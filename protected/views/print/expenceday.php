<?php
// Utils::print_r($data);
    $this->addCSS('print/expenceday.css');
    $this->addCSS('print/report.css');
    $rec_doc = $data['doc'];
    //$rec_doc_data = $data['details'];
//  //     // print_r($data);

    $d = explode('-',$_GET['workdate']);
    $d = $d[2].' . '.$d[1].' . '.$d[0];
    // Utils::print_r(count($rec_doc));
    // exit;
?>
    <div class='header'>Расход товаров за <?php echo $d; ?> </div>
        <table border='1'>
            <?php
                $i=0;
                foreach ($rec_doc as $d_row) {
                        $row = $d_row->documentdata[0];
                        // echo ++$i.'<br>';
                       Utils::print_r(($row->id));
                // }
                // exit;
                    ?>
                    <tr>
                        <td>
                            <?php print ($row->idGoods->id); ?>
                        </td>
                        <td>
                            <?php print ($row->idGoods->name); ?>
                        </td>
                        <td>
                            <?php print Unit::model()->findByPK($row->idGoods->id_unit)->name; ?>
                        </td>
                        <td>
                            <?php print ($row->quantity); ?>
                        </td>
                        <td>
                            <?php print ($row->cost); ?>
                        </td>
                        <td>
                        </td>
                        <td>
                            <?php print number_format($row->cost,'0','.'," "); ?>
                        </td>
                        <td>
                            <?php print ($row->markup); ?>
                        </td>
                        <td>
                            <?php print number_format((($row->markup/100+1)*$row->cost),'0','.',' '); ?>
                        </td>
                        <td>
                            <?php print (($row->markup/100+1)*$row->cost*$row->quantity); ?>
                         </td>
                         <td>
                            <?php print ($row->vat); ?>
                         </td>
                         <td>
                            <?php  print number_format((($row->vat/100+1)*($row->markup/100+1)*$row->cost*$row->quantity),'0','.'," "); ?>
                         </td>
                         <td>
                            <?php print number_format((($row->vat/100+1)*($row->markup/100+1)*$row->cost),'0','.'," "); ?>
                         </td>
                         <td>
                            <?php print number_format(($row->price),'0','.'," "); ?>
                         </td>
                         <td>
                             <?php print number_format(($row->price*$row->quantity),'0','.'," "); ?>
                         </td>
                     </tr>
                <?php  } ?>
       </table>