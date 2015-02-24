$(document).ready(function(){
	/*  ---------------------------------------------------------  */
	$('.parent_row').click(function(){
		var ch = $('#ch_'+$(this).attr('id'));
		var pr = $(this);
		//$('.parent_row .child_row').show();
		// alert($('#ch_'+$(this).attr('id')).attr('id'));
		ch.removeClass('hidden');
		ch.addClass('visible');
		pr.addClass('hidden');
	})
	/*  ---------------------------------------------------------  */
	$('.doc_hat').click({a:12, b:"abc"}, function(eventObject){
		//alert(eventObject.)
		var id = $(this).attr('id').substring(8);
		//$('.parent_row .child_row').show();
		//alert($(this).attr('id').substring(8));
		var ch = $('#ch_'+id);
		var pr = $('#'+id);

		ch.addClass('hidden');
		ch.removeClass('visible');
		pr.removeClass('hidden');
	})
	/*  ---------------------------------------------------------  */
	$('.child tbody tr').click(function() {
		if ($(this).hasClass('selected')) {
			$(this).removeClass('selected');
		} else {
			$(this).addClass('selected');
		}

	})
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
