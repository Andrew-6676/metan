<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 03.09.15
 * Time: 8:37
 */


class selectionAction extends CAction   /*---- GoodsController ----*/
{
	public function run(){

//		$this->controller->pageTitle = 'Магазин "Метан"';
		$data = $_GET['id'];

		$dataProvider = new CActiveDataProvider(
			'Rest',
			array(
				'criteria' => array(
					'condition' => 'id_goods in ('.$data.') and date_part(\'month\', rest_date)='.substr(Yii::app()->session['workdate'],5,2),
				),
				'pagination'=>false,
//				'sort' => $sort
			)
		);

		$this->controller->render('selection', array('data'=>$dataProvider));
	}
}