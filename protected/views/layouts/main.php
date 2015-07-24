<?php
//error_log("----------------------------");

//error_log(print_r(Yii::app()->session->sessionID, true));
//if ($this->beginCache('main2_'.Yii::app()->user->id))
{
?>
<!DOCTYPE HTML>
<html lang="ru">
<head>
	<!--[if lt IE9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<meta charset="utf-8">
	<link rel="icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon.ico" type="image/x-icon">
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" rel="stylesheet">
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/menu.css" rel="stylesheet">
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.js"></script>
	<?php
	echo $this->getCSS();
	echo $this->getJS();
	?>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/main.js"></script>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body>
<div class="back_head"></div>
<header id="header">

	<?php // если пользователь залогинился - выводим справа сверху дату
	if (!Yii::app()->user->isGuest) {

//				  echo Yii::app()->session['id_store'];
		if (Yii::app()->session['can_select_store']) {
			echo '<div id="store_info">';
			$stores = Store::model()->findAll(array('condition' => 'id>0', 'order' => 'name'));
			$list = CHtml::listData($stores,
				'id', 'name');
			echo CHtml::dropDownList('id_store',
				Yii::app()->session['id_store'],
				$list
				//			array('class'=>'ddd')
			);

			?>
			<div class="btn">
				<button id="refresh_store"></button>
				<button id="cancel_store"></button>
			</div>
		</div>
			<?php
		}
		echo '<div class="store_names"><span class="store_fname">' . Store::model()->findByPk(Yii::app()->session['id_store'])->fname . '</span>';
		echo '<span class="store_name">(' . Store::model()->findByPk(Yii::app()->session['id_store'])->name . ')</span></div>';
		?>

		<div id="workdate">
			<div>
				<div>Работаем с датой:</div>
				<input name="workdate" type="date" value="<?php echo Yii::app()->session['workdate']; ?>">
			</div>
			<div class='btn'>
				<button id="refresh_workdate"></button>
				<button id="cancel_workdate"></button>
			</div>
		</div>
	<?php }
	echo '<!--';
	//echo CHtml::encode(Yii::app()->name);
	//echo "<br>ServerName = <b>".Yii::app()->request->ServerName."</b>";
	//echo '<br>basePath = <b>'.$this->basePath.'</b>; ';
	if (Yii::app()->user->isGuest) {
		//echo "isGuest = <b>Yes</b><br>";
	} else {
		$isg = "No";
		echo 'Controller = <b>' . $this->uniqueId . '</b>; Action = <b>' . $this->action->id . '</b>;<br>';
		echo "login = <b>" . Yii::app()->user->name . "</b>; ";
		echo "id_user = <b>" . intval(Yii::app()->user->id) . "</b>=>";
		echo User::model()->findByPk(Yii::app()->session['id_user'])->fname . '<br>';
		echo "id_store=<b>" . Yii::app()->session['id_store'] . "</b> => ";
		echo Store::model()->findByPk(Yii::app()->session['id_store'])->fname . '<br>';
		echo "Workdate=<b>" . Yii::app()->session['workdate'] . "</b><br";
	}

	//echo $_SERVER['HTTP_HOST'].'   '.$_SERVER['REQUEST_URI'];
	//print_r(Yii::app()->session['id_store']);
	//echo "loginUrl = "; print_r(Yii::app()->user->loginUrl);  // страница ввода логина и пароля
	//echo "returnUrl = "; print_r(Yii::app()->user->returnUrl);  // страница для перенаправления после удачного логина
	?>
	-->
</header>
<div class="back_menu"></div>
<nav id="main_menu">
	<?php
	// загружаем из БД главное меню
	$menu = Menu::model()->findAllBySql('select m.id, m.url
													from {{menu}} m inner join {{group}} g on g.id=m.id_group
													where enabled=true and level=0 and category=\'main\' and (m.id_group=0 or g.id=(select id_group from vgm_user where id=:id))
													order by ord',
		array(':id' => intval(Yii::app()->user->id)));


	$sub_menu = Menu::model()->findAllBySql('select m.id, m.url
													from {{menu}} m inner join {{group}} g on g.id=m.id_group
													where enabled=true and level>0 and category=\'sub\' and (m.id_group=0 or g.id=(select id_group from vgm_user where id=:id))
													order by ord',
		array(':id' => intval(Yii::app()->user->id)));


	// echo "<pre>";
	// print_r($sub_menu);
	// echo "</pre>";
	//exit;
	//print_r($menu);
	$items = array();
	$sub_items = array();


	// полученные из БД данные пихаем в масив $sub_items[]
	foreach ($sub_menu as $item) {
		// echo $item->url.'---';
		eval($item->url);
	}
	//Utils::print_r($sub_items);
	//Utils::print_r($this->action->id);
	//if ($this->action->id == 'index') {
	//	$this->menu = $sub_items;
	//Utils::print_r($this->menu);
	//	}
	$i = 0;
	// полученные из БД данные пихаем в масив $items[]
	foreach ($menu as $item) {
		eval($item->url);
		//print_r($item->name.' -- '.$item->url."\n");
		$items[$i]["itemOptions"] = array('id' => 'm_' . $item->id);
		$items[$i]["submenuOptions"] = array('id' => 'sub_' . $item->id, 'class' => 'sub_menu');
		if (array_key_exists($item->id, $sub_items)) {
			$items[$i]['items'] = $sub_items[$item->id];
		}
		$i++;
	}
	$items[] = array("label" => "Справка", "linkOptions" => array('target' => '_blank'), "url" => array("/help/index/c/" . $this->uniqueId . "/a/" . $this->action->id . '/i/' . $this->helpIndex));
	$items[] = array("label" => "Войти", "url" => array("/site/login"), "visible" => Yii::app()->user->isGuest);
	$items[] = array("label" => "Выйти <span class=\"exitname\">(" . Yii::app()->user->name . ")</span>", "url" => array("/site/logout"), "visible" => !Yii::app()->user->isGuest);
	// echo "<pre>";
	// print_r($items);
	// echo "</pre>";


	// echo "<pre>";
	// print_r($sub_menu);
	// echo "</pre>";


	// exit;
	// выводим полученное меню
	$this->widget('zii.widgets.CMenu', array(
		'encodeLabel' => false,
		'items' => $items
		/*array(
		// array('label'=>'<img src="'.Yii::app()->request->baseUrl.'/images/dom.png">', 'url'=>array('/site/index')),
		array('label'=>'Главная', 'url'=>array('/site/index')),
	/*	array('label'=>'Site-Info', 'url'=>array('/site/info')),
		array('label'=>'Test-Index', 'url'=>array('/test/index')),
		array('label'=>'Test-Test', 'url'=>array('/test/test')),
		   array('label'=>'Printer',   'url'=>array('/printer/index')),
		   array('label'=>'GuestBook',   'url'=>array('/guestbook/index')),*/
		/*	array('label'=>'Gii', 'url'=>'http://'.Yii::app()->request->ServerName.'/test_yii/index.php/gii/default/index', 'visible'=>(Yii::app()->user->id<0)),
			array('label'=>'Справочники', 'url'=>array('/admin/directory/index'), 'visible'=>(Yii::app()->user->id<0)),
			   array('label'=>'Выход <span class="exitname">('.Yii::app()->user->name.')</span>', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
			   array('label'=>'Вход','url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),*/
	)); ?>

</nav>
<!-- #main menu  -->
<?php
//	$this->endCache();
}
?>
<div class="wrapper">
	<?php
	// вывод контента, сформированного в представлении контроллера и в файлах /layouts/c1.php или /layouts/c2.php
	echo $content;
	?>
</div>

<footer id="footer">
	<!--small><p>Copyright (c) 2014  #id: footer [Подвал сайта]</p></small-->
	<?php echo CHTML::link('Обратная связь', Yii::app()->createAbsoluteUrl("site/gbook"), array('id' => 'feedback')); ?>
	<address>
		Разработчик: <a href='mailto:
      				<?php echo Yii::app()->params['adminEmail']; ?>'>
			<?php echo Yii::app()->params['adminFIO'] . "  (" . Yii::app()->params['adminEmail'] ?>)
		</a>
		<br>
	</address>
	<?php echo Yii::powered(); ?>
</footer>


<a id="to_bottom" href='#footer'>
	<div>
	</div>
</a>
<a id="to_top" href='#header'>
	<div>
	</div>
</a>

<div id="overlay"></div>
<!-- для затемнения фона -->
<img id="loadImg" src="<?php echo Yii::app()->request->baseUrl; ?>/images/loading.gif"/>
</body>
</html>