<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 20.07.15
 * Time: 8:05
 */

class prepareDeliverynoteAction extends CAction   /*---- storeController ----*/
{
	public function run() {

		if(Yii::app()->request->isAjaxRequest)
		{

			$this->controller->renderPartial('forms/_deliverynote',array(
				'data'=>'$data',
			));

			exit;
		}		// // if(Yii::app()->request->isAjaxRequest)


		$this->controller->render('forms/_deliverynote',array(
			'data'=>'$data',
		));
	}

}