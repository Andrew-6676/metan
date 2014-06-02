<?php
	$this->beginContent('//layouts/main'); ?>

	<div id="left">

		<?php
				// формируем содержимое левой панели (меню)
				//echo $var2
			//	$this->widget('zii.widgets.CMenu',array( $this->menu ));
			$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>'Справочники:',
			));
			$this->widget('zii.widgets.CMenu', array(
					'id' => 'leftmenu1',
	    			'items'=>$this->menu,
	     			'htmlOptions'=>array('class'=>'leftmenu'),
	     			'encodeLabel'=>false,
	     		));
			$this->endWidget();

				// Если есть второе меню - то выводим и его
			if (count($this->menu2)>0) {
				$this->beginWidget('zii.widgets.CPortlet', array(
					'title'=>'Операции:',
				));
				$this->widget('zii.widgets.CMenu', array(
						'id' => 'leftmenu2',
		    			'items'=>$this->menu2,
		     			'htmlOptions'=>array('class'=>'leftmenu'),
		     			'encodeLabel'=>false,
		     		));
				$this->endWidget();
			}
		?>
	</div> <!-- left -->


 	<div id="content2">
		<?php
			// вывод контента, сформированном в представлении контроллера
			echo $content;
		?>
	</div>	<!-- content -->

<?php $this->endContent(); ?>
