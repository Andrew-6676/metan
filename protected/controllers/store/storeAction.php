<?php

class storeAction extends CAction   /*---- StoreController ----*/
{
	public function run(){


		$model = Store::model()->findByPK(Yii::app()->session['id_store']);

		if (isset($_POST['Store'])) {

			Utils::print_r( $_POST['Store']['okpo']);

//			$model->attributes=$_POST['Store'];
			$model->name     = $_POST['Store']['name'];
			//$model->fname    = $_POST['Store']['fname'];
			$model->address  = $_POST['Store']['address'];


			$model->fio      = $_POST['Store']['fio'];
			$model->phone    = $_POST['Store']['phone'];
			$model->account  = $_POST['Store']['account'];
			$model->mfo      = $_POST['Store']['mfo'];
			$model->bank     = $_POST['Store']['bank'];
			$model->fio_mpu  = $_POST['Store']['fio_mpu'];
			$model->unn      = $_POST['Store']['unn'];
			$model->okpo     = $_POST['Store']['okpo'];
			$model->lic      = $_POST['Store']['lic'];
			$model->dov      = $_POST['Store']['dov'];
			$model->address  = $_POST['Store']['address'];
			$model->pname    = $_POST['Store']['pname'];

			if ($model->save()){
				Yii::app()->user->setFlash('ok', "Сохранено!");
				$this->controller->redirect(array('store/store'));
			}


		}

	 	$this->controller->pageTitle = 'Магазин "Метан"';
	 	$this->controller->render('store', array('model'=>$model));
	}
}