            </section><!-- AJAXY -->

</div><!-- OUTER-CONTAINER -->
	<?php wp_footer(); ?>

    <!--// SCRIPTS ////////////-->
    <script src="//vjs.zencdn.net/4.2/video.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/bigvideo.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery_cookie.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/bootstrap.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/spin.min.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/perfect-scrollbar-0.4.5.with-mousewheel.min.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/history.js"></script>

    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/scripts.js"></script>
    <script type="text/javascript">
        //VIDEO BG /////////////////////////////////////////
        if ( !conditionizr.touch ){

            <?php
            //GET FIELDS FOR VIDEO AND BG IMG
            $video_mp4 = get_pods_field('company_information','background_video_mp4');
            $video_ogv = get_pods_field('company_information','background_video_ogv');
            $bg_images = get_pods_field('company_information','background_images');
            $rand_bg_img = $bg_images[array_rand($bg_images, 1)];

            ?>

            var BV = new $.BigVideo({useFlashForFirefox:false});
            BV.init();

            //ONLY FOR CURRENT BROWSERS
            if( !conditionizr.ie8 || !conditionizr.ie7 ){

                BV.show('<?= $video_mp4['guid']; ?>',{
                    ambient: true,
                    altSource: '<?= $video_ogv['guid']; ?>'
                });

            } else {
            //FOR DEPRECATED BROWSERS

                BV.show('<?= $rand_bg_img['guid']; ?>');

            }

        }
    </script>

</body>
</html>