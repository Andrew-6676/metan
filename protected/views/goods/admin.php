<!--http://yiiframework.ru/doc/guide/ru/topics.gii-->
<?php
/* @var $this GoodsController */
/* @var $model Goods */

$this->breadcrumbs=array(
	'Goods'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Goods', 'url'=>array('index')),
	array('label'=>'Create Goods', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#goods-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Справочник товаров</h1>

<!--<p>-->
<!--You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>-->
<!--or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.-->
<!--</p>-->

<?php echo CHtml::link('Расширеный поиск','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'goods-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'unit.name',
//		array(
//			'name' => 'unitname',
//			'type' => 'raw',
//			'value' => 'CHtml::link(CHtml::encode($data->unit->name),
//                         array("/unit/view","id" => $data->unit->id))',
//		),
		'producer',
		'norder',
//		'id_supplier',
//		'supplier.name',
		array(
			'name'=>'contact.name',
			'header'=>'Наименование поставщика',
//			'type'=>'html',
			'filter'=>CHtml::textField('Goods[contact.name]', $model->contactname),
//			'value' =>'@$data->supplier->name',
		),
		/*
		'id_goodsgroup',*/
		'id_3torg',
		array(
			'class'=>'CButtonColumn',
		),
	),
));

?>
