<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 03.09.15
 * Time: 8:39
 */

?>

<?php
//?id[]=42931026&id[]=42875721&id[]=43876018&id[]=42874875&id[]=42931014
//Utils::print_r($data);

$this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'restGrid',
	'dataProvider' => $data,
	'enablePagination' => false,
	'columns' => array(
		array(
			'name'=>'id',
			'header'=>'Код',
			'htmlOptions'=>array('class'=>'gid')
		),
		array(
			'name'=>'name',
			'header'=>'Наименование'
		),
		array(
			'name'=>'price',
			'value'=>'number_format($data["price"], "2", ".", " ")',
			'header'=>'Цена',
			'htmlOptions'=>array('class'=>'r'),
		),
		array(
			'name'=>'rest',
			'header'=>'Остаток',
			'htmlOptions' => array('class'=>'r')
		)
	)
));