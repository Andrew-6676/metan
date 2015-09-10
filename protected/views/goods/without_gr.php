<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 25.08.15
 * Time: 16:22
 */

//
//$this->menu=array(
//	array('label'=>'List Goods', 'url'=>array('index')),
//	array('label'=>'Create Goods', 'url'=>array('create')),
//);

//Yii::app()->clientScript->registerScript('search', "
//$('.search-button').click(function(){
//	$('.search-form').toggle();
//	return false;
//});
//$('.search-form form').submit(function(){
//	$('#goods-grid').yiiGridView('update', {
//		data: $(this).serialize()
//	});
//	return false;
//});
//");
?>

<h1>Товары без групп</h1>

<!--<p>-->
<!--You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>-->
<!--or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.-->
<!--</p>-->

<?php

	$this->widget('zii.widgets.grid.CGridView', array(
		'id' => 'restGrid',
		'dataProvider' => $data,
		'enablePagination' => false,
		'columns' => array(
			array(
				'name'=>'id',
				'header'=>'Код',
				'type'=>'raw',
				'value'=> 'CHtml::link($data->id,array("goods/update/".$data->id))',
			),
			array(
				'name'=>'name',
				'header'=>'Наименование'
			),
			array(
				'name'=>'id_3torg',
				'header'=>'3-торг',
				'htmlOptions'=>array('class'=>'r'),
			)
		)
	));
?>


<?php

