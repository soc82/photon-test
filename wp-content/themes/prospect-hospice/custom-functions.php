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
