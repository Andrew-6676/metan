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

//		$kassa = Kassa::model()->find(array('condition'=>'kassa_date::text like \''.Yii::app()->session['workdate']."'"));


		$criteria = new CDbCriteria;
		$criteria->addCondition('kassa_date::text like \''.Yii::app()->session['workdate']."'");
		$criteria->addCondition('id_store='.Yii::app()->session['id_store']);
		$kassa = Kassa::model()->find($criteria);

		$kassa ? $sum=$kassa->sum:$sum=0;

		$criteria2 = new CDbCriteria;
		$criteria2->addCondition('kassa_date::text LIKE \''.substr(Yii::app()->session['workdate'],0,7).'-%\'');
		$criteria2->addCondition('id_store='.Yii::app()->session['id_store']);
		$criteria2->order ='kassa_date';



		$dataProvider = new CActiveDataProvider('Kassa', array(
			'criteria' => $criteria2,
		));


		$model = $dataProvider; //Kassa::model()->findAll($criteria2);


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
					$kassa->id_store = Yii::app()->session['id_store'];
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

			if (isset($_GET['Kassa_sort'])) {
				echo '1';
				exit;
			}

			echo 'Неправильный запроc';
			exit;
		}



		$this->controller->render('kassa', array('sum'=>$sum, 'model'=>$model));
	}
}