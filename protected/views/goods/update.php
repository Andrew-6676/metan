<?php
/* @var $this GoodsController */
/* @var $model Goods */

//$this->addJS('goods/main.js');
$this->addCSS('smoothness/jquery-ui-1.10.4.custom.css');
$this->addCSS('spr/main.css');


$this->breadcrumbs=array(
	'Goods'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Goods', 'url'=>array('index')),
	array('label'=>'Create Goods', 'url'=>array('create')),
	array('label'=>'View Goods', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Goods', 'url'=>array('admin')),
);
?>

<h2>Редактирование <span><?php echo '"'.$model->name.'"'; ?></span></h1>

<?php
//		// список единиц измерения
//	$units = Unit::model()->findAll(array('order'=>'name'));
//		// группы 3-торг
//	$groups = Torg3::model()->findAll(array('order'=>'name'));

?>

<?php $this->renderPartial('_form', array(
	'model'=>$model,
	'units'=>$units,
	'groups'=>$groups,
	'suppliers'=>$suppliers
)); ?>

