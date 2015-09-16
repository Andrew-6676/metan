/**
 * Created by andrew on 16.07.15.
 */
$(document).ready(function () {

	$('.print_doc_button').click(function(event){
		var id = $(this).parent().attr('doc_id');
		//alert('print reestr  '+$('#doc_hat_'+id+' .doc_num').text());
		window.open(rootFolder+'/print/index?report=Receipt&id='+id,'_blank')
		event.stopPropagation();	// что бы не обрабатывался onclick нижележащего элемента
	});

	$('.cennic_doc_button').click(function(event){
		var id = $(this).parent().attr('doc_id');
		//alert('print reestr  '+$('#doc_hat_'+id+' .doc_num').text());
		window.open(rootFolder+'/print/index?report=Pricelabel&id='+id+'&orient=P&format=html','_blank')
		event.stopPropagation();	// что бы не обрабатывался onclick нижележащего элемента
	});

	$('.del_doc_button').click(function(event){
		//		// получаем ID удаляемого документа
			var id = $(this).parent().attr('doc_id');
			//alert('del '+ id);
			if (confirm("Точно хотите безвозвратно удалить \n ТТН №"+$('#doc_hat_'+id+' .doc_num').text().trim()+" от "+$('#doc_hat_'+id+' .doc_date').text().trim()+"?\n (id="+id+")")) {
				// alert('delte');
				$.ajax({
		     		url: 'http://'+document.location.host+rootFolder+"/store/receipt",
		     		type:'POST',
		     		dataType: "json",
		     		data: {del_receipt: id},
		     			// функция обработки ответа сервера
		     		error: function() {
		     			alert('Во время удаления произошла ошибка. Проверьте данные!');
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

	$('.cell.empty').dblclick(function (event) {
		event.stopPropagation();
		console.log('add id_3torg');
		location.href = 'http://'+document.location.host+rootFolder+"/goods/update/"+$(this).parent().find('.cell.c2').text();
	});

	$('[field="quantity"]').dblclick(function (event) {
		var td = $(this);
		event.stopPropagation();
		console.log($(this).parent().attr('docdata_id'));
		var quantity = prompt('Введите новое количество:', $(this).text());
		if (quantity==null || quantity==$(this).text()) {
			return false;
		}

		var arr =  {'id': '', 'quantity': ''};;
		arr['id'] = $(this).parent().attr('docdata_id');
		arr['quantity'] = quantity;
		//console.log(arr);
			// передаём данные на сервер
		$.ajax({
			url: 'http://' + document.location.host + rootFolder + "/store/receipt",
			type: 'POST',
			dataType: "json",
			data: {change_q: arr},
			// функция обработки ответа сервера
			error: function (data) {
				alert(JSON.stringify(data) + '###');
				alert('Во время сохранения произошла ошибка. Проверьте введённые данные!');
				$('#overlay').hide();
				$('#loadImg').hide();
			},
			success: function (data) {
				console.log(data);
				//alert(data.message);
				if (data.status == 'ok') {
						// вписываем новое кол-во в таблицу
					console.log(td);
					td.text(quantity);
					td.css({"color":"red", "background-color":"#FCFF99"});
					// @TODO надо обновить суммы... или страницу
					//location.reload();
				} else {
					alert(data.message);
				}

			}
		}); //end ajax
	});

	//console.log($('.cell.empty').size());
});
