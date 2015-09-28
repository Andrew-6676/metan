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

<h2>Товары без групп</h2>
<!--<p>-->
<!--You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>-->
<!--or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.-->
<!--</p>-->

<button id="btn_hide">
	Спрятать/показать строки с одним вариантом
</button>
<button id="btn_auto">
	Автоматически занести строки с одним вариантом
</button>

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
				'htmlOptions'=>array('class'=>'gr'),
			),
			array(
				'name'=>'samegoods',
				'header'=>'Предположительная группа',
				'type'=>'raw',
				'value'=>'$data->samegoods["data"]',
				'htmlOptions'=>array('class'=>'t'),
			),
		)
	));
DTimer::log('конец');
DTimer::show();
?>
	<style>
		button {
			padding: 2px 3px;

		}
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
				var tid = $(this).attr('tid');
				var gid = $(this).parent().attr('gid');
				var tr  = $(this).parent().parent().parent();
				set_group(tid, gid, tr);
				event.stopPropagation();
			});

			$('#btn_hide').text($('#btn_hide').text() +'(' + $('.tr_ok').size() + ')');
			$('#btn_auto').text($('#btn_auto').text() +'(' + $('.tr_ok').size() + ')');

			$('#btn_hide').click(function (event) {
				$('.tr_ok').toggleClass('hidden');
			});

			$('#btn_auto').click(function (event) {
				var arr = {};

				$('.tr_ok').each(function (i, e) {
					$(e).find('.gr').text( $(e).find('li').attr('tid'));
					arr[$(e).find('ul').attr('gid')] = $(e).find('li').attr('tid');
				});

				$.ajax({
					url: 'http://' + document.location.host + rootFolder + "/goods/set_gr",
					type: 'POST',
					dataType: "json",
					data: {data: arr},
					// функция обработки ответа сервера
					error: function (data) {
						alert(JSON.stringify(data) + '###');
						alert('Во время сохранения произошла ошибка. Проверьте введённые данные!');
						$('#overlay').hide();
						$('#loadImg').hide();
					},
					success: function (data) {
						console.log(data);
						if (data.status == 'ok') {
							//tr.find('.gr').text(tid);
						} else {
							$('#overlay').hide();
							$('#loadImg').hide();
							alert(data.message);
						}
					}
				});

			});
		});

		function set_group(tid, gid, tr) {
			console.log('добавить к '+gid+' группу '+tid);
//			console.log(tr);

			var arr = {};
			arr[gid] = tid;
			$.ajax({
				url: 'http://' + document.location.host + rootFolder + "/goods/set_gr",
				type: 'POST',
				dataType: "json",
				data: {data: arr},
				// функция обработки ответа сервера
				error: function (data) {
					alert(JSON.stringify(data) + '###');
					alert('Во время сохранения произошла ошибка. Проверьте введённые данные!');
					$('#overlay').hide();
					$('#loadImg').hide();
				},
				success: function (data) {
					console.log(data);
					if (data.status == 'ok') {
						tr.find('.gr').text(tid);
					} else {
						$('#overlay').hide();
						$('#loadImg').hide();
						alert(data.message);
					}
				}
			});


			//tr.find('.gr').text(tid);
		}
	</script>

<?php

