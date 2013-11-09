var rmp;



/* --------------------------------------------------- *\
  SHARED FUNCTIONS
\* --------------------------------------------------- */



//GET QUERY STRINGS
///////////////////////////
function getQueryStrings(){
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}

//ANIMATED SCROLL
/////////////////////////////////////
function animatedScroll(topPosition){
    $('body,html').animate({scrollTop: topPosition}, 500);
}

//WINDOW RESIZE
///////////////////
function resize(w){

    if(w < 768){ //////----PHONE/MINI


    }

    if(w < 1025){ //////----PHONE/MINI/TABLET


    }

    if(w >= 768 && w < 1025){ //////----TABLET


    }

    if(w >= 768){ //////----TABLET/FULL


    }

    if(w >= 1025){ //////----FULL


    }

    if(w < 3000){ //////----EVERYTHING


    }
}

//SPINNER
////////////////////////////////////
function loadSpinner(targetElement){

    var opts = {
          lines: 17, // The number of lines to draw
          length: 10, // The length of each line
          width: 2, // The line thickness
          radius: 22, // The radius of the inner circle
          corners: 1, // Corner roundness (0..1)
          rotate: 0, // The rotation offset
          direction: 1, // 1: clockwise, -1: counterclockwise
          color: '#000', // #rgb or #rrggbb or array of colors
          speed: 1.6, // Rounds per second
          trail: 52, // Afterglow percentage
          shadow: false, // Whether to render a shadow
          hwaccel: false, // Whether to use hardware acceleration
          className: 'spinner', // The CSS class to assign to the spinner
          zIndex: 2e9, // The z-index (defaults to 2000000000)
          top: 'auto', // Top position relative to parent in px
          left: 'auto' // Left position relative to parent in px
    };
    var target = document.getElementById(targetElement);
    var spinner = new Spinner(opts).spin(target);

    return spinner;
}



/* --------------------------------------------------- *\
  DOM READY
\* --------------------------------------------------- */



$(function(){

    //WINDOW VARS
    window.template_url = $('meta[name="template-url"]').attr('content');
    window.base_url = $('meta[name="base-url"]').attr('content');
    window.body = $('body');
    window.win_width = $(window).width();

    //HOME-------->
    if(window.body.hasClass('home')){

        $('header .tip-btn').click(function(){

        });
    }


});



/* --------------------------------------------------- *\
  WINDOW READY
\* --------------------------------------------------- */



$(window).on('load',function(){

    //WINDOW RESIZING SCRIPTS ARE TRIGGERED.
    resize(window.win_width);
    window.initialized = true;
    $(window).resize(function() {

        //RE-DECLARE WIN_WIDTH
        window.win_width = $(window).width();
        resize(window.win_width);

    });

});


