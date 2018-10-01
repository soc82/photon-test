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
        $typeSlug = reset($type)->slug;
       else:
         $colour = '#84BD00';
         $typeSlug = '';
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
         'type' => $typeSlug,
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

// suppress from the edit booking
add_filter('acf/prepare_field/name=other_attendee_details', function($field){
	if (isset($_GET['event_entry'])) {
		$event_entry = check_event_entry();
		if ($event_entry && get_post_type($event_entry) == 'event-entry') {
			return false;
		}
	}

	if (is_admin() && get_current_screen()->id == 'event-entry' ) {
		return false;
	}

	return $field;
});

function prospect_get_attendee_form() {
  if (isset($_GET['event_entry'])) {

	$event_entry = check_event_entry();
	if (!$event_entry) return;

    acf_form(array(
      'post_id' => $event_entry,
      'post_title'  => false,
      'submit_value'  => 'Save'
    ));

  }
}

function prospect_get_event_form( ) {
  $event = '';
  if(isset($_GET['event'])):
	$entry_id = check_event_entry();

    $event = get_post($_GET['event']);

	$post_title = sprintf('Booking for %s @ %s', $event->post_title, date('H:i d-M-Y'));

	$post_data = array(
	  'post_type'   => 'draft-event-entry',
	  'post_status' => 'publish',
	  'post_title'  => $post_title,
	);

	  $fields_id = get_event_booking_fieldset_id($_GET['event']);

    echo '<h2>Event: ' . get_the_title($event) . '</h2>';

    if($fields_id):
      $form_args = array(
		  'id'                => 'event-registration',
		  'field_groups'      => array($fields_id),
		  'new_post'          => $post_data,
		  'post_id'           => $entry_id ?: 'new_post',
		  'submit_value'      => 'Save',
		  'html_after_fields' => '<input type="submit" name="save_and_add" class="button" value="Save &amp; Checkout">'
      );
      acf_form($form_args);
      echo '<div class="event-attendee-wrapper">';
        echo '<div class="event-total-attendees"></div>';
        echo '<div class="event-total-price"></div>';
      echo '</div>';
    else:
      echo '<p>Event not found.</p>';
    endif;
  else:
    echo '<p>Event not found.</p>';
  endif;
}

/**
 * @return mixed
 */
function get_event_booking_fieldset_id($id)
{
	$fields_id = get_post_meta($id, 'booking_form_post_id', true);

	return $fields_id;
}

/**
 * @return bool
 */
function check_event_entry()
{
	$entry_id = false;
	if (isset($_GET['event_entry'])) {
		$entry_user_id = get_post_meta($_GET['event_entry'], 'event_user_id', true);
		if ($entry_user_id == get_current_user_id()) {
			$entry_id = $_GET['event_entry'];
		}
	}

	return $entry_id;
}

add_action('acf/submit_form', function ($form, $post_id) {
	if ($form['id'] == 'event-registration') {
		if ($form['post_id'] == 'new_post' && $post_id) {
			update_post_meta($post_id, 'event_user_id', get_current_user_id());
			update_post_meta($post_id, 'event_id', $_GET['event']);
		}
	}
}, 10, 2);

add_filter('acf/pre_submit_form', function ($form) {
	if ($form['id'] == 'event-registration') {
		if (isset($_POST['save_and_add'])) {
			$form['return'] = wc_get_cart_url('') . '?add-to-cart=' . $_GET['event'] . '&event_entry=' . $_GET['event_entry'];
		}
	}
	return $form;
});


add_action( 'woocommerce_before_calculate_totals', function ( $wc_cart ) {

	if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
		return;
	}

	// First loop to check if product 11 is in cart
	foreach ( $wc_cart->get_cart() as $cart_item ){
		if ($cart_item['data'] instanceof WC_Product_Event) {
			// price calcs go here
			// regular seems ok to use - it will break if they put it on sale
			$price = $cart_item['data']->get_regular_price();
			$price = $price * (1 + count(get_field( 'additional_attendees', $cart_item['event_entry'])));
			$cart_item['data']->set_price($price);
		}
	}
});

function process_attendee_email($message, $attendee) {
  $message = str_replace('{attendee_name}', get_field('first_name', $attendee->ID), $message);
  $message = str_replace('{attendee_full_name}', acf_get_field('first_name', $attendee->ID) . ' ' . get_field('last_name', $attendee->ID), $message);
  return $message;
}

add_action( 'woocommerce_order_status_processing', function ( $order_id ) {

	$order = wc_get_order( $order_id );

	$order_items = $order->get_items();

	foreach ($order_items as $order_item) {

		$event_entry_id = $order_item->get_meta('_event_entry');

		if (!$event_entry_id) continue;

		$event_entry = get_post($event_entry_id);
		if ($event_entry->post_status != 'publish') continue;

		$post_title = sprintf('Booking for %s', $order_item->get_product()->get_title());
		$post_data = array(
			'post_type'   => 'event-entry',
			'post_status' => 'publish',
			'post_title'  => $post_title
		);

		$fieldset_id = get_event_booking_fieldset_id($order_item->get_product()->get_id() );


		$fields = get_field_objects($event_entry_id);

		$fields = array_filter($fields, function ($field) use ($fieldset_id) {
			return $field['parent'] == $fieldset_id;
		});

		$additional_attendees = $fields['additional_attendees']['value'];
		unset($fields['additional_attendees']);

		array_walk($fields, function (&$b, $k) {
			$b = $b['value'];
		});

		$lead = wp_insert_post($post_data);
		foreach ($fields as $k=>$v) {
			update_post_meta($lead, $k, $v);
		}
		update_post_meta($lead, 'event_id', $order_item->get_product()->get_id());
		update_post_meta($lead, 'event_user_id', get_post_meta($event_entry_id, 'event_user_id', true));

		$post_data['post_parent'] = $lead;

		foreach ($additional_attendees as $attendee) {
			$new_attendee = wp_insert_post($post_data);
			foreach ($attendee as $k=>$v) {
				update_post_meta($new_attendee, $k, $v);
			}

			update_post_meta($new_attendee, 'event_id', $order_item->get_product()->get_id());

			$user = get_user_by( 'email', $attendee['email_address']);
			if (!$user) {
				$user_data = [
					'user_login' => strtolower(preg_replace('|[^a-z0-9_]|i', '', $attendee['first_name'] . '_' . $attendee['last_name'])),
					'user_name'  => preg_replace('|[^a-z0-9_]|i', '', $attendee['first_name'] . '_' . $attendee['last_name']),
					'user_email' => $attendee['email_address'],
					'user_pass'  => null,
				];
				$user = wp_insert_user($user_data);
				$user = get_user_by('ID', $user);
			}
			update_post_meta($new_attendee, 'event_user_id', $user->ID);

			$form_complete = get_field('other_attendee_details', $new_attendee);
			// Check to make sure the lead booker hasn't filled out all of the attendee fields before emailing
			if ($form_complete == 'complete-attendee') {
				$to = get_field('email_address', $new_attendee);
				$subject = get_field('new_attendee_email_subject', 'options');
				$link_text = get_field('new_attendee_email_link_text', 'options');

				$message = get_field('new_attendee_email_content', 'options');
				$message .= '<a href="' . get_site_url() . '/attendee-form/?event_entry=' . $new_attendee . '">' . $link_text . '</a>';

				$headers = array(
					"MIME-Version: 1.0",
					"Content-Type: text/html;charset=utf-8"
				);

				$mail = wp_mail( $to, $subject, process_attendee_email($message, get_post($new_attendee) ), implode("\r\n", $headers) );
			}


		}
		wp_trash_post($event_entry_id);
	}
}, 10, 1 );

// Save event entry post id to cart item when added to cart
add_filter( 'woocommerce_add_cart_item_data', function( $cart_item_data, $product_id, $variation_id ) {
	$entry_id = check_event_entry();
	if( ! $entry_id ) return $cart_item_data;

	$event_id = get_post_meta($entry_id, 'event_id', true);

    $cart_item_data['event_entry'] = intval( $entry_id );

	$event = get_post($event_id);
	$cart_item_data['event'] = $event->post_title;

    return $cart_item_data;
}, 10, 3);


add_filter( 'woocommerce_get_item_data', function ( $item_data, $cart_item ) {
	if ( empty( $cart_item['event_entry'] ) ) {
		return $item_data;
	}

	$item_data[] = array(
		'key'     => 'Entry',
		'value'   => sprintf('<a href="/booking-form/?event=%s&event_entry=%s">Edit</a>',$cart_item['data']->get_id(), $cart_item['event_entry'] ),
		'display' => '',
	);

	return $item_data;
}, 10, 2);


add_action( 'woocommerce_checkout_create_order_line_item', function ( $item, $cart_item_key, $values, $order ) {
    if ( isset( $values['event_entry'] ) ) {
		$item->add_meta_data( '_event_entry', $values['event_entry'] );

		$event = get_post($values['product_id']);
		$item->add_meta_data( 'event', $event->post_title );
    }
}, 10, 4);



function prospect_woo_account_menu_events($menu) {
	$menu = array_slice($menu, 0, 5, true) +
		[
			'savedbookings'     => __('Saved Bookings', 'prospect'),
			'attendingevents' => __('Events', 'prospect')
		] +
		array_slice($menu, 5, count($menu)-5, true);
	return $menu;

}
add_filter ( 'woocommerce_account_menu_items', 'prospect_woo_account_menu_events', 20 );


function prospect_add_events_endpoint() {
    add_rewrite_endpoint( 'attendingevents', EP_PAGES );
    add_rewrite_endpoint( 'savedbookings', EP_PAGES );
}
add_action( 'init', 'prospect_add_events_endpoint' );


add_action( 'woocommerce_account_attendingevents_endpoint', function () {
	include(plugin_dir_path( __FILE__ ) . 'templates/attendee_events.php');
} );

add_action( 'woocommerce_account_savedbookings_endpoint', function () {
	include(plugin_dir_path( __FILE__ ) . 'templates/saved_event_bookings.php');
} );

