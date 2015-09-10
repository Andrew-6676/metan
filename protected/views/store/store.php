<?php
	$this->addCss('forms.css');
?>
<div class="store_wr">
	<h2>Паспорт магазина</h2>
	<?php
		$this->renderPartial('forms/_form_store', array('model'=>$model));
	?>
</div>




