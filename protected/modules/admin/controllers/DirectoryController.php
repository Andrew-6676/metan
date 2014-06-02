<?php

/**
 * SiteController is the default controller to handle user requests.
 */
class DirectoryController extends Controller2
{
	public $menu2 = array();

	public function filters()
		{
			return array(
				'accessControl', // perform access control for CRUD operations
				//'postOnly + delete', // we only allow deletion via POST request
			);
		}

	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index', 'import'),
				'users'=>array('admin'),
			),
			/*array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),*/
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

/* --------------------- список всех действий контроллера ---------------*/
	public function actions()
    {

    	/* формируем меню для этого контроллера */
    	$menu=array(
    		array('label'=>'пользователей', 'url'=>array('directory/index', 'dir'=>'users')),
			array('label'=>'операций', 'url'=>array('directory/index', 'dir'=>'operations')),
			array('label'=>'поставщиков', 'url'=>array('directory/index', 'dir'=>'cont')),
			array('label'=>'единиц измерения', 'url'=>array('directory/index','dir'=>'unit')),
			array('label'=>'паспорт магазина', 'url'=>array('directory/passport')),
		);
		$this->menu = array_merge($this->menu, $menu);

		$this->menu2 = array(
			array('label'=>'Импорт', 'url'=>array('directory/import')),
			array('label'=>'Экспорт', 'url'=>array('directory/export')),
		);

        return array(
        	'index'=>'application.modules.admin.controllers.directory.indexAction',
            'import'=>'application.modules.admin.controllers.directory.importAction',
            //'logout'=>'application.controllers.site.logoutAction',
        );
    }
}