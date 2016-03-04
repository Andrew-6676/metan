<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 20.07.15
 * Time: 8:10
 */
	$this->addCSS('store/prepareGoodsreport.css');
	$this->addCSS('forms.css');
	$this->addJS('store/prepareGruntreport.js');
?>
<div class="title">
	<h2>Реализация грунтов</h2>
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
			<input type="date" name="getReport[from_date]" placeholder="Дата документа" required value="<?php echo date('Y-m-d', mktime(0,0,0,$d[1],$d[2],$d[0])) ?>"> <!-- pattern="[0-9]{2}\.[0-9]{2}\.[0-9]{4}" -->

			<label class="inline" for="getReport[doc_date]">по</label>
			<input type="date" name="getReport[to_date]" placeholder="Дата документа" required value="<?php echo date('Y-m-d', mktime(0,0,0,$d[1],$d[2],$d[0])) ?>"> <!-- pattern="[0-9]{2}\.[0-9]{2}\.[0-9]{4}" -->
			<br>
		</div>	<!-- r2 -->
	</div>    <!-- <div class="doc_hat"> -->
</div>
<br>
<div class="buttons">
	<input type="submit" onclick="return false" value="Показать" id="showReport">
	<input disabled="disabled" type="submit" onclick="return false" value="Отправить по e-mail" id="send_mail">
	<input disabled="disabled" type="submit" onclick="return false" value="Открыть в офисе" id="openOffice">
	<input type="submit" onclick="return false" value="Печать" id="printReport">
</div>

</form>

<br>
<br>
<div id="Report">

</div>
