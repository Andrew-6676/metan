<?php
/* @var $this ContactController */
/* @var $data Contact */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fname')); ?>:</b>
	<?php echo CHtml::encode($data->fname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rs')); ?>:</b>
	<?php echo CHtml::encode($data->rs); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mfo')); ?>:</b>
	<?php echo CHtml::encode($data->mfo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('okpo')); ?>:</b>
	<?php echo CHtml::encode($data->okpo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('unn')); ?>:</b>
	<?php echo CHtml::encode($data->unn); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('address')); ?>:</b>
	<?php echo CHtml::encode($data->address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kpo')); ?>:</b>
	<?php echo CHtml::encode($data->kpo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('parent')); ?>:</b>
	<?php echo CHtml::encode($data->parent); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('bank')); ?>:</b>
	<?php echo CHtml::encode($data->bank); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('agreement')); ?>:</b>
	<?php echo CHtml::encode($data->agreement); ?>
	<br />

	*/ ?>

</div>