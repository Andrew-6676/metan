<?php

class MainAjaxController extends CController
{
/* ---------------------------------------------------------------------- */
	public function ActionsetWorkDate($date)
	{
		// $connection=Yii::app()->db;
		if(Yii::app()->request->isAjaxRequest) {
			//echo $_POST['sql'];
			// return $connection->createCommand($_POST['sql'])->execute();
			// exit;
			// переприсвоить переменную Yii::app()->session['workdate']
			Yii::app()->session['workdate'] = $date;
			echo Yii::app()->session['workdate'];
		} else {
			echo 'error - no data';
		}
	}
/*------------------------------------------------------------------------*/
	public function ActionGetGoodsName($term,$f) {
			// выбор товаров для дропбокса в расходе (выбрать по хорошему надо из остатков + из прихода)
		// if(Yii::app()->request->isAjaxRequest) {
				// запрос на выборку наименований из БД по шаблону
			//$sql = "SELECT string_agg(concat('name: ',name), ',' ) FROM vgm_goods WHERE upper(name) like upper('".$term."%')";
			$sql = "SELECT id, name FROM vgm_goods WHERE upper(".$f."::text) like upper('".$term."%')";
			//echo $sql;
			$connection = Yii::app()->db;
			$elements = $connection->createCommand($sql)->queryAll();
			// echo '<pre>';
			// print_r($elements);
			// echo '</pre>';
			//$s = "[".$elements."]";
			$s = json_encode($elements);
			echo $s;

		// } else {
		// 	echo 'error - no data';
		// }
	}

/*------------------------------------------------------------------------*/
	public function ActionGetGoodsNameFromRest($term,$f) {
		$connection = Yii::app()->db;

		$sql_rest = "select gid as id, gname as name, price, sum(quantity)::real as rest
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
					having sum(quantity)!=0 and upper(".$f."::text) like upper('".$term."%')
					order by 4,1,2";
		// echo '<pre>'.$sql_rest.'</pre>';
		$rest = $connection->createCommand($sql_rest)->queryAll();

		$res = json_encode($rest);
		echo $res;
	}

}