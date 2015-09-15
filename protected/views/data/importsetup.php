<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 11.09.15
 * Time: 17:03
 */
$this->addCSS('store/importsetup.css');

//$tables = iTables::model()->with('fields')->findAll();

//Utils::print_r($tables[0]);


//Utils::print_r($import);

?>


<?php
//exit;
foreach ($data->imptabl as $imp) {
		$disabled = '';
		if (!$imp->table->enabled) {
			$disabled = ' disabled';
		}
		$t  = '<table class="std canhide'.$disabled.'"><caption>'.$imp->table->name.' ('.$imp->table->table_src.' > '.$imp->table->table_dst.')</caption><tbody class="hidden">';
	foreach ($imp->table->fields as $field) {
//		Utils::print_r($t);
//		echo '<hr>';
//
			$t .= '<tr>';
			$t .= '<td>';
			$t .= $field->field_src;
			$t .= '</td>';
			$t .= '<td>';
			$t .= $field->field_dst;
			$t .= '</td>';
			$t .= '</tr>';
	}

	$t .= '</tbody></table>';
	echo $t;
}


?>

