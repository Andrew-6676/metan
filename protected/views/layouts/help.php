<?php
	$this->beginContent('//layouts/helppage'); ?>

	<div id="left">
			навигация по справке
		<?php
				// формируем содержимое левой панели (меню)

		?>
	</div> <!-- left -->


 	<div id="content2">
		<?php
			// вывод контента, сформированном в представлении контроллера
			echo $content;
		?>
	</div>	<!-- content -->

<?php $this->endContent(); ?>
