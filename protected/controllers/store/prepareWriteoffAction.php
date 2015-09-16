<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 16.09.15
 * Time: 15:37
 */

class prepareWriteoffAction extends CAction   /*---- storeController ----*/
{
	public function run() {

		if(Yii::app()->request->isAjaxRequest)
		{

			$this->controller->renderPartial('forms/_form_writeoff',array(
				'data'=>'$data',
			));

			exit;
		}		// // if(Yii::app()->request->isAjaxRequest)


		$this->controller->render('forms/_form_writeoff',array(
			'data'=>'$data',
		));
	}

}