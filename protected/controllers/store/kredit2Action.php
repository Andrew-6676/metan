<?php

class kredit2Action extends CAction   /*---- StoreController ----*/
{
	public function run()
	{

		/*--------------------------------------------------------------*/
		// данные для вывода
		// $res = Document::model()->with('documentdata')->findAll(array(
		// 												//'join'=>'inner join {{operation}} on {{operation}}.id=t.id_operation',
		// 												//'condition'=>'{{operation}}.operation<0 and doc_date<=\''.Yii::app()->session['workdate'].'\' and doc_date::text like \''.substr(Yii::app()->session['workdate'],0,7).'%\' and id_store='.Yii::app()->session['id_store'],
		// 												'condition'=>'id_doctype=2 and doc_date<=\''.Yii::app()->session['workdate'].'\' and doc_date::text like \''.substr(Yii::app()->session['workdate'],0,7).'%\' and id_store='.Yii::app()->session['id_store'],
		// 												'order'=>'doc_date desc, doc_num desc')
		// 												);

		$criteria = new CDbCriteria;
		// $criteria->join = 'inner join {{operation}} on {{operation}}.id=t.id_operation';
		$criteria->order = 'doc_date desc, doc_num desc';
		$criteria->addCondition('id_doctype = 12');
		$criteria->addCondition('id_operation = 54');
		$criteria->addCondition('id_store=' . Yii::app()->session['id_store']);
		$criteria->addCondition('doc_date<=\'' . Yii::app()->session['workdate'] . '\'');
		$criteria->addCondition('doc_date::text like \'' . substr(Yii::app()->session['workdate'], 0, 7) . '%\'');
//		$criteria->addCondition('doc_num != \'0\'');

		$res = Document::model()->with('documentdata')->findAll($criteria);

		$criteria->order ='';
		$criteria->select = 'sum(price*quantity) as price';
		$criteria->join = 'inner join {{document}} on {{document}}.id=t.id_doc';

		$sum = Documentdata::model()->find($criteria);

		//doc_num2>0 and
		// список операций
		$oper = Operation::model()->findAll(array('condition' => 'operation<0',
			'order' => 'name'));
		// следующий номер документа
		$sql = 'SELECT max(doc_num2)::INTEGER+1 FROM {{DOCUMENT}} d WHERE id_doctype=2 AND id_store=' . Yii::app()->session['id_store'] . ' AND doc_date::TEXT LIKE \'' . substr(Yii::app()->session['workdate'], 0, 4) . '%\'';
		$doc_num = Yii::app()->db->createCommand($sql)->queryScalar();
		if (!$doc_num) {
			$doc_num = 1;
		}

		$this->controller->pageTitle = 'Рассрочка';
		$this->controller->render('kredit2', array(
			'data' => $res,
			'oper' => $oper,
			'doc_num' => $doc_num,
			'mode' => 'kredit',
			'sum'  => $sum
		));
	}    // end run

	/*-----------------------------------------------------------------------------------*/
}