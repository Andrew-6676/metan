<?php
class DataController extends Controller
{
	/*
	 * Index action is the default action in a controller.

	public function actionIndex($param='default')
	{

	}*/
/* --------------------- список всех действий контроллера ---------------*/
	public function actions()
    {
        return array(
        	'import'=>'application.controllers.data.importAction',
            //'login'=>'application.controllers.site.loginAction',
            //'logout'=>'application.controllers.site.logoutAction',
        );
    }

/* ------------------------- фильтры -------------------------*
	 public function filters()
    {
        return array(
            'accessControl',
        );
    }
/* --------------------------- паравила доступа для контроллера ---------------*
public function accessRules()
    {
        return array(
        		// правила просматриваются по порядку до первого совпадения
        	array('allow',
                'actions'=>array('delete','index'),  	// только пользователь "test" получит доступ
                'users'=>array('test'),					// остальным выдаст ошибку
            ),
            array('deny',
                'actions'=>array('index', 'edit'),		// запреить всем доступ к "index"
                'users'=>array('*'),					// запрет должен стоять после разрешения
            ),

            array('deny',
                'actions'=>array('delete'),
                'roles'=>array('admin'),
                'users'=>array('*'),
            ),
        );
    }*/

}
