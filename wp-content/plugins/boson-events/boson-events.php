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


/******************************
  Events QUERY FOR CALENDARS
*******************************/

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
         $category = wp_get_post_terms( $post->ID, '' );

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
           );
       }

       $events = json_encode($events);

       return $events;
       wp_reset_postdata();

   }


 /******************************
 LOAD PAGE TEMPLATES
 *******************************/
 // Creates the page templates in page-attributes dropdown
 function prospect_event_page_template ($templates) {
     $templates['page-events-calendar.php'] = 'Events Calendar';
     //$templates['page-manage-events.php'] = 'Manage Events';
     return $templates;
 }
 add_filter ('theme_page_templates', 'prospect_event_page_template');

 // Redirects templates to plugin files
 function prospect_event_redirect_template ($template) {
   $plugindir = dirname( __FILE__ );
   if ( is_page_template( 'page-events-calendar.php' ))
       $template = $plugindir . '/templates/page-events-calendar.php';
   //if ( is_page_template( 'page-manage-events.php' ))
       //$template = $plugindir . '/templates/page-manage-events.php';
   return $template;
 }
 add_filter ('page_template', 'prospect_event_redirect_template');
