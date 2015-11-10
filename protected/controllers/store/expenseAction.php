<?php

class expenseAction extends CAction   /*---- StoreController ----*/
{
   public function run()
	{
		if(Yii::app()->request->isAjaxRequest)
		{
			// print_r($_POST);
			// exit;
				// сохранить расход в БД
			if(isset($_POST['new_expense'])) {
//				$goods = array();
//					// цикл по товарам
//				foreach ($_POST['new_expense']['doc_data'] as $id => $row) {
//					$goods[$id] = $row['quantity'];
//				}
//
//				$chk = Rest::model()->checkRest($goods);
//				if ($chk['status']=='ok') {
					$this->addExpense($_POST['new_expense']);
//				} else {
//					echo json_encode($chk);
//				}
				exit;
        	}		// if(isset($_POST['new_expense']))

        		// удалить расход
//			if(isset($_POST['del_expense'])) {
//				$this->delExpense($_POST['del_expense']);
//				exit;
//        	}		// if(isset($_POST['del_expense']))

        	echo 'Неправильный запроc';
        	exit;
		}		// // if(Yii::app()->request->isAjaxRequest)

		/*--------------------------------------------------------------*/
			// данные для вывода
		// $res = Document::model()->with('documentdata')->findAll(array(
		// 												//'join'=>'inner join {{operation}} on {{operation}}.id=t.id_operation',
		// 												//'condition'=>'{{operation}}.operation<0 and doc_date<=\''.Yii::app()->session['workdate'].'\' and doc_date::text like \''.substr(Yii::app()->session['workdate'],0,7).'%\' and id_store='.Yii::app()->session['id_store'],
		// 												'condition'=>'id_doctype=2 and doc_date<=\''.Yii::app()->session['workdate'].'\' and doc_date::text like \''.substr(Yii::app()->session['workdate'],0,7).'%\' and id_store='.Yii::app()->session['id_store'],
		// 												'order'=>'doc_date desc, doc_num desc')
		// 												);

		$criteria = new CDbCriteria;
		// $criteria->join = 'inner join {{operation}} on {{operation}}.id=t.id_operation';
		$criteria->order ='doc_date desc, doc_num desc';
		$criteria->addCondition('id_doctype = 2');
		$criteria->addCondition('id_store='.Yii::app()->session['id_store']);
		$criteria->addCondition('doc_date<=\''.Yii::app()->session['workdate'].'\'');
		$criteria->addCondition('doc_date::text like \''.substr(Yii::app()->session['workdate'],0,7).'%\'');
		$criteria->addCondition('doc_num2 != 0');

		$res = Document::model()->with('documentdata')->findAll($criteria);

		//doc_num2>0 and
			// список операций
		$oper = Operation::model()->findAll(array('condition'=>'operation<0',
												  'order'=>'name'));
			// следующий номер документа
		$sql = 'SELECT max(doc_num2)::integer+1 FROM {{document}} d where id_doctype=2 and id_store='.Yii::app()->session['id_store'].' and doc_date::text like \''.substr(Yii::app()->session['workdate'],0,4).'%\'';
		$doc_num = Yii::app()->db->createCommand($sql)->queryScalar();
		if (!$doc_num) {$doc_num = 1;}

		$this->controller->pageTitle = 'Накладные,<br>кредиты';
		$this->controller->render('expense', array(
									'data'=>$res,
									'oper'=>$oper,
									'doc_num'=>$doc_num
								 ));
	}	// end run

/*-----------------------------------------------------------------------------------*/
/*---------------------- Добавление нового расхода в БД -----------------------------*/
	private function addExpense($data) {
		$res = array();
		$new_doc = false;

		$goods = array();
			// цикл по товарам
		foreach ($data['doc_data'] as $id => $row) {
			$goods[$id] = $row['quantity'];
		}

		$chk = Rest::model()->checkRest($goods);
		if ($chk['status']!='ok') {
//			echo json_encode($chk);
//			exit;
			$res['no_rest'] = $chk;
		}


			// тут надо проверить $data['doc']['doc_id']
			// если меньше 0 - новый документ, иначе - редактирование существующего
//		$document = new Document();
//		$new_doc = false;
//		if ($data['doc']['doc_id']<0) {
//			$new_doc = true;
//		} else {
//			// echo 'Редактирование документа id='.$data['doc']['doc_id'];
//			// exit;
//		}

		if ($data['doc']['doc_id']>0) {
			$document = Document::model()->findByPK($data['doc']['doc_id']);
			if (!$document) {
				$new_doc = true;
				$document = new Document();
			}
		} else {
			$new_doc = true;
			// echo 'Редактирование документа id='.$data['doc']['doc_id'];
			$document = new Document();
			//exit;
			// наверно надо добавит документ как новый и в случае успеха удалить старый документ.
		}


//		echo json_encode($data);
//		exit;
			// начинаем транзакцию
		$transaction=$document->dbConnection->beginTransaction();
		// Yii::app()->db->emulatePrepare = false;
		try {
			$doc = $data['doc'];
			// атрибуты родительской таблицы
//			$document->date_insert = date('Y-m-d');
			$document->date_edit    = date('Y-m-d H:i:00');
//            $document->id_editor    = 8;

			$document->doc_num      = $doc['doc_num'];
			$document->doc_num2     = intval($doc['doc_num']);
			$document->doc_date     = $doc['doc_date'];
			$document->id_contact   = $doc['id_contact'];
			$document->id_storage   = 2;
			$document->reason       = '';
			$document->id_operation = $doc['id_operation'];
			$document->id_doctype   = 2;

			if (isset($doc['doc_for']) && $doc['doc_for']) {
				$document->for = $doc['doc_for'];
			}
			if (isset($doc['payment_order'])) {
				$document->payment_order = $doc['payment_order'];
			}


	    	//print_r($document);
			if($document->save()) {
					// если удачное сохранение - получаем ID новой записи
				// echo "<pre>";
				//echo 'new ID='.$document->id."\n";
				$res['new_id'] = $document->id;


				if (!$new_doc) {
					// удалить старый док
					Documentdata::model()->deleteAll('id_doc='.$data['doc']['doc_id']);
				}
				// 	// и добавляем данные в дочернюю таблицу


				$doc_data = $data['doc_data'];
				$res['goods'] = array();
					// цикл по товарам
				foreach ($doc_data as $id => $row) {
					$documentdata = new Documentdata();
					// echo "$id - $quantity;   \n";

				   		// атрибуты дочерней таблицы
	                $documentdata->id_doc       = $document->id;
	                $documentdata->id_goods     = $id;
//	                $documentdata->cost         = 0;
//	                $documentdata->markup       = 0;
//	                $documentdata->vat          = 0;
					if (isset($row['cost'])) {
						$documentdata->cost         = $row['cost'];
					} else {
						$documentdata->cost         = 0;
					}
					if (isset($row['markup'])) {
						$documentdata->markup   = $row['markup'];
					} else {
						$documentdata->markup   = 0;
					}
					$documentdata->vat          = $row['vat'];
	                $documentdata->quantity     = $row['quantity'];
	                $documentdata->packages     = 0;
	                $documentdata->gross        = 0;
	                $documentdata->price        = $row['price'];
					if (isset($doc['partof'])) {
						if (trim($doc['partof'])=='') {
							$doc['partof'] = -1;
						}
						$documentdata->partof   = $doc['partof'];
					}

	                	// если запись сохранилась, получаем новые ID
					if($documentdata->save()) {
							// массив вида [код товара]=><id записи>
						$res['goods'][$id] = $documentdata->id;
					} else {

					}

	        	}
//	        	if (!$new_doc) {
//	        		// удалить старый док
//	        		// $death_doc = Document::model()->findByPK($data['doc']['doc_id']);
//	        		Document::model()->deleteByPK($data['doc']['doc_id']);
//	        	}

			} else {
				// если данные не сохранены
				$res['message'] = $document->getErrors();
				$transaction->rollback();
				echo json_encode($res);
				return;
			}		// end if($model->save())


			// $model->attributes = $_POST['expense'];
	   		//$model->attributes=$_POST['User'];
	        // $model->name = $_POST['User']['name'];
	        // $model->first_name = $_POST['User']['first_name'];
	        // $model->description = $_POST['User']['description'];

	  //       echo "----\n";
	  //       print_r($res);
	  //       echo "----\n";
			// print_r($data);
			$res['status'] = 'ok';
			$res['message'] = 'Документ сохранён';
			echo json_encode($res);
			// echo "</pre>";
			//exit;
			$transaction->commit();
		}
		catch (Exception $e)
		{
			$transaction->rollback();
			$res['status'] = 'error';
			$res['message'] = $e;
			echo json_encode($res);
		}
		// Yii::app()->db->emulatePrepare = true;
	}	// end addExpense

/*----------------------- Удалить расход --------------------------------------------------*/
//	private function delExpense($id) {
////		$sql = 'delete from vgm_document where id='.$id;
//	 	try {
//		 	// $r = Yii::app()->db->createCommand($sql)->exeute();
//			Document::model()->deleteByPk($id);
//			$res = array('status'=>'ok', 'id'=>$id);
//		}catch(Exception $e) {
//			$res = array('status'=>'error', 'id'=>$id);
//		}
//
//		echo json_encode($res);
//	}	// end delExpense
/*-----------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------*/
}	// end expenseAction