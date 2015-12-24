<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 26.08.15
 * Time: 14:46
 */

class printPricelabelAction extends CAction   /*---- PrintController ----*/
{
	// public function run($rep, $id_doc, $id_store=0, $workdate='2000-01-01'){
	public function run() {
		//  Utils::print_r($_GET);
		//echo "receipt doc";

		$rec_doc = Document::model()->findByPK($_GET["id"]);
		$rec_doc_data = Documentdata::model()
							->with('idGoods')
							->findAll(
								array(
									'condition'=>'id_doc='.$_GET["id"],
									'order'=>'t.id'
								));

		$data['doc'] = $rec_doc;
		$data['details'] = $rec_doc_data;
		//  Utils::print_r($rec_doc_data );
		// $this->controller->render('receipt', array('workdate'=>$workdate, 'id_store'=>$id_store, 'data'=>$receipt_doc));


		$this->controller->render('pricelabel', array('data'=>$data));
	}
}