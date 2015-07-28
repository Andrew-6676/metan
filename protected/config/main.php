<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/bootstrap');

return array(
//	'theme'=>'bootstrap', // requires you to copy the theme under your themes directory
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',  //папка protected
	'name'=>'Metan_0.1',
	'defaultController'=>'store',					// контроллер по умолчанию
	/*array(
    'site/stop',
    'param1'=>'value1',
    'param2'=>'value2',
	),*/

	// preloading 'log' component
	//'preload'=>array('log'),

	// автозагрузка моделей и компонентов -------------------------------------------------------------
	'import'=>array(

		'application.components.*',
		'application.models.*',
		'application.widgets.superdoc.*',					// для рисования таблиц документов
		'application.widgets.doc.*',					// для рисования таблиц документов
		'application.widgets.invoice.*',				// для рисования таблиц счёт-фактур
		'application.widgets.expence.*',				// для рисования таблиц расхода
		'application.widgets.return.*',					// для рисования таблиц возврата
		'application.widgets.editTable.*',				// для рисования редактируемых таблиц
		'application.extensions.pdf.mpdf60beta.mpdf',  	//для печати в PDF
	),

	 'modules'=>array(
	 	// 'modules'=>array('admin'),
	 	'admin'=>array(
                'class' => 'application.modules.admin.AdminModule',
            ),
	// 	// uncomment the following to enable the Gii tool

		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'flatron',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
			'generatorPaths'=>array(
				'bootstrap.gii',
			),
		),

	 ),

	// application components -------------------------------------------------------------
	'components'=>array(
		// 'CHttpCookie'=>array(
		// 	'domain'=>'.xxxxx.com'
		// ),
		'bootstrap'=>array(
			'class'=>'bootstrap.components.Bootstrap',
		),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>false,
				//если не авторизован + фильтр на action - перенаправит сюда
			'loginUrl'=>array('site/login'),
			//'returnUrl'=>array('site/index'),
		),
		// uncomment the following to enable URLs in path-format

		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				//'admin-import'=>'/admin/directory/import',  					// Работает!!!
				'logout'=>'/site/logout',
				'login'=>'/site/login',
			),
		),

		'db'=>require(dirname(__FILE__).'/db.php'),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'error/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages

				array(
					'class'=>'CWebLogRoute',
				),

			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'rootFolder' => '/metan_0.1',
		'pathToDBF' => '/var/www/metan_0.1/public/dbf/',
		'adminEmail'=>'Shavneval@oblgas.by',
		'adminFIO' => 'Шавнёв А.Л.',
	),
);