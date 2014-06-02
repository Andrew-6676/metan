$(document).ready(function(){
	/*-------------------удаление документа----------------------------------------------*/
	$('.del_doc_button').click(function(event){
			// получаем ID удаляемого документа
		var id = $(this).parent().attr('doc_id');
		//alert('del '+ id);
		if (confirm("Точно хотите безвозвратно удалить \n ТТН №"+$('#doc_hat_'+id+' .doc_num').text().trim()+" от "+$('#doc_hat_'+id+' .doc_date').text().trim()+"?\n (id="+id+")")) {
			// alert('delte');
			$.ajax({
          		url: 'http://'+document.location.host+"/metan_0.1/store/receipt",
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

/*  ---------------------------------------------------------  */
	$('.parent_row').click(function(){
		var ch = $('#ch_'+$(this).attr('id'));
		var pr = $(this);
		//$('.parent_row .child_row').show();
		// alert($('#ch_'+$(this).attr('id')).attr('id'));
		ch.removeClass('hidden');
		pr.addClass('hidden');
	})
	/*  ---------------------------------------------------------  */
	$('.doc_hat').click(function(){
		var id = $(this).attr('id').substring(8);
		//$('.parent_row .child_row').show();
		//alert($(this).attr('id').substring(8));
		var ch = $('#ch_'+id);
		var pr = $('#'+id);

		ch.addClass('hidden');
		pr.removeClass('hidden');
	})
	/*  ---------------------------------------------------------  */
	/*  ---------------------------------------------------------  */
	/*  ---------------------------------------------------------  */
	/*  ---------------------------------------------------------  */
	/*  ---------------------------------------------------------  */
	/*  ---------------------------------------------------------  */
	/*  ---------------------------------------------------------  */
	/*  ---------------------------------------------------------  */
	/*  ---------------------------------------------------------  */
})
//alert('Delivery.js')
