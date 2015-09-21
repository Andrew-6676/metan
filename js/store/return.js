var search_data = {
		capt: "Поиск для возврата",
		action: "GetGoodsNameFromAll",
		fields: ["name"],
		field: 'name',
		key: "id",
		width: 800,
		sender: null,
};
/*----------------------------------------------------*/

$(document).ready(function(){

	$('#return_doc_id_operation').focus();
	$('#return_doc_id_operation').click(function(event){
		$('[name*=doc_date]').focus();
		event.stopPropagation();
	})


	// $('.search').keyup(function(event){
	// 	if (event.keyCode==118) {
	// 	 	//alert('Поиск');
	// 	 	event.stopPropagation();	// что бы не обрабатывался onclick нижележащего элемента
	// 	 	//createSearchForm();
	// 	 	sForm = new searchForm();
	// 	 	sForm.create({
	// 	 		table: "goods",
	// 	 		field: "name",
	// 	 		key: "id"
	// 	 	});
	// 	}
	// })


$('#add_return').click(function(){

		//alert('сохранить возврат');
		//alert(document.location.host);
		//alert($('[name = "return_doc[id_operation]"]').val());
			// собираем данные в массив
		var arr = {};
		var goods_arr = {};
		var exp = {'doc':'', 'doc_data':''};

		var id 		= $('.id_goods');	// массив инпутов с кодами товаров
		var quantity= $('.quantity');	// массив с количествами товаров
		var price 	= $('.price'); 		// массив с ценами

			// цикл по кодам товара
		var err = false;
		id.each(function(index, element){
			//alert(index+' -- ["'+$(element).val() + '"] = '+ $(quantity).eq(index).val());

				// если одно из полей пустое - выдать сообщение с вариантами: пропустить/отменить

				// создаём массив вида array('id'=>array(quantity, price))
			if ($(id).eq(index).val() != '' && $(quantity).eq(index).val() != '' && $(price).eq(index).val() !='') {
				goods_arr[$(element).val().replace(/`/g,"")] = {
						'quantity':$(quantity).eq(index).val(),
						'price':$(price).eq(index).val()
				};
			} else {
				alert('не все поля заполнены!');
				err =  true;
				return false;
			}

			// goods_arr[$(element).val()] = $(quantity).eq(index).val();
		});

		if (err) {return false;}

			// массив с аттрибутами документа (шапка)
		arr['doc_id']		= $('#new_goods_table').attr('doc_id');
		arr['id_operation'] = $('[name = "return_doc[id_operation]"]').val();
		arr['doc_date']		= $('[name = "return_doc[doc_date]"]').val();
		arr['doc_num'] 		= $('[name = "return_doc[doc_num]"]').val();

			// запихиваем два массива в один, который и отправится на сервер
		exp['doc'] = arr;
		exp['doc_data'] = goods_arr;
	 	// alert(JSON.stringify(exp));

       // $('#loadImg').show();
	   //	$('#overlay').show();

			// передаём данные на сервер
		$.ajax({
          		url: 'http://'+document.location.host+rootFolder+"/store/return",
          		type:'POST',
          		dataType: "json",
          		data: {new_return: exp},
          			// функция обработки ответа сервера
          		error: function(data) {
          			alert(JSON.stringify(data)+'###');
          			alert('Во время сохранения произошла ошибка. Проверьте введённые данные!');
          		},
		        success: function(data){
		        	//alert(JSON.stringify(data));
		        //	var res = eval(data);
		        	//alert(data.status+'---');
		        	//alert(typeof data);
		        	if (data.status == 'ok') {
		        		location.reload();
		        	} else {
		        		alert('Во время сохранения произошла ошибка. Проверьте введённые данные!\n\r'+JSON.stringify(data));
		        		//$('#overlay').hide();
        				//$('#loadImg').hide();
		        	}
		        	// обновить страницу в случае удачного сохранения

		        }
        	});
	});		// end $('#add_return').click

});


/*----------------------------------------------------------------*/
function set_autocomplete(id) {
	//alert(id);
	$(id + " .id_goods").autocomplete({
		source: function (request, response) {
			//response функция для обработки ответа
			//alert(request.term); // - строка поиска;
			$.ajax({
				url: 'http://' + document.location.host + rootFolder + "/MainAjax/GetGoodsNameFromAll",
				type: 'GET',
				dataType: "json",
				data: 'term=' + request.term + '&f=id',
				success: function (data) {
					//alert((data));
					response(
						$.map(data, function (item) {
							return {
								value: item.id,
								label: '' + String(item.id).pad(10) + ' ' + item.name.pad(50) + ' ',		// это поле отобразится в выпадающем списке
								name: item.name,
							}
						})
					);
				}
			});
		},
		minLength: 3,
		select: function (event, ui) {
			// ui.item будет содержать выбранный элемент
			//alert(ui.item.name);
			//alert($(this).parent('td').parent('tr').attr('id').substr(4));
			var row = $(this).parent('td').parent('tr').attr('id').substr(4);
			$('#row_' + row + ' .goods_name').val(ui.item.name + '   (' + ui.item.rest + ' шт)');
			$('#row_' + row + ' .price').attr('cost', ui.item.cost);
			$('#row_' + row + ' .price').attr('markup', ui.item.markup);
			$('#row_' + row + ' .price').attr('vat', ui.item.vat);
			$('#row_' + row + ' .quantity').focus();
			// вставить цену товара в <input>
			//alert(ui.item.price*1);
			$('#row_' + row + ' .price').val((ui.item.price * 1));
		}
	});		// end $(id+" .id_goods" ).autocomplete

	/*------------------ Автодополнение для наименования товара --------------------------------*/
	$(id + " .goods_name").autocomplete({
		source: function (request, response) {
			//response функция для обработки ответа
			//request.term - строка поиска;
			$.ajax({
				url: 'http://' + document.location.host + rootFolder + "/MainAjax/GetGoodsNameFromAll",
				type: 'GET',
				dataType: "json",
				data: 'term=' + request.term + '&f=name', /*параметры для поиска: term - искомая строка, f - по какому полю искать*/
				success: function (data) {
					//alert((data));
					// формируем массив из найденых в БД строк
					response(
						$.map(data, function (item) {	// пробегаем по каждой строке результата
							//console.log('>'+item.name.pad(40)+'<');
							return { 	// формируем массив нужной структуры
								id: item.id,	// это поле для вставки в соседний <input> (код товара)
								value: item.name,	// это поле вставится в <input>
								label: '' + String(item.id).pad(10) + ' ' + item.name.pad(50) + ' ',		// это поле отобразится в выпадающем списке
							}
						})
					);
				}
			});
		},
		minLength: 4,
		// действие на выбор из выпадающего списка
		select: function (event, ui) {
			/*ui.item будет содержать выбранный элемент*/
			// определяем id текущей строки таблицы
			var row = $(this).parent('td').parent('tr').attr('id').substr(4);
			// вставить код товара в <input>
			$('#row_' + row + ' .id_goods').val(ui.item.id);
			// вставить цену товара в <input>
			$('#row_' + row + ' .price').val(ui.item.price);
			$('#row_' + row + ' .price').attr('cost', ui.item.cost);
			$('#row_' + row + ' .price').attr('markup', ui.item.markup);
			$('#row_' + row + ' .price').attr('vat', ui.item.vat);
			// поставить курсор в <input> количество
			$('#row_' + row + ' .quantity').focus();
		}
	});		// end $(id+" .goods_name" ).autocomplete
	/*---------------------------------------------------------*/


	$(id + ' input').keypress(function (event) {
		if (event.keyCode == 13) {
			console.log('next input');
			//console.log($('input:visible').index(this));
			if ($('input:visible').size() > $('input:visible').index(this) + 1) {
				$('input:visible').eq($('input:visible').index(this) + 1).focus();
			} else {
				//$('input:visible, button:visible').eq($('input:visible, button:visible').index(this) + 1).focus();
				$('#add_new_row, .form_footer button').first().focus();
			}

			event.stopPropagation();
		}

		//if (event.keyCode==13 && !$(this).is(':button')) {
		//	if ($(this).hasClass('price')) {
		//		if ($(this).closest('tr').next().length != 0) {
		//			$(this).closest('tr').next().find('.id_goods').focus();
		//		} else {
		//			$('#add_expence').focus();
		//			$('#add_invoice').focus();
		//			$('#add_return').focus();
		//		}
		//	} else {
		//		$(this).parent().next().find('input, button').focus();
		//	}
		//}
	});
	/*----------------------------------------------------------*/
	$(id + ' input').keydown(function () {
		if (event.ctrlKey) {
			if (event.keyCode == 37 || event.keyCode == 39) {
				var step = -38 + event.keyCode;
				$('#new_goods_table input').eq($('#new_goods_table input').index(this) + step).focus();
			}
			//} else {
			if (event.keyCode == 38 || event.keyCode == 40) {
				event.stopPropagation();
				//console.log('#new_goods_table input.' + $(this).attr('class').split(' ')[0]);
				var step = -39 + event.keyCode;
				//if (event.keyCode == 38) {
				//	step = -1;
				//}
				//if (event.keyCode == 40) {
				//	step = 1;
				//}
				//$('input:visible').size()>$('input:visible').index(this)+1)
				$('#new_goods_table input.' + $(this).attr('class').split(' ')[0]).eq($('#new_goods_table input.' + $(this).attr('class').split(' ')[0]).index(this) + step).focus();
			}
		}
	});
	/*---------------------------------------------------------*/
	$(id + ' input').keyup(function (event) {
		//alert(event.ctrlKey);
		//alert(event.keyCode);
		if (event.ctrlKey && event.keyCode == 13) {
			//$(this).parent().parent().next().find .focus();
			$('#add_new_row').click();
			event.stopPropagation();
			//alert('Ctrl+enter');
		}
	})
	/*---------------------------------------------------------*/
	$(id + ' .del_row').click(function () {
		if ($('#new_goods_table tbody tr').size() > 1) {
			var row = $(this).parent('div').parent('td').parent('tr').attr('id');
			//alert('delete '+row);
			$('#' + row).remove();
			// пересчитать сумму
			$('.quantity').eq(0).change();
			console.log('www');
		} else {
			alert('Нельзя удалить единственную строку!');
		}
	})

	$(id + ' .clr_row').click(function () {
		var row = $(this).parent('div').parent('td').parent('tr').attr('id').substr(4);
		//alert('clear '+row);
		$(this).parent().parent().parent().find(':input').val('');
	})

	/*-------------Пересчёт сумм при изменении количества---*/
	$(id + ' .quantity, ' + id + '  .price').change(function () {

		// alert('ch q');
		var tr = $(this).closest('tr');
		var pr = tr.find('.price').val();
		var qt = tr.find('.quantity').val();
		if (pr != '' || pr != 0) {
			tr.find('.summ').text(formatNum(pr * qt));
		} else {
			tr.find('.summ').text('');
		}
		;

		var itog_summ = 0;

		$('.summ').each(function (i, e) {
			itog_summ += $(e).text().replace(/\s+/g, '') * 1;
		})
		$('.itog_summ').text(formatNum(itog_summ));
	})

	/*-------------Поиск по F7------------------------------*/
	$(id + ' .search.goods_name').keyup(function (event) {
		if (event.keyCode == 118) {
			//alert('Поиск');
			sForm = new searchForm();
			search_data.sender = $(this).parent().parent().attr('id');
			sForm.create(search_data);
		}
	})

}		// end set_autocomplete


