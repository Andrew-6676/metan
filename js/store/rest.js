/**
 * Created by andrew on 28.08.15.
 */

$(document).ready(function () {
	//console.log('rest');

	$('tr').click(function (e) {
		if (e.shiftKey) {
			if ($('.sel').size() > 0) {
				$(this).prevUntil('.sel').addClass('sel');
				$(this).addClass('sel');
			} else {
				$(this).toggleClass('sel');
			}
			// alert("shift+click");
			// выделяем все от
		} else {
			$(this).toggleClass('sel');
		}
	});
	
	$('.unselect_goods').click(function () {
		$('tr.sel').removeClass('sel');
	});
	
	$('.selected_goods').click(function () {
		var goods = $("tr.sel").map(function(indx, element){
			return $(element).find('.gid').text();
		});

		if (goods.size() > 0 ) {
			goods = goods.get();
			console.log(goods);
			var params = '?id='+goods.join(',');
			// открыть выборку на новой вкладке
			window.open(rootFolder + '/goods/selection' + params, '_blank')
		} else {
			alert("Не выбрано ни одной записи.");
		}
	})

});


//function open_card(sender) {
//	//console.log(sender);
//
//}