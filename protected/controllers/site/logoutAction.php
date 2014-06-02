<?php

class logoutAction extends CAction   /*SiteController*/
{
   public function run()
	{
		Yii::app()->user->logout();
		$this->controller->redirect(Yii::app()->user->loginUrl);
	}
}