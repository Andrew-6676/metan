<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 29.09.15
 * Time: 11:48
 */

class svodDayAction extends CAction   /*---- StoreController ----*/
{
	public function run()
	{

		$criteria = new CDbCriteria;

		$criteria->addCondition('id_store='.Yii::app()->session['id_store']);
		$criteria->addCondition('doc_date=\''.Yii::app()->session['workdate'].'\'');
		$criteria->addCondition('id_doctype <> 3'); // счёт-фактура
		$criteria->addCondition('id_doctype <> 1'); // приход
		$criteria->order ='doc_date desc, doc_num desc';

		/* сводная таблица по расходу за день */
		$day_sum = Array(-1=>0, 1=>0, 2=>0, 3=>0);
		$gr = array();

		$s_model = Document::model()->with('documentdata')->findAll($criteria);

		foreach ($s_model as $document) {
			$sum = $document->documentdata[0]->price*$document->documentdata[0]->quantity * (-$document->operation->operation);
			$day_sum[$document->for] += $document->documentdata[0]->price*$document->documentdata[0]->quantity;

			if (!isset($gr[$document->id_operation])) {
				$gr[$document->id_operation] = array(0 => $sum);
				$gr[$document->id_operation][$document->for] = $sum;
			} else {
				$gr[$document->id_operation][0] += $sum;
				if (!isset($gr[$document->id_operation][$document->for])) {
					$gr[$document->id_operation][$document->for] = $sum;
				} else {
					$gr[$document->id_operation][$document->for] += $sum;
				}
			}
		}

		$this->controller->renderPartial('_svod_day', array(
			'data' => $gr,
		));

	}
}