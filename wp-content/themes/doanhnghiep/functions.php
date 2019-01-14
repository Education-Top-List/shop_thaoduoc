<?php

function zingvn_resources(){
	wp_enqueue_style ('style', get_template_directory_uri().'/style.css');
}

add_action('wp_enqueue_scripts','zingvn_resources');

	// Navigation menus 
register_nav_menus(array(
	'primary' => __('Primary Menu'),
	'menu_mobile' => __('Mobile Menu')
));

	// Get top ancestor id
function get_top_ancestor_id(){
	global $post;
	if($post->post_parent){
		$ancestors= array_reverse(get_post_ancestors($post->ID));
		return $ancestors[0];
	}	
	return $post->ID;
}

	// Does page have children ? 
function has_children(){
	global $post;
	$pages = get_pages('child_of=' . $post->ID);
	return count($pages);
}

	// Customize excerpt word count length
function excerpt($limit) {
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

	// ADD FEATURED IMAGE SUPPORT
function featured_images_setup(){
	add_theme_support('post-thumbnails');
  add_image_size( 'thumbnail',300, 250, true ); //thumbnail
    add_image_size( 'medium', 600, 400, true ); //medium
    add_image_size( 'large', 1200, 800, true ); //large
}
add_action('after_setup_theme','featured_images_setup');

	// ADD POST FORMAT SUPPORT
add_theme_support('post-formats',array('aside','gallery','link'));

	// ADD OUR WIDGETS LOCATION
function our_widget_inits(){
	register_sidebar(array(
		'name' => 'Sidebar',
		'id' => 'sidebar1',
		'before_widget' => '<div id="%1$s" class="widget %2$s widget_area">',
		'after_widget' => "</div>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name' => 'Footer area 1',
		'id' => 'footer1',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name' => 'Footer area 2',
		'id' => 'footer2',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name' => 'Footer area 3',
		'id' => 'footer3',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
}
add_action('widgets_init','our_widget_inits');




/** Filter & Hook In Widget Before Post Content .*/
function before_post_widget() {


	if ( is_home() && is_active_sidebar( 'sidebar1' ) ) { 
		dynamic_sidebar('sidebar1', array(
			'before' => '<div class="before-post">',
			'after' => '</div>',
		) );      
	}

}

add_action( 'woo_loop_before', 'before_post_widget' );


// ADD THEME CUSTOM LOGO
add_theme_support( 'custom-logo' );


//  ADD BREADCRUMB
  function the_breadcrumb() {
 
  if (!is_front_page()) {
    echo '<li><a href="';
    echo home_url();
    echo '">';
    echo 'Trang chủ ';
    echo "</a><li>";
    if (is_category() || is_single()) {
      echo '';
      the_category(' ');
      if (is_single()) {
        echo "<li>";
        the_title();
        echo '</li>';
      }
    } elseif (is_page()) {
      echo '';
      echo the_title();
      echo '';
    } elseif (is_home()) {
      echo wp_title('');
    }
  }
  elseif (is_tag()) {single_tag_title();}
  elseif (is_day()) {echo"Archive for "; the_time('F jS, Y'); echo'';}
  elseif (is_month()) {echo"Archive for "; the_time('F, Y'); echo'';}
  elseif (is_year()) {echo"Archive for "; the_time('Y'); echo'';}
  elseif (is_author()) {echo"Author Archive"; echo'';}
  elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {echo "Blog Archives"; echo'';}
  elseif (is_search()) {echo"Search Results"; echo'';}
 
}
//  END BREADCRUMB

/*
 *  DUPLICATE POST IN  ADMIN. Dups appear as drafts. User is redirected to the edit screen
 */
function rd_duplicate_post_as_draft(){
  global $wpdb;
  if (! ( isset( $_GET['post']) || isset( $_POST['post'])  || ( isset($_REQUEST['action']) && 'rd_duplicate_post_as_draft' == $_REQUEST['action'] ) ) ) {
    wp_die('No post to duplicate has been supplied!');
  }
 
  /*
   * Nonce verification
   */
  if ( !isset( $_GET['duplicate_nonce'] ) || !wp_verify_nonce( $_GET['duplicate_nonce'], basename( __FILE__ ) ) )
    return;
 
  /*
   * get the original post id
   */
  $post_id = (isset($_GET['post']) ? absint( $_GET['post'] ) : absint( $_POST['post'] ) );
  /*
   * and all the original post data then
   */
  $post = get_post( $post_id );
 
  /*
   * if you don't want current user to be the new post author,
   * then change next couple of lines to this: $new_post_author = $post->post_author;
   */
  $current_user = wp_get_current_user();
  $new_post_author = $current_user->ID;
 
  /*
   * if post data exists, create the post duplicate
   */
  if (isset( $post ) && $post != null) {
 
    /*
     * new post data array
     */
    $args = array(
      'comment_status' => $post->comment_status,
      'ping_status'    => $post->ping_status,
      'post_author'    => $new_post_author,
      'post_content'   => $post->post_content,
      'post_excerpt'   => $post->post_excerpt,
      'post_name'      => $post->post_name,
      'post_parent'    => $post->post_parent,
      'post_password'  => $post->post_password,
      'post_status'    => 'draft',
      'post_title'     => $post->post_title,
      'post_type'      => $post->post_type,
      'to_ping'        => $post->to_ping,
      'menu_order'     => $post->menu_order
    );
 
    /*
     * insert the post by wp_insert_post() function
     */
    $new_post_id = wp_insert_post( $args );
 
    /*
     * get all current post terms ad set them to the new post draft
     */
    $taxonomies = get_object_taxonomies($post->post_type); // returns array of taxonomy names for post type, ex array("category", "post_tag");
    foreach ($taxonomies as $taxonomy) {
      $post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
      wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
    }
 
    /*
     * duplicate all post meta just in two SQL queries
     */
    $post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
    if (count($post_meta_infos)!=0) {
      $sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
      foreach ($post_meta_infos as $meta_info) {
        $meta_key = $meta_info->meta_key;
        if( $meta_key == '_wp_old_slug' ) continue;
        $meta_value = addslashes($meta_info->meta_value);
        $sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
      }
      $sql_query.= implode(" UNION ALL ", $sql_query_sel);
      $wpdb->query($sql_query);
    }
 
 
    /*
     * finally, redirect to the edit post screen for the new draft
     */
    wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );
    exit;
  } else {
    wp_die('Post creation failed, could not find original post: ' . $post_id);
  }
}
add_action( 'admin_action_rd_duplicate_post_as_draft', 'rd_duplicate_post_as_draft' );
 
/*
 * Add the duplicate link to action list for post_row_actions
 */
function rd_duplicate_post_link( $actions, $post ) {
  if (current_user_can('edit_posts')) {
    $actions['duplicate'] = '<a href="' . wp_nonce_url('admin.php?action=rd_duplicate_post_as_draft&post=' . $post->ID, basename(__FILE__), 'duplicate_nonce' ) . '" title="Duplicate this item" rel="permalink">Nhân bản</a>';
  }
  return $actions;
}
 
add_filter( 'post_row_actions', 'rd_duplicate_post_link', 10, 2 );

// duplicate page
//add_filter('page_row_actions', 'rd_duplicate_post_link', 10, 2);


/**
 * URL SITE
 */
define('BASE_URL', get_site_url('null','/wp-content/themes/doanhnghiep', 'http'));




// PRIOTITY SINGLE-PRODUCT THAN SINGLE.PHP
function mytheme_add_woocommerce_support() {
  add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );


// LOGOUT REDIRECT INDEX
add_action( 'wp_logout', 'redirect_after_logout');
function redirect_after_logout(){
  wp_redirect(home_url());
  exit();
}



// EDIT PRICE HTML WOOCOMERCE
add_filter( 'woocommerce_get_price_html', 'custom_get_price_html', 100, 2 );
function custom_get_price_html( $price,$product ){
   // return $product->price;
    if ( $product->price > 0 ) {
      if ( $product->price && isset( $product->regular_price ) ) {
        $from = $product->regular_price;
        $to = $product->price;
        return '<div class="old-colt"><del>'. ( ( is_numeric( $from ) ) ? wc_price( $from ) : $from ) .
         '  </del>  </div><div class="live-colst"><label>Giá</label>: '.( ( is_numeric( $to ) ) ? wc_price( $to ) : $to ) .' </div>';
      } else {
        $to = $product->price;
        return '<div class="live-colst"> ' . ( ( is_numeric( $to ) ) ? wc_price( $to ) : $to ) . ' fsda</div>';
      }
   } else {
     return '<div class="live-colst">0 Our Price</div>';
   }
}


/* WOOCOMERCE MINICART*/
add_filter('woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');
function woocommerce_header_add_to_cart_fragment( $fragments ) {
 global $woocommerce;
 ob_start();
 ?>
 <a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('Xem giỏ hàng', 'woothemes'); ?>">
  <?php 
  echo '<i class="fa fa-shopping-cart" aria-hidden="true"></i><span class="amount_pdc">';
  echo sprintf(_n('%d', '%d', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?> <?php //echo $woocommerce->cart->get_cart_total(); ?>
  <?php echo '</span>'; ?>
  </a>
 <?php
 $fragments['a.cart-contents'] = ob_get_clean();
 return $fragments;
}

// SHOW PRODUCT TO CART AJAX
add_filter( 'woocommerce_widget_cart_is_hidden', 'always_show_cart', 40, 0 );
function always_show_cart() {
    return false;
}

add_filter( 'woocommerce_add_to_cart_fragments', function($fragments) {

    ob_start();
    ?>

    <div class="header-quickcart">
        <?php woocommerce_mini_cart(); ?>
    </div> 

    <?php $fragments['div.header-quickcart'] = ob_get_clean();

    return $fragments;

} );


// CLEAR THE CART WHEN LOGOUT
function clear_cart_logout() {
    if( function_exists('WC') ){
        WC()->cart->empty_cart();
    }
}
add_action('wp_logout', 'clear_cart_logout');



// CLEART THE CART WHEN LOGIN
function clear_persistent_cart_after_login( $user_login, $user ) {
    $blog_id = get_current_blog_id();
    // persistent carts created in WC 3.1 and below
    if ( metadata_exists( 'user', $user->ID, '_woocommerce_persistent_cart' ) ) {
        delete_user_meta( $user->ID, '_woocommerce_persistent_cart' );
    }

    // persistent carts created in WC 3.2+
    if ( metadata_exists( 'user', $user->ID, '_woocommerce_persistent_cart_' . $blog_id ) ) {
        delete_user_meta( $user->ID, '_woocommerce_persistent_cart_' . $blog_id );
    }
}
add_action('wp_login', 'clear_persistent_cart_after_login', 10, 2);





/**
 * BREADCRUMB WOOCOMERCE
 */
add_filter( 'woocommerce_breadcrumb_defaults', 'jk_woocommerce_breadcrumbs' );
function jk_woocommerce_breadcrumbs() {
    return array(
            'delimiter'   => ' ',
            'wrap_before' => '<div class="breadcrumb" id="breadcrumb"><ul>',
            'wrap_after'  => '</ul></div>',
            'before'      => '<li>',
            'after'       => '</li>',
            'home'        => _x( 'Trang chủ', 'breadcrumb', 'woocommerce' ),
        );
}


// Remove the product rating display on product loops
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

// add class thumbnail for product woocomerce archive 
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);

if ( ! function_exists( 'woocommerce_template_loop_product_thumbnail' ) ) {
    function woocommerce_template_loop_product_thumbnail() {
        echo woocommerce_get_product_thumbnail();
    } 
}
if ( ! function_exists( 'woocommerce_get_product_thumbnail' ) ) {   
    function woocommerce_get_product_thumbnail( $size = 'shop_catalog', $placeholder_width = 0, $placeholder_height = 0  ) {
        global $post, $woocommerce;
        $args = array( 'post_type' => 'product', 'posts_per_page' => 9, 'orderby' => 'date' );
        $loop = new WP_Query( $args );
         $image = wp_get_attachment_image_src( get_post_thumbnail_id( $loop->post->ID ), 'single-post-thumbnail' );
        $output = '<figure class="thumbnail ">';

        if ( has_post_thumbnail() ) {               
            $output .= get_the_post_thumbnail( $post->ID, $size );
        } else {
             $output .= wc_placeholder_img( $size );
        }                       
        $output .= '</figure>';
        return $output;
    }
}


/**
 * Change number of products that are displayed per page (shop page)
 */
add_filter( 'loop_shop_per_page', 'new_loop_shop_per_page', 20 );

function new_loop_shop_per_page( $cols ) {
  // $cols contains the current number of products per page based on the value stored on Options -> Reading
  // Return the number of products you wanna show per page.
  $cols = 9;
  return $cols;
}

// REMOVE SIDEBAR SINGLE PRODUCT
add_action( 'wp', 'bbloomer_remove_sidebar_product_pages' );
 
function bbloomer_remove_sidebar_product_pages() {
if ( is_product() ) {
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
}
}

// ADD BUTTON ADD TO CARD AJAX
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_loop_add_to_cart', 30 );



// REMOVE WOOCOMERCE SHIPPING FIELDS
add_filter( 'woocommerce_cart_needs_shipping_address', '__return_false');





// REMOVE CSS WP_HEAD
remove_action( 'wp_head', 'wp_print_styles', 8 );


?>





