<?php

	$this->addCSS('print/report.css');
	$df = Utils::format_date($_GET['from_date']);
	$dt = Utils::format_date($_GET['to_date']);
//Utils::print_r($data);
?>


<div class="rep_wrapper">
	<div class="page p">
		<div class="report_title">ОТЧЕТ О РЕАЛИЗАЦИИ ГРУНТА
			<br>
			c <?php echo $df; ?> по <?php echo $dt; ?>
			<br>
			Магазин «Метан» г. Витебск
		</div>
		<table>
			<thead>
			<tr>
				<th>Наименование</th>
				<th>Ёмкость</th>
				<th>Количество</th>
				<th>Цена</th>
				<th>Сумма</th>
			</tr>
			</thead>

			<?php
				foreach ($data as $item) {
					$tr = '<tr>';
					$tr .=   '<td>';
					$tr .=      $item['name'];
					$tr .=   '</td>';
					$tr .=   '<td class="r">';
					$tr .=      $item['vol'];
					$tr .=   '</td>';
					$tr .=   '<td class="r">';
					$tr .=      number_format($item['quantity'], '0', ' ', ' ');
					$tr .=   '</td>';
					$tr .=   '<td class="r">';
					$tr .=      number_format($item['price'], '0', ' ', ' ');
					$tr .=   '</td>';
					$tr .=   '<td class="r">';
					$tr .=      number_format($item['sum'], '0', ' ', ' ');
					$tr .=   '</td>';
					$tr .= '</tr>';

					echo $tr;
				}
			?>
		</table>

<br>
<br>
<br>
<br>
<br>
		ЗАМ ЗАВ ТПК _____________________________________________________З. А. СМОЛЬСКАЯ

	</div>
</div>