var workdate=null
var to_id = null;
var anim = false;
$(document).ready( function(){

		// событие отправки ajax-запроса
  $(document).ajaxSend(
    function(){
    		// ерез секунду после отправки показываем анимацию
      to_id = setTimeout(
      				function() {
      						anim = true;
                            $('#overlay').show();
                            $('#loadImg').show();
                    },
              1000)

    }
  );
  		// событие получения ответа от сервера
  $(document).ajaxComplete(
    function(){
     	// alert("Пришёл ответ ссервера.");
     	// если ответ пришёл раньше, чем показали анимацию - отменяем анимацию
	    clearTimeout(to_id);
	    	// если анимация показана, то прячем  через секунду, после получения ответа
	    if (anim) {
			setTimeout(
					function() {
		                $('#overlay').hide();
		                $('#loadImg').hide();
		            },
		    1000)
		}
    }
  );

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

function formatNum(num) {
		//alert('--->'+num+'<---');
		str = num.toString();
		str = str.replace(/(\.(.*))/g, '');
		var arr = str.split('');
		var str_temp = '';
		if (str.length > 3) {
			for (var i = arr.length - 1, j = 1; i >= 0; i--, j++) {
				str_temp = arr[i] + str_temp;
				if (j % 3 == 0) {
					str_temp = ' ' + str_temp;
				}
			}
			//alert(str_temp);
			return str_temp;
		} else {
			return str;
		}
	}