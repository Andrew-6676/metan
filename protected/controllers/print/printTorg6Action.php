<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 18.09.15
 * Time: 8:04
 */

class printTorg6Action extends CAction   /*---- PrintController ----*/
{
	// public function run($rep, $id_doc, $id_store=0, $workdate='2000-01-01'){
	public function run() {


		//$data = 'Трг 6';

		$criteria = new CDbCriteria;
		$criteria->order ='doc_date desc, doc_num desc, documentdata.id';
		$criteria->addCondition('id_doctype = 2');
		//$criteria->addCondition('id_operation <> 1');
		//$criteria->addCondition('id_operation <> ');
		$criteria->addCondition('id_store='.Yii::app()->session['id_store']);
		$criteria->addCondition('doc_date<=\''.Yii::app()->session['workdate'].'\'');
		$criteria->addCondition('doc_date::text like \''.substr(Yii::app()->session['workdate'],0,7).'%\'');
		$criteria->addCondition('doc_num != \'0\'');

		$data  = Document::model()->with('documentdata')->findAll($criteria);


		$this->controller->render('torg6', array('data'=>$data));
	}
}