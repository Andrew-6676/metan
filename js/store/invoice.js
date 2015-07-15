var search_data = {
	capt: "Поиск для счёт-фактуры",
	action: "GetGoodsNameFromRest",
	fields: ["name", "rest", "price"],
	field: 'gname',
	key: "id",
	width: 800,
	sender: null,
};
/*-----------------------------------------------------------*/

$(document).ready(function () {

	//$(".new_contact").draggable({
	//		    cursor: "move",
	//		    // distance: 10,
	//		   	//revert: true,
	//		   	//revertDuration: 3000
	//		});

	//$('.new_doc_hat input').keyup(function (event) {
	//	if (event.keyCode == 13) {
	//		console.log('next input');
	//		//console.log($('input:visible').index(this));
	//		$('input:visible').eq($('input:visible').index(this)+1).focus();
	//		event.stopPropagation();
	//	}
	//
	//});

		// не заполнен потребитель
	$('#contact_name').blur(function () {
		if ($(this).attr('cid')=='') {
			$(this).addClass('err');
		} else {
			$(this).removeClass('err');

		}
	});
	
	$(document).keyup(function (event) {
		switch (event.keyCode) {
			case 45:    // INS
				console.log('insert');
				$('#add_new_row').click();
				break;
			case 0:
				console.log('0');
				break;
			case 0:
				console.log('0');
				break;
			default:
				console.log('keyUp: ' + event.keyCode);
		}
	});


	$('#contact_name').focus();
	$('#contact_name').keyup(function (event) {
		if (event.keyCode == 118) {
			// alert('Поиск');
			search_data1 = {
				capt: "Поиск клиента",
				action: "GetContactName",
				fields: ["name"],
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
			url: 'http://'+document.location.host+"/metan_0.1/store/invoice",
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
				}
			}
		})
	});
	/*----------------------------------------------------------------------*/
	$('.edit_contact').click(function () {
		// alert('изменитьпотребитель');
		event.stopPropagation();
		$('#overlay').show() //fadeIn(50); ;
		//$('[name="new_contact[id]"]').removeAttr('disabled');
		$('[name="new_contact[id]"]').attr('disabled','disabled');
		$('[name="new_contact[id]"]').val($('#contact_name').attr('cid'));
		$('[name="new_contact[name]"]').focus();
		$('.new_contact').show(); //fadeIn(100); //show();
		$('.new_contact .caption').text('Редактировать потребителя');
	});
	$('.add_contact').click(function () {
		//alert('новый потребитель');
		$('#overlay').show() //fadeIn(50); ;
		$('.new_contact').show(); //fadeIn(100); //show();
		$('[name="new_contact[id]"]').val('-1');
		$('[name="new_contact[id]"]').attr('disabled','disabled');
		$('[name="new_contact[name]"]').focus();
		$('.new_contact .caption').text('Добавить нового потребителя');
	});

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

	/*------------------- Добавить расход в БД-----------------------------------------------*/

	$('#contact_name').autocomplete({
		source: function (request, response) {
			//response функция для обработки ответа
			//alert(request.term); // - строка поиска;
			$.ajax({
				url: 'http://' + document.location.host + "/metan_0.1/MainAjax/GetContactName",
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
	});		// end $(id+" .id_goods" ).autocomplete

	/*------------------- Добавить расход в БД-----------------------------------------------*/

	$('#add_invoice').click(function () {

		if ($('#contact_name').attr('cid') == '') {
			alert('Не указан потребитель!');
			$('#contact_name').focus();
			err = true;
			return false;
		}

		//alert('сохранить расход');
		//alert(document.location.host);
		//alert($('[name = "expence[id_operation]"]').val());
		// собираем данные в массив
		var arr = {};
		var goods_arr = {};
		var exp = {'doc': '', 'doc_data': ''};

		var id = $('.id_goods');	// массив инпутов с кодами товаров
		var quantity = $('.quantity');	// массив с количествами товаров
		var price = $('.price'); 		// массив с ценами
		var vat = $('.vat'); 		// массив с НДС

		// цикл по кодам товара
		var err = false;
		id.each(function (index, element) {
			//alert(index+' -- ["'+$(element).val() + '"] = '+ $(quantity).eq(index).val());

			// если одно из полей пустое - выдать сообщение с вариантами: пропустить/отменить

			// создаём массив вида array('id'=>array(quantity, price))
			if ($(id).eq(index).val() != '' && $(quantity).eq(index).val() != '' && $(price).eq(index).val() != '' && $(vat).eq(index).val() != '') {
				goods_arr[$(element).val()] = {
					'quantity': $(quantity).eq(index).val(),
					'price': $(price).eq(index).val(),
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
		arr['id_contact'] = $('#contact_name').attr('cid');
		arr['doc_date'] = $('[name = "invoice[doc_date]"]').val();
		arr['doc_num'] = $('[name = "invoice[doc_num]"]').val();

		// запихиваем два массива в один, который и отправится на сервер
		exp['doc'] = arr;
		exp['doc_data'] = goods_arr;
		// alert(JSON.stringify(exp));

		$('#loadImg').show();
		$('#overlay').show();

		// передаём данные на сервер
		$.ajax({
			url: 'http://' + document.location.host + "/metan_0.1/store/invoice",
			type: 'POST',
			dataType: "json",
			data: {new_invoice: exp},
			// функция обработки ответа сервера
			error: function (data) {
				alert(JSON.stringify(data) + '###');
				alert('Во время сохранения произошла ошибка. Проверьте введённые данные!');
				$('#overlay').hide();
				$('#loadImg').hide();
			},
			success: function (data) {
				//alert(JSON.stringify(data));
				//	var res = eval(data);
				//alert(data.status+'---');
				//alert(typeof data);
				if (data.status == 'ok') {
					location.reload();
				} else {
					alert('Во время сохранения произошла ошибка. Проверьте введённые данные!\n\r' + JSON.stringify(data));
					$('#overlay').hide();
					$('#loadImg').hide();
				}

			}
		});
	})		// end $('#add_invoice').click
	/*-------------------------------------------------------------------------------------*/

	// $('.edit_invoice_button').click(function(event) {
	// 	alert('Редактировать счёт-фактуру ');
	// 	event.stopPropagation();	// что бы не обрабатывался onclick нижележащего элемента
	// })

	// списание в расход счёта фактуры
	$('.write_off_button').click(function (event) {
		//console.log('списать ');
		var nakl_num = prompt('Введите номер накладной', '');
		if (nakl_num==null) {
			return false;
		}
		if (nakl_num=='') {
			alert('Неправильный номер накладной');
			return false;
		}
		$.ajax({
			url: 'http://' + document.location.host + "/metan_0.1/store/invoice",
			type: 'POST',
			dataType: "json",
			data: {writeoff_invoice: {'doc_id':$(this).parent().attr('doc_id'), 'nakl_num':nakl_num}},
			// функция обработки ответа сервера
			error: function (data) {
				console.log(data);
				//alert(JSON.stringify(data) + '###');
				alert('Во время списания произошла ошибка. Напрягайте программиста!');
				$('#overlay').hide();
				$('#loadImg').hide();
			},
			success: function (data) {
				console.log(data);
				if (data.status == 'ok') {
					if (data.nakl_id < 0) {
						alert(data.message);
					} else {
						alert(data.message);
					}
				} else {
					alert('Во время сохранения произошла ошибка. Напрягайте программиста!\n\r');
					$('#overlay').hide();
					$('#loadImg').hide();
				}

			}
		});
		event.stopPropagation();	// что бы не обрабатывался onclick нижележащего элемента
	})
	// печать счёт-фактуры
	$('.print_doc_button').click(function (event) {
		var id = $(this).parent().attr('doc_id');
		// alert('print invoice  '+$('#doc_hat_'+id+' .doc_num').text());
		window.open('/metan_0.1/print/index?report=Invoice&id=' + id, '_blank')
		event.stopPropagation();    // что бы не обрабатывался onclick нижележащего элемента
	})
})