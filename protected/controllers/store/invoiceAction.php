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
			if(isset($_POST['del_invoice'])) {
				$this->delInvoice($_POST['del_invoice']);
				exit;
        	}		// end if(isset($_POST['del_expense']))
				// занести счёт-фактуру в расход-----------------------------------------------------------------------
			if (isset($_POST['writeoff_invoice'])) {
				$this->writeoffInvoice($_POST['writeoff_invoice']);
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
		$criteria->addCondition('doc_date::text like \''.substr(Yii::app()->session['workdate'],0,7).'%\'');

		$res = Document::model()->with('documentdata')->findAll($criteria);

			// получаем следующий номер документа
		$sql = 'SELECT max(doc_num2)::integer+1 FROM {{document}} d where id_doctype=3 and id_store='.Yii::app()->session['id_store'];
		$doc_num = Yii::app()->db->createCommand($sql)->queryScalar();

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
		$document = new Document();
		$new_doc = false;

		if ($data['doc']['doc_id']<0) {

		} else {
			$new_doc = true;
			// echo 'Редактирование документа id='.$data['doc']['doc_id'];
			//$document = new Document();
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
	    	$document->id_store 	= Yii::app()->session['id_store'];
	    	$document->id_owner	 	= Yii::app()->user->id;
	    	$document->id_editor	= Yii::app()->user->id;
	    	$document->date_insert 	= date('Y-m-d');
	    	$document->date_edit	= date('Y-m-d');
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
	        	if ($new_doc) {
	        		// удалить старый док
	        		// $death_doc = Document::model()->findByPK($data['doc']['doc_id']);
	        		Document::model()->deleteByPK($data['doc']['doc_id']);
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
	private function delInvoice($id) {
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
	private function writeoffInvoice($data) {
		/*
		    скопировать шапку документа с новым номером и типом документа и id_operation
			скопировать содержимое документа с новым id_doc
			вернуть id нового документа

			?? в шапку счёта-фактуры добавить ссылку на накладную инаоборот
			?? как связать накладную и счёт-фактуру - это лишнее

		 */
		$res = array(
			'status'=>'',
			'nakl_id'=>-1,
			'message'=>'',
//			'nakl_num'=>$data['nakl_num'],
		);


		$criteria = new CDbCriteria;
		$criteria->addCondition("doc_num = '".$data['nakl_num']."'");
		$criteria->addCondition("id_doctype = 2");
		$count = Document::model()->count($criteria);

		if ($count) {
			$res['status']  = 'ok';
			$res['message'] = 'Накладная с номером '.$data['nakl_num'].' уже существует!';

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
			$nakl->doc_num      = $data['nakl_num'];
			$nakl->doc_num2     = $data['nakl_num'];
			$nakl->date_insert  = date('Y-m-d H:i:s');
			$nakl->date_edit    = date('Y-m-d H:i:s');
			// $nakl->doc_date = $data['date'];
			$nakl->doc_date = Yii::app()->session['workdate'];


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
					$new_doc_data->attributes = $row_data->attributes;
					$new_doc_data->id_doc = $nakl->id;
					if ($new_doc_data->save()) {
						$rc++;
					} else {
						$res['message'] = 'Ошибка при копировании строк документа';
						$transaction->rollback();
					};
				}
	//			$res['docdata'] = print_r($docdata[0]->price,true);

				$res['message'] = 'Накладная № ' . $data['nakl_num'] . ' от ' . date('d.m.Y') . ' создана. ('.$rc.' стр.)';
			}
			$transaction->commit();
			echo json_encode($res);
		}
		catch (Exception $e)
		{
			$transaction->rollback();
			$res['status'] = 'error';
			$res['message'] = 'error catch';
			echo json_encode($res);
		}
	}   // end eriteoffInvoice
/*-----------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------*/

}	// end invoiceAction