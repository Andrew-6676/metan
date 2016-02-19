<?php
/* @var $this ContactController */
/* @var $model Contact */

$this->breadcrumbs=array(
	'Contacts'=>array('index'),
	'Manage',
);
$this->addCSS('forms.css');
$this->menu=array(
	array('label'=>'List Contact', 'url'=>array('index')),
	array('label'=>'Create Contact', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#contact-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

?>

<h1>Справочник потребителй</h1>



<?php echo CHtml::link('Расширеный поиск','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'contact-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'summaryText' => '{start}&ndash;{end} из {count}',
	'pager' => array(
		'header' => '',
		'prevPageLabel' => '&laquo; назад',
		'nextPageLabel' => 'далее &raquo;',
		'maxButtonCount' => 30,

	),
	'columns'=>array(
		'id',
		'name',
		//'fname',
		'rs',
		'mfo',
		'okpo',
		'unn',
		'address',
		//'kpo',
		//'parent',
//		'bank',
		'agreement',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
