<?php
    $this->addCSS('print/reestr.css');
    $this->addCSS('print/report.css');
    $rec_doc = $data['doc'];
    $rec_doc_data = $data['details'];
     // print_r($data);

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
                            print number_format($row->cost,'0','.'," ");
                        echo "</td>";
                        echo "<td>";
                            print ($row->markup);
                        echo "</td>";
                        echo "<td>";
                            print number_format((($row->markup/100+1)*$row->cost),'0','.',' ');
                        echo "</td>";
                        echo "<td>";
                            print (($row->markup/100+1)*$row->cost*$row->quantity);
                        echo "</td>";
                        echo "<td>";
                            print ($row->vat);
                        echo "</td>";
                        echo "<td>";
                            print print number_format((($row->vat/100+1)*($row->markup/100+1)*$row->cost*$row->quantity),'0','.'," ");
                        echo "</td>";
                        echo "<td>";
                            print print number_format((($row->vat/100+1)*($row->markup/100+1)*$row->cost),'0','.'," ");
                        echo "</td>";
                        echo "<td>";
                            print print number_format(($row->price),'0','.'," ");
                        echo "</td>";
                        echo "<td>";
                             print number_format(($row->price*$row->quantity),'0','.'," ");
                        echo "</td>";
                    echo "</tr>";
                }
        echo "</table>";