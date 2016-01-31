<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 20.07.15
 * Time: 8:10
 */
	$this->addCSS('store/prepareGoodsreport.css');
	$this->addCSS('forms.css');
	$this->addJS('store/prepareGoodsreport.js');
?>
<div class="title">
	<h2>Товарный отчёт</h2>
</div>
<form>
<div class="form">
	<div class="new_doc_hat">
		<div class="row r3">
			<label class="inline" for="getReport[doc_num]">№ документа:</label>
			<input type="number" name="getReport[doc_num]" placeholder="№ документа" value="1" required> <!-- pattern="[0-9]{2}\.[0-9]{2}\.[0-9]{4}" -->
		</div>	<!-- r3 -->
		<div class="row r2">
			<?php
			$d = explode('-', Yii::app()->session['workdate']);
			?>
			<br>
			<span>За период:</span>
			<label class="inline" for="getReport[doc_date]">с</label>
			<input type="date" name="getReport[from_date]" placeholder="Дата документа" required value="<?php echo date('Y-m-d', mktime(0,0,0,$d[1],$d[2]-9,$d[0])) ?>"> <!-- pattern="[0-9]{2}\.[0-9]{2}\.[0-9]{4}" -->

			<label class="inline" for="getReport[doc_date]">по</label>
			<input type="date" name="getReport[to_date]" placeholder="Дата документа" required value="<?php echo date('Y-m-d', mktime(0,0,0,$d[1],$d[2],$d[0])) ?>"> <!-- pattern="[0-9]{2}\.[0-9]{2}\.[0-9]{4}" -->
			<br>
			<br>
			<input type="checkbox" name="getReport[full]">
			<label class="inline" for="getReport[full]">Подробный</label>
		</div>	<!-- r2 -->

	</div>    <!-- <div class="doc_hat"> -->
</div>
<br>
<div class="buttons">
<!--	<button id="getreportButton">Сформировать</button>-->
<!--	<button id="printButton">Печать</button>-->
	<input type="submit" onclick="return false" value="Печать" id="printButton">
	<input type="submit" onclick="return false" value="Печать (типовая форма)" id="printButton2">
</div>

</form>
<!--<div id="goodsReport">-->
<!--	сюда аяксом выдать сформированный отчёт-->
<!--</div>-->
