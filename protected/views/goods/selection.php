<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 03.09.15
 * Time: 8:39
 */

?>

selection

<?php
//?id[]=42931026&id[]=42875721&id[]=43876018&id[]=42874875&id[]=42931014
//Utils::print_r($data);

$this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'restGrid',
	'dataProvider' => $data,
	'enablePagination' => false,
	'columns' => array(
		array(
			'name'=>'id_goods',
			'header'=>'Код',
			'htmlOptions'=>array('class'=>'gid')
		),
		array(
			'name'=>'Goods.name',
			'header'=>'Наименование'
		),
		array(
			'name'=>'price',
			'value'=>'number_format($data["price"],"0", ".", " ")',
			'header'=>'Цена',
			'htmlOptions'=>array('class'=>'r'),
		),
		array(
			'name'=>'quantity',
			'header'=>'Остаток',
			'htmlOptions' => array('class'=>'r')
		)
	)
));