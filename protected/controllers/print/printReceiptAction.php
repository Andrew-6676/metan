<?php

class printReceiptAction extends CAction   /*---- PrintController ----*/
{
    // public function run($rep, $id_doc, $id_store=0, $workdate='2000-01-01'){
    public function run() {
      //  Utils::print_r($_GET);
        //echo "receipt doc";

        $rec_doc = Document::model()->findByPK($_GET["id"]);
        $rec_doc_data = Documentdata::model()->with('idGoods')->findAll('id_doc=:id_doc', array(':id_doc'=>$_GET["id"]));
        $data['doc'] = $rec_doc;
        $data['details'] = $rec_doc_data;
     //  Utils::print_r($rec_doc_data );
       // $this->controller->render('receipt', array('workdate'=>$workdate, 'id_store'=>$id_store, 'data'=>$receipt_doc));


        $this->controller->render('reestr', array('data'=>$data));
    }
}