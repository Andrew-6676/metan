<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 18.08.15
 * Time: 16:53
 */

$this->addCSS('print/report.css');

?>
	<div class="rep_wrapper">
		<div class="page l">
			<div class="rekvizit" style="height: 75px;">
				<div class="post" style="float: left" width="40%">
					<table class="no_border">
						<tr>
							<td>
								Поставщик: <?php echo Store::model()->findByPk($_GET['id_store'])->storepassports[0]->name; ?>
							</td>
						</tr>
						<tr>
							<td>
								Адрес: <?php echo Store::model()->findByPk($_GET['id_store'])->storepassports[0]->address; ?>
							</td>
						</tr>
						<tr>
							<td>
								P/c <?php echo Store::model()->findByPk($_GET['id_store'])->storepassports[0]->account; ?>
								<?php echo Store::model()->findByPk($_GET['id_store'])->storepassports[0]->bank; ?>
								, МФО <?php echo Store::model()->findByPk($_GET['id_store'])->storepassports[0]->mfo; ?>
							</td>
						</tr>
						<tr>
							<td>
								Идентификационный номер покупателя
								(ИНН): <?php echo Store::model()->findByPk($_GET['id_store'])->storepassports[0]->unn; ?>
							</td>
						</tr>
						<tr>
							<td>
								Код
								ОКПО: <?php echo Store::model()->findByPk($_GET['id_store'])->storepassports[0]->okpo; ?>
							</td>
						</tr>
					</table>
				</div>
				<div class="pokup" style="float: right" width="40%">
					<table class="no_border">
						<tr>
							<td>
								Покупатель: <?php echo $data['rec_doc']->contact->fname; ?>
							</td>
						</tr>
						<tr>
							<td>
								Адрес: <?php echo $data['rec_doc']->contact->address; ?>
							</td>
						</tr>
						<tr>
							<td>
								P/c <?php echo $data['rec_doc']->contact->rs; ?>
								<?php echo $data['rec_doc']->contact->bank; ?>
								, МФО <?php echo $data['rec_doc']->contact->mfo; ?>
							</td>
						</tr>
						<tr>
							<td>
								Идентификационный номер покупателя (ИНН): <?php echo $data['rec_doc']->contact->unn; ?>
							</td>
						</tr>
						<tr>
							<td>
								Код ОКПО: <?php echo $data['rec_doc']->contact->okpo; ?>
							</td>
						</tr>
						<tr>
							<td>
								На основании договора <?php echo $data['rec_doc']->contact->agreement; ?>
							</td>
						</tr>
					</table>
				</div>
			</div>
			<div>
			<div style="font-size: 12px;">
				ОПЛАТА В ТЕЧЕНИЕ 10 БАНКОВСКИХ ДНЕЙ
				<br>
				Счёт-фактура является протоколом согласования цен
			</div>
			</div>
			<div class="report_title">
				СЧЁТ-ФАКТУРА № <?php echo $data['rec_doc']->doc_num; ?>
				от <?php echo Utils::format_date($data['rec_doc']->doc_date); ?>
			</div>

		<?php
		//	Utils::print_r($_GET);
		//Utils::print_r($data);
		//exit;
		// //  Utils::print_r($rec_doc_data );
		//   // $this->controller->render('receipt', array('workdate'=>$workdate, 'id_store'=>$id_store, 'data'=>$receipt_doc));
		$npp = 1;
		?>
		<table>
			<thead>
			<tr>
				<th>№</th>
				<th>Код</th>
				<th>Наименование товара</th>
				<th>Ед. <br>изм.</th>
				<th>Кол-во</th>
				<th>Цена<br>покупная, руб.</th>
				<th>Торг.<br>надбавка, %</th>
				<th>Цена<br>с учётом<br>надбавки</th>
				<th>Сумма<br>с учётом<br>надбавки</th>
				<th>НДС, %</th>
				<th>Сумма<br>НДС, руб.</th>
				<th>Цена<br>розничная, руб.</th>
				<th>Сумма, руб.</th>
				<th>Изготовитель</th>
			</tr>
			</thead>
			<tbody>
			<?php
			foreach ($data['rec_doc_data'] as $row) {
				$tr = '<tr class="r">';
				$tr .= '<td>';
				$tr .= $npp++;
				$tr .= '</td>';
				$tr .= '<td>';
				$tr .= $row->idGoods->id;
				$tr .= '</td>';
				$tr .= '<td class="l">';
				$tr .= $row->idGoods->name;
				$tr .= '</td>';
				$tr .= '<td class="c">';
				$tr .= $row->idGoods->unitname;
				$tr .= '</td>';
				$tr .= '<td>';
				$tr .= number_format($row->quantity, '0', '.', ' ');
				$tr .= '</td>';
				$tr .= '<td>';
				$tr .= number_format($row->cost, '0', '.', ' ');
				$tr .= '</td>';
				$tr .= '<td>';
				$tr .= number_format($row->markup, '0', '.', ' ');
				$tr .= '</td>';
				$tr .= '<td>';
				$tr .= number_format($row->cost * (1 + $row->markup/100), '0', '.', ' ');
				$tr .= '</td>';
				$tr .= '<td>';
				$tr .= number_format($row->quantity * $row->cost * (1 + $row->markup / 100), '0', '.', ' ');
				$tr .= '</td>';
				$tr .= '<td>';
				$tr .= $row->vat; //number_format($row->vat, '', '.', ' ');
				$tr .= '</td>';
				$tr .= '<td>';
//				$tr .= number_format($row->vat / 100 * $row->quantity * $row->cost * (1 + $row->markup / 100), '0', '.', ' ');
				$tr .= number_format($row->vat / 100 * $row->quantity * $row->price, '0', '.', ' ');
				$tr .= '</td>';
				$tr .= '<td>';
				$tr .= number_format($row->price, '0', '.', ' ');
				$tr .= '</td>';
				$tr .= '<td>';
				$tr .= number_format($row->price * $row->quantity, '0', '.', ' ');
				$tr .= '</td>';
				$tr .= '<td class="l">';
				$tr .= $row->goods->producer;
				$tr .= '</td>';
				$tr .= '</tr>';
				echo $tr;
			}
					// строка с итогами
			$tr = '<tr class="r">';
			$tr .= '<td class="no_border l" colspan="7">';
			$tr .= 'ВСЕГО';
			$tr .= '</td>';
			$tr .= '<td class="no_border">';
			$tr .= '</td>';
			$tr .= '<td class="no_border r">';
			$tr .= number_format($data['rec_doc']->sum_with_markup, '0', '.', ' ');
			$tr .= '</td>';
			$tr .= '<td class="no_border">';

			$tr .= '</td>';
			$tr .= '<td class="no_border r">';
			$tr .=      number_format($data['rec_doc']->sum_vat2, '0', '.', ' ');
			$tr .= '</td>';
			$tr .= '<td class="no_border">';
			$tr .= '</td>';
			$tr .= '<td class="no_border r">';
			$tr .=      number_format($data['rec_doc']->sum_price, '0', '.', ' ');
			$tr .= '</td>';
			$tr .= '<td class="no_border">';
			$tr .= '</td>';
			$tr .= '</tr>';

			$tr .= '<tr>';
			$tr .= '<td class="no_border" colspan="14">';
			$tr .= '</td>';
			$tr .= '</tr>';
			$tr .= '<tr>';
			$tr .= '<td class="no_border" colspan="14">';
			$tr .= (Utils::num2str($data['rec_doc']->sum_price));
			$tr .= '</td>';
			$tr .= '</tr>';
			echo $tr;
			?>
			</tbody>
		</table>
		<br>
		<hr>

		<div class="report_footer">
			Наименование
			<br>
			Изготовитель
			<br>
			Обоснование
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>

			<table width="100%" class="no_border">
				<tr>
					<td width="20%">
						<span style="padding-left: 150px">М.П. продавца</span>
					</td>
					<td width="40%">
						<span style="padding-left: 150px">
							<?php
							echo User::model()->findByPk($_GET['u'])->post;
							echo ', ';
							echo User::model()->findByPk($_GET['u'])->name;
							?>
						</span>
					</td>
					<td>
						<span style="padding-left: 150px">М.П. покупателя</span>
					</td>
				</tr>
			</table>
		</div>
	</div>

</div>
<?php

