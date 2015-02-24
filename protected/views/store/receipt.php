<?php
	// $this->addCSS('');
	// $this->addJS('');
?>
<div class="page_caption">
	Приход товара за <b><u>
	<?php
		echo Utils::getMonthName(intval(substr(Yii::app()->session['workdate'],5,2)));
		echo date(' Y');
	?>
	г.</b></u>
	<?php echo ' (документов: '.count($data).')'; ?>
</div>

<div class="data">
<?php

	$this->widget('DocWidget',array(
							'data'=>$data,
							'mode'=>'one_to_many',
							'columns'=> array('doc_num','doc_date','reason'),
			                ));

?>
</div>