<!DOCTYPE HTML>
<html lang="ru">
<head>
<!--[if lt IE9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
	<meta charset="utf-8">
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/help.css" rel="stylesheet">
	<?php
		echo $this->getCSS();
		echo $this->getJS();
	?>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body>
	<header id="header">
		<?php
			echo CHtml::encode(Yii::app()->name);
			//echo "<br>ServerName = <b>".Yii::app()->request->ServerName."</b>";
			echo '<br>basePath: <b>'.$this->basePath.'</b><br>';
			if (Yii::app()->user->isGuest) {$isg="Yes";} else {$isg="No";}
			echo "isGuest = <b>".$isg."</b><br>";
			echo "name = <b>".Yii::app()->user->name."</b><br>";
			echo "id = <b>".intval(Yii::app()->user->id)."</b><br>";
			echo "Workdate=<b>".Yii::app()->session['workdate']."</b><br>";
			if (isset($_GET['controller']))
			{
				echo 'Help for -> <b>'.$_GET['controller'].'/'.$_GET['action'].'</b><br>';
			} else {
				echo ' -> General help';
			}
			//echo "loginUrl = "; print_r(Yii::app()->user->loginUrl);  // страница ввода логина и пароля
			//echo "returnUrl = "; print_r(Yii::app()->user->returnUrl);  // страница для перенаправления после удачного логина
		?>
	</header>

	<nav id="main_menu">
		HELP
		<?php
				// загружаем из БД главное меню
				$items = array();

					// выводим полученное меню
				$this->widget('zii.widgets.CMenu',array(
							'encodeLabel'=>false,
        	                'items'=>$items
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

	</nav>  <!-- #main menu  -->

	<div class="wrapper">
		<?php
				// вывод контента, сформированного в представлении контроллера и в файлах /layouts/c1.php или /layouts/c2.php
			echo $content;
		?>
	</div>
	<footer id="footer">
		    <!--small><p>Copyright (c) 2014  #id: footer [Подвал сайта]</p></small-->
		    <address>
      			Разработчик: <a href='mailto:
      				<?php echo Yii::app()->params['adminEmail']; ?>'>
      					<?php echo Yii::app()->params['adminFIO']."  (".Yii::app()->params['adminEmail'] ?>)
      					</a>
      					<br>
			</address>
			<?php echo Yii::powered(); ?>
	</footer>
</body>
</html>
