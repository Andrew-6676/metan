<?php

class expense_dayAction extends CAction   /*---- StoreController ----*/
{
   public function run()
	{

		 if(Yii::app()->request->isAjaxRequest) {
			//print_r($_POST);
			// exit;
				// сохранить расход в БД
			if(isset($_GET['action']) && $_GET['action']=='check') {
				// $res['newRowsCount'] = Document::model()->count("id in ".$_GET['idArr']."and doc_num2=0 and doc_date='".Yii::app()->session['workdate']."'");
				// $res['rowsData'] = Document::model()->findAllBySql("select array_to_string(array(select id from {{document}} "." where doc_num2=0 and doc_date='".Yii::app()->session['workdate']."'), ',')");
				// $res['rowsData'] = Document::model()->findAll(array(
				// 						'select'=>'id',
				// 						'condition' => "doc_num2=0 and doc_date='".Yii::app()->session['workdate']."'",
				// 				));

				$connection = Yii::app()->db;
				$sql = "select array_to_string(array(select id
						from {{document}}
						where doc_num2=0
								and doc_num='0'
								and id_doctype=2
								and doc_date='".Yii::app()->session['workdate']."'
								and id_store=".Yii::app()->session['id_store']."), ',') as data";
				$rowsData = $connection->createCommand($sql)->queryAll();

				$dbData = explode(',', $rowsData[0]['data']);
				$userData = array();
				if (isset($_GET['idArr'])) {
					$userData = $_GET['idArr'];
				}
				// Utils::print_r($dbData);
				// Utils::print_r($userData);
				$res = array();
				// $res['newDataExist'] = false;
				$res['delRows'] = Null;
				$res['newRows'] = Null;
				foreach ($userData as $val) {
					if (!in_array ($val, $dbData)) {
						// удалённая запись
						$res['delRows'][] = $val;
					}
				}
				foreach ($dbData as $val) {
					if (!in_array ($val, $userData)) {
						// новая запись
						$res['newRows'][] = $val;
					}
				}
				$src = array(
					51=>'nal_30.png',
					52=>'',
					53=>'',
					54=>'kredit_30.png',
					55=>'',
					56=>'karta_30.png',
				);
				$newRows = Document::model()->with('documentdata')->findAllByPk($res['newRows']);
				$arr = array();
				foreach ($newRows as $document) {
					$arr[$document->id][] = $document->id;
					$arr[$document->id][] = $document->documentdata[0]->id_goods;
					//$arr[$document->id][] = $document->documentdata[0]->idGoods->name;
					$arr[$document->id][] = CHtml::link($document->documentdata[0]->idGoods->name, '#', array('class'=>'goodscart','gid'=>$document->documentdata[0]->id_goods) );
					$arr[$document->id][] = $document->documentdata[0]->quantity;
					$arr[$document->id][] = number_format($document->documentdata[0]->price, '2','.','`');
					$arr[$document->id][] = number_format($document->documentdata[0]->price*$document->documentdata[0]->quantity, '2','.','`');
					$arr[$document->id][] = array($document->id_operation, '<img alt="" title="'.$document->idOperation->name.'" src="/metan_0.1/images/'.$src[$document->id_operation].'">', $document->paymentorder, $document->prim);
					$arr[$document->id][] = $document->for;
				}

				// Utils::print_r($arr);
				$res['newData'] = $arr;
				// $res['userData'] = $_GET['idArr'];
				// $res['dbData'] = $dbData;

				// if ($res['newData']) {$res['newDataExist'] = true;}

				echo json_encode($res);

				Yii::app()->end();
				// exit;
			}       // if(isset($_POST['new_expense']))

			echo 'Неправильный запроc';
			Yii::app()->end();
		 }       // // if(Yii::app()->request->isAjaxRequest)

		$criteria = new CDbCriteria;

		$criteria->addCondition('id_store='.Yii::app()->session['id_store']);
		$criteria->addCondition('doc_date=\''.Yii::app()->session['workdate'].'\'');
		$criteria->addCondition('id_doctype <> 3');
		$criteria->addCondition('id_doctype <> 1');
		$criteria->addCondition('id_doctype = 2');
		$criteria->addCondition('doc_num = \'0\'');
		$criteria->addCondition('doc_num2 = 0');
		$criteria->order ='t.date_insert desc, t.id';

		$q_model = Document::model()->with('documentdata')->findAll($criteria);

			// список операций
		$oper = Operation::model()->findAll(array('condition'=>'operation<0',
												  'order'=>'name'));

		$this->controller->pageTitle = 'Расход за день ('.date('d.m', strtotime(Yii::app()->session['workdate'])).')';
		$this->controller->render('expense_day', array(
									'data'=>$q_model,
//									'day_sum'=>$day_sum,
									'oper'=>$oper,
//									'tmp'=>$gr,
									// 'doc_num'=>$doc_num
								 ));
	}	// end run
	/*---------------------------------------------------------------------------------------*/
}	// end expense_dayAction