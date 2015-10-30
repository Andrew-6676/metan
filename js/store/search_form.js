var sForm;
// _this = this;
//  document.getElementById(this.id).onmouseover =  function(){_this.func()};

// function search(sender_1) {
// 	sForm = new searchForm();
//  	sForm.create({
//  		capt: "Поиск для расхода",
//  		table: "goods",
//  		field: "name",
//  		key: "id",
//  		width: 800,
//  		sender: $(sender_1).parent().parent().attr('id'),
//  	});
//  	//console.log($(sender_1).parent().parent().attr('id'));
// }

/*-----------------------------------------------------------------*/
function paste_result(row_id, fields) {
		/*		вставка результатов поиска
			row_id - куда вставить
			fields - что вставить
		*/
	console.log('row_id - '+fields.id );
	// alert(JSON.stringify(fields));
	if (row_id=='contact_name') {
		$('#contact_name').val(fields.name);
		$('#contact_name').attr('cid',(fields.id*1));
		$('#contact_name').focus();
	} else {
		row = $('#'+row_id);
		row.find('.id_goods').val(fields.id);
		row.find('.goods_name').val(fields.name+'  ('+fields.rest+' шт.)');

		console.log(fields.cost);
		row.find('.price').attr('cost',fields.cost);
		row.find('.price').attr('markup',fields.markup);
		row.find('.price').attr('vat',fields.vat);

		row.find('.price').val(fields.price);

		row.find('.goods_name').focus();
	}
	sForm.closeForm();
}
/*-----------------------------------------------------------------*//*-----------------------------------------------------------------*/

/*-----------------------------------------------------------------*//*-----------------------------------------------------------------*/
	// объект окна поиска
function searchForm () {
		// свойства
	this.table = '';
	// this.action = '';
	this.form = null;
	this.visible = false;
	this.filter = '';
	this.arr = new Array();
	//this.sender = '';
/*-----------------------------------------------------------------*/
		// метод создаёт окно и показывает
	this.create = function(param) {
		//this.sender = param.sender;
		//console.log(param.table);
		//console.log(param.field);
		//console.log(param.key);
		sForm.fields = param.fields;
			// создать окно
		$('#content').append(
			"<div id='search_window'> \
				<div class='caption'>"+param.capt+"</div> \
				<div id='close_popup'></div> \
				<div id='f_content'> \
					<div class='selector'> \
						<table class='search_list'> \
						</table> \
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

		$('#f_content .counter').text($('.search_item').size());

			// фильтруем список по мере набора текста
		$('.search_filter').keyup(function(event) {
			if ((event.which > 45 && event.which < 222) || event.which==8 || event.which==32) {
				filter($(this).val());
					// проскролить до выделенного пункта
				$(".selector").scrollTop($('.selected').prevAll('.visible').size()*$('.selected').height())
			}
		});

			// обработчик нажатия стрелок на клавиатуре
		$('.search_filter').keydown(function(event) {
				 // alert(event.keyCode);
			if (event.keyCode==27) {
				// alert('close');
				$('#close_popup').click();
			}

			if (event.keyCode==13) {
				//alert($('.search_item.selected').attr('key'));
				event.stopPropagation();
				$('.search_item.selected').click();
			}
			if (event.keyCode==40 || event.keyCode==38 || event.keyCode==33 || event.keyCode==34) {
					// 40 - down
					// 38 - up
					// 34 - page down
					// 33 - page up
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
					var n = 1;
						// если есть выделеная строка - выделяем следующую или предыдущую
					if 	(event.keyCode==34) {
						var next_all = selected_item.nextAll('.search_item.visible');
						if (next_all.size() > 18) {
							next_all.eq(18).addClass('selected');
							selected_item.removeClass('selected');
						} else if (next_all.size() > 0) {
							next_all.last().addClass('selected');
							selected_item.removeClass('selected');
						} else {

						}
						n = 18;
						// selected_item.nextAll('.search_item.visible').first().addClass('selected');
					}
					if 	(event.keyCode==33) {
						var prev_all = selected_item.prevAll('.search_item.visible');
						if (prev_all.size() > 18) {
							prev_all.eq(18).addClass('selected');
							selected_item.removeClass('selected');
						} else if (prev_all.size() > 0) {
							prev_all.last().addClass('selected');
							selected_item.removeClass('selected');
						} else {

						}
						n = 18;
						// selected_item.nextAll('.search_item.visible').first().addClass('selected');
					}
					if 	(event.keyCode==40) {
						var next_all = selected_item.nextAll('.search_item.visible');
						if (next_all.size() > 0) {
							next_all.first().addClass('selected');
							selected_item.removeClass('selected');
						}
						// selected_item.nextAll('.search_item.visible').first().addClass('selected');
					}
					if 	(event.keyCode==38) {
						var prev_all = selected_item.prevAll('.search_item.visible');
						if (prev_all.size() > 0) {
							prev_all.first().addClass('selected');
							selected_item.removeClass('selected');
						}
					}
				}

					// если выделенная строка скрылась вверх
				if ($('.selected').position().top<36) {
					$(".selector").scrollTop($('.selected').prevAll('.visible').size()*$('.selected').height());
				}
					// если выделенная строка скрылась вниз
				if ($('.selected').position().top>460) {
					$(".selector").scrollTop($(".selector").scrollTop()+($('.selected').height()+2.1)*n);
				}


			}
			event.stopPropagation();	// что бы не обрабатывался onclick нижележащего элемента
		})

			// делаем его закрываемым
	    $('#close_popup').click(function() { // Скрываем всплывающее окно при клике по кнопке закрыть
			$('#search_window, #overlay').fadeOut(50);
			//$('#response').fadeOut(50);
			$('#search_window').remove();
			//console.log("close\n-------------------------------------\n");
	    });

	    	// заполняем данными
	    	// if (param.table=='contact') {
	    	// 	action = 'GetContactName';
	    	// } else {
	    	// 	action = 'GetGoodsNameFromRest';
	    	// }
	    		// запрос данных с сервера
			$.ajax({
				async: false,
          		// url: 'http://'+document.location.host+rootFolder+"/MainAjax/GetGoodsNameFromRest",
          		url: 'http://'+document.location.host + rootFolder + "/MainAjax/"+param.action,
          		type:'GET',
          		dataType: "json",
          		data: 'term='+''+'&f='+param.field, /*параметры для поиска: term - искомая строка, f - по какому полю искать*/
		        success: function(data) {
		        	// alert((data));
		        		// формируем массив из найденых в БД строк
		        		arr = new Array();
		        	// response(
		        		$.map(data, function(item){	// пробегаем по каждой строке результата
		        				// формируем строку таблицы из списка полей, переданных в конструтор формы
		        			var row = '';
					        var minus = '';
					        for (val of sForm.fields) {
						        var tmp = 'item.'+val;
						        var cl = '';
						        if (typeof(eval(tmp))=='number') {
							        cl = 'r';
							        tmp = 'String('+tmp+').'+"replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1`')";
						        }

						        row += '<td class="'+cl+'">' + eval(tmp) + '</td>';
						        if (eval(tmp)<0) {
							        //console.log(eval(tmp));
							        minus = 'minus';
						        };
							}

					        // выводим строку на экран
						        $('.search_list').append('<tr class="search_item visible '+minus+'" key='+item.id + '>'
						        + '<td class="char">' + item.id + '</td>'
						        + row
						        +'</tr>');

		        				// запихиваем в массив
			            	arr[item.id] = ({ 	// формируем массив нужной структуры
			            		//id: item.id,	// это поле для вставки в соседний <input> (код товара)
			            		value: item.name /*+ '    ('+item.rest+' шт)'*/,	// это поле вставится в <input>
			            		label: '['+item.id+'] '+item.name + '    ('+item.rest+' шт по '+item.price+'р.)',		// это поле отобразится в выпадающем списке
			            		price: item.price,
					            cost: item.cost,
					            markup: item.markup,
					            vat: item.vat,
			            		rest: item.rest
			              	})
			              //	alert(arr[arr.length]);
		            	})
		         //    );
					sForm.arr = arr;
					// alert(JSON.stringify(this.arr['42875425']));
					// alert((this.arr['42875425'].value));
		        }
        	});

				// действие по клику по строке результата
			$('.search_item').click(function(){
				//alert($(this).attr('key'));
				//console.log('sForm.sender - '+);
				//console.log(sForm.arr[$(this).attr('key')].price);
				paste_result(
					param.sender,
					{
						'id': $(this).attr('key'),
						'name': sForm.arr[$(this).attr('key')].value,
						'cost': sForm.arr[$(this).attr('key')].cost,
						'markup':sForm.arr[$(this).attr('key')].markup,
						'vat': sForm.arr[$(this).attr('key')].vat,
						'price': sForm.arr[$(this).attr('key')].price,
						'rest': sForm.arr[$(this).attr('key')].rest
					}
				);

			})
				// показываем кол-во найденных строк
			$('#f_content .counter').text($('.search_item').size());


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
	this.closeForm = function () {
		$('#search_window, #overlay').fadeOut(50);
		$('#search_window').remove();
		//console.log("close\n-------------------------------------\n");
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