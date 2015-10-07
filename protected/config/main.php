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
		'application.widgets.superdoc.*',				// для рисования таблиц документов
//		'application.widgets.doc.*',					// для рисования таблиц документов
//		'application.widgets.invoice.*',				// для рисования таблиц счёт-фактур
//		'application.widgets.expence.*',				// для рисования таблиц расхода
//		'application.widgets.return.*',					// для рисования таблиц возврата
		'application.widgets.editTable.*',				// для рисования редактируемых таблиц
		'application.extensions.pdf.mpdf60.mpdf',  	    //для печати в PDF
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
	'preload' => array(
		'debug',
	),
	// application components -------------------------------------------------------------
	'components'=>array(
		// 'CHttpCookie'=>array(
		// 	'domain'=>'.xxxxx.com'
		// ),
		//'bootstrap'=>array(
		//	'class'=>'bootstrap.components.Bootstrap',
		//),
		'debug' => array(
			'class' => 'ext.yii2-debug.Yii2Debug',
			'enabled' => true,
		),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
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

//				array(
//					'class'=>'CWebLogRoute',
//				),

			),
		),

		/*------------------------*
		'ePdf' => array(
			'class'   => 'ext.yii-pdf.EYiiPdf',
			'params'  => array(
				'mpdf' => array(
					'librarySourcePath' => 'application.extensions.pdf.mpdf60.mpdf',
					'constants'         => array(
						'_MPDF_TEMP_PATH' => Yii::getPathOfAlias('application.runtime'),
					),
					//'class' => 'mpdf',
//					'defaultParams'     => array(
//						'mode'            => '', //  Этот параметр определяет режим нового документа
//						'format'          => 'A4', // форматы A4, A5, ...
//						'default_font_size' => 0, // Устанавливает default размер шрифта в точках (PT)
//						'default_font'    => '', // Устанавливает default font-family для документа.
//						'mgl'             => 15, // margin_left. Устанавливает отступы.
//						'mgr'             => 15, // margin_right
//						'mgt'             => 16, // margin_top
//						'mgb'             => 16, // margin_bottom
//						'mgh'             => 9, // margin_header
//						'mgf'             => 9, // margin_footer
//						'orientation'     => 'P', // книжная и альбомная ориентация
//					)
				),
			),
		),
		/*------------------------*/
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['rootFolder']
	'params'=>array(
		// this is used in contact page
		'rootFolder' => '/metan_0.1',
		'pathToDBF' => '/var/www/metan_0.1/public/dbf/',
		'adminEmail'=>'Shavneval@oblgas.by',
		'adminFIO' => 'Шавнёв А.Л.',
	),
);



