/**
 * Created by andrew on 28.08.15.
 */

$(document).ready(function () {
	//console.log('rest');

	$('tr').click(function () {
		$(this).toggleClass('sel');
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
		}
	})

});
