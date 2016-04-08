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

		if ($mon > 2 && $mon <= 5) $kv = 1;
		if ($mon > 5 && $mon <= 8) $kv = 2;
		if ($mon > 8 && $mon <= 11) $kv = 3;
		if ($mon > 11 || $mon <= 2) $kv = 4;

		$data = $kvartal[$kv];

		$connection = Yii::app()->db;
		$sql= "select id, name, id_3torg,sum(quantity) as quantity, sum(quantity_rb) as quantity_rb, sum(sum) as sum, sum(sum_rb) as sum_rb
			 from (
			select t.id, t.name, id_3torg, sum(quantity) as quantity, NULL as quantity_rb, sum(quantity*price) as sum, NULL as sum_rb
			from vgm_documentdata as dd
				inner join vgm_document as d on d.id=dd.id_doc
				inner join vgm_goods as g on dd.id_goods = g.id
				inner join vgm_3torg as t on t.kod_gr=g.id_3torg
			where doc_date>='".$year.$kvartal[$kv][0]."' and doc_date<='".$year.$kvartal[$kv][1]."'
			group by t.id, g.id_3torg,t.name
				union
			select t.id, t.name, id_3torg, NULL as quantity, sum(quantity) as quantity_rb, NULL as sum, sum(quantity*price) as sum
			from vgm_documentdata as dd
				inner join vgm_document as d on d.id=dd.id_doc
				inner join vgm_goods as g on dd.id_goods = g.id
				inner join vgm_3torg as t on t.kod_gr=g.id_3torg
			where doc_date>='".$year.$kvartal[$kv][0]."' and doc_date<='".$year.$kvartal[$kv][1]."' and upper(g.producer) like 'РБ%'
			group by t.id, g.id_3torg,t.name
			order by id
			) as tmp
			group by id, name, id_3torg
			order by id_3torg";
//		$sql = "select t.name, id_3torg, sum(quantity) as quantity, sum(quantity*price) as sum
//				from vgm_documentdata as dd
//					inner join vgm_document as d on d.id=dd.id_doc
//					inner join vgm_goods as g on dd.id_goods = g.id
//					inner join vgm_3torg as t on t.kod_gr=g.id_3torg
//				where doc_date>='".$year.$kvartal[$kv][0]."' and doc_date<='".$year.$kvartal[$kv][1]."'
//				group by g.id_3torg,t.name
//				";
		$data = $connection->createCommand($sql)->queryAll();
		//$data = $sql;


		$this->controller->render('torg4p', array('data'=>$data));
	}
}
