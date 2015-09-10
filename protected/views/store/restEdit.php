<?php
	$this->addCSS('store/restEdit.css');
	$this->addJS('store/restEdit.js');

?>
	<div class="" style="float: right; margin-right: 60px">
		Всего: <?php echo number_format($sum, 0, '.', ' '); ?>
	</div>
<?php
	$this->widget('editTableWidget',
					array(
	 					'model'=>$model,
	 					'columns'=>array(
	 								'id_goods',
	 								array('Goods', 'name'),
	 								array('Goods', 'unitname'),
	 								'price',
	 								'quantity'
	 					),
	 					'edit'=>array('cost',
	 						 		  'quantity'),
					)
	);
?>


