 $(document).ready(function(){
 	console.log('resumen');

 	var id = $("#id_c").val();
    var tipo =$("#tipo_c").val();

    $("#proceder_update").on("click", function(e){
        e.preventDefault();
        console.log('clic');
        $("body").load( site_url+"user/actualizar_datos", { id: id, tipo: tipo } );
    });

    $("#proceder_c").on("click", function(e){
        e.preventDefault();
        console.log('clic 2');
        $("body").load( site_url+"buscador/resultados", { id: id, tipo: tipo } );
    });



 });