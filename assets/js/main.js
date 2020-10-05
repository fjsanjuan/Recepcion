$(document).ready(function() {
   $("form_orden_servicio").keypress(function(e) {
        if (e.which == 13) {
            return false;
        }
    });
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
          
          if(typeof data.success != "undefined")
          {
            if(data.success == 1)
            {

              location.href = data.href;

            }else if(typeof data.errors != "undefined"){
              var error_string = '';
              for(key in data.errors)
              {
                error_string += data.errors[key]+"<br/>";
              }
              swal({
                icon: 'warning',
                html: error_string,
              });
            }else
            {
              swal({
                icon: 'error',
                text: data.data
              });
            }
          }else
          {
            swal({
              type : 'error',
              text: data.data
            });
          }
        })
        .fail(function() {
          alert("Hubo un error al iniciar sesión");
        });
    });

    $("#orden_horario, #cita_horario").on("contentChanged", function() {
        $(this).material_select();
    });

    function llenar_selectHorario()
    {
        $.ajax({
        cache: false,
        url: site_url+"buscador/ver_horariosAg",
        dataType: 'json',
        })
        .done(function(data) {
            var opc = "";

            $.each(data, function(index, val) {
              opc += "<option value='"+val["Hora"]+"'>"+val["Hora"]+"</option>";
            });

            $("#orden_horario, #cita_horario").html(opc);
            $("#orden_horario, #cita_horario").trigger("contentChanged");
        })
        .fail(function() {
            alert("Hubo un error al mostrar los horarios");
        });
    }

    llenar_selectHorario();

    function abrirNav()
    {
      $("#menu_sidebar").show();
    }

    function cerrarNav()
    {
      $("#menu_sidebar").hide();
    }

    $("#icono_sidebar").on("click", function(){
        abrirNav();
    });

    $(".closebtn").on("click", function(){
        cerrarNav();
    });
});



