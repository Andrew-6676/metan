$(document).ready( function(){
	// alert('epence.js')

	// var array = {'goods_arr':''};
	// array['goods_arr'] = {'quantity':'10', 'price':'35678'};
	// alert(JSON.stringify(array));
	// for (var key in array){
	//		alert(key);
	//		alert(array[key]);
	//}
/*-------------------Редактирование расхода----------------------------------------------*/
/*-------------------удаление документа----------------------------------------------*/
	$('.del_doc_button').click(function(event){
			// получаем ID удаляемого документа
		var id = $(this).parent().attr('doc_id');
		//alert('del '+ id);
		if (confirm("Точно хотите безвозвратно удалить \n документ №"+$('#doc_hat_'+id+' .doc_num').text().trim()+" от "+$('#doc_hat_'+id+' .doc_date').text().trim()+"?")) {
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
		        		$('#'+id+', #ch_'+id).remove();
		        	}


		        }
	        });
		}
		event.stopPropagation();	// что бы не обрабатывался onclick нижележащего элемента
	})
/*-------------------  редактирование документа-----------------------------------------------*/
	$('.edit_doc_button').click(function(event){
		alert('edit');
		//event.preventDefault();

		event.stopPropagation();
	})
/*------------------- Добавить расход в БД-----------------------------------------------*/
	$('#add_expence').click(function(){
		//alert('сохранить расход');
		//alert(document.location.host);
		//alert($('[name = "expence[id_operation]"]').val());
			// собираем данные в массив

		var arr = {};
		var goods_arr = {};
		var exp = {'doc':'', 'doc_data':''};

		var id 		= $('.id_goods');	// массив инпутов с кодами товаров
		var quantity= $('.quantity');	// массив с количествами товаров
		var price 	= $('.price'); 		// массив с ценами
			// цикл по кодам товара
		id.each(function(index, element){
			//alert(index+' -- ["'+$(element).val() + '"] = '+ $(quantity).eq(index).val());

				// если одно из полей пустое - выдать сообщение с вариантами: пропустить/отменить

				// создаём массив вида array('id'=>array(quantity, price))
			goods_arr[$(element).val()] = {'quantity':$(quantity).eq(index).val(), 'price':$(price).eq(index).val()};

			// goods_arr[$(element).val()] = $(quantity).eq(index).val();
		});
			// массив с аттрибутами документа (шапка)
		arr['id_operation'] = $('[name = "expence[id_operation]"]').val();
		arr['doc_date']		= $('[name = "expence[doc_date]"]').val();
		arr['doc_num'] 		= $('[name = "expence[doc_num]"]').val();

			// запихиваем два массива в один, который и отправится на сервер
		exp['doc'] = arr;
		exp['doc_data'] = goods_arr;
	 	// alert(JSON.stringify(exp));

			// передаём данные на сервер
		$.ajax({
          		url: 'http://'+document.location.host+"/metan_0.1/store/expense",
          		type:'POST',
          		dataType: "json",
          		data: {new_expense: exp},
          			// функция обработки ответа сервера
          		error: function(data) {
          			alert(JSON.stringify(data)+'###');
          			alert('Во время сохранения произошла ошибка. Проверьте введённые данные!');
          		},
		        success: function(data){
		        	alert(JSON.stringify(data));
		        //	var res = eval(data);
		        	//alert(data.status+'---');
		        	//alert(typeof data);
		        	if (data.status == 'ok') {
		        		location.reload();
		        	}
		        	// обновить страницу в случае удачного сохранения

		        }
        	});
	})
/*-------------------------------------------------------------------------------------*/
/*--------------------- Добавить новую строку для товара ------------------------------*/
	$('#add_new_row').click(function(){
			//	добавить пустую строку для нового товара в расходе
			// клонируем последнюю строку таблицы и вставляем её в конец таблицы
		$('#new_goods_table tr:last').clone().appendTo('#new_goods_table');
			// получаем тлько что вставленную строку
		var tr=$('#new_goods_table tr:last');
			// вычисляем её id+1
		var id = 'row_'+(tr.attr('id').substr(4)*1+1);
			// меняем id  в последней строке
		tr.attr('id',id);
			// очищаем <input'ы>
		$('#new_goods_table tr:last :input').val('');
		$('#new_goods_table tr:last .id_goods').focus();
			// назначаем обработку событий новой строке
		set_autocomplete('#'+id);
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
set_autocomplete('#row_1');
/*-------------------------------------------------------*/

})		//$(document).ready( function(){

/*--------------------------------------------------------------------------------------------------------------*/
/*--------------------------------------------------------------------------------------------------------------*/
/*-------------------- Автодополнение для кода товара ---------------------------------------------------------*/
function set_autocomplete(id) {
	//alert(id);
	$(id+" .id_goods" ).autocomplete({
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
     		$('#row_'+row+' .price').val(ui.item.price);
     	}
    });		// end $(id+" .id_goods" ).autocomplete

/*------------------ Автодополнение для наименования товара --------------------------------*/
$(id+" .goods_name" ).autocomplete({
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
		        		$.map(data, function(item){	// пробегаем по каждой строке результата
			            	return{ 	// формируем массив нужной структуры
			            		id: item.id,	// это поле для вставки в соседний <input> (код товара)
			            		value: item.name + '    ('+item.rest+' шт)',	// это поле вставится в <input>
			            		label: '['+item.id+'] '+item.name + '    ('+item.rest+' шт по '+item.price+'р.)',		// это поле отобразится в выпадающем списке
			            		price: item.price,
			            		rest: item.rest
			              	}
		            	})
		            );
		        }
        	});
      	},
     	minLength: 3,
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
    });		// end $(id+" .goods_name" ).autocomplete
/*---------------------------------------------------------*/
	$(id+' input').keypress(function(event){
		if (event.keyCode==13 && !$(this).is(':button')) {
			if ($(this).hasClass('price')) {
				var idd = '#row_'+(id.substr(5)*1+1);
				//alert(idd+' .id_goods');
				$(idd+' .id_goods').focus();
			} else {
				$(this).parent().next().find('input, button').focus();
			}
		}
	})
/*---------------------------------------------------------*/
	$(id+' input').keyup(function(event){
		//alert(event.ctrlKey);
		//alert(event.keyCode);
		if (event.ctrlKey && event.keyCode==13) {
			//$(this).parent().parent().next().find .focus();
			$('#add_new_row').click();
			event.stopPropagation();
			//alert('Ctrl+enter');
		}
	})
/*---------------------------------------------------------*/
	$(id+' .del_row').click(function(){
		if ($('#new_goods_table tbody tr').size()>1) {
			var row = $(this).parent('div').parent('td').parent('tr').attr('id');
			//alert('delete '+row);
			$('#'+row).remove();
		} else {
			alert('Нельзя удалить единственную строку!');
		}
	})

	$(id+' .clr_row').click(function(){
		var row = $(this).parent('div').parent('td').parent('tr').attr('id').substr(4);
		//alert('clear '+row);
		$('#new_goods_table tr:last :input').val('');
	})
}		// end set_autocomplete