/**
 * Created by andrew on 20.07.15.
 */
$(document).ready(function () {

	$('#printButton').click(function (){
		window.open(rootFolder+'/print/index?report=Goodsreport&orient=P&from_date=' + $('[name*=from_date]').val() + '&to_date=' + $('[name*=to_date]').val()+'&full='+$('[name*=full]').prop("checked"), '_blank')
	});
	$('#printButton2').click(function (){
		window.open(rootFolder+'/print/index?report=Goodsreport&orient=P&from_date=' + $('[name*=from_date]').val() + '&to_date=' + $('[name*=to_date]').val()+'&full='+$('[name*=full]').prop("checked")+'&forma=f058', '_blank')
	});
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
				//alert('Произошла ошибка. Обратитесь к разработчику!');
				alert(data.message);
				console.log(data);
				$('#overlay').hide();
				$('#loadImg').hide();
			},
			success: function (data) {
				if (data.status == 'ok') {
					$('#goodsReport').html(create_table(data.report_data));
				} else {
					//alert('Во время сохранения произошла ошибка. Проверьте введённые данные!\n\r' + JSON.stringify(data));
					console.log(data);
					alert(data.message);
					$('#overlay').hide();
					$('#loadImg').hide();
				}

			}
		});
		return false;
	});
});

function create_table(data) {
	//return data;
	var html = '';


	//$(data).each(function(i, e){
	//	html += '<br>'+ i;
	//	$(e).each(function(i2, e2){
	//		html += '<br>---'+ i2;
	//		console.log(e2);
	//	});
	//	console.log(e);
	//});

	$.each(data, function(i,e){
		html += '<br>'+ i;
		console.log(e);
	});

	return html;
}