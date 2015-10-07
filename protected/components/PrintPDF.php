<?php
	class PrintPDF extends CComponent
	{
        public $mpdf=null;
        public $outputPath=null;
    /*----------------------------------------------------------------------------------------------------------------*/
        function __construct($size='A4',$orient='P', $m = array(10,5,5,5,5,5), $double=false)
        {
            $this->outputPath = Yii::getPathOfAlias('webroot.public');
            //mpdf('','', 0, '', 15, 15, 16, 16, 9, 9, 'L');
	        //$efaultParams    = array( // More info: http://mpdf1.com/manual/index.php?tid=184
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
	        $this->mpdf = new mpdf('utf-8', $size, '8', 'dejavusans', $m[0], $m[1], $m[2], $m[3], $m[4], $m[5], ''); /*задаем формат, отступы и.т.д.*/

//        $this->mpdf->autoPageBreak = false;

	        if ($double) {
		        $this->mpdf->mirroMargins = true;
	        }

	        $this->mpdf->AddPage($orient); // Lanscape Portpait(def)
            $this->mpdf->charset_in = 'utf-8'; /*не забываем про русский, стандарт похоже utf8*/

        }

        public function getInfo(){
            return '-----begin getInfo<h1>Test string from PrintPDF</h1>'.Yii::getPathOfAlias('webroot.public').'<br>end getInfo-----';
        }

        public function printFromVar($page, $style=false)
        {
            // if ($style==true) {
            //     if (file_exists($style)){
            //         $stylesheet = file_get_contents($style); /*подключаем css если надо*/
            //         $this->mpdf->WriteHTML($stylesheet, 1);
            //     }
            // }

            // // echo $page.'<br>';
            // $this->mpdf->list_indent_first_level = 0;

            // $this->mpdf->WriteHTML($page); /*формируем pdf*/

            // //$this->mpdf->Output('mpdf.pdf', 'I');  //  - выдать на экран без сохранения
            // $this->mpdf->Output($this->outputPath.'/test.pdf', 'F');   // - сохранить в указанное место

            // return '<h3>URL to PDF file:<small><a href="http://localhost/metan_0.1/public/test.pdf">скачать</small></h3>';

        }
    /*----------------------------------------------------------------------------------------------------------------*/
        public function printFromURL($page='',$style=false)
        {
            /*  */
            //echo '<br><br>-----begin printFromURL<br>';
            //echo $style;
            // if ($style)
            // {
            //     //if (file_exists($style)){

            //         $stylesheet = file_get_contents($style); /*подключаем css если надо*/
            //         $this->mpdf->WriteHTML($stylesheet, 1);
            //         // echo $stylesheet;
            //     //}
            // }
            //exit;
                 // echo $page.'<br>';
                $page = file_get_contents($page);

                 // echo $page.'<br>';
               // $this->mpdf->list_indent_first_level = 0;



	            //$this->mpdf->keep_table_proportions = true;
	            //$this->mpdf->use_kwt = true;
	            //$this->mpdf->shrink_tables_to_fit = 2;


                $this->mpdf->WriteHTML($page); /*формируем pdf*/
//	            $this->mpdf->autoPageBreak = false;
                $this->mpdf->Output(/*'mpdf.pdf', 'I'*/);  //  - выдать на экран без сохранения
               // $this->mpdf->Output($this->outputPath.'/test.pdf', 'F');   // - сохранить в указанное место

               // return '<h3>URL to PDF file:<small><a href="http://localhost/metan_0.1/public/test.pdf">скачать</a>></small></h3>';
        }

	}
