<?php

class MainAjaxController extends CController
{
/* ---------------------------------------------------------------------- */
	public function Actiontest() {
//		echo $_POST['var'];
//		$g = Goods::model()->findAll('id>42569999');
//		Utils::print_r($g[0]->cost);
////		Utils::print_r($g);
//		foreach ($g as$gg ) {
//			echo '<br>'.$gg->id.' --- '.$gg->cost;
//		}

//		$this->widget('CAutoComplete',
//			array(
//				'model'=>'Inputcache',
//				'name'=>'str',
//				'url'=>array('MainAjax/autocomplete'),
//				'minChars'=>2,
//			)
//		);
//
//		$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
//			'name'=>'test1',
//			'value'=>'test21',
//			'source'=>$this->createUrl('MainAjax/autocomplete'),
//			// additional javascript options for the autocomplete plugin
//		//	'options'=>array(
//		//		'showAnim'=>'fold',
//		//	),
//		));


		$this->widget('zii.widgets.jui.CJuiAutoComplete',array(
		    'name'=>'normal',
		    'source'=>array('ac1','ac2','ac3'),
		    // additional javascript options for the autocomplete plugin
		    'options'=>array(
		        'minLength'=>'2',
		    ),
		    'htmlOptions'=>array(
		        'style'=>'height:20px;',
		    ),
		));


//		$model = Inputcache::model();
//		$autocompleteConfig = array(
//			'model'=>$model, // модель
//			'attribute'=>'str', // атрибут модели
//			// "источник" данных для выборки
//			// может быть url, который возвращает JSON, массив
//			// или функция JS('js: alert("Hello!");')
//			'source' =>Yii::app()->createUrl('MainAjax/autocomplete'),
//			// параметры, подробнее можно посмотреть на сайте
//			// http://jqueryui.com/demos/autocomplete/
//			'options'=>array(
//				// минимальное кол-во символов, после которого начнется поиск
//				'minLength'=>'2',
//				'showAnim'=>'fold',
//				// обработчик события, выбор пункта из списка
//				'select' =>'js: function(event, ui) {
//					            // действие по умолчанию, значение текстового поля
//					            // устанавливается в значение выбранного пункта
//					            this.value = ui.item.label;
//					            // устанавливаем значения скрытого поля
//					            $("#Order_customer_id").val(ui.item.id);
//					            return false;
//					        }',
//			),
//			'htmlOptions' => array(
//				'maxlength'=>50,
//			),
//		);
//
//
//		$this->widget('zii.widgets.jui.CJuiAutoComplete', $autocompleteConfig);
	}
/* ---------------------------------------------------------------------- */
	public function ActionupdateRest() {
		Utils::print_r($_POST['data']) ;
		$data = $_POST['data'];
		// в таблице $tname у записи с $id  меняем поле $fname на $val
		// обновим строки, отвечающие заданному условию
		//Post::model()->updateAll($attributes,$condition,$params);
		// обновим строки, удовлетворяющие заданному условию и значению первичного ключа (или нескольким значениям ключей)
		//Post::model()->updateByPk($pk,$attributes,$condition,$params);
		// обновим поля-счётчики в строках, удовлетворяющих заданным условиям
		//Post::model()->updateCounters($counters,$condition,$params);
		// Utils::print_r($data) ;
		// Rest::model()->updateByPk($id, array($fname=>$val));

		Rest::model()->updateByPk($data['id'], $data['f_vals']);
		// $rest = Rest::model()->findByPk($data['id']);
		// Utils::print_r($rest) ;
	}
	/* ---------------------------------------------------------------------- */
	public function ActiondelRest() {
		$id = $_POST['id'];
		Rest::model()->deleteByPk($id);
	}
/* ---------------------------------------------------------------------- */
	public function ActionsetWorkDate($date)
	{
		// $connection=Yii::app()->db;
		if(Yii::app()->request->isAjaxRequest) {
			//echo $_POST['sql'];
			// return $connection->createCommand($_POST['sql'])->execute();
			// exit;
			// переприсвоить переменную Yii::app()->session['workdate']
			Yii::app()->session['workdate'] = $date;
			echo Yii::app()->session['workdate'];
		} else {
			echo 'error - no data';
		}
	}
/* ---------------------------------------------------------------------- */
	public function ActionsetStoreId($id)
	{
		// $connection=Yii::app()->db;
		if (Yii::app()->request->isAjaxRequest) {
			//echo $_POST['sql'];
			// return $connection->createCommand($_POST['sql'])->execute();
			// exit;
			// переприсвоить переменную Yii::app()->session['workdate']
			if (Yii::app()->session['can_select_store']) {
				Yii::app()->session['id_store'] = $id;
				echo Yii::app()->session['id_store'];
			}
		} else {
			echo 'error - no data';
		}
	}
/*------------------------------------------------------------------------*/
	public function ActionGetGoodsName($term,$f) {
			// выбор товаров для дропбокса в расходе (выбрать по хорошему надо из остатков + из прихода)
		// if(Yii::app()->request->isAjaxRequest) {
				// запрос на выборку наименований из БД по шаблону
			//$sql = "SELECT string_agg(concat('name: ',name), ',' ) FROM vgm_goods WHERE upper(name) like upper('".$term."%')";
			$sql = "SELECT id, name FROM vgm_goods WHERE upper(".$f."::text) like upper('".$term."%')";
			//echo $sql;
			$connection = Yii::app()->db;
			$elements = $connection->createCommand($sql)->queryAll();
			// echo '<pre>';
			// print_r($elements);
			// echo '</pre>';
			//$s = "[".$elements."]";
			$s = json_encode($elements);
			echo $s;

		// } else {
		// 	echo 'error - no data';
		// }
	}

/*------------------------------------------------------------------------*/
	public function ActionGetGoodsNameFromRest($term, $f) {

		$rest = Rest::getRestList($f, $term, Yii::app()->session['workdate'], Yii::app()->session['id_store'], 'json');
		echo $rest;
	}
/*------------------------------------------------------------------------*/
	public function ActionGetGoodsNameFromAll($term, $f) {

//		$rest = Rest::getRestList($f, $term, Yii::app()->session['workdate'], Yii::app()->session['id_store'], 'json');
		$connection = Yii::app()->db;
		$sql_goods = "select id, ".$f."
					  from {{goods}}
					  where upper(".$f."::text) like upper('".$term."%')";
		$res = $connection->createCommand($sql_goods)->queryAll();

//		Utils::print_r($res);
		echo json_encode($res);
	}
/*--------------------------------------------------------------------------------------------------------------------*/
	public function ActionGetContactName($term, $f) {
		$connection = Yii::app()->db;

		$sql = "select id, trim(name) as name, trim(fname) as fname, trim(unn) as unn
				from {{contact}}
				where upper(".$f."::text) like upper('".$term."%') and parent=2
				order by 2";
		// echo '<pre>'.$sql_rest.'</pre>';
		$res = $connection->createCommand($sql)->queryAll();

		$res = json_encode($res);
		echo $res;
	}
/*--------------------------------------------------------*/
	public function ActionGetContact($id) {
		$res = Contact::model()->findByPK($id);
		echo json_encode($res->attributes);
	}

	public function ActionReplace_code () {
		echo 'replace code<pre>';

		$goods = Goods::model()->findAll();
		foreach ($goods as $row) {
//			$reg = '/(\d{2})(\d{2})(\d{2})(\d{3})/';
//			preg_match($reg, $row->id_3torg, $arr);
//			array_shift($arr);
////			print_r($arr);
//			echo $row->id.'---';
//			echo implode('.',$arr)."\n";
//			$row->id_3torg = implode('.',$arr);
			//$row->save();
//			if (strpos($row->id_3torg,'.000')>0) {
//				echo $row->id_3torg.'-----'.substr($row->id_3torg,0,-4)."\n";
//				$row->id_3torg = substr($row->id_3torg,0,-4);
//				$row->save();
//			} else {
//				echo $row->id_3torg."\n";
//			}


//			echo $row->id_3torg."\n";


		}

	}

	/*------------------------------------------------------------------------------*/

	public function ActionDelDocdata() {
		$res = array('status'=>'ok', 'message'=>'Удалено.');
		$res['ids'] = $_POST['data'];

		foreach ($_POST['data'] as $doc_id) {
			if(Documentdata::model()->deleteByPK($doc_id)==0){
				$res['status'] = 'error';
				$res['message'] = 'Не получилось удалить';
			}
		}

		echo json_encode($res);
	}

	/*------------------------------------------------------------------------------*/
	public function ActionGoodsCart($id=0) {
		echo 'goods cart<br>';

		$criteria = new CDbCriteria;
		$criteria->order = 'id_doctype, doc_date';


		$criteria->addCondition('id_goods = '.$id);
		$criteria->addCondition('id_doctype <> 3');
		$criteria->addCondition('id_store='.Yii::app()->session['id_store']);
//		$criteria->addCondition('doc_date<=\''.Yii::app()->session['workdate'].'\'');
		$criteria->addCondition('doc_date::text like \''.substr(Yii::app()->session['workdate'],0,7).'%\'');
//		$criteria->addCondition('doc_num2 != 0');

		$res = Document::model()->with('documentdata', 'documentdata.idGoods','doctype', 'operation')->findAll($criteria);

//		echo $res[0]->doctype->name;
//		echo $res[0]->operation->name;
//		Utils::print_r($res[0]->documentdata[0]->idGoods->name);

		foreach ($res as $row) {
			echo $row->doctype->name.'  _______  '.$row->doc_date.'_______'.$row->doc_num.'_______'.$row->documentdata[0]->quantity.'_______'.$row->documentdata[0]->cost.'_______'.$row->documentdata[0]->price."<br>";
		}
	}
	/*------------------------------------------------------------------------------*/
//	public function ActionTovRep($from,$to) {
//
//		//http://localhost/metan_0.1/MainAjax/tovRep?from=2015-07-01&to=2015-07-22
//
////		function exceptions_error_handler($severity, $message, $filename, $lineno) {
////			if (error_reporting() == 0) {
////				return;
////			}
////			if (error_reporting() & $severity) {
////				throw new ErrorException($message, 0, $severity, $filename, $lineno);
////			}
////		}
////		set_error_handler('exceptions_error_handler');
//
////		echo 'tov_rep<br>';
//
//		$criteria = new CDbCriteria;
//		$criteria->order = 'id_doctype, doc_date';
//
//
////		$criteria->addCondition('id_goods = '.$id);
//		$criteria->addCondition('id_doctype <> 3'); // не счёт-фактура
////		$criteria->addCondition('doc_num2 <> 0'); // не расход за день
//		$criteria->addCondition('id_store='.Yii::app()->session['id_store']);
//		$criteria->addCondition('doc_date>=\''.$from.'\'');
//		$criteria->addCondition('doc_date<=\''.$to.'\'');
////		$criteria->addCondition('doc_date::text like \''.substr(Yii::app()->session['workdate'],0,7).'%\'');
////		$criteria->addCondition('doc_num2 != 0');
//		$criteria->order = 'operation.operation desc, operation.id desc, id_doctype, doc_date, doc_num';
//		$res = Document::model()->with('documentdata', 'documentdata.idGoods','doctype', 'operation')->findAll($criteria);
//
////		echo $res[0]->doctype->name;
////		echo $res[0]->operation->name;
////		Utils::print_r($res[0]->documentdata[0]->idGoods->name);
////		Utils::print_r($res[0]);
//		$json = array();
//		$json['expence']['day']['sum'] = 0;
//		$json['expence']['karta']['sum'] = 0;
//		foreach ($res as $row_d) {
//				// если вдруг документ пустой
//			if (count($row_d->documentdata)) {
//					// расход за день отдельно
//				if ($row_d->doc_num==0) {
//					if ($row_d->id_operation==56) {
//						$json['expence']['karta']['data'][] = array(
//							'date'=>$row_d->doc_date,
//							'kart_num'=>$row_d->docaddition?$row_d->docaddition->payment_order:0,
//							'sum'=>$row_d->documentdata[0]->quantity*$row_d->documentdata[0]->price,
//						);
//						$json['expence']['karta']['sum'] += $row_d->documentdata[0]->quantity*$row_d->documentdata[0]->price;
//					} else {
//						$json['expence']['day']['data'][] = array(
//							'date'=>$row_d->doc_date,
//							'sum'=>$row_d->documentdata[0]->quantity*$row_d->documentdata[0]->price,
//						);
//						$json['expence']['day']['sum'] += $row_d->documentdata[0]->quantity*$row_d->documentdata[0]->price;
//					}
//				} else {
//					// шапка документа
//					$json[$row_d->doctype->name][$row_d->operation->name][]['head'] = array(
//						'date'=>$row_d->doc_date,
//						'num'=>$row_d->doc_num,
//						'contact'=>$row_d->contact->name,
//						'sum_cost'=>$row_d->sum_cost,
//						'sum_vat'=>$row_d->sum_vat,
//						'sum_price'=>$row_d->sum_price,
//					);
//					$c = count($json[$row_d->doctype->name][$row_d->operation->name]) - 1;
//					$s = 0;
//					// строки документа
//					foreach ($row_d->documentdata as $row_dd) {
//						$json[$row_d->doctype->name][$row_d->operation->name][$c]['data'][] = array(
//							'quantity'=>$row_dd->quantity,
//							'cost'=>$row_dd->cost,
//							'price'=>$row_dd->price
//						);
//						$s += $row_dd->quantity * $row_dd->price;
//					}
//					// добавляем сумму в шапку
////					$json[$row_d->doctype->name][$row_d->operation->name][$c]['sum'] = $s;
//				}
//			}
////			if (count($row->documentdata)) {
////				echo $row->doctype->name . '  _______  ' . $row->doc_date . '_______' . $row->doc_num . '_______' . $row->documentdata[0]->quantity . '_______' . $row->documentdata[0]->cost . '_______' . $row->documentdata[0]->price . "<br>";
////				$json[$row->doctype->name]['head'] = array(
////					$row->doc_date, $row->doc_num,
////				);
////
////			} else {
////				$json['err'] = 'no data';
////			}
////			try {
////				echo $row->doctype->name . '  _______  ' . $row->doc_date . '_______' . $row->doc_num . '_______' . $row->documentdata[0]->quantity . '_______' . $row->documentdata[0]->cost . '_______' . $row->documentdata[0]->price . "<br>";
////			} catch (Exception $e) {
//////				echo 'Выброшено исключение: ',  $e->getMessage(), "\n";
////			}
//		}
//
////		echo "end\n";
//		Utils::print_r($json);
//	}
	/*------------------------------------------------------------------------------*/
	public function ActionAutocomplete() {
		$term = Yii::app()->getRequest()->getParam('term');
		$input = Yii::app()->getRequest()->getParam('input');

//		if(Yii::app()->request->isAjaxRequest && $term) {
			$criteria = new CDbCriteria;
			// формируем критерий поиска
//			$criteria->addSearchCondition('str', $term);
			if ($input) {
				$criteria->addCondition('input = \''.$input.'\'');
			}
			$criteria->addCondition('upper(str) like upper(\''.$term.'%\')');
            $inp = Inputcache::model()->findAll($criteria);
            // обрабатываем результат
            $result = array();
            foreach($inp as $i) {
	            $lable = $i['str'];
	            $result[] = array('id'=>$i['id'], 'label'=>$lable, 'value'=>$lable);
            }
            echo CJSON::encode($result);
            Yii::app()->end();
        }
//	}
	/*------------------------------------------------------------------------------*/
	/*------------------------------------------------------------------------------*/
	/*------------------------------------------------------------------------------*/
}