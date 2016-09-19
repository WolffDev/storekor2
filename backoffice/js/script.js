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
    var member_id = check_member.data('member_id');
    var event_id = check_member.data('event_id');
    var deltager_id = check_member.data('deltager_id');

    if(check_member.prop('checked') === false) {
      $.ajax
      ({
          url: "includes/json/deltager.php",
          data:
            {
              "deltager": "add",
              "member_id": member_id,
              "event_id": event_id
            },
          type: "post"
      });

    } else if(check_member.prop('checked') === true) {

      $.ajax
      ({
          url: "includes/json/deltager.php",
          data:
            {
              "deltager": "remove",
              "deltager_id": deltager_id
            },
          type: "post"
      });
    }

  });

});
