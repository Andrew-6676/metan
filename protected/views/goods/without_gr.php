<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 25.08.15
 * Time: 16:22
 */

//
//$this->menu=array(
//	array('label'=>'List Goods', 'url'=>array('index')),
//	array('label'=>'Create Goods', 'url'=>array('create')),
//);

//Yii::app()->clientScript->registerScript('search', "
//$('.search-button').click(function(){
//	$('.search-form').toggle();
//	return false;
//});
//$('.search-form form').submit(function(){
//	$('#goods-grid').yiiGridView('update', {
//		data: $(this).serialize()
//	});
//	return false;
//});
//");
?>

<h1>Товары без групп</h1>

<!--<p>-->
<!--You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>-->
<!--or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.-->
<!--</p>-->

<?php
//Utils::print_r($data);

DTimer::log('старт');	// засекаем время выполнения

	$this->widget('zii.widgets.grid.CGridView', array(
		'rowCssClassExpression' => function($row, $data) {
			// $row - номер строки начиная с 0
			// $data - ваша моделька
			$class = '';
			if ($data->samegoods['count'] == 1) { // выделяем вторую! строку
				$class = 'tr_ok';
			}
			if ($data->samegoods['count'] == 0) { // выделяем вторую! строку
				$class = 'tr_none';
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
		'columns' => array(
			array(
				'name'=>'npp',
				'type'=>'raw',
				'value'=> '$row',
			),
			array(
				'name'=>'id',
				'header'=>'Код',
				'type'=>'raw',
				'value'=> 'CHtml::link($data->id,array("goods/update/".$data->id))',
			),
			array(
				'name'=>'name',
				'header'=>'Наименование'
			),
			array(
				'name'=>'id_3torg',
				'header'=>'3-торг',
				'type'=>'raw',
				'value'=>'',
//				'htmlOptions'=>array('class'=>'r'),
			),
			array(
				'name'=>'samegoods',
				'header'=>'samegoods',
				'type'=>'raw',
				'value'=>'$data->samegoods["data"]'
			),
		)
	));
DTimer::log('конец');
DTimer::show();
?>
	<style>
		table.items{
			font-size: 0.9em;
		}
		.lst {
			margin-left: 20px !important;
		}
		.lst li {
			margin: 5px 0;
		}
		.lst li:hover {
			color: #f00 !important;
			cursor: pointer;
		}
		.tr_none {
			background: #FFB4B4 !important;
		}
		.tr_ok {
			/*display: none;*/
			color: #bcbcbc;
			font-size: 0.8em;
		}
		.tr_ok:hover {
			color: #000;
		}
	</style>
	<script>
		$(document).ready(function () {
			$('.lst li').click(function (event) {

				event.stopPropagation();
			});
		});

	</script>

<?php

