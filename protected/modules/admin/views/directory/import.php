<?php
  $this->addCSS('modules/admin/importform.css');
  $this->addCSS('cupertino/jquery-ui-1.10.4.custom.css');

  $this->addJS('modules/admin/importform.js');
  $this->addJS('jquery-ui.js');

  echo Yii::app()->getModule('admin')->getBasePath();
  echo  '<br>'.Yii::getPathOfAlias('admin');
?>

<form name='import' method="post" action="#">
	<div class='tables'>
		<div class="row">
			<label for="path">Истоник</label>
			<input name='import[path]' id='path' value='<?php echo Yii::app()->params['pathToDBF'] ?>f160005.dbf'>
			<button id='get_fields_src_button' type='button'>Получить список полей таблицы</button>
		</div>
		<div class="row">
			<label for="tname">Назначение</label>
			<input name='import[tname]' id='tname' value='' placeholder='имя таблицы в БД'>
			<button id='get_table_list_button' type='button'>Список таблиц БД</button>
			<button id='get_field_dst_button' type='button' disabled>Список полей</button>
		</div>
	</div>
	<div class="row">
		<input type='checkbox' name='import[create]' id='ch_create'>
		<label for="ch_create">Создать новую таблицу</label>
		<input name='import[new_tname]' id='new_tname' value='' placeholder='Имя новой таблицы' disabled>
	</div>
	<div class='options'>
		Опции:
		<div class="row">
			<input type='checkbox' name='import[replace]' id='r_replace' value="replace"><label for="r_replace">Очистить таблицу в БД</label>
		</div>
		<div class="row">
			<input type='radio' name='import[radio]' id='r_append' value="append"><label for="r_append">Добавить с новыми ключами</label>
		</div>
		<div class="row">
			<input type='radio' name='import[radio]' checked id='r_update' value="update"><label for="r_update">Объединить</label>
			<input name='import[key_field_src]' id='key_field_src' value='' placeholder='ключевое поле src'>
			<input name='import[key_field_dst]' id='key_field_dst' value='' placeholder='ключевое поле dst'>
		</div>
	</div>
	<br>
	src --------------------------------------------  dst
	<div class="fields">
		<div class="field">
			<input n='0' name='import[field_src][]' class='src_field' value='' placeholder='src_поле'> ->
			<input n='0' name='import[field_dst][]' class='dst_field' value='' placeholder='dst_поле'>
			(<input n='0' name='import[field_dst_type][]' class='dst_type' value='' placeholder='тип поля'>)
		</div>
		<div class="field">
			<input n='1' name='import[field_src][]' class='src_field' value='' placeholder='src_поле'> ->
			<input n='1' name='import[field_dst][]' class='dst_field' value='' placeholder='dst_поле'>
			(<input n='1' name='import[field_dst_type][]' class='dst_type' value='' placeholder='тип поля'>)
		</div>
	</div>
	<br>
	<div class='row'>
		<!-- <button type='submit' id='run_import'>Выполнить</button> -->
		<input type="submit" id='run_import'>
	</div>
</form>

<div id='query'>
	<textarea placeholder='текст запроса' id='query_text'></textarea>
	<br>
	<button type='button' id='exec_query'>Выполнить запрос</button>
</div>
<div class="response" id="response">
	<div class="caption">
		Заголовок окна
	</div>
	<div id="close_popup"></div>
	<div class="mess">
		<ul></ul>
	</div>
</div>

<!-- br>
fasdfasdfasdfasdf
<br>
fasdfasdfasdfasdf
<br>
fasdfasdfasdfasdf
<br>
fasdfasdfasdfasdf
<br>
fasdfasdfasdfasdf
<br>
fasdfasdfasdfasdf
<br>
fasdfasdfasdfasdf
<br>
fasdfasdfasdfasdf
<br>
fasdfasdfasdfasdf
<br>
fasdfasdfasdfasdf
<br>
fasdfasdfasdfasdf
<br>
fasdfasdfasdfasdf
<br>
fasdfasdfasdfasdf
<br>
fasdfasdfasdfasdf
<br>
fasdfasdfasdfasdf
<br>
fasdfasdfasdfasdf
<br>
fasdfasdfasdfasdf
<br>
fasdfasdfasdfasdf
<br>
fasdfasdfasdfasdf
<br>
fasdfasdfasdfasdf
<br>
fasdfasdfasdfasdf
<br>
fasdfasdfasdfasdf
<br>
fasdfasdfasdfasdf
<br>
fasdfasdfasdfasdf
<br>
fasdfasdfasdfasdf
<br>
fasdfasdfasdfasdf
<br>
fasdfasdfasdfasdf
<br>
fasdfasdfasdfasdf
overflow: hidden
<br>
fasdfasdfasdfasdf
overflow: hidden
<br>
fasdfasdfasdfasdf
overflow: hidden
<br>
fasdfasdfasdfasdf
overflow: hidden
<br>
fasdfasdfasdfasdf
overflow: hidden
<br>
fasdfasdfasdfasdf
overflow: hidden
<br>
fasdfasdfasdfasdf
overflow: hidden
<br>
fasdfasdfasdfasdf
overflow: hidden
<br>
fasdfasdfasdfasdf
overflow: hidden22313123123123123123 -->