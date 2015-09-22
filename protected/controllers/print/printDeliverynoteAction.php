<?php

class printDeliverynoteAction extends CAction   /*---- PrintController ----*/
{
    // public function run($rep, $id_doc, $id_store=0, $workdate='2000-01-01'){
    public function run() {

//	    if(Yii::app()->request->isAjaxRequest) {
//		    parse_str($_POST['data']['params']);
//		    $_POST['data']['params'] = $form_ttn;
//		    echo json_encode(print_r($_POST, true));
//		    Yii::app()->end();
//	    }

	    $rec_doc = Document::model()->findByPK($_GET["id"]);
	    $rec_doc_data = Documentdata::model()->with('idGoods')->findAll('id_doc=:id_doc', array(':id_doc'=>$_GET["id"]));


	    $data = array('rec_doc'=>$rec_doc, 'rec_doc_data'=>$rec_doc_data);

	    $this->controller->render('deliverynote', array('data'=>$data));
    }
}