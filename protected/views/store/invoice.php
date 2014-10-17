<?php
	$this->addCSS('store/expence.css');
	$this->addCSS('store/invoice.css');
	$this->addCSS('smoothness/jquery-ui-1.10.4.custom.css');
	$this->addJS('store/expence.js');
	$this->addJS('store/invoice.js');
	$this->addJS('jquery-ui.js');
	// echo '<pre>';
	// print_r($oper);
	// echo '</pre>';
?>

<div id="form">
	<div class="form_caption"></div>
	<div class="new_doc_hat">

		<div class="row r0">
			<label for="invoice[contact]">Потребитель:</label>
			<input type="text" id='contact_name' cid='' name="invoice[contact]" placeholder="Потребитель" required value="">
			<button class='add_contact' title='Добавить нового потребителя'></button>
			<div class='new_contact'>
				<input id='new_contact[id]' class='s' placeholder='Код'>
				<input id='new_contact[name]' class='l' placeholder='Короткое наименование нового потребителя'>
				<br>
				<input id='new_contact[fname]' class='l' placeholder='Полное наименование нового потребителя'>
				<br>
				<input id='new_contact[address]' class='l' placeholder='Адрес'>
				<br>
				<input id='new_contact[unn]' class='s' placeholder='УНН'>
				<input id='new_contact[rs]' class='s' placeholder='Расчётный счёт'>
				<input id='new_contact[mfo]' class='s' placeholder='МФО'>
				<input id='new_contact[okpo]' class='s' placeholder='ОКПО'>
				<br>
				<input id='new_contact[bank]' class='l' placeholder='Банк'>
				<div class='buttons'>
					<button id='add_new_contact'>Сохранить</button>
					<button id='cancel_new_contact'>Отмена</button>
				</div>

			</div>
			<!-- [+ новый потребитель] -->
		</div>	<!-- r0 -->

		<!--div class="row r1">
			<label for="invoice[contact]">Потребитель:</label>
			<?php
				// $list = CHtml::listData($contact,
			 //                'id', 'name');
				// // echo '<pre>';
				// // print_r($list);
				// // echo '</pre>';
				// echo CHtml::dropDownList('contact[id_operation]',
				// 					  	  '',
				// 	              		  $list,
				// 	              		  array('class'=>'ddd')
				// 	              		 // array('empty' => '(Select a category')
			 //              			);

			?>
		</div --> <!-- r1 -->

		<div class="row r2">
			<label for="invoice[doc_date]">Дата документа:</label>
			<?php
				$d = explode('-', Yii::app()->session['workdate']);
			?>
			<input type="date" name="invoice[doc_date]" placeholder="Дата документа" required value="<?php echo date('Y-m-d', mktime(0,0,0,$d[1],$d[2],$d[0])) ?>"> <!-- pattern="[0-9]{2}\.[0-9]{2}\.[0-9]{4}" -->
		</div>	<!-- r2 -->

		<div class="row r3">
			<label for="invoice[doc_num]">№ документа:</label>
			<input type="text" name="invoice[doc_num]" placeholder="№ документа" value="<?php echo $doc_num ?>" required> <!-- pattern="[0-9]{2}\.[0-9]{2}\.[0-9]{4}" -->
		</div>	<!-- r3 -->
	</div>    <!-- <div class="doc_hat"> -->

	<div id="new_table">
		<table id="new_goods_table">
			<thead>
				<tr>
					<th><div class="th t1">Код товара</div></th>
					<th><div class="th t2">Наименование товара</div></th>
					<th><div class="th t3">Количество</div></th>
					<th><div class="th t4">НДС, %</div></th>
					<th><div class="th t5">Цена</div></th>
					<th><div class="th t6">Сумма</div></th>
					<th></th>
				</tr>
			</thead>
			<tr id="row_1" class="new_goods_row">
				<td>
					<input type="text" name="id_goods" class="id_goods" placeholder="код товара">
				</td>
				<td>
					<input type="text" name="goods_name" class="goods_name" placeholder="наименование">
				</td>
				<td>
					<input type="number" name="quantity" class="quantity" placeholder="Количество" required pattern="[0-9]">
				</td>
				<td>
					<input type="number" name="vat" class="vat" placeholder="НДС, %" required pattern="[0-9]">
				</td>
				<td>
					<input type="number" name="price" class="price" placeholder="Цена" required pattern="[0-9]">
				</td>
				<td>
					<div class='summ'></div>
				</td>
				<td>
					<div class="td_buttons">
						<button type="button" class="clr_row" title='Очистить строку'></button>
						<button type="button" class="del_row" title='Удалить строку'></button>
					</div>
				</td>
			</tr>
		</table>
		<button id="add_new_row" type="button">Добавить строку</button>
	</div>
	<div class="form_footer">
		<button id="add_invoice" type="button">Сохранить</button>
		<button id="clear_invoice" type="button">Очистить</button>
	</div>
</div>

<br>
<hr>
<br>

<div class="page_caption">
	Счёт-фактуры за <b><u>
	<?php
		echo Utils::getMonthName(intval(substr(Yii::app()->session['workdate'],5,2)));
		echo date(' Y');
	?>
	г.</b></u>
	<?php echo ' (кол-во: <span class="counter">'.count($data).')</span>'; ?>
<div>

<div class="data">
<?php

	$this->widget('InvoiceWidget',array(
	  						'data'=>$data,
	  		                ));
	//Utils::print_r($data);
?>
</div>