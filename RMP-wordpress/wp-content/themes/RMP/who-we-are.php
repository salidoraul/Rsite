<?php
/**
 * Template Name: Who We Are Page
 *
 */

get_header(); ?>

<section class="main">

    <div class="tabs-container">
        <h1 class="main-title"><?php the_title(); ?></h1>
        <div class="panel-group" id="services">
            <?php
            //ARGUMENTS FOR ABOUT
            $args = array(
                'numberposts'    =>  -1,
                'post_type'      =>  'about',
                'orderby'        => 'menu_order',
                'order'          =>  'ASC'
            );
            $posts = get_posts( $args );
            foreach( $posts as $post ) :
                setup_postdata($post);

                //FIELDS
                $title = get_the_title();
                $content = get_the_content();
                $panel_slug = the_slug();

            ?>
                <div class="panel">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a class="accordion-toggle collapsed clearfix <?= $panel_slug ?>" data-toggle="collapse" data-parent="#services" href="#<?= $panel_slug ?>" ajax-data="<?= $panel_slug ?>">
                                <span class="title"><?= $title ?></span>
                                <span class="glyphicon glyphicon-chevron-up"></span>
                            </a>
                        </h4>
                    </div>
                    <div id="<?= $panel_slug ?>" class="panel-collapse collapse">
                        <div class="panel-body">
                            <div class="content"><?= $content ?></div>

                            <?php
                            //TEAM LOGIC
                            if( $panel_slug == 'team' ): ?>
                            <div class="team-module">
                                <div class="team-members">
                                    <div class="team-thumbs">
                                        <?php //RE-DECLARE ARGS FOR TEAM THUMBS
                                        wp_reset_query();

                                        $i = 0;
                                        $args2 = array(
                                            'numberposts'    =>  -1,
                                            'post_type'      =>  'team',
                                            'order'          =>  'ASC',
                                        );
                                        $custom_query = new WP_Query( $args2 );

                                        if ( $custom_query->have_posts() ) :
                                            while ( $custom_query->have_posts() ) :
                                            $custom_query->the_post();

                                                //FIELDS
                                                $item_slug = the_slug();
                                                $thumb = get_the_post_thumbnail($post->ID, 'medium');
                                        ?>

                                            <div class="team-thumb <?php if($i==0){echo 'active';}?>" data-filter="<?= $item_slug ?>">
                                                <?= $thumb ?>
                                            </div>

                                        <?php
                                        $i++;
                                        endwhile;
                                        endif;
                                        wp_reset_postdata();?>
                                    </div>

                                    <div class="team-items">
                                        <div class="blur-container">
                                            <?php //LOOP AGAIN

                                            $custom_query = new WP_Query( $args2 );

                                            if ( $custom_query->have_posts() ) :
                                                while ( $custom_query->have_posts() ) :
                                                $custom_query->the_post();

                                                    //FIELDS
                                                    $item_slug = the_slug();
                                                    $image = get_the_post_thumbnail($post->ID, 'full');
                                                    $name = get_the_title();
                                                    $position = get_pods_field('team','position');
                                                    $email = get_pods_field('team','email');
                                                    $bio = get_pods_field('team','biography');
                                            ?>

                                                <div class="team-item <?= $item_slug ?>">
                                                    <div class="image">
                                                        <?= $image ?>
                                                    </div>
                                                    <div class="info">
                                                        <div class="credentials">
                                                            <div class="name"><?= $name ?></div>
                                                            <div class="position"><?= $position ?></div>
                                                            <div class="email">
                                                                <a href="mailto:<?= $email ?>"><?= $email ?></a>
                                                            </div>
                                                        </div>
                                                        <div class="bio">
                                                            <?= $bio ?>
                                                        </div>
                                                    </div>
                                                </div>

                                            <?php endwhile;
                                            endif;
                                            wp_reset_postdata();
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            <?php
            endforeach;
            wp_reset_postdata();
            ?>
        </div>
    </div>

</section>

<?php get_footer(); ?>