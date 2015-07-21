<?php
/* @var $this ContactController */
/* @var $model Contact */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contact-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля, помеченные <span class="required">*</span> обязательные.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>80)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fname'); ?>
		<?php echo $form->textField($model,'fname',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'fname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'rs'); ?>
		<?php echo $form->textField($model,'rs',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'rs'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'mfo'); ?>
		<?php echo $form->textField($model,'mfo',array('size'=>9,'maxlength'=>9)); ?>
		<?php echo $form->error($model,'mfo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'okpo'); ?>
		<?php echo $form->textField($model,'okpo',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'okpo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'unn'); ?>
		<?php echo $form->textField($model,'unn',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'unn'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'address'); ?>
		<?php echo $form->textField($model,'address',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'address'); ?>
	</div>

<!--	<div class="row">-->
<!--		--><?php //echo $form->labelEx($model,'parent'); ?>
<!--		--><?php //echo $form->textField($model,'parent'); ?>
<!--		--><?php //echo $form->error($model,'parent'); ?>
<!--	</div>-->

	<div class="row">
		<?php echo $form->labelEx($model,'bank'); ?>
		<?php echo $form->textField($model,'bank',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'bank'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'agreement'); ?>
		<?php echo $form->textField($model,'agreement',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'agreement'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->