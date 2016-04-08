<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 18.09.15
 * Time: 8:10
 */

$this->addCSS('print/report.css');

?>
	<style>
		table {
			font-size: 14px;
		}
	</style>
	<div class="rep_wrapper">
		<div class="page l">
			<div class="report_title">
				Торг 4
			</div>
			<div class="sub_title">

			</div>

			<table>
				<thead>
					<tr>
						<th>Группа</th>
						<th>Код группы</th>
						<th>Количество</th>
						<th>Количество РБ</th>
						<th>Сумма</th>
						<th>Сумма РБ</th>
						<th>Остаток</th>
						<th>Остаток РБ</th>
					</tr>
				</thead>
			<?php
				//Utils::print_r($data);

				foreach ($data as $row) {
					$tr = '<tr>';
					$tr .= '<td>'.$row['name'].'</td>';
					$tr .= '<td>'.$row['id_3torg'].'</td>';
					$tr .= '<td class="r">'.$row['quantity'].'</td>';
					$tr .= '<td class="r">'.$row['quantity_rb'].'</td>';
					$tr .= '<td class="r">'.Yii::app()->format->formatNumber($row['sum']/1000000).'</td>';
					$tr .= '<td class="r">'.Yii::app()->format->formatNumber($row['sum_rb']/1000000).'</td>';
					$tr .= '<td>'.''.'</td>';
					$tr .= '<td>'.''.'</td>';
					$tr .= '</tr>';
					echo $tr;
				}

			?>
			</table>


<?php

//Utils::print_r($rest);
//Utils::print_r($sum2);
//Utils::print_r($sum->price - $sum2->price);
//Utils::print_r($rk);


