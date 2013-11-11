<?php
/**
 * Template Name: What We Do Page
 *
 */

get_header(); ?>

<section class="main">

    <div class="tabs-container">
        <div class="panel-group" id="services">
            <?php
            //ARGUMENTS FOR .
            $args = array(
                'numberposts'    =>  -1,
                'post_type'      =>  'services',
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
                        <h4 class="panel-title clearfix">
                            <a class="accordion-toggle collapsed <?= $panel_slug ?>" data-toggle="collapse" data-parent="#promises" href="#<?= $panel_slug ?>">
                                <?= $title ?>
                                <span class="glyphicon glyphicon-chevron-right"></span>
                            </a>
                        </h4>
                    </div>
                    <div id="<?= $panel_slug ?>" class="panel-collapse collapse">
                        <div class="panel-body">
                            <div class="content"><?= $content ?></div>
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