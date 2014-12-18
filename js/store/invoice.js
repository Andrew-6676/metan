var search_data = {
		 		capt: "Поиск для счёт-фактуры",
		 		table: "goods",
		 		field: "name",
		 		key: "id",
		 		width: 800,
		 		sender: null,
		 	};
/*-----------------------------------------------------------*/

$(document).ready( function() {

	// $(".new_contact").draggable({
	// 		    cursor: "move",
	// 		    // distance: 10,
	// 		   	//revert: true,
	// 		   	//revertDuration: 3000
	// 		});

	$('.add_contact').click(function() {
		//alert('новый потребитель');
		$('#overlay').show() //fadeIn(50); ;
		$('.new_contact').show(); //fadeIn(100); //show();
	})

	$('#cancel_new_contact, #close_form').click(function() {
		$('#overlay').fadeOut(100); //hide();
		$('.new_contact').fadeOut(100); //hide();
	})

		// спрятать форму нового потребителя по клику в не формы
	$(document).click(function(event) {
	    if ($(event.target).closest('.new_contact, .add_contact').length) return;
	    $('.new_contact').hide();
		$('#overlay').hide();
	    event.stopPropagation();
	});

/*------------------- Добавить расход в БД-----------------------------------------------*/

	$('#contact_name').autocomplete({
    	source: function(request, response){
    		//response функция для обработки ответа
    		//alert(request.term); // - строка поиска;
        	$.ajax({
          		url: 'http://'+document.location.host+"/metan_0.1/MainAjax/GetContactName",
          		type:'GET',
          		dataType: "json",
          		data: 'term='+request.term+'&f=name',
		        success: function(data){
		        	//alert((data));
		        	response(
		        		$.map(data, function(item){
			            	return{
			            		value: item.name,
			            		label: '['+item.id+'] '+item.name,
			            		id: item.id
			              	}
		            	})
		            );
		        }
        	});
      	},
     	minLength: 4,
     	select: function(event, ui) {
     		//     // вставить id в тег cid
     		$('#contact_name').attr('cid',(ui.item.id*1));
     	}
    });		// end $(id+" .id_goods" ).autocomplete

/*------------------- Добавить расход в БД-----------------------------------------------*/

	$('#add_invoice').click(function(){

		if ($('#contact_name').attr('cid')=='') {
			alert('Не указан потребитель!');
				err =  true;
				return false;
		}

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
		var vat 	= $('.vat'); 		// массив с НДС

			// цикл по кодам товара
		var err = false;
		id.each(function(index, element){
			//alert(index+' -- ["'+$(element).val() + '"] = '+ $(quantity).eq(index).val());

				// если одно из полей пустое - выдать сообщение с вариантами: пропустить/отменить

				// создаём массив вида array('id'=>array(quantity, price))
			if ($(id).eq(index).val() != '' && $(quantity).eq(index).val() != '' && $(price).eq(index).val() !='' && $(vat).eq(index).val() != '') {
				goods_arr[$(element).val()] = {
						'quantity':$(quantity).eq(index).val(),
						'price':$(price).eq(index).val(),
						'vat':$(vat).eq(index).val()
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
		arr['id_contact'] 	= $('#contact_name').attr('cid');
		arr['doc_date']		= $('[name = "invoice[doc_date]"]').val();
		arr['doc_num'] 		= $('[name = "invoice[doc_num]"]').val();

			// запихиваем два массива в один, который и отправится на сервер
		exp['doc'] = arr;
		exp['doc_data'] = goods_arr;
	 	// alert(JSON.stringify(exp));

        $('#loadImg').show();
	 	$('#overlay').show();

			// передаём данные на сервер
		$.ajax({
          		url: 'http://'+document.location.host+"/metan_0.1/store/invoice",
          		type:'POST',
          		dataType: "json",
          		data: {new_invoice: exp},
          			// функция обработки ответа сервера
          		error: function(data) {
          			alert(JSON.stringify(data)+'###');
          			alert('Во время сохранения произошла ошибка. Проверьте введённые данные!');
          			$('#overlay').hide();
        			$('#loadImg').hide();
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
		        		$('#overlay').hide();
        				$('#loadImg').hide();
		        	}
		        	// обновить страницу в случае удачного сохранения

		        }
        	});
	})		// end $('#add_invoice').click
/*-------------------------------------------------------------------------------------*/

	// $('.edit_invoice_button').click(function(event) {
	// 	alert('Редактировать счёт-фактуру ');
	// 	event.stopPropagation();	// что бы не обрабатывался onclick нижележащего элемента
	// })

	$('.write_off_button').click(function(event) {
		alert('списать ');
		event.stopPropagation();	// что бы не обрабатывался onclick нижележащего элемента
	})

})