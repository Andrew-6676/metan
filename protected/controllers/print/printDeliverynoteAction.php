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
//
//	    $efaultParams    = array( // More info: http://mpdf1.com/manual/index.php?tid=184
//                        'mode'              => '', //  This parameter specifies the mode of the new document.
//                        'format'            => 'A4', // format A4, A5, ...
//                        'default_font_size' => 0, // Sets the default document font size in points (pt)
//                        'default_font'      => '', // Sets the default font-family for the new document.
//                        'mgl'               => 15, // margin_left. Sets the page margins for the new document.
//                        'mgr'               => 15, // margin_right
//                        'mgt'               => 16, // margin_top
//                        'mgb'               => 16, // margin_bottom
//                        'mgh'               => 9, // margin_header
//                        'mgf'               => 9, // margin_footer
//                        'orientation'       => 'L', // landscape or portrait orientation
//                    );
//
//	    $mPDF1=Yii::app()->ePdf->mpdf('','', 0, '', 15, 15, 16, 16, 9, 9, 'L');
//
//	    $mPDF1->AddPage('L');
//	    $stylesheet1 = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/print/report.css');
//	    $stylesheet2 = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/print/delivery.css');
//
//	    $mPDF1->WriteHTML($stylesheet1, 1);
//	    $mPDF1->WriteHTML($stylesheet2, 1);
//
//		$mPDF1->WriteHTML($this->controller->renderPartial('deliverynote', array('data'=>$data), true));
//
//	    $mPDF1->Output();
    }
}