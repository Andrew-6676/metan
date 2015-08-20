<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 17.08.15
 * Time: 11:53
 */

//print_r($data);

$this->addCSS('print/report.css');

$df = Utils::format_date($_GET['from_date']);
$dt = Utils::format_date($_GET['to_date']);

//Utils::print_r($data);
//return;
$expence = array_shift($data);

?>

<div class="rep_wrapper">
	<div class="report_title">Товарно-денежный отчёт запериод с <?php echo $df; ?> по <?php echo $dt; ?></div>

<!-- Приход ------------------------------------------------------------------------------ -->

	<?php

	$docs = array_shift($data);
	$key = array_keys($docs);
	?>

	<div class="sub_title">
		<?php echo $key[0]; ?>
	</div>

	<?php
//	Utils::print_r($key);
//	echo count($docs[$key[0]]);
//	Utils::print_r($docs);
	?>
	<table>
		<thead>
			<tr>
				<th>Дата</th>
				<th>Номер документа</th>
				<th>Поставщик</th>
				<th>Сумма</th>
			</tr>
		</thead>
	<?php
	$s = 0;
	foreach($docs[$key[0]] as $doc) {
//		echo $doc['head']['num'].'<br>';
//		Utils::print_r($doc);
		$tr = '<tr>';
		$tr .=   '<td>';
		$tr .=      Utils::format_date($doc['head']['date']);
		$tr .=   '</td>';
		$tr .=   '<td>';
		$tr .=      $doc['head']['num'];
		$tr .=   '</td>';
		$tr .=   '<td>';
		$tr .=      $doc['head']['contact'];
		$tr .=   '</td>';
		$tr .=   '<td class="r">';
		$tr .=      number_format($doc['head']['sum_price'],'0','.',' ');
		$tr .=   '</td>';
		$tr .= '</tr>';
		$s += $doc['head']['sum_price'];
		echo $tr;
		$tr = '';
		if ($full=='true') {
			foreach ($doc['data'] as $row) {
				$tr .= '<tr>';
				$tr .=    '<td colspan="3" class="no_border">';
				$tr .=    '</td>';
				$tr .=    '<td class="r">';
				$tr .=         number_format($row['price']*$row['quantity'],'0','.',' ');
				$tr .=    '</td>';
				$tr .=    '</tr>';
			}
			echo $tr;
		}
	}
	?>
		<tr>
			<td colspan="3" class="no_border itog">Итого по данной операции:</td>
			<td class="r no_border itog"><?php echo number_format($s,'0','.',' '); ?></td>
		</tr>
	</table>

<!--	<hr>-->

<!-- Возврат ------------------------------------------------------------------------------ -->

	<?php

	$docs = array_shift($data);
	$key = array_keys($docs);

	?>

	<div class="sub_title">
		<?php echo $key[0]; ?>
	</div>

	<?php
	//	Utils::print_r($key);
	//	echo count($docs[$key[0]]);
	//	Utils::print_r($docs);
	?>
	<table>
		<thead>
		<tr>
			<th>Дата</th>
			<th>Номер документа</th>
<!--			<th>Поставщик</th>-->
			<th>Сумма</th>
		</tr>
		</thead>
		<?php
		$s1 = 0;
		foreach($docs[$key[0]] as $doc) {
//		echo $doc['head']['num'].'<br>';
//		Utils::print_r($doc);
			$tr = '<tr>';
			$tr .=   '<td>';
			$tr .=      Utils::format_date($doc['head']['date']);
			$tr .=   '</td>';
			$tr .=   '<td>';
			$tr .=      $doc['head']['num'];
			$tr .=   '</td>';
//			$tr .=   '<td>';
//			$tr .=      $doc['head']['contact'];
//			$tr .=   '</td>';
			$tr .=   '<td class="r">';
			$tr .=      number_format($doc['head']['sum_price'],'0','.',' ');
			$tr .=   '</td>';
			$tr .= '</tr>';
			$s1 += $doc['head']['sum_price'];
			echo $tr;
		}
		?>
		<tr>
			<td colspan="2" class="no_border itog">Итого по данной операции:</td>
			<td class="r no_border itog"><?php echo number_format($s1,'0','.',' '); ?></td>
		</tr>
		<tr>
			<td colspan="3" class="no_border"></td>
		</tr>
		<tr>
			<td colspan="2" class="no_border itog">Итого по приходу:</td>
			<td class="r no_border itog"><?php echo number_format($s1+$s,'0','.',' '); ?></td>
		</tr>
	</table>

<!--	<hr>-->

										<!-- Расход -->
<!-- Продажа наличными -------------------------------------------------------------------- -->

	<?php

	$docs = $expence['day'];
	//	Utils::print_r($docs);
	//	exit;
	?>

	<div class="sub_title">
		Продажа наличными
	</div>

	<table>
		<thead>
		<tr>
			<th>Дата</th>
			<th>1</th>
			<th>2</th>
			<th>3</th>
			<th>4</th>
		</tr>
		</thead>
		<?php
		$s = 0;
		foreach($docs['data'] as $date => $doc) {
//		echo $doc['head']['num'].'<br>';
//		Utils::print_r($doc);
			$tr = '<tr>';
			$tr .=   '<td>';
			$tr .=      Utils::format_date($doc['date']);
			$tr .=   '</td>';
			$tr .=   '<td class="r">';
			$tr .=      number_format($doc['kassa'],'0','.',' ');
			$tr .=   '</td>';
			$tr .=   '<td>';
//			$tr .=      $doc['contact'];
			$tr .=   '</td>';
			$tr .=   '<td class="r">';
			$tr .=      @number_format($doc['return'],'0','.',' ');
			$tr .=   '</td>';
			$tr .=   '<td class="r">';
			$tr .=      number_format($doc['sum'],'0','.',' ');
			$tr .=   '</td>';
			$tr .= '</tr>';
			$s += $doc['sum'];
			echo $tr;
		}
		?>
		<tr>
			<td colspan="4" class="no_border itog">Итого по данной операции:</td>
			<td class="r no_border itog"><?php echo number_format($s,'0','.',' '); ?></td>
		</tr>
	</table>

<!-- Безнал ------------------------------------------------------------------------------- -->
	<?php

	$docs = array_shift($data);
	$key = array_keys($docs);
//	Utils::print_r($key);
	$s = array();
	foreach ($key as $op) {
	?>

	<div class="sub_title">
		<?php echo $op; ?>
	</div>

	<?php
	//	Utils::print_r($key);
	//	echo count($docs[$key[0]]);
	//	Utils::print_r($docs);

	?>
	<table>
		<thead>
		<tr>
			<th>Дата</th>
			<th>Номер документа</th>
			<th>Потребитель</th>
			<th>Сумма</th>
		</tr>
		</thead>
		<?php
		$s[] = 0;
		foreach($docs[$op] as $doc) {
//		echo $doc['head']['num'].'<br>';
//		Utils::print_r($doc);
			$tr = '<tr>';
			$tr .=   '<td>';
			$tr .=      Utils::format_date($doc['head']['date']);
			$tr .=   '</td>';
			$tr .=   '<td>';
			$tr .=      $doc['head']['num'];
			$tr .=   '</td>';
			$tr .=   '<td>';
			$tr .=      $doc['head']['contact'];
			$tr .=   '</td>';
			$tr .=   '<td class="r">';
			$tr .=      number_format($doc['head']['sum_price'],'0','.',' ');
			$tr .=   '</td>';
			$tr .= '</tr>';
			$s[count($s)-1] += $doc['head']['sum_price'];
			echo $tr;
		}
		?>
		<tr class="itog">
			<td colspan="3" class="no_border itog">Итого по данной операции:</td>
			<td class="r no_border itog"><?php echo number_format($s[count($s)-1],'0','.',' '); ?></td>
		</tr>

		<!--  ?php
			if (count($s)==count($key))	{
				// итого по накладным
				?>
				<tr class="itog">
					<td colspan="3" class="no_border itog">Итого по накладным:</td>
					<td class="r no_border itog">< ?php echo number_format(array_sum($s),'0','.',' '); ?></td>
				</tr>
				<php
			}
		?   -->
	</table>

<!--	<hr>-->
	<?php } ?>

<!-- В кредит ----------------------------------------------------------------------------- -->
	<?php

	$docs = $expence['kredit'];
	//	Utils::print_r($docs);
	//	exit;
	?>

	<div class="sub_title">
		Продажа в кредит
	</div>


	<table>
		<thead>
		<tr>
			<th>Дата</th>
			<th>ФИО</th>
			<!--			<th>Поставщик</th>-->
			<th>Сумма</th>
		</tr>
		</thead>
		<?php
		$s = 0;
		foreach($docs['data'] as $doc) {
//		echo $doc['head']['num'].'<br>';
//		Utils::print_r($doc);
			$tr = '<tr>';
			$tr .=   '<td>';
			$tr .=      Utils::format_date($doc['date']);
			$tr .=   '</td>';
//			$tr .=   '<td>';
////			$tr .=      $doc['kart_num'];
//			$tr .=   '</td>';
			$tr .=   '<td>';
			$tr .=      $doc['contact'];
			$tr .=   '</td>';
			$tr .=   '<td class="r">';
			$tr .=      number_format($doc['sum'],'0','.',' ');
			$tr .=   '</td>';
			$tr .= '</tr>';
			$s += $doc['sum'];
			echo $tr;
		}
		?>
		<tr>
			<td colspan="2" class="no_border itog">Итого по данной операции:</td>
			<td class="r no_border itog"><?php echo number_format($s,'0','.',' '); ?></td>
		</tr>
	</table>

<!-- По карточке -------------------------------------------------------------------------- -->
	<?php

	$docs = $expence['karta'];
//	Utils::print_r($docs);
//	exit;
	?>

	<div class="sub_title">
		Пластиковая карта
	</div>


	<table>
		<thead>
		<tr>
			<th>Дата</th>
			<th>Номер карты</th>
<!--			<th>Поставщик</th>-->
			<th>Сумма</th>
		</tr>
		</thead>
		<?php
		$s = 0;
		foreach($docs['data'] as $doc) {
//		echo $doc['head']['num'].'<br>';
//		Utils::print_r($doc);
			$tr = '<tr>';
			$tr .=   '<td>';
			$tr .=      Utils::format_date($doc['date']);
			$tr .=   '</td>';
			$tr .=   '<td>';
			$tr .=      $doc['kart_num'];
			$tr .=   '</td>';
//			$tr .=   '<td>';
//			$tr .=      $doc['head']['contact'];
//			$tr .=   '</td>';
			$tr .=   '<td class="r">';
			$tr .=      number_format($doc['sum'],'0','.',' ');
			$tr .=   '</td>';
			$tr .= '</tr>';
			$s += $doc['sum'];
			echo $tr;
		}
		?>
		<tr>
			<td colspan="2" class="no_border itog">Итого по данной операции:</td>
			<td class="r no_border itog"><?php echo number_format($s,'0','.',' '); ?></td>
		</tr>
	</table>

<!--	<hr>-->




</div>

<?php
//Utils::print_r($expence);