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

	$('.vat').val(_vat);
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
				if (event.shiftKey || event.ctrlKey) {
					return false;
				}
				console.log('insert');
				$('#add_new_row').click();
				break;
			case 0:
				console.log('0');
				break;
			//case 0:
			//	console.log('0');
			//	break;
			default:
				console.log('keyUp: ' + event.keyCode);
		}
	});



	/*---------------------------------------------------------------------------------------*/
	$('div.search_invoice input').keypress(function (event) {
		event.stopPropagation();
		if (event.keyCode == 13) {
			console.log('serch invoice '+$(this).val());
		}
	});

	/*------------------- Добавить расход в БД-----------------------------------------------*/

	$('#add_invoice').click(function () {

		//test localstorage
		localStorage["metan.nds"] = $('.vat:last').val();
		/*-------*/

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
		var cost = $('.cost');
		var markup = $('.markup');
		var vat = $('.vat'); 		// массив с НДС

		// цикл по кодам товара
		var err = false;
		id.each(function (index, element) {
			//alert(index+' -- ["'+$(element).val() + '"] = '+ $(quantity).eq(index).val());

			// если одно из полей пустое - выдать сообщение с вариантами: пропустить/отменить


			// создаём массив вида array('id'=>array(quantity, price))
			if ($(id).eq(index).val() != '' && $(quantity).eq(index).val() != '' && $(price).eq(index).val() != '' && $(vat).eq(index).val() != '') {
				goods_arr[$(element).val().replace(/`/g,"")] = {
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
		arr['id_contact'] = $('#contact_name').attr('cid');
		arr['doc_date'] = $('[name = "invoice[doc_date]"]').val();
		arr['doc_num'] = $('[name = "invoice[doc_num]"]').val();

		// запихиваем два массива в один, который и отправится на сервер
		exp['doc'] = arr;
		exp['doc_data'] = goods_arr;
		// alert(JSON.stringify(exp));

		$('#loadImg').show();
		$('#overlay').show();

		console.log({new_invoice: exp});
		//return;
		// передаём данные на сервер
		$.ajax({
			url: 'http://' + document.location.host + rootFolder+"/store/invoice",
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

		// вывод на печать накладной (если есть)
	$('.ttn_doc_button').click(function (event) {
		var id = $(this).attr('link');
		_id_doc = id;
		console.log("печать ттн из счёта фактуры: "+id);
		$("#prepareTTN").dialog("open");
		//$('#ttn').click();
		//$('#wr_off').click();
		//$('#form_writeoff_nttn').val($(this).parent().parent().find('.doc_num').text().trim());
		//console.log($('#form_writeoff_date_ttn').val());

		event.stopPropagation();	// что бы не обрабатывался onclick нижележащего элемента
	})

		// списание в расход счёта фактуры
	$('.write_off_doc_button').click(function (event) {
		console.log('списать ');
		var id = $(this).parent().attr('doc_id');
		_id_doc = id;

		$('#wr_off').click();
		$('#form_writeoff_nttn').val($(this).parent().parent().find('.doc_num').text().trim());
		console.log($('#form_writeoff_date_ttn').val());

		event.stopPropagation();	// что бы не обрабатывался onclick нижележащего элемента
	})

		// печать счёт-фактуры
	//$('.print_doc_button').click(function (event) {
	//	event.stopPropagation();    // что бы не обрабатывался onclick нижележащего элемента
	//	// alert('print invoice  '+$('#doc_hat_'+id+' .doc_num').text());
	//	var id = $(this).parent().attr('doc_id');
	//	window.open(rootFolder+'/print/index?report=Invoice&id=' + id, '_blank')
	//})
})

function writeoff(id, nttn, date_ttn, n_pl, for_) {
	console.log(arguments);

	/* проверить содержимое переменных
	var nakl_num = prompt('Введите номер накладной', '');
	if (nakl_num==null) {
		return false;
	}
	if (nakl_num=='') {
		alert('Неправильный номер накладной');
		return false;
	}
	var payment_order = prompt('Введите платёжное поручение', '');
	if (payment_order==null) {
		return false;
	}*/

	$.ajax({
		url: 'http://' + document.location.host + rootFolder+"/store/invoice",
		type: 'POST',
		dataType: "json",
		data: {writeoff_invoice: {'doc_id':id, 'nakl_num':nttn, 'nakl_date': date_ttn,'payment_order': n_pl, 'for_': for_}},
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
				//if (data.nakl_id < 0) {
				alert(data.message);
				if (data.no_rest) {
					str = '';
					$(data.no_rest.no_rest).each(function (i,e) {
						//console.log(e);
						str += '"'+e.name +'" в остатке только  ' + e.quantity + ' шт.'+"\n";
					});
					alert(data.message+"\n\n"+str);
				}
				if (data.nakl_id<0) {
					//  накладная не была создана
				} else {
					$("#prepareWriteoff").dialog("close");
						// если нету - добавить кнопку ttn_doc_button
					if ($('[doc_id="'+id+'"]').find('.ttn_doc_button').size() == 0) {
						$btn = $('<button class="ttn_doc_button" link="'+data.nakl_id+'"></button>').insertAfter($('[doc_id="'+id+'"] .write_off_doc_button'))
						$btn.click(function (event) {
							var id = $(this).attr('link');
							_id_doc = id;
							console.log(id+'--');
							//$('.ttn_doc_button').click();
							event.stopPropagation();	// что бы не обрабатывался onclick нижележащего элемента
						})
					}
						// присвоить кнопке arrt(link)
					console.log(id);

					$('[doc_id="'+id+'"]').find('.ttn_doc_button').attr('link', data.nakl_id);

							// запросить печать накладной
					//if (confirm("Печатать накладную?")) {
					//	console.log('печать накладной '+data.nakl_id);
					//	_id_doc = data.nakl_id;
					//	$('.ttn_doc_button').click();
					//}
				}
				//} else {
				//	alert(data.message);
				//}

			} else {
				if (data.no_rest) {
					str = '';
					$(data.no_rest).each(function (i,e) {
						//console.log(e);
						str += '"'+e.name +'" в остатке только  ' + e.quantity + ' шт.'+"\n";
					});
					alert(str);

					//alert('Во время сохранения произошла ошибка. Напрягайте программиста!\n\r');
				} else {
					alert('Во время сохранения произошла ошибка. Напрягайте программиста!\n\r');
				}
			}
			$('#overlay').hide();
			$('#loadImg').hide();
		}
	});


}