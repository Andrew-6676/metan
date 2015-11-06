<?php
	$this->addCss('forms.css');
?>
<div class="store_wr">
	<h2>Паспорт магазина</h2>

	<?php

//	$allMessages = Yii::app()->user->getFlashes();
//	if ($allMessages) {
//		foreach($allMessages as $key => $message) {
//			echo '<span>' . $key.': '.$message . '</span><br>';
//		}
//	}

	if(Yii::app()->user->hasFlash('ok')):?>
		<span class="error_message">
        <?php echo Yii::app()->user->getFlash('ok'); ?>
    </span>
	<?php endif; ?>
	<?php
		$this->renderPartial('forms/_form_store', array('model'=>$model));
	?>
</div>




