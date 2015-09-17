<?php
	$this->addCSS('store/restClose.css');
	$this->addJS('store/restClose.js');
	//print_r(Utils::getMonthList());
	$months = Utils::getMonthList();
	//Utils::print_r($months);

	// echo '<div class="closed"><table>';
	// foreach ($months as $num => $name) {
	// 	if ($num > intval(date('m'))) {
	// 		break;
	// 	}

	// 	echo '<tr>';
	// 		echo '<td>';
	// 			echo $name;
	// 		echo '</td>';
	// 		echo '<td>';
	// 			echo 'закрыт';
	// 		echo '</td>';
	// 	echo '</tr>';
	// }
	// echo '</table></div>';
?>

<div class='restClose'>
	<label for=''>Закрываем месяц:</label>
	<?php
		echo CHtml::dropDownList('months',
								 intval(date('m'))-1,
								 $months,
								 array('id'=>'month_num')
		);

		$years = array();
		for ($i=2015; $i < intval(date('Y')+1); $i++) {
			$years[$i] = $i;
		}

		echo CHtml::dropDownList('years',
								 date('Y'),
								 //array(2013=>2013, 2014=>2014, 2015=>2015, 2016=>2016),
								 $years,
								 array('id'=>'year_num')
		);
	?>
	<span id='res_span'></span>
	<br>
	<button id='close_month'>Закрыть месяц</button>
	<div id='res_div'></div>
</div>