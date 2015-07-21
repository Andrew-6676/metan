<?php
/* @var $this GoodsController */
/* @var $model Goods */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_unit'); ?>
		<?php echo $form->textField($model,'id_unit'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'producer'); ?>
		<?php echo $form->textField($model,'producer',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'norder'); ?>
		<?php echo $form->textField($model,'norder',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_supplier'); ?>
		<?php echo $form->textField($model,'id_supplier'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_goodsgroup'); ?>
		<?php echo $form->textField($model,'id_goodsgroup'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_3torg'); ?>
		<?php echo $form->textField($model,'id_3torg',array('size'=>13,'maxlength'=>13)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->