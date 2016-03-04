<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 20.07.15
 * Time: 8:05
 */

class prepareGruntreportAction extends CAction   /*---- storeController ----*/
{
	public function run()
	{

		if (Yii::app()->request->isAjaxRequest) {

			if (isset($_POST['getAjaxReport'])) {
				//$this->getGoodsReport($_POST['getReport']);
				$res = getGruntReport($_POST['getAjaxReport']['from_date'], $_POST['getAjaxReport']['to_date']);

				echo json_encode($res);
				exit;
			}        // if(isset($_POST['getReport']))

			echo 'Неправильный запроc';
			exit;
		}        // if(Yii::app()->request->isAjaxRequest)

		$this->controller->render('prepareGruntreport', array(
			'data' => '$data',
		));
	}




}

function getGruntReport($from_date, $to_date) {

	$connection = Yii::app()->db;
	$sql = "select name, vol, price, sum(quantity) as quantity, sum(quantity*price) as sum
			from
			(SELECT
				g.name as gname,
				substring(g.name, '\d+')::int AS vol,
				substring(g.name, '(ДВИНА|УНИВЕРС|ЦВЕТОЧНЫЙ|ТОМАТНЫЙ|ТОМАТ\+ПЕРЕЦ|ПЕРЦ|УРОЖАЙ.+\s|РАССАДН)') AS name,
				quantity,
				price
			FROM vgm_documentdata AS dd
				INNER JOIN vgm_document AS d ON d.id=dd.id_doc
				INNER JOIN vgm_operation AS o ON o.id=d.id_operation
				INNER JOIN vgm_goods AS g ON g.id=dd.id_goods
			WHERE /*upper(name) like upper('Грунт %') or*/
				id_3torg='52.48.32'
				AND (doc_date>='" . $from_date . "' AND doc_date<='" . $to_date . "')
				AND operation<0
			  ) as tmp
			  group by name, vol, price
			  ORDER BY vol, name";

	$data = $connection->createCommand($sql)->queryAll();

	return ['status'=>'ok', 'message'=>'Отчёт', 'sql'=>$sql, 'data'=>$data];
}