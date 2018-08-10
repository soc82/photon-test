<?php

/*************************************
** Custom functions to be add below
**************************************/

/*
** Add search form to top navigation
*/
function prospect_search_form_to_menu ( $items, $args ) {
	if( 'top-navigation' === $args->theme_location ) {
    $search_form = '';
    $search_form .= '<li class="menu-item menu-item-search">';
    $search_form .= '<form method="get" class="menu-search-form" action="#" /"><input class="text_input" type="text" placeholder="Search" name="s" id="s" /></form>';
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

    $query_args = array(
        'post_type' => 'jobs',
        'posts_per_page'  => -1,
        'order' => 'DESC',
        'orderby' => 'date',
    );

    $query_args['tax_query'][] = [
        'taxonomy' => 'jobsection',
        'field'    => 'slug',
        'terms'    => $job_section,
    ];

    $items = new WP_Query($query_args);

    $terms = [];

    foreach ($items->posts as $post) {
        $post_terms = wp_get_post_terms($post->ID, 'jobtype');
        foreach ($post_terms as $term) {
            $terms[] = $term;
        }
    }

    return $terms;
}

/*
** Returns list of taxonomies for filtering downloads pages
*/
function prospect_get_downloads_filters() {

    $query_args = array(
        'post_type' => 'downloads',
        'posts_per_page'  => -1,
        'order' => 'DESC',
        'orderby' => 'date',
    );

    $items = new WP_Query($query_args);

    $terms = [];

    foreach ($items->posts as $post) {
        $post_terms = wp_get_post_terms($post->ID, 'department');
        foreach ($post_terms as $term) {
            $terms[] = $term;
        }
    }
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
