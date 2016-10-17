<?php

//$this->addCSS('store/rest.css');
$this->addCSS('store/goodasCart.css');
$this->addJS('store/rest.js');
$this->addJS('jquery-ui.js');


?>

<!-- a href="/metan_0.1/print/index?report=Rest" target="_blank">Печать</a>
<br -->
<a href="/metan_0.1/store/restEdit">Остатки на начало месяца (редактировать)</a>
<br>
<br>
<button class="selected_goods">Выбрать</button>
<button class="unselect_goods">Снять выделение</button>

<br><br>
<form method="get">
	<label for="filter">Фильтр</label>
	<input name="filter" id="filter" placeholder="<?php echo @$_GET['filter'] ?>">
	<button class="btn" id="apply_filter">Применить</button>
</form>
<div class="" style="float: right; ">
	Сумма:<b> <?php echo number_format($total, '2', '.', ' '); ?></b>
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
			if ($data['rest'] < 0) {
				$class = 'minus';
			}
			if ($data['rest'] == 0) {
				$class = 'nol';
			}
			// TODO что-то тут не так
			if (($data['receipt']!= 0) && (($data['price_from_rest'] && $data['price_from_doc']) && ($data['price_from_rest'] != $data['price_from_doc']))) {
				$class = 'invalid_price';
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
		'summaryText' => 'Строк: '.$count.'',
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
				'value'=>'CHtml::link($data[\'name\'], "#", array("class"=>"goodscart","gid"=>$data[\'id\'],  "onclick"=>"showGoodsCart($(this).attr(\'gid\')); return false;"))',
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
				'value'=>'number_format($data["price"], "2", ".", " ")',
				'header'=>'Цена',
				'htmlOptions'=>array('class'=>'r'),
			),
			array(
				'name'=>'rest_begin',
				'value'=>'$data[\'rest_begin\']',
				'header'=>'Остаток<br>на начало',
				'htmlOptions'=>array('class'=>'r'),
			),
			array(
				'name'=>'receipt',
				'value'=>'$data[\'receipt\']',
				'header'=>'Приход',
				'htmlOptions'=>array('class'=>'r'),
			),
			array(
				'name'=>'expence',
				'value'=>'$data[\'expence\']',
				'header'=>'Расход',
				'htmlOptions'=>array('class'=>'r'),
			),
			array(
				'name'=>'rest',
				'header'=>'Остаток',
				'htmlOptions' => array('class'=>'r'),
				'value' => '$data[\'inv\'] ? $data[\'rest\']." (".$data[\'inv\'].")" : $data[\'rest\']',
			),
		)
	));
	// условие ? значение1 : значение2
?>

