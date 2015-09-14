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
$criteria = new CDbCriteria;
$criteria->addCondition('id_store='.Yii::app()->session['id_store']);
$criteria->order ='sort';

$import = iImport::model()->with('imptabl.table.fields')->find($criteria);

//Utils::print_r($import);

?>

asdfasdfasdf
<?php
//exit;
foreach ($import->imptabl as $imp) {

		$t  = '<table><caption>'.$imp->table->name.' ('.$imp->table->table_src.' > '.$imp->table->table_dst.')</caption>';
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

	$t .= '</table>';
	echo $t;
}


?>

