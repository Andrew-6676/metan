<?php
	/* HelpController->IndexAction->Index_view*/

//		$this->addCSS('store/search_form.css');
		$this->addJS('ckeditor/ckeditor.js');

		$this->pageTitle = 'Справка: '.$data->title;
		// print_r($data);
		echo "<div id='content_help_cap'>";
		echo "<input type='text' id='help_edit_cap' value='$data->title'>";
		echo "</div>";

		echo "<div id='content_help'><textarea id='help_edit_content' class='editor' name='editor'>";
		echo nl2br($data->text);
		echo "</textarea></div>";

		echo	CHtml::ajaxButton(
							'Сохранить',
							Yii::app()->createURL('/editor/index'),
							array(
								'async' => 'false',
						        'type' => 'POST',
						        // 'data' => 'js:{"aj_page":"'.$page.'","text":$("iframe").contents().find("body").html()}',
						        // 'data' => 'js:{"aj_page":"'.$page.'","text":$("#editor").val()}',
						        'data' => 'js:{
						        	"action": "save",

						        	"descr":$("#help_edit_content").val(),
						        	"name":$("#help_edit_cap").val()
						        }',
						        //'beforeSend' => 'js:function(){console.log("before_aj");CKEupdate()}',
						        'success'=>'js:function(data){
						        		//alert("3");
						        		//console.log("data")
						        	$("#result").html(data);
						        	$("#save_btn").attr("disabled", "disabled");
						        	$("#name").attr("disabled", "disabled");
						        	_modified = false;
						        	if (data==1) {

						        	} else {
						        		//alert("Ошибка сохранения! Программеру в бубен!");

						        	}
						        }',
						        'error' => 'js:function(data){
						        	alert(JSON.stringify(data));
						        }',
						    ),
					        array('class'=>'button', 'id'=>'save_btn', 'disabled'=>'disabled')
			        );
?>

<!--<textarea id='editor' class="editor" name="editor"></textarea>-->
<script type='text/javascript'>CKEDITOR.replace( 'editor' );</script>