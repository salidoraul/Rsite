            </section><!-- outer-container -->
            <!-- FOOTER -->
            <footer>
                <div class="footer-container">
                    <?php wp_nav_menu( array( 'menu' => 'Footer' ) ); ?>
                </div>
            </footer>

            </div><!-- st-content-inner -->
        </div><!-- st-content -->
</div><!-- st-container -->
	<?php wp_footer(); ?>

    <!--// SCRIPTS ////////////-->
    <script src="http://vjs.zencdn.net/4.0/video.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/bigvideo.js"></script>

    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/classie.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/sidebarEffects.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery_cookie.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/bootstrap.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/spin.min.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/perfect-scrollbar-0.4.5.with-mousewheel.min.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery.history.js"></script>

    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/scripts.js"></script>
    <script type="text/javascript">
        //VIDEO BG /////////////////////////////////////////
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
    </script>

</body>
</html>