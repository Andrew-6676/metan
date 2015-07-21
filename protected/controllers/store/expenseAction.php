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
				$goods = array();
					// цикл по товарам
				foreach ($_POST['new_expense']['doc_data'] as $id => $row) {
					$goods[$id] = $row['quantity'];
				}

				$chk = Goods::model()->checkRest($goods);
				if ($chk['status']=='ok') {
					$this->addExpense($_POST['new_expense']);
				} else {
					echo json_encode($chk);
				}
				exit;
        	}		// if(isset($_POST['new_expense']))

        		// удалить расход
			if(isset($_POST['del_expense'])) {
				$this->delExpense($_POST['del_expense']);
				exit;
        	}		// if(isset($_POST['del_expense']))

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
		$sql = 'SELECT max(doc_num2)::integer+1 FROM {{document}} d where id_doctype=2 and id_store='.Yii::app()->session['id_store'];
		$doc_num = Yii::app()->db->createCommand($sql)->queryScalar();


		$this->controller->pageTitle = 'Расход';
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
			// тут надо проверить $data['doc']['doc_id']
			// если меньше 0 - новый документ, иначе - редактирование существующего
		$document = new Document();
		$new_doc = false;
		if ($data['doc']['doc_id']<0) {
			$new_doc = true;
		} else {
			// echo 'Редактирование документа id='.$data['doc']['doc_id'];
			// exit;
		}


//		echo json_encode($data);
//		exit;
			// начинаем транзакцию
		$transaction=$document->dbConnection->beginTransaction();
		// Yii::app()->db->emulatePrepare = false;
		try {
			$doc = $data['doc'];
			// атрибуты родительской таблицы
			$document->id_store = Yii::app()->session['id_store'];
			$document->id_owner = Yii::app()->user->id;
			$document->id_editor = Yii::app()->user->id;
			$document->date_insert = date('Y-m-d');
			$document->date_edit = date('Y-m-d');
			$document->doc_num = $doc['doc_num'];
			$document->doc_num2 = intval($doc['doc_num']);
			$document->doc_date = $doc['doc_date'];
			$document->id_contact = 0;
			$document->id_storage = 2;
			$document->reason = '';
			$document->id_operation = $doc['id_operation'];
			$document->id_doctype = 2;
			//$document->active = '1::boolean';
			if (isset($doc['doc_for']) && $doc['doc_for']) {
				$document->for = $doc['doc_for'];
			}
	    	//print_r($document);
			if($document->save()) {
					// если удачное сохранение - получаем ID новой записи
				// echo "<pre>";
				//echo 'new ID='.$document->id."\n";
				$res['new_id'] = $document->id;

				// 	// и добавляем данные в дочернюю таблицу


				$doc_data = $data['doc_data'];
				$res['goods'] = array();
					// цикл по товарам
				foreach ($doc_data as $id => $row) {
					$documentdata = new Documentdata();
					// echo "$id - $quantity;   \n";

				   		// атрибуты дочерней таблицы
	                $documentdata->id_doc       = $document->id;
	                $documentdata->id_owner     = Yii::app()->user->id;
	                $documentdata->id_editor    = Yii::app()->user->id;
	                $documentdata->date_insert  = date('Y-m-d');
	                $documentdata->date_edit    = date('Y-m-d');
	                $documentdata->id_goods     = $id;
	                $documentdata->cost         = 0;
	                $documentdata->markup       = 0;
	                $documentdata->vat          = 0;
	                $documentdata->quantity     = $row['quantity'];
	                $documentdata->packages     = 0;
	                $documentdata->gross        = 0;
	                $documentdata->price        = $row['price'];

	                	// если запись сохранилась, получаем новые ID
					if($documentdata->save()) {
							// массив вида [код товара]=><id записи>
						$res['goods'][$id] = $documentdata->id;
					} else {

					}

	        	}
	        	if (!$new_doc) {
	        		// удалить старый док
	        		// $death_doc = Document::model()->findByPK($data['doc']['doc_id']);
	        		Document::model()->deleteByPK($data['doc']['doc_id']);
	        	}

			} else {
				// если данные не сохранены

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
			echo json_encode($res);
			// echo "</pre>";
			//exit;
			$transaction->commit();
		}
		catch (Exception $e)
		{
			$transaction->rollback();
			$res['status'] = 'error';
			echo json_encode($res);
		}
		// Yii::app()->db->emulatePrepare = true;
	}	// end addExpense

/*----------------------- Удалить расход --------------------------------------------------*/
	private function delExpense($id) {
		$sql = 'delete from vgm_document where id='.$id;
	 	try {
		 	// $r = Yii::app()->db->createCommand($sql)->exeute();
			Document::model()->deleteByPk($id);
			$res = array('status'=>'ok', 'id'=>$id);
		}catch(Exception $e) {
			$res = array('status'=>'error', 'id'=>$id);
		}

		echo json_encode($res);
	}	// end delExpense
/*-----------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------*/
}	// end expenseAction