var frm = $('#form_create_usr');

frm.submit(function (e) {
	e.preventDefault();
	$.ajax({
        type: frm.attr('method'),
        url: frm.attr('action'),
        data: frm.serialize() 
    })
    .done(function(data) {
    	console.log( "success" );
		data = eval("("+data+")");
		if(typeof data.success != "undefined"){
			if(data.success==1){
				//$form[0].reset();
				oTable.draw();
				alertify.alert( data.data );
			}else if(typeof data.errors != "undefined"){
				var error_string = '';
				for(key in data.errors){
					error_string += data.errors[key]+"<br/>";
				}
				alertify.alert( error_string );
			}else{
				alertify.alert( data.data );
			}
		}else{
			alertify.alert("Ocurrió un error durante el proceso");
		}
    })
    .fail(function() {
    })
    .always(function() {
    	console.log( "done" );
    })
});
