<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 18.09.15
 * Time: 8:10
 */

$this->addCSS('print/report.css');

?>
	<div class="rep_wrapper">
		<div class="page l">
			<div class="report_title">
				Торг 6
			</div>
			<div class="sub_title">

			</div>
		<?php
			//Utils::print_r($data)


		?>


			<table>
				<thead>
				<tr>
					<td>Наименование показателя</td>
					<td>Номер
						строки</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				</thead>
				<tr>
					<td>Розничный товарооборот
						(сумма строк 02 и 04) </td>
					<td>01</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>в том числе продано:</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>пищевых продуктов, напитков
						и табачных изделий </td>
					<td>02</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>из них алкогольных напитков</td>
					<td>03</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>непродовольственных товаров</td>
					<td>04</td>
					<td><?php echo Yii::app()->format->formatNumber($sum->price - $sum2->price+$rk[0]-$rk[1]) ?></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>Запасы товаров в розничных торговых объектах и на складах
						на конец отчетного периода</td>
					<td>05</td>
					<td>!!</td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>Товарооборот общественного питания (сумма строк 07 и 09)</td>
					<td>06</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>в том числе продано:</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>ищевых продуктов, напитков
						и табачных изделий </td>
					<td>07</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>из них алкогольных напитков</td>
					<td>08</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>непродовольственных товаров</td>
					<td>09</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</table>


		</div>
	</div>
<?php

//Utils::print_r($sum);
//Utils::print_r($sum2);
//Utils::print_r($sum->price - $sum2->price);
//Utils::print_r($rk);


