<!DOCTYPE HTML>
<html lang="ru">

	<head>
		<meta charset="utf-8">
		<?php
			echo $this->getCSS();
		?>
		<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	</head>

	<body>


		<!-- <header id="header"> -->
		<!-- </header> -->
			<?php echo $content; ?>
		<!-- <footer id="footer"> -->
		<!-- </footer> -->

	</body>

</html>