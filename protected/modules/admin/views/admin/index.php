<?php
	//$str = '$arr = array("label"=>"Gii", "url"=>"http://".Yii::app()->request->ServerName."/test_yii/index.php/gii/default/index", "visible"=>(Yii::app()->user->id<0));';
	//$str = '$arr = array("a","b");';
	//$str = '$arr=34;';

	echo ('это главная  страница админки ');
	echo CHtml::link('Админка', array('/admin/admin/index'));  // выведем ссылку на эту же страницу (например)
	echo '<br>'.$this->basePath;
	echo '<br>';
	echo '<br>';
	echo '<br>';

	echo '<pre>';

	//print_r("str=  ".$str);

	echo '<br>';
	echo '<br>';
	echo '<br>';

	//eval($str);
	//print_r($arr);

	echo '<br>';
	echo '<br>';
	echo '<br>';
/*
	$menu = Menu::model()->findAllBySql('select m.url
										from vg_menu m inner join vgm_group g on g.id=m.id_group
										where enabled=true and (m.id_group=0 or g.id=(select id_group from vgm_user where id=:id))
										order by ord',
										array(':id'=>intval(Yii::app()->user->id)));
	//print_r($menu);
	$items = array();
	foreach($menu as $item) {
		eval($item->url);
		//print_r($items[0]['visible']);
		print_r($item->name.' -- '.$item->url."\n");
	}
	//print_r($items);

	echo '</pre>';

	echo '<br>';
	echo '<br>';
	echo '<br><div style="border: 1px solid black">';

//$this->beginContent('//layouts/main');
			$this->widget('zii.widgets.CMenu', array(
	    			'items'=>$items,
	     			'htmlOptions'=>array('class'=>'leftmenu'),
	     			'encodeLabel'=>false,
	     		));
			//$this->endWidget();

			echo "</div>";
//$this->endContent();*/