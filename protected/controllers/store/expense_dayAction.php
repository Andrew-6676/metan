<?php

class expense_dayAction extends CAction   /*---- StoreController ----*/
{
   public function run()
	{

		 if(Yii::app()->request->isAjaxRequest) {
			//print_r($_POST);
			// exit;
				// сохранить расход в БД
			if(isset($_GET['action']) && $_GET['action']=='check') {
				// $res['newRowsCount'] = Document::model()->count("id in ".$_GET['idArr']."and doc_num2=0 and doc_date='".Yii::app()->session['workdate']."'");
				// $res['rowsData'] = Document::model()->findAllBySql("select array_to_string(array(select id from {{document}} "." where doc_num2=0 and doc_date='".Yii::app()->session['workdate']."'), ',')");
				// $res['rowsData'] = Document::model()->findAll(array(
				// 						'select'=>'id',
				// 						'condition' => "doc_num2=0 and doc_date='".Yii::app()->session['workdate']."'",
				// 				));

				$connection = Yii::app()->db;
				$sql = "select array_to_string(array(select id from {{document}} "." where doc_num2=0 and doc_date='".Yii::app()->session['workdate']."'), ',') as data";
				$rowsData = $connection->createCommand($sql)->queryAll();

				$dbData = explode(',', $rowsData[0]['data']);
				$userData = array();
				if (isset($_GET['idArr'])) {
					$userData = $_GET['idArr'];
				}
				// Utils::print_r($dbData);
				// Utils::print_r($userData);
				$res = array();
				// $res['newDataExist'] = false;
				$res['delRows'] = Null;
				$res['newRows'] = Null;
				foreach ($userData as $val) {
					if (!in_array ($val, $dbData)) {
						// удалённая запись
						$res['delRows'][] = $val;
					}
				}
				foreach ($dbData as $val) {
					if (!in_array ($val, $userData)) {
						// новая запись
						$res['newRows'][] = $val;
					}
				}
				$newRows = Document::model()->with('documentdata')->findAllByPk($res['newRows']);
				$arr = array();
				foreach ($newRows as $document) {
					$arr[$document->id][] = $document->id;
					$arr[$document->id][] = $document->documentdata[0]->id_goods;
					$arr[$document->id][] = $document->documentdata[0]->idGoods->name;
					$arr[$document->id][] = $document->documentdata[0]->quantity;
					$arr[$document->id][] = number_format($document->documentdata[0]->price,'0','.','`');
					$arr[$document->id][] = number_format($document->documentdata[0]->price*$document->documentdata[0]->quantity,'0','.','`');
					$arr[$document->id][] = $document->idOperation->name;
				}

				// Utils::print_r($arr);
				$res['newData'] = $arr;
				// $res['userData'] = $_GET['idArr'];
				// $res['dbData'] = $dbData;

				// if ($res['newData']) {$res['newDataExist'] = true;}

				echo json_encode($res);

				Yii::app()->end();
				// exit;
			}       // if(isset($_POST['new_expense']))

			echo 'Неправильный запроc';
			Yii::app()->end();
		 }       // // if(Yii::app()->request->isAjaxRequest)

		// $res = Document::model()->with('documentdata')->findAll(array(
		// 												//'join'=>'inner join {{operation}} on {{operation}}.id=t.id_operation',
		// 												//'condition'=>'{{operation}}.operation<0 and doc_date<=\''.Yii::app()->session['workdate'].'\' and doc_date::text like \''.substr(Yii::app()->session['workdate'],0,7).'%\' and id_store='.Yii::app()->session['id_store'],
		// 												'condition'=>'id_doctype=2 and doc_date<=\''.Yii::app()->session['workdate'].'\' and doc_date::text like \''.substr(Yii::app()->session['workdate'],0,7).'%\' and id_store='.Yii::app()->session['id_store'],
		// 												'order'=>'doc_date desc, doc_num desc')
		// 												);
		// 	// список операций
		// $oper = Operation::model()->findAll(array('condition'=>'operation<0',
		// 										  'order'=>'name'));
		// 	// следующий номер документа
		// $sql = 'SELECT max(doc_num2)::integer+1 FROM {{document}} d where id_doctype=2 and id_store='.Yii::app()->session['id_store'];
		// $doc_num = Yii::app()->db->createCommand($sql)->queryScalar();

		$criteria = new CDbCriteria;
		$criteria->join = 'inner join {{operation}} on {{operation}}.id=t.id_operation';
		$criteria->order ='doc_date desc, doc_num desc';
		$criteria->addCondition('id_doctype = 2');
		$criteria->addCondition('id_store='.Yii::app()->session['id_store']);
		$criteria->addCondition('doc_date=\''.Yii::app()->session['workdate'].'\'');
		$criteria->addCondition('doc_num2 = 0');

		$q_model = Document::model()->with('documentdata')->findAll($criteria);

			// список операций
		$oper = Operation::model()->findAll(array('condition'=>'operation<0',
												  'order'=>'name'));

		$this->controller->pageTitle = 'Расход за день';
		$this->controller->render('expense_day', array(
									'data'=>$q_model,
									'oper'=>$oper,
									// 'doc_num'=>$doc_num
								 ));
	}	// end run
	/*---------------------------------------------------------------------------------------*/
}	// end expense_dayAction