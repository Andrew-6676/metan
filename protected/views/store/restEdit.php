<?php
	$this->addCSS('store/restEdit.css');
	$this->addJS('store/restEdit.js');

?>
	<div class="vsego" style="float: right; margin-right: 60px">
		<table>
			<tr>
				<td align="right">Сумма: &nbsp;</td>
				<td><b><span><?php echo number_format($sum, 2, '.', ' '); ?></span></b></td>
			</tr>
			<tr>
				<td align="right">Нименований: &nbsp;</td>
				<td><?php echo number_format(count($model), 0, '.', ' '); ?></td>
			</tr>
		</table>
<br>
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
//Utils::print_r($model);
//Utils::print_r($dataProvider);
//$this->widget('zii.widgets.grid.CGridView', array(
////		'rowCssClassExpression' => function($row, $data) {
//////			// $row - номер строки начиная с 0
//////			// $data - ваша моделька
////			$class = '';
////			if ($data['rest'] < 0) {
////				$class = 'minus';
////			}
////			if ($data['rest'] == 0) {
////				$class = 'nol';
////			}
////			if ($row%2 == 0) {
////				$class .= ' odd';
////			} else {
////				$class .= ' even';
////			}
////			return $class;
////		},
//		'id' => 'restGrid',
//		'dataProvider' => $dataProvider,
//		'enablePagination' => false,
//	//'pager'=> array(
//	//	'header' => '',
//	//'prevPageLabel' => '&laquo; назад',
//	//'nextPageLabel' => 'далее &raquo;',
//	//'maxButtonCount' => 10,
//	//'cssFile' => Yii::app()->theme->baseUrl . '/css/pager.css',
//	//	'htmlOptions' => array(
//	//		'class' => 'paginator'
//	//	),
//	//),
//		'columns' => array(
//				array(
//						'name'=>'id',
//						'header'=>'Код',
//						'htmlOptions'=>array('class'=>'gid')
//				),
//				array(
//						'name'=>'name',
//						'header'=>'Наименование',
//						'type'=>'raw',
//					//'value'=> 'CHtml::link($data[\'name\'], array(\'store/goodsCart/\'.$data[\'id\']));'
//						'value'=>'CHtml::link($data[\'name\'], "#", array("class"=>"goodscart","gid"=>$data[\'id\']) )',
//				),
//				array(
//						'name'=>'price',
//						'value'=>'number_format($data["price"], "2", ".", " ")',
//						'header'=>'Цена',
//						'htmlOptions'=>array('class'=>'r'),
//				),
//				array(
//						'name'=>'quantity',
//						'header'=>'Остаток',
//						'htmlOptions' => array('class'=>'r')
//				)
//		)
//));

?>


