/**
 * Created by andrew on 20.07.15.
 */
$(document).ready(function () {

		// запрос отчёта
	$('#getreportButton').click(function () {
		console.log('getReport');

			// сбор данных для передачи
		var data = {};
		reg = /\[(.*)\]/;
		$('[name*=getReport]').each(function(i){
			data[$(this).attr('name').match(reg)[1]] = $(this).val();
		});
		//console.log(data);

		$.ajax({
			url: 'http://' + document.location.host + rootFolder +"/store/prepareGoodsreport",
			type: 'POST',
			dataType: "json",
			data: {getReport: data},
			error: function (data) {
				//alert(JSON.stringify(data) + '###');
				alert('Во время сохранения произошла ошибка. Проверьте введённые данные!');
				$('#overlay').hide();
				$('#loadImg').hide();
			},
			success: function (data) {
				//console.log(data);
				//	var res = eval(data);
				//alert(data.status+'---');
				//alert(typeof data);
				if (data.status == 'ok') {
					$('#goodsReport').html(data.message);
				} else {
					alert('Во время сохранения произошла ошибка. Проверьте введённые данные!\n\r' + JSON.stringify(data));
					$('#overlay').hide();
					$('#loadImg').hide();
				}

			}
		});
	});
});