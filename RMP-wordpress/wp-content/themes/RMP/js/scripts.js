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

//EXPAND PANEL /////////////////////
function queryStringPanel(queryString){
    var panelSelector = getQueryStrings()[queryString];
    setTimeout(function(){
        $('.panel a.accordion-toggle.'+ panelSelector).trigger('click');
    },500);
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
          color: '#FFF', // #rgb or #rrggbb or array of colors
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

    //VIDEO BG /////////////////////////////////////////
    if (!Modernizr.touch){
        var BV = new $.BigVideo({useFlashForFirefox:false});
        BV.init();
        BV.show('http://www.randymurrayproductions.com/RMP-wordpress/wp-content/themes/RMP/video/rmp-video.mp4',{
            ambient: true,
            altSource: 'http://www.randymurrayproductions.com/RMP-wordpress/wp-content/themes/RMP/video/rmp.oggtheora.ogv'
        });
    }

    //NAV
    $('.st-menu a').click(function(){

        var url = $(this).attr('href');
        $('.st-pusher').trigger('click');

        ///////AJAX FUNCTION GOES HERE

        return false;
    });

    //NAV CONTACT
    $('header .tip-btn').click(function(){

        var data = $(this).attr('data');

        if( $(this).hasClass('active') ){
            $('.tip-btn').removeClass('active');

            $('.contact-tip').slideUp('fast');

        }else{
            $('.tip-btn').removeClass('active');
            $(this).addClass('active');

            $('.contact-tip').slideUp('fast');
            setTimeout(function(){
                $('.contact-tip.' + data).slideDown('fast');
            },250);
        }

        return false;
    });

    //HOME-------->
    if(window.body.hasClass('home')){

    }

    //WHAT WE DO-------->
    if(window.body.hasClass('what-we-do')){

        //LOAD VIDEO GALLERY THUMBS
        $('.accordion-toggle').click(function(){

            if( !$(this).hasClass('loaded') ){

                var service_type = $(this).attr('ajax-data'),
                    service_url = base_url + '/what-we-do/?serv=' + service_type + '&thumbs=1&auth=y';

                //AJAX THUMBS//////////////////////////////////////
                $('#services').on('shown.bs.collapse', function() {

                    //GET THUMBS
                    $.ajax({
                        url: service_url,
                        beforeSend: function(){

                            //SPIN
                            loadSpinner('thumbs-container-' + service_type);

                        },
                        success: function(response){

                            var html = $(response).find('.the-thumbs').html();

                            //REMOVE SPIN
                            $('.spinner').remove();

                            //ADD ITEMS
                            $('#thumbs-container-' + service_type + ' .thumbs-content').html(html);

                        },
                        complete: function(){

                            //SCROLLBAR
                            var these_thumbs = $('#thumbs-container-' + service_type + ' .thumb-item'),
                                count = these_thumbs.size(),
                                width = these_thumbs.width() + 2.5,
                                height = these_thumbs.height() + 10,
                                result = count * width;
                            $('#thumbs-container-' + service_type + ' .thumbs-content').css('width',result);
                            $('#thumbs-container-' + service_type).animate({height: height}).perfectScrollbar();

                            //ADD 'LOADED' CLASS
                            $('.accordion-toggle.' + service_type).addClass('loaded');

                            //AJAX FOR VIDEO GALLERY PROJECT ///////////////////////////////////////////////
                            $('.thumbs-container .thumb-item').click(function(){

                                if( !$(this).hasClass('active') ){

                                    $('.thumbs-container .thumb-item').removeClass('active');
                                    $(this).addClass('active');

                                    //VARS
                                    var project_id = $(this).attr('href'),
                                        project_cont = $(this).parent().parent().siblings('.project-details').attr('id'),
                                        project_url = base_url + '/what-we-do/?proj=' + project_id + '&auth=y';

                                    //GRAB SPECIFIC PROJECT
                                    $.ajax({
                                        url: project_url,
                                        beforeSend: function(){

                                            //SPIN
                                            loadSpinner(project_cont);
                                            //BLUR
                                            $('#' + project_cont + ' .blur-container').addClass('blurred');

                                        },
                                        success: function(response){

                                            var html = $(response).find('.the-project').html();

                                            //REMOVE SPIN
                                            $('.spinner').remove();
                                            //ADD ITEMS & REMOVE BLUR
                                            $('#' + project_cont + ' .blur-container').html(html).removeClass('blurred');

                                        },
                                        complete: function(){

                                            $(this).addClass('loaded');

                                        }
                                    });

                                }

                                return false;

                            });
                        }
                    });
                });
            }
        });

        //EXPAND WITH QUERY STRING
        queryStringPanel('s');

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


