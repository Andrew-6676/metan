<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 18.09.15
 * Time: 8:04
 */

class printTorg4pAction extends CAction   /*---- PrintController ----*/
{
	// public function run($rep, $id_doc, $id_store=0, $workdate='2000-01-01'){
	public function run() {


//$data2 = Yii::app()->db->createCommand()
//->select('sum(price*count) as summ')
//->from('resources')
//->where('prj_id = ' . $_POST['Resources']['prj_id'])
//->queryRow();

		//$data = 'Трг 4';
		$kvartal = array(
			'1' => array('-01-01', '-03-31'),
			'2' => array('-04-01', '-06-30'),
			'3' => array('-07-01', '-09-30'),
			'4' => array('-10-01', '-12-31'),
		);

		// выясняем квартал
		$mon = (int)substr(Yii::app()->session['workdate'],5,2);
		$year = substr(Yii::app()->session['workdate'],0,4);

		if ($mon > 2  && $mon <= 5)  $kv = 1;
		if ($mon > 5  && $mon <= 8)  $kv = 2;
		if ($mon > 8  && $mon <= 11) $kv = 3;
		if ($mon > 11 || $mon <= 2)  $kv = 4;

		$data = $kvartal[$kv];

		$connection = Yii::app()->db;
		$sql= "select id, name, id_3torg, month, sum(quantity) as quantity, sum(quantity_rb) as quantity_rb, sum(sum) as sum, sum(sum_rb) as sum_rb
			 from (
			select t.id, t.name, id_3torg, EXTRACT(MONTH FROM  doc_date) as month, sum(quantity) as quantity, NULL as quantity_rb, sum(quantity*price) as sum, NULL as sum_rb
			from vgm_documentdata as dd
				inner join vgm_document as d on d.id=dd.id_doc
				inner join vgm_goods as g on dd.id_goods = g.id
				left join vgm_3torg as t on t.kod_gr=g.id_3torg
			where 
				d.id_store=".Yii::app()->session['id_store']." 
				and doc_date>='".$year.$kvartal[$kv][0]."' 
				and doc_date<='".$year.$kvartal[$kv][1]."'
				and id_doctype = 2
				and \"for\"=2
			group by t.id, g.id_3torg,t.name, EXTRACT(MONTH FROM  doc_date)
				union
			select t.id, t.name, id_3torg, EXTRACT(MONTH FROM  doc_date) as month, NULL as quantity, sum(quantity) as quantity_rb, NULL as sum, sum(quantity*price) as sum
			from vgm_documentdata as dd
				inner join vgm_document as d on d.id=dd.id_doc
				inner join vgm_goods as g on dd.id_goods = g.id
				left join vgm_3torg as t on t.kod_gr=g.id_3torg
			where 
				d.id_store=".Yii::app()->session['id_store']." 
				and doc_date>='".$year.$kvartal[$kv][0]."' 
				and doc_date<='".$year.$kvartal[$kv][1]."'
				and id_doctype = 2
				and \"for\"=2
				and upper(g.producer) like 'РБ%'
			group by t.id, g.id_3torg,t.name, EXTRACT(MONTH FROM  doc_date)
			order by id
			) as tmp
			group by id, name, id_3torg, month
			order by id_3torg";

		$data = $connection->createCommand($sql)->queryAll();
		//$data = $sql;
		//Utils::print_r($sql);

			// считаем остатки по группам
		$rest = Rest::getRestList_new('id', '', $year.$kvartal[$kv][1], Yii::app()->session['id_store']);

		$sql_gr = "select distinct g.id, g.id_3torg
					from vgm_documentdata as dd
						inner join vgm_goods as g on dd.id_goods = g.id
						inner join vgm_document as d on d.id=dd.id_doc
					where 
						d.id_store=".Yii::app()->session['id_store']." 
						and doc_date>='".$year.$kvartal[$kv][0]."' 
						and doc_date<='".$year.$kvartal[$kv][1]."'
						and id_doctype = 2
						and \"for\"=2";

		$sql_gr2 = "select distinct g.id, g.id_3torg
					from vgm_documentdata as dd
						inner join vgm_goods as g on dd.id_goods = g.id
						inner join vgm_document as d on d.id=dd.id_doc
					where 
						d.id_store=".Yii::app()->session['id_store']." 
						and doc_date>='".$year.$kvartal[$kv][0]."' 
						and doc_date<='".$year.$kvartal[$kv][1]."'
						and id_doctype = 2
						and \"for\"=2
						and upper(g.producer) like 'РБ%'";

		$gr = $connection->createCommand($sql_gr)->queryAll();
		$gr = CHtml::listData($gr, 'id','id_3torg');

		$ost = array();
		foreach ($rest as $row) {
			if (array_key_exists($row['id'], $gr))
				if (isset($ost[$gr[$row['id']]])) {
					$ost[$gr[$row['id']]]['q'] += $row['rest'];
					$ost[$gr[$row['id']]]['s'] += $row['rest']*$row['price'];
				} else {
					$ost[$gr[$row['id']]]['q'] = $row['rest'];
					$ost[$gr[$row['id']]]['s'] = $row['rest']*$row['price'];
				}
		}

		$rst[0] = $ost;

		$gr = $connection->createCommand($sql_gr2)->queryAll();
		$gr = CHtml::listData($gr, 'id','id_3torg');
		
		$ost2 = array();
		foreach ($rest as $row) {
			if (array_key_exists($row['id'], $gr))
				if (isset($ost2[$gr[$row['id']]])) {
					$ost2[$gr[$row['id']]]['q'] += $row['rest'];
					$ost2[$gr[$row['id']]]['s'] += $row['rest']*$row['price'];
				} else {
					$ost2[$gr[$row['id']]]['q'] = $row['rest'];
					$ost2[$gr[$row['id']]]['s'] = $row['rest']*$row['price'];
				}
		}

		$rst[1] = $ost2;

		$this->controller->render('torg4p', array('data'=>$data, 'rst'=>$rst, 'kv'=>$kv));
	}
}
