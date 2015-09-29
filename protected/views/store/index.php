<?php
	$this->addCss('store/index.css');


//Yii::app()->user->setFlash('success', 'Файл  был успешно загружен!');
//if (Yii::app()->user->hasFlash('success')) {
//	Utils::print_r(Yii::app()->user->getFlash('success'));
//
//}
?>
<div class="store_index">
	<div class="date">
		<input type="date" id="workdate_page" value="<?php echo Yii::app()->session['workdate']; ?>">
		<button id="accept_date">Принять</button>
	</div>
	<?php
	// Utils::print_r($this->menu);
	if (sizeof($this->menu) > 0) {
		$this->widget('zii.widgets.CMenu',array(
						'encodeLabel'=>false,
                        'items'=>$this->menu
		              )
		);

	}
?>
</div>