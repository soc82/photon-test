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

/****************************
  Register event submissions post type
*****************************/
include(plugin_dir_path( __FILE__ ) . 'boson-event-submissions.php');


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
    'singular_name'     => _x( 'Event Type', 'taxonomy singular name', 'prospect' ),
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

function prospect_get_attendee_form() {
  if (isset($_GET['event_entry'])) {
    $event_entry = $_GET['event_entry'];

    acf_form(array(
      'post_id' => $event_entry,
      'post_title'  => false,
      'submit_value'  => 'Update the post!'
    ));

  }
}

function prospect_get_event_form( ) {
  $event = '';
  if(isset($_GET['event'])):
    $event = get_post($_GET['event']);
    $fields_id = get_post_meta($_GET['event'], 'booking_form_post_id', true);
    echo '<h2>Event: ' . get_the_title($event) . '</h2>';

    if($fields_id):
      $form_args = array(
        'field_groups'  => array($fields_id),
      );
      acf_form($form_args);
      echo '<div class="event-total-attendees"></div>';
      echo '<div class="event-total-price"></div>';

    else:
      echo '<p>Event not found.</p>';
    endif;
  else:
    echo '<p>Event not found.</p>';
  endif;
}


function prosect_event_form_attendee_number( $form, $args ) {
    echo '<input type="hidden" name="total_number_attendees" id="total_number_attendees" value="1">';
}
add_action( 'af/form/hidden_fields', 'prosect_event_form_attendee_number', 10, 2 );


function prospect_event_form_testing($post_id) {

  $post_title = 'Event Entry';

  $post_data = array(
    'post_type' => 'event-entry',
    'post_status' => 'publish',
    'post_title' => $post_title,
  );

  $fields = $_POST['acf'];

  exit;
}

// add_filter('acf/pre_save_post' , 'prospect_event_form_testing', 10, 1 );


/*
** After ACF form submission
*/
function prospect_event_form_submission( $post_id ) {

  $post_title = 'Event Entry';

  $post_data = array(
    'post_type' => 'event-entry',
    'post_status' => 'publish',
    'post_title' => $post_title,
  );

    /*
    ** Reminder to add completion status here
    */
    $event_id = $_GET['event'];
    $lead_booker_fields = [];
    $attendees = [];

    $fields = $_POST['acf'];

    foreach ($fields as $key => $field) {

        if (acf_get_field($key)['type'] == 'repeater') {
            foreach ($field as $attendee) {
              $attendees[] = $attendee;
            }
        } else {
            if ($field) {
                $lead_booker_fields[$key] = $field;
            }
        }
    }
    exit;

    if ($lead_booker_fields) {
        $lead_post_id = wp_insert_post( $post_data );
        foreach ($lead_booker_fields as $key => $lead_booker_field) {
            update_field($key, $lead_booker_field, $lead_post_id);
        }
        update_post_meta($lead_post_id, 'attendee_status', 'complete');
        update_post_meta($lead_post_id, 'event_id', $event_id);
    }

    if ($attendees) {
        $attendeeID = 1;

        foreach ($attendees as $attendee) {
            // Check to see if a user already exists for the attendees
            var_dump(acf_get_field('email_address'));
            exit;

            $user = get_user_by( 'email', acf_get_field('email_address')['value']);
            if (!$user) {
                $user_data = [
                    'user_login' => strtolower(str_replace(' ',  '_', acf_get_field('first_name')['value'] . '_' . acf_get_field('last_name')['value'])),
                    'user_name' => acf_get_field('first_name')['value']  . ' ' . acf_get_field('last_name')['value'],
                    'user_email' => acf_get_field('email_address')['value'],
                    'user_pass' => null,
                ];
                $user = wp_insert_user($user_data);
                $user = get_user_by('ID', $user);
            }

            $to = $user->data->user_email;
            $subject = get_field('new_attendee_email_subject', 'options');
            $link_text = get_field('new_attendee_email_link_text', 'options');

            $message = get_field('new_attendee_email_content', 'options');
            $message .= '<a href="' . get_site_url() . '/my-account/lost-password/">' . $link_text . '</a>';

            $headers = array(
                "MIME-Version: 1.0",
                "Content-Type: text/html;charset=utf-8"
            );

            $mail = wp_mail( $to, $subject, process_attendee_email($message, $attendee), implode("\r\n", $headers) );
            // Create an event entry post for each attendee, replace this with a custom wp_mail
            $post_id = wp_insert_post( $post_data );

            foreach ($attendee as $key => $value) {
                $field = acf_get_field(substr($key, -19));
                //var_dump($field['name']);
                update_field($field['name'], $value, $post_id);
            }

            update_post_meta($post_id, 'event_id', $event_id);
            update_post_meta($post_id, 'lead_booking_id', $lead_post_id);

            $attendeeID++;
        }
    }
    exit;
    wp_redirect( wc_get_cart_url() . '?add-to-cart=' .  $_GET['event'] . '&quantity=' . $attendeeID . '&event_entry_id=' . $lead_post_id);
    exit;
}

add_filter('acf/pre_save_post' , 'prospect_event_form_submission', 10, 1 );


function process_attendee_email($message, $attendee) {
  $message = str_replace('{attendee_name}', acf_get_field('first_name')['value'], $message);
  $message = str_replace('{attendee_full_name}', acf_get_field('first_name')['value'] . ' ' . acf_get_field('last_name')['value'], $message);
  return $message;
}

// Save event entry post id to cart item when added to cart
add_filter( 'woocommerce_add_cart_item_data', 'prospect_save_event_entry_cart_data', 30, 3 );
function prospect_save_event_entry_cart_data( $cart_item_data, $product_id, $variation_id ) {
    if( ! isset($_GET['event_entry_id']) )
        return $cart_item_data;

    $cart_item_data['custom_data']['event_entry_meta'] = esc_attr( $_GET['event_entry_id'] );

    return $cart_item_data;
}

add_action( 'woocommerce_add_order_item_meta', 'prospect_save_order_meta', 10, 3 );
function prospect_save_order_meta( $itemId, $values, $key ) {
    if ( isset( $values['custom_data']['event_entry_meta'] ) ) {
        wc_add_order_item_meta( $itemId, 'event_entry_id', $values['custom_data']['event_entry_meta'] );
    }
}


function prospect_woo_account_menu_events() {
  $myorder = array(
    'dashboard'          => __( 'Dashboard', 'prospect' ),
    'edit-account'       => __( 'Account Details', 'prospect' ),
    'edit-address'       => __( 'Addresses', 'prospect' ),
    //'payment-methods'    => __( 'Payment Methods', 'prospect' ),
    'orders'             => __( 'Orders & Events', 'prospect' ),
    'applications' => __( 'Job Applications', 'prospect' ),
    'attendingevents' => __( 'Events', 'prospect' ),
    //'downloads'          => __( 'Download', 'prospect' ),
    'customer-logout'    => __( 'Logout', 'prospect' ),
  );
  return $myorder;
}
add_filter ( 'woocommerce_account_menu_items', 'prospect_woo_account_menu_events' );

// Add new URL endpoint for job applications
function prospect_add_events_endpoint() {
    add_rewrite_endpoint( 'attendingevents', EP_PAGES );
}
add_action( 'init', 'prospect_add_events_endpoint' );
// Set the content for the new endpoint
function prospect_events_endpoint_content() {
    include(plugin_dir_path( __FILE__ ) . 'templates/attendee_events.php');
}
add_action( 'woocommerce_account_attendingevents_endpoint', 'prospect_events_endpoint_content' );
