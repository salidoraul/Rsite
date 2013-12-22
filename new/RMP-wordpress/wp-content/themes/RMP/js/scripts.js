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

//GOOGLE MAP API
////////////////////////////////////////////////
function initialize_map(lat,lon,bubbleHtml){

    var infoBubble,
    icon = template_url + '/images/rmp-pin.png';

    // Geolocation function.
    function geolocation(lat,lon){
        return new google.maps.LatLng(lat,lon);
    }

    // Geolocation vars.
    var loc = geolocation(lat, lon),
        ibLoc = geolocation( parseFloat(lat) + .0015, lon),
        centerLoc = geolocation( parseFloat(lat) + .004 , lon);

    // Create an array of styles.
    var styles = [
    {
        "stylers": [
          { "hue": "#7079ce" },
          { "saturation": -100 },
          { "lightness": -5 },
          { "gamma": 0.90 }
        ]
    },{
        featureType: "road"
    },
    {
        "elementType": "labels.icon",
        "stylers": [
          { "hue": "#bf358e" }
        ]
    },
    {
        "elementType": "labels.text.fill",
        "stylers": [
          { "hue": "#bf358e" }
        ]
      },{
        "elementType": "labels.text.stroke",
        "stylers": [
          { "hue": "#bf358e" }
        ]
      }
    ];

    // Style the map.
    var styledMap = new google.maps.StyledMapType(styles,{name: "Styled Map"});

    // Create a map object.
    var mapOptions = {
        zoom: 15,
        scrollwheel: false,
        center: centerLoc,
        disableDefaultUI: true,
        mapTypeControlOptions: {
        mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']
    }
    };
    var map = new google.maps.Map(document.getElementById('map-canvas'),
    mapOptions);

    // Associate the styled map.
    map.mapTypes.set('map_style', styledMap);
    map.setMapTypeId('map_style');

    // Set marker.
    marker = new google.maps.Marker({
        map: map,
        draggable: false,
        position: loc
    });
    iconFile = icon;
    marker.setIcon(iconFile);

    //Custom info bubble content.
    var bubbleContent = '<div class="info-bubble"><div class="info-bubble-top"><span id="close" class="glyphicon glyphicon-remove"></span></div><div class="info-bubble-content">'+ bubbleHtml +'</div></div>';

    //Construct info bubble.
    infoBubble = new InfoBubble({
        maxWidth: 260,
        map: map,
        content: bubbleContent,
        position: ibLoc,
        shadowStyle: 1,
        padding: 0,
        backgroundColor: '#333333',
        borderWidth: 0,
        borderRadius: 0,
        hideCloseButton: true
    });

    setTimeout(function(){
        infoBubble.open();
    },500);

    // Info Bubble controls.
    setTimeout(function(){
        google.maps.event.addListener(marker, 'click', function() {
            if (!infoBubble.isOpen()) {

                infoBubble.open();
                //Run DOMListeners on re-init.
                setTimeout(function(){
                    DOMListeners();
                },500)

            } else {

                infoBubble.close();
            }
        });

        //DOM Listeners function.
        function DOMListeners(){
            var close = document.getElementById('close');
            google.maps.event.addDomListener(close, 'click', function() {
                infoBubble.close();
            });

        }

        //Run DOM listeners.
        DOMListeners();

    },1650);

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
            altSource: 'http://www.randymurrayproductions.com/RMP-wordpress/wp-content/themes/RMP/video/rmp-video.ogv'
        });
    }

    //AJAX PAGE LOADING /////////////
    $('.st-menu a').click(function(){

        var url = $(this).attr('href');

        $('.st-pusher').trigger('click');
        $.ajax({
            url: url,
            beforeSend: function(){

                window.previous_slug = $('meta[name="the-slug"]').attr('content');

                //SPIN & REMOVE
                setTimeout(function(){
                    loadSpinner('ajaxy');
                    $('.main').addClass('out');
                },500);

            },
            success: function(response){

                setTimeout(function(){

                    var slug = $(response).find('meta[name="the-slug"]').attr('content'),
                        title = $(response).find('title').text(),
                        html = $(response).find('.main').html();

                    //REMOVE SPIN
                    $('.spinner').remove();
                    //ADD ITEMS
                    console.log(html);
                    console.log(window.previous_slug);
                    console.log(slug);
                    console.log(title);

                    document.title = title;
                    $('body').removeClass(window.previous_slug).addClass(slug);
                    $('#ajaxy').html(html);
                },750);
            },
            complete: function(){

            }
        });

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

        //LOAD VIDEO GALLERY THUMBS/////////////
        $('.accordion-toggle').click(function(){

            var service_type = $(this).attr('ajax-data'),
                current_tab = '.accordion-toggle.' + service_type,
                service_url = base_url + '/what-we-do/?serv=' + service_type + '&thumbs=1&auth=y';

            //AJAX THUMBS//////////////////////////////////////
            $('#services').on('shown.bs.collapse', function() {

                //ONLY FOR NON-LOADED ITEMS
                if( !$(current_tab).hasClass('loaded') ){

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

                            $(current_tab).addClass('loaded');

                            //SCROLLBAR
                            var these_thumbs = $('#thumbs-container-' + service_type + ' .thumb-item'),
                                count = these_thumbs.size(),
                                width = these_thumbs.width() + 2.5,
                                result = count * width;
                            $('#thumbs-container-' + service_type + ' .thumbs-content').css('width',result);

                            //HEIGHT ON IMG LOAD
                            var thumb_obj = these_thumbs.find('img');
                            thumb_obj.on('load',function(){
                                var height = these_thumbs.height() + 10;
                                $('#thumbs-container-' + service_type).animate({height: height}).perfectScrollbar();
                            });

                            //AJAX FOR VIDEO GALLERY PROJECT ///////////////////////////////////////////////
                            $('.thumbs-container .thumb-item').click(function(){

                                if( !$(this).hasClass('active') ){

                                    $('.thumbs-container .thumb-item').removeClass('active');
                                    $(this).addClass('active');

                                    //VARS
                                    var _this = $(this),
                                        project_id = _this.attr('href'),
                                        project_cont = _this.parent().parent().siblings('.project-details').attr('id'),
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

                                            //SCROLLTO
                                            setTimeout(function(){
                                                var os = _this.offset().top;
                                                animatedScroll(os);
                                            },500);

                                        }
                                    });

                                }

                                return false;

                            });
                        }
                    });
                }
            });
        });

        //EXPAND WITH QUERY STRING
        queryStringPanel('s');

    }

    //WHO WE ARE-------->
    if(window.body.hasClass('who-we-are')){

        //TEAM MODULE
        $('.team-module .team-thumb').click(function(){

            var data = $(this).attr('data-filter'),
                item_h = $('.team-items').height();

            if( !$(this).hasClass('active') ){

                $('.team-module .team-thumb').removeClass('active');
                $(this).addClass('active');

                //BLUR AND REPLACE TEAM ITEMS
                $('.team-items').css('height',item_h);
                $('.team-items .blur-container').addClass('blurred');
                setTimeout(function(){
                    $('.team-item').hide();
                    $('.team-item.' + data).show();
                    $('.team-items').css('height','auto');
                    $('.team-items .blur-container').removeClass('blurred');
                },1000);
            }

        });

    }

    //CONTACT---------->
    if(window.body.hasClass('contact')){

        //SERVE MAPS BASED ON LOCATIONS
        $('.location-item').click(function(){

            var lat_lon = $(this).attr('data-filter').split(','),
                address = $(this).find('.address-container').html(),
                offset = $(this).offset().top;

            if( !$(this).hasClass('active') ){
                $('.locations .location-item').removeClass('active');
                $(this).addClass('active');

                //SLIDE
                $('.map-slider').addClass('slide');

                setTimeout(function(){
                    initialize_map(lat_lon[0],lat_lon[1],address);
                    animatedScroll(offset);
                    $('.map-slider').removeClass('slide');
                },500);
            }
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

    //CONTACT---------->
    if(window.body.hasClass('contact')){

        //INITIALIZE PHX
        var phx_coor = $('.phx.location-item').attr('data-filter').split(','),
            phx_address = $('.phx.location-item').find('.address-container').html();

        $('.phx.location-item').addClass('active');
        initialize_map(phx_coor[0],phx_coor[1],phx_address);
    }

});


