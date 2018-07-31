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