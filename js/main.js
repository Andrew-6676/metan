var workdate=null
$(document).ready( function(){

/*-------------------------------------------------------------------------------*/
	workdate = $('#workdate input').val();
	//alert(workdate);

	// $('#workdate input').blur(function(){
	// 	//alert('blur');
	// });


	$('#workdate input').change(function(){
		//alert('change');
		if (workdate!=$('#workdate input').val()) {
			$('#workdate button').show();
		} else {
			$('#workdate button').hide();
		}
	});
		// отменить смену даты
	$('#cancel_workdate').click(function(){
		$('#workdate button').hide();
		$('#workdate input').val(workdate);
	});
	$('#workdate input').keyup(function(event){
		if (event.keyCode==27) {
			$('#workdate button').hide();
			$('#workdate input').val(workdate);
		}
	})
	/*-------------------------*/
	$('#refresh_workdate').click(function(){
			// запросить подтверждение изменения даты и перезагрузки страницы
			//alert($('#workdate input').val());
			// переприсвоить workdate в сессии
		$.get(
			'/metan_0.1/MainAjax/setWorkDate',
			{	// список параметров
				date: $('#workdate input').val(),
			},
			onSetWorkDate  // функция приёма сообщений от сервера
		)

		$('#workdate button').hide();
	});
/*-------------------------------------------------------------------------------*/
	//http://demo.webcareer.ru/2014/01/popup/index.html

	/*$(".row").ajaxError(function(e, xhr, settings, exept){
    	alert("При выполнении ajax-запроса страницы " + settings.url + " произошла ошибка.");
  	});*/
function onSetWorkDate(data) {
	//alert(data);
	//location="http://annet.dn.ua"
		// если вызвалась эта функция, то дата на сервере поменялась - перезагружаем страницу
	location.reload();
}
/* --------------------------------- запуск импорта ------------------------*
	//$('#run_import').click(function(){
	//	startLoadingAnimation();
		// $.post(
		// 	'/metan_0.1/admin/directory/import',
		// 	{	// список параметров
		// 		sql: $('#query_text').val(),
		// 	},
		// 	onAjaxQuery  // функция приёма сообщений от сервера
		// );
	});*/
/* --------------------------------- */
})