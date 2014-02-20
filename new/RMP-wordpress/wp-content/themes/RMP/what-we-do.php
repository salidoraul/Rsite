<?php
/**
 * Template Name: What We Do Page
 *
 */

get_header(); ?>

<section class="main">

    <div class="tabs-container">
        <h1 class="main-title"><?php the_title(); ?></h1>
        <div class="panel-group" id="services">
            <?php
            //ARGUMENTS FOR SERVICES
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
                        <h4 class="panel-title">
                            <a class="accordion-toggle collapsed clearfix <?= $panel_slug ?> with-window" data-toggle="collapse" data-parent="#services" href="#<?= $panel_slug ?>" ajax-data="<?= $panel_slug ?>">
                                <span class="title"><?= $title ?></span>
                                <img class="arrow" src="<?php bloginfo('template_url'); ?>/images/arrow.png">
                            </a>
                        </h4>
                    </div>
                    <div id="<?= $panel_slug ?>" class="panel-collapse collapse">
                        <div class="panel-body">
                            <div class="content"><?= $content ?></div>
                            <div class="video-gallery-outer">
                                <h2 class="projects-title">Projects</h2>
                                <div id="thumbs-container-<?= $panel_slug ?>" class="thumbs-container">
                                    <div class="thumbs-content"></div>
                                </div>
                                <div id="details-container-<?= $panel_slug ?>" class="project-details right-window">
                                    <div class="blur-container"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php
            endforeach;
            wp_reset_postdata();
            ?>
        </div>
    </div>

    <?php
    //PROJECT TOOL
    include(PROJECT_TOOL); ?>

</section>

<?php get_footer(); ?>