<?php

//SLUG
$slug = the_slug();

//REMOVE AUTOP - PAGES & POSTS
$autoP = get_pods_field('page','pages_auto_p');
if($autoP == 0){
    remove_filter('the_content', 'wpautop');
}

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="template-url" content="<?php bloginfo('template_url'); ?>">
    <meta name="base-url" content="<?php bloginfo('url'); ?>">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <link rel="icon" href="<?php bloginfo('template_url') ?>/images/favicon.gif" />

    <!--// STYLESHEETS ////////////-->
    <style type="text/css">.video-js{visibility: hidden;}</style>
    <link href="//vjs.zencdn.net/4.2/video-js.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/css/dashicons.css" />
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/css/bigvideo.css" />
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/css/perfect-scrollbar-0.4.5.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/css/styles.css" />

    <?php wp_head(); ?>

    <!--[if lt IE 9]>
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/css/ie-fix.css" />
    <script src="<?php bloginfo('template_url'); ?>/js/html5.js"></script>
    <![endif]-->

    <!--CONDITIONIZR-->
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/conditionizr.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/detects/touch.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/detects/chrome.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/detects/chromium.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/detects/firefox.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/detects/ie6.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/detects/ie7.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/detects/ie8.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/detects/ie9.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/detects/ie10.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/detects/ie10touch.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/detects/ie11.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/detects/ios.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/detects/linux.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/detects/mac.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/detects/opera.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/detects/retina.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/detects/safari.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/detects/windows.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/detects/winPhone7.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/detects/winPhone75.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/detects/winPhone8.js"></script>

</head>

<body <?php body_class($slug); ?>>

    <!-- OFF-CANVAS NAV -->
    <nav class="off-canvas-nav">
        <div class="nav-wrapper">
            <a href="<?php bloginfo('url'); ?>" class="nav-logo-link">
                <img class="nav-logo" src="<?php bloginfo("template_url"); ?>/images/rmp-logo.png" alt="Randy Murray Productions"/>
            </a>
            <?php wp_nav_menu( array( 'menu' => 'Main' ) ); ?>
        </div>
    </nav>
    <div class="nav-cover"></div>

    <div class="outer-container">
        <!--HEADER-->
        <header class="main-header">
            <div class="header-wrapper clearfix">
                <!--LEFT-->
                <div class="left-header">
                    <a href="<?php bloginfo('url'); ?>" class="header-logo">
                        <img src="<?php bloginfo('template_url'); ?>/images/rmp-sun.png" alt="RMP"/>
                    </a>
                    <div class="nav-btn">
                        <div class="menu-icon">
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                        <div class="menu-title">Menu</div>
                    </div>
                </div>
                <!--RIGHT-->
                <div class="right-header">
                    <div class="header-contact social">
                        <?php
                        $twitter = get_option('company_information_twitter');
                        if($twitter){
                        ?>
                        <a href="<?= $twitter ?>" target="_blank" class="dashicons dashicons-twitter"></a>
                        <?php
                        }
                        $facebook = get_option('company_information_facebook');
                        if($facebook){
                        ?>
                        <a href="<?= $facebook ?>" target="_blank" class="dashicons dashicons-facebook"></a>
                        <?php
                        }
                        ?>
                    </div>
                    <?php
                        $contact_email = get_option('company_information_contact_email');
                        $contact_phone = get_option('company_information_contact_phone');
                    ?>
                    <div class="email-section header-contact">
                        <a href="#" class="tip-btn" data="email">
                            <span class="glyphicon glyphicon-envelope"></span>
                        </a>
                    </div>
                    <div class="phone-section header-contact">
                        <a href="#" class="tip-btn" data="phone">
                            <span class="glyphicon glyphicon-earphone"></span>
                        </a>
                    </div>
                </div>
            </div>

            <!--HEADER-CONTACT-->
            <div class="header-contact-links">
                <div class="contact-links-wrapper">
                    <div class="contact-tip email">
                        <a href='mailto:<?= $contact_email ?>'><?= $contact_email ?></a>
                    </div>
                    <div class="contact-tip phone">
                        <a href='tel:<?= $contact_phone ?>' class='phone-link'><?= $contact_phone ?></a>
                    </div>
                </div>
            </div>
        </header>

        <section id="ajaxy" slug="<?= the_slug(); ?>">
        <!--MAIN-->
