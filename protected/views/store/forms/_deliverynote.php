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

echo '<div class="row">';
	textField($form, $ttnForm, 'addr1');
echo '</div>';
echo '<div class="row">';
	$ttnForm->otpusk = Store::model()->findByPk(Yii::app()->session['id_store'])->storepassports[0]->fio;
	textField($form, $ttnForm, 'otpusk');
echo '</div>';
echo '<div class="row">';
	//f_ttnForm_sdal
//	$ttnForm->sdal = Inputcache::model()->getList('f_ttnForm_sdal');
	textField($form, $ttnForm, 'sdal');
echo '</div>';
echo '<div class="row">';
textField($form, $ttnForm, 'car');
echo '</div>';
echo '<div class="row">';
textField($form, $ttnForm, 'driver');


//$this->widget('CAutoComplete',
//	array(
//		'model'=>'Inputcache',
//		'name'=>'str',
//		'url'=>array('MainAjax/autocomplete'),
//		'minChars'=>2,
//	)
//);

//$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
//	'name'=>'test1',
//	'value'=>'test21',
//	'source'=>$this->createUrl('MainAjax/autocomplete'),
//	// additional javascript options for the autocomplete plugin
////	'options'=>array(
////		'showAnim'=>'fold',
////	),
));


echo '</div>';


//echo CHtml::submitButton('Отправить');

$this->endWidget();

function textField($form, $fo, $fi) {
	echo $form->labelEx($fo,$fi);
	echo $form->textField($fo,$fi, array('size'=>35));
	echo $form->error($fo,$fi);
}