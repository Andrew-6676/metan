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
				Торг 4 (<?php echo $kv; ?> квартал)
			</div>
			<div class="sub_title">

			</div>

			<table>
				<thead>
					<tr>
						<th rowspan="2">Группа</th>
						<th rowspan="2">Код группы</th>
						<th rowspan="2">Месяц</th>
						<th colspan="2">Количество</th>
						<th colspan="2">Сумма, <br>тыс.руб</th>
						<th colspan="2">Остаток кол-во</th>
						<th colspan="2">Остаток тыс.руб.</th>
					</tr>
					<tr>
						<th>Всего</th>
						<th>в том числе РБ</th>
						<th>Всего</th>
						<th>в том числе РБ</th>
						<th>Всего</th>
						<th>в том числе РБ</th>
						<th>Всего</th>
						<th>в том числе РБ</th>
					</tr>
				</thead>
			<?php
				//Utils::print_r($data);

				foreach ($data as $row) {
					$tr = '<tr>';
					$tr .= '<td>'.$row['name'].'</td>';
					$tr .= '<td>'.$row['id_3torg'].'</td>';
					$tr .= '<td>'.Utils::$ru_month[$row['month']].'</td>';
					$tr .= '<td class="r">'.$row['quantity'].'</td>';
					$tr .= '<td class="r">'.$row['quantity_rb'].'</td>';
					$tr .= '<td class="r">'.Yii::app()->format->formatNumber($row['sum']/1000).'</td>';
					$tr .= '<td class="r">'.Yii::app()->format->formatNumber($row['sum_rb']/1000).'</td>';
					$tr .= '<td class="r">'.@$rst[0][$row['id_3torg']]['q'].'</td>';
					$tr .= '<td class="r">'.@$rst[1][$row['id_3torg']]['q'].'</td>';
					$tr .= '<td class="r">'.Yii::app()->format->formatNumber(@$rst[0][$row['id_3torg']]['s']/1000).'</td>';
					$tr .= '<td class="r">'.Yii::app()->format->formatNumber(@$rst[1][$row['id_3torg']]['s']/1000).'</td>';
					$tr .= '</tr>';
					echo $tr;
				}
				// TODO суммы по столбцам
			?>
			</table>


<?php

//Utils::print_r($rst);
//Utils::print_r($sum2);
//Utils::print_r($sum->price - $sum2->price);
//Utils::print_r($rk);


