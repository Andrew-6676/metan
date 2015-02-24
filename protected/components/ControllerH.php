<?php
/*
	переопределение Controller, который расширен от СController
 */
class ControllerH extends Controller
{
	public $css = array('help.css');
	//public $js = array('jquery.js');
	public $layout='//layouts/help';	// представление по умолчанию (help - для отображения справки
}