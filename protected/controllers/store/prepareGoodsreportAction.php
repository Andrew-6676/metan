<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 20.07.15
 * Time: 8:05
 */

class prepareGoodsreportAction extends CAction   /*---- storeController ----*/
{
	public function run()
	{

		if (Yii::app()->request->isAjaxRequest) {

			if (isset($_POST['getReport'])) {
				$this->getGoodsReport($_POST['getReport']);
				exit;
			}        // if(isset($_POST['getReport']))

			echo 'Неправильный запроc';
			exit;
		}        // if(Yii::app()->request->isAjaxRequest)

		$this->controller->render('prepareGoodsreport', array(
			'data' => '$data',
		));
	}


	public function getGoodsReport($params) {

		//http://localhost/metan_0.1/MainAjax/tovRep?from=2015-07-01&to=2015-07-22

		//		function exceptions_error_handler($severity, $message, $filename, $lineno) {
		//			if (error_reporting() == 0) {
		//				return;
		//			}
		//			if (error_reporting() & $severity) {
		//				throw new ErrorException($message, 0, $severity, $filename, $lineno);
		//			}
		//		}
		//		set_error_handler('exceptions_error_handler');

		//		echo 'tov_rep<br>';

//		$criteria = new CDbCriteria;
//		$criteria->order = 'id_doctype, doc_date';
//
//
//		//		$criteria->addCondition('id_goods = '.$id);
//		$criteria->addCondition('id_doctype <> 3'); // не счёт-фактура
//		//		$criteria->addCondition('doc_num2 <> 0'); // не расход за день
//		$criteria->addCondition('id_store=' . Yii::app()->session['id_store']);
//		$criteria->addCondition('doc_date>=\'' . $params['from_date'] . '\'');
//		$criteria->addCondition('doc_date<=\'' . $params['to_date'] . '\'');
//		//		$criteria->addCondition('doc_date::text like \''.substr(Yii::app()->session['workdate'],0,7).'%\'');
//		//		$criteria->addCondition('doc_num2 != 0');
//		$criteria->order = 'operation.operation desc, operation.id desc, id_doctype, doc_date, doc_num';
//		$res = Document::model()->with('documentdata', 'documentdata.idGoods', 'doctype', 'operation')->findAll($criteria);
//
//		//		echo $res[0]->doctype->name;
//		//		echo $res[0]->operation->name;
//		//		Utils::print_r($res[0]->documentdata[0]->idGoods->name);
//		//		Utils::print_r($res[0]);
//		$json = array();
////		$json['expence']['day']['sum'] = 0;
////		$json['expence']['karta']['sum'] = 0;
////		$json['expence']['kredit']['sum'] = 0;
//		foreach ($res as $row_d) {
//			// если вдруг документ пустой
//			if (count($row_d->documentdata)) {
//				// расход за день отдельно
//				if ($row_d->doc_num == 0) {
//					if ($row_d->id_operation == 56) {
//						$json['expence']['karta']['data'][] = array(
//							'date' => $row_d->doc_date,
//							'kart_num' => $row_d->docaddition ? $row_d->docaddition->payment_order : 0,
//							'sum' => $row_d->documentdata[0]->quantity * $row_d->documentdata[0]->price,
//						);
//						$json['expence']['karta']['sum'] += $row_d->documentdata[0]->quantity * $row_d->documentdata[0]->price;
//					} elseif ($row_d->id_operation == 54) { // кредит
//						$json['expence']['kredit']['data'][] = array(
//							'date' => $row_d->doc_date,
//							//'contact'=>$row_d->contact->name,
//							'sum' => $row_d->documentdata[0]->quantity * $row_d->documentdata[0]->price,
//						);
//						$json['expence']['day']['sum'] += $row_d->documentdata[0]->quantity * $row_d->documentdata[0]->price;
//					} else {
//						$json['expence']['day']['data'][] = array(
//							'date' => $row_d->doc_date,
//							'sum' => $row_d->documentdata[0]->quantity * $row_d->documentdata[0]->price,
//						);
//						$json['expence']['day']['sum'] += $row_d->documentdata[0]->quantity * $row_d->documentdata[0]->price;
//					}
//				} else {
//					// шапка документа
//					$json[$row_d->doctype->name][$row_d->operation->name][]['head'] = array(
//						'date' => $row_d->doc_date,
//						'num' => $row_d->doc_num,
//						'contact' => $row_d->contact->name,
//						'sum_cost' => $row_d->sum_cost,
//						'sum_vat' => $row_d->sum_vat,
//						'sum_price' => $row_d->sum_price,
//					);
//					$c = count($json[$row_d->doctype->name][$row_d->operation->name]) - 1;
//					$s = 0;
//					// строки документа
//					foreach ($row_d->documentdata as $row_dd) {
//						$json[$row_d->doctype->name][$row_d->operation->name][$c]['data'][] = array(
//							'quantity' => $row_dd->quantity,
//							'cost' => $row_dd->cost,
//							'price' => $row_dd->price
//						);
//						$s += $row_dd->quantity * $row_dd->price;
//					}
//					// добавляем сумму в шапку
//					//					$json[$row_d->doctype->name][$row_d->operation->name][$c]['sum'] = $s;
//				}
//			}
//		}
//
//		//		echo "end\n";
////		Utils::print_r($json);
//
//		$res = array(
//			'status' => 'ok',
//			'message' => '',
//			'report_data' => $json,
//		);
//
//		echo json_encode($res);
	}



}