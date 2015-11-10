<?php

class invoiceAction extends CAction   /*---- StoreController ----*/
{
   public function run()
	{
		if(Yii::app()->request->isAjaxRequest)
		{
//			 print_r($_POST);
			// exit;
				// сохранить расход в БД-------------------------------------------------------------------------------
			if(isset($_POST['new_invoice'])) {
				//print_r($_POST['new_invoice']);
				$this->addInvoice($_POST['new_invoice']);
				exit;
        	}		// end if(isset($_POST['new_expense']))

        		// удалить счёт-фактуру--------------------------------------------------------------------------------
//			if(isset($_POST['del_invoice'])) {
//				$this->delInvoice($_POST['del_invoice']);
//				exit;
//        	}		// end if(isset($_POST['del_expense']))
				// занести счёт-фактуру в расход-----------------------------------------------------------------------
			if (isset($_POST['writeoff_invoice'])) {

//				$goods = array();
//				$connection = Yii::app()->db;
//				$sql = "select id_goods as id, quantity from {{documentdata}} where id_doc=".$_POST['writeoff_invoice']['doc_id'];
//
//				$g = $connection->createCommand($sql)->queryAll();

//				// цикл по товарам
//				foreach ($g as $id => $row) {
//					$goods[$row['id']] = $row['quantity'];
//				}

//				echo json_encode($goods);
//				exit;


//				$chk = Rest::model()->checkRest($goods);
//				if ($chk['status']=='ok') {
					$this->writeoffInvoice($_POST['writeoff_invoice']);
//				} else {
//					echo json_encode($chk);
//				}
				exit;
			}
				// добавить новый контакт -----------------------------------------------------------------------------
			if(isset($_POST['new_contact'])) {
//				echo json_encode(array('new'=>'contact'));
				if ($_POST['new_contact']['id'] < 0) {
					$contact = new Contact();
					echo json_encode($contact->add($_POST['new_contact']));
				} else {
					$contact = Contact::model()->findByPK($_POST['new_contact']['id']);
					echo json_encode($contact->edit($_POST['new_contact']));
				}
				exit;
			}		// if(isset($_POST['new_contact']))
				//  удалить контакт------------------------------------------------------------------------------------
			if (isset($_POST['del_contact'])) {
				if (Contact::model()->deleteByPK($_POST['new_contact']['id']) > 0) {
					$res = array('status'=>'ok');
				} else {
					$res = array('status'=>'error');
				}
				echo json_encode($res);
				exit;
			}

        	echo 'Неправильный запроc';
        	exit;
		}		// // if(Yii::app()->request->isAjaxRequest)

		/*--------------------------------------------------------------*/

//		$res = Document::model()->with('documentdata')->findAll(array(
//														'condition'=>'id_doctype=3 and doc_date<=\''.Yii::app()->session['workdate'].'\' and doc_date::text like \''.substr(Yii::app()->session['workdate'],0,7).'%\' and id_store='.Yii::app()->session['id_store'],
//														'order'=>'doc_date desc, doc_num desc')
//														);
		$criteria = new CDbCriteria;
		// $criteria->join = 'inner join {{operation}} on {{operation}}.id=t.id_operation';
		$criteria->order = 'doc_date desc, doc_num desc';
		$criteria->addCondition('id_doctype = 3');
		$criteria->addCondition('id_store='.Yii::app()->session['id_store']);
		$criteria->addCondition('doc_date<=\''.Yii::app()->session['workdate'].'\'');
//		$criteria->addCondition('doc_date::text like \''.substr(Yii::app()->session['workdate'],0,7).'%\'');

		$res = Document::model()->with('documentdata')->findAll($criteria);

			// получаем следующий номер документа
		$sql = 'SELECT max(doc_num2)::integer+1 FROM {{document}} d where id_doctype=3 and id_store='.Yii::app()->session['id_store'].' and doc_date::text like \''.substr(Yii::app()->session['workdate'],0,4).'%\'';
		$doc_num = Yii::app()->db->createCommand($sql)->queryScalar();
		if (!$doc_num) {$doc_num = 1;}
			// потребители
		$contact = Contact::model()->findAll(array('condition'=>'parent=2','order'=>'name'));

		/*--------------------------------------------------------------*/

		$this->controller->pageTitle = 'Счёт-фактура';
		$this->controller->render('invoice', array(
									'data'=>$res,
									'doc_num'=>$doc_num,
									'contact'=>$contact
								));
	}
/*-----------------------------------------------------------------------------------------*/
/*-------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------*/
/*---------------------- Добавление нового расхода в БД -----------------------------*/
	private function addInvoice($data) {
		$res = array();

			// тут надо проверить $data['doc']['doc_id']
			// если меньше 0 - новый документ, иначе - редактирование существующего
//		$document = new Document();
		$new_doc = false;

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

			// начинаем транзакцию
		$transaction=$document->dbConnection->beginTransaction();
		// Yii::app()->db->emulatePrepare = false;
		try
		{
			$doc = $data['doc'];
				// атрибуты родительской таблицы
			$document->date_edit    = date('Y-m-d H:i:00');
	    	$document->doc_num		= $doc['doc_num'];
	    	$document->doc_num2		= intval($doc['doc_num']);
			$document->doc_date		= $doc['doc_date'];
	    	$document->id_contact	= $doc['id_contact'];
	    	$document->id_storage	= 2;
	    	$document->reason		= '';
	    	$document->id_operation	= 1;
	    	$document->id_doctype 	= 3;
	    	//$document->active = '1::boolean';
	    	//print_r($document);
			if($document->save()) {
					// если удачное сохранение - получаем ID новой записи
				// echo "<pre>";
				//echo 'new ID='.$document->id."\n";
				$res['new_id'] = $document->id;

				// 	// и добавляем данные в дочернюю таблицу


				if (!$new_doc) {
					// удалить старый док
					Documentdata::model()->deleteAll('id_doc='.$data['doc']['doc_id']);
				}
				$doc_data = $data['doc_data'];
				$res['goods'] = array();
					// цикл по товарам
				foreach ($doc_data as $id => $row) {
					$documentdata = new Documentdata();
					// echo "$id - $quantity;   \n";

				   		// атрибуты дочерней таблицы
	                $documentdata->id_doc       = $document->id;
	                $documentdata->id_goods     = $id;
	                $documentdata->cost         = $row['cost'];
	                $documentdata->markup       = $row['markup'];
	                $documentdata->vat          = $row['vat'];
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

	        	// тут все данные уже сохранены.
	        	// Если это редактирование - удаляем старые документы
	        	if (!$new_doc) {

	        		// удалить старый док
	        		// $death_doc = Document::model()->findByPK($data['doc']['doc_id']);
	        		//Document::model()->deleteByPK($data['doc']['doc_id']);
	        	}
			} else {
				// если данные не сохранены

			}		// if($model->save())


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
			print_r($e);
		}
		// Yii::app()->db->emulatePrepare = true;
	}	// end addExpense

/*----------------------- Удалить расход --------------------------------------------------*/
//	private function delInvoice($id) {
//		$sql = 'delete from vgm_document where id='.$id;
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
	private function writeoffInvoice($data) {
		/*
		    скопировать шапку документа с новым номером и типом документа и id_operation
			скопировать содержимое документа с новым id_doc
			вернуть id нового документа

			?? в шапку счёта-фактуры добавить ссылку на накладную инаоборот
			?? как связать накладную и счёт-фактуру

		 */
		$res = array(
			'status'=>'',
			'nakl_id'=>-1,
			'message'=>'',
//			'nakl_num'=>$data['nakl_num'],
		);

			// проверка остатков
		$goods = array();
		$connection = Yii::app()->db;
		$sql = "select id_goods as id, quantity from {{documentdata}} where id_doc=".$data['doc_id'];

		$g = $connection->createCommand($sql)->queryAll();
		$goods = array();
		// цикл по товарам
		foreach ($g as $id => $row) {
			$goods[ $row['id']] = $row['quantity'];
		}

		$chk = Rest::model()->checkRest($goods);
		if ($chk['status']!='ok') {
//			echo json_encode($chk);
//			exit;
			$res['no_rest'] = $chk;
		}   // end проверка остатков

			// проверка существования документа с указанным номером
		$criteria = new CDbCriteria;
		$criteria->addCondition("doc_num = '".$data['nakl_num']."'");
		$criteria->addCondition("id_doctype = 2");
		$n = Document::model()->find($criteria);

		if ($n) {   // такой документ уже есть
			$res['status']  = 'ok';
			$res['message'] = 'Накладная с номером '.$data['nakl_num'].' уже существует! (от '.$n->doc_date.', '.$n->idStore->name.')';
			echo json_encode($res);
			return;
		}

		$nakl = new Document();
		$transaction = $nakl->dbConnection->beginTransaction();
		try {
				// копирование шапки документа
			$nakl->attributes   = Document::model()->findByPK($data['doc_id'])->attributes;
			$nakl->id_doctype   = 2;
			$nakl->id_operation = 52; // $data['id_operation']
//			$nakl->id_contact   = $data['']
			$nakl->doc_num      = $data['nakl_num'];
			$nakl->doc_num2     = $data['nakl_num'];
			$nakl->doc_date     = $data['nakl_date'];
			$nakl->for          = $data['for_'];
			$nakl->date_insert  = date('Y-m-d H:i:s');
			$nakl->date_edit    = date('Y-m-d H:i:s');
			$nakl->payment_order= $data['payment_order'];

			// $nakl->doc_date = $data['date'];
//			$nakl->doc_date = Yii::app()->session['workdate'];


			if ($nakl->save()) {
				$res['status']  = 'ok';
				$res['nakl_id'] = $nakl->id;

					// копирование содержимого документа
				$criteria = new CDbCriteria;
				$criteria->addCondition("id_doc = '".$data['doc_id']."'");
				$docdata = Documentdata::model()->findAll($criteria);

				$rc = 0;
				foreach ($docdata as $row_data) {
					$new_doc_data = new Documentdata();
					$res['d'][] = $row_data->attributes;
					$new_doc_data->attributes = $row_data->attributes;
					$new_doc_data->cost       = $row_data->cost;
					$new_doc_data->quantity   = $row_data->quantity;
					$new_doc_data->price      = $row_data->price;
					$new_doc_data->vat        = $row_data->vat;
					$new_doc_data->markup     = $row_data->markup;
					$new_doc_data->id_doc     = $nakl->id;
					$new_doc_data->date_insert = date('Y-m-d H:i:s');
					$new_doc_data->date_edit   = date('Y-m-d H:i:s');
					if ($new_doc_data->save()) {
						$rc++;
					} else {
						$res['message'] = 'Ошибка при копировании строк документа';
						$transaction->rollback();
					};
				}
	//			$res['docdata'] = print_r($docdata[0]->price,true);
				$d = Utils::format_date($data['nakl_date']);
				$res['message'] = 'Накладная № ' . $data['nakl_num'] . ' от ' . $d . ' создана. ('.$rc.' стр.)';
			}

				// добавить link к счёту-фактуре
			$inv = Document::model()->findByPK($data['doc_id']);
			$inv->link = $res['nakl_id'];
			$inv->save();

			$transaction->commit();
			echo json_encode($res);
		}
		catch (Exception $e)
		{
			$transaction->rollback();
			$res['status'] = 'error';
			$res['message'] = $e;
			echo json_encode($res);
		}
	}   // end eriteoffInvoice
/*-----------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------*/

}	// end invoiceAction