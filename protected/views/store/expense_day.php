<?php
$this->addCSS('store/expence_day.css');
$this->addCSS('store/search_form.css');
$this->addCSS('smoothness/jquery-ui-1.10.4.custom.css');
$this->addCSS('store/goodasCart.css');

$this->addJS('store/search_form.js');
//$this->addJS('store/expense.js');
$this->addJS('store/expence_day.js');
$this->addJS('jquery-ui.js');

// Utils::print_r($data[0]->idOperation->name);
//
$oper = array(
		51=>'Наличные',
		//52=>'',
		53=>'Продажа чеками',
		//54=>'kredit_30.png',
		//55=>'',
		56=>'Карта',
);
//Utils::print_r($oper);

?>

<div id="form">
	<div class="form_caption"></div>
	<div class="new_doc_hat">
		<div class="doc_title">
			<?php echo $this->pageTitle; ?>
			<div class='action new'>[добавление]</div>
		</div>
		<div class="row r2">
			<?php $d = explode('-', Yii::app()->session['workdate']); ?>
			<input type="hidden" name="expence[doc_date]" placeholder="Дата документа" required
			       value="<?php echo date('Y-m-d', mktime(0, 0, 0, $d[1], $d[2], $d[0])) ?>">
			<!-- pattern="[0-9]{2}\.[0-9]{2}\.[0-9]{4}" -->
		</div>
		<!-- r2 -->

		<div class="row r3">
			<input type="hidden" name="expence[doc_num]" placeholder="№ документа" value="0" required>
			<!-- pattern="[0-9]{2}\.[0-9]{2}\.[0-9]{4}" -->
		</div>
		<!-- r3 -->
	</div>
	<!-- <div class="doc_hat"> -->

	<div id="new_table">
		<table id="new_goods_table" doc_id='-1'>
			<thead>
			<tr>
				<th>
					<div class="th t0">Операция</div>
				</th>
				<th>
					<div class="th t01">Товарооборот</div>
				</th>
				<th>
					<div class="th t1">Код<br>товара</div>
				</th>
				<th>
					<div class="th t2">Наименование товара</div>
				</th>
				<th>
					<div class="th t3">Кол-<br>во</div>
				</th>
				<th>
					<div class="th t4">Цена</div>
				</th>
				<th>
					<div class="th t5">Сумма</div>
				</th>
			</tr>
			</thead>
			<tbody>
			<tr id="row_1" class="new_goods_row">
				<td>
					<?php
					//$list = CHtml::listData($oper, 'id', 'name');
					echo CHtml::dropDownList('expence[id_operation]',
						'51',
						$oper,
						array('class' => 'id_operation')
					// array('empty' => '(Select a category')
					);

					?>
				</td>
				<td>
					<select name="for" class="for" id="for">
						<option value="1">Общий товарооборот</option>
						<option value="2" selected="selected">Розничный товарооборот</option>
						<option value="3">Собственные нужды</option>
					</select>
				</td>
				<td>
					<input type="text" name="id_goods" class="id_goods search" list="id_goods_list"
					       placeholder="код товара">
				</td>
				<td>
					<input type="text" name="goods_name" class="goods_name search" list="goods_name_list"
					       placeholder="наименование">
				</td>
				<td>
					<input type="number" name="quantity" class="quantity" placeholder="Количество" required
					       pattern="[0-9]">
				</td>
				<td>
					<input type="number" name="price" class="price" placeholder="Цена" required pattern="[0-9]">
				</td>
				<td>
					<div class='summ'></div>
				</td>
			</tr>
			</tbody>
		</table>

		<details class="additional_data">
			<summary>Дополнительные данные</summary>
			<div class="docadditional">
				<div class="row">
					<label for="expence[payment_order]">Номер карты:</label>
					<input class="dop_data d1" name="expence[payment_order]" placeholder="">
					<!-- pattern="[0-9]{2}\.[0-9]{2}\.[0-9]{4}" -->
				</div>
				<div class="row">
					<label for="expence[descr]">Примечание:</label>
					<input class="dop_data d2" name="expence[descr]" placeholder="">
					<!-- pattern="[0-9]{2}\.[0-9]{2}\.[0-9]{4}" -->
				</div>
				<div class="row">
					<label for="expence[descr]">Оплата части товара:</label>
					<input type="checkbox" name="expence[part_of_c]">
					<?php
					$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
						'name'=>'Document',
//					'model'=>$fo,
//					'attribute'=>$fi,
					//			'name'=>'test1',
					//			'value'=>'',
						'source'=>$this->createUrl('MainAjax/autocomplete'.'/input/part_of'),
						'options'=>array(
							'showAnim'=>'fold',
							// обработчик события, выбор пункта из списка
							'select' =>'js: function(event, ui) {
					            // действие по умолчанию, значение текстового поля
					            // устанавливается в значение выбранного пункта
					            this.value = ui.item.label;
					            // устанавливаем значения скрытого поля
					            $("[name=\'expence[part_of_i]\']").val(ui.item.id);
					            $("[name=\'expence[part_of_c]\']").prop("checked", true);
					            return false;
					        }',
						),
						'htmlOptions' => array(
							'maxlength'=>50,
							'name'=>'expence[part_of_n]',
							'placeholder'=>'номер документа'
						),
					));

					?>
					<input class="dop_data d2" name="expence[part_of_i]" placeholder="id документа">
					<!-- pattern="[0-9]{2}\.[0-9]{2}\.[0-9]{4}" -->
				</div>
			</div>
		</details>

		<div class="form_footer">
			<button id="add_expence" type="button">Добавить</button>
			<button id="cancel_expence" type="button">Отмена</button>
		</div>
	</div>
</div>

<div class="delemiter"></div>

<div class="form">
	Касса на начало дня:
	<?php echo CHtml::textField('kassa_rest', number_format(Kassa::getRest(), '0', '.', '`'), array('id'=>'kassa_rest', 'rest'=>Kassa::getRest())); ?>
	<?php echo CHtml::button('Сохранить',array('onclick'=>'send();')); ?>
	<script type="text/javascript">

		function send()
		{

			var text = $("#kassa_rest").attr('rest');

			if (text=='') {
				alert('Введите сумму!');
				return false;
			}

			$.ajax({
				type: 'POST',
				url: '<?php echo Yii::app()->createAbsoluteUrl("store/kassa"); ?>',
				dataType:'json',
				data: {mess : text},
				success:function(data){
					console.log(data);
					if (data.status=='ok') {

					} else {
						alert('Ошибка сохранения!');
					}
//				alert(data.message);
//					location.reload();
				},

				error: function(data) { // if error occured
					console.log(data);
					alert(data.message);
				}
			});

		}

	</script>
</div><!-- form -->
<!-- ----------------------------------------------------------------------- -->
<div id="svodday">

</div>
<!-- ----------------------------------------------------------------------- -->
<table class="doc_data">
	<caption></caption>
	<thead>
	<tr>
		<th>№ п.п.</th>
		<th>Код</th>
		<th>Наименование товара</th>
		<th>Кол-во</th>
		<th>Розничная<br>цена</th>
		<th>Сумма<br>розница</th>
		<th>Операция</th>
		<th>Товаро-<br>оборот</th>
		<th>
			<button class="print_doc_button" title="Распечатать расход"></button>
		</th>
	</tr>
	</thead>
	<tbody>
	<?php
	$src = array(
		51=>'nal_30.png',
		52=>'',
		53=>'check_30.jpg',
		54=>'kredit_30.png',
		55=>'',
		56=>'karta_30.png',
	);
	$for = array('-1' => '-', '1' => 'Общий товарооборот', '2' => 'Розничный товарооборот', '3' => 'Собственные нужды');
	$i = count($data);
	?>

	<tr class="hidden template">
		<td class="npp"></td>
		<td class="id"></td>
		<td class="name"></td>
		<td class="quantity"></td>
		<td class="price"></td>
		<td class="sum"></td>
		<td class="operation"></td>
		<td class="for"></td>
		<td class="buttons">
			<button class='del'></button>
			<button class='edit'></button>
			<button class="save"></button>
		</td>
	</tr>

	<?php

	foreach ($data as $document) : ?>
		<tr doc_id="<?php echo $document->id; ?>"
			<?php
				if ($document->documentdata[0]->partof > 0) {
					$d = Document::model()->findByPK($document->documentdata[0]->partof);
					echo 'partof_num="' . $d->getAttribute('doc_num').' от '.Utils::format_date($d->getAttribute('doc_date')).'"';
					echo 'partof_id="' . $document->documentdata[0]->partof . '"';
					echo 'class="part"';
				}
			?>>
			<td class="npp"><?php echo $i--; ?></td>
			<td class="id"><?php echo $document->documentdata[0]->id_goods; ?></td>
			<td class="name">
				<?php
					echo CHtml::link($document->documentdata[0]->idGoods->name, '#', array('class'=>'goodscart','gid'=>$document->documentdata[0]->id_goods) );
//					echo CHtml::ajaxLink(
//									$document->documentdata[0]->idGoods->name,
//									array('store/goodsCart/'.$document->documentdata[0]->id_goods),
//									array('update' => '#mainDialogArea'),
//									array('onclick' => '$("#mainDialog").dialog("open");')
//						);
				?>
			</td>
			<td class="quantity"><?php echo $document->documentdata[0]->quantity; ?></td>
			<td class="price"
			    cost="<?php echo number_format($document->documentdata[0]->cost, '0', '.', '&nbsp;');?>"
			    markup="<?php echo number_format($document->documentdata[0]->markup, '0', '.', '&nbsp;');?>"
			    vat="<?php echo number_format($document->documentdata[0]->vat, '0', '.', '&nbsp;');?>"
				>
				<?php echo number_format($document->documentdata[0]->price, '0', '.', '&nbsp;');?>
			</td>
			<td class="sum"><?php echo number_format($document->documentdata[0]->price * $document->documentdata[0]->quantity, '0', '.', '&nbsp;'); ?></td>
			<td class="operation" id_operation="<?php echo $document->idOperation->id; ?>"
			    kart_num="<?php echo @$document->docaddition->payment_order; ?>"
				prim="<?php echo @$document->docaddition->descr; ?>">
				<?php echo CHtml::image(Yii::app()->request->baseUrl.'/images/'.$src[$document->idOperation->id],'', array('alt'=>$document->idOperation->name, 'title'=>$document->idOperation->name)); ?>
			</td>
			<td class="for" id_for="<?php echo $document->for; ?>"><?php echo $for[$document->for]; ?></td>
			<td class="buttons">
				<button class='del'></button>
				<button class='edit'></button>
				<button class="save"></button>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
