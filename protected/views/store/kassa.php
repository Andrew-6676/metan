<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 20.07.15
 * Time: 9:37
 */

$this->pageTitle = 'Касса на начало дня';

?>

<div class="form">
	<h2>Остаток на <?php echo Utils::format_date(Yii::app()->session['workdate']); ?></h2>
	<?php echo CHtml::textField('mess',$sum); ?>
	<br>
	<?php echo CHtml::button('Сохранить',array('onclick'=>'send();')); ?>

</div><!-- form -->

<script type="text/javascript">

	function send()
	{

		var text = $("[name='mess']").val();

		if (text=='') {
			alert('Введите сумму!');
			return false;
		}


		$.ajax({
			type: 'POST',
			url: '<?php echo Yii::app()->createAbsoluteUrl("store/kassa"); ?>',
			dataType:'json',
			data: {mess : text},
			success:function(data){
				console.log(data);
//				alert(data.message);
				location.reload();
			},

			error: function(data) { // if error occured
				console.log(data);
				alert(data.message);
			}
		});

	}

</script>

<style>
	input[type=text] {
		/*width: 600px;*/
		/*height: 300px;*/
		/*margin: auto;*/
		font-size: 1.4em;
		text-align: right;
	}
	input[type=button]{
		font-size: 1.2em;
		padding: 5px;
		cursor: pointer;
	}
	.items{
		width: 300px !important;
	}
	.summary {
		display: none !important;
	}
</style>

<?php

$this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$model,
	'enablePagination' => false,
	'columns'=>array(
		array(
			'name'=>'kassa_date',
			'value' =>'format_date($data->kassa_date)',
//			'value' =>'date("d.m.Y",$data->kassa_date)',
			'htmlOptions'=>array('style'=>'text-align: center;'),
		),
		array(
			'name'=>'sum',
			'value' =>'number_format($data->sum, "2", ".", "`")',
			'htmlOptions'=>array('style'=>'text-align: right'),
		)
	)
));

function format_date($date) {
	$d = explode('-',$date);
	return $d[2].'.'.$d[1];
	//.'.'.$d[0];
}


//$model2 = Kassa::model()->findAll()[0];
//$model2->kassa_date = format_date($model2->kassa_date);
//$this->widget('zii.widgets.jui.CJuiDatePicker', array(
//	'model' => $model2,
//	'attribute' => 'kassa_date',
//
//	'options'=>array(
//		'showAnim'=>'fold',
//		'dateFormat'=>'dd.mm.yy',
//
//	),
//	'htmlOptions'=>array(
//		'style'=>'height:20px;'
//	),
//	'language' => 'ru'
//));


//Utils::print_r($model);
//$criteria = new CDbCriteria;
//$criteria->addCondition('kassa_date::text LIKE \''.substr(Yii::app()->session['workdate'],0,7).'-%\'');
//$criteria->addCondition('id_store='.Yii::app()->session['id_store']);
//$criteria->order ='kassa_date';
//$model = Kassa::model()->findAll($criteria);
//
//
//$this->widget('editTableWidget',
//	array(
//		'model'=>$model,
//		'columns'=>array(
////			'id',
//			'kassa_date',
//			'sum',
//		),
//		'edit'=>array('sum'),
//	)
//);
?>

<?php
//        //Подключаем виджет модального окна
//        $this->beginWidget('bootstrap.widgets.TbModal', array(
//	        'id'=>'loginModalForm',
//	        'htmlOptions'=>array(
//		        'style'=>'display: none;',  //скрываем модальное окно в неактивном состоянии, исключая возможное перекрытие с другими элементами страницы
//	        ),
//        ));
//    ?>
<!--<!-- заголовок модального окна -->
<!--<div class="modal-header">-->
<!--	<a class="close" data-dismiss="modal">×</a>-->
<!--	<h4>Вход на сайт</h4>-->
<!--</div>-->
<!--<!-- тело модального окна, выводим элементы формы -->
<!--<div class="modal-body">-->
<!--	--><?php
//
////	$model = new Userlogin;
////	$reg = new RegistrationForm;
////	$profile=new Profile;
//	$this->widget('bootstrap.widgets.TbTabs', array(
//		'type'=>'tabs',
//		'placement'=>'top',
//		'tabs'=>array(
//			array('label'=>Yii::t('login', 'Login'), 'content'=>'asdfasdfafasdfdf', 'active'=>true),
//			array('label'=>Yii::t('registration', 'Register'), 'content'=>'dfasdfadsfa','active'=>false),
////'tabs'=>array(
////	array('label'=>Yii::t('login', 'Login'), 'content'=>Yii::app()->controller->renderPartial('//../modules/user/views/user/login', array('model'=>$model), true, false), 'active'=>true),
////	array('label'=>Yii::t('registration', 'Register'), 'content'=>Yii::app()->controller->renderPartial('//../modules/user/views/user/registration', array('model'=>$reg, 'profile'=>$profile), true, false),'active'=>false),
////),
//		),
//	));
//	?>
<!--</div>-->
<!--<!-- подвал формы, где выводятся кнопки отправки формы и закрытия модального окна -->
<!--<div class="modal-footer">-->
<!--	--><?php
//	$this->widget('bootstrap.widgets.TbButton', array(
//		'buttonType'=>'submit',
//		'label'=>'Вход',
//	));
//	?>
<!--	--><?php
//	$this->widget('bootstrap.widgets.TbButton', array(
//		'label'=>'Закрыть',
//		'htmlOptions'=>array('data-dismiss'=>'modal'),
//	));
//	?>
<!--</div>-->

<?php
//$this->endWidget(); //Конец виджета модального окна
?>
