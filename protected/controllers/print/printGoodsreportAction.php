<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 17.08.15
 * Time: 11:51
 */


class printGoodsreportAction extends CAction   /*---- PrintController ----*/
{
	public function run($from_date, $to_date, $full) {
		// Utils::print_r($_GET);
//		 echo 'asdf';
//		// echo "receipt doc";
//		$rec_doc = Document::model()->findAll('doc_num = :dn and doc_date = :dd', array(':dn'=>0,'dd'=>$_GET['workdate']));
//		// $id = $rec_doc[0]->id;
//		// $rec_doc_data = Documentdata::model()->findAll('id_doc=:id_doc', array(':id_doc'=>$id));
//		$data['doc'] = $rec_doc;
//		// $data['details'] = $rec_doc_data;

		$params['from_date'] = $from_date;
		$params['to_date'] = $to_date;
		$params['full'] = $full;


//		$data = $_GET;
//		$data = array_merge($_GET, $params);
		if (isset($_GET['forma']) && $_GET['forma']=='f058') {
			$data = $this->getData2($_GET);
			$this->controller->render('goodsreport_2', array('data' => $data, 'full' => $full));
		} else {
			$data = $this->getData($_GET);
			$this->controller->render('goodsreport_1', array('data' => $data, 'full' => $full));
		}
	}


/*--------------------------------------------------------------------------------------------------------------*/

	private function getData($params) {

		$criteria = new CDbCriteria;
		$criteria->order = 'id_doctype, doc_date';

		//		$criteria->addCondition('id_goods = '.$id);
		$criteria->addCondition('id_doctype <> 3'); // не счёт-фактура
		//		$criteria->addCondition('doc_num2 <> 0'); // не расход за день
		$criteria->addCondition('id_store=' .$params['id_store']);
//		$criteria->addCondition('id_store=2');
		$criteria->addCondition('doc_date>=\'' . $params['from_date'] . '\'');
		$criteria->addCondition('doc_date<=\'' . $params['to_date'] . '\'');
		//		$criteria->addCondition('doc_date::text like \''.substr(Yii::app()->session['workdate'],0,7).'%\'');
		//		$criteria->addCondition('doc_num2 != 0');
		$criteria->order = 'operation.operation desc, id_doctype, operation.id desc, doc_date, doc_num';
		$res = Document::model()->with('documentdata', 'documentdata.idGoods', 'doctype', 'operation')->findAll($criteria);

		//		echo $res[0]->doctype->name;
		//		echo $res[0]->operation->name;
		//		Utils::print_r($res[0]->documentdata[0]->idGoods->name);
		//		Utils::print_r($res[0]);
		$json = array();
//		$json['expence']['return'] = array();
		$json['expence']['day']['sum'] = 0;
		$json['expence']['day']['data'] = array();
		$json['expence']['karta']['sum'] = 0;
		$json['expence']['kredit']['sum'] = 0;
		$json['expence']['including'][-1] = 0;
		$json['expence']['including'][1] = 0;
		$json['expence']['including'][2] = 0;
		$json['expence']['including'][3] = 0;
		$se = 0;
		$d='';

			// формируем массив документов
		foreach ($res as $row_d) {
				// если вдруг документ пустой
			if (count($row_d->documentdata)) {
					// считаем сумму по всем у расходу, разбивая по полю for
				if ($row_d->operation->operation < 0) {
					$json['expence']['including'][$row_d->for] += $row_d->documentdata[0]->quantity * $row_d->documentdata[0]->price;
				}
					// "расход за день" отдельно счиатем
				if (trim($row_d->doc_num) == '0') {
						//
					if ($d == '') {$d = $row_d->doc_date;}
					if ($d != $row_d->doc_date) {
						$d = $row_d->doc_date;
						$se = 0;
					}

					switch ($row_d->id_operation) {
						case 56: // карточка
							$json['expence']['karta']['data'][] = array(
								'date' => $row_d->doc_date,
								'kart_num' => $row_d->docaddition ? $row_d->docaddition->payment_order : 0,
								'sum' => $row_d->documentdata[0]->quantity * $row_d->documentdata[0]->price,
							);
							$json['expence']['karta']['sum'] += $row_d->documentdata[0]->quantity * $row_d->documentdata[0]->price;
							break;
						case 54: // кредит
							$json['expence']['kredit']['data'][] = array(
								'date' => $row_d->doc_date,
								'contact' => ($row_d->docaddition ? $row_d->docaddition->payment_order : 0).$row_d->contact->name,
								'sum' => $row_d->documentdata[0]->quantity * $row_d->documentdata[0]->price,
							);
							$json['expence']['kredit']['sum'] += $row_d->documentdata[0]->quantity * $row_d->documentdata[0]->price;
							break;
						default:
							//$json['expence']['day']['data'][] = array(
							//'date' => $row_d->doc_date,
							//'sum' => $row_d->documentdata[0]->quantity * $row_d->documentdata[0]->price,
							//);
							//$json['expence']['day']['sum'] += $row_d->documentdata[0]->quantity * $row_d->documentdata[0]->price;
							$se += $row_d->documentdata[0]->quantity * $row_d->documentdata[0]->price;
								// чтобы не затереть уже добавленный возврат - сливаем массивы
							if (isset($json['expence']['day']['data'][$row_d->doc_date])) {
								$json['expence']['day']['data'][$row_d->doc_date] = array_merge($json['expence']['day']['data'][$row_d->doc_date], array(
									'date' => $row_d->doc_date,
									'sum' => $se,
									'kassa' => Kassa::getRest($row_d->doc_date, $_GET['id_store']),
								));
							} else {
								$json['expence']['day']['data'][$row_d->doc_date] = array(
									'date' => $row_d->doc_date,
									'sum' => $se,
									'kassa' => Kassa::getRest($row_d->doc_date,  $_GET['id_store']),
								);
							}
							$json['expence']['day']['sum'] += $row_d->documentdata[0]->quantity * $row_d->documentdata[0]->price;
							break;
					}   // end switch
				} else {    // если не "расход за день"
						// если возврат
					if ($row_d->id_operation == 2) {

//						if (!isset($json['expence']['day']['data'])) {
//							$json['expence']['day']['data'][$row_d->doc_date]['sum'] = 0;
//							$json['expence']['return'][$row_d->doc_date] = ($json['expence']['day']['data'][$row_d->doc_date]);
//							if (!isset)
//							echo 'asdsa--';
							$json['expence']['day']['data'][$row_d->doc_date] = array(
								'return' => $row_d->sum_price + @$json['expence']['day']['data'][$row_d->doc_date]['return'],
								'date' => $row_d->doc_date,
								'sum' => 0,
								'kassa' => Kassa::getRest($row_d->doc_date,  $_GET['id_store']),
							);
//						} else {

//						}
					}   // end если возврат
					if ($row_d->id_operation == 54): // кредит
						$json['expence']['kredit']['data'][] = array(
							'date' => $row_d->doc_date,
							'contact' => $row_d->contact->name,
							'sum' => $row_d->documentdata[0]->quantity * $row_d->documentdata[0]->price,
						);
						$json['expence']['kredit']['sum'] += $row_d->documentdata[0]->quantity * $row_d->documentdata[0]->price;
						//break;
					else:

							// шапка документа
						$json[$row_d->doctype->name][$row_d->operation->name][]['head'] = array(
							'date' => $row_d->doc_date,
							'num' => $row_d->doc_num,
							'contact' => $row_d->contact->name,
							'sum_cost' => $row_d->sum_cost,
							'sum_vat' => $row_d->sum_vat,
							'sum_price' => $row_d->sum_price,
						);
						$c = count($json[$row_d->doctype->name][$row_d->operation->name]) - 1;
						$s = 0;

							// строки документа
						foreach ($row_d->documentdata as $row_dd) {
							$json[$row_d->doctype->name][$row_d->operation->name][$c]['data'][] = array(
								'quantity' => $row_dd->quantity,
								'cost' => $row_dd->cost,
								'price' => $row_dd->price
							);
							$s += $row_dd->quantity * $row_dd->price;
						}
					endif;
				}   // если не расход за день
			}
		}

		return $json;
	}

	/*---------------------------------------------------------------------------------------*/
	private function getData2($params) {

//

		$json = array();

//		$json['expence']['day']['sum'] = 0;
//		$json['expence']['day']['data'] = array();
//		$json['expence']['karta']['sum'] = 0;
//		$json['expence']['kredit']['sum'] = 0;
//		$json['expence']['including'][-1] = 0;
//		$json['expence']['including'][1] = 0;
//		$json['expence']['including'][2] = 0;
//		$json['expence']['including'][3] = 0;
//
//		$json['receipt'] = array();

		$op = Operation::model()->findAll(
			array(
				'condition' => 'operation<>0',
				'order'=>'operation desc, id'
			)
		);
		$op = CHtml::listData($op,
			'id', 'name', 'operation');
		$op[1] = array_reverse($op[1], true);
			// в таком порядке операций будут выводится документы
		$json['operations'] = $op;


		$criteria = new CDbCriteria;
		// Документы с номером 0 - отдельно (это расход за день)

// Остатки -----------------------------------------------------------------------------------------------------
		$json['rest']['tovar'] = Rest::get_Rest($_GET['from_date'], $_GET['id_store']);
		$json['rest']['kassa'] = Kassa::getRest($_GET['from_date'], $_GET['id_store'], -1);


// ПРИХОД ------------------------------------------------------------------------------------------------------

		foreach ($op[1] as $id_op => $name_op) {
			$criteria->condition = '';

			$criteria->addCondition('id_operation = '.$id_op);
			$criteria->addCondition('id_store=' .$params['id_store']);
			$criteria->addCondition('doc_date>=\'' . $params['from_date'] . '\'');
			$criteria->addCondition('doc_date<=\'' . $params['to_date'] . '\'');
			$criteria->order = 'operation.operation desc, id_doctype, operation.id desc, doc_date, doc_num';

			//Utils::print_r($criteria->condition);

			$data = Document::model()->with('documentdata', 'documentdata.idGoods', 'doctype', 'operation')->findAll($criteria);
//			Utils::print_r($data);
			foreach ($data as $row) {
				//echo $row->doc_date;
				$json[1][$id_op][] = $row;
			}
		}


// РАСХОД ------------------------------------------------------------------------------------------------------

		foreach ($op[-1] as $id_op => $name_op) {
			$criteria->condition = '';

			$criteria->addCondition('id_operation = '.$id_op);
			$criteria->addCondition('doc_num2 <> 0 or id_operation=54');
			$criteria->addCondition('id_store=' .$params['id_store']);
			$criteria->addCondition('doc_date>=\'' . $params['from_date'] . '\'');
			$criteria->addCondition('doc_date<=\'' . $params['to_date'] . '\'');
			$criteria->order = 'operation.operation desc, id_doctype, operation.id desc, doc_date, doc_num';

			//Utils::print_r($criteria->condition);

			$data = Document::model()->with('documentdata', 'documentdata.idGoods', 'doctype', 'operation')->findAll($criteria);
//			Utils::print_r($data);
			foreach ($data as $row) {
				//echo $row->doc_date;
				$json[-1][$id_op][] = $row;
			}
		}

		return $json;
	}
}