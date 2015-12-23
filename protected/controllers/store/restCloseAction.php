<?php
/*
 * @TODO остаток по кассе тоже перенести
 * */
class restCloseAction extends CAction   /*---- StoreController ----*/
{
	public function run(){
		if(Yii::app()->request->isAjaxRequest) {
			 // Utils::print_r($_POST);

		 	$connection = Yii::app()->db;
		 	$o = '';
			$o1 = '';
		 		// добавлять ли 0 перед номером месяца
		 	if ($_POST['month'] < 9) {
		 		$o = '0';
		 	}
			if ($_POST['month'] < 10) {
				$o1 = '0';
			}

		 	if ($_POST['mode']=='close') {
			    $res = Rest::closeMonth($_POST['month'], $_POST['year'], Yii::app()->session['id_store']);


			}
			/*------------------------------------------------------------------*/
			if ($_POST['mode']=='check') {

				if ($_POST['month']<9) {
					$m = '0'.($_POST['month']+1);
				} else {
					if ($_POST['month'] == 12) {
						$m = '01';
						$_POST['month'] = $m;
						$_POST['year']++;
					} else {
						$m = ($_POST['month']+1);
					}
				}
				//$res['post'] = $_POST;
				$sql_count = 'select count(*) from {{rest}} where rest_date::text like \''.$_POST['year'].'-'.$m.'-%\' and id_store='.Yii::app()->session['id_store'];
				if ($connection->createCommand($sql_count)->queryScalar() > 0) {
					$res['status'] = 'ok';
				} else {
					$res['status'] = 'no';
				}
			}
			//$res['sql'] = $sql_count;
			echo json_encode($res);
			// print_r($res);

			exit;
		}



	 	$this->controller->pageTitle = 'Закрытие месяца';
	 	$this->controller->render('restClose');
	}
}