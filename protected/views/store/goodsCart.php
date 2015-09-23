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


?>
<div class="caption">
	<?php
		echo $data['goods']->name;
		echo ' ('.$data['goods']->id.')';
	?>
</div>
<!--<table class="motion">-->
<!--	<tr class="capt">-->
<!--		<td colspan="4"></td>-->
<!--	</tr>-->
<?php
	echo 'Остаток на '. Utils::format_date(substr(Yii::app()->session['workdate'],0,7).'-01').': <b>'.$data['goods']->rest0.'</b>';
?>

<table class="std cart">
	<thead>
		<tr>
			<th>Дата</th>
			<th>Операция</th>
			<th>Кол-во</th>
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
		'56' => '/store/expense_day',
		'52' => '/store/expense',
	);
	$rest = $data['goods']->rest0;
	foreach ($data['m'] as $doc) {
		foreach ($doc->documentdata as $row) {
			$m='';
			if ($doc->operation->operation < 0 ) {
				$m = 'minus';
			}
			$rest += $row->quantity*$doc->operation->operation;
			$tr = '<tr>';
			$tr .=     '<td>';
			$tr .=         Utils::format_date($doc->doc_date);
			$tr .=     '</td>';
			$tr .=     '<td class="c">';
			$tr .=         CHtml::link($doc->operation->name, Yii::app()->params['rootFolder'].$links[$doc->id_operation], array('title'=>'Документ № '.$doc->doc_num));
			$tr .=     '</td>';
			$tr .=     '<td  class="'.$m.'">';
			$tr .=         $row->quantity;
			$tr .=     '</td>';
			$tr .=     '<td  class="'.$m.'">';
			$tr .=         number_format($row->price*$row->quantity,'0','.','`');
			$tr .=     '</td>';
			$tr .=     '<td>';
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
//		echo '<br>&nbsp&nbsp&nbsp&nbsp&nbsp'.$row->quantity.' * '. number_format($row->price,'0','.','`').'';
//		$rest += $row->quantity*$doc->operation->operation;
//	}
//}
//echo '<br><br>Остаток на '.Utils::format_date(Yii::app()->session['workdate']).': '.$rest;
?>

<!--</table>-->