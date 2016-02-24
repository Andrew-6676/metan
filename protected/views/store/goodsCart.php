<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 21.08.15
 * Time: 12:14
 */

//Utils::print_r($data['goods']->rest0);
$this->addCSS('store/goodasCart.css');

$op = '';
$dt = '';
$dn = '';

$diff_price = false;
?>
<h3 class="capt hidden" >
	<?php
		echo $data['goods']->name;
		echo ' ('.$data['goods']->id.')';
	?>
</h3>

<!--<table class="motion">-->
<!--	<tr class="capt">-->
<!--		<td colspan="4"></td>-->
<!--	</tr>-->
<?php
	echo 'Остаток на '. Utils::format_date(substr(Yii::app()->session['workdate'],0,7).'-01').': <b>'.$data['goods']->rest0.'</b>';

	if ($data['goods']->rest0price > 0) {
		echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small> цена: '.number_format($data['goods']->rest0price,'0','.','&nbsp;').'</small>';
	}
	//Utils::print_r($data['goods']->rest0price);
	if (count($data['m']) == 0) {
		echo "<div class='message'>Нет движения</div>";

		echo "<script>
				$('.ui-dialog-title').text($('h3.capt').text());
				$('h3.capt').hide();
			</script>";
		return;
	}
?>

<table class="std cart">
	<thead>
		<tr>
			<th>Дата</th>
			<th>№ док-та</th>
			<th>Операция</th>
			<th>Кол-во</th>
<!--			<th>Цена</th>-->
			<th>Сумма</th>
			<th>Остаток</th>
		</tr>
	</thead>
	<tbody>
	<!-- tr>
		<td><?php echo Utils::format_date(substr(Yii::app()->session['workdate'],0,7).'-01') ?></td>
		<td class="c">Остаток</td>
		<td><?php echo $data['goods']->rest0; ?></td>
		<td><?php //echo $data['goods']->rest0->price; ?></td>
		<td><?php echo $data['goods']->rest0; ?></td>
	</tr -->

	<?php
	$links = array(
		'1'  => '/store/invoice',
		'2'  => '/store/return',
		'33' => '/store/receipt',
		'51' => '/store/expense_day',
		'52' => '/store/expense',
		'54' => '/store/expense',
		'56' => '/store/expense_day',
	);
	$rest = $data['goods']->rest0;
	$po = -1;
	foreach ($data['m'] as $doc) {
		foreach ($doc->documentdata as $row) {
			$m='';
			if ($doc->operation->operation < 0 ) {
				$m = 'minus';
			}

			if ($row->partof > 0 ) {
				$rq = 0;
				$po = $row->partof;
				$class = ' class="partof" ';
				$pr = number_format($row->price*$row->quantity,'0','.','&nbsp;').' <small>('.number_format(Goods::model()->findByPK($row->id_goods)->price,'0','.','&nbsp;').')</small>';
			} else {
				$pr = number_format($row->price*$row->quantity,'0','.','&nbsp;');
				$rq = $row->quantity;
				$class = '';
				$rest += $row->quantity*$doc->operation->operation;
			}

			if ($doc->id == $po) {
				$pr = number_format($row->price*$row->quantity,'0','.','&nbsp;').' <small>('.number_format(Goods::model()->findByPK($row->id_goods)->price,'0','.','&nbsp;').')</small>';
			}

			if (!$diff_price && $data['goods']->rest0price !=0 && $data['goods']->rest0price != $row->price) {
				echo "<br><br><span style='color: red; font-size: 1.1em;'>Цена начального остатка отличается от цены в документах!</span><br><br>";
				$diff_price = true;
			}

			$tr = '<tr '.$class.'>';
			$tr .=     '<td>';
			$tr .=         Utils::format_date($doc->doc_date);
			$tr .=     '</td>';
			$tr .=     '<td>';
			$tr .=         $doc->doc_num==0?'':$doc->doc_num;
			$tr .=     '</td>';
			$tr .=     '<td class="c">';
			$tr .=         CHtml::link($doc->operation->name, Yii::app()->params['rootFolder'].$links[$doc->id_operation], array('title'=>'Документ № '.$doc->doc_num));
			$tr .=     '</td>';
			$tr .=     '<td  class="'.$m.'">';
			$tr .=         $rq;
			$tr .=     '</td>';
//				$tr .=     '<td  class="'.$m.'">';
//				$tr .=         '<small>'.number_format($row->cost,'0','.','&nbsp;').'</small><br>';
//				$tr .=         '<small>'.number_format($row->markup,'0','.','&nbsp;').'</small><br>';
//				$tr .=         '<small>'.number_format($row->price,'0','.','&nbsp;').'</small><br>';
//				$tr .=     '</td>';
			$tr .=     '<td  class="'.$m.'">';
			$tr .=         $pr;
			$tr .=     '</td>';
			$tr .=     '<td  class="'.$m.'">';
			$tr .=         $rest;
			$tr .=     '</td>';
			$tr .= '</tr>';
			echo $tr;
		}
	}
	?>
	</tbody>
</table>


<?php
echo 'Остаток на '.Utils::format_date(Yii::app()->session['workdate']).': <b>'.$rest.'</b>';
//exit;




//echo 'Остаток на начало месяца: '.$data['goods']->rest0;
//
//if (!$data['m']) {
//	echo '<br><br>По данному товару движения не было';
//	return;
//}
//
//
//$rest = $data['goods']->rest0;
//
//foreach ($data['m'] as $doc) {
//	if ($op != $doc->id_operation) {
//		$op = $doc->id_operation;
//		echo '<br><br>' . CHtml::link($doc->operation->name, Yii::app()->params['rootFolder'].$links[$doc->id_operation]);
//	}
////	if ($dt != $doc->id_doctype) {
////		$dt = $doc->id_doctype;
////		echo '<br>' . $doc->doctype->name;
////	}
//	if ($dn != trim($doc->doc_num).$doc->doc_date) {
//		$dn = trim($doc->doc_num).$doc->doc_date;
//		echo "<br>[" . trim($doc->doc_num).'] -  '.Utils::format_date($doc->doc_date);
//	}
//	foreach ($doc->documentdata as $row) {
//		echo '<br>&nbsp&nbsp&nbsp&nbsp&nbsp'.$row->quantity.' * '. number_format($row->price,'0','.','&nbsp;').'';
//		$rest += $row->quantity*$doc->operation->operation;
//	}
//}
//echo '<br><br>Остаток на '.Utils::format_date(Yii::app()->session['workdate']).': '.$rest;
?>

<!--</table>-->

