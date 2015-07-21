<?php
/* @var $this ContactController */
/* @var $model Contact */
$this->addCSS('spr/main.css');

$this->breadcrumbs=array(
	'Contacts'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Contact', 'url'=>array('index')),
	array('label'=>'Create Contact', 'url'=>array('create')),
	array('label'=>'View Contact', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Contact', 'url'=>array('admin')),
);
?>

<h1>Редактирование <?php echo $model->name; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>