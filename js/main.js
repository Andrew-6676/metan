var rootFolder = '/metan_0.1';
var workdate=null
var to_id = null;
var anim = false;
var ajax_count = 0;

$(document).ready( function(){


/*----------------------------------*/
    $("#to_top").hide();
        // если документ не больше окна браузера
    if ($(window).innerHeight()-$(document).innerHeight()>-100) {
        $("#to_bottom").hide();
    }
            // событие прокрутки документа
        $(window).scroll(function () {
            //alert('sdf');
                // если прокрутили вниз на 150 и более пикселей от верха
            if ($(this).scrollTop() > 150) {
                $('#to_top').fadeIn();
            } else {
                $('#to_top').fadeOut();
            }
                // если прокрутили вниз на 100 и более пикселей от низа
            if ($(window).scrollTop()+$(window).innerHeight()-$(document).innerHeight()>-100) {
                $("#to_bottom").fadeOut();
            } else {
                $("#to_bottom").fadeIn();
            }
        });

        // при изменениии высоты документа во время просмотра
    OnResizeElement(document, function(el){
            if ($(window).scrollTop()+$(window).innerHeight()-$(document).innerHeight()>-100) {
                $("#to_bottom").fadeOut();
            } else {
                $("#to_bottom").fadeIn();
            }
    }, 300);

/*---------------------------------------------------------------------------------*/

		// событие отправки ajax-запроса
  $(document).ajaxSend(
    function(){
    	ajax_count++;
    	//console.log('--> send '+ajax_count+'  /anim='+anim);
    	if (!anim) {
	    		// через секунду после отправки показываем анимацию
	        to_id = setTimeout(
	      				function() {
	      						// 	если пришли не все ответы - показываем анимацию
      						if (ajax_count > 0) {
	      						anim = true;
	                            $('#overlay').show();
	                            $('#loadImg').show();
    							console.log('show '+ajax_count+'  /anim='+anim);
	                        }
	                    },
	              1000)
	    }
    }
  );

  		// событие получения ответа от сервера
  $(document).ajaxComplete(
    function(){
    	ajax_count--;
     	//console.log("<-- ответ с сервера. "+ ajax_count+'  /anim='+anim);
     	if (ajax_count == 0) {
     		//console.log('последний ответ!');
	     	// если ответ пришёл раньше, чем показали анимацию - отменяем анимацию
		    clearTimeout(to_id);
		    	// если анимация показана, то прячем  через секунду, после получения ответа
		    if (anim) {
		    	console.log('запуск скрытия анимации')
				setTimeout(
						function() {
							console.log('hide');
			                $('#overlay').hide();
			                $('#loadImg').hide();
			                anim = false;
			            },
			    1000)
			}
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
			rootFolder+'/MainAjax/setWorkDate',
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
/* --------------------------------- запуск импорта ------------------------*
	//$('#run_import').click(function(){
	//	startLoadingAnimation();
		// $.post(
		// 	rootFolder+'/admin/directory/import',
		// 	{	// список параметров
		// 		sql: $('#query_text').val(),
		// 	},
		// 	onAjaxQuery  // функция приёма сообщений от сервера
		// );
	});*/
/* --------------------------------- */

})

/* --------------------------------- */
/* --------------------------------- */
/* --------------------------------- */
function onSetWorkDate(data) {
	//alert(data);
	//location="http://annet.dn.ua"
		// если вызвалась эта функция, то дата на сервере поменялась - перезагружаем страницу
	location.reload();
}
/* --------------------------------- */

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

/*--------------------------------------------------------------------------*/

function OnResizeElement(element, handler, time){
    var id = null;
    var _constructor = function(){
        var WIDTH = $(element).outerWidth(),
            HEIGHT = $(element).outerHeight();
        id = setInterval(function(){
            if(WIDTH != $(element).outerWidth() || HEIGHT != $(element).outerHeight()){
                WIDTH = $(element).outerWidth(), HEIGHT = $(element).outerHeight();
                handler(element);
            };
        }, time);
    };
    var _destructor = function(){
        clearInterval(id);
    };
    this.Destroy = function(){
        _destructor();
    };
    _constructor();
};