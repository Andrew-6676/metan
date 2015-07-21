<?php

class HelpController extends ControllerH
{
/* --------------------- список всех действий контроллера ---------------*/
	public function actions()
    {
        return array(
        	'index'=>'application.controllers.help.indexAction',
        	'editor'=>'application.controllers.help.editorAction',
        );
    }
    // ------------------------- фильтры -------------------------/
	 public function filters()
    {
        return array(
            'accessControl',
        );
    }
/* --------------------------- паравила доступа для контроллера ---------------*/
	public function accessRules()
    {
        return array(
        		// правила просматриваются по порядку до первого совпадения
        	array('allow',
                'actions'=>array('editor'),          	// только пользователи "admin" получат доступ
                'users'=>array('admin','zavmag'),					// остальным выдаст ошибку 403
            ),
            array('deny',
                'actions'=>array('editor'),	       	// запреить всем доступ
                'users'=>array('*'),					// запрет должен стоять после разрешения
            ),
        );
    }


}