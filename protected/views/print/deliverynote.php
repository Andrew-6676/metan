<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 19.08.15
 * Time: 14:12
 */

$this->addCSS('print/report.css');
$this->addCSS('print/delivery.css');
//echo $_GET['type'];
//exit;
?>


	<div class="rep_wrapper">
		<div class="page p1 more deliverynote">
			<br><br>
			<div>
				<table class="no_border" align="center" style="width:200px">
					<tr class="c">
						<td>
							<?php echo Store::model()->findByPk($_GET['id_store'])->storepassports[0]->unn; ?>
						</td>
						<td>
							<?php echo $data['rec_doc']->contact->unn; ?>
						</td>
						<td>

						</td>
					</tr>
				</table>
			</div>

			<div class="empty">
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
			</div>

			<div>
				<table class="no_border spec" width="100%">
					<tr>
						<td colspan="146">
							<?php echo Utils::format_date($data['rec_doc']->doc_date, 'full'); ?>
						</td>
					</tr>
					<tr>
						<td colspan="146" height="10"></td>
					</tr>
					<tr>
						<td colspan=11 height="15">Автомобиль</td>
						<td></td>
						<td style="border-bottom: 1px solid #1f1c1b" colspan=38 align="center"><br></td>
						<td></td>
						<td colspan=7>Прицеп</td>
						<td></td>
						<td style="border-bottom: 1px solid #1f1c1b" colspan=38 align="center"><br></td>
						<td></td>
						<td colspan=12>К путевому листу №</td>
						<td></td>
						<td style="border-bottom: 1px solid #1f1c1b" colspan=35 align="center"><br></td>
					</tr>
					<tr>
						<td colspan="12"></td>
						<td colspan=38 align="center" valign=top><i><font size=1>(марка, государственный
									номер)</font></i></td>
						<td colspan="9"></td>
						<td colspan=38 align="center" valign=top><i><font size=1>(марка, государственный
									номер)</font></i></td>
						<td colspan="49"></td>

					</tr>
					<tr>
						<td height="4" colspan="146"></td>
					</tr>
					<tr>
						<td colspan=14 height="15">Владелец автомобиля</td>
						<td><br></td>
						<td style="border-bottom: 1px solid #1f1c1b" colspan=35 align="center"><br></td>
						<td><br></td>
						<td colspan=9>Водитель</td>
						<td><br></td>
						<td style="border-bottom: 1px solid #1f1c1b" colspan=85 align="center"><br></td>
					</tr>
					<tr>
						<td height="15" colspan="15"><br></td>
						<td colspan=35 align="center" valign=top><i><font size=1>(наименование)</font></i></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td colspan=85 align="center" valign=top><i><font size=1>(фамилия и инициалы)</font></i></td>
					</tr>
					<tr>
						<td height="4" colspan="146"></td>
					</tr>
					<tr>
						<td colspan=28 height="15">Заказчик автомобильной перевозки (плательщик)</td>
						<td><br></td>
						<td style="border-bottom: 1px solid #1f1c1b" colspan=117 align="center"><br></td>
					</tr>
					<tr>
						<td height="15" colspan="29"><br></td>
						<td colspan=102 align="center" valign=top><i><font size=1>(наименование, адрес)</font></i></td>
					</tr>
					<tr>
						<td height="4" colspan="146"></td>
					</tr>
					<tr>
						<td colspan=12 height="15">Грузоотправитель</td>
						<td align="center"><b><i><br></i></b></td>
						<td style="border-bottom: 1px solid #1f1c1b" colspan=133 align="center">
							<?php echo Store::model()->findByPk($_GET['id_store'])->storepassports[0]->name; ?>,
							<?php echo Store::model()->findByPk($_GET['id_store'])->storepassports[0]->address; ?>
						</td>
					</tr>
					<tr>
						<td height="15" colspan="13"><br></td>
						<td style="border-top: 1px solid #1f1c1b" colspan=129 align="center" valign=top><i><font size=1>(наименование,
									адрес)</font></i></td>
					</tr>
					<tr>
						<td height="4" colspan="146"></td>
					</tr>
					<tr>
						<td colspan=12 height="15">Грузополучатель</td>
						<td align="center"><b><i><br></i></b></td>
						<td style="border-bottom: 1px solid #1f1c1b" colspan=133 align="center">
							<?php echo $data['rec_doc']->contact->fname; ?>,
							<?php echo $data['rec_doc']->contact->address; ?>
						</td>
					</tr>
					<tr>
						<td height="15" colspan="13"><br></td>
						<td style="border-top: 1px solid #1f1c1b" colspan=129 align="center" valign=top><i><font size=1>(наименование,
									адрес)</font></i></td>
					</tr>
					<tr>
						<td height="4" colspan="146"></td>
					</tr>
					<tr>
						<td colspan=10 height="15">Основание отпуска</td>
						<td><br></td>
						<td style="border-bottom: 1px solid #1f1c1b" colspan=43 align="center"><br></td>
						<td><br></td>
						<td colspan=10>Пункт погрузки</td>
						<td><br></td>
						<td style="border-bottom: 1px solid #1f1c1b" colspan=34 align="center">
							<?php echo Store::model()->findByPk($_GET['id_store'])->storepassports[0]->address; ?>
						</td>
						<td><br></td>
						<td colspan=10>Пункт разгрузки</td>
						<td><br></td>
						<td style="border-bottom: 1px solid #1f1c1b" colspan=34 align="center">
							<?php echo $data['rec_doc']->contact->address; ?>
						</td>
					</tr>
					<tr>
						<td height="15"><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td colspan=36 align="center" valign=top><i><font size=1>(дата и номер договора или другого
									документа)</font></i></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td colspan=30 align="center" valign=top><i><font size=1>(адрес)</font></i></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td colspan=29 align="center" valign=top><i><font size=1>(адрес)</font></i></td>
					</tr>
					<tr>
						<td height="4" colspan="146"></td>
					</tr>
					<tr>
						<td colspan=10 height="15">Переадресовка</td>
						<td><br></td>
						<td style="border-bottom: 1px solid #1f1c1b" colspan=135 align="center"><br></td>
					</tr>
					<tr>
						<td height="15"><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td><br></td>
						<td colspan=131 align="center" valign=top><i><font size=1>(наименование, адрес нового
									грузополучателя, фамилия, инициалы, подпись уполномоченного должностного
									лица)</font></i></td>
					</tr>
				</table>
			</div>

			<?php

			?>
			<table class="usr " style="page-break-after:always">
				<caption>
					<br>
					I. ТОВАРНЫЙ РАЗДЕЛ
				</caption>
				<thead>
				<tr>
					<th>Наименование товара</th>
					<th>Ед. <br>изм.</th>
					<th>Кол-во</th>
					<th>Цена, руб.</th>
					<th>Стоимость, <br>руб.</th>
					<th>Ставка <br>НДС, %</th>
					<th>Сумма<br>НДС, руб.</th>
					<th>Сумма<br>с НДС, руб.</th>
					<th>Количество <br>грузовых <br>мест</th>
					<th>Масса<br>груза</th>
					<th>Примечание</th>
				</tr>
				<tr>
					<th>1</th>
					<th>2</th>
					<th>3</th>
					<th>4</th>
					<th>5</th>
					<th>6</th>
					<th>7</th>
					<th>8</th>
					<th>9</th>
					<th>10</th>
					<th>11</th>
				</tr>
				</thead>
				<tbody>
				<?php
				foreach ($data['rec_doc_data'] as $row) {
					$tr = '<tr class="r">';
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
					$tr .= number_format($row->price, '0', '.', ' ');
					$tr .= '</td>';
					$tr .= '<td>';
					$tr .= number_format($row->price * $row->quantity, '0', '.', ' ');
					$tr .= '</td>';
					$tr .= '<td>';
					$tr .= $row->vat;
					$tr .= '</td>';
					$tr .= '<td>';
					$tr .= number_format($row->quantity * $row->price * ($row->vat / 100), '0', '.', ' ');
					$tr .= '</td>';
					$tr .= '<td>';
					$tr .= number_format($row->quantity * $row->price * (1 + $row->vat / 100), '0', '.', ' ');
					$tr .= '</td>';
					$tr .= '<td>';
					$tr .= '</td>';
					$tr .= '<td>';
					$tr .= '</td>';
					$tr .= '<td class="l">';
					$tr .= $row->goods->producer;
					$tr .= '</td>';
					$tr .= '</tr>';
					echo $tr;
				}

				$tr = '<tr class="r">';
				$tr .= '<td class="no_border l" colspan="2">';
				$tr .= 'ВСЕГО';
				$tr .= '</td>';
				$tr .= '<td class="no_border">';
				$tr .= '';
				$tr .= '</td>';
				$tr .= '<td class="no_border">';
				$tr .= '</td>';
				$tr .= '<td class="no_border r">';
				$tr .= number_format($data['rec_doc']->sum_cost, '0', '.', ' ');
				$tr .= '</td>';
				$tr .= '<td class="no_border">';
				$tr .= '</td>';
				$tr .= '<td class="no_border r">';
				$tr .= $data['rec_doc']->sum_vat;
				$tr .= '</td>';
				$tr .= '<td class="no_border">';
				$tr .= number_format($data['rec_doc']->sum_price, '0', '.', ' ');
				$tr .= '</td>';
				$tr .= '<td class="no_border r">';
				$tr .= '</td>';
				$tr .= '<td class="no_border">';
				$tr .= '</td>';
				$tr .= '</tr>';

				//		$tr .= '<tr>';
				//		$tr .=     '<td class="no_border" colspan="11">';
				//		$tr .=     '</td>';
				//		$tr .= '</tr>';
				//		$tr .= '<tr>';
				//		$tr .=     '<td class="no_border" colspan="11">';
				//		$tr .=     		(Utils::num2str($data['rec_doc']->sum_price));
				//		$tr .=     '</td>';
				//		$tr .= '</tr>';
				echo $tr;
				?>
				</tbody>
			</table>


		</div>
		<!--  end page 1 -->
		<!--<div style="height: 10px; width: 10px;" class="more">.</div>-->
		<!--	<pagebreak class="more"/>-->
		<!--	<p style="page-break-after:always">...</p>-->
		<div class="page p2 deliverynote">
			<table width="100%" class="no_border spec2" style="font-size: 10px;">
				<colgroup span="146" width="7"></colgroup>
				<tbody>
				<tr>
					<td height="15"><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td colspan="24">Количество ездок (заездов)</td>
					<td><br></td>
					<td style="border-bottom: 1px solid #1f1c1b" colspan="29" align="center"><br></td>
				</tr>
				<tr>
					<td colspan="16" height="15">Всего сумма НДС</td>
					<td></td>
					<td style="border-bottom: 1px solid #1f1c1b" colspan="129" align="center">
						<?php echo Utils::num2str($data['rec_doc']->sum_vat); ?>
					</td>
				</tr>
				<tr>
					<td height="15"><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td colspan="129" align="center" valign="top"><i><font size="1">(прописью)</font></i></td>
				</tr>
				<tr>
					<td colspan="21" height="15">Всего стоимость с НДС</td>
					<td><br></td>
					<td style="border-bottom: 1px solid #1f1c1b" colspan="124" align="center">
						<?php echo Utils::num2str($data['rec_doc']->sum_price); ?>
					</td>
				</tr>
				<tr>
					<td height="15"><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td colspan="124" align="center" valign="top"><i><font size="1">(прописью)</font></i></td>
				</tr>
				<tr>
					<td colspan="16" height="15">Всего масса груза</td>
					<td><br></td>
					<td style="border-bottom: 1px solid #1f1c1b" colspan="53" align="center"><br></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td colspan="28">Всего количество грузовых мест</td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td style="border-bottom: 1px solid #1f1c1b" colspan="46" align="center"><br></td>
				</tr>
				<tr>
					<td height="15"><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td colspan="53" align="center" valign="top"><i><font size="1">(прописью)</font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td colspan="46" align="center" valign="top"><i><font size="1">(прописью)</font></i></td>
				</tr>
				<tr>
					<td colspan="16" height="15">Отпуск разрешил</td>
					<td><br></td>
					<td style="border-bottom: 1px solid #1f1c1b" colspan="56" align="center"><br></td>
					<td style="border-right: 1px solid #1f1c1b" align="center" valign="top"><i><font
								size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td colspan="23">Товар к перевозке принял</td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td style="border-bottom: 1px solid #1f1c1b" colspan="47" align="center"><br></td>
				</tr>
				<tr>
					<td height="15"><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td colspan="56" align="center" valign="top"><i><font size="1">(должность, фамилия, инициалы,
								подпись)</font></i></td>
					<td style="border-right: 1px solid #1f1c1b" align="center" valign="top"><i><font
								size="1"><br></font></i></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td colspan="47" align="center" valign="top"><i><font size="1">(должность, фамилия, инициалы,
								подпись)</font></i></td>
				</tr>
				<tr>
					<td colspan="20" height="15">Сдал грузоотправитель</td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td style="border-bottom: 1px solid #1f1c1b" colspan="52" align="center"><br></td>
					<td style="border-right: 1px solid #1f1c1b" align="center" valign="top"><i><font
								size="1"><br></font></i></td>
					<td><br></td>
					<td colspan="15">по доверенности</td>
					<td><br></td>
					<td style="border-bottom: 1px solid #1f1c1b" colspan="17" align="center"><br></td>
					<td>,</td>
					<td colspan="9">выданной</td>
					<td><br></td>
					<td style="border-bottom: 1px solid #1f1c1b" colspan="27" align="center"><br></td>
				</tr>
				<tr>
					<td height="15"><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td colspan="52" align="center" valign="top"><i><font size="1">(должность, фамилия, инициалы,
								подпись)</font></i></td>
					<td style="border-right: 1px solid #1f1c1b" align="center" valign="top"><i><font
								size="1"><br></font></i></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td colspan="17" align="center" valign="top"><i><font size="1">(номер, дата)</font></i></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td colspan="27" align="center" valign="top"><i><font size="1">(наименование организации)</font></i>
					</td>
				</tr>
				<tr>
					<td colspan="10" height="15">№ пломбы</td>
					<td><br></td>
					<td style="border-bottom: 1px solid #1f1c1b" colspan="29" align="center"><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td style="border-right: 1px solid #1f1c1b" align="center" valign="top"><i><font
								size="1"><br></font></i></td>
					<td><br></td>
					<td colspan="22">Принял грузополучатель</td>
					<td><br></td>
					<td style="border-bottom: 1px solid #1f1c1b" colspan="48" align="center"><br></td>
				</tr>
				<tr>
					<td height="15"><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td style="border-right: 1px solid #1f1c1b" align="center" valign="top"><i><font
								size="1"><br></font></i></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td colspan="48" align="center" valign="top"><i><font size="1">(должность, фамилия, инициалы,
								подпись)</font></i></td>
				</tr>
				<tr>
					<td height="15"><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td style="border-right: 1px solid #1f1c1b" align="center" valign="top"><i><font
								size="1"><br></font></i></td>
					<td><br></td>
					<td colspan="10">№ пломбы</td>
					<td><br></td>
					<td style="border-bottom: 1px solid #1f1c1b" colspan="29" align="center"><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
				</tr>

				<tr>
					<td colspan="33" height="15">Штамп (печать) грузоотправителя</td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td style="border-right: 1px solid #1f1c1b" align="center" valign="top"><i><font
								size="1"><br></font></i></td>
					<td><br></td>
					<td colspan="33">Штамп (печать) грузополучателя</td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
				</tr>
				<tr>
					<td colspan="146" style="border-bottom: 1px solid #1f1c1b; height: 0px;" ></td>

				</tr>
				<tr>
					<td colspan="146" align="center"><b>II. ПОГРУЗОЧНО-РАЗГРУЗОЧНЫЕ ОПЕРАЦИИ</b></td>
				</tr>

				<tr>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="10" rowspan="7" height="72" align="center" valign="middle"><b>Операция</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="16" rowspan="7" align="center" valign="middle"><b>Исполнитель</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="13" rowspan="7" align="center" valign="middle"><b>Способ<br>(ручной,<br>механи-зированный)</b>
					</td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="7" rowspan="7" align="center" valign="middle"><b>Код</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="27" rowspan="3" align="center" valign="middle"><b>Дата, время<br>(ч, мин)</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="22" rowspan="3" align="center" valign="middle"><b>Дополнительные<br>операции</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="8" rowspan="7" align="center" valign="middle"><b>Подпись</b></td>
					<td><br></td>
					<td colspan="19">Транспортные услуги</td>
					<td><br></td>
					<td style="border-bottom: 1px solid #1f1c1b" colspan="22" align="center"><br></td>
				</tr>
				<tr>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
				</tr>
				<tr>
					<td><br></td>
					<td style="border-bottom: 1px solid #1f1c1b" colspan="42" align="center"><br></td>
				</tr>
				<tr>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="9" rowspan="4" align="center" valign="middle"><b>прибытия</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="9" rowspan="4" align="center" valign="middle"><b>убытия</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="9" rowspan="4" align="center" valign="middle"><b>простоя</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="9" rowspan="4" align="center" valign="middle"><b>время</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="13" rowspan="4" align="center" valign="middle"><b>наименование</b></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
				</tr>
				<tr>
					<td><br></td>
					<td style="border-bottom: 1px solid #1f1c1b" colspan="42" align="center"><br></td>
				</tr>
				<tr>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
				</tr>
				<tr>
					<td><br></td>
					<td style="border-bottom: 1px solid #1f1c1b" colspan="42" align="center"><br></td>
				</tr>
				<tr>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="10" height="13" align="center" valign="middle"><b><br></b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="16" align="center" valign="middle" sdval="12" sdnum="1049;"><b>12</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="13" align="center" valign="middle" sdval="13" sdnum="1049;"><b>13</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="7" align="center" valign="middle" sdval="14" sdnum="1049;"><b>14</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="9" align="center" valign="middle" sdval="15" sdnum="1049;"><b>15</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="9" align="center" valign="middle" sdval="16" sdnum="1049;"><b>16</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="9" align="center" valign="middle" sdval="17" sdnum="1049;"><b>17</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="9" align="center" valign="middle" sdval="18" sdnum="1049;"><b>18</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="13" align="center" valign="middle" sdval="19" sdnum="1049;"><b>19</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="8" align="center" valign="middle" sdval="20" sdnum="1049;"><b>20</b></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
				</tr>
				<tr>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="10" height="17" align="center">Погрузка
					</td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="16"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="13" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="7" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="9" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="9" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="9" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="9" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="13" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="8" align="center"><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
				</tr>
				<tr>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="10" height="17" align="center">Разгрузка
					</td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="16"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="13" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="7" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="9" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="9" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="9" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="9" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="13" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="8" align="center"><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
				</tr>
				<tr>
					<td colspan="146" height="15" align="center" valign="top"><b>III. ПРОЧИЕ СВЕДЕНИЯ (заполняются
							перевозчиком)</b></td>
				</tr>

				<tr>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="41" rowspan="4" height="38" align="center" valign="middle"><b>Расстояние перевозки<br>по
							группам дорог, км</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="12" rowspan="7" align="center" valign="middle"><b>Кодbr экспеди-<br>рования</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="12" rowspan="7" align="center" valign="middle"><b>За<br>транс-портные<br>услуги</b>
					</td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="25" rowspan="4" align="center" valign="middle"><b>Поправочный<br>коэффициент</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="8" rowspan="7" align="center" valign="middle"><b>Штраф</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="5" rowspan="7" align="center" valign="middle"><b><br></b></td>
					<td><br></td>
					<td colspan="27">Отметки о составленных актах</td>
					<td><br></td>
					<td style="border-bottom: 1px solid #1f1c1b" colspan="14" align="center"><br></td>
				</tr>
				<tr>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
				</tr>
				<tr>
					<td><br></td>
					<td style="border-bottom: 1px solid #1f1c1b" colspan="42" align="center"><br></td>
				</tr>
				<tr>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
				</tr>
				<tr>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="10" rowspan="3" height="34" align="center" valign="middle"><b>всего</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="10" rowspan="3" align="center" valign="middle"><b>в городе</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="7" rowspan="3" align="center" valign="middle"><b>I</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="7" rowspan="3" align="center" valign="middle"><b>II</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="7" rowspan="3" align="center" valign="middle"><b>III</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="12" rowspan="3" align="center" valign="middle"><b>расценки<br>водителю</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="13" rowspan="3" align="center" valign="middle"><b>основной<br>тариф</b></td>
					<td><br></td>
					<td style="border-bottom: 1px solid #1f1c1b" colspan="42" align="center"><br></td>
				</tr>
				<tr>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
				</tr>
				<tr>
					<td><br></td>
					<td style="border-bottom: 1px solid #1f1c1b" colspan="42" align="center"><br></td>
				</tr>
				<tr>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="10" height="13" align="center" valign="middle" sdval="21" sdnum="1049;"><b>21</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="10" align="center" valign="middle" sdval="22" sdnum="1049;"><b>22</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="7" align="center" valign="middle" sdval="23" sdnum="1049;"><b>23</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="7" align="center" valign="middle" sdval="24" sdnum="1049;"><b>24</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="7" align="center" valign="middle" sdval="25" sdnum="1049;"><b>25</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="12" align="center" valign="middle" sdval="26" sdnum="1049;"><b>26</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="12" align="center" valign="middle" sdval="27" sdnum="1049;"><b>27</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="12" align="center" valign="middle" sdval="28" sdnum="1049;"><b>28</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="13" align="center" valign="middle" sdval="29" sdnum="1049;"><b>29</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="8" align="center" valign="middle" sdval="30" sdnum="1049;"><b>30</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="5" align="center" valign="middle" sdval="31" sdnum="1049;"><b>31</b></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
				</tr>
				<tr>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="10" height="17" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="10" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="7" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="7" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="7" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="12" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="12" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="12" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="13" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="8" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="5" align="center"><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
				</tr>
				<tr>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="10" height="17" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="10" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="7" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="7" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="7" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="12" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="12" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="12" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="13" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="8" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="5" align="center"><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
				</tr>
				<tr>
					<td height="8"><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td align="center" valign="top"><i><font size="1"><br></font></i></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
				</tr>
				<tr>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="11" rowspan="7" height="84" align="center" valign="middle"><b>Расчет<br>стоимости</b>
					</td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="10" rowspan="7" align="center" valign="middle"><b>За<br>тонны</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="10" rowspan="7" align="center" valign="middle"><b>За<br>расстояние<br>перевозки</b>
					</td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="10" rowspan="7" align="center" valign="middle"><b>За<br>специаль<br>-ныйтранспорт</b>
					</td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="10" rowspan="7" align="center" valign="middle"><b>За<br>транс-портные<br>услуги</b>
					</td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="10" rowspan="7" align="center" valign="middle"><b>Погрузоч-<br>но-разгру-зочные<br>работы,
							т</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="18" rowspan="3" align="center" valign="middle"><b>Сверхнормативный<br>простой</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="9" rowspan="7" align="center" valign="middle"><b>Прочие<br>доплаты</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="9" rowspan="7" align="center" valign="middle"><b>Дополни-<br>тельные<br>услуги<br>(экспеди-<br>рование)</b>
					</td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="16" rowspan="3" align="center" valign="middle"><b>К оплате</b></td>
					<td><br></td>
					<td colspan="11">Таксировка</td>
					<td><br></td>
					<td style="border-bottom: 1px solid #1f1c1b" colspan="20" align="center"><br></td>
				</tr>
				<tr>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
				</tr>
				<tr>
					<td><br></td>
					<td style="border-bottom: 1px solid #1f1c1b" colspan="32" align="center"><br></td>
				</tr>
				<tr>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="9" rowspan="4" align="center" valign="middle"><b>погрузка</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="9" rowspan="4" align="center" valign="middle"><b>разгрузка</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="8" rowspan="4" align="center" valign="middle"><b>итого</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="8" rowspan="4" align="center" valign="middle"><b>в том<br>числе<br>ТЭП</b></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
				</tr>
				<tr>
					<td><br></td>
					<td style="border-bottom: 1px solid #1f1c1b" colspan="32" align="center"><br></td>
				</tr>
				<tr>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
				</tr>
				<tr>
					<td><br></td>
					<td style="border-bottom: 1px solid #1f1c1b" colspan="32" align="center"><br></td>
				</tr>
				<tr>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="11" height="13" align="center" valign="middle"><b><br></b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="10" align="center" valign="middle" sdval="32" sdnum="1049;"><b>32</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="10" align="center" valign="middle" sdval="33" sdnum="1049;"><b>33</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="10" align="center" valign="middle" sdval="34" sdnum="1049;"><b>34</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="10" align="center" valign="middle" sdval="35" sdnum="1049;"><b>35</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="10" align="center" valign="middle" sdval="36" sdnum="1049;"><b>36</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="9" align="center" valign="middle" sdval="37" sdnum="1049;"><b>37</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="9" align="center" valign="middle" sdval="38" sdnum="1049;"><b>38</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="9" align="center" valign="middle" sdval="39" sdnum="1049;"><b>39</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="9" align="center" valign="middle" sdval="40" sdnum="1049;"><b>40</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="8" align="center" valign="middle" sdval="41" sdnum="1049;"><b>41</b></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="8" align="center" valign="middle" sdval="42" sdnum="1049;"><b>42</b></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
				</tr>
				<tr>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="11" height="17">По заказу
					</td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="10" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="10" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="10" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="10" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="10" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="9" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="9" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="9" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="9" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="8" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="8" align="center"><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
				</tr>
				<tr>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="11" height="17">Выполнено
					</td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="10" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="10" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="10" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="10" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="10" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="9" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="9" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="9" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="9" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="8" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="8" align="center"><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
				</tr>
				<tr>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="11" height="17">Расценка
					</td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="10" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="10" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="10" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="10" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="10" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="9" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="9" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="9" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="9" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="8" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="8" align="center"><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
				</tr>
				<tr>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="11" height="17">К оплате
					</td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="10" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="10" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="10" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="10" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="10" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="9" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="9" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="9" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="9" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="8" align="center"><br></td>
					<td style="border-top: 1px solid #1f1c1b; border-bottom: 1px solid #1f1c1b; border-left: 1px solid #1f1c1b; border-right: 1px solid #1f1c1b"
					    colspan="8" align="center"><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
					<td><br></td>
				</tr>

				<tr>
					<td colspan="29" height="15">С товаром переданы документы:</td>
					<td><br></td>
					<td style="border-bottom: 1px solid #1f1c1b" colspan="116" align="center"><br></td>
				</tr>

				<tr>
					<td style="border-bottom: 1px solid #1f1c1b" colspan="146" height="15" align="center"><br></td>
				</tr>
				</tbody>
			</table>
		</div>
	</div>
<?php

