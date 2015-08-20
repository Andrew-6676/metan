<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 27.07.15
 * Time: 11:27
 */

//echo 'deliverynote form';
$ttnForm = new f_ttnForm;
$form = $this->beginWidget('CActiveForm', array(
	'id' => 'quick-form',
	'enableClientValidation' => true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
	),
//		'action' => array('site/quick'),
));

$form->errorSummary($ttnForm);

echo '<div>';
	textField($form, $ttnForm, 'addr1');
echo '</div>';
echo '<div>';
	textField($form, $ttnForm, 'otpusk');
echo '</div>';

echo '<div>';
	textField($form, $ttnForm, 'car');
echo '</div>';


//echo CHtml::submitButton('Отправить');

$this->endWidget();

function textField($form, $fo, $fi) {
	echo $form->labelEx($fo,$fi);
	echo $form->textField($fo,$fi, array('size'=>35));
	echo $form->error($fo,$fi);
}