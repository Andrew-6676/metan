<?php
$this->addCss('forms.css');
//echo 'deliverynote form';
$wrForm = new form_writeoff;

$form = $this->beginWidget('CActiveForm', array(
	'id' => 'quick-form',
	'enableClientValidation' => true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
	),
//		'action' => array('site/quick'),
));

$form->errorSummary($wrForm);
$for = array('1' => 'Общий товарооборот', '2' => 'Розничный товарооборот', '3' => 'Собственные нужды');
$arr = array(
	'nttn',
	'date_ttn',
	'n_pl',
);

//foreach ($arr as $key) {
$wrForm->nttn = '';
$wrForm->date_ttn = Yii::app()->session['workdate'];
$wrForm->n_pl = '0';
	?>

	<div class="row">
		<?php textField($form, $wrForm, 'nttn'); ?>
	</div>
	<div class="row">
		<?php dateField($form, $wrForm, 'date_ttn'); ?>
	</div>
	<div class="row">
		<?php textField($form, $wrForm, 'n_pl'); ?>
	</div>

	<div class="row">
		<?php
			echo $form->labelEx($wrForm, 'for');
			echo $form->dropDownList($wrForm,'for', $for);
		?>
	</div>

	<?php
//}

$this->endWidget();

function dateField($form, $fo, $fi) {
	echo $form->labelEx($fo,$fi);
	echo $form->dateField($fo,$fi, array('size'=>35));
	echo $form->error($fo,$fi);
}
function textField($form, $fo, $fi) {
	echo $form->labelEx($fo,$fi);
	echo $form->textField($fo,$fi, array('size'=>35));
	echo $form->error($fo,$fi);
}
