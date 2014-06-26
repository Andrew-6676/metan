<?php

class returnAction extends CAction   /*---- StoreController ----*/
{
	public function run(){


	 	$this->controller->pageTitle = 'Возврат товара';
	 	$this->controller->render('return');
	}
}