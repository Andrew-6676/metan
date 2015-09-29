<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 29.09.15
 * Time: 11:39
 */
?>
<div class="day_sum">
	<table class="std" style="margin: auto; margin-bottom: 20px;">
		<thead>
		<tr>
<!--			<td class="no_border"></td>-->
			<th></th>
			<th>Общий<br>товарооборот</th>
			<th>Розничный<br>товарооборот</th>
			<th>Собственные<br>нужды</th>
			<th><button class="reload"></button></th>
		</tr>
		</thead>
		<?php
		$s = array(0=>0,1=>0,2=>0,3=>0);
		foreach ($data as $id_op=>$op) {
			$tr = '<tr>';
			$tr .=   '<th>';
			$tr .=       '<b>'.Operation::model()->findByPK($id_op)->name.'</b>';
			$tr .=   '</th>';
			$tr .=   '<td>';
			$tr .=       number_format(@$op[1], '0', '.', '`');
			$tr .=   '</td>';
			$tr .=   '<td>';
			$tr .=       number_format(@$op[2], '0', '.', '`');
			$tr .=   '</td>';
			$tr .=   '<td>';
			$tr .=       number_format(@$op[3], '0', '.', '`');
			$tr .=   '</td>';
			$tr .=   '<td>';
			$tr .=       '<b>'.number_format(@$op[0], '0', '.', '`').'<b>';
			$tr .=   '</td>';
			$tr .= '</tr>';

			for($i=0; $i<4; $i++) {
				$s[$i] += @$op[$i];
			}

			echo $tr;
		}
		$tr = '<tr>';
		$tr .=   '<th>';
		$tr .=       '<b>Всего</b>';
		$tr .=   '</th>';
		$tr .=   '<td>';
		$tr .=       '<b>'.number_format($s[1], '0', '.', '`').'<b>';
		$tr .=   '</td>';
		$tr .=   '<td>';
		$tr .=       '<b>'.number_format($s[2], '0', '.', '`').'<b>';
		$tr .=   '</td>';
		$tr .=   '<td>';
		$tr .=       '<b>'.number_format($s[3], '0', '.', '`').'<b>';
		$tr .=   '</td>';
		$tr .=   '<td><b>';
		$tr .=       number_format($s[0], '0', '.', '`');
		$tr .=   '</td></b>';
		$tr .= '</tr>';
		echo $tr;

		?>
</table>

</div>

<script>
	$('.reload').click(function() {
//		alert('sdf');
		loadDaySvod('#svodday');
	});
</script>