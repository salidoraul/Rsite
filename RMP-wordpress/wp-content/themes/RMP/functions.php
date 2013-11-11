<?php


// RMP FUNCTIONS //////////////////////////////////////////////
//////////////////////////////////////////////////////////////


//REGISTER LIBRARIES
if (!is_admin()) add_action("wp_enqueue_scripts", "my_jquery_enqueue", 11);
function my_jquery_enqueue() {

    //JQUERY
    wp_deregister_script('jquery');
    wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js", false, null);
    wp_enqueue_script('jquery');

    //JQUERY UI
    wp_deregister_script('jquery-ui');
    wp_register_script('jquery-ui', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js", false, null);
    wp_enqueue_script('jquery-ui');
}

//THE SLUG
function the_slug() {
    global $post;
    $post_data = get_post($post->ID, ARRAY_A);
    $slug = $post_data['post_name'];
    return $slug;
}

//THE PARENT SLUG
function the_parent_slug() {
  global $post;
  if($post->post_parent == 0) return '';
  $post_data = get_post($post->post_parent);
  return $post_data->post_name;
}

//ADD MENU ORDER TO CUSTOM POSTS
add_action( 'init', 'pull_menu_order_to_posts' );
function pull_menu_order_to_posts()
{
    add_post_type_support( 'services', 'page-attributes' );
}

//MENUS
add_theme_support('menus');

//ADD SLUG TO MENUS
function add_slug_class_to_menu_item($output){
	$ps = get_option('permalink_structure');
	if(!empty($ps)){
		$idstr = preg_match_all('/<li id="menu-item-(\d+)/', $output, $matches);
		foreach($matches[1] as $mid){
			$id = get_post_meta($mid, '_menu_item_object_id', true);
			$slug = basename(get_permalink($id));
			$output = preg_replace('/menu-item-'.$mid.'">/', 'menu-item-'.$mid.' menu-item-'.$slug.'">', $output, 1);
		}
	}
	return $output;
}
add_filter('wp_nav_menu', 'add_slug_class_to_menu_item');

//ADD FEATURED IMAGE
add_theme_support( 'post-thumbnails' );

//ROYALSLIDER
//register_new_royalslider_files(1);

//ROYAL SLIDER VIDEO LINK
class MyRoyalSliderRendererHelper {
    private $post;
    private $options;

    function __construct( $data, $options ) {
        // $data variable holds WordPress post object only for Posts Slider
        // for other types sliders it holds just data associated with slide, print it to see what's inside
        $this->post = $data;

        // slider options (that you choose in right sidebar)
        $this->options = $options;
    }

    function post_id() {
        return $this->post->ID;
    }
    function video_link() {
        $video_array = get_post_meta($this->post->ID,'video_link');
        return $video_array[0];
    }
}

/**
 * @param  [object] $m       Mustache_Engine object
 * @param  [object] $data    Object with slide data (for example for posts slider it's WordPress Post Object)
 * @param  [object] $options Array of RoyalSlider options
 */
function newrs_add_custom_variables($m, $data, $options) {

    // initialize helper class
    $helper = new MyRoyalSliderRendererHelper($data, $options);

    // add {{hello_world}} variable that gets data from hello_world function of MyRoyalSliderRendererHelper class
    $m->addHelper('video_link', array($helper, 'video_link') );

    // same, but for post_id
    $m->addHelper('post_id', array($helper, 'post_id') );
}
add_filter('new_rs_slides_renderer_helper', 'newrs_add_custom_variables', 10, 4);

//GET GALLERY ID'S
function get_gallery_ids() {

    global $post;
    $attachment_ids = array();
    $pattern = get_shortcode_regex();
    $ids = array();

    if (preg_match_all( '/'. $pattern .'/s', $post->post_content, $matches ) ) {   //finds the     "gallery" shortcode and puts the image ids in an associative array at $matches[3]
    $count=count($matches[3]);      //in case there is more than one gallery in the post.
    for ($i = 0; $i < $count; $i++){
        $atts = shortcode_parse_atts( $matches[3][$i] );
        if ( isset( $atts[ids] ) ){
        $attachment_ids = explode( ',', $atts[ids] );
        $ids = array_merge($ids, $attachment_ids);
        }
    }
    }
      return $ids;

 }
add_action( 'wp', 'get_gallery_ids' );

//ADD THUMB TO POST COLUMNS
//add_filter('manage_posts_columns', 'posts_columns', 5);
//add_action('manage_posts_custom_column', 'posts_custom_columns', 5, 2);
//function posts_columns($defaults){
//    $defaults['riv_post_thumbs'] = __('Thumbs');
//    return $defaults;
//}
//function posts_custom_columns($column_name, $id){
//        if($column_name === 'riv_post_thumbs'){
//        echo the_post_thumbnail( array(110,110) );
//    }
//}

//BASE PAGINATION
//function base_pagination() {
//	global $wp_query;
//
//	$big = 999999999; // This needs to be an unlikely integer
//
//	// For more options and info view the docs for paginate_links()
//	// http://codex.wordpress.org/Function_Reference/paginate_links
//	$paginate_links = paginate_links( array(
//		'base' => str_replace( $big, '%#%', get_pagenum_link($big) ),
//		'current' => max( 1, get_query_var('paged') ),
//		'total' => $wp_query->max_num_pages,
//		'mid_size' => 5
//	) );
//
//	// Display the pagination if more than one page is found
//	if ( $paginate_links ) {
//		echo '<div class="pagination">';
//		echo $paginate_links;
//		echo '</div>';
//	}
//}

//EXCLUDE SEARCH ITEMS
//function custom_search_query( $query ) {
//    if ($query->is_search && !is_admin()) {
//        $query->set('cat', "-16,-17,-18,-25,-26" ); // id of page or post
//    }
//}
//add_filter( 'pre_get_posts', 'custom_search_query');

//PODS FIELDS
function get_pods_field($podName, $fieldName, $isTaxon=false){
    global $post;
    if($isTaxon){
        $termsObj = wp_get_object_terms($post->ID, $podName);
        return pods_field($podName, $termsObj[0]->term_id, $fieldName);
    }else{
        $pod = pods($podName, $post->ID);
        return $pod->field($fieldName);
    }
}

//EXCERPT WITH CHARACTER LIMIT
function get_excerpt_limited($limit) {
    $excerpt = explode(' ', get_the_excerpt(), $limit);
    if (count($excerpt)>=$limit) {
        array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'...';
        } else {
    $excerpt = implode(" ",$excerpt);
        }
    $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
    return $excerpt;
}

?>