$(document).on("click", "#add_input", function() {
	//remove
	$("#textareacontrol").removeClass();
	$("#manycontrol").removeClass();
	$("#radiocontrol").removeClass();
	$("#inputcontrol").removeClass();
	//hides
	$("#textareacontrol").addClass("animated zoomOut");
	$("#textareacontrol").hide();
	$("#manycontrol").addClass("animated zoomOut");
	$("#manycontrol").hide();
	$("#radiocontrol").addClass("animated zoomOut");
	$("#radiocontrol").hide();
	//apper
	$("#inputcontrol").addClass("animated zoomIn");
	$("#inputcontrol").show();
});
$(document).on("click", "#add_textarea", function() {
	//removes
	$("#textareacontrol").removeClass();
	$("#manycontrol").removeClass();
	$("#radiocontrol").removeClass();
	$("#inputcontrol").removeClass();
	//hides
	$("#inputcontrol").addClass("animated zoomOut");
	$("#inputcontrol").hide();
	$("#manycontrol").addClass("animated zoomOut");
	$("#manycontrol").hide();
	$("#radiocontrol").addClass("animated zoomOut");
	$("#radiocontrol").hide();
	//appear
	$("#textareacontrol").addClass('animated zoomIn');
	$("#textareacontrol").show();
});
$(document).on("click", "#add_checkbox", function() {
	//removes
	$("#textareacontrol").removeClass();
	$("#manycontrol").removeClass();
	$("#radiocontrol").removeClass();
	$("#inputcontrol").removeClass();
	//hides
	$("#inputcontrol").addClass("animated zoomOut");
	$("#inputcontrol").hide();
	$("#textareacontrol").addClass("animated zoomOut");
	$("#textareacontrol").hide();
	$("#radiocontrol").addClass("animated zoomOut");
	$("#radiocontrol").hide();

	//appear
	$('#manycontrol').addClass('animated zoomIn');
	$('#manycontrol').show();

});
$(document).on("click", "#add_radio", function() {
	//removes
	$("#textareacontrol").removeClass();
	$("#manycontrol").removeClass();
	$("#radiocontrol").removeClass();
	$("#inputcontrol").removeClass();
	//hides
	$("#inputcontrol").addClass("animated zoomOut");
	$("#inputcontrol").hide();
	$("#manycontrol").addClass("animated zoomOut");
	$("#manycontrol").hide();
	$("#textareacontrol").addClass("animated zoomOut");
	$("#textareacontroltextareacontrol").hide();
	//appear
	$("#radiocontrol").addClass('animated zoomIn');
	$("#radiocontrol").show();
});

$(document).on("click", "#btnSave_check", function (e){
	e.preventDefault(); 
	
	var pregunta = $("#preguntachecks").val();
	var cuantos = $('#manychecks').val();
	var container = $('#elements');
	var inputs = container.find('input');
	var id = inputs.length+1;
    var myid = pregunta.replace(/ /g,'');

    $("#elements").append('<br />');
	$('#elements').append('<div class="form-check" id="'+myid+'">');

	var nuevo = $(myid);    
	for (var i = 1; i <= cuantos; i++) {
		if(i==1){
			$("#"+myid).append('<strong>'+pregunta+'</strong>');
			console.log('hola');
		}
		$('<input />', { type: 'radio', class:'form-check-input' , id: 'cb'+id, value: 'name' }).appendTo("#"+myid);
		$('<label />', { 'for': 'cb'+id, class: 'form-check-label', text: 'name' }).appendTo("#"+myid);
	}
});

$(document).on("click", "#btnSave_input", function(e){
	e.preventDefault(); 
	
	var pregunta  = $("#preguntainput").val();
	var container = $('#elements');
	var inputs    = container.find('input');
	var id        = inputs.length+1;
	var myid      = pregunta.replace(/ /g,'');

	$("#elements").append('<br />');
	$('#elements').append('<div class="md-form form-sm" id="'+myid+'">');

	var nuevo = $(myid);
	$('<input />', { type: 'text', class:'form-control ' , id: 'cb'+id }).appendTo("#"+myid);
	$('<label />', { 'for': 'cb'+id, text: pregunta }).appendTo("#"+myid);

});

$(document).on("click", "#btnSave_textarea", function (e){
	e.preventDefault(); 
	var pregunta = $("#preguntatext").val();
	var container = $('#elements');
	var inputs    = container.find('input');
	var id        = inputs.length+1;
	var myid      = pregunta.replace(/ /g,'');

	$("#elements").append('<div class="md-form" id="'+myid+'">');
	
	var nuevo = $(myid);

	$('<textarea  />', { type: 'text', class:'form-control md-textarea' , id: 'cb'+id }).appendTo("#"+myid);
	$('<label />', { 'for': 'textareaBasic', text: pregunta }).appendTo("#"+myid);

 
});

$(document).on("click", "#btnSave_radio", function (e){
	e.preventDefault(); 
	var pregunta = $("#preguntaradio").val();
	var container = $('#elements');
	var inputs    = container.find('input');
	var id        = inputs.length+1;
	var myid      = pregunta.replace(/ /g,'');

});


//funciones
function addCheckbox(name) {

   var container = $('#cblist');
   var inputs = container.find('input');
   var id = inputs.length+1;

   $('<input />', { type: 'checkbox', id: 'cb'+id, value: name }).appendTo(container);
   $('<label />', { 'for': 'cb'+id, text: name }).appendTo(container);
}