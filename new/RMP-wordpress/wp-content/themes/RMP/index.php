<?php
/**
 * Template Name: Home Page
 *
 */

get_header(); ?>

<section class="main">

    <div class="hero-container">
        <div class="hero-logo">
            <img src="<?php bloginfo("template_url"); ?>/images/rmp-logo.png" alt="Randy Murray Productions"/>
        </div>
        <h1 class="hero-slogan">Powerful Storytelling For Positive Change</h1>
    </div>

    <nav class="home-nav">
        <?php
        //CUSTOM MAIN MENU
        $menu_name = 'footer';

        $args = array(
            'order'                  => 'ASC',
            'orderby'                => 'menu_order',
            'post_type'              => 'nav_menu_item',
            'output'                 => ARRAY_A,
            'output_key'             => 'menu_order',
            'nopaging'               => true,
            'update_post_term_cache' => false
        );

        //GET MAIN MENU BY ID
        $menu = wp_get_nav_menu_object(4,$args);
        $menu_items = wp_get_nav_menu_items($menu->term_id);

        //CONSTRUCT MENU LIST
        foreach ( $menu_items as $menu_item ) {
            $title = $menu_item->title;
            $url = $menu_item->url;
            $sub_title = $menu_item->post_excerpt;

            $url_array = explode('/',$url);

            $menu_list .= '<a href="' . $url . '" class="post '. $url_array[3] .'">' . $title . '</a>';
        }

        //OUTPUT THE MENU
        echo $menu_list;

        ?>
    </nav>

</section>

<?php get_footer(); ?>