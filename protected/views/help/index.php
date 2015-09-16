<?php
	/* HelpController->IndexAction->Index_view*/

	if ($data) {
		$this->pageTitle = 'Справка: '.$data->title;
		// print_r($data);
		echo "<div id='content_help_cap' >";
		if(intval(Yii::app()->user->id)<0){
			echo "<div id='editor_help'>";
			echo CHtml::link('[править]',array('help/editor/'.$data->id));
			echo "</div>";
		}
		echo "<div style='text-align:center'>".$data->title."</div>";
		echo "</div>";

		echo "<div id='content_help' 'hid'=".$data->id.">";
//		echo nl2br($data->text);
		echo ($data->text);
		echo "</div>";
		
	} else {
		echo 'Справка не найдена';
	}


?>


