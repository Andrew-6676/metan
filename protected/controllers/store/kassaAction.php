<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 20.07.15
 * Time: 9:36
 */


class kassaAction extends CAction   /*SiteController*/
{
	public function run()
	{

		$kassa = Kassa::model()->find(array('condition'=>'kassa_date::text like \''.Yii::app()->session['workdate']."'"));
		$kassa ? $sum=$kassa->sum:$sum=0;

		if(Yii::app()->request->isAjaxRequest) {
//			 print_r($_POST);
			// exit;
			// сохранить расход в БД-------------------------------------------------------------------------------
			if (isset($_POST['mess'])) {
				$res = array('status' => 'error', 'message' => '');

//				$kassa = new Kassa;
				if (!$kassa) {
					$kassa = new Kassa;
					$kassa->kassa_date = Yii::app()->session['workdate'];
				}

				$kassa->sum = $_POST['mess'];

				if ($kassa->save()) {
					$res['status'] = 'ok';
					$res['message'] = 'Сохранено';
				} else {
					$res['status'] = 'ok';
					$res['message'] = 'Ошибка! ';
				}

				echo json_encode($res);
				exit;
			}
//
			echo 'Неправильный запроc';
			exit;
		}



		$this->controller->render('kassa', array('sum'=>$sum));
	}
}