<?php
/* @var $this GoodsController */
/* @var $model Goods */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'goods-form',
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
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_unit'); ?>
		<?php
			$list = CHtml::listData($units,	'id', 'name');
			echo $form->dropDownList($model,'id_unit', $list);
		?>

		<?php echo $form->error($model,'id_unit'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'producer'); ?>
		<?php echo $form->textField($model,'producer',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'producer'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'norder'); ?>
		<?php echo $form->textField($model,'norder',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'norder'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_supplier'); ?>
		<?php
			$list = CHtml::listData($suppliers, 'id', 'name');
			echo $form->dropDownList($model,'id_supplier', $list);
		?>

		<?php echo $form->error($model,'id_supplier'); ?>
	</div>

	<!-- div class="row">
		<?php echo $form->labelEx($model,'id_goodsgroup'); ?>
		<?php echo $form->textField($model,'id_goodsgroup'); ?>
		<?php echo $form->error($model,'id_goodsgroup'); ?>
	</div -->

	<div class="row">
		<?php echo $form->labelEx($model,'id_3torg'); ?>
		<?php
			$list = CHtml::listData($groups, 'kod_gr', 'name');
			echo $form->dropDownList($model,'id_3torg', $list);
		?>

		<?php echo $form->error($model,'id_3torg'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->