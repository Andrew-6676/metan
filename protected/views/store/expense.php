<?php
	$this->addCSS('store/expence.css');
	$this->addCSS('smoothness/jquery-ui-1.10.4.custom.css');
	$this->addCSS('store/search_form.css');

  	$this->addJS('store/search_form.js');
	$this->addJS('store/expence.js');
	$this->addJS('jquery-ui.js');

	// echo '<pre>';
	// print_r($oper);
	// echo '</pre>';


$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id' => 'mydialog2',
	'options' => array(
		'title'         => 'Реквизиты ТТН/ТН',
		'autoOpen'      => FALSE,
		'modal'         => true,
		'closeOnEscape' => 'true',
		'width'         =>'700',
		'top'           => '30',
		'resizable'     => false,
//		'position'=> '{ my: "left top", at: "left bottom", of: button }',
		'position'=>array('50%',180),
		'buttons'       => array(
			'Печать'=>'js:function(){alert("ok")}',
			'Отмена'=>'js:function(){alert("cancel")}',),
	),
));

?>

<div id="regions_tree"></div>

<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');


//print CHtml::ajaxLink('Объекты', array('store/getForm','form'=>'deliverynote'),
print CHtml::ajaxLink('Объекты', array('store/prepareDeliverynote'),
	array('update' => '#regions_tree'),
	array('onclick' => '$("#mydialog2").dialog("open");', 'title' => 'Реквизиты ТТН/ТН', 'id'=>'ttn', 'style'=>'display:none')
);

?>

<div id="form">
	<div class="form_caption"></div>
	<div class="new_doc_hat">
		<div class="doc_title">
			<?php echo $this->pageTitle; ?>
			<div class='action new'>[новый]</div>
		</div>
		<div class="row r1">
			<label for="expence[id_operation]">Вид расхода:</label>
			<?php
				$list = CHtml::listData($oper,
			                'id', 'name');
				// echo '<pre>';
				// print_r($list);
				// echo '</pre>';
				echo CHtml::dropDownList('expence[id_operation]',
									  	  '51',
					              		  $list,
					              		  array('class'=>'ddd')
					              		 // array('empty' => '(Select a category')
			              			);

			?>
			<select name="for" class="for" id="for">
				<option value="-1">-</option>
				<option value="1">Общий товарооборот</option>
				<option value="2">Розничный товарооборот</option>
				<option value="3">Собственные нужды</option>
			</select>
		</div> <!-- r1 -->

		<div class="row r2">
			<label for="expence[doc_date]">Дата расхода:</label>
			<?php
				$d = explode('-', Yii::app()->session['workdate']);
			?>
			<input type="date" name="expence[doc_date]" placeholder="Дата документа" required value="<?php echo date('Y-m-d', mktime(0,0,0,$d[1],$d[2],$d[0])) ?>"> <!-- pattern="[0-9]{2}\.[0-9]{2}\.[0-9]{4}" -->
		</div>	<!-- r2 -->

		<div class="row r3">
			<label for="expence[doc_num]">№ документа:</label>
			<input type="number" name="expence[doc_num]" placeholder="№ документа" value="<?php echo $doc_num ?>" required> <!-- pattern="[0-9]{2}\.[0-9]{2}\.[0-9]{4}" -->
		</div>	<!-- r3 -->
	</div>    <!-- <div class="doc_hat"> -->

	<div id="new_table">
		<table id="new_goods_table"  doc_id='-1'>
			<thead>
				<tr>
					<th><div class="th t1">Код товара</div></th>
					<th><div class="th t2">Наименование товара</div></th>
					<th><div class="th t3">Количество</div></th>
					<th><div class="th t4">Цена</div></th>
					<th><div class="th t5">Сумма</div></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<tr id="row_1" class="new_goods_row">
					<td>
						<input type="text" name="id_goods" class="id_goods search" list="id_goods_list" placeholder="код товара">
					</td>
					<td>
						<input type="text" name="goods_name" class="goods_name search" list="goods_name_list" placeholder="наименование">
					</td>
					<td>
						<input type="number" name="quantity" class="quantity" placeholder="Количество" required pattern="[0-9]">
					</td>
					<td>
						<input type="number" name="price" class="price" placeholder="Цена" required pattern="[0-9]">
					</td>
					<td>
						<div class='summ'></div>
					</td>
					<td>
						<div class="td_buttons">
							<button type="button" class="clr_row"></button>
							<button type="button" class="del_row"></button>
						</div>
					</td>
				</tr>
			</tbody>
			<tfoot>
				<tr><td colspan='6' class='itog_summ'>0</td></tr>
			</tfoot>
		</table>
		<details class="additional_data">
			<summary>Дополнительные данные</summary>
			<div class="docadditional">
				<div class="row">
					<label for="expence[payment_order]">Платёжное поручение:</label>
					<input type="number" name="expence[payment_order]" placeholder="Платёжное поручение" value="" > <!-- pattern="[0-9]{2}\.[0-9]{2}\.[0-9]{4}" -->
				</div>
				<div class="row">
					<label for="expence[descr]">Примечание:</label>
					<input type="number" name="expence[descr]" placeholder="Платёжное поручение" value="" > <!-- pattern="[0-9]{2}\.[0-9]{2}\.[0-9]{4}" -->
				</div>
			</div>
		</details>
		<div class="form_footer">
			<button id="add_new_row" type="button">Добавить строку</button>
			<button id="add_expence" type="button">Сохранить</button>
			<button id="cancel_expence" type="button">Отмена</button>
			<button id="clear_form" type="button">Очистить</button>
		</div>
	</div>
</div>

<div class="delemiter"></div>

<div class="page_caption">
	Расход за <b><u>
	<?php
		echo Utils::getMonthName(intval(substr(Yii::app()->session['workdate'],5,2)));
		echo date(' Y');
	?>
	г.</b></u>
	<?php echo ' (документов: <span class="counter">'.count($data).')</span>'; ?>
</div>

<div class="data">
<?php

//	 $this->widget('ExpenceWidget',array(
//	 						'data'=>$data,
//	 		                ));

	$this->widget('SuperdocWidget',array(
		'data'=>$data,
		//'mode'=>'one_to_many',
		'head'=>array(
			'doc_num'=>'Документ №',
			'doc_date'=>'Дата',
			'contact.name'=>'Покупатель',
			'operation.name'=>'Вид расхода',
//			'for'=>'',
//			'sum_vat'=>'Сумма НДС',
//			'sum_cost'=>'Сумма',
			'sum_price'=>'Сумма',
//			'paymentorder'=>''
		),
		'columns'=> array(
			'id_goods'=>'Код',
			'goods.name'=>'Наименование товара',
			'quantity'=>'Количество',
//			'vat'=>'НДС',
			'price'=>'Розничная цена',
			'=quantity*price'=>'Сумма розница'
		),
		'buttons'=>array('print','del','edit'),
	));

?>
</div>