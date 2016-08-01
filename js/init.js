(function($){
  $(function(){

    $('.button-collapse').sideNav({
        menuWidth: 300, // Default is 240
        edge: 'left', // Choose the horizontal origin
        closeOnClick: true // Closes side-nav on <a> clicks, useful for Angular/Meteor
        }
    );
    $('.parallax').parallax();
    $(".dropdown-button").dropdown({
        inDuration: 300,
        outDuration: 225,
        constrain_width: false, // Does not change width of dropdown to that of the activator
        hover: false, // Activate on hover
        gutter: 0, // Spacing from edge
        belowOrigin: true, // Displays dropdown below the button
        alignment: 'left' // Displays dropdown with edge aligned to the left of button
      }
    );
    $('.datepicker').pickadate({
      labelMonthNext: 'Næste måned',
      labelMonthPrev: 'Forrige måned',
      labelMonthSelect: 'Vælg måned',
      labelYearSelect: 'Vælg årstal',
      monthsFull: [ 'Januar', 'Februar', 'Marts', 'April', 'Maj', 'Juni', 'July', 'August', 'September', 'Oktober', 'November', 'December' ],
      monthsShort: [ 'Jan', 'Feb', 'Mar', 'Apr', 'Maj', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dec' ],
      weekdaysFull: [ 'Søndag', 'Mandag', 'Tirsdag', 'Onsdag', 'Torsdag', 'Fredag', 'Lørdag' ],
      weekdaysShort: [ 'Søn', 'Man', 'Tir', 'Ons', 'Tor', 'Fre', 'Lør' ],
      weekdaysLetter: [ 'S', 'M', 'T', 'W', 'T', 'F', 'S' ],
      today: 'Idag',
      clear: 'Ryd',
      close: 'Luk',
      min: new Date(1930,1,1),
      max: new Date(2010,11,31),
      selectYears: 120,
      selectMonths: true,
      format: 'Du har valgt!: dddd, !d. d. mmm, yyyy',
      formatSubmit: 'dd-mm-yyyy',
      hiddenName: true
    });

    $('select').material_select();

    // smooth scroll on same page
    $('a[href*=#]:not([href=#])').click(function() {
      if (location.pathname.replace(/^\//,'') === this.pathname.replace(/^\//,'') && location.hostname === this.hostname) {
        var target = $(this.hash);
        target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
        if (target.length) {
          $('html,body').animate({
            scrollTop: target.offset().top
          }, 2000);
          return false;
          }
        }
      }
    );

  }); // end of document ready
})(jQuery); // end of jQuery name space
