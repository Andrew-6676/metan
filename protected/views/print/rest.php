<?php
	$this->addCSS('print/rest.css');
//echo $workdate;
	echo '<div class="report_title">';
		echo '<div class="div_left">'.Store::model()->findByPk($id_store)->fname.'</div>';
		$d = explode('-', $workdate);
		echo '<div class="div_center">Наличие товара на '.date('d.m.Y', mktime(0,0,0,$d[1],$d[2],$d[0])).'</div>';
		echo '<div class="div_right">'.date('d.m.Y').'</div>';
	echo '</div>';
?>
<br>
<br>
<table>
	<thead>
		<tr>
			<th rowspan='2' class="n">№<br>п.п.</th>
			<th rowspan='2' class="gid">Код</th>
			<th rowspan='2' class="gname">Наименование товара</th>
			<th rowspan='2' class="price">Цена</th>
			<th colspan='2' class="">Остаток</th>
		</tr>
		<tr>
			<th class='rest'>Кол-во</th>
			<th class='sum'>Сумма</th>
		</tr>
	</thead>

<?php
//echo count($data).'<br>';
	// echo '<pre>';
	// print_r($data);
	// echo '</pre>';
	$sum_m = 0;
	$sum_gr= 0;
	$n = 1;
	$curr_group = $data[0]['ggname'];
	$group = '';
	foreach ($data as $row) {
		$group = $row['ggname'];
			// если сменилась группа
		if ($group!=$curr_group) {

				// выводим итог, если
			echo '<tr class="sum_gr">';
			echo '<td colspan="5"><b>Итого по группе</b> '.$curr_group.'</td>';
				echo '<td class="sum">'.number_format($sum_gr, '2','.',' ').'</td>';
			echo '</tr>';
				// начинаем новую группу
			// echo '<tr>';
			// 	echo '<td colspan="6"';
			// 		//echo $group;
			// 	echo '</td>';
			// echo '</tr>';
			$curr_group = $row['ggname'];
			$sum_gr = 0;
		}

		$sum_m += $row['rest']*$row['price'];
		$sum_gr += $row['rest']*$row['price'];

		echo '<tr>';
			echo '<td class="n">'.$n++.'</td>';
			echo '<td class="gid">'.$row['gid'].'</td>';
			echo '<td class="gname">'.$row['gname'].'</td>';
			echo '<td class="price">'.number_format($row['price'], '2','.',' ').'</td>';
			echo '<td class="rest">'.$row['rest'].'</td>';
			echo '<td class="sum">'.number_format($row['rest']*$row['price'], '2','.',' ').'</td>';
		echo '</tr>';
	}


	echo '<tr class="sum_gr">';
		echo '<td colspan="5"><b>Итого по группе</b>'.$group.'</td>';
		echo '<td class="sum">'.number_format($sum_gr, '2','.',' ').'</td>';
	echo '</tr>';

	echo '<tr class="sum_m">';
		echo '<td colspan="5"><b>ИТОГО ПО МАГАЗИНУ</b></td>';
		echo '<td class="sum">'.number_format($sum_m, '2','.',' ').'</td>';
	echo '</tr>';
?>
</table>