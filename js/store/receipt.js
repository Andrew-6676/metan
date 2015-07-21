/**
 * Created by andrew on 16.07.15.
 */
$(document).ready(function () {
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
		console.log('add id_3torg');
		location.href = 'http://'+document.location.host+rootFolder+"/goods/update/"+$(this).parent().find('.cell.c2').text();
	});

	console.log($('.cell.empty').size());
});
