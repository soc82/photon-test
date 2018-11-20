<?php

/*************************************
** Custom functions to be add below
**************************************/

/*
** Add search form to top navigation
*/
function prospect_search_form_to_menu ( $items, $args ) {
	if( 'top-navigation' === $args->theme_location && $args->menu_id == 'top-navigation') {
		$search_form = '';
		$search_form .= '<li class="menu-item menu-item-search">';
		$search_form .= '<form method="get" class="menu-search-form" action="' . esc_url( home_url( '/' ) ) . '" /"><input class="text_input" type="text" placeholder="Search" name="s" id="s" /></form>';
		$search_form .= '</li>';
		$items = $search_form . $items;
	}
  return $items;
}
add_filter('wp_nav_menu_items','prospect_search_form_to_menu',10,2);


/*
** Gets the Donate page id
*/
function prospect_get_donate_page_ID() {
		$page = get_field('donate_page', 'options');
		if($page)
			return $page->ID;
}

/*
** Returns list of taxonomies for filtering job pages
*/
function prospect_get_jobs_filters($job_section) {
    $terms = get_terms( array(
        'taxonomy' => 'jobtype',
        'hide_empty' => true,
    ) );

    return $terms;
}


/*
** Modify ACF text and textarea fields to accept shortcodes
*/
function prospect_allow_shortcode_in_acf_fields( $value, $post_id, $field ) {
	$value = do_shortcode($value);
	return $value;
}
add_filter('acf/format_value/type=textarea', 'prospect_allow_shortcode_in_acf_fields', 10, 3);
add_filter('acf/format_value/type=text', 'prospect_allow_shortcode_in_acf_fields', 10, 3);


/*
** Checks if the background colour is dark and returns white class (for themeing)
** For use in flexible content field
*/
function prospect_dark_colour_class() {
	$background_colour = get_sub_field('background_colour', get_the_ID());
	$dark_colors = array('#bf3051', '#639144', '#525c63', '#f7941d');
	$color_class = '';
	if(in_array($background_colour, $dark_colors)){
		$color_class = 'color-white';
	}
	return $color_class;
}

/*
** Adds a close item to the menu
*/
add_filter('wp_nav_menu_items', 'prospect_add_close_item', 10, 2);
function prospect_add_close_item($items, $args){
    if( $args->theme_location == 'top-navigation' && $args->menu_id == 'mobile-menu' ){
		$items = '<a class="mp-close close">&nbsp;</a>' . $items;

    	$search_form = '';
		$search_form .= '<li class="menu-item mobile-menu-item-search">';
		$search_form .= '<form method="get" class="menu-search-form" action="' . esc_url( home_url( '/' ) ) . '" /"><input class="text_input" type="text" placeholder="Search" name="s" id="s" /></form>';
		$search_form .= '</li>';
		$items = $search_form . $items;

    }
    return $items;
}


/*
** Change Wordpress sender email and name
*/
function prospect_sender_email( $original_email_address ) {
    return 'webmaster@prospect-hospice.net ';
}

function prospect_sender_name( $original_email_from ) {
    return 'Prospect Hospice';
}

add_filter( 'wp_mail_from', 'prospect_sender_email' );
add_filter( 'wp_mail_from_name', 'prospect_sender_name' );


/*
** Stop GF anchor scrolling on form submission
*/
add_filter( 'gform_confirmation_anchor', '__return_false' );


function wpse28782_remove_menu_items() {

    // Hide draft event entries for all
    remove_menu_page('edit.php?post_type=draft-event-entry'); // Event Entry

    // If HR User ...
    if( current_user_can( 'hr' )):
        remove_menu_page('edit.php?post_type=event-entry'); // Event Entry
        remove_menu_page('edit.php'); // Newss
        remove_menu_page('upload.php'); // Media
        remove_menu_page('link-manager.php'); // Links
        remove_menu_page('edit-comments.php'); // Comments
        remove_menu_page('edit.php?post_type=page'); // Pages
        remove_menu_page('edit.php?post_type=draft-event-entry'); // Draft event entries
        remove_menu_page('plugins.php'); // Plugins
        remove_menu_page('themes.php'); // Appearance
        remove_menu_page('users.php'); // Users
        remove_menu_page('tools.php'); // Tools
        remove_menu_page('options-general.php'); // Settings
    endif;

    if(current_user_can( 'volunteering' )):
        remove_menu_page('edit.php?post_type=event-entry'); // Event Entry
        remove_menu_page('edit.php'); // Newss
        remove_menu_page('upload.php'); // Media
        remove_menu_page('link-manager.php'); // Links
        remove_menu_page('edit-comments.php'); // Comments
        remove_menu_page('edit.php?post_type=draft-event-entry'); // Draft event entries
        remove_menu_page('plugins.php'); // Plugins
        remove_menu_page('themes.php'); // Appearance
        remove_menu_page('users.php'); // Users
        remove_menu_page('tools.php'); // Tools
        remove_menu_page('options-general.php'); // Settings
        remove_menu_page('edit.php?post_type=downloads'); // Downloads
        remove_menu_page('edit.php?post_type=courses'); // Courses
        remove_menu_page('edit.php?post_type=faqs'); // FAQs
        remove_menu_page('edit.php?post_type=shop'); // Shops
        remove_menu_page('edit.php?post_type=team'); // Team
        remove_menu_page('edit.php?post_type=testimonials'); // Testimonials
    endif;

    if (current_user_can('fundraising')):
        remove_menu_page('edit.php?post_type=downloads'); // Downloads
        remove_menu_page('edit.php?post_type=courses'); // Courses
        remove_menu_page('edit.php?post_type=faqs'); // FAQs
        remove_menu_page('edit.php?post_type=shop'); // Shops
        remove_menu_page('edit.php?post_type=team'); // Team
        remove_menu_page('edit.php?post_type=testimonials'); // Testimonials
        remove_menu_page('edit.php'); // Newss
        remove_menu_page('tools.php'); // Tools
    endif;

    if ( current_user_can('retail')):
        remove_menu_page('edit.php?post_type=draft-event-entry'); // Draft event entries
        remove_menu_page('edit.php?post_type=event-entry'); // Event entries
        remove_menu_page('edit.php'); // Newss
        remove_menu_page('tools.php'); // Tools
    endif;

    if ( current_user_can('comms_team')):
        remove_menu_page('tools.php'); // Tools
    endif;

    if ( current_user_can('super_user')):
        remove_menu_page('tools.php'); // Tools
    endif;

}
add_action( 'admin_menu', 'wpse28782_remove_menu_items' );


add_action( 'editable_roles' , 'prospect_hide_unused_roles' );
function prospect_hide_unused_roles( $roles ){
    if (current_user_can('administrator')) {
        return $roles;
    }
    unset($roles['author']);
    unset($roles['content_keeper']);
    unset($roles['contributor']);
    unset($roles['wpseo_editor']);
    unset($roles['wpseo_manager']);
    unset($roles['editor']);
    unset($roles['shop_manager']);
    unset($roles['administrator']);

    return $roles;
}
