<?php
session_start();

//UNIQUE SESSION ID
if( !isset($_SESSION["session_id"]) ):
    $_SESSION["session_id"]=uniqid();
endif;

//SLUG
$slug = the_slug();

//REMOVE AUTOP - PAGES & POSTS
$autoP = get_pods_field('page','pages_auto_p');
if($autoP == 0){
    remove_filter('the_content', 'wpautop');
}

//BROWSER DETECT
include('includes/browserdetect.class.php');
include('includes/utility.class.php');
$html_classesa = new utility();
$browser = new Browser();
$mobile = new Mobile_Detect();

function html_classes($browser_name, $browser_platform, $browser_version, $is_mobile = false, $is_tablet = false){
    $browser_name = lcwords(str_replace(" ","-", $browser_name));
    $browser_platform = lcwords(str_replace(" ","-", $browser_platform));
    $browser_platform = ($browser_platform == "apple")?"mac":$browser_platform;
    $browser_version = explode(".",$browser_version);
    $browser_version = $browser_version[0];
    $browser_version = $browser_name."-".$browser_version;
    $is_mobile = ($is_mobile)?"mobile":"";
    $is_tablet = ($is_tablet)?"tablet":"";
    $is_phone = ($is_mobile && !$is_tablet)?"phone":"";

    $html_classes = $browser_name." ".$browser_platform." ".$browser_version." ".$is_phone." ".$is_tablet." ".$is_mobile;
    return $html_classes;
}

function lcwords($str){
    return preg_replace('#\b([a-z])#ie', "strtolower($1)", $str);
}

$x_browser_classes = html_classes( $browser->getBrowser(),$browser->getPlatform(),$browser->getVersion(),$mobile->isMobile(),$mobile->isTablet());


/**
Template Name: Splash Page
 */
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" class="<?= $x_browser_classes;?>">
<head>
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
                    <h1>Powerfull Storytelling For Positive Change</h1>
                </div>
                <div class="nav">
                    <h2>New Site Coming Winter 2013</h2>
                    <div class="links">
                        <a href="#" class="contact">Contact</a>|
                        <a href="http://vimeo.com/randymurrayproductions" class="vimeo" target="blank">Vimeo</a>|
                        <a href="http://randymurrayproductions.com/back-in-time.html" class="old-site">Old Site</a>
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
                        <a href="https://www.google.com/maps?q=2690+North+Beachwood+Drive,+Los+Angeles,+CA&hl=en&sll=33.964342,-118.041624&sspn=1.436241,1.234589&hnear=2690+N+Beachwood+Dr,+Los+Angeles,+California+90028&t=m&z=17" target="_blank"><span class="glyphicon glyphicon-map-marker"></span> View Map</a>
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
                        <a href="https://www.google.com/maps?q=first+studio+631+North+First+Avenue,+Suite+101+phoenix+az&hl=en&ll=33.455828,-112.074741&spn=0.011287,0.009645&sll=34.119961,-118.320825&sspn=0.0112,0.009645&hq=first+studio&hnear=631+N+1st+Ave+%23101,+Phoenix,+Arizona+85003&t=m&z=17&iwloc=A" target="_blank"><span class="glyphicon glyphicon-map-marker"></span> View Map</a>
                    </div>
                    <div class="location-item">
                        <h4>SF</h4>
                        <div class="address">
                            901 Mission Street Suite 105<br/>
                            San Francisco, CA 94103
                        </div>
                        <a href="https://www.google.com/maps?q=901+Mission+St,+San+Francisco,+CA&hl=en&ll=37.781909,-122.405977&spn=0.010353,0.023335&sll=37.782414,-122.406617&layer=c&cbp=13,142.29,,0,0.01&cbll=37.782544,-122.406744&hnear=901+Mission+St,+San+Francisco,+California+94103&t=h&z=17&iwloc=A&panoid=ddwKRDyK-_74bQIMiaVQag" target="_blank"><span class="glyphicon glyphicon-map-marker"></span> View Map</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<!--// SCRIPTS /////////////-->
<script type="text/javascript" src="http://vjs.zencdn.net/4.0/video.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/bigvideo.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/bootstrap.js"></script>
<script type="text/javascript">
    $(function() {
        var BV = new $.BigVideo({useFlashForFirefox:false});
        BV.init();
        if (Modernizr.touch) {
            BV.show('http://www.randymurrayproductions.com/RMP-wordpress/wp-content/themes/RMP/video/poster.jpg');
        } else{
            BV.show('http://www.randymurrayproductions.com/RMP-wordpress/wp-content/themes/RMP/video/rmp-video.mp4',{
                ambient:true,
                altSource:'http://www.randymurrayproductions.com/RMP-wordpress/wp-content/themes/RMP/video/rmp.oggtheora.ogv'
            });
        }

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

            return false;
        });

    });
</script>
</html>
