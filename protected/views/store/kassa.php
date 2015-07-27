<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 20.07.15
 * Time: 9:37
 */

$this->pageTitle = 'Касса на начало дня';

$d = explode('-', Yii::app()->session['workdate']);
$d = $d[2].'.'.$d[1].'.'.$d[0];
?>

<div class="form">
	<h2>Остаток на <?php echo $d; ?></h2>
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
	'enablePagination' => true,
	'columns'=>array(
		array(
			'name'=>'kassa_date',
			'value' =>'format_date($data->kassa_date)',
//			'value' =>'date("d.m.Y",$data->kassa_date)',
			'htmlOptions'=>array('style'=>'text-align: center;'),
		),
		array(
			'name'=>'sum',
			'value' =>'number_format($data->sum, "0", ".", "`")',
			'htmlOptions'=>array('style'=>'text-align: right'),
		)
	)
));

function format_date($date) {
	$d = explode('-',$date);
	return $d[2].'.'.$d[1];//.'.'.$d[0];
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