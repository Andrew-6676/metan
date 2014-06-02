<?php
	class PrintPDF extends CComponent
	{
        public $mpdf=null;
        public $outputPath=null;
    /*----------------------------------------------------------------------------------------------------------------*/
        function __construct($size='A4',$orient='P')
        {
            $this->outputPath = Yii::getPathOfAlias('webroot.public');
            $this->mpdf = new mpdf('utf-8', $size, '8', '', 10, 10, 7, 7, 10, 10); /*задаем формат, отступы и.т.д.*/
           // $this->mpdf->AddPage($orient); // Lanscape Portpait(def)
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

                $this->mpdf->WriteHTML($page); /*формируем pdf*/

                $this->mpdf->Output(/*'mpdf.pdf', 'I'*/);  //  - выдать на экран без сохранения
               // $this->mpdf->Output($this->outputPath.'/test.pdf', 'F');   // - сохранить в указанное место

               // return '<h3>URL to PDF file:<small><a href="http://localhost/metan_0.1/public/test.pdf">скачать</a>></small></h3>';
        }

	}
