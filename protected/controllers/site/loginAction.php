<?php

class loginAction extends CAction   /*---- SiteController ----*/
{
   public function run()
	{
		$err  = FALSE;
		$err1 = '';
		$err2 = '';


		// collect user input data
		if(isset($_POST['login']) && isset($_POST['pass']))
		{
			//$record = User::model()->findByAttributes(array('login'=>$_POST['login']));
			$identity = new UserIdentity($_POST['login'],$_POST['pass']);
				// проверка введённых пользователем данных
			if($identity->authenticate()) {
				// echo "Login!";
				//Yii::app()->session->sessionID;
					error_log("----------------------------");
					error_log(print_r(Yii::app()->session->sessionID, true));
			    Yii::app()->user->login($identity);		// если всё правильно - аутентифицируем польователя
			    // error_log(print_r($_SESSION,true));
			    // $this->controller->redirect(array('site/index'));
			    // print_r(Yii::app()->user);
				// return;
			    	// записываем дату в сессию
                Yii::app()->session['workdate'] = $_POST['date'];

        /*-----------------------------Переменные в сессию-----------------------------------------*/
                //$st = User::model()->findByAttributes(array('id'=>Yii::app()->user->id));
                $st = User::model()->findByPk(Yii::app()->user->id);
					// записываем id магазина в сессию
                Yii::app()->session['id_store'] = $st->id_store;
                	// записываем id пользователя в сессию
                Yii::app()->session['id_user'] = $st->id;
		/*-----------------------------------------------------------------------------------------*/
			// return;
			    $this->controller->redirect(Yii::app()->user->returnUrl);	// перенаправляем
			} else {
				//echo "Error";
		    	$err2 = $identity->errorMessage;
		    	//$err1 = 'Неверный логин или пароль';
		    	$err = TRUE;

			}
		}

/*  пример из документации
		$model = new LoginForm();
	    if(isset($_POST['LoginForm']))
	    {
	        	// получаем данные от пользователя
	        $model->attributes=$_POST['LoginForm'];
	        	// проверяем полученные данные и, если результат проверки положительный,
	        	// перенаправляем пользователя на предыдущую страницу
	        if($model->validate())
	            $this->controller->redirect(Yii::app()->user->returnUrl);
	    }*/

			// показать форму авторизации
		$this->controller->render('login', array (
									//'model'=>$model,
									'err'=>$err,
									'err1'=>$err1,
									'err2'=>$err2,
								));
	}
}