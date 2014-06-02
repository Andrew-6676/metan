<?php

class prAction extends CAction   /*---- PrintController ----*/
{
	public function run(){
		$this->controller->render('pr');
	}
}