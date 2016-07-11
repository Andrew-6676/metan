<?php
	$this->addJS('store/receipt.js');
	$this->addCSS('store/receipt.css');

	// $this->addCSS('');
	// $this->addJS('');
?>
<div class="page_head">
	<div class="doc_title">
		<?php echo $this->pageTitle; ?>
		<!--		<div class='action new'>Просмотр</div>-->
	</div>
</div>
<div class="page_caption">
	Приход товара за <b><u>
	<?php
		echo Utils::getMonthName(intval(substr(Yii::app()->session['workdate'],5,2)));
		echo date(' Y');
	?>
	г.</b></u>
	<?php echo ' (документов: '.count($data).')'; ?>
	<br>
	<?php echo ' Сумма: <b>'.number_format($sum->price, '2', '.', '&nbsp;').'</b>'; ?>
</div>

<div class="data">
<?php
//Utils::print_r($data);
//	$this->widget('DocWidget',array(
//							'data'=>$data,
//							'mode'=>'one_to_many',
//							'columns'=> array('doc_num','doc_date','reason'),
//			                ));
//exit;
	$this->widget('SuperdocWidget',array(
		'data'=>$data,
		//'mode'=>'one_to_many',
		'head'=>array(
			'doc_num'=>'Документ №',
			'doc_date'=>'Дата',
			'contact.name'=>'Поставщик',
			'sum_vat'=>'Сумма НДС',
//			'sum_cost'=>'Сумма',
			'sum_price'=>'Сумма розница',
		),
		'columns'=> array(
			'id_goods'=>'Код',
			'goods.id_3torg'=>'Группа',
			'goods.name'=>'Наименование товара',
			'cost'=>'Оптовая цена',
			'markup'=>'Наценка',
			'vat'=>'НДС',
			'price'=>'Розничная цена',
			'quantity'=>'Количество',
			'=quantity*cost'=>'Сумма опт',
			'=quantity*price'=>'Сумма розница'
		),
		'buttons'=>array('print'=>'Печать реестра','cennic'=>'Печать ценников','deactivate'=>'Удалить приход'),
	));

?>
	<br><br>
	<details class="detail">
		<summary>Удалённые накладные</summary>
	<?php
$this->widget('SuperdocWidget',array(
	'data'=>$data2,
	//'mode'=>'one_to_many',
	'head'=>array(
		'doc_num'=>'Документ №',
		'doc_date'=>'Дата',
		'contact.name'=>'Поставщик',
		'sum_vat'=>'Сумма НДС',
//			'sum_cost'=>'Сумма',
		'sum_price'=>'Сумма розница',
	),
	'columns'=> array(
		'id_goods'=>'Код',
		'goods.id_3torg'=>'Группа',
		'goods.name'=>'Наименование товара',
		'cost'=>'Оптовая цена',
		'markup'=>'Наценка',
		'vat'=>'НДС',
		'price'=>'Розничная цена',
		'quantity'=>'Количество',
		'=quantity*cost'=>'Сумма опт',
		'=quantity*price'=>'Сумма розница'
	),
	'buttons'=>array('print'=>'Печать реестра','cennic'=>'Печать ценников','restore'=>'Востановить','del'=>'Удалить приход'),
));
?>
		</details>
</div>