<?php
	$this->addCSS('store/restEdit.css');
	$this->addJS('store/restEdit.js');

	$this->widget('editTableWidget',
					array(
	 					'model'=>$model,
	 					'columns'=>array(
	 								'id_goods',
	 								array('Goods', 'name'),
	 								array('Goods', 'Unit', 'name'),
	 								'cost',
	 								'quantity'
	 					),
	 					'edit'=>array('cost',
	 						 		  'quantity'),
					)
	);
?>


