<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 27.08.15
 * Time: 16:41
 */


?>

<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 27.07.15
 * Time: 11:27
 */

//echo 'deliverynote form';


//Utils::print_r($_GET);

$form = $this->beginWidget('CActiveForm', array(
	'id' => 'store_form',
	'enableClientValidation' => true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
	),
//		'action' => array('site/quick'),
));

//if ($_GET['saved'])
$form->errorSummary($model);

$arr = array('name',
			'fname',
			'fio',
			'phone',
			'account',
			'mfo',
			'bank',
			'fio_mpu',
			'unn',
			'okpo',
			'lic',
			'dov',
			'address');

foreach ($arr as $key) {
	?>

	<div class="row">
		<?php textField($form, $model, $key); ?>
	</div>

<?php

}
?>

<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
</div>

<?php
//echo CHtml::submitButton('Отправить');
$this->endWidget();



function textField($form, $fo, $fi)
{
	echo $form->labelEx($fo, $fi);
	echo $form->textField($fo, $fi, array('size' => 35));
	echo $form->error($fo, $fi);
}


?>
