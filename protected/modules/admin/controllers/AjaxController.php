<?php

class AjaxController extends CController
{
/* ---------------------------------------------------------------------- */
	public function ActionQuery()
	{
		$connection=Yii::app()->db;
		if(Yii::app()->request->isAjaxRequest) {
			//echo $_POST['sql'];
			return $connection->createCommand($_POST['sql'])->execute();
			exit;
		}else {
			echo '-1';
		}
	}
/*------------------------------------------------------------------------*/
	public function ActionFieldSrcList()
	{
	//	if(Yii::app()->request->isAjaxRequest)
		{
	        //echo CHtml::encode($output);
            //echo 'Response from DirectoryController->ImportAction';
            //if
            $DBF = new dbf($_POST['path']);
            //$DBF = new dbf('/var/www/metan_0.1/public/dbf/f160006.dbf');
			if ($DBF)
			{
				//print_r($DBF->getFields());
				echo json_encode($DBF->getFields());
			}
	        Yii::app()->end();	// Завершаем приложение
        }
	}
/*------------------------------------------------------------------------*/

	public function ActionTableList()
	{
        $connection=Yii::app()->db;
		$sql = 'SELECT c.relname AS Name
				FROM pg_catalog.pg_class c
				where c.relkind=\'r\' and  c.relname like \'vgm_%\'';
		$command = $connection->createCommand($sql);
		$rows = $command->queryAll();
		echo json_encode($rows);
		//echo 'hello from ajaxController';
	}
/* ---------------------------------------------------------------------- */
	public function ActionFieldList($tname='test')
	{
       	$connection=Yii::app()->db;
		$sql = 'SELECT  c.column_name as name, c.data_type as type
				FROM information_schema.TABLES t
				     JOIN information_schema.COLUMNS c ON t.table_name = c.table_name
				WHERE t.table_name = \''.$tname.'\'';
		$command = $connection->createCommand($sql);
		$rows = $command->queryAll();
		//echo $tname."<br>";
		echo json_encode($rows);
		//echo 'hello from ajaxController';
	}
/* ---------------------------------------------------------------------- */
/*	public function filters()
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
			),*
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
/*-------------------------------------------------------------------------*/

	public function getFieldsSrc($path='')
	{
		# code...
	}
}