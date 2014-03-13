            </section><!-- AJAXY -->

</div><!-- OUTER-CONTAINER -->
	<?php

    //GET FIELDS FOR VIDEO AND BG IMG
    $video_mp4 = get_pods_field('company_information','background_video_mp4');
    $video_ogv = get_pods_field('company_information','background_video_ogv');

    $bg_images = get_pods_field('company_information','background_images');

    //IF IT RETURNS AN ARRAY PROCEED
    if( is_array($bg_images) ){
        $rand = array_rand($bg_images, 1);
        $img_obj = 'BV.show("'.$bg_images[$rand]['guid'].'");';
    };


    wp_footer(); ?>

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

        $(function(){
            //CONDITIONIZR
            conditionizr.config({
                tests: {
                    'chrome': ['class'],
                    'chromium': ['class'],
                    'firefox': ['class'],
                    'ie6': ['class'],
                    'ie7': ['class'],
                    'ie8': ['class'],
                    'ie9': ['class'],
                    'ie10': ['class'],
                    'ie10touch': ['class'],
                    'ie11': ['class'],
                    'ios': ['class'],
                    'linux': ['class'],
                    'mac': ['class'],
                    'opera': ['class'],
                    'retina': ['class'],
                    'safari': ['class'],
                    'touch': ['class'],
                    'windows': ['class'],
                    'winPhone7': ['class'],
                    'winPhone75': ['class'],
                    'winPhone8': ['class']
                }
            });
        });

        //VIDEO BG /////////////////////////////////////////
        $(window).on('load',function(){

            if ( !conditionizr.touch ){

                //INITIALIZE VIDEO
                var BV = new $.BigVideo({useFlashForFirefox:false});
                BV.init();

                //SHOW VIDEO ONLY ON CURRENT BROWSERS
                if( !conditionizr.ie8 || !conditionizr.ie7 ){

                    //SHOW VIDEO WHEN OBJECT IS READY
                    videojs("big-video-vid").ready(function(){

                        BV.show('<?= $video_mp4['guid']; ?>',{
                            ambient: true,
                            altSource: '<?= $video_ogv['guid']; ?>'
                        });

                    });

                } else {
                //FOR DEPRECATED BROWSERS

                    <?= $img_obj ?>

                }

                //HIDE BG VIDEO ON CONTACT
                if(window.body.hasClass('contact')){

                    if( $(window).width() > 1023 ){
                        $('#big-video-wrap').fadeOut().addClass('faded');
                    }
                }

                //VIDEO IS VISIBLE
                setTimeout(function(){
                    $('.video-js').css('visibility','visible');
                },500);

            }

        });

    </script>

</body>
</html>