<?php

class goodsCartAction extends CAction   /*---- StoreController ----*/
{
	public function run($id){
		$criteria = new CDbCriteria;

		$criteria->order ='id_doctype, doc_date, doc_num';
		$criteria->addCondition('documentdata.id_goods='.$id);
		$criteria->addCondition('id_store='.Yii::app()->session['id_store']);
		$criteria->addCondition('doc_date<=\''.Yii::app()->session['workdate'].'\'');
		$criteria->addCondition('doc_date::text like \''.substr(Yii::app()->session['workdate'],0,7).'%\'');

		$data = Document::model()->with('documentdata','operation','doctype')->findAll($criteria);
//		$data =

		$this->controller->pageTitle = 'Каточка товара';
		$this->controller->render('goodsCart', array('data'=>$data));
	}
}