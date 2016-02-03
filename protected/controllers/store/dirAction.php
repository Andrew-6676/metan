<?php

class dirAction extends CAction   /*---- StoreController ----*/
{
	public function run(){

		//Utils::print_r($this->id);
		//Utils::print_r($this->controller->id);


		$page_menu = Menu::model()->findAll(['condition'=>'parent=49', 'order'=>'ord']);
		$sub_items = array();
		foreach($page_menu as $item) {
			// echo $item->url.'---';
			eval($item->url);
		}
		$this->controller->menu = $sub_items[49];

	 	$this->controller->pageTitle = 'Магазин "Метан"';
	 	$this->controller->render('index');
	}
}