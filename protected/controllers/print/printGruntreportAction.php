<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 17.08.15
 * Time: 11:51
 */


class printGruntreportAction extends CAction   /*---- PrintController ----*/
{
	public function run($from_date, $to_date) {
		// Utils::print_r($_GET);

		$params['from_date'] = $from_date;
		$params['to_date'] = $to_date;

		$data = $this->getData($_GET);
		$this->controller->render('grunt', array('data' => $data));
	}


/*--------------------------------------------------------------------------------------------------------------*/

	private function getData($params)
	{
		$from_date = $params['from_date'];
		$to_date = $params['to_date'];

		$connection = Yii::app()->db;
		$sql = "SELECT name, vol, price, sum(quantity) AS quantity, sum(quantity*price) AS sum
			FROM
			(SELECT
				g.name AS gname,
				substring(g.name, '\d+')::int AS vol,
				substring(g.name, '(ДВИНА|УНИВЕР|ЦВЕТОЧНЫЙ|ТОМАТНЫЙ|ТОМАТ\+ПЕРЕЦ|ПЕРЦ|УРОЖАЙ.+\s|РАССАДН)') AS name,
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
			  ) AS tmp
			  GROUP BY name, vol, price
			  ORDER BY vol, name";


		$data = $connection->createCommand($sql)->queryAll();


		return $data;
	}
}