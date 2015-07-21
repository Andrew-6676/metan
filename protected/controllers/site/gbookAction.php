<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 20.07.15
 * Time: 9:36
 */


class gbookAction extends CAction   /*SiteController*/
{
	public function run()
	{

		if(Yii::app()->request->isAjaxRequest) {
//			 print_r($_POST);
			// exit;
			// сохранить расход в БД-------------------------------------------------------------------------------
			if (isset($_POST['mess'])) {
				$res = array('status' => 'error', 'message' => '');
				$gbook = new Gbook;
				$gbook->mess = $_POST['mess'];

				if ($gbook->save()) {
					$res['status'] = 'ok';
					$res['message'] = 'Сообщение отправлено';
				} else {
					$res['status'] = 'ok';
					$res['message'] = 'Ошибка! ';
				}

				echo json_encode($res);
				exit;
			}

			echo 'Неправильный запроc';
			exit;
		}

		$this->controller->render('gbook');
	}
}