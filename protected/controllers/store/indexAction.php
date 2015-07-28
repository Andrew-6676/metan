<?php

class indexAction extends CAction   /*---- StoreController ----*/
{
	public function run(){

		//Utils::print_r($this->id);
		//Utils::print_r($this->controller->id);


		$page_menu = Menu::model()->findAll('parent=32');
		$sub_items = array();
		foreach($page_menu as $item) {
			// echo $item->url.'---';
			eval($item->url);
		}
		$this->controller->menu = $sub_items[32];

	 	$this->controller->pageTitle = 'Магазин "Метан"';
	 	$this->controller->render('index');
	}
}