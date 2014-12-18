var search_data = {
		 		capt: "Поиск для возврата",
		 		table: "goods",
		 		field: "name",
		 		key: "id",
		 		width: 800,
		 		sender: null,
		 	};

/*----------------------------------------------------*/

$(document).ready(function(){

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
				goods_arr[$(element).val()] = {
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
          		url: 'http://'+document.location.host+"/metan_0.1/store/return",
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
	})		// end $('#add_return').click

})