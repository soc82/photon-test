<?php
/*
   Plugin Name: Boson Web - Events
   Plugin URI: http://bosonweb.net
   Description: This plugin allows you to manage events.
   Version: 1.0
   Author: Will Lawrence - Boson Web
   Author URI: http://bosonweb.net
   License: GPL2
   */


/****************************
  LOAD ACF FIELDS
*****************************/
require_once('acf-fields.php');


// Event query for calendar
function prospect_events_calendar_query() {

     global $events;
     $events = array();
     $events_args = array(
       'post_type' => 'product',
       'posts_per_page'  => -1,
       'tax_query' => array(
            array(
                'taxonomy' => 'product_type',
                'field'    => 'slug',
                'terms'    => 'prospect_event',
            ),
        ),
     );
     $result = new WP_Query($events_args);

     foreach($result->posts as $post) {
       // Convert ACF date fields for output

       $start = new DateTime(get_post_meta($post->ID, 'event_start_date', true) . ' ' . get_post_meta($post->ID, 'event_start_time', true));
       $end = new DateTime(get_post_meta($post->ID, 'event_end_date', true) . ' ' . get_post_meta($post->ID, 'event_end_time', true));

       $location = get_post_meta( $post->ID, 'event_location', true);
       $link = get_permalink($post->ID);
       $type = wp_get_post_terms( $post->ID, 'event-type');
       if($type):
        $colour = get_field('colour', 'event-type_' . reset($type)->term_id);
       else:
         $colour = '#84BD00';
       endif;

       $events[] = array(
         'title'   => $post->post_title,
         'startDate' => date("d/m/Y", strtotime(get_post_meta($post->ID, 'event_start_date', true))),
         'endDate' => date("d/m/Y", strtotime(get_post_meta($post->ID, 'event_end_date', true))),
         'startTime' => get_post_meta($post->ID, 'event_start_time', true),
         'endTime'  => get_post_meta($post->ID, 'event_end_time', true),
         'start'   => $start->format('Y-m-d h:i:s'),
         'end'     => $end->format('Y-m-d h:i:s'),
         'location'  => $location,
         'link'    => $link,
         'type' => reset($type)->slug,
         'color'  => $colour,
         );
     }
     wp_reset_postdata();

     $events = json_encode($events);
     return $events;

 }

// Retrieves all data for an event
function prospect_get_event_info() {
  $post_ID = get_the_ID();
  $start = new DateTime(get_post_meta($post_ID, 'event_start_date', true) . ' ' . get_post_meta($post_ID, 'event_start_time', true));
  $end = new DateTime(get_post_meta($post_ID, 'event_end_date', true) . ' ' . get_post_meta($post_ID, 'event_end_time', true));

  $location = get_post_meta( $post_ID, 'event_location', true);
  $link = get_permalink($post_ID);
  $type = wp_get_post_terms($post_ID, 'event-type');
  if($type):
   $colour = get_field('colour', 'event-type_' . reset($type)->term_id);
  else:
    $colour = '#84BD00';
  endif;

  $event = array(
    'name'  => get_the_title(),
    'start' => $start,
    'end' => $end,
    'location'  => $location,
    'link'  => $link,
    'type'  => $type,
    'color' => $colour,
  );
  return $event;
}

function prospect_get_location_long_lat($address) {
  // function to geocode address, it will return false if unable to geocode address

    $address = urlencode($address);
    $url = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $address . '&key=AIzaSyC136X0oNRMn3rEvmB6FzNi8_e4I66o74A';

    $resp_json = file_get_contents($url);
    $resp = json_decode($resp_json, true);

    // response status will be 'OK', if able to geocode given address
    if($resp['status']=='OK'){

        $lat = isset($resp['results'][0]['geometry']['location']['lat']) ? $resp['results'][0]['geometry']['location']['lat'] : "";
        $long = isset($resp['results'][0]['geometry']['location']['lng']) ? $resp['results'][0]['geometry']['location']['lng'] : "";

        if($lat && $long){

          $lat_long = array(
            'lat' => $lat,
            'long'  => $long,
          );
          return $lat_long;

        } else {
            return false;
        }

    } else{
        echo "<strong>ERROR: {$resp['status']}</strong>";
        return false;
    }
}


/******************************
LOAD PAGE TEMPLATES
*******************************/
// Creates the page templates in page-attributes dropdown
function prospect_event_page_template ($templates) {
   $templates['page-events-calendar.php'] = 'Events Calendar';
   return $templates;
 }
 add_filter ('theme_page_templates', 'prospect_event_page_template');

 // Redirects templates to plugin files
 function prospect_event_redirect_template ($template) {
   $plugindir = dirname( __FILE__ );
   if ( is_page_template( 'page-events-calendar.php' ))
       $template = $plugindir . '/templates/page-events-calendar.php';
   return $template;
 }
 add_filter ('page_template', 'prospect_event_redirect_template');



/*
** Create Event Type taxonomy for product
*/
add_action( 'init', 'create_event_type_taxonomies', 0 );

function create_event_type_taxonomies() {

	$labels = array(
		'name'              => _x( 'Event Types', 'taxonomy general name', 'prospect' ),
		'singular_name'     => _x( 'Genre', 'taxonomy singular name', 'prospect' ),
		'search_items'      => __( 'Search Event Types', 'prospect' ),
		'all_items'         => __( 'All Event Types', 'prospect' ),
		'parent_item'       => __( 'Parent Event Type', 'prospect' ),
		'parent_item_colon' => __( 'Parent Event Type:', 'prospect' ),
		'edit_item'         => __( 'Edit Event Type', 'prospect' ),
		'update_item'       => __( 'Update Event Type', 'prospect' ),
		'add_new_item'      => __( 'Add New Event Type', 'prospect' ),
		'new_item_name'     => __( 'New Event Type', 'prospect' ),
		'menu_name'         => __( 'Event Types', 'prospect' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'event-type' ),
	);

	register_taxonomy( 'event-type', array( 'product' ), $args );

}
