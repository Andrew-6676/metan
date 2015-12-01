<?php

class printExpencedayAction extends CAction   /*---- PrintController ----*/
{
	public function run() {
		$rec_doc = Document::model()->findAll('doc_num = :dn and doc_date = :dd', array(':dn'=>0,'dd'=>$_GET['workdate']));
		$data['doc'] = $rec_doc;
		// $data['details'] = $rec_doc_data;
		$this->controller->render('expenceday', array('data'=>$data));
	}
}