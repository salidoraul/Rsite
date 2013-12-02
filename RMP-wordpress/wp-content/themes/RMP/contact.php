<?php
/**
 * Template Name: Contact Page
 *
 */

get_header(); ?>

<section class="main">

    <div class="information-section">
        <h1>We're Here For You</h1>
        <div class="info-container">
            <?php
            //ARGUMENTS FOR CONTACT INFO
            $args = array(
                'numberposts'    =>  -1,
                'post_type'      =>  'contact_info',
                'orderby'        => 'menu_order',
                'order'          =>  'ASC'
            );
            $posts = get_posts( $args );
            foreach( $posts as $post ) :
                setup_postdata($post);

                //FIELDS
                $title = get_the_title();
                $info = get_pods_field('contact_info','info');
                $phone = get_pods_field('contact_info','phone');
                $mobile = get_pods_field('contact_info','mobile');
                $email = get_pods_field('contact_info','email');
            ?>

                <div class="info-item">
                    <h3><?= $title ?></h3>
                    <div class="info"><?= $info ?></div>
                    <a class="phone phone-link" href="tel:<?= $phone ?>"><?= $phone ?></a>
                    | M <a class="mobile phone-link" href="<?= $mobile ?>"><?= $mobile ?></a>
                    <a class="email" href="mailto:<?= $email ?>"><?= $email ?></a>
                </div>

            <?php
            endforeach;
            wp_reset_postdata();
            ?>
        </div>
    </div>

    <div class="locations-section">
        <div class="locations">
            <?php
            //ARGUMENTS FOR LOCATIONS
            $args = array(
                'numberposts'    =>  -1,
                'post_type'      =>  'locations',
                'orderby'        => 'menu_order',
                'order'          =>  'ASC'
            );
            $posts = get_posts( $args );
            foreach( $posts as $post ) :
                setup_postdata($post);

                //FIELDS
                $title = get_the_title();
                $address = get_pods_field('locations','address');
                $phone = get_pods_field('locations','phone');
                $fax = get_pods_field('locations','fax');
                $email = get_pods_field('locations','email');

                $lat_long = get_pods_field('locations','lat_long');
            ?>

                <div class="location-item" data-filter="<?= $lat_long ?>">
                    <div class="title"><?= $title ?></div>
                    <div class="address-container">
                        <div class="address"><?= $address ?></div>
                        <a class="phone phone-link" href="tel:<?= $phone ?>">Office: <?= $phone ?></a>
                        <?php if($fax){ ?>
                            <a class="phone phone-link" href="tel:<?= $fax ?>">Fax: <?= $fax ?></a>
                        <?php } ?>
                        <a class="email" href="mailto:<?= $email ?>"><?= $email ?></a>
                    </div>
                </div>

            <?php
            endforeach;
            wp_reset_postdata();
            ?>
        </div>

        <!-- GOOGLE MAP -->
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB2oIP9_kISo93_2UVT4QfJGzEFOE-cmyM&sensor=false"></script>
        <script type="text/javascript" src="<?php bloginfo('template_url') ?>/js/infobubble-compiled.js"></script>
        <div class="map-container">
            <div id="map-canvas"></div>
        </div>
    </div>

</section>

<?php get_footer(); ?>