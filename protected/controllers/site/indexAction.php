<?php

class indexAction extends CAction   /*SiteController*/
{
   public function run()
	{
		$this->controller->render('index');
	}
}