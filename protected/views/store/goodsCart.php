<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 21.08.15
 * Time: 12:14
 */

//Utils::print_r($data);

$op = '';
$dt = '';
$dn = '';
if (!$data) {
	echo 'Не было движения по данному товару';
	return;
}
foreach ($data as $doc) {
	if ($op != $doc->id_operation) {
		$op = $doc->id_operation;
		echo '<br>' . $doc->operation->name;
	}
//	if ($dt != $doc->id_doctype) {
//		$dt = $doc->id_doctype;
//		echo '<br>' . $doc->doctype->name;
//	}
	if ($dn != $doc->doc_num) {
		$dn = trim($doc->doc_num);
		echo '<br>[' . trim($doc->doc_num).'] -  '.Utils::format_date($doc->doc_date).'<br>';
	}
	foreach ($doc->documentdata as $row) {
		echo $row->quantity.' * '. number_format($row->price,'0','.','`').'<br>';
	}
}
?>

