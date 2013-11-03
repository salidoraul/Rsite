<?php
/**
Template Name: Splash Page
 */
?>

<!DOCTYPE html>
<html>
<head>
	<title>Randy Murray Productions</title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="icon" type="image/png" href="<?php bloginfo('template_url') ?>/images/icon.png" />

    <!--// STYLESHEETS ////////////-->
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/css/bigvideo.css" />
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/css/splash.css" />

    <?php wp_head(); ?>

    <!--[if lt IE 9]>
    <script src="<?php bloginfo('template_url'); ?>/js/html5.js"></script>
    <![endif]-->

</head>

<body>
    <div class="splash-container">
        <div class="main-container wrapper">
            <div class="hero-container">
                <div class="hero">
                    <img src="<?php bloginfo("template_url"); ?>/images/rmp-logo.png" alt="Randy Murray Productions"/>
                    <h1>Powerfull Storytelling For A Positive Change</h1>
                </div>
                <div class="nav">
                    <h2>New Site Coming Winter 2013</h2>
                    <div class="links">
                        <a href="#" class="contact">Contact</a>|
                        <a href="#" class="vimeo" target="blank">Vimeo</a>|
                        <a href="#" class="old-site">Old Site</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="contact-container">
            <div class="contact-section wrapper">
                <h3 class="contact-header">We're Here For You :)</h3>
                <div class="locations">
                    <div class="location-item">
                        <h4>LA</h4>
                        <div class="address">
                            2690 N. Beachwood Drive<br/>
                            Los Angeles, CA 90068
                        </div>
                        <a href="#"><span class="glyphicon glyphicon-map-marker"></span> View Map</a>
                    </div>
                    <div class="location-item main">
                        <h4>Phx</h4>
                        <div class="address">
                            631 North First Avenue, Suite 101<br/>
                            Phoenix, AZ 85003<br/>
                            Office: 602 957 7760<br/>
                            Fax: 602 776 7660<br/>
                            <a href="mailto:info@randymurrayproductions.com">info@randymurrayproductions.com</a>
                        </div>
                        <a href="#"><span class="glyphicon glyphicon-map-marker"></span> View Map</a>
                    </div>
                    <div class="location-item">
                        <h4>SF</h4>
                        <div class="address">
                            901 Mission Street Suite 105<br/>
                            San Francisco, CA 94103
                        </div>
                        <a href="#"><span class="glyphicon glyphicon-map-marker"></span> View Map</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<!--// SCRIPTS /////////////-->
<script src="http://vjs.zencdn.net/4.0/video.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/bigvideo.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/bootstrap.js"></script>
<script type="text/javascript">
    $(function() {
        var BV = new $.BigVideo({useFlashForFirefox:false});
        BV.init();
        BV.show('http://www.randymurrayproductions.com/wordpress/wp-content/themes/RMP/video/rmp.mp4',{
            ambient:true,
            altSource:'http://www.randymurrayproductions.com/wordpress/wp-content/themes/RMP/video/rmp.oggtheora.ogv'
        });

        function animatedScroll(topPosition){
            $('body,html').animate({scrollTop: topPosition}, 500);
        }
        $('.links a.contact').click(function(){
            var contact_offset = $('.contact-section').offset().top;
            animatedScroll(contact_offset);
            setTimeout(function(){
                $('.contact-header').addClass('active');
                setTimeout(function(){
                    $('.contact-header').removeClass('active');
                },500);
            },250);
        });

    });
</script>
</html>
