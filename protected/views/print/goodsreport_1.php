<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 17.08.15
 * Time: 11:53
 */

//Utils::print_r($data);
//exit;
$this->addCSS('print/report.css');

$df = Utils::format_date($_GET['from_date']);
$dt = Utils::format_date($_GET['to_date']);

ksort($data['expence']['day']['data']);

//Utils::print_r($_GET);
//exit;
//return;
// извлекаем расход за день
$expence = array_shift($data);

//Utils::print_r($data);
//exit;
$rr = Rest::get_Rest($_GET['from_date'], $_GET['id_store'], -1);
$rk = Kassa::getRest($_GET['from_date'], $_GET['id_store'], -1);

//$total = $rr+$rk;         // для накопления остатка
$total = $rr;         // для накопления остатка
$vozvr_beznal = 0;
?>

	<div class="rep_wrapper">
		<div class="page p">
			<div class="report_title">Товарно-денежный отчёт за период с <?php echo $df; ?> по <?php echo $dt; ?></div>
			<hr>
			<table class="rest_begin no_border" style="width: 250px" >
				<tr>
					<td>
						Остаток на <?php echo $df; ?>
					</td>
					<td class="r">
						<?php echo number_format($rr+$rk, '2', '.', ' '); ?>
					</td>
				</tr>
				<tr>
					<td>
						В том числе по товару
					</td>
					<td class="r">
						<?php echo number_format($rr, '2', '.', ' '); ?>
					</td>
				</tr>
				<tr>
					<td>
						В том числе по кассе
					</td>
					<td class="r">
						<?php echo number_format($rk, '2', '.', ' '); ?>
					</td>
				</tr>
			</table>
			<hr>
			<!-- Приход - не факт! ------------------------------------------------------------------------------ -->

			<?php
			if (!$data) {
//				echo 'Нету данных"!';
				goto exp;
//				exit;
			}

			$docs = array_shift($data);
			$key = array_keys($docs);
			//Utils::print_r($key);
				// если нету прихода - переходим дальше
			if (array_key_exists('Приход', $docs)) {
				//echo 'приход присутствует';
			} else {
				goto vozvr;
			}
			?>

			<div class="sub_title">
				<?php echo $key[0]; ?>
			</div>

			<?php
//				Utils::print_r($key);
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
				$dn = '';
				foreach ($docs[$key[0]] as $doc) {
					//echo $doc['head']['num'].'<br>';
					//Utils::print_r($doc);

					$tr = '';
						// если подробный вывод выбран
					if ($full == 'true') {
						if ($dn != $doc['head']['num']) {
							echo '<tr class="no_border"><td colspan="4"></td></tr>';
							$dn = $doc['head']['num'];
						}
						foreach ($doc['data'] as $row) {
							$tr .= '<tr>';
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
							$tr .=      number_format($row['price'] * $row['quantity'], '2', '.', ' ');
							$tr .=   '</td>';
							$tr .= '</tr>';

							$s += $row['price'] * $row['quantity'];
						}
					} else {    // если краткий вывод
						$tr .= '<tr>';
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
						$tr .=      number_format($doc['head']['sum_price'], '2', '.', ' ');
						$tr .=   '</td>';
						$tr .= '</tr>';

						$s += $doc['head']['sum_price'];
					}

					echo $tr; // вывод строки прихода
				}

				$total += $s;
				?>
				<tr>
					<td colspan="3" class="no_border itog">Итого по данной операции:</td>
					<td class="r no_border itog"><?php echo number_format($s, '2', '.', ' '); ?></td>
				</tr>
				<tr>
					<td colspan="3" class="no_border itog">Итого приход с остатком:</td>
					<td class="r no_border itog"><?php echo number_format($s+$rk+$rr, '2', '.', ' '); ?></td>
				</tr>
			</table>

			<!--	<hr>-->
<!-- --------------------------------------------------------------------------------------------------------------- -->
<!-- --------------------------------------- Возврат --------------------------------------------------------------- -->

			<?php

//			Utils::print_r($data);
			if (array_key_exists('Возврат', $data)) {
//				echo 'возврат присутствует';
			} else {
//				echo 'возврат отсутствует';
//				Utils::print_r(array_keys($data));
				goto exp;
			}
			$docs = array_shift($data);

vozvr:
			$vozvr_beznal = 0;
			if ($docs){
				$sv = array();
				$key = array_keys($docs);
					// если нету возврата

				foreach ($key as $op) {
				?>

				<div class="sub_title">
					<?php echo $op; ?>
				</div>

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

					$sv[] = 0;
					foreach ($docs[$op] as $doc) {
						//echo $doc['head']['num'].'<br>';
						//Utils::print_r($doc);

						$tr = '';
							// если подробный вывод выбран
						if ($full == 'true') {
							foreach ($doc['data'] as $row) {
								$tr .= '<tr>';
								$tr .=  '<td>';
								$tr .=      Utils::format_date($doc['head']['date']);
								$tr .=  '</td>';
								$tr .=  '<td>';
								$tr .=      $doc['head']['num'];
								$tr .=  '</td>';
								// $tr .=   '<td>';
								// $tr .=      $doc['head']['contact'];
								// $tr .=   '</td>';
								$tr .=  '<td class="r">';
								$tr .=      number_format($row['price'] * $row['quantity'], '2', '.', ' ');
								$tr .=  '</td>';
								$tr .= '</tr>';

//								$s1 += $row['price'] * $row['quantity'];
								$sv[count($sv) - 1] += $row['price'] * $row['quantity'];
							}
						} else {    // если краткий вывод
							$tr = '<tr>';
							$tr .= '<td>';
							$tr .= Utils::format_date($doc['head']['date']);
							$tr .= '</td>';
							$tr .= '<td>';
							$tr .= $doc['head']['num'];
							$tr .= '</td>';
							// $tr .=   '<td>';
							// $tr .=      $doc['head']['contact'];
							// $tr .=   '</td>';
							$tr .= '<td class="r">';
							$tr .= number_format($doc['head']['sum_price'], '2', '.', ' ');
							$tr .= '</td>';
							$tr .= '</tr>';

							$sv[count($sv) - 1] += $doc['head']['sum_price'];
//							$s1 += $doc['head']['sum_price'];
						}

						echo $tr;
					}
					$total += $sv[count($sv) - 1];
					//Utils::print_r($op);
					if ($op == 'Возврат безнал') {
						$vozvr_beznal = $sv[count($sv) - 1];
					}
					?>

					<tr>
						<td colspan="2" class="no_border itog">Итого по данной операции:</td>
						<td class="r no_border itog"><?php echo number_format($sv[count($sv) - 1], '2', '.', ' '); ?></td>
					</tr>

				</table>
			<?php
				}
			}
			?>
			<table>
				<tr>
					<td colspan="2" class="no_border itog">Итого по приходу:</td>
					<td class="r no_border itog"><?php echo @number_format(array_sum($sv)+$s, '2', '.', ' '); ?></td>
				</tr>
			</table>

			<hr>

<!-- --------------------------------------------------------------------------------------------------------------- -->
<!-- ---------------------------------------- Расход --------------------------------------------------------------- -->
<!-- ----------------------------------- Продажа наличными --------------------------------------------------------- -->

			<?php

exp:
			$itogo_r = 0;
			$sb = 0;
			$sv = 0;
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
					<th>Касса</th>
					<th>Банк</th>
					<th>Возврат</th>
					<th>Расход</th>
				</tr>
				</thead>
				<?php
				$s = 0;
				$r = $rk;
				foreach ($docs['data'] as $date => $doc) {
					//echo $doc['head']['num'].'<br>';
					//Utils::print_r($doc);
					$tr = '<tr>';
					$tr .=  '<td>';
					$tr .=      Utils::format_date($doc['date']);
					$tr .=  '</td>';
					$tr .=  '<td class="r">';
					$tr .=      number_format($doc['kassa'], '2', '.', ' ');
					$tr .=  '</td>';
					$tr .=  '<td class="r">';
					$tr .=      number_format(($r + $doc['sum'] - @$doc['return'] - $doc['kassa']), '2', '.', ' ');
					$tr .=  '</td>';
					$tr .=  '<td class="r">';
					$tr .=      @number_format($doc['return'], '2', '.', ' ');
					$tr .=  '</td>';
					$tr .=  '<td class="r">';
					$tr .=      number_format($doc['sum'], '2', '.', ' ');
					$tr .=  '</td>';
					$tr .=  '</tr>';
					echo $tr;

					$sb += $r + $doc['sum'] - $doc['return'] - $doc['kassa'];
					$sv += $doc['return'];

					$s += $doc['sum'];
					$r = $doc['kassa'];


				}
				$total -= $s;
				$itogo_r += $s;
				?>
				<tr>
					<td colspan="2" class="no_border itog">Итого по данной операции:</td>
					<td class="r no_border itog"><?php echo number_format($sb, '2', '.', ' '); ?></td>
					<td class="r no_border itog"><?php echo number_format($sv, '2', '.', ' '); ?></td>
					<td class="r no_border itog"><?php echo number_format($s, '2', '.', ' '); ?></td>
				</tr>
			</table>

<!-- --------------------------------------------------------------------------------------------------------------- -->
<!-- ------------------------------------- Безнал ------------------------------------------------------------------ -->
			<?php

			$docs = array_shift($data);
//			if (array_key_exists('Продажа безналичными', $docs)) {
//				//echo 'приход присутствует';
//			} else {
//				goto kred;
//			}
			//Utils::print_r($docs);
			if ($docs) {


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
						foreach ($docs[$op] as $doc) {
							//echo $doc['head']['num'].'<br>';
							//Utils::print_r($doc);

							$tr = '';
							// если подробный вывод выбран
							if ($full == 'true') {
								foreach ($doc['data'] as $row) {
									$tr .= '<tr>';
									$tr .= '<td>';
									$tr .= Utils::format_date($doc['head']['date']);
									$tr .= '</td>';
									$tr .= '<td>';
									$tr .= $doc['head']['num'];
									$tr .= '</td>';
									$tr .= '<td>';
									$tr .= $doc['head']['contact'];
									$tr .= '</td>';
									$tr .= '<td class="r">';
									$tr .= number_format($row['price'] * $row['quantity'], '2', '.', ' ');
									$tr .= '</td>';
									$tr .= '</tr>';

									$s[count($s) - 1] += $row['price'] * $row['quantity'];
								}
							} else {    // если краткий вывод
								$tr = '<tr>';
								$tr .= '<td>';
								$tr .= Utils::format_date($doc['head']['date']);
								$tr .= '</td>';
								$tr .= '<td>';
								$tr .= $doc['head']['num'];
								$tr .= '</td>';
								$tr .= '<td>';
								$tr .= $doc['head']['contact'];
								$tr .= '</td>';
								$tr .= '<td class="r">';
								$tr .= number_format($doc['head']['sum_price'], '2', '.', ' ');
								$tr .= '</td>';
								$tr .= '</tr>';

								$s[count($s) - 1] += $doc['head']['sum_price'];
							}

							echo $tr;
						}
						$total -= $s[count($s) - 1];
						$itogo_r += $s[count($s) - 1];
						?>
						<tr class="itog">
							<td colspan="3" class="no_border itog">Общий товарооборот:</td>
							<td class="r no_border itog"><?php echo number_format($expence['including_bn'][1], '2', '.', ' '); ?></td>
						</tr>
						<tr class="itog">
							<td colspan="3" class="no_border itog">Собственные нужды:</td>
							<td class="r no_border itog"><?php echo number_format($expence['including_bn'][3], '2', '.', ' '); ?></td>
						</tr>
						<tr class="itog">
							<td colspan="3" class="no_border itog">Итого по данной операции:</td>
							<td class="r no_border itog"><?php echo number_format($s[count($s) - 1], '2', '.', ' '); ?></td>
						</tr>

						<!--  ?php
							if (count($s)==count($key))	{
								// итого по накладным
								?>
								<tr class="itog">
									<td colspan="3" class="no_border itog">Итого по накладным:</td>
									<td class="r no_border itog">< ?php echo number_format(array_sum($s), '2','.',' '); ?></td>
								</tr>
								<php
							}
						?   -->
					</table>

					<!--	<hr>-->
			<?php
					//Utils::print_r($expence['including_bn']);
				}
			}
			?>
<!-- --------------------------------------------------------------------------------------------------------------- -->
<!-- ---------------------------- В кредит ------------------------------------------------------------------------- -->
			<?php
kred:
			$docs = $expence['kredit'];
			//Utils::print_r($docs);
			//exit;
			if ($docs['sum']>0) {
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
					foreach ($docs['data'] as $doc) {
						//		echo $doc['head']['num'].'<br>';
						//		Utils::print_r($doc);
						$tr = '<tr>';
						$tr .= '<td>';
						$tr .= Utils::format_date($doc['date']);
						$tr .= '</td>';
						//			$tr .=   '<td>';
						////			$tr .=      $doc['kart_num'];
						//			$tr .=   '</td>';
						$tr .= '<td>';
						$tr .=      $doc['contact'];
						$tr .= '</td>';
						$tr .= '<td class="r">';
						$tr .= number_format($doc['sum'], '2', '.', ' ');
						$tr .= '</td>';
						$tr .= '</tr>';
						$s += $doc['sum'];
						echo $tr;
					}
					$total -= $s;
					$itogo_r += $s;

					?>
					<tr>
						<td colspan="2" class="no_border itog">Итого по данной операции:</td>
						<td class="r no_border itog"><?php echo number_format($s, '2', '.', ' '); ?></td>
					</tr>
				</table>
			<?php
			}
			?>
<!-- --------------------------------------------------------------------------------------------------------------- -->
<!-- ------------------------------------По чекам--- --------------------------------------------------------------- -->
			<?php
			$docs = $expence['check'];
			//Utils::print_r($docs);
			//exit;
			if ($docs['sum']>0) {
				?>

				<div class="sub_title">
					Продажа чеками
				</div>


				<table>
					<thead>
					<tr>
						<th>Дата</th>
						<th></th>
						<!--			<th>Поставщик</th>-->
						<th>Сумма</th>
					</tr>
					</thead>
					<?php
					$s = 0;
					foreach ($docs['data'] as $doc) {
						//		echo $doc['head']['num'].'<br>';
						//		Utils::print_r($doc);
						$tr = '<tr>';
						$tr .= '<td>';
						$tr .= Utils::format_date($doc['date']);
						$tr .= '</td>';
						//			$tr .=   '<td>';
						////			$tr .=      $doc['kart_num'];
						//			$tr .=   '</td>';
						$tr .= '<td>';
						$tr .=      $doc['contact'];
						$tr .= '</td>';
						$tr .= '<td class="r">';
						$tr .= number_format($doc['sum'], '2', '.', ' ');
						$tr .= '</td>';
						$tr .= '</tr>';
						$s += $doc['sum'];
						echo $tr;
					}
					$total -= $s;
					$itogo_r += $s;

					?>
					<tr>
						<td colspan="2" class="no_border itog">Итого по данной операции:</td>
						<td class="r no_border itog"><?php echo number_format($s, '2', '.', ' '); ?></td>
					</tr>
				</table>
				<?php
			}
			?>
<!-- --------------------------------------------------------------------------------------------------------------- -->
<!-- ------------------------------------По карточке --------------------------------------------------------------- -->
			<?php

			$docs = $expence['karta'];
			//	Utils::print_r($docs);
			//	exit;
			if ($docs['sum']>0) {
				?>


				<div class="sub_title">
					Пластиковая карта
				</div>


				<table>
					<thead>
					<tr>
						<th>Дата</th>
						<!-- th>Номер карты</th -->
						<!-- th>Поставщик</th -->
						<th>Сумма</th>
					</tr>
					</thead>
					<?php
					$s = 0;
					foreach ($docs['data'] as $date=>$sum) {
						//		echo $doc['head']['num'].'<br>';
						//		Utils::print_r($doc);
						$tr = '<tr>';
						$tr .= '<td>';
						$tr .= Utils::format_date($date);
						$tr .= '</td>';
						//$tr .= '<td>';
						//$tr .= $doc['kart_num'];
						//$tr .= '</td>';
						//			$tr .=   '<td>';
						//			$tr .=      $doc['head']['contact'];
						//			$tr .=   '</td>';
						$tr .= '<td class="r">';
						$tr .= number_format($sum, '2', '.', ' ');
						$tr .= '</td>';
						$tr .= '</tr>';
						$s += $sum;
						echo $tr;

					}
					$total -= $s;
					$itogo_r += $s;
					?>
					<tr>
						<td colspan="1" class="no_border itog">Итого по данной операции:</td>
						<td class="r no_border itog"><?php echo number_format($s, '2', '.', ' '); ?></td>
					</tr>
					<tr>
						<td colspan="1" class="no_border ">Возврат безнал:</td>
						<td class="r no_border "><?php echo number_format($vozvr_beznal, '2', '.', ' '); ?></td>
					</tr>
					<tr>
						<td colspan="1" class="no_border ">Итого по терминалу:</td>
						<td class="r no_border "><?php echo number_format($s-$vozvr_beznal, '2', '.', ' '); ?></td>
					</tr>
				</table>
			<?php
			}
			?>
			<br>
			<table class="total no_border">
				<tr class="itog">
					<td class="itog">Итого расход</td>
					<td class="itog r"><?php echo number_format($itogo_r, '2', '.', ' '); ?></td>
				</tr>
			</table>

			<hr>
			<table class="total no_border" >
				<tr class="itog">
					<td class="itog">Остаток на <?php echo Utils::format_date($_GET['to_date']); ?></td>
					<td class="itog r"><?php echo number_format($total, '2','.',' '); ?></td>
				</tr>
			</table>
		</div>
	</div>
<?php
//Utils::print_r($expence);
