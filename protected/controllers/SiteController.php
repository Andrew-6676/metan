<?php
//  Yii::app()->session['user_id']
/**
 * SiteController is the default controller to handle user requests.
 */
class SiteController extends Controller
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
        	'index'=>'application.controllers.site.indexAction',
	        'gbook'=>'application.controllers.site.gbookAction',
	        'gbookadmin'=>'application.controllers.site.gbookadminAction',
            'login'=>'application.controllers.site.loginAction',
            'logout'=>'application.controllers.site.logoutAction',
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

