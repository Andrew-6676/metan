<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 21.08.15
 * Time: 12:14
 */

//Utils::print_r($data);
$this->addCSS('store/goodasCart.css');

$op = '';
$dt = '';
$dn = '';


?>
<div class="caption">
	<?php echo $data['goods']->name;  ?>
</div>
<!--<table class="motion">-->
<!--	<tr class="capt">-->
<!--		<td colspan="4"></td>-->
<!--	</tr>-->
<?php

echo 'Остаток на начало месяца: '.$data['goods']->rest0;

if (!$data['m']) {
	echo '<br><br>По данному товару движения не было';
	return;
}

$links = array(
	'1'  => '/store/invoice',
	'2'  => '/store/return',
	'33' => '/store/receipt',
	'51' => '/store/expense_day',
	'56' => '/store/expense_day',
	'52' => '/store/expense',
);
foreach ($data['m'] as $doc) {
	if ($op != $doc->id_operation) {
		$op = $doc->id_operation;
		echo '<br>' . CHtml::link($doc->operation->name, Yii::app()->params['rootFolder'].$links[$doc->id_operation]);
	}
//	if ($dt != $doc->id_doctype) {
//		$dt = $doc->id_doctype;
//		echo '<br>' . $doc->doctype->name;
//	}
	if ($dn != $doc->doc_num) {
		$dn = trim($doc->doc_num);
		echo '<br>[' . trim($doc->doc_num).'] -  '.Utils::format_date($doc->doc_date).' - ';
	}
	foreach ($doc->documentdata as $row) {
		echo $row->quantity.' * '. number_format($row->price,'0','.','`').'<br>';
	}
}
?>

<!--</table>-->