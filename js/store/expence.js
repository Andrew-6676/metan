var search_data = {
				capt: "Поиск для расхода",
				action: "GetGoodsNameFromRest",
				fields: ["name","rest","price"],
				field: 'gname',
				key: "id",
				width: 800,
				sender: null,
			};
/*--------------------------------------------------*/
$(document).ready( function(){
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
	$(document).keypress(function(event){
		if (event.keyCode==127 && !$(this).is(':input')) {
			//alert(event.keyCode);
			var del_list = $('.child_row.visible .selected');
			if ($(del_list).length > 0) {
				var str = 'Точно хотите безвозвратно удалить строки из документов: \n\n';
				//alert('del rows:'+$(del_list).length);
				$('.child_row.visible .selected').closest('.child').each(function(i, el){
					str += '№ ' + ($(el).find('.doc_num').text().trim());
					str += ' от ' + ($(el).find('.doc_date').text().trim());
					str += ' (' + $(el).find('.selected').length + ' стр.)' + '\n';
				})
				str += '\n(всего '+$(del_list).length+' стр.)';
				if (confirm(str)) {
					alert('del');
				}
			}
		}
	})
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
		rows.each(function(j,el){
			td_dst = tbl_dst.find('.new_goods_row').last().find('td');
			cells_src = $(el).find('td');
				// console.log(cells_src);
				// обход колонок (кроме первой и последней - они нам не нужны)
			cells_src.each(function(i, el) {
				if (i != 0  &&  i < cells_src.size()-1) {
					if (i == cells_src.size()-2) {
							// console.log($(el).text().trim().replace(/`/g,""));
							// console.log(td_dst.eq(i));
							// удаляем лишние символы из цены
						td_dst.eq(i-1).find('input').val($(el).text().trim().replace(/`/g,""));
					} else {
						//console.log($(el).text());
						td_dst.eq(i-1).find('input').val($(el).text().trim());
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
		$('[name*=doc_date]').val( date_arr[2]+'-'+date_arr[1]+'-'+date_arr[0] );
			// номер документа
		$('[name*=doc_num]').val(tbl_src.find('thead .doc_num').text().trim());
			// id документа
		$('#new_goods_table').attr('doc_id', tbl_src.parent().parent().prev().attr('id'));
			// id операции
		$('[name*=id_operation]').val(tbl_src.find('thead [id_operation]').attr('id_operation'));
			// id контакта и его наименование
		$('#contact_name').attr('cid', tbl_src.find('thead [id_contact]').attr('id_contact'));
		$('#contact_name').val(tbl_src.find('thead [id_contact]').text());


		$(document).scrollTop(70)
		event.stopPropagation();
	})
/*-------------------- Очистить форму ---------------------------------------------------*/
	$('#clear_form').click(function(){
		if (confirm("Удалить введённые, но не сохранённые данные?")) {
			clear_form();
		}

	})

	function clear_form(){
			// удалить все строки и очистить шапку
		$('#new_goods_table .new_goods_row').each(function(i, el){
			if (i==0) {
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
		$('#new_goods_table').attr('doc_id','-1');		// обнулить id документа в форме редактирования

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

			// массив с аттрибутами документа (шапка)
		arr['doc_id']		= $('#new_goods_table').attr('doc_id');
		arr['id_operation'] = $('[name = "expence[id_operation]"]').val();
		arr['doc_date']		= $('[name = "expence[doc_date]"]').val();
		arr['doc_num'] 		= $('[name = "expence[doc_num]"]').val();

			// запихиваем два массива в один, который и отправится на сервер
		exp['doc'] = arr;
		exp['doc_data'] = goods_arr;
	 	// alert(JSON.stringify(exp));

	 	$('#overlay').show();
        $('#loadImg').show();

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
					$('#overlay').hide();
			        $('#loadImg').hide();
          		},
		        success: function(data){
		        //	alert(JSON.stringify(data));
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
		$('#new_goods_table tbody tr:last').clone().appendTo('#new_goods_table');
			// получаем тлько что вставленную строку
		var tr=$('#new_goods_table tbody tr:last');
			// вычисляем её id+1
		var id = 'row_'+(tr.attr('id').substr(4)*1+1);
			// меняем id  в последней строке
		tr.attr('id',id);
			// очищаем <input'ы>
		$('#new_goods_table tbody tr:last :input').val('');
		$('#new_goods_table tbody tr:last .summ').text('');
		$('#new_goods_table tbody tr:last .id_goods').focus();
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


/*-------------------------------------------------------*/
	set_autocomplete('#row_1');
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
     		    //alert(ui.item.price*1);
     		$('#row_'+row+' .price').val((ui.item.price*1));
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
    });		// end $(id+" .goods_name" ).autocomplete
	/*---------------------------------------------------------*/
	$(id+' input').keypress(function(event){
		if (event.keyCode==13 && !$(this).is(':button')) {
			if ($(this).hasClass('price')) {
				if ($(this).closest('tr').next().length != 0) {
					$(this).closest('tr').next().find('.id_goods').focus();
				} else {
					$('#add_expence').focus();
					$('#add_invoice').focus();
					$('#add_return').focus();
				}
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

	/*-------------Пересчёт сумм при изменении количества---*/
	$(id+' .quantity, '+id+'  .price').change(function(){

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
	$(id+' .search.goods_name').keyup(function(event){
		if (event.keyCode==118) {
		 	//alert('Поиск');
		 	sForm = new searchForm();
		 	search_data.sender = $(this).parent().parent().attr('id');
		 	sForm.create(search_data);
		}
	})


}		// end set_autocomplete