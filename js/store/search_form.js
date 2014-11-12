// _this = this;
//  document.getElementById(this.id).onmouseover =  function(){_this.func()};


	// объект окна поиска
function searchForm () {
		// свойства
	this.table = '';
	this.form = null;
	this.visible = false;
	this.filter = '';
	this.arr = new Array();
/*-----------------------------------------------------------------*/
		// метод создаёт окно и показывает
	this.create = function(param) {
		console.log(param.table);
		console.log(param.field);
		console.log(param.key);
			// создать окно
		$('#content').append(
			"<div id='search_window'> \
				<div class='caption'>"+param.capt+"</div> \
				<div id='close_popup'></div> \
				<div id='f_content'> \
					<div class='selector'> \
						<ul class='search_list'> \
						</ul> \
					</div> \
					<input type='text' class='search_filter'>\
					<div>Записей найдено: <span class='counter'></span></div>\
				</div> \
			</div>"
		);
		this.form = $('#search_window');
			// сделать его перетаскиваемым
		$("#search_window").draggable({
		    cursor: "move",
		    // distance: 10,
		   	//revert: true,
		   	//revertDuration: 3000
		});



		//$('#overlay').css({opacity: 0.5}); // Делаем затемняющий фон кроссбраузерным
		setPosition($('#search_window'), param.width); // Позиционируем всплывающее окно по центру

		$('.counter').text($('.search_item').size());

			// фильтруем список по нажатию
		$('.search_filter').keyup(function(event) {
			if ((event.which > 45 && event.which < 222) || event.which==8 || event.which==32) {
				filter($(this).val());
					// проскролить до выделенного пункта
				$(".selector").scrollTop($('.selected').prevAll('.visible').size()*$('.selected').height())
			}
		})

			// обработчик нажатия стрелок
		$('.search_filter').keydown(function(event) {
				// alert(event.keyCode);
			if (event.keyCode==27) {
				// alert('close');
				$('#close_popup').click();
			}

			if (event.keyCode==13) {
				alert($('.search_item.selected').attr('key'));
			}
			if (event.keyCode==40 || event.keyCode==38) {
					// 40 - down
					// 38 - up
				// alert('down');

				var visible_items =  $('.search_item.visible');
				var selected_item =  $('.search_item.selected');
					// alert(selected_item.size());
					// если ни одной строки ещё не выделено - выделяем первую
				if (selected_item.size()==0) {
					// alert('f');
					visible_items.first().addClass('selected');
				} else {
					// alert('else');
						// если есть выделеная строка - выделяем следующую или предыдущую
					if 	(event.keyCode==40) {
						var next_all = selected_item.nextAll('.search_item.visible');
						if (next_all.size() > 0) {
							next_all.first().addClass('selected');
							selected_item.removeClass('selected');
						}
						// selected_item.nextAll('.search_item.visible').first().addClass('selected');
					} else {
						var prev_all = selected_item.prevAll('.search_item.visible');
						if (prev_all.size() > 0) {
							prev_all.first().addClass('selected');
							selected_item.removeClass('selected');
						}
					}
				}


				if ($('.selected').position().top<36) {
					$(".selector").scrollTop($('.selected').prevAll('.visible').size()*$('.selected').height());
				}
				if ($('.selected').position().top>460) {
					$(".selector").scrollTop($(".selector").scrollTop()+19);
				}


			}
			event.stopPropagation();	// что бы не обрабатывался onclick нижележащего элемента
		})

			// делаем его закрываемым
	    $('#close_popup').click(function() { // Скрываем всплывающее окно при клике по кнопке закрыть
			$('#search_window, #overlay').fadeOut(50);
			//$('#response').fadeOut(50);
			$('#search_window').remove();
			console.log("close\n-------------------------------------\n");
	    });

	    	// заполняем данными
	    		// запрос данных с сервера
			$.ajax({
				async: false,
          		url: 'http://'+document.location.host+"/metan_0.1/MainAjax/GetGoodsNameFromRest",
          		type:'GET',
          		dataType: "json",
          		data: 'term='+''+'&f=gname', /*параметры для поиска: term - искомая строка, f - по какому полю искать*/
		        success: function(data){
		        	// alert((data));
		        		// формируем массив из найденых в БД строк
		        		arr = new Array();
		        	// response(
		        		$.map(data, function(item){	// пробегаем по каждой строке результата
		        				// выводим строку на экран
		        			$('.search_list').append('<li class="search_item visible" key='+item.id+'>'+'['+item.id+'] '+item.name + '    ('+item.rest+' шт по '+item.price+'р.)'+'</li>');
		        				// запихиваем в массив
			            	arr[item.id] = ({ 	// формируем массив нужной структуры
			            		//id: item.id,	// это поле для вставки в соседний <input> (код товара)
			            		value: item.name + '    ('+item.rest+' шт)',	// это поле вставится в <input>
			            		label: '['+item.id+'] '+item.name + '    ('+item.rest+' шт по '+item.price+'р.)',		// это поле отобразится в выпадающем списке
			            		price: item.price,
			            		rest: item.rest
			              	})
			              //	alert(arr[arr.length]);
		            	})
		         //    );
					this.arr = arr;
					// alert(JSON.stringify(this.arr['42875425']));
					// alert((this.arr['42875425'].value));
		        }
        	});

				// назначаем действие по клику по строке результата
			$('.search_item').click(function(){
				alert($(this).attr('key'));
			})
				// показываем кол-во найденных строк
			$('.counter').text($('.search_item').size());


	    	// показываем окно
	    this.show();
	}
/*----------------------- end create ------------------------------------------*/
		// показать окно
	this.show = function() {
		$('#search_window, #overlay').fadeIn(50);	//показать всплывающее окно
		this.visible = true;
		$('.search_filter').focus();
	}
/*-----------------------------------------------------------------*/
		// закрыть окно
	this.close = function () {
		$('#search_window, #overlay').fadeOut(50);
		$('#search_window').remove();
		console.log("close\n-------------------------------------\n");
	}
/*-----------------------------------------------------------------*/
		// фильтрация списка
	function filter(str) {
		$('.search_item').each(function(i,e){
			var res = $(e).text().toUpperCase().search(str.toUpperCase());
			if (res>=0) {
				$(e).show();
				$(e).addClass('visible');
			} else {
				$(e).hide();
				$(e).removeClass('visible');
			}
		})
		$('.counter').text($('.search_item.visible').size());
		//alert('df');
	}
/*-----------------------------------------------------------------*/

/*-----------------------------------------------------------------*/

/*-----------------------------------------------------------------*/

/*-----------------------------------------------------------------*/


}	// end searchForm

/*-----------------------------------------------------------------*/
/*-----------------------------------------------------------------*/
/*-----------------------------------------------------------------*/



/*-----------------------------------------------------------------*/


/*-----------------------------------------------------------------*/

function setPosition(elem,width) { // Функция, которая позиционирует всплывающее окно по центру
	elem.width(width);
    elem.offset({
        top: ($(window).height()/2 - elem.outerHeight(true) / 2),
		left: ($(window).width()/2 - elem.outerWidth(true) / 2)
    });

}