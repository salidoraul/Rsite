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

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> xmlns="http://www.w3.org/1999/xhtml" class="<?= $x_browser_classes;?>">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="template-url" content="<?php bloginfo('template_url'); ?>">
    <meta name="base-url" content="<?php bloginfo('url'); ?>">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <link rel="icon" type="image/png" href="<?php bloginfo('template_url') ?>/images/icon.png" />

    <!--// STYLESHEETS ////////////-->

    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/css/component.css" />
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/css/styles.css" />

    <?php wp_head(); ?>

    <!--[if lt IE 9]>
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/css/ie-fix.css" />
    <script src="<?php bloginfo('template_url'); ?>/js/html5.js"></script>
    <![endif]-->

</head>

<body <?php body_class($slug); ?>>

<div id="st-container" class="st-container">

    <div class="st-pusher">

        <!-- OFF-CANVAS NAV -->
        <nav class="st-menu st-effect-6" id="menu-6">
            <?php wp_nav_menu( array( 'menu' => 'Main' ) ); ?>
        </nav>

        <div class="st-content">
            <div class="st-content-inner">

                <!--HEADER-->
                <header class="main-header clearfix">
                    <div class="left-header">
                        <img class="header-logo" src="<?php bloginfo('template_url'); ?>/images/rmp-sun.png" alt="RMP"/>
                        <div id="st-trigger-effects" class="column nav-btn">
                            <div id="menu-btn" data-effect="st-effect-6">
                                <div class="menu-icon">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                                <div class="menu-title">Menu</div>
                            </div>
                        </div>
                    </div>
                    <div class="right-header">
                        <?php
                            $contact_email = get_option('company_information_contact_email');
                            $contact_phone = get_option('company_information_contact_phone');
                        ?>
                        <div class="email-section header-contact">
                            <a href="#" data-toggle="tooltip" title="<a href='mailto:<?= $contact_email ?>'><?= $contact_email ?></a>" class="tip-btn">
                                <img src="<?php bloginfo('template_url'); ?>/images/mail-icon.png">
                            </a>
                        </div>
                        <div class="phone-section header-contact">
                            <a href="#" data-toggle="tooltip" title="<a href='<?= $contact_phone ?>' class='phone-link'><?= $contact_phone ?></a>" class="tip-btn">
                                <img src="<?php bloginfo('template_url'); ?>/images/phone-icon.png">
                            </a>
                        </div>
                    </div>
                </header>

                <!--MAIN-->
