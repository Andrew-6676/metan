return.php

<div id="mposter">Обновить этот DIV</div>
<?php
echo CHtml::ajaxButton(
			'Получить ответ от сервера',
			CController::createUrl('/MainAjax/updateRest'),
			array(
				'type' => 'GET',			// method
				'beforeSend' => 'function(request) {
									alert("перед отправкой");
								}',
				'success' => 'function(data) {
									alert("Данные пришли");
									$("#mposter").html(data);
								}',
			    'data' => array('id'=>119, array('quantity'=>333, 'cost'=>444)),	// что отправить на сервер
      			'update' => '#mposter', 		// куда вставить резултат, работает, если нет success
			),
			array(
				'href' => Yii::app()->createUrl( 'ajax/new_link' ),
				'class' => "class",
				//'type' => 'submit',
			)
	);
?>
<?=CHtml::linkButton('Удалить', array(
    'submit'=>array(
        'MainAjax/test',
        'id' => 55
    ),
    'params'=>array(
        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
    ),
    'confirm'=>"Точно удалить?"
))?>