<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 27.07.15
 * Time: 11:27
 */

//echo 'deliverynote form';
$ttnForm = new form_ttn;
$form = $this->beginWidget(
	'CActiveForm',
	array(
		'id' => 'prepare-ttn-form',
		'enableClientValidation' => true,
		'clientOptions' => array(
			'validateOnSubmit' => true,
		),
	//'action' => array('site/quick'),
	)
);

/*  заполняем форму жанными*/
//$ttnForm->otpusk = Store::model()->findByPk(Yii::app()->session['id_store'])->storepassports[0]->fio;
$usr = User::model()->findByPk(Yii::app()->user->id);
$ttnForm->otpusk = $usr->post.', '.$usr->name;

$ttnForm->vladelec = 'b';
$ttnForm->zakazchik = 'b';
$form->errorSummary($ttnForm);

foreach ($ttnForm->fields as $key) {
	?>

	<div class="row">
		<?php textField_($form, $ttnForm, $key, $this); ?>
	</div>

	<?php

}

echo '</div>';



$this->endWidget();

function textField_($form, $fo, $fi, $controller) {
	echo $form->labelEx($fo, $fi);
//	if ($fi=='vladelec' || $fi=='zakazchik') {
//		echo $form->dropDownList($fo, $fi, array('b' => 'Покупатель', 's' => 'Продавец'));
//	} else
		if ($fi != 'dover' && $fi!='vladelec' && $fi!='zakazchik' && $fi!='p_razgruz' && $fi!='addr1' && $fi!='put_list' && $fi!='osnovanie'/*$fi=='sdal' || $fi=='car'*/ ) {
		$controller->widget('zii.widgets.jui.CJuiAutoComplete', array(
			'model'=>$fo,
			'attribute'=>$fi,
//			'name'=>'test1',
//			'value'=>'',
			'source'=>$controller->createUrl('MainAjax/autocomplete'.'/input/f_ttnForm_'.$fi),
			'options'=>array(
				'showAnim'=>'fold',
			),
		));
	} else {

		echo $form->textField($fo, $fi, array('size' => 35));
		echo $form->error($fo, $fi);
	}
}