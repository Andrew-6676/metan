<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 11.09.15
 * Time: 17:00
 */


class importsetupAction extends CAction   /*DataController*/
{
	/*--------------------------------------------------------------------------------------------------*/
	public function run()
	{
		$criteria = new CDbCriteria;
		$criteria->addCondition('id_store='.Yii::app()->session['id_store']);
		$criteria->order ='enabled desc, sort';

		$data = iImport::model()->with('imptabl.table.fields')->find($criteria);

		$this->controller->render('importsetup', array('data'=>$data));
	}
}