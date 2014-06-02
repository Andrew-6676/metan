<?php
	/* DirectoryController->IndexAction */
	echo '<br>'.$this->basePath;
	echo $mess.'<br><br>';
	//print_r($model);

if ($model) {
	$this->widget('zii.widgets.grid.CGridView', array(
		//'id'=>'user-grid',
		'dataProvider'=>$model->search(),
		//'filter'=>$model,			// вывод на странице строки для ввода фильтра
		'columns'=>$columns,
	));
}

/*
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#user-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
*/

?>