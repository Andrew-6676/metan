<?php
	$this->addCSS('print/report.css');
    $rec_doc = $data['doc'];
    $rec_doc_data = $data['details'];
     // print_r($data);
?>

	<div class="rep_wrapper">
		<div class="page l">
			<div class="report_title">РЕЕСТР РОЗНИЧНЫХ ЦЕН ПУ "ВИТЕБСКГАЗ" СКЛАД №2 /ТОВАРЫ/</div>
			<div class="sub_title">
				РЕЕСТР 1     Приложение к накладной № <?php echo $rec_doc->doc_num; ?> от <?php echo Utils::format_date($rec_doc->doc_date); ?>
			</div>
			<table>
<!--				<colgroup>-->
<!--					<col class="l">-->
<!--					<col class="r">-->
<!--					<col class="r">-->
<!--					<col class="r">-->
<!--					<col class="r">-->
<!--					<col class="r">-->
<!--					<col class="r">-->
<!--					<col class="r">-->
<!--					<col class="r">-->
<!--					<col class="r">-->
<!--					<col class="r">-->
<!--					<col class="r">-->
<!--					<col class="r">-->
<!--					<col class="r">-->
<!--					<col class="r">-->
<!--				</colgroup>-->
				<thead>
				<tr>
					<th>Код</th>
					<th>Наименование товара</th>
					<th>Ед.<br>изм.</th>
					<th>Кол-во</th>
					<th>Цена без НДС</th>
					<th>Опт.<br>надбавка</th>
					<th>Цена покупная</th>
					<th>Торговая надбавка</th>
					<th>Цена с учётом наценки</th>
					<th>Сумма</th>
					<th>НДС, %</th>
					<th>Сумма НДС</th>
					<th>Цена с НДС</th>
					<th>Розничная цена</th>
					<th>Сумма</th>
				</tr>
				</thead>

				<tbody>


					<?php


					foreach ($rec_doc_data as $row) {
						$tr = '<tr class="r">';
						$tr .=    "<td>";
						$tr .=          $row->idGoods->id;
						$tr .=    "</td>";
						$tr .=    '<td class="l">';
						$tr .=          $row->idGoods->name;
						$tr .=    "</td>";
						$tr .=    "<td>";
						$tr .=          $row->idGoods->unitname;
						$tr .=    "</td>";
						$tr .=    "<td>";
						$tr .=          number_format($row->quantity,'3','.'," ");
						$tr .=    "</td>";
						$tr .=    "<td>";
						$tr .=           number_format($row->cost,'0','.'," ");
						$tr .=    "</td>";
						$tr .=    "<td>";

						$tr .=    "</td>";
						$tr .=    "<td>";
						$tr .=          number_format($row->cost,'0','.'," ");
						$tr .=    "</td>";
						$tr .=    "<td>";
						$tr .=          $row->markup;
						$tr .=    "</td>";
						$tr .=    "<td>";
						$tr .=          number_format((($row->markup/100+1)*$row->cost),'0','.',' ');
						$tr .=    "</td>";
						$tr .=    "<td>";
						$tr .=          number_format(($row->markup/100+1)*$row->cost*$row->quantity,'0','.',' ');
						$tr .=    "</td>";
						$tr .=    "<td>";
						$tr .=          $row->vat;
						$tr .=    "</td>";
						$tr .=    "<td>";
						$tr .=          number_format((($row->vat/100)*($row->markup/100+1)*$row->cost*$row->quantity),'0','.'," ");
						$tr .=    "</td>";
						$tr .=    "<td>";
						$tr .=          number_format((($row->vat/100+1)*($row->markup/100+1)*$row->cost),'0','.'," ");
						$tr .=    "</td>";
						$tr .=    "<td>";
						$tr .=          number_format(($row->price),'0','.'," ");
						$tr .=    "</td>";
						$tr .=    "<td>";
						$tr .=          number_format(($row->price*$row->quantity),'0','.'," ");
						$tr .=    "</td>";
						$tr .= "</tr>";

						echo $tr;
					}
					$tr = '<tr class="r no_border"><td colspan="15"><br></td></tr>';

					$tr .= '<tr class="r no_border">';
					$tr .=    "<td colspan='2'>";
					$tr .=          'ВСЕГО';
					$tr .=    "</td>";
					$tr .=    "<td>";
//					$tr .=
					$tr .=    "</td>";
					$tr .=    "<td>";
//					$tr .=          number_format($row->quantity,'3','.'," ");
					$tr .=    "</td>";
					$tr .=    "<td>";
//					$tr .=           number_format($row->cost,'0','.'," ");
					$tr .=    "</td>";
					$tr .=    "<td>";

					$tr .=    "</td>";
					$tr .=    "<td>";
//					$tr .=          number_format($row->cost,'0','.'," ");
					$tr .=    "</td>";
					$tr .=    "<td>";
//					$tr .=          $row->markup;
					$tr .=    "</td>";
					$tr .=    "<td>";
					//					$tr .=          number_format(($row->markup/100+1)*$row->cost*$row->quantity,'0','.',' ');
					$tr .=    "</td>";
					$tr .=    "<td>";
					$tr .=          number_format($rec_doc->sum_with_markup,'0','.',' ');
					$tr .=    "</td>";
					$tr .=    "<td>";
//					$tr .=          $row->vat;
					$tr .=    "</td>";
					$tr .=    "<td>";
					$tr .=          number_format($rec_doc->sum_vat,'0','.',' ');
					$tr .=    "</td>";
					$tr .=    "<td>";
//					$tr .=          number_format((($row->vat/100+1)*($row->markup/100+1)*$row->cost),'0','.'," ");
					$tr .=    "</td>";
					$tr .=    "<td>";
//					$tr .=          number_format(($row->price),'0','.'," ");
					$tr .=    "</td>";
					$tr .=    "<td>";
					$tr .=          number_format(($rec_doc->sum_price),'0','.'," ");
					$tr .=    "</td>";
					$tr .= "</tr>";
						// ВСЕГО
					echo $tr;

					$tr = '<tr class="r no_border">';
					$tr .=    "<td colspan='2'>";
					$tr .=          'Сумма без наценки';
					$tr .=    "</td>";
					$tr .=    "<td>";
					//					$tr .=
					$tr .=    "</td>";
					$tr .=    "<td>";
					//					$tr .=          number_format($row->quantity,'3','.'," ");
					$tr .=    "</td>";
					$tr .=    "<td>";
					//					$tr .=           number_format($row->cost,'0','.'," ");
					$tr .=    "</td>";
					$tr .=    "<td>";

					$tr .=    "</td>";
					$tr .=    "<td>";
					//					$tr .=          number_format($row->cost,'0','.'," ");
					$tr .=    "</td>";
					$tr .=    "<td>";
					//					$tr .=          $row->markup;
					$tr .=    "</td>";
					$tr .=    "<td>";
					//					$tr .=          number_format(($row->markup/100+1)*$row->cost*$row->quantity,'0','.',' ');
					$tr .=    "</td>";
					$tr .=    "<td>";
					$tr .=          number_format($rec_doc->sum_cost,'0','.',' ');
					$tr .=    "</td>";
					$tr .=    "<td>";
					//					$tr .=          $row->vat;
					$tr .=    "</td>";
					$tr .=    "<td>";
//					$tr .=          number_format($rec_doc->sum_vat,'0','.',' ');
					$tr .=    "</td>";
					$tr .=    "<td>";
					//					$tr .=          number_format((($row->vat/100+1)*($row->markup/100+1)*$row->cost),'0','.'," ");
					$tr .=    "</td>";
					$tr .=    "<td>";
					//					$tr .=          number_format(($row->price),'0','.'," ");
					$tr .=    "</td>";
					$tr .=    "<td>";
//					$tr .=          number_format(($rec_doc->sum_price),'0','.'," ");
					$tr .=    "</td>";
					$tr .= "</tr>";
						// Сумма безнаценки
					echo $tr;

					$tr = '<tr class="r no_border">';
					$tr .=    "<td colspan='2'>";
					$tr .=          'В том числе торговая наценка';
					$tr .=    "</td>";
					$tr .=    "<td>";
					//					$tr .=
					$tr .=    "</td>";
					$tr .=    "<td>";
					//					$tr .=          number_format($row->quantity,'3','.'," ");
					$tr .=    "</td>";
					$tr .=    "<td>";
					//					$tr .=           number_format($row->cost,'0','.'," ");
					$tr .=    "</td>";
					$tr .=    "<td>";

					$tr .=    "</td>";
					$tr .=    "<td>";
					//					$tr .=          number_format($row->cost,'0','.'," ");
					$tr .=    "</td>";
					$tr .=    "<td>";
					//					$tr .=          $row->markup;
					$tr .=    "</td>";
					$tr .=    "<td>";
					//					$tr .=          number_format(($row->markup/100+1)*$row->cost*$row->quantity,'0','.',' ');
					$tr .=    "</td>";
					$tr .=    "<td>";
					$tr .=          number_format($rec_doc->sum_markup,'0','.',' ');
					$tr .=    "</td>";
					$tr .=    "<td>";
					//					$tr .=          $row->vat;
					$tr .=    "</td>";
					$tr .=    "<td>";
					//					$tr .=          number_format($rec_doc->sum_vat,'0','.',' ');
					$tr .=    "</td>";
					$tr .=    "<td>";
					//					$tr .=          number_format((($row->vat/100+1)*($row->markup/100+1)*$row->cost),'0','.'," ");
					$tr .=    "</td>";
					$tr .=    "<td>";
					//					$tr .=          number_format(($row->price),'0','.'," ");
					$tr .=    "</td>";
					$tr .=    "<td>";
					//					$tr .=          number_format(($rec_doc->sum_price),'0','.'," ");
					$tr .=    "</td>";
					$tr .= "</tr>";
					// В том числе торговая наценка
					echo $tr;
					?>

				</tbody>
			</table>

			<br><br><br><br>

			<div class="report_footer">
				<table style="width:600px;">
					<tr class="no_border">
						<td>Поставщик: <br><br></td>
						<td>Получатель: <br><br></td>
					</tr>
					<tr class="no_border">
						<td><br>______________________________</td>
						<td><br>______________________________</td>
					</tr>
					<tr class="no_border с" >
						<td>Руководитель предприятия</td>
						<td></td>
					</tr>
					<tr class="no_border">
						<td><br>______________________________</td>
						<td><br>______________________________</td>
					</tr>
					<tr class="no_border">
						<td>Экономист</td>
						<td></td>
					</tr>
				</table>
			</div>
		</div>
	</div>


<?php



