<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 03.09.15
 * Time: 8:37
 */


class selectionAction extends CAction   /*---- GoodsController ----*/
{
	public function run(){

//		$this->controller->pageTitle = 'Магазин "Метан"';
		$data = $_GET['id'];

		$dataProvider = new CActiveDataProvider(
			'Rest',
			array(
				'criteria' => array(
					'condition' => 'id_goods in ('.$data.') and date_part(\'month\', rest_date)='.substr(Yii::app()->session['workdate'],5,2),
				),
				'pagination'=>false,
//				'sort' => $sort
			)
		);


		$connection = Yii::app()->db;
		$store = Yii::app()->session['id_store'];
		$date = Yii::app()->session['workdate'];

		// в предыдущем запросе не учитывалось то, что товар мог был оплачен двумя суммами (часть нал, часть безнал)
		// часть товара оплаченная налом помечена в поле partof - в количество такой товар считать не надо, цену надо брать из прихода
		//TODO: цену выбрать только из прихода и остатков (никаких счёт-фактур)
		$sql_rest = "select gid as id, gname as name, max(cost) as cost, max(markup) as markup, max(vat) as vat,
						COALESCE((select price from {{rest}} where id_goods=gid and rest_date='".substr($date,0,7)."-01' order by rest_date desc limit 1), (select price from {{documentdata}} dd inner join {{document}} d on d.id=dd.id_doc where id_goods=gid and id_operation=33 and doc_date<='".$date."' and doc_date>='".substr($date,0,7)."-01' order by d.id desc limit 1)) as price,
						 sum(quantity)::real as rest,
						(select COALESCE(sum(quantity), 0)
						from vgm_documentdata dd
							inner join vgm_document d on d.id=dd.id_doc
						where d.id_doctype=3 and id_goods=gid and  d.doc_date<='".$date."' and d.doc_date>='".substr($date,0,7)."-01' and id_store=".$store." and link<0) as inv
					from (
						select g.id as gid, g.name as gname, dd.cost as cost, max(dd.markup) as markup, max(vat) as vat, sum(dd.quantity*o.operation) as quantity, 'd' as t
						from vgm_goods g
						  inner join vgm_documentdata dd on g.id=dd.id_goods and dd.partof<0
						  inner join vgm_document d on d.id=dd.id_doc and d.active
						  inner join vgm_operation o on o.id=d.id_operation
						where d.doc_date<='".$date."' and d.doc_date>='".substr($date,0,7)."-01' and id_store=".$store."
						group by gid, gname, cost

							union

						select g.id as gid, g.name as gname,  r.cost as cost, r.markup as markup, r.vat as vat, r.quantity, 'r' as t
						from vgm_goods g
						  inner join vgm_rest r on g.id=r.id_goods
						where r.rest_date='".substr($date,0,7)."-01' and id_store=".$store."
					) as motion
					group by gid, gname, price
					having gid in (".$data.")
					order by 1, 2";

		$rest = $connection->createCommand($sql_rest)->queryAll();
		//Utils::print_r($rest);

		$dataProvider = new CArrayDataProvider(
			$rest,
			array(
				'keyField'   => 'gid',
				'pagination'=>false,
//				'sort' => $sort
			)
		);


		$this->controller->render('selection', array('data'=>$dataProvider));
	}
}