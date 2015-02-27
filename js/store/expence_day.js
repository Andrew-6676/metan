var search_data = {
				capt: "Поиск для расхода",
				table: "goods",
				field: "gname",
				key: "id",
				width: 800,
				sender: null,
			};
/*--------------------------------------------------*/
$(document).ready( function(){

	/*-----------------------------------------------------*/
	$('#expence_id_operation').click(function(){
		$('.id_goods').focus();
	})
	$('#expence_id_operation').keypress(function(){
		if (event.keyCode==13) {
			$('.id_goods').focus();
		}
	})
	/*-----------------------------------------------------*/
	$('input').keypress(function(event){
		if (event.keyCode==13 && !$(this).is(':button')) {
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
	$('.quantity, .price').change(function(){

		 // alert('ch q');
		var tr = $(this).closest('tr');
		var pr = tr.find('.price').val();
		var qt = tr.find('.quantity').val();
		if (pr != '' || pr != 0) {
			tr.find('.summ').text(formatNum(pr*qt));
		} else {
			tr.find('.summ').text('');
		};

		var itog_summ = 0;

		$('.summ').each(function(i,e) {
			itog_summ += $(e).text().replace(/\s+/g, '')*1;
		})
		$('.itog_summ').text(formatNum(itog_summ));
	})

	/*-------------Поиск по F7------------------------------*/
	$('.search.goods_name').keyup(function(event){
		if (event.keyCode==118) {
			//alert('Поиск');
			sForm = new searchForm();
			search_data.sender = $(this).parent().parent().attr('id');
			sForm.create(search_data);
		}
	})
	/*------------ Ctrl + Enter ------------------------------------------------*/
	$('input').keyup(function(event){
		//alert(event.ctrlKey);
		//alert(event.keyCode);
		if (event.ctrlKey && event.keyCode==13) {
			//$(this).parent().parent().next().find .focus();
			$('#add_expence').click();
			event.stopPropagation();
			//alert('Ctrl+enter');
		}
	})

	/*--------------------- Автодополнение -------------------------------------------*/
	$(".id_goods" ).autocomplete({
		source: function(request, response){
			//response функция для обработки ответа
			//alert(request.term); // - строка поиска;
			$.ajax({
				url: 'http://'+document.location.host+"/metan_0.1/MainAjax/GetGoodsNameFromRest",
				type:'GET',
				dataType: "json",
				data: 'term='+request.term+'&f=gid',
				success: function(data){
					//alert((data));
					response(
						$.map(data, function(item){
							return{
								value: item.id,
								label: '['+item.id+'] '+item.name  + '  ('+item.rest+' шт по '+item.price+'р.)',
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
		select: function(event, ui) {
			// ui.item будет содержать выбранный элемент
			//alert(ui.item.name);
			//alert($(this).parent('td').parent('tr').attr('id').substr(4));
			var row = $(this).parent('td').parent('tr').attr('id').substr(4);
			$('#row_'+row+' .goods_name').val(ui.item.name+'   ('+ui.item.rest+' шт)');
			$('#row_'+row+' .quantity').focus();
				// вставить цену товара в <input>
				//alert(ui.item.price*1);
			$('#row_'+row+' .price').val((ui.item.price*1));
		}
	});     // end $(".id_goods" ).autocomplete
	/*----------------------------------------------------------------------------------------*/
	$(".goods_name" ).autocomplete({
		source: function(request, response){
			//response функция для обработки ответа
			//request.term - строка поиска;
			$.ajax({
				url: 'http://'+document.location.host+"/metan_0.1/MainAjax/GetGoodsNameFromRest",
				type:'GET',
				dataType: "json",
				data: 'term='+request.term+'&f=gname', /*параметры для поиска: term - искомая строка, f - по какому полю искать*/
				success: function(data){
					//alert((data));
						// формируем массив из найденых в БД строк
					response(
						$.map(data, function(item){ // пробегаем по каждой строке результата
							return{     // формируем массив нужной структуры
								id: item.id,    // это поле для вставки в соседний <input> (код товара)
								value: item.name + '    ('+item.rest+' шт)',    // это поле вставится в <input>
								label: '['+item.id+'] '+item.name + '    ('+item.rest+' шт по '+item.price+'р.)',       // это поле отобразится в выпадающем списке
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
		select: function(event, ui) {
			/*ui.item будет содержать выбранный элемент*/
				// определяем id текущей строки таблицы
			var row = $(this).parent('td').parent('tr').attr('id').substr(4);
				// вставить код товара в <input>
			$('#row_'+row+' .id_goods').val(ui.item.id);
				// вставить цену товара в <input>
			$('#row_'+row+' .price').val(ui.item.price);
				// поставить курсор в <input> количество
			$('#row_'+row+' .quantity').focus();
		}
	});     // end $(id+" .goods_name" ).autocomplete
	/*---------------- Сохранить расход -------------------------------------------*/
	$('#add_expence').click(function(){
	   // alert('сохранить расход');
		//alert(document.location.host);
		//alert($('[name = "expence[id_operation]"]').val());
			// собираем данные в массив


		 var arr = {};
		 var goods_arr = {};
		 var exp = {'doc':'', 'doc_data':''};

		 var id      = $('.id_goods');   // массив инпутов с кодами товаров
		 var quantity= $('.quantity');   // массив с количествами товаров
		 var price   = $('.price');      // массив с ценами
			 // цикл по кодам товара
		 var err = false;
		 id.each(function(index, element){
			//alert(index+' -- ["'+$(element).val() + '"] = '+ $(quantity).eq(index).val());

				// если одно из полей пустое - выдать сообщение с вариантами: пропустить/отменить

				// создаём массив вида array('id'=>array(quantity, price))
			if ($(id).eq(index).val() != '' && $(quantity).eq(index).val() != '' && $(price).eq(index).val() !='') {
				goods_arr[$(element).val()] = {'quantity':$(quantity).eq(index).val(), 'price':$(price).eq(index).val()};
			} else {
				alert('не все поля заполнены!');
				err =  true;
				return false;
			}

			// goods_arr[$(element).val()] = $(quantity).eq(index).val();
		});

		if (err) {return false;}

	//         // массив с аттрибутами документа (шапка)
		 arr['doc_id']       = $('#new_goods_table').attr('doc_id');
		 arr['id_operation'] = $('[name = "expence[id_operation]"]').val();
		 arr['doc_date']     = $('[name = "expence[doc_date]"]').val();
		 arr['doc_num']      = $('[name = "expence[doc_num]"]').val();

	//         // запихиваем два массива в один, который и отправится на сервер
		 exp['doc'] = arr;
		 exp['doc_data'] = goods_arr;
		 // alert(JSON.stringify(exp));

		$('#overlay').show();
		$('#loadImg').show();

	//         // передаём данные на сервер
		$.ajax({
				url: 'http://'+document.location.host+"/metan_0.1/store/expense",
				type:'POST',
				dataType: "json",
				data: {new_expense: exp},
					// функция обработки ответа сервера
				error: function(data) {
					alert(JSON.stringify(data)+'###');
					alert('Во время сохранения произошла ошибка. Проверьте введённые данные!');
					$('#overlay').hide();
					$('#loadImg').hide();
				},
				success: function(data){
				//  alert(JSON.stringify(data));
				//  var res = eval(data);
					//alert(data.status+'---');
					//alert(typeof data);
					if (data.status == 'ok') {
						location.reload();
					}
					// обновить страницу в случае удачного сохранения

				}
			});
	})

	/*---------------------- Удалить строку --------------------------------------------*/
	$('button.del').click(function(){
			// получаем ID удаляемого документа
		var row = $(this).parent().parent();
		var tmp = row.css("background");
		row.css("background", "#fcc");
		var id = row.attr('doc_id');
		// alert('del '+ id);
		// exit;
		if (confirm("Точно хотите безвозвратно удалить строку \n "+row.find('td.name').text()+"?")) {
			// alert('delte');
			$.ajax({
          		url: 'http://'+document.location.host+"/metan_0.1/store/expense",
          		type:'POST',
          		dataType: "json",
          		data: {del_expense: id},
          			// функция обработки ответа сервера
          		error: function(data) {
          			alert('Во время удаления произошла ошибка. Проверьте данные!');
          			//alert(data);
          		},
		        success: function(data){
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
	$('button.edit').click(function(){
		checkNewData();
	})
})      // end document.ready


/*---------------------------- ПРоверка и загрузка новых строк с сервера ---------------------------*/
function checkNewData() {
	// console.log('start check data');
	var lastId = $('.doc_data tr').last().attr('doc_id');
	// console.log(lastId);

	$.ajax({
  		url: 'http://'+document.location.host+"/metan_0.1/store/expense_day",
  		type:'POST',
  		dataType: "json",
  		data: {"action": "check", "lastId": lastId-3},
  			// функция обработки ответа сервера
  		error: function(data) {
  			alert('Произошла ошибка!');
  			alert(JSON.stringify(data));
  		},
        success: function(data){
        	alert(data);
        	alert(data.newRowsCount);
        	alert(JSON.stringify(data.rowsData));
        	//alert(typeof data);
        	// удалить строку из таблицы на странице в случае удачного удаления

        	}


        //}
    })
}