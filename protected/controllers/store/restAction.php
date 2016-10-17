<?php

class restAction extends CAction   /*---- StoreController ----*/
{
	public function run(){
		$connection = Yii::app()->db;

		$filter = '';
		if (isset($_GET['filter'])) $filter = $_GET['filter'];
		$rest = Rest::getRestList_new('name', $filter.'%', Yii::app()->session['workdate'], Yii::app()->session['id_store']);


		$total = 0;
		$count = 0;
		foreach ($rest as $r) {
			if ($r['id']!=99999999) {
				$total += $r['price'] * $r['rest'];
				$count++;
			} else {
				$total -= $r['price'];
			}
//			$total += $r['rest']*Goods::model()->findByPK($r['id'])->price;
		}


		//$count = count($rest);
//		$SqldataProvider = new CActiveDataProvider($rest, array(
//	    	'keyField'=>'gid',
//	    	'totalItemCount'=>$count,
//	    	'pagination'=>array('pageSize'=>5000,),
//		));

		$sort = new CSort;
		$sort->defaultOrder = 'name ASC';
		$sort->attributes = array('name', 'id', 'price', 'rest');

		$dataProvider = new CArrayDataProvider(
			$rest,
			array(
				'keyField'   => 'id',
				'pagination'=>false,
//				'pagination' => array(
//									'pageSize'=>3000,
//								),
				'sort' => $sort
			)
		);


	 	$this->controller->pageTitle = 'Остатки товара';
	 	$this->controller->render('rest', array('data'=>$dataProvider, 'total'=>$total, 'count'=>$count));
	}
}