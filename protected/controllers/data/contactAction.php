<?php

class contactAction extends CAction   /*---- DataController ----*/
{
   public function run()
	{
		//if(Yii::app()->request->isAjaxRequest)
		{
			// print_r($_POST);
			// exit;
				// сохранить контакт в БД
			if(isset($_POST['new_contact'])) {
				//$this->addContact($_POST['new_contact']);
				echo 'new_contact';
				exit;
        	}		// if(isset($_POST['new_expense']))

        		// удалить контакт
			if(isset($_POST['del_contact'])) {
				$this->delContact($_POST['del_contact']);
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

		// $criteria = new CDbCriteria;
		// // $criteria->join = 'inner join {{operation}} on {{operation}}.id=t.id_operation';
		// $criteria->order ='doc_date desc, doc_num desc';
		// $criteria->addCondition('id_doctype = 2');
		// $criteria->addCondition('id_store='.Yii::app()->session['id_store']);
		// $criteria->addCondition('doc_date=\''.Yii::app()->session['workdate'].'\'');
		// $criteria->addCondition('doc_num2 != 0');

		// $res = Document::model()->with('documentdata')->findAll($criteria);

		// //doc_num2>0 and
		// 	// список операций
		// $oper = Operation::model()->findAll(array('condition'=>'operation<0',
		// 										  'order'=>'name'));
		// 	// следующий номер документа
		// $sql = 'SELECT max(doc_num2)::integer+1 FROM {{document}} d where id_doctype=2 and id_store='.Yii::app()->session['id_store'];
		// $doc_num = Yii::app()->db->createCommand($sql)->queryScalar();


		// $this->controller->pageTitle = 'Расход';
		// $this->controller->render('expense', array(
		// 							'data'=>$res,
		// 							'oper'=>$oper,
		// 							'doc_num'=>$doc_num
		// 						 ));
	}	// end run

/*-----------------------------------------------------------------------------------*/
/*---------------------- Добавление нового расхода в БД -----------------------------*/
	private function addContact($data) {
		$res = array();
			// тут надо проверить $data['doc']['doc_id']
			// если меньше 0 - новый документ, иначе - редактирование существующего
		$contact = new Contact();
		$new_cont = false;
		if ($data['id']<0) {

		} else {
			// echo 'Редактирование документа id='.$data['doc']['doc_id'];
			// exit;
			$new_doc = true;
		}

			// начинаем транзакцию
		$transaction=$document->dbConnection->beginTransaction();
		// Yii::app()->db->emulatePrepare = false;
		try
		{
	    	// $contact->id_owner	 	= Yii::app()->user->id;
	    	// $contact->id_editor	= Yii::app()->user->id;
	    	// $contact->date_insert 	= date('Y-m-d');
	    	// $contact->date_edit	= date('Y-m-d');
	    	$contact->id			= $data['id'];
	    	$contact->doc_num2		= intval($doc['doc_num']);
			$contact->doc_date		= $doc['doc_date'];
	    	$contact->id_contact	= 0;
	    	$contact->id_storage	= 2;
	    	$contact->reason		= '';
	    	$contact->id_operation	= $doc['id_operation'];
	    	$contact->id_doctype 	= 2;
	    	//$document->active = '1::boolean';
	    	//print_r($document);
			if($document->save()) {

			}

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
	private function delContact($id) {
		//$sql = 'delete from vgm_document where id='.$id;
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
}	// end contactAction