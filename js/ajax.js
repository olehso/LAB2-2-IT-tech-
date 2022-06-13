function getPage(){
    $.ajax({
		converters: {
	   "text json": jQuery.parseJSON
	   },
        type: "GET",
        url: "auth.php",
        data: {author: $('[name="author"]').val()},
        success: function(result){
            $('#result1').html(result);
			localStorage.setItem('form1Result', JSON.stringify(result));
			localStorage.setItem('form1Data', $('#Form1').serialize());
        }
    });
}

function getLocal1(e) {
	$('#result1').html('');
	var currentForm = $(e).parents('form');
	var result = JSON.parse(localStorage.getItem('form1Result'));
	var data = localStorage.getItem('form1Data');
	if (currentForm.serialize() === data) {
	  	$('#result1').html(result);
	} else {
		alert("Данные с такими параметрами отсутствуют!");
	}
}
