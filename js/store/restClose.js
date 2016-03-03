
$(document).ready( function(){

	check_closed($('#month_num').val(), $('#year_num').val());

  /*-------------------------------------------------------------------------------*/
	$('#close_month').click(function(){
		//alert('Закрываем '+$('#month_num').val()+' '+$('#year_num').val())
		if (confirm('Закрываем '+$('#month_num').val()+'.'+$('#year_num').val()+'?')) {
			// alert('delte');
			$.ajax({
          		url: 'http://'+document.location.host+rootFolder+"/store/restClose",
          		type:'POST',
          		dataType: "json",
          		data: {mode: 'close', month: $('#month_num').val(), year: $('#year_num').val()},
          			// функция обработки ответа сервера
          		error: function(data) {
          			// alert('Во время обработки произошла ошибка. Дайте в бубен программеру!!!');
		            console.log(data);
      				$('#res_span').removeClass();
    				$('#res_span').addClass('no');
	        		$('#res_span').html('ошибка');
          			alert(JSON.stringify(data));
          		},
		        success: function(data){
			        console.log(data);
		        	// alert(JSON.stringify(data));
		        	// $('#res_div').html('<pre>'+JSON.stringify(data)+'</pre>');
		        	// alert(data.status);
		        	// alert(typeof data);
		        	if (data.status == 'ok') {
		        		//location.reload();
		        		$('#res_span').removeClass();
        				$('#res_span').addClass('ok');
		        		$('#res_span').html('закрыт');
		        		alert('Месяц закрыт.');
		        	//	location.reload();
		        	} else {
				        alert('Возникла ошибка при закрытии месяца. Виноват, сорее всего, программист.');
			        }


		        }
	        });
		}


	})

/*-------------------------------------------------------------------------------*/

	$('#month_num, #year_num').change(function(){
		// alert('sd');
		check_closed($('#month_num').val(), $('#year_num').val());

	})
/*-------------------------------------------------------------------------------*/

});
/*-------------------------------------------------------------------------------*/
/*-------------------------------------------------------------------------------*/
/*-------------------------------------------------------------------------------*/
/*-------------------------------------------------------------------------------*/
/*-------------------------------------------------------------------------------*/
/*-------------------------------------------------------------------------------*/
/*-------------------------------------------------------------------------------*/
/*-------------------------------------------------------------------------------*/
/*-------------------------------------------------------------------------------*/

function check_closed (m,y) {
	$.ajax({
  		url: 'http://'+document.location.host+rootFolder+"/store/restClose",
  		type:'POST',
  		dataType: "json",
  		data: {mode: 'check', month: m, year: y},
  			// функция обработки ответа сервера
  		error: function(data) {
  			alert('Во время обработки произошла ошибка. Дайте в бубен программеру!!!');
  			// alert(JSON.stringify(data));
  		},
        success: function(data){
        	// alert(JSON.stringify(data));
        	switch (data.status) {
        		case 'ok':
        			$('#res_span').removeClass();
        			$('#res_span').addClass('ok');
        			$('#res_span').html('закрыт');
        			break;
        		case 'no':
					$('#res_span').removeClass();
        			$('#res_span').addClass('no');
        			$('#res_span').html('не закрыт');
        			break;
        		default:

        	}
        	// alert(JSON.stringify(data));
        	// $('#res_div').html('<pre>'+JSON.stringify(data)+'</pre>');
        	// alert(data.status);
        	// alert(typeof data);
       	}
	});
}