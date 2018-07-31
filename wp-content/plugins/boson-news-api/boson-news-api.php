<?php
/*
Plugin Name: Boson Web - News API Module
Plugin URI: http://bosonweb.net
Description: This plugin allows you to manage roles and applications.
Version: 1.0
Author: Boson Web
Author URI: http://bosonweb.net
License: GPL2
*/

function news_api() {
	$query_args = array(
		'post_type' => 'post',
		'posts_per_page'  => -1,
		'order' => 'DESC',
		'orderby' => 'date',
	);

	$items = new WP_Query($query_args);

	$return_array = [];

	foreach ($items->posts as $item) {
		$return_array[] = [
			'post_id' => $item->ID,
			'post_title' => $item->post_title,
			'post_content' => $item->post_content,
			'featured_image' => get_the_post_thumbnail_url($item->ID),
		];
	}

	return $return_array;
}


add_action( 'rest_api_init', function () {
  register_rest_route( 'news-api', '/news', array(
    'methods' => 'GET',
    'callback' => 'news_api',
  ) );
} );