<?php

class printInvoiceAction extends CAction   /*---- PrintController ----*/
{
    // public function run($rep, $id_doc, $id_store=0, $workdate='2000-01-01'){
    public function run() {
	    $rec_doc = Document::model()->findByPK($_GET["id"]);
	    $rec_doc_data = Documentdata::model()->with('idGoods')->findAll(
		    array(
			    'condition'=>'id_doc='.$_GET["id"],
			    'order' => 't.id'
		    )
	    );


	    $data = array('rec_doc'=>$rec_doc, 'rec_doc_data'=>$rec_doc_data);

	    $this->controller->render('invoice', array('data'=>$data));
    }
}