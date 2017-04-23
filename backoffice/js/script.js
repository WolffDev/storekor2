$( document ).ready(function() {
  $('.timepicker').pickatime({
    autoclose: true,
    twelvehour: false,
    donetext: 'Færdig'
  });

  $('.scrollspy').scrollSpy();
  $(window).scroll(function(){
    var $el = $('.fixedElement');
    var isPositionFixed = ($el.css('position') === 'fixed');
    if ($(this).scrollTop() > 242 && !isPositionFixed){
      $('.fixedElement').css({'position': 'fixed', 'top': '0px'});
    }
    if ($(this).scrollTop() < 242 && isPositionFixed)
    {
      $('.fixedElement').css({'position': 'static', 'top': '0px'});
    }
  });

  $('.checkbox-info').on('click', function() {
    var check_member = $(this).parent().parent().find("input");
    var absence_id = check_member.data('absence_id');

    if(check_member.prop('checked') === false) {
      $.ajax({
          url: "includes/json/absence.php",
          data:
            {
              "absence": "update",
              "absence_id": absence_id,
              "absence_status": 0

            },
          type: "post",
      });

    } else if(check_member.prop('checked') === true) {

      $.ajax
      ({
          url: "includes/json/absence.php",
          data:
            {
              "absence": "update",
              "absence_id": absence_id,
              "absence_status": 1
            },
          type: "post"
      });
    }

  });


});
