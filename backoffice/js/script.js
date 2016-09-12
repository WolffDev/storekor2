$( document ).ready(function() {
  $('.timepicker').pickatime({
    autoclose: true,
    twelvehour: false,
    donetext: 'Færdig'
  });

  $('.scrollspy').scrollSpy();
  $(window).scroll(function(e){
    var $el = $('.fixedElement');
    var isPositionFixed = ($el.css('position') == 'fixed');
    if ($(this).scrollTop() > 105 && !isPositionFixed){
      $('.fixedElement').css({'position': 'fixed', 'top': '0px'});
    }
    if ($(this).scrollTop() < 105 && isPositionFixed)
    {
      $('.fixedElement').css({'position': 'static', 'top': '0px'});
    }
  });

});
