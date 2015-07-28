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

$form->labelEx($ttnForm,'addr1');
$form->textField($ttnForm,'addr1', array('size'=>35));
$form->error($ttnForm,'addr1');


echo $form->labelEx($ttnForm,'otpusk');
echo $form->textField($ttnForm,'otpusk', array('size'=>35));
echo $form->error($ttnForm,'otpusk');

echo "<br>";

echo $form->labelEx($ttnForm,'car');
echo $form->textField($ttnForm,'car', array('size'=>35));
echo $form->error($ttnForm,'car');

//echo "<br>";

//echo CHtml::submitButton('Отправить');

$this->endWidget();
