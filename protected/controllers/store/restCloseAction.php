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
		 		// добавлять ли 0 перед номером месяца
		 	if ($_POST['month'] < 9) {
		 		$o = '0';
		 	}
			if ($_POST['month'] < 10) {
				$o1 = '0';
			}

		 	if ($_POST['mode']=='close') {
		 				// дата нового месяца
		 		if ($_POST['month'] < 12) {
					$date = $_POST['year'].'-'.$o.($_POST['month']+1).'-01';
				} else {
					$date = ($_POST['year']+1).'-01-01';
				}
						// месяц из которого брать
				$month = $_POST['year'].'-'.$o1.$_POST['month'].'-%';

				$sql_del_rest = "delete from {{rest}} where rest_date='".$date."' and id_store=".Yii::app()->session['id_store'];
				/*$sql_add_rest = "insert into {{rest}} (id_store, id_goods, rest_date, quantity, price)
									select ".Yii::app()->session['id_store']." as id_store, gid as id_goods, '".$date."' as rest_date, sum(quantity)::real as quantity, price
									from (
										select g.id as gid, dd.quantity*o.operation as quantity, dd.price, 'd' as t
										from {{goods}} g
											inner join vgm_documentdata dd on g.id=dd.id_goods
											inner join vgm_document d on d.id=dd.id_doc
											inner join vgm_operation o on o.id=d.id_operation
										where d.doc_date::text like '".$month."' and id_store=".Yii::app()->session['id_store']."
											union
										select g.id as gid, r.quantity, r.price as price, 'r' as t
										from {{goods}} g
											inner join vgm_rest r on g.id=r.id_goods
										where r.rest_date::text like '".$month."' and id_store=".Yii::app()->session['id_store']."
									) as motion
									group by gid, price
									having sum(quantity)!=0
									order by 1";*/
			        // предыдущий запрос терял повторяющиеся строки
			    $store = Yii::app()->session['id_store'];

			    $sql_add_rest ="insert into {{rest}} (id_store, id_goods, rest_date, quantity, cost, markup, vat, price)
								select
									".Yii::app()->session['id_store']." as id_store,
									gid as id,
									'".$date."' as rest_date,
									sum(quantity)::real as quantity,
									max(cost) as cost,
									max(markup) as markup,
									max(vat) as vat,
									price
								from (
									select g.id as gid, dd.cost as cost, max(dd.markup) as markup, max(vat) as vat, sum(dd.quantity*o.operation) as quantity, dd.price, 'd' as t
									from vgm_goods g
									  inner join vgm_documentdata dd on g.id=dd.id_goods
									  inner join vgm_document d on d.id=dd.id_doc
									  inner join vgm_operation o on o.id=d.id_operation
									where d.doc_date<='".$date."' and d.doc_date::text like'".$month."' and id_store=".$store."
									group by gid, cost, price

										union

									select g.id as gid, r.cost as cost, r.markup as markup, r.vat as vat, r.quantity, r.price as price, 'r' as t
									from vgm_goods g
									  inner join vgm_rest r on g.id=r.id_goods
									where r.rest_date::text like '".$month."' and id_store=".$store."
									     ) as motion
									group by gid, price
									having sum(quantity)!=0
									order by 1";

			    $sql_kassa_del = "delete from {{kassa}} where kassa_date='".$date."' and id_store=".Yii::app()->session['id_store'];

				$sql_kassa_add = "insert into vgm_kassa (kassa_date, sum, id_store)
									(select '".$date."'::date, sum, id_store
									from vgm_kassa
									where id_store=".Yii::app()->session['id_store']." and kassa_date::text like '".$month."'
									order by kassa_date desc
									limit 1)";
				// echo '<pre>'.$sql_add_rest.'</pre>';
				$res = array('status'=>'unknown', 'data'=>array());

				$transaction = $connection->beginTransaction();
				try {
					$connection->createCommand($sql_del_rest)->execute();
					$connection->createCommand($sql_add_rest)->execute();
					$connection->createCommand($sql_kassa_del)->execute();
					$connection->createCommand($sql_kassa_add)->execute();
					$transaction->commit();
					$res['status'] = 'ok';
					$res['data']['post'] = $_POST;
					$res['data']['sql1'] = $sql_del_rest;
					$res['data']['sql2'] = $sql_add_rest;
					$res['data']['sql3'] = $sql_kassa_del;
					$res['data']['sql4'] = $sql_kassa_add;
				} catch (Exception $e) {
					$transaction->rollback();
					$res['status'] = 'error';
					$res['data']['err'] = $e->errorInfo;
				}
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