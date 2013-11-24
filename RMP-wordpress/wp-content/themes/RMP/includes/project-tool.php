<?php
//ONLY IF IT IS AUTHORIZED.
$auth = $_GET['auth'];
if ($auth == 'y') :

    //FILTERS///////////////////////
    $service_filter = $_GET['serv'];
    $thumb_filter = $_GET['thumbs'];
    $project_filter = $_GET['proj'];

    //GET PRODUCTS OBJECTS
    $args = array(
        'numberposts'    =>  -1,
        'post_type'      =>  'projects',
        'orderby'        => 'menu_order',
        'order'          =>  'ASC'
    );
    $posts = get_posts( $args );

    //ADD SERVICE TO PRODUCTS OBJECTS
    foreach( $posts as $post ){
        $service = get_pods_field('projects','service')['post_name'];
        $post->service = $service;
    }

    //THUMBS //////////////////////////////////////////
    if( $thumb_filter ) :

        $thumbs_output = '<div class="the-thumbs">';
            foreach( $posts as $post ) :

                //FILTER BY SERVICE
                if( $post->service == $service_filter ){

                    $thumb = get_the_post_thumbnail($post->ID,'thumbnail');
                    $proj_id = $post->ID;

                        $thumbs_output .=<<<RSA
                        <a class="thumb-item" href="$proj_id">
                            $thumb
                        </a>
RSA;
                }
            endforeach;
        $thumbs_output .= '</div>';

        //RESULT
        echo $thumbs_output;

    endif;
    wp_reset_postdata();

    //PROJECT /////////////////////////////////////////
    if( $project_filter ) :

            //GET SPECIFIC POST
            $post = get_post($project_filter);

                $title = get_the_title();

                $vimeo_id = get_pods_field('projects','vimeo_id');
                $vimeo_player = '<iframe src="//player.vimeo.com/video/'.$vimeo_id.'?title=0&amp;byline=0&amp;portrait=0&amp;color=7079CE" width="100%" height="100%" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';

                $desc = get_pods_field('projects','description');

                $client_logo = get_pods_field('projects','client_logo');
                $client_logo_src = $client_logo['guid'];
            ?>
                    <div class="the-project">
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
    <?php
    endif;
    wp_reset_postdata();

//AUTH ENDS
endif;
?>