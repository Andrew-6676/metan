<?php

class receiptAction extends CAction   /*---- StoreController ----*/
{
   public function run()
	{
		if(Yii::app()->request->isAjaxRequest)
		{
			// 	// сохранить расход в БД
			// if(isset($_POST['new_expense'])) {
			// 	$this->addExpense($_POST['new_expense']);
			// 	 exit;
   //      	}		// if(isset($_POST['new_expense']))

				// изменить количество
			if(isset($_POST['change_q'])) {
				$res['status'] = 'ok';
				$res['message'] = 'Сохранено';

				$d = Documentdata::model()->findByPK($_POST['change_q']['id']);
				$d->quantity = $_POST['change_q']['quantity'];
				if (!$d->save()) {
					$res['status'] = 'err';
					$res['message'] = print_r($d->getErrors(),true);
				}

				echo json_encode($res);
				exit;
			}		// if(isset($_POST['del_receipt']))
        		// удалить расход
			if(isset($_POST['del_receipt'])) {
				$this->delReceipt($_POST['del_receipt']);
				 exit;
        	}		// if(isset($_POST['del_receipt']))

        	echo 'Неправильный запрос';
        	exit;
		}		// // if(Yii::app()->request->isAjaxRequest)

		/*--------------------------------------------------------------*/

			//$res = Goods::model()->with('idUnit')->findAll();
		// $res = Document::model()->with('documentdata')->findAll('id_operation=33 and extract(MONTH from doc_date)='.intval(substr(Yii::app()->session['workdate'],5,2)),
		// 															array('order'=>'doc_date')
		// 														);
		$res = Document::model()->with('documentdata', 'sum_cost', 'operation')->findAll(array(
																//'join'=>'inner join {{operation}} on {{operation}}.id=t.id_operation',
//																'condition'=>'id_doctype=1 and {{operation}}.operation>0 and doc_date<=\''.Yii::app()->session['workdate'].'\' and doc_date::text like \''.substr(Yii::app()->session['workdate'],0,7).'%\' and id_store='.Yii::app()->session['id_store'],
																'condition'=>'id_doctype=1 and operation.operation>0 and doc_date<=\''.Yii::app()->session['workdate'].'\' and doc_date::text like \''.substr(Yii::app()->session['workdate'],0,7).'%\' and id_store='.Yii::app()->session['id_store'],
																'order'=>'doc_date desc')
																);
		// echo '<pre>';
		// print_r($res[0]);
		// echo '</pre>';
		//echo $res[0]->date_insert."\n";
		//echo $res[0]->deliverynotelist[0]->id_dnote."\n\n";

		// $contact = $res[2]->idContact;
		// print_r($contact->name);
		$this->controller->pageTitle = 'Приход';
		$this->controller->render('receipt', array('data'=>$res));
	}
/*-----------------------------------------------------------------------------------------*/
/*----------------------- Удалить приход --------------------------------------------------*/
	private function delReceipt($id) {
		$sql = 'delete from vgm_document where id='.$id;
	 	try {
		 	// $r = Yii::app()->db->createCommand($sql)->exeute();
			Document::model()->deleteByPk($id);
			$res = array('status'=>'ok', 'id'=>$id);
		}catch(Exception $e) {
			$res = array('status'=>'error', 'id'=>$id);
		}

		echo json_encode($res);
	}	// end delReceipt
/*-----------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------*/

}	// end receiptAction