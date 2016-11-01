/**
 * Created by andrew on 28.08.15.
 */
var nol_hidden = false;

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
	});

	/* ---------------------------------------------------------------------- */
	$('#hide_nol').click(function (e) {
		e.stopPropagation();
		nol_hidden = !nol_hidden;
		if (nol_hidden) {
			$(this).text('Показать с нулевым остатком');
			//$('.summary').text('Строк:');
			$('.nol').hide();
		} else {
			$(this).text('Спрятать с нулевым остатком');
			//$('.summary').text('Строк:');
			$('.nol').show();
		}

		return false;
	});
});


//function open_card(sender) {
//	//console.log(sender);
//
//}