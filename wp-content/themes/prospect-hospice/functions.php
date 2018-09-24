<?php

// Nav walker for Bootstrap friendly navs.
require 'inc/walker.php';
require 'inc/modified-wp-walker.php';
require_once('inc/shortcodes.php');
require_once('inc/template-builder/acf-fields.php');


/*
** Hide the admin bar.
*/
show_admin_bar(false);


/**********************************************
** Clean-ups
**********************************************/

/*
** Remove wp-embed.js
*/
function my_deregister_scripts() {
  wp_deregister_script('wp-embed');
}
add_action('wp_footer', 'my_deregister_scripts');

/*
** Removing window._wpemojiSettings from header.
*/
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');


// Let WordPress manage the document title.
add_theme_support('title-tag');


/**********************************************
** Images
**********************************************/

/*
** To keep images fluid, remove height and width HTML attributes from all <img> within post content.
*/
add_filter('post_thumbnail_html', 'remove_width_attribute', 10);
add_filter('image_send_to_editor', 'remove_width_attribute', 10);

function remove_width_attribute($html) {
    return preg_replace('/(width|height)="\d*"\s/', '', $html);
}

/*
** Register image sizes
*/
add_image_size( 'slider', 1700, 600, false );




/**********************************************
** Scripts & Stylesheets
**********************************************/

/*
** Enqueue stylesheets & scripts
*/
function startline_enqueue_scripts() {
	$currentTheme = wp_get_theme();

  // Main theme stylesheet
	wp_enqueue_style('main-css', get_stylesheet_directory_uri() . '/css/main.min.css', [], $currentTheme->get('Version'), 'screen');

  // Modal
  wp_enqueue_script( 'modal-js', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js', array( 'jquery' ), null, true);
  wp_enqueue_script( 'luminous-js', get_stylesheet_directory_uri() . '/js/Luminous.js', array( 'jquery' ), null, true);


  // Cookie js
  wp_enqueue_script( 'cookie-js', 'https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js', array( 'jquery' ), null, true);

  wp_enqueue_script( 'slick-js', get_stylesheet_directory_uri() . '/js/slick.min.js', array( 'jquery' ), $currentTheme->get('Version'), true);
  wp_enqueue_script( 'classie', get_stylesheet_directory_uri() . '/js/classie.js', array( 'jquery' ), $currentTheme->get('Version'), true);
  wp_enqueue_script( 'mlpushmenu', get_stylesheet_directory_uri() . '/js/mlpushmenu.js', array( 'jquery' ), $currentTheme->get('Version'), true);

  wp_enqueue_script( 'moment-js', get_stylesheet_directory_uri() . '/js/moment.min.js', array( 'jquery' ), null, true);

  if(is_page_template('page-events-calendar.php')):
    wp_enqueue_script( 'fullcalendar-js', get_stylesheet_directory_uri() . '/js/fullcalendar.js', array( 'jquery' ), null, true);
    wp_enqueue_script( 'bootstrap-js', get_stylesheet_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ), null, true);
  endif;

  wp_enqueue_script( 'datatables-js', '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js', array( 'jquery' ), null, true);
  wp_enqueue_style('datatables-css', '//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css', [], $currentTheme->get('Version'), 'screen');


  wp_enqueue_script( 'custom-js', get_stylesheet_directory_uri() . '/js/custom.js', array( 'jquery' ), null, true);

  // Fonts.com
  wp_enqueue_style( 'fonts-com', '//fast.fonts.net/cssapi/51101345-a47d-4725-8ddd-5585cded8327.css', [], $currentTheme->get('Version'), 'screen');


  // JQuery Modal CSS
  wp_enqueue_style( 'modal-css', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css', [], $currentTheme->get('Version'), 'screen');

  // Font Awesome CDN
  //wp_enqueue_style('font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', false, null);

}
add_action('wp_enqueue_scripts', 'startline_enqueue_scripts');

/**********************************************
** Navigation
**********************************************/

/*
** Register navigations (comment out below if not needed).
*/
function startline_custom_new_menu() {
  register_nav_menu('main-navigation',__( 'Main Navigation' ));
  register_nav_menu('footer-navigation',__( 'Footer Navigation' ));
  register_nav_menu('top-navigation',__( 'Top Navigation' ));
}
add_action( 'init', 'startline_custom_new_menu' );

/*
** Add BS active class to active nav elements.
*/
function startline_special_nav_class($classes, $item) {
    if (in_array('current-menu-item', $classes) ){
        $classes[] = 'active ';
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'startline_special_nav_class', 10, 2);


/**********************************************
** WP Core
**********************************************/

/*
** Custom excerpt length
*/
function startline_excerpt_length( $length ) {
	return 30;
}
add_filter( 'excerpt_length', 'startline_excerpt_length', 999 );

/*
** Custom excerpt ending
*/
function startline_excerpt_more( $more ) {
	return '...';
}
add_filter('excerpt_more', 'startline_excerpt_more');



/**
 * Displays an optional post thumbnail.
 *
 */
if (!function_exists('theme_get_post_thumbnail')){
	function theme_get_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		$base = '';
		if (is_singular()){
			$base = '
				<div class="post-thumbnail">
					' . the_post_thumbnail('large', array('class'=>'img-fluid')) . '
				</div><!-- .post-thumbnail -->
			';
		}else{
			$base = '
				<a class="post-thumbnail" href="' . the_permalink() . '" aria-hidden="true">
					' . the_post_thumbnail( 'post-thumbnail', array('class'=>'img-fluid', 'alt' => the_title_attribute( 'echo=0' ) ) ) . '
				</a><!-- .post-thumbnail -->
			';
		}

		return $base;
	}
}



/**********************************************
** Google API
**********************************************/

/*
** API Key for ACF Google Maps field
*/
function startline_acf_init() {
	acf_update_setting('google_api_key', 'AIzaSyDQJsfiggkELXzjTTH3xUKjsef9cBtXLdQ');
}
add_action('acf/init', 'startline_acf_init');





/**********************************************
** Woocommerce theme compatibility
**********************************************/

/*
** Unhook woocommerce wrapper
*/
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

/*
** Add own content wrappers - The below should be changed to match the theme markup
*/
add_action('woocommerce_before_main_content', 'startline_woo_wrapper_start', 10);
function startline_woo_wrapper_start() {
  echo '<div class="page-wrapper">';
}

add_action('woocommerce_after_main_content', 'startline_woo_wrapper_end', 10);
function startline_woo_wrapper_end() {
  echo '</div>';
}



/**********************************************
** Custom Functions
**********************************************/

require_once 'functions-custom.php';
require_once 'functions-woocommerce.php';
