<?php

class goodsCartAction extends CAction   /*---- StoreController ----*/
{
	public function run($id){
		$criteria = new CDbCriteria;

			// получаем движение товара
//		$criteria->order ='id_doctype, id_operation, doc_date, doc_num';
		$criteria->order = 'doc_date, id_operation, t.id';
		$criteria->addCondition('documentdata.id_goods='.$id);
		$criteria->addCondition('id_doctype<>3');
		$criteria->addCondition('id_store='.Yii::app()->session['id_store']);
		$criteria->addCondition('doc_date<=\''.Yii::app()->session['workdate'].'\'');
		$criteria->addCondition('doc_date::text like \''.substr(Yii::app()->session['workdate'],0,7).'%\'');

		$data['m'] = Document::model()->with('documentdata','operation','doctype')->findAll($criteria);

		$data['goods'] = Goods::model()->findByPK($id);

		$this->controller->pageTitle = 'Каточка товара';

		if(Yii::app()->request->isAjaxRequest) {
			$this->controller->renderPartial('goodsCart', array('data'=>$data));
		} else {
			$this->controller->render('goodsCart', array('data'=>$data));
		}

	}
}