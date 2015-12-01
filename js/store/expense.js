var _id_ttn = -1;
var _vat = parseFloat(localStorage["metan.nds"]);
var _razreshil = (localStorage["metan.razreshil"]);

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
	$('#new_goods_table tbody tr:last .vat').val(_vat);
	//$('#expence_id_operation').focus();
	$('[name="expence[doc_date]"]').focus();
	$('#expence_id_operation').click(function (event) {
		$('#for').focus();
		event.stopPropagation();
	});
	$('#for').click(function (event) {
		$('[name*=doc_date]').focus();
		event.stopPropagation();
	});
	$('#expence_id_operation').keypress(function (event) {
		if (event.keyCode == 13) {
			$('[name*=doc_date]').focus();
			event.stopPropagation();
		}
	});
	$('input').keypress(function (event) {
		if (event.keyCode == 13) {
			console.log('next input1');
			//console.log($('input:visible').index(this));
			if ( $('input:visible').eq($('input:visible').index(this) + 1).attr('name') == 'id_goods') {
				$('input:visible').eq($('input:visible').index(this) + 2).focus();
			} else {
				if ($('input:visible').size() > $('input:visible').index(this) + 1) {
					$('input:visible').eq($('input:visible').index(this) + 1).focus();
				} else {
					//$('input:visible, button:visible').eq($('input:visible, button:visible').index(this) + 1).focus();
					$('.ui-dialog-buttonpane button').eq(1).focus();
				}
			}



			event.stopPropagation();
		}

	});


	//$(document).keydown(function (event) {
	//	if (event.ctrlKey && event.keyCode==80) {
	//		console.log('print');
	//		event.stopPropagation();
	//		return false;
	//	}
	//});

	$('button').keydown(function (event) {
		if (event.keyCode == 39) {
			$(this).next('button').focus();
		}
		if (event.keyCode == 37) {
			$(this).prev('button').focus();
		}
		if (event.keyCode == 38) {
			$('.goods_name').last().focus();
		}
		event.stopPropagation();
	});

	/*-------------------  Потребитель -----------------------------------------------*/
	if ($('#contact_name').size() !=0 ) {
		$('#contact_name').autocomplete({
			source: function (request, response) {
				//response функция для обработки ответа
				//alert(request.term); // - строка поиска;
				$.ajax({
					url: 'http://' + document.location.host + rootFolder + "/MainAjax/GetContactName",
					type: 'GET',
					dataType: "json",
					data: 'term=' + request.term + '&f=name',
					success: function (data) {
						//alert((data));
						response(
							$.map(data, function (item) {
								return {
									value: item.name,
									label: '[' + item.id + '] ' + item.name,
									id: item.id
								}
							})
						);
					}
				});
			},
			minLength: 4,
			select: function (event, ui) {
				//     // вставить id в тег cid
				$('#contact_name').attr('cid', (ui.item.id * 1));
				$('#contact_name').removeClass('err');
			}
		});		// end contact_name.autocomplete
	}

	//$('#contact_name').focus();
	if ($('#contact_name').size() !=0 ) {
		$('#contact_name').keyup(function (event) {
			if (event.keyCode == 118) {
				// alert('Поиск');
				search_data1 = {
					capt: "Поиск клиента",
					action: "GetContactName",
					fields: ["name", "unn"],
					field: 'name',
					key: "id",
					width: 800,
					sender: 'contact_name',
				};
				sForm = new searchForm();
				// search_data1.sender = $(this).parent().parent().attr('id');
				sForm.create(search_data1);

			}
			//if (event.keyCode==13) {
			//    //console.log('enter');
			//    // поставить курсор в таблицу
			//    $('.id_goods').first().focus();
			//}
		});
	}
	/*--------------------------------------------------------------------*/
	$('#add_new_contact').click(function () {
		// сбор данных для передачи
		var data = {};
		reg = /\[(.*)\]/;
		$('[name*=new_contact]').each(function(i){
			data[$(this).attr('name').match(reg)[1]] = $(this).val();
		});
		console.log(data);

		$.ajax({
			url: 'http://'+document.location.host+rootFolder+"/store/invoice",
			type:'POST',
			dataType: "json",
			data: {new_contact: data},
			// функция обработки ответа сервера
			error: function(data) {
				console.log('New_contact error: '+data);
				alert('Во время сохранения произошла ошибка. Проверьте введённые данные!');
				//$('#overlay').hide();
				//$('#loadImg').hide();
			},
			success: function(data){
				console.log(data);
				if (data.status == 'ok') {
					$('#contact_name').attr('cid', data.id);
					$('#contact_name').val($('[name="new_contact[name]"]').val());
					$('#overlay').hide();
					$('#loadImg').hide();
					$('#contact_name').removeClass('err');
					$('.new_contact').fadeOut(200);
					$('#contact_name').focus();
				} else {
					alert('Возникла ошибка при сохранении. Проверте введённые данные.');
				}
			}
		})
	});
	/*----------------------------------------------------------------------*/
	$('.edit_contact').click(function (event) {
		event.stopPropagation();
		// alert('изменитьпотребитель');
		if ($('#contact_name').attr('cid')=='') {
			alert('Не выбран потребитель!');
			$('#contact_name').focus();
		} else {
			$('#overlay').show() //fadeIn(50); ;
			//$('[name="new_contact[id]"]').removeAttr('disabled');
			$('[name="new_contact[id]"]').attr('disabled', 'disabled');
			$('[name="new_contact[id]"]').val($('#contact_name').attr('cid'));
			$('[name="new_contact[name]"]').focus();

			// заполнить поля из БД
			$.ajax({
				url: 'http://' + document.location.host + rootFolder+"/MainAjax/GetContact",
				type: 'GET',
				dataType: "json",
				data: 'id='+$('#contact_name').attr('cid'),
				success: function (data) {
					console.log(data);
					$.each(data, function(key,val){
						//console.log(key+'-'+val);
						$('[name="new_contact['+key+']"]').val(val);
					});
				}
			});


			$('.new_contact').show(); //fadeIn(100); //show();
			$('.new_contact .caption').text('Редактировать потребителя');
		}
	});
	/*---------------------------------------------*/
	$('.add_contact').click(function () {
		//alert('новый потребитель');
		$('#overlay').show() //fadeIn(50); ;
		$('.new_contact').show(); //fadeIn(100); //show();
		$('[name="new_contact[id]"]').val('-1');
		$('[name="new_contact[id]"]').attr('disabled','disabled');
		$('[name="new_contact[name]"]').focus();
		$('.new_contact .caption').text('Добавить нового потребителя');
	});
	/*---------------------------------------------*/
	$('#cancel_new_contact, #close_form').click(function () {
		$('#overlay').fadeOut(100); //hide();
		$('.new_contact').fadeOut(100); //hide();
	});

	/*---------------------------------------------------------------------*/

	// спрятать форму нового потребителя по клику в не формы
	$(document).click(function (event) {
		if ($(event.target).closest('.new_contact, .add_contact').length) return;
		$('.new_contact').hide();
		$('#overlay').hide();
		event.stopPropagation();
	});


	/*------------------------------- конец потребителя ---------------*/
	// alert('epence.js')

	// var array = {'goods_arr':''};
	// array['goods_arr'] = {'quantity':'10', 'price':'35678'};
	// alert(JSON.stringify(array));
	// for (var key in array){
	//		alert(key);
	//		alert(array[key]);
	//}


	// $('.search.goods_name').keyup(function(event){
	// 	if (event.keyCode==118) {
	// 	 	//alert('Поиск');
	// 	 	sForm = new searchForm();
	// 	 	sForm.create({
	// 	 		capt: "Поиск для расхода",
	// 	 		table: "goods",
	// 	 		field: "name",
	// 	 		key: "id",
	// 	 		width: 800,
	// 	 		sender: $(this).parent().parent().attr('id'),
	// 	 	});
	// 	}
	// })


	/*-------------------Редактирование расхода----------------------------------------------*/
	/*-------------------Удаление строки из текущего документа-------------------------------*/
	//$(document).keypress(function(event){
	//	if (event.keyCode==127 && !$(this).is(':input')) {
	//		//alert(event.keyCode);
	//		var del_list = $('.child_row.visible .selected');
	//		if ($(del_list).length > 0) {
	//			var str = 'Точно хотите безвозвратно удалить строки из документов: \n\n';
	//			//alert('del rows:'+$(del_list).length);
	//			$('.child_row.visible .selected').closest('.child').each(function(i, el){
	//				str += '№ ' + ($(el).find('.doc_num').text().trim());
	//				str += ' от ' + ($(el).find('.doc_date').text().trim());
	//				str += ' (' + $(el).find('.selected').length + ' стр.)' + '\n';
	//			})
	//			str += '\n(всего '+$(del_list).length+' стр.)';
	//			if (confirm(str)) {
	//				alert('del');
	//			}
	//		}
	//	}
	//})

	/*-------------------  редактирование документа-----------------------------------------------*/
	$('.edit_doc_button').click(function (event) {
		//alert('edit');
		//event.preventDefault();
		// очищаем форму от предыдущих данных
		clear_form();
		$('.action').removeClass('new');
		$('.action').addClass('edit');
		$('.action').text('[редактирование]');
		// загружаем данные в форму для редактирования прямо из HTML-таблицы
		tbl_src = $(this).parentsUntil('.child_row');		// выбираем таблицу с исходными данными
		tbl_dst = $('#new_goods_table tbody');				// таблица, куда вставлять данные
		//console.log($(tbl[4]).find('tbody tr'));
		// обход строк таблицы с расходом
		rows = $(tbl_src[4]).find('tbody tr');
		rows.each(function (j, el) {
			td_dst = tbl_dst.find('.new_goods_row').last().find('td');
			cells_src = $(el).find('td');
			// console.log(cells_src);
			// обход колонок (кроме первой и последней - они нам не нужны)
			cells_src.each(function (i, el) {
				if (i != 0 && i < cells_src.size() - 1) {
					if($(el).attr('field')=='cost' || $(el).attr('field')=='markup') {
						td_dst.find('.price').attr($(el).attr('field'), $(el).text().trim().replace(/[\s`]/g, ""));
					}

					if (i == cells_src.size() - 2) {
						// console.log($(el).text().trim().replace(/`/g,""));
						// console.log(td_dst.eq(i));
						// удаляем лишние символы из цены
						td_dst.eq(i - 1).find('input').val($(el).text().trim().replace(/[\s`]/g, ""));
					} else {
						//console.log($(el).text());
						td_dst.eq(i - 1).find('input').val($(el).text().trim());
					}
				}
			})// end each cells



			// пересчитать суммы
			td_dst.find('.quantity').change();
			// добавить новую строку
			//if (j != 0) {
			$('#add_new_row').click();
			//}
		})// end each rows

		tbl_dst.find('.new_goods_row').last().find('.del_row').click();

		// дата документа
		date_arr = tbl_src.find('thead .doc_date').text().trim().split('.'); 	// разбиваем дату на состовляющие, чтобы поменять их местами
		// console.log(date_arr);
		// console.log(date_arr[2]+'-'+date_arr[1]+''+date_arr[0]);
		$('[name*=doc_date]').val(date_arr[2] + '-' + date_arr[1] + '-' + date_arr[0]);
		// номер документа
		$('[name*=doc_num]').val(tbl_src.find('thead .doc_num').text().trim());
		// id документа
		$('#new_goods_table').attr('doc_id', tbl_src.parent().parent().prev().attr('id'));
		// id операции
		$('[name*=id_operation]').val(tbl_src.find('thead [id_operation]').attr('id_operation'));
		// for
		$('[name=for]').val(tbl_src.find('thead [id_for]').attr('id_for'));
		// id контакта и его наименование
		$('#contact_name').attr('cid', tbl_src.find('thead [id_contact]').attr('id_contact'));
		$('#contact_name').val(tbl_src.find('thead [id_contact]').text());
		// платёжное поручение
		var hat = $(this).closest('.doc_hat');
		if (hat.attr('payment_order')!='') {
			$('.additional_data').attr('open','');
		}
		$('[name="expence[payment_order]"]').val(hat.attr('payment_order'));
		$('[name="expence[descr]"]').val(hat.attr('descr'));

		$('#cancel_expence').show();
		$('#contact_name').removeClass('err');
		$(document).scrollTop(70);
		event.stopPropagation();
	})
	/*---------------------------------------------------------------------------------------*/
	$('#cancel_expence').click(function () {
		if (confirm("Отменить все изменения?")) {
			clear_form();
			$(this).hide();
			$('#contact_name').attr('cid', '');
			$('#contact_name').val('');
			$('#new_goods_table').attr('doc_id', -1);
			$('.action').removeClass('edit');
			$('.action').addClass('new');
			$('.action').text('[добавление]');
		}
	})
	/*-------------------- Очистить форму ---------------------------------------------------*/
	$('#clear_form').click(function () {
		if (confirm("Удалить введённые, но не сохранённые данные?")) {
			clear_form();
		}

	})

	function clear_form() {
		// удалить все строки и очистить шапку
		$('#new_goods_table .new_goods_row').each(function (i, el) {
			if (i == 0) {
				$(el).find('input').val('');
				$(el).find('.summ').text('');
			} else {
				$(el).remove();
			}
			$('.itog_summ').text('0');
		})

		$('.action').removeClass('edit');
		$('.action').addClass('new');
		$('.action').text('[новый]');
		$('#new_goods_table').attr('doc_id', '-1');		// обнулить id документа в форме редактирования

		// шапку чистим
		$('[name*=doc_date]').val($('[name*=doc_date]').attr('value'));
		// номер документа
		$('[name*=doc_num]').val($('[name*=doc_num]').attr('value'));
		// id контакта и его наименование
		$('#contact_name').attr('cid', '');
		$('#contact_name').val('');

		//alert('cleared');
	}

	/*------------------- Добавить расход в БД-----------------------------------------------*/
	$('#add_expence').click(function () {
		//alert('сохранить расход');
		//alert(document.location.host);
		//alert($('[name = "expence[id_operation]"]').val());

		if ($('#contact_name').attr('cid') == '') {
			alert('Не указан потребитель!');
			$('#contact_name').focus();
			err = true;
			return false;
		}
		if ($('[name="expence[doc_num]"]').val().trim() == '') {
			alert('Не указан номер документа!');
			$('[name="expence[doc_num]"]').focus();
			err = true;
			return false;
		}

		// собираем данные в массив
		var arr = {};
		var goods_arr = {};
		var exp = {'doc': '', 'doc_data': ''};

		var id = $('.id_goods');	// массив инпутов с кодами товаров
		var quantity = $('.quantity');	// массив с количествами товаров
		var price = $('.price'); 		// массив с ценами
		var cost = $('.cost');
		var markup = $('.markup');
		var vat = $('.vat'); 		// массив с НДС

		// цикл по кодам товара
		var err = false;
		id.each(function (index, element) {
			//alert(index+' -- ["'+$(element).val() + '"] = '+ $(quantity).eq(index).val());

			// проверить остатки

			// если одно из полей пустое - выдать сообщение с вариантами: пропустить/отменить

			// создаём массив вида array('id'=>array(quantity, price))
			if ($(id).eq(index).val() != '' && $(quantity).eq(index).val() != '' && $(price).eq(index).val() != '') {
				goods_arr[$(element).val().replace(/`/g, "")] = {
					'quantity': $(quantity).eq(index).val(),
					'price': $(price).eq(index).val(),
					'cost':$(price).eq(index).attr('cost'),
					'markup':$(price).eq(index).attr('markup'),
					'vat': $(vat).eq(index).val()
				};
			} else {
				alert('не все поля заполнены!');
				err = true;
				return false;
			}

			// goods_arr[$(element).val()] = $(quantity).eq(index).val();
		});

		if (err) {
			return false;
		}

		// массив с аттрибутами документа (шапка)
		arr['doc_id'] = $('#new_goods_table').attr('doc_id');
		arr['id_operation'] = $('[name = "expence[id_operation]"]').val();
		arr['id_contact'] = $('#contact_name').attr('cid');
		arr['doc_date'] = $('[name = "expence[doc_date]"]').val();
		arr['doc_num'] = $('[name = "expence[doc_num]"]').val();
		arr['doc_for'] = $('[name = "for"]').val();
		arr['payment_order'] = $('[name="expence[payment_order]"]').val();
		arr['descr'] = $('[name="expence[descr]"]').val();
		//arr['payment_order']= false;
		// запихиваем два массива в один, который и отправится на сервер
		exp['doc'] = arr;
		exp['doc_data'] = goods_arr;
		//console(exp);

		$('#overlay').show();
		$('#loadImg').show();

		// передаём данные на сервер
		$.ajax({
			url: 'http://' + document.location.host + rootFolder + "/store/expense",
			type: 'POST',
			dataType: "json",
			data: {new_expense: exp},
			// функция обработки ответа сервера
			error: function (data) {
				alert(JSON.stringify(data) + '###');
				alert('Во время сохранения произошла ошибка. Проверьте введённые данные!');
				$('#overlay').hide();
				$('#loadImg').hide();
			},
			success: function (data) {
				console.log(data);
				if (data.status == 'ok') {
					if (data.no_rest) {
						str = '';
						$(data.no_rest.no_rest).each(function (i, e) {
							//console.log(e);
							str += '"' + e.name + '" в остатке только  ' + e.quantity + ' шт.' + "\n";
						});
						alert(data.message + "\n\n" + str);
					}
					location.reload();
				} else {
					$('#overlay').hide();
					$('#loadImg').hide();
					str = '';
					$(data.no_rest).each(function (i, e) {
						//console.log(e);
						str += '"' + e.name + '" в остатке только ' + e.quantity + ' шт.' + "\n";
					});
					alert(str);
				}

			}
		});
	});
	/*-------------------------------------------------------------------------------------*/
	$('.vat').blur(function () {
		_vat = $(this).val();
	});
	/*--------------------- Добавить новую строку для товара ------------------------------*/
	$('#add_new_row').click(function () {
		//	добавить пустую строку для нового товара в расходе
		// клонируем последнюю строку таблицы и вставляем её в конец таблицы
		$('#new_goods_table tbody tr:last').clone().appendTo('#new_goods_table');
		// получаем тлько что вставленную строку
		var tr = $('#new_goods_table tbody tr:last');
		// вычисляем её id+1
		var id = 'row_' + (tr.attr('id').substr(4) * 1 + 1);
		// меняем id  в последней строке
		tr.attr('id', id);
		// очищаем <input'ы>
		$('#new_goods_table tbody tr:last :input').val('');
		$('#new_goods_table tbody tr:last .summ').text('');
		$('#new_goods_table tbody tr:last .vat').val(_vat);
		$('#new_goods_table tbody tr:last .goods_name').focus();
		// назначаем обработку событий новой строке
		set_autocomplete('#' + id);
	})
	/*-------------------------------------------------------*/
// 	$('datalist option').click(function(){
// 		alert('qqq');
// 	})
// /*-------------------------------------------------------*/
// 	//var datalist = document.getElementById ("id_goods_list");
//     var input = document.getElementById ("id_goods_list");
//  	input.addEventListener ("click", function (event) {
//         //if (event.which === 13) {
//             alert('sdf'); // Example
//         //}
//     }, false);
	/*-------------------------------------------------------*/
// печать накладной
	$('.print_doc_button').click(function (event) {
		var id = $(this).parent().attr('doc_id');
		event.stopPropagation();    // что бы не обрабатывался onclick нижележащего элемента
		//alert('print invoice  '+$('#doc_hat_'+id+' .doc_num').text());
		var id_contact = $(this).parent().parent().find('[id_contact]').attr('id_contact');

		if ($('.doc_title').text().indexOf('Счёт-фактура') + 1) {
			window.open(rootFolder + '/print/index?report=Invoice&id=' + id, '_blank');
		}
		if ($('.doc_title').text().indexOf('Кредит') + 1) {
			console.log('print kredit');
		}
		if ($('.doc_title').text().indexOf('Накладные') + 1) {
			//window.open(rootFolder + '/print/index?report=Deliverynote&id=' + id, '_blank')
			_id_doc = id;


			// заполнить данными форму
			cont = getContactData(id_contact);
			// 0. Основание
			$('#form_ttn_osnovanie').val('п/п '+$(this).closest('.doc_hat').attr('payment_order')+', '+cont.agreement);
			// 1. адрес загрузки - взять из справочника contact по id покупателя
			//$('#form_ttn_addr1').val(cont.addr);
			// 2. Пункт разгрузки
			$('#form_ttn_p_razgruz').val(cont.addr);
			// 3. Влделец транспорта - наименование покупателя
			$('#form_ttn_vladelec').val(cont.name);
			// 4. Заказчик перевозки - наименование покупателя
			$('#form_ttn_zakazchik').val(cont.name);

			//$('#f_ttnForm_otpusk').val(_razreshil);
			// показать
			//$('#ttn').click();

			$("#prepareTTN").dialog("open");
		}

	});

	/*-------------------------------------------------------*/
	set_autocomplete('#row_1');
});		//$ end (document).ready( function(){

/*--------------------------------------------------------------------------------------------------------------*/
/*--------------------------------------------------------------------------------------------------------------*/
/*-------------------- Автодополнение для кода товара ---------------------------------------------------------*/
function set_autocomplete(id) {
	//alert(id);
	$(id + " .id_goods").autocomplete({
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
								//label: '[' + item.id + '] ' + item.name.pad(50) + '  (' + item.rest + ' шт по ' + item.price + 'р.)',
								label: '' + String(item.id).pad(10) + ' ' + item.name.pad(50) + ' ' + item.rest.pad(6,' ',0) + ' ' + String(item.price).replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1`').pad(11,' ',0),		// это поле отобразится в выпадающем списке
								name: item.name,
								cost: item.cost,
								markup: item.markup,
								vat: item.vat,
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
				url: 'http://' + document.location.host + rootFolder + "/MainAjax/GetGoodsNameFromRest",
				type: 'GET',
				dataType: "json",
				data: 'term=' + request.term + '&f=gname', /*параметры для поиска: term - искомая строка, f - по какому полю искать*/
				success: function (data) {
					//alert((data));
					// формируем массив из найденых в БД строк
					response(
						$.map(data, function (item) {	// пробегаем по каждой строке результата
							//console.log('>'+item.name.pad(40)+'<');
							return { 	// формируем массив нужной структуры
								id: item.id,	// это поле для вставки в соседний <input> (код товара)
								value: item.name + '   (' + item.rest + ' шт)',	// это поле вставится в <input>
								label: '' + String(item.id).pad(10) + ' ' + item.name.pad(50) + ' ' + item.rest.pad(6,' ',0) +('('+item.inv+')').pad(5,' ',0) +' ' + String(item.price).replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1`').pad(11,' ',0),		// это поле отобразится в выпадающем списке
								cost: item.cost,
								markup: item.markup,
								vat: item.vat,
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
			//console.log('www');
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

function saveInputcache(params){
	//alert(params);

	$.ajax({
		url: 'http://'+document.location.host+rootFolder+"/MainAjax/saveinputcache",
		type:'GET',
		dataType: "json",
		data:  params,
		// функция обработки ответа сервера
		error: function(data) {
			console.log('saveinputcache error: '+data);
			alert('Во время сохранения произошла ошибка. Проверьте введённые данные!');
			//$('#overlay').hide();
			//$('#loadImg').hide();
		},
		success: function(data){
			console.log(data);
			if (data.status == 'ok') {
				//$('#overlay').hide();
				//$('#loadImg').hide();
				//$('#contact_name').removeClass('err');
				//$('.new_contact').fadeOut(200);
				//$('#contact_name').focus();
			} else {
				//alert('Возникла ошибка при сохранении. Проверте введённые данные.');
			}
		}
	})

};

function print_ttn(id, type, params) {
	console.log(arguments);

	var orient = {'ttn':'L', 'tn':'P'};
	window.open(rootFolder + '/print/index?report=Deliverynote&orient='+orient[type]+'&format=pdf&type='+type+'&id='+_id_doc+'&'+params+'&m[]=20&m[]=15&m[]=5&m[]=5&m[]=0&m[]=0', '_blank');

	return false;
}

function getContactData(id) {
	var res=null;
	$.ajax({
		url: 'http://' + document.location.host + rootFolder + "/MainAjax/GetContact",
		type: 'GET',
		async: false,
		dataType: "json",
		data: 'id='+id,
		// функция обработки ответа сервера
		error: function (data) {
			console.log('err:'+data);
		},
		success: function (data) {
			console.log(data);
			var tmp = '';
			if (data.agreement != null) {
				tmp = data.agreement;
			}
			res={
				"addr": data.address,
				"name":data.name,
				"agreement":tmp
			}
		}
	});

	return res;
}