<?php get_header(); ?>

<section class="main">
    <div class="box">
        <?php
        //GET SPECIFIC POST
        global $post;

        $title = get_the_title();

        $vimeo_id = get_pods_field('projects','vimeo_id');
        $vimeo_player = '<iframe src="//player.vimeo.com/video/'.$vimeo_id.'?title=0&amp;byline=0&amp;portrait=0&amp;color=7079CE" width="100%" height="100%" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';

        $desc = get_pods_field('projects','description');

        $client_logo = get_pods_field('projects','client_logo');
        $client_logo_src = $client_logo['guid'];
        ?>
        <div class="project-item">
            <div class='video-container'>
                <?= $vimeo_player ?>
            </div>

            <div class="title">
                <h2><?= $title ?></h2>
            </div>

            <div class="info-container<?php if($client_logo){echo ' w-logo';}?>">
                <?php
                if($client_logo){ ?>
                    <div class="client-logo">
                        <img src="<?= $client_logo_src ?>" />
                    </div>
                    <div class="desc">
                        <?= $desc ?>
                    </div>
                <?php }else{ ?>
                    <div class="desc">
                        <?= $desc ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>