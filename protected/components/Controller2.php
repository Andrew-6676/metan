<?php
/*
	расширение функционала Controller, который расширен от СController
 */
class Controller2 extends Controller
{
	public $css = array('left.css');	// подключаемый стиль по умолчанию
	//public $js = array('jquery.js');
	public $layout='//layouts/c2';	// представление по умолчанию (с2 - двухколоночное)
}