<?php

class ErrorController extends Controller
{
	public $mess = array(
			'400' => 'Плохой запрос',
			'403' => 'Доступ к этой странице пользователю <span class="uname"><user></span> ЗАПРЕЩЁН!',
			'404' => 'Такой страницы не существует!',
			'500' => 'Внутренняя ошибка сервера',
		);

	public function actionError() {
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->helpIndex = $error['code'];
				$this->render('error', array('error'=>$error));
				//$acttion = 'Error'.$error['code'];
		}
	}

	public function Error404()
	{
		$mess = '';
		$this->render('error', array(
								'error'=>$error,
								'mess'=>$mess,
					));
	}
}

/* --------------------- список всех действий контроллера ---------------*

	public function actions()
    {
        return array(
        	'index'=>'application.controllers.directory.indexAction',
            //'login'=>'application.controllers.site.loginAction',
            //'logout'=>'application.controllers.site.logoutAction',
        );
    }
}*/