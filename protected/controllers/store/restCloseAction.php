<?php

class restCloseAction extends CAction   /*---- StoreController ----*/
{
	public function run(){
		if(Yii::app()->request->isAjaxRequest) {
			// Utils::print_r($_POST);

		 	$connection = Yii::app()->db;

			$date = substr(Yii::app()->session['workdate'],0,7).'-01';
			$new_month = substr(Yii::app()->session['workdate'],0,7).'-%';

			$sql_del_rest = "delete from vgm_rest where rest_date='".$date."' and id_store=".Yii::app()->session['id_store'];
			$sql_add_rest = "insert into vgm_rest (id_store, id_goods, rest_date, quantity, cost)
								select ".Yii::app()->session['id_store']." as id_store, gid as id_goods, '".$date."' as rest_date, sum(quantity)::real as quantity, price as cost
								from (
									select g.id as gid, dd.quantity*o.operation as quantity, dd.price, 'd' as t
									from vgm_goods g
										inner join vgm_documentdata dd on g.id=dd.id_goods
										inner join vgm_document d on d.id=dd.id_doc
										inner join vgm_operation o on o.id=d.id_operation
									where d.doc_date::text like '".$new_month."' and id_store=".Yii::app()->session['id_store']."
										union
									select g.id as gid, r.quantity, r.cost as price, 'r' as t
									from vgm_goods g
										inner join vgm_rest r on g.id=r.id_goods
									where r.rest_date::text like '".$new_month."' and id_store=".Yii::app()->session['id_store']."
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
				$res['data'] = $_POST;
			} catch (Exception $e) {
				$transaction->rollback();
				$res['status'] = 'error';
				$res['data']['err'] = $e->errorInfo;
			}
			$transaction->commit();

			echo json_encode($res);
			// print_r($res);

			exit;
		}



	 	$this->controller->pageTitle = 'Закрытие месяца';
	 	$this->controller->render('restClose');
	}
}