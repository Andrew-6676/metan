<?php
	/* ErrorController->ErrorAction->Error_view*/
?>
<div class="errcaption">
	Ошибка <span class="errnum"><?php echo $error['code'] ?></span>
</div>

<div class="errmess">
	<?php
		$mess = preg_replace('/<user>/i', Yii::app()->user->name, $this->mess[$error['code']]);
		echo $mess;
	?>
</div>


<details class="detail">
	<summary>Детали ошибки</summary>
	<div class="errdetail">
		<?php
			$this->addCSS('error.css');
			echo '<span class="s1">code</span> <span class="s2">= '.$error['code'].'</span><br>';
			echo '<span class="s1">message</span> <span class="s2">= '.$error['message'].'</span><br>';
			echo '<span class="s1">type</span> <span class="s2">= '.$error['type'].'</span><br>';
		?>
	</div>
	<div>
		<details>
			<summary>переменная $error</summary>
			<div class="errvar">
				<?php print_r($error); ?>
			</div>
		</details>
	</div>
</details>