<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 17.08.15
 * Time: 11:53
 */

//Utils::print_r($data[-1]);
//exit;
$this->addCSS('print/report.css');

$df = Utils::format_date($_GET['from_date']);
$dt = Utils::format_date($_GET['to_date']);
//ksort($data['expence']['day']['data']);

//Utils::print_r($data);
//Utils::print_r($_GET);
//exit;
//return;


//Utils::print_r();
$total_rest = $data['rest']['tovar']+$data['rest']['kassa'];         // для накопления остатка

$store = Storepassport::model()->find('id_store='.$_GET['id_store']);
?>

	<div class="rep_wrapper">
		<div class="page p podshiv">
			<div class="hat">


				<table class="no_border" cellpadding="0" cellspacing="0" style="width:100%">
					<tbody>
					<tr>
						<td></td>
						<td></td>
						<td class="border c">Код</td>
					</tr>
					<tr>
						<td class="c" style="border-bottom: 1px solid #000; width:60%">
							<?php echo $store->name.', '.$store->address; ?>
						</td>
						<td class="r">
							Форма по ОКУД
						</td>
						<td class="border c"></td>
					</tr>
					<tr>
						<td class="c">
							<small>(организация, адрес)</small>
						</td>
						<td class="r">
							по ОКПО
						</td>
						<td class="border c">
							<?php echo $store->okpo ?>
						</td>
					</tr>
					<tr>
						<td class="c" style="border-bottom: 1px solid #000;">
							<?php echo Store::model()->findByPK($_GET['id_store'])->name; ?>
						</td>
						<td class="r">
							УНН
						</td>
						<td  class="border c">
							<?php echo $store->unn ?>
						</td>
					</tr>
					<tr class="border">
						<td class="c">
							<small>(структурное подразделение)</small>
						</td>
						<td></td>
						<td class="border c"></td>
					</tr>
					<tr>
						<td colspan="2" class="r">
							<p>Вид деятельности по ОКЭД&nbsp;</p>
						</td>
						<td class="border c"></td>
					</tr>
					<tr>
						<td></td>
						<td class="r">
							Вид операции
						</td>
						<td class="border c"></td>
					</tr>
					</tbody>
				</table>
<br>
				<table class="" cellpadding="0" cellspacing="0" style="width:100%">
					<tbody>
					<tr class="c">
						<td rowspan="2" class="no_border"  width="50%"></td>
						<td rowspan="2">
							Номер документа
						</td>
						<td rowspan="2">
							<p>Дата составления</p>
						</td>
						<td colspan="2">
							<p>Отчетный период</p>
						</td>
					</tr>
					<tr class="c">
						<td>
							<p>с</p>
						</td>
						<td>
							<p>по</p>
						</td>
					</tr>
					<tr class="c">
						<td class="no_border">
							<strong>ТОВАРНЫЙ ОТЧЕТ</strong>
						</td>
						<td></td>
						<td>
							<?php echo date('d.m.Y') ?>
						</td>
						<td>
							<?php echo $df ?>
						</td>
						<td>
							<?php echo $dt ?>
						</td>
					</tr>
					</tbody>
				</table>
<br>
				<table class="no_border" cellpadding="0" cellspacing="0" style="width:100%">
					<tbody>
					<tr>
						<td>
							Материально ответственное лицо _____________________________________________________________________________________
						</td>
						<td class="border c">
							Табельный номер
						</td>
					</tr>
					<tr>
						<td class="c">
							<small>(фамилия, имя, отчество)</small>
						</td>
						<td class="border"></td>
					</tr>
					</tbody>
				</table>



			</div>  <!-- hat -->
<br>
			<div class="docdata">
				<table cellpadding="0" cellspacing="0" style="width:100%">
					<tbody>
					<tr class="c">
						<td rowspan="2">
							<p>Наименование</p>
						</td>
						<td colspan="2">
							<p>Документ</p>
						</td>
						<td colspan="2">
							<p>Сумма, руб.</p>
						</td>
						<td colspan="4">
							<p>Дополнительные сведения</p>
						</td>
					</tr>
					<tr class="c">
						<td>дата</td>
						<td>номер</td>
						<td>товара</td>
						<td>тары</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr class="c">
						<td>1</td>
						<td>2</td>
						<td>3</td>
						<td>4</td>
						<td>5</td>
						<td>6</td>
						<td>7</td>
						<td>8</td>
						<td>9</td>
					</tr>
					<tr class="itog">
						<td>
							Остаток на <?php echo $df; ?>
						</td>
						<td>х</td>
						<td>х</td>
						<td class="r">
							<?php echo number_format($total_rest, '2', ' ', ' '); ?>
						</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td>Приход</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<?php
					$sum = 0;
					foreach ($data[1] as $op => $receipt) {
						foreach ($receipt as $doc) {
							$tr = '<tr><td class="l">';
							$tr .= $doc->contact->name; //1
							$tr .= '</td>';
							$tr .= '<td class="c">';
							$tr .= Utils::format_date($doc->doc_date); //2
							$tr .= '</td>';
							$tr .= '<td class="c">';
							$tr .= $doc->doc_num; //3
							$tr .= '</td>';
							$tr .= '<td class="r">';
							$tr .= number_format($doc->sum_price, '2', ' ', ' '); //4
							$tr .= '</td>';
							$tr .= '<td>';
							$tr .= ''; //5
							$tr .= '</td>';
							$tr .= '<td>';
							$tr .= ''; //6
							$tr .= '</td>';
							$tr .= '<td>';
							$tr .= ''; //7
							$tr .= '</td>';
							$tr .= '<td>';
							$tr .= ''; //8
							$tr .= '</td>';
							$tr .= '<td>';
							$tr .= $doc->operation->name; //9
							$tr .= '</td></tr>';
							echo $tr;

							$sum += $doc->sum_price;
							$total_rest += $doc->sum_price;
						}
					}
					?>
					<tr class="itog">
						<td>ИТОГО по приходу</td>
						<td>х</td>
						<td>х</td>
						<td class="r">
							<?php echo number_format($sum, '2', ' ', ' ')?>
						</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr class="itog">
						<td>ИТОГО с остатком</td>
						<td>х</td>
						<td>х</td>
						<td class="r">
							<?php echo number_format($total_rest, '2', ' ', ' ')?>
						</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td>Расход</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<?php
					$sum = 0;
					foreach ($data[-1] as $op => $expence) {
						foreach ($expence as $doc) {
							$tr = '<tr><td class="l">';
							$tr .= $doc->contact->name; //1
							$tr .= '</td>';
							$tr .= '<td class="c">';
							$tr .= Utils::format_date($doc->doc_date); //2
							$tr .= '</td>';
							$tr .= '<td class="c">';
							$tr .= $doc->doc_num; //3
							$tr .= '</td>';
							$tr .= '<td class="r">';
							$tr .= number_format($doc->sum_price, '2', ' ', ' '); //4
							$tr .= '</td>';
							$tr .= '<td>';
							$tr .= ''; //5
							$tr .= '</td>';
							$tr .= '<td>';
							$tr .= ''; //6
							$tr .= '</td>';
							$tr .= '<td>';
							$tr .= ''; //7
							$tr .= '</td>';
							$tr .= '<td>';
							$tr .= ''; //8
							$tr .= '</td>';
							$tr .= '<td>';
							$tr .= $doc->operation->name; //9
							$tr .= '</td></tr>';
							echo $tr;

							$sum += $doc->sum_price;
							$total_rest -= $doc->sum_price;
						}
					}
					?>

					<tr class="itog">
						<td>ИТОГО по расходу</td>
						<td>х</td>
						<td>х</td>
						<td class="r">
							<?php echo number_format($sum, '2', ' ', ' ')?>
						</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr class="itog">
						<td>
							Остаток на <?php echo $dt ?>
						</td>
						<td>х</td>
						<td>х</td>
						<td class="r">
							<?php echo number_format($total_rest, '2', ' ', ' ')?>
						</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					</tbody>
				</table>

			</div>
<br>
			<div class="footer">

				<p>Приложение: _______________________________________________________ документов.</p>

				<p>&nbsp;</p>

				<table class="no_border" cellpadding="7" cellspacing="0" style="width:100%">
					<tbody>
					<tr>
						<td>Материально ответственное лицо _____________________________________________ </td>
						<td></td>
						<td style="border-bottom: 1px solid #000"></td>
						<td></td>
						<td style="border-bottom: 1px solid #000"></td>
					</tr>
					<tr>
						<td class="c">(должность)</td>
						<td></td>
						<td class="c">(подпись)</td>
						<td></td>
						<td class="c">(расшифровка подписи)</td>
					</tr>
					<tr>
						<td>Отчет с документами принял и проверил _______________________________________
						</td>
						<td></td>
						<td style="border-bottom: 1px solid #000"></td>
						<td></td>
						<td style="border-bottom: 1px solid #000"></td>
					</tr>
					<tr>
						<td class="c">(должность)</td>
						<td></td>
						<td class="c">(подпись)</td>
						<td></td>
						<td class="c">(расшифровка подписи)</td>
					</tr>
					</tbody>
				</table>

			</div>
		</div>  <!-- page p -->
	</div>  <!-- rep_wrapper -->
<?php
//Utils::print_r($expence);