<?php
// Utils::print_r($data);
    $this->addCSS('print/expenceday.css');
    $this->addCSS('print/report.css');
    $rec_doc = $data['doc'];

    $d = explode('-',$_GET['workdate']);
    $d = $d[2].' . '.$d[1].' . '.$d[0];
?>

<div class="rep_wrapper">
	<div class="page p">
		<div class="report_title">Расход товаров за <?php echo $d; ?> </div>


        <table>
	        <thead>
		        <tr>
			        <th>Код</th>
			        <th>Наименование</th>
			        <th>Ед.изм.</th>
			        <th>Кол-во</th>
			        <th>Цена</th>
			        <th>Сумма</th>
		        </tr>
	        </thead>
            <?php
                $i=0;
                foreach ($rec_doc as $d_row) {
                        $row = $d_row->documentdata[0];
                        // echo ++$i.'<br>';
                      // Utils::print_r(($row->id));
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
                        <td class="r">
                            <?php print ($row->quantity); ?>
                        </td>
                         <td class="r">
                            <?php print number_format(($row->price), '2','.'," "); ?>
                         </td>
                         <td class="r">
                             <?php print number_format(($row->price*$row->quantity), '2','.'," "); ?>
                         </td>
                     </tr>
                <?php  } ?>
       </table>

	</div>
</div>