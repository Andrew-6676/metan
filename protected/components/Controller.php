<?php
/*
	расширение функционала стандартного контроллера
 */
class Controller extends CController
{
	public $basePath;	// путь к файлу контроллера
	public $helpIndex = 0;
	public $css = array();	// массив подключаемых стилей
	public $js = array();	// массив подлючаемых скриптов
	public $layout='//layouts/c1';	// представление по умолчанию (с1 - одноколоночный вид)
	public $menu= array();	// меню
	public $breadcrumbs=array();


	public function init() {
			// определяем путь к контроллеру
		$this->basePath = Yii::app()->request->getBaseUrl().'/'.$this->getRoute();
		parent::init();
	}

//$url=$this->createUrl($route,$params);
/* ------------------------- добавить файл стилей к странице ----------------------*/
	public function addCSS($css) {
		$this->css[] = $css;
	}

/*-------------------- вернуть код HTML для вставки в страницу CSS----------------*/
	public function getCSS() {
		$css_str = '';
		foreach($this->css as $c) {
			$css_str .= "\n<link href='".Yii::app()->request->getBaseUrl().'/css/'.$c."' rel='stylesheet'>\n";
		}
		return $css_str;
	}

/* ------------------------- добавить скрипт к странице ----------------------*/
	public function addJS($js) {
		$this->js[] = $js;
	}

/*-------------------- вернуть код HTML для вставки в страницу JS ----------------*/
	public function getJS() {
		$js_str = '';
		foreach($this->js as $j) {
			$js_str .= "\n<script src='".Yii::app()->request->getBaseUrl().'/js/'.$j."'></script>\n";
		}
		return $js_str;
	}
}