<?php
	$this->beginContent('//layouts/helppage'); ?>

	<div id="left">
			<div id="leftmenu_cap">Навигация по справке</div>
		<?php
				// формируем содержимое левой панели (меню)
		$this->widget('zii.widgets.CMenu', array(
					'id' => 'leftmenu_nav',
	    			'items'=>$this->menu,
	     			'htmlOptions'=>array('class'=>'leftmenu'),
	     			'encodeLabel'=>false,
	     		));
			

		?>
	</div> <!-- left -->


 	<div id="content2">
		<?php
			// вывод контента, сформированном в представлении контроллера
			echo $content;
		?>
	</div>	<!-- content -->

<?php $this->endContent(); ?>
