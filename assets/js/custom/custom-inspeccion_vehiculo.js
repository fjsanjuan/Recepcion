// Tooltips Initialization
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

// Steppers
$(document).ready(function () {
  var navListItems = $('div.setup-panel-2 div a'),
          allWells = $('.setup-content-2'),
          allNextBtn = $('.nextBtn-2'),
          allPrevBtn = $('.prevBtn-2');

  allWells.hide();

  navListItems.click(function (e) {
      e.preventDefault();
      var $target = $($(this).attr('href')),
              $item = $(this);

      if (!$item.hasClass('disabled')) {
          navListItems.removeClass('btn-amber').addClass('btn-blue-grey');
          $item.addClass('btn-amber');
          allWells.hide();
          $target.show();
          $target.find('input:eq(0)').focus();
      }
  });

  allPrevBtn.click(function(){
      var curStep = $(this).closest(".setup-content-2"),
          curStepBtn = curStep.attr("id"),
          prevStepSteps = $('div.setup-panel-2 div a[href="#' + curStepBtn + '"]').parent().prev().children("a");

          prevStepSteps.removeAttr('disabled').trigger('click');
  });

  allNextBtn.click(function(){
      var curStep = $(this).closest(".setup-content-2"),
          curStepBtn = curStep.attr("id"),
          nextStepSteps = $('div.setup-panel-2 div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
          curInputs = curStep.find("input[type='text'],input[type='url']"),
          isValid = true;

      $(".form-group").removeClass("has-error");
      for(var i=0; i< curInputs.length; i++){
          if (!curInputs[i].validity.valid){
              isValid = false;
              $(curInputs[i]).closest(".form-group").addClass("has-error");
          }
      }
      if (isValid)
          nextStepSteps.removeAttr('disabled').trigger('click');
  });

  $('div.setup-panel-2 div a.btn-amber').trigger('click');
});

//gas
var $myFuelGauge;

$( function () {
  $myFuelGauge = $("#fuel-gauge").dynameter({
    width: 200 ,
    label: 'tanque',
    value: 4,
    min: 0,
    max: 8,
    unit: 'octavos',
    regions: { // Value-keys and color-refs
      0: 'error',
      2: 'warn',
      4: 'normal'
    }
  });

  // jQuery UI slider widget
  $('#fuel-gauge-control').slider({
    min: 0,
    max: 8,
    value: 4 ,
    step: 1,
    slide: function (evt, ui) {
      $myFuelGauge.changeValue((ui.value).toFixed(1));
    }
  });

});
$(document).ready(function () {
    var $o, os;

    //generate toolbar
    var $toolbar = $(".toolbar");
    $.each(tools, function (i, tool) {
        $("<img>", tool).appendTo($toolbar);
    });
    var $tools = $toolbar.find("img");

    //define drag and drop handlers
    $toolbar.on("dragstart", "img", onDrag);
    $(".canvas").on({
        dragenter: false,
        dragover: false,
        drop: onDrop
    });

    //handle commencement of drag
    function onDrag(e) {
        $o = $(this).clone();
        var o = e.originalEvent;
        o.effectAllowed = "copy";
        os = { X: o.offsetX, Y: o.offsetY };
    }

    //handle drop
    function onDrop(e) {
        e.preventDefault();
        var o = e.originalEvent;
        var pos = { left: o.offsetX - os.X, top: o.offsetY - os.Y };
        $o.css(pos);
        $(this).append($o);
        //***DATABASE example:-
        // (1) Create dataset, e.g. JSON:-
        var data = {
            id: $o.data("id"),
            description: $o.data("description"),
            position: pos
        };
        // (2) Send (JSON) data to SQL webservice using AJAX POST:-   
        //$.post("sqlwebservice.ashx", data);
        return false;
    }
});

  //define toolset (JSON, e.g. from database)...
  var tools = [{
      "data-id": 1,
      alt: "Golpe",
      title: "Golpe",
      src: "https://api.intelisis-solutions.com/canvas/explode.png",
      "data-description": "golpe"
  }, {
      "data-id": 2,
      alt: "rayon",
      title: "rayon",
      src: "https://api.intelisis-solutions.com/canvas/rayo.png",
      "data-description": "rayon"
  }];

  $(document).on('click', '#saveCar', function(){

  });


