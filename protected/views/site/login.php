<?php
/* SiteController->LoginAction->Login_view*/
// форма аутентификации
  $this->addCSS('loginform.css');
//  $this->addJS('loginform.js');
?>

<!--div class="form">
<php $form=$this->beginWidget('CActiveForm'); ?>

    <php echo $form->errorSummary($model); ?>

    <div class="row">
        <php echo $form->label($model,'login'); ?>
        <php echo $form->textField($model,'login') ?>
    </div>

    <div class="row">
        <php echo $form->label($model,'pass'); ?>
        <php echo $form->passwordField($model,'pass') ?>
    </div>

    <div class="row submit">
        <php echo CHtml::submitButton('Войти'); ?>
    </div>

<php $this->endWidget(); ?>
</div><!- form -->


<div id='loginform'>
	<form method="post" action="#" name="login_f">
		<!--fieldset-->
				<!--legend>Авторизация</legend-->
			<div class="captionrow">Введите логин и пароль</div>
			<div class="daterow">
				<input type="date" name="date" placeholder="Дата" required  autofocus value="<?php echo date('Y-m-d') ?>"> <!-- pattern="[0-9]{2}\.[0-9]{2}\.[0-9]{4}" -->
			</div>
			<div class="loginrow">
				<input type="text" name="login" placeholder="Имя пользователя" required pattern="[a-zA-Z0-9]{4,10}">
			</div>
			<div class="passrow">
				<input type="password" name="pass" placeholder="Пароль" required>
			</div>
			<div class="submitrow">
				<button class="submit" type="submit">Войти</button>
			</div>
			<div class='<?php if ($err) echo "err_"; ?>messagerow'>
				<?php
				  	echo "$err1";
  					echo "$err2";
  				?>
			</div>
		</fieldset>
	</form>

</div><!-- test form -->



