var curr_td = null;
$(document).ready(function() {

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
/*-----------------------------------------------------------------------------------*/
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

/*-----------------------------------------------------------------------------------*/
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
		if (confirm("Подтвердите сохранение всех изменённых записей.")) {
				// выбрать измененённые записи
			var modified = $('.modified_tr');
				// цикл по строкам
			modified.each(function(i, el){
				// alert($(el).attr('id'));
				save_row(el);
			})
		}
	})
/*-----------------------------------------------------------------------------------*/
/*-------------------------отменить изменение одной строки---------------------------*/
	$('.cancel_row').click(function(){
		cancel_row($(this).closest('tr'));
	})
/*-------------------------Отменить изменения всех строк---------------------------*/
	$('#cancel_all').click(function(){
		if (confirm("Подтвердите отмену всех изменений.")) {
				// выбрать измененённые записи
			var modified = $('.modified_tr');
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
	var record = {id: $(row).attr('id')}
	alert(record.id);
	// $.ajax({
	// 	url: '',
	// 	type: "POST",
	// 	data: {data: record},
	// 	success: function(data){
	 	   	cancel_row(row);
	// 	}
	// });
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