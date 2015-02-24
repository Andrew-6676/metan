<?php

class printReceiptAction extends CAction   /*---- PrintController ----*/
{
    // public function run($rep, $id_doc, $id_store=0, $workdate='2000-01-01'){
    public function run() {
      //  Utils::print_r($_GET);
        //echo "receipt doc";

        $rec_doc = Document::model()->findByPK($_GET["id"]);
        $rec_doc_data = Documentdata::model()->with('idGoods')->findAll('id_doc=:id_doc', array(':id_doc'=>$_GET["id"]));
     //  Utils::print_r($rec_doc_data );
       // $this->controller->render('receipt', array('workdate'=>$workdate, 'id_store'=>$id_store, 'data'=>$receipt_doc));
        echo 'РЕЕСТР РОЗНИЧНЫХ ЦЕН ПУ "ВИТЕБСКГАЗ" СКЛАД №2<br>';
        $d = explode('-',$rec_doc->doc_date);
        $d = $d[2].' . '.$d[1].' . '.$d[0];
        echo 'РЕЕСТР 1     Приложение к накладной № '.$rec_doc->doc_num.' от '.$d;
        echo "<table border='1'>";
                foreach ($rec_doc_data as $row) {
                    echo "<tr>";
                        echo "<td>";
                            print ($row->idGoods->id);
                        echo "</td>";
                        echo "<td>";
                            print ($row->idGoods->name);
                        echo "</td>";
                        echo "<td>";
                           // print ($row->idGoods->id_unit);
                            print Unit::model()->findByPK($row->idGoods->id_unit)->name;
                        echo "</td>";
                        echo "<td>";
                            print ($row->quantity);
                        echo "</td>";
                        echo "<td>";
                            print ($row->cost);
                        echo "</td>";
                        echo "<td>";
                        echo "</td>";
                        echo "<td>";
                            print ($row->cost);
                        echo "</td>";
                        echo "<td>";
                            print ($row->markup);
                        echo "</td>";
                        echo "<td>";
                            print (($row->markup/100+1)*$row->cost);
                        echo "</td>";
                        echo "<td>";
                            print (($row->markup/100+1)*$row->cost*$row->quantity);
                        echo "</td>";
                        echo "<td>";
                            print ($row->vat);
                        echo "</td>";
                        echo "<td>";
                            print (($row->vat/100+1)*($row->markup/100+1)*$row->cost*$row->quantity);
                        echo "</td>";
                        echo "<td>";
                            print (($row->vat/100+1)*($row->markup/100+1)*$row->cost);
                        echo "</td>";
                        echo "<td>";
                            print ($row->price);
                        echo "</td>";
                        echo "<td>";
                            print ($row->price*$row->quantity);
                        echo "</td>";
                    echo "</tr>";
                }
        echo "</table>";
    }
}