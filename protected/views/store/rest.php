<a href="/metan_0.1/print/index?report=Rest" target="_blank">Печать</a>
<br>
<a href="/metan_0.1/store/rest">Остатки на текущую дату</a>
<br>
<a href="/metan_0.1/store/restEdit">Остатки на начало месяца (редактировать)</a>
<?php
	//echo "<pre>";
	//print_r($data);
	//echo "</pre>";


	$this->widget('zii.widgets.grid.CGridView', array(
    	'dataProvider'=>$data,
    	'enablePagination' => true,
	));


?>

