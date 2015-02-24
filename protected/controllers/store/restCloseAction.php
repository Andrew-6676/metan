<?php

class restCloseAction extends CAction   /*---- StoreController ----*/
{
	public function run(){
		if(Yii::app()->request->isAjaxRequest) {
			 // Utils::print_r($_POST);

		 	$connection = Yii::app()->db;
		 	$o = '';
		 		// добавлять ли 0 перед номером месяца
		 	if ($_POST['month'] <10) {
		 		$o = '0';
		 	}

		 	if ($_POST['mode']=='close') {
		 				// дата нового месяца
		 		if ($_POST['month'] < 12) {
					$date = $_POST['year'].'-'.$o.($_POST['month']+1).'-01';
				} else {
					$date = $_POST['year']+1.'-01-01';
				}
						// месяц из которого брать
				$month = $_POST['year'].'-'.$o.$_POST['month'].'-%';

				$sql_del_rest = "delete from {{rest}} where rest_date='".$date."' and id_store=".Yii::app()->session['id_store'];
				$sql_add_rest = "insert into {{rest}} (id_store, id_goods, rest_date, quantity, cost)
									select ".Yii::app()->session['id_store']." as id_store, gid as id_goods, '".$date."' as rest_date, sum(quantity)::real as quantity, price as cost
									from (
										select g.id as gid, dd.quantity*o.operation as quantity, dd.price, 'd' as t
										from {{goods}} g
											inner join vgm_documentdata dd on g.id=dd.id_goods
											inner join vgm_document d on d.id=dd.id_doc
											inner join vgm_operation o on o.id=d.id_operation
										where d.doc_date::text like '".$month."' and id_store=".Yii::app()->session['id_store']."
											union
										select g.id as gid, r.quantity, r.cost as price, 'r' as t
										from {{goods}} g
											inner join vgm_rest r on g.id=r.id_goods
										where r.rest_date::text like '".$month."' and id_store=".Yii::app()->session['id_store']."
									) as motion
									group by gid, price
									having sum(quantity)!=0
									order by 1";

				// echo '<pre>'.$sql_rest.'</pre>';
				$res = array('status'=>'unknown', 'data'=>array());

				$transaction = $connection->beginTransaction();
				try {
					$connection->createCommand($sql_del_rest)->execute();
					$connection->createCommand($sql_add_rest)->execute();
					$res['status'] = 'ok';
					$res['data']['post'] = $_POST;
					$res['data']['sql1'] = $sql_del_rest;
					$res['data']['sql2'] = $sql_add_rest;
				} catch (Exception $e) {
					$transaction->rollback();
					$res['status'] = 'error';
					$res['data']['err'] = $e->errorInfo;
				}
				$transaction->commit();
			}

			if ($_POST['mode']=='check') {

				if ($_POST['month']>8) {
					$m = ($_POST['month']+1);
				} else {
					if ($_POST['month'] == 1) {
						$m = 12;
						$_POST['year']--;
					} else {
						$m = $o.($_POST['month']+1);
					}
				}

				$sql_count = 'select count(*) from {{rest}} where rest_date::text like \''.$_POST['year'].'-'.$m.'-%\' and id_store='.Yii::app()->session['id_store'];
				if ($connection->createCommand($sql_count)->queryScalar() > 0) {
					$res['status'] = 'ok';
				} else {
					$res['status'] = 'no';
				}
			}

			echo json_encode($res);
			// print_r($res);

			exit;
		}



	 	$this->controller->pageTitle = 'Закрытие месяца';
	 	$this->controller->render('restClose');
	}
}