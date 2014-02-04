            </section><!-- AJAXY -->

            <!-- FOOTER -->
            <footer>
                <div class="footer-container">
                    <?php wp_nav_menu( array( 'menu' => 'Footer' ) ); ?>
                </div>
            </footer>
</div><!-- OUTER-CONTAINER -->
	<?php wp_footer(); ?>

    <!--// BIG VIDEO ////////////-->
    <script src="//vjs.zencdn.net/4.2/video.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/bigvideo.js"></script>
    <script type="text/javascript">
        //VIDEO BG /////////////////////////////////////////
        if ( !conditionizr.touch || !conditionizr.ie8 || !conditionizr.ie7 || !conditionizr.ie6 ){

            var BV = new $.BigVideo({useFlashForFirefox:false});
            BV.init();
            BV.show('http://www.randymurrayproductions.com/new/RMP-wordpress/wp-content/themes/RMP/video/rmp-video.mp4',{
                ambient: true,
                altSource: 'http://www.randymurrayproductions.com/new/RMP-wordpress/wp-content/themes/RMP/video/rmp-video.ogv'
            });
        }
    </script>

    <!--// SCRIPTS ////////////-->
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery_cookie.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/bootstrap.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/spin.min.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/perfect-scrollbar-0.4.5.with-mousewheel.min.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/history.js"></script>

    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/scripts.js"></script>

</body>
</html>