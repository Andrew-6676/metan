<?php

class GoodsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
//	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
//	public function filters()
//	{
//		return array(
//			'accessControl', // perform access control for CRUD operations
//			'postOnly + delete', // we only allow deletion via POST request
//		);
//	}

	public function actions()
	{
		return array(
			'selection' => 'application.controllers.goods.selectionAction',
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{

			// список единиц измерения
		$units = Unit::model()->findAll(array('order'=>'name'));
			// группы 3-торг
		$groups = Torg3::model()->findAll(array('order'=>'name'));

		$model=new Goods;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Goods']))
		{
			$model->attributes=$_POST['Goods'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
			'units'=>$units,
			'groups'=>$groups,
			'suppliers'=>$suppliers
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{

			// список единиц измерения
		$units = Unit::model()->findAll(array('order'=>'name'));
			// группы 3-торг
		$groups = Torg3::model()->findAll(array('order'=>'name'));
			// группы 3-торг
		$suppliers = Contact::model()->findAll(array('condition'=>'parent=1','order'=>'name'));

		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Goods']))
		{
			$model->attributes=$_POST['Goods'];
			if($model->save())
//				$this->redirect(array('view','id'=>$model->id));
//				$this->redirect(array('store/receipt'));
				$this->redirect(
					array(
						Yii::app()->session['history'][1]
					)
				);

		}

		$this->render('update',array(
			'model'=>$model,
			'units'=>$units,
			'groups'=>$groups,
			'suppliers'=>$suppliers,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider = new CActiveDataProvider('Goods');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
//			Utils::print_r($_GET);
		$model=new Goods('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Goods']))
			$model->attributes = $_GET['Goods'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionWithout_gr()
	{
//			Utils::print_r($_GET);
		$sort = new CSort;
		$sort->defaultOrder = 'name ASC';
		$sort->attributes = array('name', 'id', 'id_3torg');

		$data = new CActiveDataProvider('Goods', array(
			'criteria'=>array(
				'condition'=>'id_3torg=\'\' or id_3torg=\'0\'',
			),
			'pagination'=>false,
			'sort' => $sort
		));

		$this->render('without_gr',array(
			'data'=>$data
		));
	}
	public function actionSet_gr($gid, $tid)
	{
		//Utils::print_r($_GET);
		Goods::model()->updateByPK($gid, array('id_3torg'=>$tid));
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Goods the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Goods::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Goods $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='goods-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
