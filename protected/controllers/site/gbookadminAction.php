<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 20.07.15
 * Time: 9:36
 */


class gbookadminAction extends CAction   /*SiteController*/
{
	public function run()
	{
		$criteria = new CDbCriteria;
		// $criteria->order ='sort, id';
//		$criteria->addCondition();
//		$criteria->addCondition();
//		$criteria->addCondition();
		$criteria->order = 'id desc';


		$data = Gbook::model()->findAll($criteria);
		$this->controller->render('gbookadmin', array('data'=>$data));
	}
}