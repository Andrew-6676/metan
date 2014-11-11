<?php

class returnAction extends CAction   /*---- StoreController ----*/
{
	public function run(){



		$res = Document::model()->with('documentdata')->findAll(array(
														//'join'=>'inner join {{operation}} on {{operation}}.id=t.id_operation',
														//'condition'=>'{{operation}}.operation<0 and doc_date<=\''.Yii::app()->session['workdate'].'\' and doc_date::text like \''.substr(Yii::app()->session['workdate'],0,7).'%\' and id_store='.Yii::app()->session['id_store'],
														'condition'=>'id_doctype=4 and doc_date<=\''.Yii::app()->session['workdate'].'\' and doc_date::text like \''.substr(Yii::app()->session['workdate'],0,7).'%\' and id_store='.Yii::app()->session['id_store'],
														'order'=>'doc_date desc, doc_num desc')
														);
			// список операций
		$oper = Operation::model()->findAll(array('condition'=>'operation>0',
												  'order'=>'name'));
			// следующий номер документа
		$sql = 'SELECT max(doc_num2)::integer+1 FROM {{document}} d where id_doctype=4 and id_store='.Yii::app()->session['id_store'];
		$doc_num = Yii::app()->db->createCommand($sql)->queryScalar();

	 	$this->controller->pageTitle = 'Возврат товара';
		$this->controller->render('return', array(
									'data'=>$res,
									'oper'=>$oper,
									'doc_num'=>$doc_num
								 ));
	}
}