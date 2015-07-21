<?php

class restEditAction extends CAction   /*---- StoreController ----*/
{
	public function run(){

		$connection = Yii::app()->db;

		if(Yii::app()->request->isAjaxRequest) {
			 // Utils::print_r($_POST);

		 	// $o = '';
		 	// if ($_POST['month'] <10) {
		 	// 	$o = '0';
		 	// }
			$res = array('status'=>'unknown', 'data'=>array());

			echo json_encode($res);
			// print_r($res);

			exit;
		}

		$criteria = new CDbCriteria;
		 // $criteria->addSearchCondition('rest_date::text', '2014-05-%', false, 'LIKE');
		$criteria->addCondition('rest_date::text LIKE \''.substr(Yii::app()->session['workdate'],0,7).'-%\'');
		$criteria->addCondition('id_store='.Yii::app()->session['id_store']);
		$criteria->order ='left(id_goods::text,4), id_goods';
		$model = Rest::model()->findAll($criteria);

	 	$this->controller->pageTitle = 'Редактирование остатков';
	 	$this->controller->render('restEdit', array('model'=>$model));
	}
}