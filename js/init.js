(function($) {
    $(function() {

        $('.button-collapse').sideNav({
            menuWidth: 300, // Default is 240
            edge: 'left', // Choose the horizontal origin
            closeOnClick: true // Closes side-nav on <a> clicks, useful for Angular/Meteor
        });
        $('.parallax').parallax();
        $(".dropdown-button").dropdown({
            inDuration: 300,
            outDuration: 225,
            constrain_width: false, // Does not change width of dropdown to that of the activator
            hover: false, // Activate on hover
            gutter: 0, // Spacing from edge
            belowOrigin: true, // Displays dropdown below the button
            alignment: 'left' // Displays dropdown with edge aligned to the left of button
        });
        $('.datepicker').pickadate({
            labelMonthNext: 'Næste måned',
            labelMonthPrev: 'Forrige måned',
            labelMonthSelect: 'Vælg måned',
            labelYearSelect: 'Vælg årstal',
            monthsFull: ['Januar', 'Februar', 'Marts', 'April', 'Maj', 'Juni', 'July', 'August', 'September', 'Oktober', 'November', 'December'],
            monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'Maj', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dec'],
            weekdaysFull: ['Søndag', 'Mandag', 'Tirsdag', 'Onsdag', 'Torsdag', 'Fredag', 'Lørdag'],
            weekdaysShort: ['Søn', 'Man', 'Tir', 'Ons', 'Tor', 'Fre', 'Lør'],
            weekdaysLetter: ['S', 'M', 'T', 'W', 'T', 'F', 'S'],
            today: 'Idag',
            clear: 'Ryd',
            close: 'Luk',
            min: new Date(1930, 1, 1),
            max: new Date(2010, 11, 31),
            selectYears: 120,
            selectMonths: true,
            format: 'Du har valgt!: dddd, !d. d. mmm, yyyy',
            formatSubmit: 'dd-mm-yyyy',
            hiddenName: true
        });

        $('select').material_select();

        // smooth scroll on same page
        $('a[href*=#]:not([href=#])').click(function() {
            if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && location.hostname === this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html,body').animate({
                        scrollTop: target.offset().top
                    }, 2000);
                    return false;
                }
            }
        });

        // Password form live validate
        // source: http://mlitzinger.com/articles/password-validator-js/
        (function(){
            var password = document.querySelector('.password');

            var helperText = {
                charLength: document.querySelector('.helper-text .length'),
                lowercase: document.querySelector('.helper-text .lowercase'),
                uppercase: document.querySelector('.helper-text .uppercase'),
                special: document.querySelector('.helper-text .special')
            };

            var pattern = {
                charLength: function() {
                    if( password.value.length >= 8 ) {
                        return true;
                    }
                },
                lowercase: function() {
                    var regex = /^(?=.*[a-z]).+$/; // Lowercase character pattern

                    if( regex.test(password.value) ) {
                        return true;
                    }
                },
                uppercase: function() {
                    var regex = /^(?=.*[A-Z]).+$/; // Uppercase character pattern

                    if( regex.test(password.value) ) {
                        return true;
                    }
                },
                special: function() {
                    var regex = /^(?=.*[0-9_\W]).+$/; // Special character or number pattern

                    if( regex.test(password.value) ) {
                        return true;
                    }
                }
            };

            // Listen for keyup action on password field
          password.addEventListener('keyup', function (){
                // Check that password is a minimum of 8 characters
                patternTest( pattern.charLength(), helperText.charLength );

                // Check that password contains a lowercase letter
                patternTest( pattern.lowercase(), helperText.lowercase );

                // Check that password contains an uppercase letter
                patternTest( pattern.uppercase(), helperText.uppercase );

                // Check that password contains a number or special character
                patternTest( pattern.special(), helperText.special );

            // Check that all requirements are fulfilled
            if( hasClass(helperText.charLength, 'valid') &&
                      hasClass(helperText.lowercase, 'valid') &&
                        hasClass(helperText.uppercase, 'valid') &&
                      hasClass(helperText.special, 'valid')
                ) {
                    addClass(password.parentElement, 'valid');
            }
            else {
              removeClass(password.parentElement, 'valid');
            }
            });

            function patternTest(pattern, response) {
                if(pattern) {
              addClass(response, 'valid');
            }
            else {
              removeClass(response, 'valid');
            }
            }

            function addClass(el, className) {
                if (el.classList) {
                    el.classList.add(className);
                }
                else {
                    el.className += ' ' + className;
                }
            }

            function removeClass(el, className) {
                if (el.classList)
                        el.classList.remove(className);
                    else
                        el.className = el.className.replace(new RegExp('(^|\\b)' + className.split(' ').join('|') + '(\\b|$)', 'gi'), ' ');
            }

            function hasClass(el, className) {
                if (el.classList) {
                    console.log(el.classList);
                    return el.classList.contains(className);
                }
                else {
                    new RegExp('(^| )' + className + '( |$)', 'gi').test(el.className);
                }
            }

        })();








    }); // end of document ready
})(jQuery); // end of jQuery name space
