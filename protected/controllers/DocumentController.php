<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 22.09.15
 * Time: 12:11
 */

class DocumentController extends Controller
{
	/* --------------------- список всех действий контроллера ---------------*/
	public function actions()
	{
		return array(

//			'import'=>'application.controllers.data.importAction',
//			'customimport'=>'application.controllers.data.customimportAction',
//			'contact'=>'application.controllers.data.contactAction',
//			'importsetup'=>'application.controllers.data.importsetupAction',
			//'logout'=>'application.controllers.site.logoutAction',
		);
	}

	public function actionDelete()
	{
		$id = $_POST['del_expense'];
		try {
			Document::model()->deleteByPk($id);
			$res = array('status'=>'ok', 'id'=>$id);
		}catch(Exception $e) {
			$res = array('status'=>'error', 'id'=>$id, 'message'=>$e);
		}

		echo json_encode($res);
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
