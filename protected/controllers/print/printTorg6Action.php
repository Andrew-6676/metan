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


//$data2 = Yii::app()->db->createCommand()
//->select('sum(price*count) as summ')
//->from('resources')
//->where('prj_id = ' . $_POST['Resources']['prj_id'])
//->queryRow();

		//$data = 'Трг 6';

		$criteria = new CDbCriteria;
		//$criteria->select='sum(price*quantity) as price';
		//$criteria->group='"for"';
		$criteria->order ='doc_date desc, doc_num desc, documentdata.id';
		$criteria->addCondition('id_doctype = 2');
		//$criteria->addCondition('id_operation <> 1');
		//$criteria->addCondition('id_operation <> ');
		$criteria->addCondition('id_store='.Yii::app()->session['id_store']);
		$criteria->addCondition('doc_date<=\''.Yii::app()->session['workdate'].'\'');
		$criteria->addCondition('doc_date::text like \''.substr(Yii::app()->session['workdate'],0,7).'%\'');
		$criteria->addCondition('"for"=2');

		$data  = Document::model()->with('documentdata')->findAll($criteria);
		//$data = ArrayHelper::map($data, 'item1', 'item2');


                $criteria = new CDbCriteria;
                $criteria->select = 'sum(price*quantity) as price';
                $criteria->join = 'inner join {{document}} on {{document}}.id=t.id_doc and {{document}}.for=2';
                $criteria->addCondition('id_doctype = 2');
                //$criteria->addCondition('"for"=2');
                $criteria->addCondition('id_store='.Yii::app()->session['id_store']);
                $criteria->addCondition('doc_date<=\''.Yii::app()->session['workdate'].'\'');
                $criteria->addCondition('doc_date::text like \''.substr(Yii::app()->session['workdate'],0,7).'%\'');


                $sum = Documentdata::model()->find($criteria);


                $criteria = new CDbCriteria;
                $criteria->select = 'sum(price*quantity) as price';
                $criteria->join = 'inner join {{document}} on {{document}}.id=t.id_doc';
                $criteria->addCondition('id_operation = 2 or id_operation = 3');
                //$criteria->addCondition('"for"=2');
                $criteria->addCondition('id_store='.Yii::app()->session['id_store']);
                $criteria->addCondition('doc_date<=\''.Yii::app()->session['workdate'].'\'');
                $criteria->addCondition('doc_date::text like \''.substr(Yii::app()->session['workdate'],0,7).'%\'');

		$sum2 = Documentdata::model()->find($criteria);

		$rk2 = Kassa::getRest(Yii::app()->session['workdate'], Yii::app()->session['id_store']);
		$rk1 = Kassa::getRest(substr(Yii::app()->session['workdate'],0,7).'-01', Yii::app()->session['id_store'], -1);
		$rk = array($rk1, $rk2);
		$this->controller->render('torg6', array('data'=>$data, 'sum'=>$sum, 'sum2'=>$sum2, 'rk'=>$rk));
	}
}
