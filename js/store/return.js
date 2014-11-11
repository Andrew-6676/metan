$(document).ready(function(){

	$('.search').keyup(function(event){
		if (event.keyCode==118) {
		 	//alert('Поиск');
		 	event.stopPropagation();	// что бы не обрабатывался onclick нижележащего элемента
		 	//createSearchForm();
		 	sForm = new searchForm();
		 	sForm.create({
		 		table: "goods",
		 		field: "name",
		 		key: "id"
		 	});
		}
	})

})