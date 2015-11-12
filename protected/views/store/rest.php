<?php

//$this->addCSS('store/rest.css');
$this->addCSS('store/goodasCart.css');
$this->addJS('store/rest.js');
$this->addJS('jquery-ui.js');


?>

<a href="/metan_0.1/print/index?report=Rest" target="_blank">Печать</a>
<br>
<a href="/metan_0.1/store/rest">Остатки на текущую дату</a>
<br>
<a href="/metan_0.1/store/restEdit">Остатки на начало месяца (редактировать)</a>
<br>
<br>
<button class="selected_goods">Выбрать</button>
<button class="unselect_goods">Снять выделение</button>
<div class="" style="float: right; ">
	Всего: <?php echo number_format($total, 0, '.', ' '); ?>
</div>

<?php
	//echo "<pre>";
	//print_r($data);
	//echo "</pre>";

//
//	$this->widget('zii.widgets.grid.CGridView', array(
//    	'dataProvider'=>$data,
//    	'enablePagination' => true,
//	));



	$this->widget('zii.widgets.grid.CGridView', array(
		'rowCssClassExpression' => function($row, $data) {
//			// $row - номер строки начиная с 0
//			// $data - ваша моделька
			$class = '';
			if ($data['rest'] < 0) { // выделяем вторую! строку
				$class = 'minus';
			}
			if ($row%2 == 0) {
				$class .= ' odd';
			} else {
				$class .= ' even';
			}
			return $class;
		},
		'id' => 'restGrid',
		'dataProvider' => $data,
		'enablePagination' => false,
		//'pager'=> array(
		//	'header' => '',
			//'prevPageLabel' => '&laquo; назад',
			//'nextPageLabel' => 'далее &raquo;',
			//'maxButtonCount' => 10,
			//'cssFile' => Yii::app()->theme->baseUrl . '/css/pager.css',
		//	'htmlOptions' => array(
		//		'class' => 'paginator'
		//	),
		//),
		'columns' => array(
//			array(
//				'name'=>'check',
//				'header'=>'',
//				'type'=>'raw',
//				'value'=> 'CHtml::CheckBox("f_n",false, array("value"=>$data[\'id\'] ));'
//			),
			array(
				'name'=>'id',
				'header'=>'Код',
				'htmlOptions'=>array('class'=>'gid')
			),
			array(
				'name'=>'name',
				'header'=>'Наименование',
				'type'=>'raw',
				//'value'=> 'CHtml::link($data[\'name\'], array(\'store/goodsCart/\'.$data[\'id\']));'
				'value'=>'CHtml::link($data[\'name\'], "#", array("class"=>"goodscart","gid"=>$data[\'id\']) )',
//				'value'=>'CHtml::ajaxLink(
//									$data[\'name\'],
//									array("store/goodsCart/".$data[\'id\']),
//									array("update" => "#mainDialogArea"),
//									array("onclick" => "$(\'#mainDialog\').dialog(\'open\');")
//						);'
				//store/goodsCart/42876052
			),
			array(
				'name'=>'price',
				'value'=>'number_format($data["price"],"0", ".", " ")',
				'header'=>'Цена',
				'htmlOptions'=>array('class'=>'r'),
			),
//			array(
//				'name'=>'price',
//				'type'=>'raw',
//				'value'=>'number_format(Goods::model()->findByPK($data["id"])->price,"0", ".", " ")',
//				'header'=>'Цена',
//				'htmlOptions'=>array('class'=>'r'),
//			),
			array(
				'name'=>'rest',
				'header'=>'Остаток',
				'htmlOptions' => array('class'=>'r')
			)
		)
	));
	// условие ? значение1 : значение2
?>

