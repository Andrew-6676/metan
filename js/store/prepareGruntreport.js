/**
 * Created by andrew on 20.07.15.
 */
$(document).ready(function () {

	$('#printReport').click(function (){
		window.open(rootFolder+'/print/index?report=Gruntreport&orient=P&from_date=' + $('[name*=from_date]').val() + '&to_date=' + $('[name*=to_date]').val(), '_blank')
	});

		// запрос отчёта
	$('#showReport').click(function () {
		//console.log('getAjaxReport');

			// сбор данных для передачи
		var data = {};
		reg = /\[(.*)\]/;
		$('[name*=getReport]').each(function(i){
			data[$(this).attr('name').match(reg)[1]] = $(this).val();
		});
		console.log(data);

		$.ajax({
			url: 'http://' + document.location.host + rootFolder +"/store/prepareGruntreport",
			type: 'POST',
			dataType: "json",
			data: {getAjaxReport: data},
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
					//console.log(data.data);
					$('#Report').html(create_table(data.data));
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
	var html ='';

	html += '<table class="std">';
	$.each(data, function(i,e){
		html += '<tr>';
		$.each(e, function(i,e){
			html += '<td>'+ e+'</td>';
		});
		html += '</tr>';
	});
	html += '</table></div>';

	return html;
}