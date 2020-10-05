$(document).ready(function(){

var frm = $('#form_login');

    frm.submit(function (e) {
        e.preventDefault();
        $.ajax({
          type: frm.attr('method'),
          url: frm.attr('action'),
          data: frm.serialize()
        })
        .done(function(data){
          data = eval("("+data+")");
          if(typeof data.success != "undefined"){
            if(data.success == 1){
              //alertify.success(data.data);
              swal({
                icon: 'success',
                text: data.data
              });
            location.href = data.href;  
            }else if(typeof data.errors != "undefined"){
              var error_string = '';
              for(key in data.errors){
                error_string += data.errors[key]+"<br/>";
              }
              //alertify.alert( error_string );
              swal({
                icon: 'warning',
                text: error_string,
                html: true
              });
            }else{
              //alertify.error( data.data );
              swal({
                icon: 'error',
                text: data.data
              });
            }
          }else{
            //alertify.error( data.data );
            swal({
              type : 'error',
              text: data.data
            });
          }
        })
        .fail(function() {
        })
        .always(function() {
          console.log( "complete" );
          //$(".loader").fadeOut("slow");
        });
    });
});