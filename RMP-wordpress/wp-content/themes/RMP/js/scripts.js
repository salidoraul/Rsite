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

    if(w < 1024){ //////----PHONE/MINI/TABLET


    }

    if(w >= 768 && w < 1024){ //////----TABLET


    }

    if(w >= 768){ //////----TABLET/FULL


    }

    if(w >= 1024){ //////----FULL


    }

    //////----EVERYTHING

        //NAV SCROLLBAR
        var nav_logo_h = $('.nav-logo-link').outerHeight(),
            main_menu_h = $('.off-canvas-nav #menu-main').outerHeight(),
            win_h = $(window).height(),
            nav_h = (win_h < (nav_logo_h + main_menu_h)) ? win_h - nav_logo_h : main_menu_h ;

        $('.menu-main-container').css('height',nav_h).perfectScrollbar('update');

}

//LOAD SCRIPT
//////////////////////////
function load_script(src){
    var script = document.createElement('script');
    script.type = 'text/javascript';
    script.src = src;
    document.body.appendChild(script);
}

//SPINNER
////////////////////////////////////
function loadSpinner(targetElement, offset){
    var offset_top = offset || 'auto';
    var opts = {
          lines: 17, // The number of lines to draw
          length: 10, // The length of each line
          width: 2, // The line thickness
          radius: 22, // The radius of the inner circle
          corners: 1, // Corner roundness (0..1)
          rotate: 0, // The rotation offset
          direction: 1, // 1: clockwise, -1: counterclockwise
          color: '#9AA5E8', // #rgb or #rrggbb or array of colors
          speed: 1.6, // Rounds per second
          trail: 52, // Afterglow percentage
          shadow: true, // Whether to render a shadow
          hwaccel: false, // Whether to use hardware acceleration
          className: 'spinner', // The CSS class to assign to the spinner
          zIndex: 2e9, // The z-index (defaults to 2000000000)
          top: offset_top, // Top position relative to parent in px
          left: 'auto' // Left position relative to parent in px
    };
    var target = document.getElementById(targetElement);
    var spinner = new Spinner(opts).spin(target);

    return spinner;
}

//GOOGLE MAP API
////////////////////////////////////////////////
function initialize_map(lat,lon,bubbleHtml,google_map_link){

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
        disableDoubleClickZoom: true,
        zoomControl: false,
        scaleControl: false,
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
    var bubbleContent = '<div class="info-bubble"><div class="info-bubble-top"><span id="close" class="glyphicon glyphicon-remove"></span></div><div class="info-bubble-content">'+ bubbleHtml +'<a class="directions" target="_blank" href="http://maps.google.com/?q='+ google_map_link +'">Get Directions</a></div></div>';

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

//INITIALIZE PHX FUNCTION
function initialize_map_phx(){

    setTimeout(function(){
        var phx_item = $('.phx.location-item'),
            phx_coor = phx_item.attr('data-filter').split(','),
            phx_address = phx_item.find('.address-container').html(),
            phx_address_string = phx_item.find('.address').text();

        phx_item.addClass('active');
        initialize_map(phx_coor[0],phx_coor[1],phx_address,phx_address_string);
    },1000);
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

    //NAV BTN
    $('header .nav-btn, .nav-cover').click(function(){

        var html = $('html'),
            outer_cont = $('.outer-container'),
            v = $('#big-video-wrap');

        //IF MENU ISN'T OPEN
        if(!html.hasClass('menu-open')){
            html.addClass('menu-open height-control');
            outer_cont.fadeOut();

            if( v.hasClass('faded') ){
                v.fadeIn();
            }

        }else{
        //IF MENU IS OPEN

            html.removeClass('menu-open');
            outer_cont.fadeIn();

            if( v.hasClass('faded') ){
                v.fadeOut();
            }

            //FADE IN AJAXY
            var a = $('#ajaxy');
            if( a.hasClass('faded') ){
                a.show().removeClass('faded');
                $('header .loop-btn').removeClass('active');
            }

            setTimeout(function(){
                html.removeClass('height-control');
            },1000);
        }
    });

    //NAV
    $('.menu-main-container').perfectScrollbar();

    //LOOP BTN
//    $('header .loop-btn').on('click',function(){
//        var ajaxy = $('#ajaxy');
//        if( ajaxy.hasClass('faded') ){
//            ajaxy.fadeIn().removeClass('faded');
//            $(this).removeClass('active');
//
//            if( $('#big-video-wrap').hasClass('faded') ){
//                $('#big-video-wrap').fadeOut();
//            }
//
//        }else{
//            ajaxy.fadeOut().addClass('faded');
//            $(this).addClass('active');
//
//            if( $('#big-video-wrap').hasClass('faded') ){
//                $('#big-video-wrap').fadeIn();
//            }
//        }
//    });

    //AJAX PAGE LOADING /////////////
    $('.nav-logo-link, .off-canvas-nav a, .home nav.home-nav a, header .header-logo, a.btn-page-link').click(function(e){

        var html = $('html');

        //AJAX IS ONLY FOR RECENT BROWSERS
        if (history && !html.hasClass('ie8') && !html.hasClass('ie7') && !html.hasClass('ie6')) {

            //VARS
            var simple_url = $(this).attr('href'),
                s = simple_url.split('?tab='),
                count_s = s.length;

            if(count_s > 1){
                var s_url = s[0],
                    s_panel = s[1];
            }

            //DEFINE URL WITH OR WITHOUT S
            var url = (s_panel == undefined) ? simple_url : s_url;

            //PREVENT
            e.preventDefault();

            var History = window.History;

            //HISTORY
            if(history.pushState){
                history.pushState(null, document.title, this.href);
            }else{
                History.pushState(null, document.title, this.href.toString());
            }

            //AJAX CALL
            html.removeClass('menu-open');
            setTimeout(function(){
                html.removeClass('height-control');
            },1000);

            $.ajax({
                url: url,
                beforeSend: function(){

                    //PREV PAGE
                    window.previous_page = $('#ajaxy').attr('slug');

                    //FADE OUTER CONT & AJAXY
                    if( $('#ajaxy').hasClass('faded') ){
                        $('#ajaxy').show().removeClass('faded');
                        $('header .loop-btn').removeClass('active');
                    }
                    $('.outer-container').fadeIn();

                    //SPIN & REMOVE
                    setTimeout(function(){
                        w = $(window).width();
                        if(w < 768){
                            loadSpinner('ajaxy','30%');
                        }else{
                            loadSpinner('ajaxy');
                        }
                        $('#ajaxy .main').animate({left: '-120%'})
                    },500);

                },
                success: function(response){

                    var title = $(response).filter('title').text(),
                        page_class = $(response).find('#ajaxy').attr('slug'),
                        html = $(response).find('#ajaxy').html();

                    setTimeout(function(){
                        var ajaxy = $('#ajaxy');

                        $('html').addClass('height-control');
                        $('#ajaxy .main').css('left', '120%');
                        setTimeout(function(){
                            $('html').removeClass('height-control');
                        },1000);

                        //REMOVE SPIN
                        $('.spinner').remove();

                        //ADD ITEMS
                        document.title = title;
                        $(window.body).removeClass(window.previous_page).addClass(page_class);
                        $('#ajaxy').attr('slug',page_class);
                        ajaxy.hide().html(html);
                    },750);

                },
                complete: function(){

                    //UNBIND
                    $('*').unbind();

                    setTimeout(function(){
                        $('#ajaxy').fadeIn();
                        $.getScript(template_url + '/js/scripts.js');
                    },900);
                }
            });

            //TRACK PAGE VIEW
            if(typeof _gaq!='undefined'){
                _gaq.push(['_trackPageview',  simple_url]);
            }
        }
    });

    //POPSTATE
    if(!$('html').hasClass('ie')){
        $(window).bind("popstate", function(e) {
            if (window.historySingleton === '1') {
                window.location = "http://" + window.location.host + location.pathname;
            } else {
                window.historySingleton = '1';
            }
        });
    }

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

    //WHAT WE DO GREY BG-------->
    if(window.body.hasClass('what-we-do')){
        $('html').addClass('grey');
    }else{
        $('html').removeClass('grey');
    }

    //WHAT WE DO & WHO WE ARE-------->
    if(window.body.hasClass('what-we-do') || window.body.hasClass('who-we-are')){

        //ACCORDION FUNCTION
        function accordion(t,callback){
            var _this = t,
                data = _this.attr('ajax-data'),
                panel = $('#' + data + '.panel-collapse');

            $('.right-window').show();

            if( _this.hasClass('collapsed') ){
                $('.accordion-toggle').addClass('collapsed');
                _this.removeClass('collapsed');
            }else{
                _this.addClass('collapsed');
            }

            $('.panel-collapse.in').collapse('hide');
            panel.collapse('toggle');

            //CALLBACK
            if(callback){
                callback();
            }
        }

        //RIGHT WINDOW FUNCTION
        function rightWindow(status,t,type,callback){

            //CLOSE
            if( status === 'close'){

                if( type === 'different' ){

                    var _this = t,
                        _this_panel_id = _this.attr('href'),
                        a_with_window = $('.accordion-toggle.with-window:not(collapsed)'),
                        panel_with_window_id = a_with_window.attr('href'),
                        rw = $(panel_with_window_id + '.panel-collapse .right-window');

                    rw.fadeOut();
                    setTimeout(function(){
                        a_with_window.addClass('collapsed');
                        $(panel_with_window_id + '.panel-collapse').collapse('hide');
                        _this.removeClass('collapsed');
                        $(_this_panel_id).collapse('show');
                        $('.tabs-container').removeClass('open-window');
                    },500);

                }else if( type === 'same' ){

                    var _this = t,
                        data = _this.attr('ajax-data'),
                        rw = $('.project-details.right-window');

                    rw.fadeOut();
                    setTimeout(function(){
                        if( _this.hasClass('collapsed') ){

                            var open_panel_id = $('.panel-collapse.in').attr('id'),
                                panel_id = _this.attr('ajax-data'),
                                panel = $('#' + panel_id + '.panel-collapse');

                            $('#' + open_panel_id + '.panel-collapse').collapse('hide');
                            $('.accordion-toggle.' + open_panel_id).addClass('collapsed');

                            panel.collapse('show');
                            _this.removeClass('collapsed');
                            setTimeout(function(){
                                $('#details-container-' + panel_id + '.right-window').fadeIn();
                                $('.tabs-container').addClass('open-window');
                            },500);

                        }else{

                            var this_panel_id = _this.attr('ajax-data'),
                                this_panel = $('#' + this_panel_id + '.panel-collapse');

                            this_panel.collapse('hide');
                            _this.addClass('collapsed');
                            $('.tabs-container').removeClass('open-window');

                        }
                    },500);

                }

            }else if( status === 'open' ){
            //OPEN

                var _this = t,
                    id = _this.attr('ajax-data'),
                    panel = $('#' + id + '.panel-collapse'),
                    rw = $('#' + id + '.panel-collapse .right-window');

                if( _this.hasClass('collapsed') ){
                    $('.tabs-container').addClass('open-window');

                    $('.accordion-toggle').not(t).addClass('collapsed');
                    $('.panel-collapse:not(.collapse)').collapse('hide');

                    _this.removeClass('collapsed');
                    panel.collapse('show');
                    setTimeout(function(){
                        rw.fadeIn();
                    },500);
                }else{
                    rw.fadeOut();
                    setTimeout(function(){
                        panel.collapse('hide');
                        _this.addClass('collapsed');
                        $('.tabs-container').removeClass('open-window');
                    },500);
                }

            }

            //CALLBACK
            if (callback) {
                callback();
            }
        }
    }


    //WHAT WE DO-------->
    if(window.body.hasClass('what-we-do')){

        function fadeBg(status){
            var bg_vid = $('#big-video-wrap');

            if( status === 'show' ){

                bg_vid.fadeIn().removeClass('faded');

            }else if( status === 'hide' ){

                bg_vid.fadeOut().addClass('faded');
            }
        }

        function ajaxThumbs(t,open){

            var service_type = t.attr('ajax-data'),
                current_tab = '.accordion-toggle.' + service_type,
                service_url = base_url + '/what-we-do/?serv=' + service_type + '&thumbs=1&auth=y';

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
                            var height = these_thumbs.height() + 15;
                            $('#thumbs-container-' + service_type).animate({height: height},'fast').perfectScrollbar();

                            //OPEN FIRST PROJECT ON DESKTOP
                            if( open === true ){
                                setTimeout(function(){
                                    $('#thumbs-container-' + service_type + ' .thumbs-content a:first').trigger('click');
                                },500);
                            }
                        });

                        //AJAX FOR VIDEO GALLERY PROJECT ///////////////////////////////////////////////
                        $('.thumbs-container .thumb-item').click(function(){

                            var t = $(this);

                            if( !t.hasClass('active') ){

                                $('.thumbs-container .thumb-item').removeClass('active');
                                t.addClass('active');

                                //VARS
                                var _this = t,
                                    project_id = _this.attr('href'),
                                    project_cont = _this.parent().parent().siblings('.project-details').attr('id'),
                                    project_url = base_url + '/what-we-do/?proj=' + project_id + '&auth=y',
                                    w = $(window).width();

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

                                        //IF MOBILE
                                        if(w < 1024){
                                            //SCROLLTO
                                            setTimeout(function(){
                                                var os = _this.offset().top;
                                                animatedScroll(os);
                                            },500);
                                        }

                                    }
                                });

                            }

                            return false;

                        });
                    }
                });
        }

        //LOAD VIDEO GALLERY THUMBS/////////////
        $('.accordion-toggle').click(function(){

            //ONLY FOR MOBILE
            var wi = $(window).width();
            if( wi < 1024){

                var _t = $(this),
                    mst = _t.attr('ajax-data'),
                    mct = '.accordion-toggle.' + mst;

                accordion(_t,function(){
                    if( !$(mct).hasClass('loaded') ){
                        ajaxThumbs(_t,false);
                    }
                });

            }else{
            //DESKTOP

                var _this = $(this),
                    st = _this.attr('ajax-data'),
                    ct = '.accordion-toggle.' + st;

                //IF THIS ISN'T COLLAPSED
                if( !_this.hasClass('collapsed') ){
                    fadeBg('show');
                }

                //IF RIGHT WINDOW IS OPEN
                if( $('.tabs-container').hasClass('open-window') ){
                    rightWindow('close',_this,'same',function(){
                        if( !$(ct).hasClass('loaded') ){
                            ajaxThumbs(_this,true);
                        }
                    });
                }else{
                    rightWindow('open',_this,false,function(){
                        if( !$(ct).hasClass('loaded') ){
                            ajaxThumbs(_this,true);
                        }
                    });
                    fadeBg('hide');
                }

                return false;

            }
        });

        //EXPAND WITH QUERY STRING
        queryStringPanel('tab');
    }

    //WHO WE ARE-------->
    if(window.body.hasClass('who-we-are')){

        //WITH RIGHT WINDOW
        $('a.accordion-toggle.with-window').on('click',function(){

            var w1 = $(window).width();
            //MOBILE
            if( w1 < 1024 ){

                accordion($(this));

            }else{
            //DESKTOP

                rightWindow('open',$(this),false);

            }
            return false;
        });

        //IF RIGHT WINDOW IS OPEN
        $('a.accordion-toggle:not(.with-window)').on('click',function(){

            var w2 = $(window).width();
            //MOBILE
            if( w2 < 1024 ){

                accordion($(this));

            }else{
            //DESKTOP

                if( $('.tabs-container').hasClass('open-window') ){
                    rightWindow('close',$(this),'different');
                    return false;
                }

            }

        });

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

        //EXPAND WITH QUERY STRING
        queryStringPanel('tab');

    }

    //CONTACT---------->
    if(window.body.hasClass('contact')){

        //FADE BG VIDEO
        $('#big-video-wrap').fadeOut().addClass('faded');

        //SERVE MAPS BASED ON LOCATIONS
        $('.location-item').click(function(){

            var lat_lon = $(this).attr('data-filter').split(','),
                address = $(this).find('.address-container').html(),
                address_string = $(this).find('.address').text(),
                offset = $(this).offset().top;

            if( !$(this).hasClass('active') ){
                $('.locations .location-item').removeClass('active');
                $(this).addClass('active');

                //SLIDE
                $('.map-slider').addClass('slide');

                setTimeout(function(){
                    initialize_map(lat_lon[0],lat_lon[1],address,address_string);
                    animatedScroll(offset);
                    $('.map-slider').removeClass('slide');
                },500);
            }
        });

        //PHX LOCATION MAP
        if(!$(window.body).hasClass('google-maps-loaded')){

            //LOAD THE GOOGLE API SCRIPT
            var google_src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyB2oIP9_kISo93_2UVT4QfJGzEFOE-cmyM&sensor=false&callback=initialize_map_phx';
            load_script(google_src);
            $(window.body).addClass('google-maps-loaded');

        }else{

            console.log('already loaded');
            initialize_map_phx();

        }

    }else{//FADE VIDEOBG BACK FOR ANY OTHER PAGE
        $('#big-video-wrap.faded').fadeIn().removeClass('faded');
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


