<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 20.07.15
 * Time: 9:37
 */

?>

<div class="form">
	<h2>Книга замечаний и предложений</h2>
	<?php echo CHtml::textArea('mess'); ?>
	<br>
	<?php echo CHtml::button('Отправить',array('onclick'=>'send();')); ?>

</div><!-- form -->

<script type="text/javascript">

	function send()
	{

		var text = $("[name='mess']").val();

		if (text=='') {
			alert('Введите сообщение');
			return false;
		}


		$.ajax({
			type: 'POST',
			url: '<?php echo Yii::app()->createAbsoluteUrl("site/gbook"); ?>',
			dataType:'json',
			data: {mess : text},
			success:function(data){
				$("[name='mess']").val('');
				alert(data.message);
			},

			error: function(data) { // if error occured
				alert(data.message);
			}
		});

	}

</script>

<style>
	h2 {
		text-align: center;
	}
	.form {
		width: 700px;
		margin: auto;
	}
	textarea {
		width: 100%;
		height: 300px;
		margin: auto;
	}
	input[type=button]{
		font-size: 1.2em;
		padding: 5px;
		cursor: pointer;
	}
</style>