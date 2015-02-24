 <?php

$this->beginContent('//layouts/main'); ?>
 	<div id="content">
		<?php
				// вывод контента, сформированном в представлении контроллера
			echo $content;
		?>
	</div>	<!-- content -->
<?php $this->endContent(); ?>