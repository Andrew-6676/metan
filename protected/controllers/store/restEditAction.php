<?php

class restEditAction extends CAction   /*---- StoreController ----*/
{
	public function run(){

		$connection = Yii::app()->db;

//		if(Yii::app()->request->isAjaxRequest) {
//			 // Utils::print_r($_POST);
//
//		 	// $o = '';
//		 	// if ($_POST['month'] <10) {
//		 	// 	$o = '0';
//		 	// }
//			$res = array('status'=>'unknown', 'data'=>array());
//
//			echo json_encode($res);
//			// print_r($res);
//
//			exit;
//		}

		$criteria = new CDbCriteria;
		 // $criteria->addSearchCondition('rest_date::text', '2014-05-%', false, 'LIKE');
		$criteria->addCondition('rest_date::text LIKE \''.substr(Yii::app()->session['workdate'],0,7).'-%\'');
		$criteria->addCondition('id_store='.Yii::app()->session['id_store']);
//		$criteria->order ='left(id_goods::text,4), id_goods';
		if (isset($_GET['sort'])) {
			$criteria->order = $_GET['sort'];
		} else {
			$criteria->order ='t1_c1';
		}

		$model = Rest::model()->with('Goods')->findAll($criteria);

		$sum = 0;
		$arr = array();
		foreach ($model as $row) {
			$arr[] = array(
					'id' => $row->id_goods,
					'name' => $row->Goods->name,
					'price' => $row->price,
					'quantity' => $row->quantity,
			);
			$sum += $row->quantity*$row->price;
		}

//		$criteria2 = new CDbCriteria;
//		$criteria2->addCondition('rest_date::text LIKE \''.substr(Yii::app()->session['workdate'],0,7).'-%\'');
//		$criteria2->addCondition('id_store='.Yii::app()->session['id_store']);
//		$criteria2->select = 'sum(quantity*price) as sum';
//
//		$sum = Rest::model()->find($criteria2);
//		$sum = 0;
//		foreach ($model as $m) {
//			$sum += $m->quantity*$m->price;
//		}

	 	$this->controller->pageTitle = 'Редактирование остатков';
	 	$this->controller->render('restEdit', array('model'=>$model, 'sum'=>$sum));




//		$sort = new CSort;
//		$sort->defaultOrder = 'id ASC';
//		$sort->attributes = array('name', 'id', 'price', 'quantity');
//
//
//		$dataProvider = new CArrayDataProvider(
//				$arr,
//				array(
//						'keyField'   => 'id',
//						'pagination'=>false,
////				'pagination' => array(
////									'pageSize'=>3000,
////								),
//						'sort' => $sort
//				)
//		);
//
//		$this->controller->pageTitle = 'Редактирование остатков';
//		$this->controller->render('restEdit', array('dataProvider'=>$dataProvider, 'sum'=>$sum));
	}
}