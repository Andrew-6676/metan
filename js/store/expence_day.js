var timeout_id = window.setTimeout(checkNewData, 60000);
;
var search_data = {
	capt: "Поиск для расхода",
	action: "GetGoodsNameFromRest",
	fields: ["name", "rest", "price"],
	field: 'gname',
	key: "id",
	width: 800,
	sender: null
};
/*--------------------------------------------------*/
$(document).ready(function () {
	$('#for').val($('td.for').attr('id_for'));

	$('#expence_id_operation').focus();
	/*-----------------------------------------------------*/
	$('#expence_id_operation').click(function (event) {
		$('#for').focus();
		if ($('#expence_id_operation').val()==56) {
			$('.additional_data').attr('open','');
		}
		event.stopPropagation();
	});
	$('#for').click(function (event) {
		$('.id_goods').focus();
		event.stopPropagation();
	});
	$('#expence_id_operation').keypress(function (event) {
		if (event.keyCode == 13) {
			$('.id_goods').focus();
			event.stopPropagation();
		}
	});
	/*-----------------------------------------------------*/
	$('input').keypress(function (event) {
		if (event.keyCode == 13 && !$(this).is(':button')) {
			if ($(this).hasClass('price')) {
				if ($(this).closest('tr').next().length != 0) {
					$(this).closest('tr').next().find('.id_goods').focus();
				} else {
					$('#add_expence').focus();
				}
			} else {
				$(this).parent().next().find('input, button').focus();
			}
			event.stopPropagation();
		}
	})
	/*----------- пересчёт суммы ------------------------------------------*/
	$('.quantity, .price').change(function () {

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
	$('.search.goods_name').keyup(function (event) {
		if (event.keyCode == 118) {
			//alert('Поиск');
			sForm = new searchForm();
			search_data.sender = $(this).parent().parent().attr('id');
			sForm.create(search_data);
		}
	})
	/*------------ Ctrl + Enter ------------------------------------------------*/
	$('input').keyup(function (event) {
		//alert(event.ctrlKey);
		//alert(event.keyCode);
		if (event.ctrlKey && event.keyCode == 13) {
			//$(this).parent().parent().next().find .focus();
			$('#add_expence').click();
			event.stopPropagation();
			//alert('Ctrl+enter');
		}
	})

	/*--------------------- Автодополнение -------------------------------------------*/
	$(".id_goods").autocomplete({
		source: function (request, response) {
			//response функция для обработки ответа
			//alert(request.term); // - строка поиска;
			$.ajax({
				url: 'http://' + document.location.host + rootFolder + "/MainAjax/GetGoodsNameFromRest",
				type: 'GET',
				dataType: "json",
				data: 'term=' + request.term + '&f=gid',
				success: function (data) {
					//alert((data));
					response(
						$.map(data, function (item) {
							return {
								value: item.id,
								label: '[' + item.id + '] ' + item.name + '  (' + item.rest + ' шт по ' + item.price + 'р.)',
								name: item.name,
								price: item.price,
								rest: item.rest
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
			$('#row_' + row + ' .quantity').focus();
			// вставить цену товара в <input>
			//alert(ui.item.price*1);
			$('#row_' + row + ' .price').val((ui.item.price * 1));
		}
	});     // end $(".id_goods" ).autocomplete
	/*----------------------------------------------------------------------------------------*/
	$(".goods_name").autocomplete({
		source: function (request, response) {
			//response функция для обработки ответа
			//request.term - строка поиска;
			$.ajax({
				url: 'http://' + document.location.host + rootFolder + "/MainAjax/GetGoodsNameFromRest",
				type: 'GET',
				dataType: "json",
				data: 'term=' + request.term + '&f=gname', /*параметры для поиска: term - искомая строка, f - по какому полю искать*/
				success: function (data) {
					//alert((data));
					// формируем массив из найденых в БД строк
					response(
						$.map(data, function (item) { // пробегаем по каждой строке результата
							return {     // формируем массив нужной структуры
								id: item.id,    // это поле для вставки в соседний <input> (код товара)
								value: item.name + '    (' + item.rest + ' шт)',    // это поле вставится в <input>
								label: '[' + item.id + '] ' + item.name + '    (' + item.rest + ' шт по ' + item.price + 'р.)',       // это поле отобразится в выпадающем списке
								price: item.price,
								rest: item.rest
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
			// поставить курсор в <input> количество
			$('#row_' + row + ' .quantity').focus();
		}
	});     // end $(id+" .goods_name" ).autocomplete

	/*---------------- Сохранить расход -------------------------------------------*/
	$('#add_expence').click(function () {
		// alert('сохранить расход');
		//alert(document.location.host);
		//alert($('[name = "expence[id_operation]"]').val());
		// собираем данные в массив


		var arr = {};
		var goods_arr = {};
		var exp = {'doc': '', 'doc_data': ''};

		var id = $('.id_goods');   // массив инпутов с кодами товаров
		var quantity = $('.quantity');   // массив с количествами товаров
		var price = $('.price');      // массив с ценами
		// цикл по кодам товара
		var err = false;
		id.each(function (index, element) {
			//alert(index+' -- ["'+$(element).val() + '"] = '+ $(quantity).eq(index).val());

			// если одно из полей пустое - выдать сообщение с вариантами: пропустить/отменить

			// создаём массив вида array('id'=>array(quantity, price))
			if ($(id).eq(index).val() != '' && $(quantity).eq(index).val() != '' && $(price).eq(index).val() != '') {
				goods_arr[$(element).val()] = {
					'quantity': $(quantity).eq(index).val(),
					'price': $(price).eq(index).val()
				};
			} else {
				alert('не все поля заполнены!');
				//$('#expence_id_operation').focus();
				$('.goods_name').focus();
				err = true;
				return false;
			}

			// goods_arr[$(element).val()] = $(quantity).eq(index).val();
		});

		if (err) {
			return false;
		}

		//         // массив с аттрибутами документа (шапка)
		arr['doc_id'] = $('#new_goods_table').attr('doc_id');
		arr['id_operation'] = $('[name = "expence[id_operation]"]').val();
		arr['doc_date'] = $('[name = "expence[doc_date]"]').val();
		arr['doc_num'] = $('[name = "expence[doc_num]"]').val();
		arr['doc_for'] = $('[name = "for"]').val();

		//         // запихиваем два массива в один, который и отправится на сервер
		exp['doc'] = arr;
		exp['doc_data'] = goods_arr;
		// alert(JSON.stringify(exp));

		$('#overlay').show();
		$('#loadImg').show();

		//         // передаём данные на сервер
		$.ajax({
			url: 'http://' + document.location.host + rootFolder + "/store/expense",
			type: 'POST',
			dataType: "json",
			data: {new_expense: exp},
			// функция обработки ответа сервера
			error: function (data) {
				//alert(data.message);
				console.log(data);
				//alert('Во время сохранения произошла ошибка. Проверьте введённые данные!');
				$('#overlay').hide();
				$('#loadImg').hide();
			},
			success: function (data) {
				//  alert(JSON.stringify(data));
				//  var res = eval(data);
				//alert(data.status+'---');
				//alert(typeof data);
					// обновить страницу в случае удачного сохранения
				if (data.status == 'ok') {
					if (data.no_rest) {
						str = '';
						$(data.no_rest.no_rest).each(function (i,e) {
							//console.log(e);
							str += '"'+e.name +'" в остатке только ' + e.quantity + ' шт.'+"\n";
						});
						alert(str);
					}
					location.reload();
				} else {
					$('#overlay').hide();
					$('#loadImg').hide();
					str = '';
					$(data.no_rest).each(function (i,e) {
						//console.log(e);
						str += '"'+e.name +'" в остатке только ' + e.quantity + ' шт.'+"\n";
					});
					alert(str);
					$('.goods_name').focus();
				}

			}
		});
	})

	/*---------------------- Удалить строку --------------------------------------------*/
	$('button.del').click(function () {
		// получаем ID удаляемого документа
		var row = $(this).parent().parent();
		var tmp = row.css("background");
		row.css("background", "#fcc");
		var id = row.attr('doc_id');
		// alert('del '+ id);
		// exit;
		if (row.hasClass('delRow')) {
			row.remove();
		} else if (confirm("Точно хотите безвозвратно удалить строку \n " + row.find('td.name').text() + "?")) {
			// alert('delte');
			$.ajax({
				url: 'http://' + document.location.host + rootFolder + "/store/expense",
				type: 'POST',
				dataType: "json",
				data: {del_expense: id},
				// функция обработки ответа сервера
				error: function (data) {
					alert('Во время удаления произошла ошибка. Проверьте данные!');
					//alert(data);
				},
				success: function (data) {
					// alert(data);
					//alert(data.status);
					//alert(typeof data);
					// удалить строку из таблицы на странице в случае удачного удаления
					if (data.status == 'ok') {
						//location.reload();
						row.remove();
					}


				}
			});
		}
		row.css("background", "none");
		event.stopPropagation();	// что бы не обрабатывался onclick нижележащего элемента

	})
	/*------------------ Редактировать  строку --------------------------------------------*/

	/*----------------------  --------------------------------------------*/
	$('button.edit').click(function () {
		// alert('edit');
		// ячейки куда надо вставлять данные
		var td_dst = $('#new_goods_table tbody tr td');
		// из этих ячеек надо сокпировать данные
		var td_src = $(this).parent().parent().find('td');
		// переносим нужные данные
		td_dst.eq(0).find('[name*=id_operation]').val(td_src.eq(6).attr('id_operation'));
		td_dst.eq(1).find('[name=for]').val(td_src.eq(7).attr('id_for'));
		td_dst.eq(2).find('input').val(td_src.eq(1).text());
		td_dst.eq(3).find('input').val(td_src.eq(2).text());
		td_dst.eq(4).find('input').val(td_src.eq(3).text().trim().replace(/`/g, ""));
		td_dst.eq(5).find('input').val(td_src.eq(4).text().trim().replace(/`/g, ""));
		// id документа
		$('#new_goods_table').attr('doc_id', td_src.parent().attr('doc_id'));
		// пересчитываем сумму
		$('.quantity, .price').change();

		$('.action').removeClass('new');
		$('.action').addClass('edit');
		$('.action').text('[редактирование]');
		$('#cancel_expence').show();
		$('#add_expence').text('Сохранить');
	})

	$('#cancel_expence').click(function () {
		$(this).hide();
		$('#new_goods_table').attr('doc_id', -1);
		$('#new_goods_table tbody tr td input').val('');
		$('.summ').text('');
		$('.action').removeClass('edit');
		$('.action').addClass('new');
		$('.action').text('[добавление]');
		$('#add_expence').text('Добавить');
	})

	// печать расхода за день
	$('.print_doc_button').click(function (event) {
		var id = $(this).parent().attr('doc_id');
		// alert('print invoice  '+$('#doc_hat_'+id+' .doc_num').text());
		window.open(rootFolder + '/print/index?report=Expenceday', '_blank')
		event.stopPropagation();    // что бы не обрабатывался onclick нижележащего элемента
	})
})      // end document.ready

/*--------------------------------------------------------------------------------------------------*/
/*---------------------------- Проверка и загрузка новых строк с сервера ---------------------------*/
function checkNewData() {
	// console.log('start check data');
	// var lastId = $('.doc_data tr').last().attr('doc_id');
	// console.log(lastId);

	// создаём массив из id видимых пользователю строк
	var idArr = new Array();
	$('.doc_data tbody tr').each(function () {
		idArr.push($(this).attr('doc_id'))
	})

	$.ajax({
		url: 'http://' + document.location.host + rootFolder + "/store/expense_day",
		type: 'GET',
		dataType: "json",
		// data: {"action": "check", "lastId": lastId, "idArr": idArr},
		// отправляем данные на сервер
		data: {"action": "check", "idArr": idArr},
		// функция обработки ответа сервера
		error: function (data) {
			alert('Произошла ошибка!');
			alert(JSON.stringify(data));
		},
		// в случае "положительного"" ответа обрабатываем данные
		success: function (data) {
			// alert(JSON.stringify(data));
			// alert(JSON.stringify(data.delRows));
			// alert(JSON.stringify(data.newRows));
			// alert(JSON.stringify(data.newData));

			// цикл по строкам, которые надо вставить в таблицу
			$.each(data.newData, function (key, val) {
				// console.log('новая строка для вставки');
				// клонируем любую строку строку, например первую
				var row = $('.doc_data>tbody>tr').first().clone();
				// назначить действия кнопкам

				row.removeClass('delRow');
				// прячем её, пока не вставим данные
				row.hide();
				// добвляем строку в конец таблицы
				$('.doc_data tbody').append(row);
				// заполняем первую колонку номером по порядку
				row.find('.npp').text($('.doc_data tr').size());
				// вставляем id строки из БД
				row.attr('doc_id', key);
				row.addClass('newRow');

				var td = row.find('td');
				// цикл по ячекйкам - вносим данные, пришедшие с сервера
				for (var i = 1; i < 6; i++) {
					td.eq(i).text(val[i]);
				}
				;
				// row.find('button.del').click() = $('button.del').click();
				// медленно выплываем строку
				row.fadeIn(1000);
				//row.animate({ backgroundColor: "#ffffff" }, 400);

			});

			if (data.delRows != null) {
				$.each(data.delRows, function (index, val) {
					// alert(val);
					$("[doc_id = " + val + "]").addClass('delRow');
				});
			}
		}


		//}
	})

	timeout_id = window.setTimeout(checkNewData, 60000);
}

// $(".newRow").animate({
// 			backgroundColor: #fff
//       }, 8500);               // анимация будет происходить 1,5 секунды
