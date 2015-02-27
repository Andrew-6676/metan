<?php

class expense_dayAction extends CAction   /*---- StoreController ----*/
{
   public function run()
	{

		if(Yii::app()->request->isAjaxRequest) {
			//print_r($_POST);
			// exit;
				// сохранить расход в БД
			if(isset($_POST['action']) && $_POST['action']=='check') {
				$res['newRowsCount'] = Document::model()->count("id>".$_POST['lastId']."and doc_num2=0 and doc_date='".Yii::app()->session['workdate']."'");
				$res['rowsData'] = Document::model()->findAll("id>".$_POST['lastId']."and doc_num2=0 and doc_date='".Yii::app()->session['workdate']."'");
				$res['rowsData'] = CHtml::listData( $res['rowsData'], 'id' , 'name');
				// yii\helpers\ArrayHelper::getColumn(MyModel::find()->all(), 'name'));;

				echo json_encode($res);
				Yii::app()->end();
			}       // if(isset($_POST['new_expense']))

			echo 'Неправильный запроc';
			Yii::app()->end();
		}       // // if(Yii::app()->request->isAjaxRequest)

		// $res = Document::model()->with('documentdata')->findAll(array(
		// 												//'join'=>'inner join {{operation}} on {{operation}}.id=t.id_operation',
		// 												//'condition'=>'{{operation}}.operation<0 and doc_date<=\''.Yii::app()->session['workdate'].'\' and doc_date::text like \''.substr(Yii::app()->session['workdate'],0,7).'%\' and id_store='.Yii::app()->session['id_store'],
		// 												'condition'=>'id_doctype=2 and doc_date<=\''.Yii::app()->session['workdate'].'\' and doc_date::text like \''.substr(Yii::app()->session['workdate'],0,7).'%\' and id_store='.Yii::app()->session['id_store'],
		// 												'order'=>'doc_date desc, doc_num desc')
		// 												);
		// 	// список операций
		// $oper = Operation::model()->findAll(array('condition'=>'operation<0',
		// 										  'order'=>'name'));
		// 	// следующий номер документа
		// $sql = 'SELECT max(doc_num2)::integer+1 FROM {{document}} d where id_doctype=2 and id_store='.Yii::app()->session['id_store'];
		// $doc_num = Yii::app()->db->createCommand($sql)->queryScalar();

		$criteria = new CDbCriteria;
		$criteria->join = 'inner join {{operation}} on {{operation}}.id=t.id_operation';
		$criteria->order ='doc_date desc, doc_num desc';
		$criteria->addCondition('id_doctype = 2');
		$criteria->addCondition('id_store='.Yii::app()->session['id_store']);
		$criteria->addCondition('doc_date=\''.Yii::app()->session['workdate'].'\'');
		$criteria->addCondition('doc_num2 = 0');

		$q_model = Document::model()->with('documentdata')->findAll($criteria);

			// список операций
		$oper = Operation::model()->findAll(array('condition'=>'operation<0',
												  'order'=>'name'));

		$this->controller->pageTitle = 'Расход за день';
		$this->controller->render('expense_day', array(
									'data'=>$q_model,
									'oper'=>$oper,
									// 'doc_num'=>$doc_num
								 ));
	}	// end run
	/*---------------------------------------------------------------------------------------*/
}	// end expense_dayAction