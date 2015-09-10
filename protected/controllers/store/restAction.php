<?php

class restAction extends CAction   /*---- StoreController ----*/
{
	public function run(){
		$connection = Yii::app()->db;

		$rest = Rest::getRestList('gname', '%', Yii::app()->session['workdate'], Yii::app()->session['id_store']);

//		$sql_rest = "select gid , gname as name,  price, sum(quantity)::real as rest
//					from (
//							select g.id as gid, g.name as gname, dd.cost as cost, dd.markup as markup, vat, dd.quantity*o.operation as quantity, dd.price, 'd' as t
//							from vgm_goods g
//								inner join vgm_documentdata dd on g.id=dd.id_goods
//								inner join vgm_document d on d.id=dd.id_doc
//								inner join vgm_operation o on o.id=d.id_operation
//							where d.doc_date<='".Yii::app()->session['workdate']."' and d.doc_date>='".substr(Yii::app()->session['workdate'],0,7)."-01' and id_store=".Yii::app()->session['id_store']."
//								union
//							select g.id as gid, g.name as gname,  r.cost as cost, r.markup as markup, r.vat as vat, r.quantity, r.price as price, 'r' as t
//							from vgm_goods g
//								inner join vgm_rest r on g.id=r.id_goods
//							where r.rest_date::text like '".substr(Yii::app()->session['workdate'],0,7)."-01' and id_store=".Yii::app()->session['id_store']."
//						 ) as motion
//					group by gid, gname, cost, markup, vat, price
//					having sum(quantity)!=0
//					order by 4, 1, 2";


//		$sql_rest = "select  gid, gname, price, sum(quantity)::real as rest
//					from (
//							select gg.id as ggid, gg.name as ggname, g.id as gid, g.name as gname, dd.quantity*o.operation as quantity, dd.price, 'd' as t
//							from vgm_goods g
//								inner join vgm_documentdata dd on g.id=dd.id_goods
//								inner join vgm_document d on d.id=dd.id_doc
//								inner join vgm_operation o on o.id=d.id_operation
//								left join vgm_goodsgroup gg on gg.id=g.id_goodsgroup
//							where d.doc_date<='".Yii::app()->session['workdate']."' and d.doc_date>='".substr(Yii::app()->session['workdate'],0,7)."-01' and id_store=".Yii::app()->session['id_store']."
//								union
//							select gg.id as ggid, gg.name as ggname, g.id as gid, g.name as gname, r.quantity, r.cost as price, 'r' as t
//							from vgm_goods g
//								inner join vgm_rest r on g.id=r.id_goods
//								left join vgm_goodsgroup gg on gg.id=g.id_goodsgroup
//							where r.rest_date::text like '".substr(Yii::app()->session['workdate'],0,7)."-01' and id_store=".Yii::app()->session['id_store']."
//						 ) as motion
//					group by ggid, ggname, gid, gname, price
//					having sum(quantity)!=0
//					order by 4,1,2";
		// echo '<pre>'.$sql_rest.'</pre>';
//		$rest = $connection->createCommand($sql_rest)->queryAll();


//		Utils::print_r($rest);
//		exit;
		$total = 0;
		foreach ($rest as $r) {
			$total += $r['price']*$r['rest'];
		}


		$count = count($rest);
//		$SqldataProvider = new CActiveDataProvider($rest, array(
//	    	'keyField'=>'gid',
//	    	'totalItemCount'=>$count,
//	    	'pagination'=>array('pageSize'=>5000,),
//		));

		$sort = new CSort;
		$sort->defaultOrder = 'name ASC';
		$sort->attributes = array('name', 'id', 'price', 'rest');

		$dataProvider = new CArrayDataProvider(
			$rest,
			array(
				'keyField'   => 'id',
				'pagination'=>false,
//				'pagination' => array(
//									'pageSize'=>3000,
//								),
				'sort' => $sort
			)
		);


	 	$this->controller->pageTitle = 'Остатки товара';
	 	$this->controller->render('rest', array('data'=>$dataProvider, 'total'=>$total));
	}
}