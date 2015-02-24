<?php

class printRestAction extends CAction   /*---- PrintController ----*/
{
	public function run($id_store=0, $workdate='2000-01-01'){

		$connection = Yii::app()->db;

		$sql_rest = "select ggid, ggname, gid, gname, price, sum(quantity)::real as rest
					from (
							select gg.id as ggid, gg.name as ggname, g.id as gid, g.name as gname, dd.quantity*o.operation as quantity, dd.price, 'd' as t
							from vgm_goods g
								inner join vgm_documentdata dd on g.id=dd.id_goods
								inner join vgm_document d on d.id=dd.id_doc
								inner join vgm_operation o on o.id=d.id_operation
								left join vgm_goodsgroup gg on gg.id=g.id_goodsgroup
							where d.doc_date<='".$workdate."' and d.doc_date>='".substr($workdate,0,7)."-01' and id_store=".$id_store."
								union
							select gg.id as ggid, gg.name as ggname, g.id as gid, g.name as gname, r.quantity, r.cost as price, 'r' as t
							from vgm_goods g
								inner join vgm_rest r on g.id=r.id_goods
								left join vgm_goodsgroup gg on gg.id=g.id_goodsgroup
							where r.rest_date::text like '".substr($workdate,0,7)."-01' and id_store=".$id_store."
						 ) as motion
					group by ggid, ggname, gid, gname, price
					having sum(quantity)!=0
					order by 3,1,2";

		// $sql_rest = "select id, name, price, sum(quantity) as rest
		// 		from (
		// 				select g.id, g.name, dd.quantity*o.operation as quantity, dd.price, 'd' as t
		// 				from vgm_goods g
		// 					inner join vgm_documentdata dd on g.id=dd.id_goods
		// 					inner join vgm_document d on d.id=dd.id_doc
		// 					inner join vgm_operation o on o.id=d.id_operation
		// 				where d.doc_date<='".Yii::app()->session['workdate']."'
		// 					union
		// 				select g.id, g.name, r.quantity, r.cost as price, 'r' as t
		// 				from vgm_goods g
		// 					inner join vgm_rest r on g.id=r.id_goods
		// 				where r.rest_date::text like '".substr(Yii::app()->session['workdate'],0,7)."-01'
		// 			 ) as motion
		// 		group by id, name, price";
		//echo "<pre>";
		//print_r($sql_rest);
//		print_r(Yii::app()->session);
		//echo "</pre>";
		$rest = $connection->createCommand($sql_rest)->queryAll();


		//$this->controller->layout='//layouts/print';
		//$this->controller->render('rest', array('data'=>$rest));
		$this->controller->render('rest', array('workdate'=>$workdate, 'id_store'=>$id_store, 'data'=>$rest));
	}
}