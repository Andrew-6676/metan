$(document).ready(function(){
	/*-------------------печать документа----------------------------------------------*/
	//$('.print_doc_button').click(function(event){
	//	var id = $(this).parent().attr('doc_id');
	//	//alert('print reestr  '+$('#doc_hat_'+id+' .doc_num').text());
	//	window.open(rootFolder+'/print/index?report=Receipt&id='+id,'_blank')
	//	event.stopPropagation();	// что бы не обрабатывался onclick нижележащего элемента
	//})
	/*-------------------удаление документа----------------------------------------------*/
	//$('.del_doc_button').click(function(event){
	//		// получаем ID удаляемого документа
	//	var id = $(this).parent().attr('doc_id');
	//	//alert('del '+ id);
	//	if (confirm("Точно хотите безвозвратно удалить \n ТТН №"+$('#doc_hat_'+id+' .doc_num').text().trim()+" от "+$('#doc_hat_'+id+' .doc_date').text().trim()+"?\n (id="+id+")")) {
	//		// alert('delte');
	//		$.ajax({
     //     		url: 'http://'+document.location.host+rootFolder+"/store/receipt",
     //     		type:'POST',
     //     		dataType: "json",
     //     		data: {del_receipt: id},
     //     			// функция обработки ответа сервера
     //     		error: function() {
     //     			alert('Во время удаления произошла ошибка. Проверьте данные!');
     //     		},
	//	        success: function(data){
	//	        	// alert(data);
	//	        	//alert(data.status);
	//	        	//alert(typeof data);
	//	        	// удалить строку из таблицы на странице в случае удачного удаления
	//	        	if (data.status == 'ok') {
	//	        		//location.reload();
	//	        		$('#'+id+', #ch_'+id).remove();
	//	        	}
	//
	//
	//	        }
	//        });
	//	}
	//	event.stopPropagation();	// что бы не обрабатывался onclick нижележащего элемента
	//})

/*--------------------------------------------------------------*/

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
					var ids = [];
					$('.child_row.visible .selected').each(function (i,e) {
						//console.log($(this).attr('docdata_id'));
						ids[ids.length] = $(this).attr('docdata_id');
					});
					console.log('del: '+ids);
					$.ajax({
						url: 'http://'+document.location.host+rootFolder+"/MainAjax/delDocdata",
						type:'POST',
						dataType: "json",
						data: {'data':ids},
						// функция обработки ответа сервера
						error: function(data) {
							console.log(data);
							alert('Во время удаления произошла ошибка. Проверьте данные!');
							//alert(data);
						},
						success: function(data){
							console.log(data);
							//alert(data.status);
							//alert(typeof data);
							// удалить строку из таблицы на странице в случае удачного удаления
							if (data.status == 'ok') {
								$('.child_row.visible .selected').remove();
								alert(data.message);
								//location.reload();

							}


						}
					});
				}
			}
		}
	})
/*  ---------------------------------------------------------  */
	$('#show_more').click(function(event){
		console.log('show_more');
		$('.parent_row.hidden').show();
		$('.parent_group.hidden').show();
		$(this).hide();
		return false;
	});
/*  ---------------------------------------------------------  */
	$('.parent_row').click(function(){
		var ch = $('#ch_'+$(this).attr('id'));
		var pr = $(this);
		//$('.parent_row .child_row').show();
		// alert($('#ch_'+$(this).attr('id')).attr('id'));
		ch.show(100);
		ch.removeClass('hidden');
		ch.addClass('visible');
		pr.addClass('hidden');
	})
	/*  ---------------------------------------------------------  */
	$('.doc_hat').click(function(){
		var id = $(this).attr('id').substring(8);
		//$('.parent_row .child_row').show();
		//alert($(this).attr('id').substring(8));
		var ch = $('#ch_'+id);
		var pr = $('#'+id);
		ch.hide(0);
		ch.addClass('hidden');
		ch.removeClass('visible');
		pr.removeClass('hidden');
	})
	/*  ---------------------------------------------------------  */
	//$('.child tbody tr a').click(function() {
	//	//event.stopPropagation();
	//	$(this).parent().parent().toggleClass('selected');
	//});
	/*  ---------------------------------------------------------  */
	$('.child tbody tr').click(function() {
		//event.stopPropagation();
		//if ($(this).hasClass('selected')) {
		//	$(this).removeClass('selected');
		//} else {
		//	$(this).addClass('selected');
		//}
		$(this).toggleClass('selected');
	});
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
