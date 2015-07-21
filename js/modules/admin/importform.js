//var current_input=null;

$(document).ready( function(){
	//http://demo.webcareer.ru/2014/01/popup/index.html

	/*$(".row").ajaxError(function(e, xhr, settings, exept){
    	alert("При выполнении ajax-запроса страницы " + settings.url + " произошла ошибка.");
  	});*/

/* --------------------------------- запуск импорта ------------------------*/
	$('#run_import').click(function(){
		startLoadingAnimation();
		// $.post(
		// 	rootFolder+'/admin/directory/import',
		// 	{	// список параметров
		// 		sql: $('#query_text').val(),
		// 	},
		// 	onAjaxQuery  // функция приёма сообщений от сервера
		// );
	});
/* --------------------------------- */

	$('#exec_query').click(function(){
		//alert($('#query_text').val());
		$.post(
			rootFolder+'/admin/ajax/query',
			{	// список параметров
				sql: $('#query_text').val(),
			},
			onAjaxQuery  // функция приёма сообщений от сервера
		 );
	});
/* ----------------------------- Установка перетягиваемых блоков ------------------  */
	$(function(){
		$("#response").draggable({
		    cursor: "move",
		    distance: 20,
	    	//revert: true,
	    	//revertDuration: 3000
	  	});

		$("#time_table").draggable({
		    cursor: "move",
		    distance: 20,
	    	revert: true,
	    	//revertDuration: 3000
	  	});
	});

/* ------------------------------------------------------------------ */
	$('#ch_create').click(function(){
		//alert($('#ch_create').prop("checked"));
		$(':radio, #key_field, #new_tname').prop('disabled',$('#ch_create').prop("checked"));
		$('#new_tname').prop('disabled',!$('#ch_create').prop("checked"));
	});

/* ------------------------------------------------------------------ */


/* ---------------------- Всплывающее окно ------------------------- */


	$('#overlay').css({opacity: 0.5}); // Делаем затемняющий фон кроссбраузерным
    setPosition($('#response')); // Позиционируем всплывающее окно по центру

    $('#close_popup').click(function() { // Скрываем всплывающее окно при клике по кнопке закрыть
		$('#response, #overlay').fadeOut(50);
		//$('#response').fadeOut(50);
    });

    function setPosition(elem) { // Функция, которая позиционирует всплывающее окно по центру
        elem.css({
            marginTop: '-' + elem.height() / 2 + 'px',
			marginLeft: '-' + elem.width() / 2 + 'px'
        });
    }

/*---------------------- field src -----------------------------------*/

	$('#get_fields_src_button').click(function(){
	  //alert('get_fields_src_button');
	  		// отправляем POST-запрос
	  	//alert($('#path').val());
		$.post(
			rootFolder+'/admin/ajax/fieldsrclist',
			{	// список параметров
				path: $('#path').val(),
			},
			onAjaxGetFieldsSrc  // функция приёма сообщений от сервера
		 );
	});		/* $('#get_fields_src_button').click */

/*------------------------ table list -----------------------------------*/

	$('#get_table_list_button').click(function(){
		startLoadingAnimation();
	  //alert('get_table_list_button');
	  		// отправляем POST-запрос
	  	//alert($('#path').value);
		$.post(
			rootFolder+'/admin/ajax/tablelist',
			{	// список параметров
				str: '',
			},
			onAjaxGetTableList  // функция приёма сообщений от сервера
		 );
	});		/* $('#get_table_list_button').click */

/*------------------------ field dst ---------------------------------*/

	$('#get_field_dst_button').click(function(){
	  //alert('get_field_dst_button');
	  		// отправляем POST-запрос
	  	//alert($('#path').value);
		$.get(
			rootFolder+'/admin/ajax/fieldlist/tname/'+$('#tname').val(),
			{	// список параметров
				tname2: $('#tname').val(),
			},
			onAjaxGetFieldList  // функция приёма сообщений от сервера
		 );
	});		/* $('#get_field_dst_button').click */

/*------------------------ new_tname ---------------------------------*/
	$('#new_tname').blur(function(){
		var new_tname_val = $('#new_tname').val();
		if (new_tname_val != '') {
			//alert('!=""--'+new_tname_val+'--');
			$('#tname').val(new_tname_val);
			$('#ch_create').prop('checked', true);
		} else {
			//alert('=""--'+new_tname_val+'--');
			$('#ch_create').prop('checked', false);
		}
		$(':radio, #key_field').prop('disabled',$('#ch_create').prop("checked"));
		$('#new_tname').prop('disabled',!$('#ch_create').prop("checked"));
	})

});  /* $(document).ready */

/*--------------------------------------------------------------------*/
/*--------------------------------------------------------------------*/

/*-------------------Список полей src---------------------------------*/

function onAjaxGetFieldsSrc(data) {
	//alert(data);
	//alert(eval(data)[3]);
	var str = '';
	var arr;
	//arr = eval(data);
	var div;
	div = $('.fields');
	div.empty();
	var i=0;
	eval(data).forEach(function(val) {
		div.append("<div class='field'><input n='"+i+"' name='import[field_src][]' class='src_field' value='"+val+"' placeholder='src_поле'>"+
					"-> <input n='"+i+"' name='import[field_dst][]' class='dst_field' value='' placeholder='dst_поле'>" +
					"(<input n='"+i+"' name='import[field_dst_type][]' class='dst_type' value='' placeholder='тип поля'>)</div>");
		i++;
		//str += val+'<br>';
	});

		// при потере фокуса, запоминаем поле
	/*$('.fields :text').blur(function(){
		//alert($(this).attr('n'));
		current_input = $(this).attr('n');
	});*/

	//div.append('<div id="close_popup"</div>');
	//alert(str);

	//$('.response').html(str);
}

/*---------------------- Cписок таблиц БД ----------------------------*/

function onAjaxGetTableList(data) {
	//alert(data);
	//var obj = jQuery.parseJSON(data);
	$('.caption').html('Список таблиц БД');
	div = $('.mess ul');
	div.empty();
	eval(data).forEach(function(val) {
		div.append('<li>'+val.name+'</li>');
	});

	/*------------------------ click по ссылке в popup  -----------------*/
	$('.mess ul li').click(function(){
		//alert(eventObject.currentTarget.text());
		//alert(this.tagName);
		//alert(this.innerHTML);
		$('#tname').val(this.innerHTML);
		$('#close_popup').click();
		$('#get_field_dst_button').prop('disabled',false);
		$('#ch_create').prop('checked', false);
		$(':radio, #key_field').prop('disabled',$('#ch_create').prop("checked"));
		$('#new_tname').val('');
	})

	$('#response, #overlay').fadeIn(50);	//показать всплывающее окно
	//$('#response').fadeIn(50);	//показать всплывающее окно
	stopLoadingAnimation();
}

/*---------------------- Список полей dst ----------------------------*/

function onAjaxGetFieldList(data) {
	//alert(data);
	//var obj = jQuery.parseJSON(data);
	$('.caption').html('Список полей таблицы <u>'+$('#tname').val()+'</u>');
	div = $('.mess ul');
	div.empty();
	eval(data).forEach(function(val) {
		div.append('<li><b>'+val.name+'</b> <span clas="type">('+val.type+')</span></li>');
	});

	$('.mess ul li').click(function(){
		//alert($(this).find('b').html());
		//$('.dst_field[n='+current_input+']').val($(this).find('b').html());
		$(':focus').val($(this).find('b').html());
		//$('#close_popup').click();
	})

	//$('#response, #overlay').fadeIn(50);	//показать всплывающее окно
	$('#response').fadeIn(50);	//показать всплывающее окно
}

/*-------------------- Результат запроса -----------------------------*/
function onAjaxQuery(data) {
	alert(data);
}


/*--------------------------------------------------------------------*/
function startLoadingAnimation() // - функция запуска анимации
{
	// найдем элемент с изображением загрузки и уберем невидимость:
	var imgObj = $("#loadImg");

	// вычислим в какие координаты нужно поместить изображение загрузки,
	// чтобы оно оказалось в серидине страницы:
	var centerY = $(window).scrollTop() + ($(window).height() - imgObj.height())/2;
	var centerX = $(window).scrollLeft() + ($(window).width() - imgObj.width())/2;
	// поменяем координаты изображения на нужные:

	//alert(centerX+'  -  '+centerY);
	imgObj.offset({top:centerY, left:centerX});
	//$('#overlay').fadeIn(10);
	imgObj.show();
	//alert();
	 // imgObj.css({
	   //         Top: '-' + centerY + 'px',
		//		Left: '-' + centerX + 'px'
	      //  });
}

function stopLoadingAnimation() // - функция останавливающая анимацию
{
	//$('#overlay').fadeOut(10);
 	$("#loadImg").hide();
}