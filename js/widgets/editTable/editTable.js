var curr_td = null;
$(document).ready(function() {

/*---------------------------Двойной клик по полю - сделать его редактируемым--------*/
	$('td').dblclick(function(){
		if ($(this).attr('ro') == 'false') {
			// alert($(this).position().top);
			var edit = $('#edit');
			edit.show();
			curr_td = $(this);
			// alert('top:'+curr_td.offset().top+',  left:' + curr_td.offset().left);
			edit.offset({top:curr_td.offset().top, left:curr_td.offset().left});
			edit.outerWidth(curr_td.outerWidth());
			edit.outerHeight(curr_td.outerHeight());
			edit.val(curr_td.text());
			edit.focus();
			edit.select();
		} else {
			// alert('Это поле не доступно для редактирования');
		}
	})
/*------------------------Нажатие ENTER----------------------------------------------*/
	$('#edit').keyup(function(event){
		if (event.keyCode==13) {
			curr_td.text($(this).val());
			//alert(curr_td.attr('val') +' - '+ $(this).val());
			if (curr_td.attr('val') != $(this).val()) {
				curr_td.addClass('modified_td');
				curr_td.parent().addClass('modified_tr');
			} else {
				curr_td.removeClass('modified_td');
				// alert($('#'+curr_td.parent().attr('id')+' .modified_td').length);
				if ($('#'+curr_td.parent().attr('id')+' .modified_td').length == 0) {
					curr_td.parent().removeClass('modified_tr');
				}
			}
			$(this).hide();
		}
	})
/*-----------------------------------------------------------------------------------*/
	// $(document).click(function(event) {
 //    	if ($(event.target).closest("#edit").length) return;
	// 	$('#edit').hide();
 //    	event.stopPropagation();
 //  	});

/*------------------------Потеря фокуса полем ввода - спрятать-----------------------*/
	$('#edit').blur(function(){
		$(this).hide();
	})
/*----------------СОХРАНЕНИЕ СТРОКИ В БД --------------------------------------------*/
	$('.save_row').click(function(){
			// передаём в функцию сохранения строку таблицы
		save_row($(this).closest('tr'));
	})
/*----------------СОХРАНЕНИЕ ВСЕХ СТРОК В БД СРАЗУ-----------------------------------*/
	$('#save_all').click(function(){
		var modified = $('.modified_tr');

		if ($(modified).size()>0 && confirm("Подтвердите сохранение всех изменённых записей.")) {
				// выбрать измененённые записи

				// цикл по строкам
			modified.each(function(i, el){
				// alert($(el).attr('id'));
				save_row(el);
			})
		}
	})
/*-----------------------------------------------------------------------------------*/
	$('.del_row').click(function(){
		console.log($(this).parent().parent().attr('row_id'));
		if (confirm("Точно хотите безвозвратно удалить строку из остатков?")) {
			var rid = $(this).parent().parent().attr('row_id');
			$.ajax({
				url: rootFolder + '/MainAjax/delRest',
				type: "POST",
				data: {id: rid},
				error: function (data) {
					alert('Ошибка удаления');
				},
				success: function (data) {
					//alert(data);
					$("[row_id=" + rid + "]").fadeOut(500);
				}
			});
		}
	})
/*-------------------------отменить изменение одной строки---------------------------*/
	$('.cancel_row').click(function(){
		cancel_row($(this).closest('tr'));
	})
/*-------------------------Отменить изменения всех строк---------------------------*/
	$('#cancel_all').click(function(){
		var modified = $('.modified_tr');
		if ($(modified).size()>0 && confirm("Подтвердите отмену всех изменений.")) {
				// выбрать измененённые записи
				// цикл по строкам
			modified.each(function(i, el){
				// alert($(el).attr('id'));
				cancel_row(el);
			})
		}
	})
/*-----------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------*/


})



/*----------------ОТПРАВИТЬ ДАННЫЕ В БД ---------------------------------------------*/
function save_row (row) {
	var record = {
		id: $(row).attr('id').substr(2),
		f_vals: {
			'quantity': $(row).find('[fname=quantity]').html(),
			'cost': $(row).find('[fname=cost]').html()
		}
	};




	//alert($(row).find('[fname=quantity]').html());
	$.ajax({
		url: rootFolder+'/MainAjax/updateRest',
		type: "POST",
		data: {data: record},
		error: function(data) {
			alert('Ошибка сохранения');
			cancel_row(row);
		},
		success: function(data) {
	 	   	//alert(data);

			// изменение суммы
			var sum = parseFloat($('.vsego span').text().replace(/[\s`]/g,''))
				+ (
					(parseFloat($(row).find('[fname=quantity]').text())-parseFloat($(row).find('[fname=quantity]').attr('val')))
					*
					(parseFloat($(row).find('[fname=price]').attr('val')))
				);
			$('.vsego span').text(String(sum).replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1`').pad(11,' ',0));
			//console.log(($(row).find('[fname=price]').text()));

	 	   	// записать новые значения в тег val
	 	 	$(row).find('[fname=quantity]').attr('val', $(row).find('[fname=quantity]').html());
	 	 	$(row).find('[fname=cost]').attr('val', $(row).find('[fname=cost]').html());
	 	 	$(row).find('.modified_td').removeClass('modified_td');
	 	 	$(row).removeClass('modified_tr');

		}
	});
}

function cancel_row (row) {
	//alert($(row).attr('id'));
	$(row).removeClass('modified_tr');
		// набор изменённых ячеек
	var td = $('#' + $(row).attr('id') + ' td').removeClass('modified_td');
	td.each(function(i, el){
		$(el).text($(el).attr('val'));
		$(el).removeClass('modified_td');
	})
}