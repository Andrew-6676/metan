index.php

<?php
	// Utils::print_r($this->menu);
	if (sizeof($this->menu) > 0) {
		$this->widget('zii.widgets.CMenu',array(
						'encodeLabel'=>false,
                        'items'=>$this->menu
		              )
		);

	}
?>