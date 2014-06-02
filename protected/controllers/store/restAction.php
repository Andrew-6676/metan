<?php

class restAction extends CAction   /*---- StoreController ----*/
{
	public function run(){
		$connection = Yii::app()->db;

		$sql_rest = "select ggid, ggname, gid, gname, price, sum(quantity)::real as rest
					from (
							select gg.id as ggid, gg.name as ggname, g.id as gid, g.name as gname, dd.quantity*o.operation as quantity, dd.price, 'd' as t
							from vgm_goods g
								inner join vgm_documentdata dd on g.id=dd.id_goods
								inner join vgm_document d on d.id=dd.id_doc
								inner join vgm_operation o on o.id=d.id_operation
								left join vgm_goodsgroup gg on gg.id=g.id_goodsgroup
							where d.doc_date<='".Yii::app()->session['workdate']."' and d.doc_date>='".substr(Yii::app()->session['workdate'],0,7)."-01' and id_store=".Yii::app()->session['id_store']."
								union
							select gg.id as ggid, gg.name as ggname, g.id as gid, g.name as gname, r.quantity, r.cost as price, 'r' as t
							from vgm_goods g
								inner join vgm_rest r on g.id=r.id_goods
								left join vgm_goodsgroup gg on gg.id=g.id_goodsgroup
							where r.rest_date::text like '".substr(Yii::app()->session['workdate'],0,7)."-01' and id_store=".Yii::app()->session['id_store']."
						 ) as motion
					group by ggid, ggname, gid, gname, price
					having sum(quantity)!=0
					order by 4,1,2";
		// echo '<pre>'.$sql_rest.'</pre>';
		$rest = $connection->createCommand($sql_rest)->queryAll();



		$count = count($rest);
		$SqldataProvider = new CSqlDataProvider($sql_rest, array(
	    	'keyField'=>'gid',
	    	'totalItemCount'=>$count,
	    	'pagination'=>array('pageSize'=>50,),
		));


	 	$this->controller->pageTitle = 'Остатки товара';
	 	$this->controller->render('rest', array('data'=>$SqldataProvider));
	}
}