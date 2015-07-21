<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 20.07.15
 * Time: 8:05
 */

class prepareGoodsreportAction extends CAction   /*---- storeController ----*/
{
	public function run() {

		if(Yii::app()->request->isAjaxRequest)
		{
			// print_r($_POST);
			// exit;
			// сохранить расход в БД
			if(isset($_POST['getReport'])) {
				$this->getGoodsReport($_POST['getReport']);
				exit;
			}		// if(isset($_POST['new_expense']))

			echo 'Неправильный запроc';
			exit;
		}		// // if(Yii::app()->request->isAjaxRequest)

		$this->controller->render('prepareGoodsreport',array(
			'data'=>'$data',
		));
	}

	private function getGoodsReport($params) {
		$res = array(
			'status'=>'ok',
			'message'=>json_encode($params),
			'data'=>array('data'=>1),
		);

		echo json_encode($res);
	}
}