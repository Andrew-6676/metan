<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 20.07.15
 * Time: 9:37
 */

?>
<h2>Книга замечаний и предложений</h2>

<table class="std" style="width: 100%">
	<?php
	foreach ($data as $mess) {
		$tr = '<tr>';
		$tr .=  '<td style="width: 100px">';
		$tr .=      $mess->id;
		$tr .=  '</td>';
		$tr .=  '<td class="l" style="white-space: pre">';
		$tr .=      $mess->mess;
		$tr .=  '</td>';
		$tr .= '</tr>';
		echo $tr;
	}

	?>
</table>