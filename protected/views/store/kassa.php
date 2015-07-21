<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 20.07.15
 * Time: 9:37
 */
$d = explode('-', Yii::app()->session['workdate']);
$d = $d[2].'.'.$d[1].'.'.$d[0];
?>

<div class="form">
	<h2>Остаток на <?php echo $d; ?></h2>
	<?php echo CHtml::textField('mess',$sum); ?>
	<br>
	<?php echo CHtml::button('Отправить',array('onclick'=>'send();')); ?>

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
				alert(data.message);
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
</style>