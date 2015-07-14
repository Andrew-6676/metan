<?php

class printExpencedayAction extends CAction   /*---- PrintController ----*/
{
	public function run() {
		// Utils::print_r($_GET);
		// echo 'asdf';
		// echo "receipt doc";
		$rec_doc = Document::model()->findAll('doc_num = :dn and doc_date = :dd', array(':dn'=>0,'dd'=>$_GET['workdate']));
		// $id = $rec_doc[0]->id;
		// $rec_doc_data = Documentdata::model()->findAll('id_doc=:id_doc', array(':id_doc'=>$id));
		$data['doc'] = $rec_doc;
		// $data['details'] = $rec_doc_data;
		$this->controller->render('expenceday', array('data'=>$data));
	}
}