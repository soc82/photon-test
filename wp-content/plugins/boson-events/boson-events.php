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
include(plugin_dir_path( __FILE__ ) . 'boson-events-export.php');


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


// load ticket types
add_filter('acf/load_field/name=ticket_type', function ( $field ) {

	// reset choices
	$field['choices'] = array();

	if (isset($_GET['event'])) {
		$event = $_GET['event'];
	} else if(isset($_GET['event_entry'])) {
        $event = $_GET['event_entry'];
    } else {
        return $field;
    }

	// get the textarea value from options page without any formatting
	$choices = get_field('ticket_types', $event, true);

	// loop through array and add to field 'choices'
	if( is_array($choices) ) {
		$prices = [];
        $content = [];
		foreach( $choices as $choice ) {
			$field['choices'][ $choice['name'] ] = $choice['name'] . ' - &pound;' . $choice['price'];
			$prices[$choice['name']] = $choice['price'];
            $consent[$choice['name']] = $choice['parent_consent_required'];
		}
		$field['wrapper']['data-pricing'] = json_encode($prices);
        $field['wrapper']['data-parent-consent'] = json_encode($consent);

	}

	// return the field
	return $field;

});

add_filter('acf/load_field/name=color', 'acf_load_color_field_choices');

// suppress from the edit booking pages
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

add_filter('acf/prepare_field/name=ticket_type', function($field){
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

    	$event_id = get_post_meta($event_entry, 'event_id', true);

    	if (!event_are_attendees_editable($event_id)) return;

    	$fieldset = get_event_attendee_fieldset_id_conditional(get_post_meta($event_entry, 'event_id', true), get_post($event_entry));

        echo '<h3>' . get_the_title($event_id) . '</h3>';

        acf_form(array(
          'post_id' 	  => $event_entry,
          'post_title'    => false,
    	  'field_groups'  => array($fieldset),
          'return'		  => site_url('/my-account/attendingevents/'),
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

    $event_terms = get_field('event_terms_conditions', $_GET['event']);
    $generic_terms = get_field('generic_event_terms', 'option');

    echo '<h2>Event: ' . get_the_title($event) . '</h2>';

    if($fields_id):
      $form_args = array(
		  'id'                => 'event-registration',
		  'field_groups'      => array($fields_id),
		  'new_post'          => $post_data,
		  'post_id'           => $entry_id ?: 'new_post',
		  'submit_value'      => 'Save',
		  'return'		  	  => site_url('/my-account/savedbookings/'),
		  'html_after_fields' => '<input type="submit" name="save_and_add" class="button" value="Save &amp; Checkout">'
      );
      acf_form($form_args);
      echo '<div class="event-attendee-wrapper">';
        echo '<div class="event-total-attendees"></div>';
        echo '<div class="event-total-price"></div>';
      echo '</div>';

       if($event_terms):
           echo '<div id="event-terms-modal" class="modal">' . $event_terms . '</div>';
       elseif($generic_terms):
           echo '<div id="event-terms-modal" class="modal">' . $generic_terms . '</div>';
       endif;

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
	//$fields_id = get_post_meta($id, 'booking_form_post_id', true);
    $fields_id = get_field('event_form', $id);
    if($fields_id) {
        $fields_id = $fields_id->ID;
    }

	return $fields_id;
}

function get_event_attendee_fieldset_id($id)
{
	$fields_id = get_event_booking_fieldset_id($id);
	if (!$fields_id) return false;
	global $wpdb;
	$data = $wpdb->get_var("SELECT p2.post_content FROM {$wpdb->prefix}posts p1 LEFT JOIN {$wpdb->prefix}posts p2 ON p1.ID = p2.post_parent WHERE p1.post_parent = $fields_id AND p1.post_excerpt = 'additional_attendees'");
	$data = unserialize($data);

    // Returns acf field key for attendee clone field
	return $data['clone'][0];
}


function get_event_attendee_fieldset_id_conditional($id, $attendee)
{

    $child_fields = '';
    $adult_fields = '';
    $lead_fields = '';
	$fields_id = get_event_booking_fieldset_id($id);
	if (!$fields_id) return false;

    // Get the fields from group id
    $fields = acf_get_fields_by_id($fields_id);
    $lead_group = get_post($fields_id);


    global $wpdb;
    // Return sub-fields of 'additional_attendees'
    $sub_fields = $wpdb->get_results("SELECT p2.post_excerpt, p2.post_content FROM {$wpdb->prefix}posts p1 LEFT JOIN {$wpdb->prefix}posts p2 ON p1.ID = p2.post_parent WHERE p1.post_parent = $fields_id AND p1.post_excerpt = 'additional_attendees'");

    if($sub_fields) {
        foreach($sub_fields as $field) {
            //$field = unserialize($field->post_content);
            if($field->post_excerpt == 'adult') {
                $adult_fields = unserialize($field->post_content);
            }
            if($field->post_excerpt == 'child') {
                $child_fields = unserialize($field->post_content);
            }
        }
    }

    $attendee_type = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE meta_key = 'attendee_type' AND post_id = {$attendee->ID}");

    if($attendee_type == 'lead') {
        return $lead_group->post_name;
    } else if($attendee_type == 'child') {
        return $child_fields['clone'][0];
    } else if($attendee_type == 'adult') {
        return $adult_fields['clone'][0];
    } else {
        // Fallback to old function which returns the first clone group if finds
        return get_event_attendee_fieldset_id($id);
    }

}


function get_attendee_post_meta($post_id) {

  $meta_array = array();
  $post_meta = get_post_meta($post_id);
  foreach($post_meta as $key => $value) {
    //if (substr($key, 0, 1) != '_') {
      $meta_array[$key] = $value[0];
    //}
  }

  return $meta_array;

}



/**
 * @return bool
 */
function check_event_entry()
{
	$entry_id = false;
	if (isset($_GET['event_entry'])) {

		if (get_post_status($_GET['event_entry'])!= 'publish') {
			return false;
		}

		$entry_user_id = get_post_meta($_GET['event_entry'], 'event_user_id', true);
		if ($entry_user_id == get_current_user_id()) {
			$entry_id = $_GET['event_entry'];
		}
		$lead_user_id = get_post_meta($_GET['event_entry'], 'lead_user_id', true);
		if ($lead_user_id == get_current_user_id()) {
			$entry_id = $_GET['event_entry'];
		}

        /*
        // Check for opted-out entries
        $details = get_conditional_attendee_details(get_post($_GET['event_entry']));
        $lead_details = get_conditional_attendee_details(get_post(get_lead_booking_id($_GET['event_entry'])));
        if ($details['email_address'] == $lead_details['email_address'] ) {
            $entry_id = $_GET['event_entry'];
        }
        */

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
            $form['return'] = wc_get_cart_url('') . '?add-to-cart=' . $_GET['event'] . '&event_entry=%post_id%';
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

			$_prices = get_field('ticket_types', $cart_item['data']->get_id(), true);
			$prices = [];
			foreach ($_prices as $price) {
				$prices[$price['name']] = $price['price'];
			}
			$type = get_field('ticket_type', $cart_item['event_entry']);
			$price = $prices[$type];
			$additional_attendees = get_field( 'additional_attendees', $cart_item['event_entry']);
              if($additional_attendees){
          			foreach ($additional_attendees as $additional_attendee) {
          				$price += $prices[$additional_attendee['ticket_type']];
          			}
              }
			$cart_item['data']->set_price($price);
		}
	}
});



// Function for sending attendee email details to Prospect
function process_admin_attendee_email($attendee) {

  $attendee_details = get_attendee_post_meta($attendee->ID);
  $event_id = get_post_meta($attendee->ID, 'event_id', true);

  $message = '<p style="font-size:18px;">New completed attendee details for: ' . get_the_title($event_id) . '<br/></p>';

  if($attendee_details){
    $message .= '<table cellpadding="7" style="border-collapse: collapse;" >';
    foreach($attendee_details as $key => $value) {
      if (substr($key, 0, 1) != '_') {
        if($key == 'event_id') {
          $key = 'Event';
          $value = get_the_title($value[0]);
        } else {
          $value = $value;
        }
        $message .= '<tr>';
        $message .= '<td width="40%" style="border: 1px solid #999; padding: 0.5rem; text-align: left; text-transform: capitalize;">' . str_replace("_", " ", $key) . '</td>';
        $message .= '<td width="60%" style="border: 1px solid #999; padding: 0.5rem; text-align: left;">' . $value . '</td>';
        $message .= '</tr>';
      }
    }
    $message .= '</table>';
  }

  $subject = 'New attendee completed';

  $headers = array(
    "MIME-Version: 1.0",
    "Content-Type: text/html;charset=utf-8"
  );

  $admin_email = 'fundraising&events@prospect-hospice.net';

  $mail = wp_mail( $admin_email, $subject, $message, implode("\r\n", $headers) );

}



function process_attendee_email($message, $attendee) {

  $details = get_conditional_attendee_details($attendee);
  $opt_out_link_text = get_field('new_attendee_email_opt_out_link_text', 'options');
  $link_text = get_field('new_attendee_email_link_text', 'options');

  if ($details) {
	  $user = new WP_User($details['user_id']);
	  $message = str_replace('{booker_name}', $details['first_name'] . ' ' . $details['last_name'], $message);
      $adt_rp_key = get_password_reset_key( $user );
  }

  $message = str_replace('{attendee_name}', $details['first_name'], $message);
  $message = str_replace('{attendee_full_name}', $details['first_name'] . ' ' . $details['last_name'], $message);
  $message = str_replace('{event_name}', get_the_title(get_field('event_id', $attendee->ID)), $message);
  $message = str_replace('{date}', attendee_details_cutoff_date(get_field('event_id', $attendee->ID)), $message);
  $message = str_replace('{complete_link}', '<a href="' . get_site_url() . '/attendee-form/?event_entry=' . $attendee->ID . '">Click here</a>', $message);
  $message = str_replace('{unsubscribe_link}', '<a href="' . get_site_url() . '/group-registration-opt-out?attendee=' . str_replace('+', '%2B', $details['email_address']) . '&event_entry=' . $attendee->ID . '">Click here</a>', $message);
  $message = str_replace('{password_reset}', '<a href="' . home_url() . '/my-account/lost-password/?key=' . $adt_rp_key . '&id=' . $attendee->ID . '">Set Password</a>', $message);

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
			if ($k === 'email_address') {
				update_post_meta($lead, 'email_address_adult_attendee', $v);
			}
		}
		$lead_user_id = get_post_meta($event_entry_id, 'event_user_id', true);
		update_post_meta($lead, 'event_id', $order_item->get_product()->get_id());
		update_post_meta($lead, 'event_user_id', $lead_user_id);
		update_post_meta($lead, '_last_notified', time());
        update_post_meta($lead, 'attendee_type', 'lead');


		$order_item->add_meta_data('_lead_entry', $lead);

		$post_data['post_parent'] = $lead;

        // Send Prospect email with lead booker details
        process_admin_attendee_email(get_post($lead));

		foreach ($additional_attendees as $ak=>$attendee) {
            // Check whether adult or child attendee (by email field), and remove other unecessary fields
            if($attendee['adult']['email_address_adult_attendee']) {
                unset($attendee['child']);
            } else if($attendee['child']['email_address_child_attendee']) {
                unset($attendee['adult']);
            }

            // Flatten multidimensional array so easier to work with
            $attendee = flatten_adult_fields($attendee);

            $new_attendee = wp_insert_post($post_data);

            foreach ($attendee as $k => $v) {

                // Manually set post meta for what type of attendee this is (used for ongoing logic).
                if($k == 'email_address_adult_attendee' || $k == 'email_address_child_attendee') {

                    if($k == 'email_address_child_attendee' ) {
                        update_post_meta($new_attendee, 'attendee_type', 'child');
                    } else {
                        update_post_meta($new_attendee, 'attendee_type', 'adult');
                    }

                }
                // @TODO This is where we need to think about nested arrays like 'child_consent' as an example. Can we use update_field and pass the field name?
                update_post_meta($new_attendee, $k, $v);


            }

            $details = get_conditional_attendee_details($new_attendee);

            // Skip account creation if email address isn't set (only possible if under 16/no email is checked)
            if ($details['email_address']) {
      			$user = get_user_by( 'email', $details['email_address']);
      			$new_user = false;
      			if (!$user) {
      				$user_data = [
      					'user_login' => strtolower(preg_replace('|[^a-z0-9_]|i', '', $details['first_name'] . '_' . $details['last_name'])),
      					'user_name'  => preg_replace('|[^a-z0-9_]|i', '', $details['first_name'] . '_' . $details['last_name']),
      					'user_email' => $details['email_address'],
      					'user_pass'  => null,
      				];
      				$user = wp_insert_user($user_data);
      				$user = get_user_by('ID', $user);
      				$new_user = true;
      			}
      			update_post_meta($new_attendee, 'event_user_id', $user->ID);
      			update_post_meta($new_attendee, '_last_notified', time());
            }

            update_post_meta($new_attendee, 'event_id', $order_item->get_product()->get_id());
            update_post_meta($new_attendee, 'lead_user_id', $lead_user_id);

			$form_complete = get_field('other_attendee_details', $new_attendee);
			// Check to make sure the lead booker hasn't filled out all of the attendee fields before emailing
			if (!is_attendee_complete($new_attendee) && $details['email_address']) {

				$to = $details['email_address'];

                if(get_post_meta($new_attendee, 'attendee_type', true) == 'child') {

                    $subject = get_field('new_attendee_email_subject_child', 'options');
                    $message = get_field('new_attendee_email_content_child', 'options');

                } else {

                    $subject = get_field('new_attendee_email_subject_adult', 'options');
                    $message = get_field('new_attendee_email_content_adult', 'options');

                }

				$headers = array(
					"MIME-Version: 1.0",
					"Content-Type: text/html;charset=utf-8"
				);

				$mail = wp_mail( $to, $subject, process_attendee_email($message, get_post($new_attendee) ), implode("\r\n", $headers) );

            // If attendee is completed, send admin
			} else {

                process_admin_attendee_email(get_post($new_attendee) );

            }

            $order_item->add_meta_data('_entry_' . $ak, $new_attendee);

		}
		wp_trash_post($event_entry_id);
		$order_item->save_meta_data();


	}
}, 10, 1 );




add_action( 'gform_after_submission', 'opt_out_handler', 10, 2);

function opt_out_handler($entry, $form) {
  // Make sure we're on the right form
  if ($form['title'] != 'Group Registration Opt-Out') {
    return;
  }

  $email = $entry[1];
  $event_entry = $entry[2];
  $user = get_user_by( 'email', $email);

  // Check the user exists as well as the event entry ID
  if ($user && get_post_status($event_entry)) {
    $parent_booking = get_lead_booking_id($event_entry);
    $details = get_conditional_attendee_details($event_entry);
    $lead_details = get_conditional_attendee_details($parent_booking);

    $user_already_existed = user_already_existed($user);

    if ($user_already_existed) {
      // Reset the attendee email address to the lead booking email
      update_post_meta($event_entry, $details['email_address_field'], $lead_details['email_address']);
      opt_out_email_notification($parent_booking, $event_entry);
    } else {
      // Reset the attendee email address to the lead booking email
      update_post_meta($event_entry, $details['email_address_field'], $lead_details['email_address']);
      // Delete the user
      require_once(ABSPATH.'wp-admin/includes/user.php' );
      wp_delete_user($user->ID);
      opt_out_email_notification($parent_booking, $event_entry);
    }
  }
}

// Return true/false if the user in question already has orders/applications in the system - used for GDPR opt outs in group reg
function user_already_existed($user) {

  $existed = false;

  $users_orders = get_posts(array(
    'numberposts' => -1,
    'meta_key'  => '_customer_user',
    'meta_value' => $user->ID,
    'post_type' => wc_get_order_types(),
    'post_status' => array_keys(wc_get_order_statuses()),
  ));

  $users_applications = get_field('applications', 'user_' . $user->ID);

  if ($users_orders || $users_applications) {
    $existed = true;
  }

  return $existed;
}

// Returns the ID of the lead booking
function get_lead_booking_id($id) {

  $parent_id = wp_get_post_parent_id( $id );

  if ($parent_id) {
    return $parent_id;
  }

  return false;
}

function opt_out_email_notification($parent_booking, $event_entry_id) {

  $details = get_conditional_attendee_details($parent_booking);

  $lead_booking_email = $details['email_address'];
  $lead_booking_name = $details['first_name'];

  $to = $lead_booking_email;
  $subject = get_field('opted_out_email_subject', 'options');
  $message = get_field('opted_out_email_content', 'options');

  $headers = array(
    "MIME-Version: 1.0",
    "Content-Type: text/html;charset=utf-8"
  );

  $event_entry = get_post($event_entry_id);

  $mail = wp_mail( $to, $subject, process_attendee_email($message, $event_entry ), implode("\r\n", $headers) );
}


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

add_filter('woocommerce_order_item_get_formatted_meta_data', function ($meta) {
	foreach ($meta as $k=>$m) {
        $details = get_conditional_attendee_details($m->value);
		if ($m->key == '_event_entry') {
			unset($meta[$k]);
			continue;
		} elseif ($m->key == 'event') {
			$m->display_key = 'Event';
		} else if ($m->key == '_lead_entry') {
			$m->display_key = 'Lead Entry';
			$m->display_value = sprintf('<a href="/wp-admin/post.php?post=%s&action=edit">%s %s</a>', $m->value, $details['first_name'], $details['last_name']);
		} elseif (strpos($m->key, '_entry_') !== false) {
			$m->display_key = 'Entry';
			$m->display_value = sprintf('<a href="/wp-admin/post.php?post=%s&action=edit">%s %s</a>', $m->value, $details['first_name'], $details['last_name']);
		}
		$meta[$k] = $m;
	}
	return $meta;
}, 99, 1);

function prospect_woo_account_menu_events($menu) {
	$menu = array_slice($menu, 0, 5, true) +
		[
			'savedbookings'     => __('Saved Event Bookings', 'prospect'),
			'attendingevents' => __('Your Event Attendees', 'prospect')
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


function is_attendee_complete($entry) {

	if (!is_numeric($entry)) {
		$entry = $entry->ID;
	}

	$fieldset = get_event_attendee_fieldset_id_conditional(get_post_meta($entry, 'event_id', true), get_post($entry));
	$fieldset = acf_get_fields($fieldset);

	if (!$fieldset) {
		return true; // what else can we do?
	}

	$required = [];
	foreach ($fieldset as $k=>$v) {
		if ($v['name'] == 'other_attendee_details') continue; // ignore this one
		if ($v['required']) {
			$required[] = $v['name'];
		}
        if(isset($v['sub_fields'])) {
            foreach($v['sub_fields'] as $s_k => $s_v) {
                if ($s_v['required']) {
        			$required[] = $s_v['name'];
        		}
            }
        }

	}

	foreach ($required as $field ) {
		if (empty(get_field($field, $entry))) {
			return false;
		}
	}

	return true;
}



add_action('acf/save_post', function ($post_id) {


  if (get_post_type($post_id) != 'event-entry') return;


  if (!(is_attendee_complete($post_id))) return;

  $attendee_meta = get_attendee_post_meta($post_id);
  unset($attendee_meta['_last_emailed_hash']);
  $hash = md5(serialize($attendee_meta));

  if ($hash != get_post_meta($post_id, '_last_emailed_hash', true)) {
    process_admin_attendee_email(get_post($post_id));
    update_post_meta($post_id, '_last_emailed_hash', $hash);
  }

  // If attendee completed hasn't already been sent, send to lead booker
  if (!get_post_meta($post_id, '_attendee_complete_email_sent', true)) {
  	send_attendee_complete_mail($post_id);
  }



  update_post_meta($post_id, '_attendee_complete', 1);
  update_post_meta($post_id, '_attendee_complete_email_sent', 1);

}, 20);

function send_attendee_complete_mail($post_id) {

    $subject = get_field('attendee_complete_email_subject', 'options');
	$message = get_field('attendee_complete_email_content', 'options');

	$headers = array(
		"MIME-Version: 1.0",
		"Content-Type: text/html;charset=utf-8"
	);

	$user = get_field('lead_user_id', $post_id);
	if (!$user) $user = get_field('event_user_id', $post_id);
	$user = new WP_User($user);

	$mail = wp_mail( $user->user_email, $subject, process_attendee_email($message, get_post($post_id) ), implode("\r\n", $headers) );

}


add_action('wp', function () {
	if (! wp_next_scheduled ( 'send_event_reminder_emails' )) {
		wp_schedule_event(time(), 'daily', 'send_event_reminder_emails');
	}
	if (! wp_next_scheduled ( 'clear_passed_event_data' )) {
		wp_schedule_event(time(), 'daily', 'clear_passed_event_data');
	}
});

add_action('send_event_reminder_emails', 'do_send_event_reminder_emails');
add_action('clear_passed_event_data', 'do_clear_passed_event_data');

function do_send_event_reminder_emails() {

	$args = [
		'post_type'      => 'event-entry',
		'posts_per_page' => -1,
		'meta_query'     => array(
			'relation' => 'OR',
			array(
				'key'     => '_attendee_complete',
				'compare' => 'NOT EXISTS'
			),
			array(
				'key'   => '_attendee_complete',
				'value' => 0
			)
		)
	];

	$entries = get_posts($args);

	$offset = 60 * 60 * 24 * 7; // a week - we send reminders once it's been a week
	foreach ($entries as $entry) {
		$last_time = (int)get_post_meta($entry->ID, '_last_notified', true);

		// check time elapsed since last email + check not complete - should never be the case, but just in case
		if (time() - $last_time > $offset && !is_attendee_complete($entry)) {

			send_attendee_reminder_mail($entry->ID);

 			update_post_meta($entry->ID, '_last_notified', time());
		}
	}

}

function send_attendee_reminder_mail($post_id) {

    $details = get_conditional_attendee_details($post_id);

	$to = $details['email_address'];
	$subject = get_field('attendee_reminder_email_subject', 'options');
	$message = get_field('attendee_reminder_email_content', 'options');

	$headers = array(
		"MIME-Version: 1.0",
		"Content-Type: text/html;charset=utf-8"
	);

	$mail = wp_mail( $to, $subject, process_attendee_email($message, get_post($post_id) ), implode("\r\n", $headers) );
}

add_filter( 'password_reset_expiration', function( $expiration ) {
	return MONTH_IN_SECONDS;
});


add_filter('acf/get_field_group', function ($group) {
	static $filtering = [];
	if (!isset($filtering[$group['key']]) && is_admin() && function_exists('get_current_screen')) {
		$filtering[$group['key']] = true;
		$get_current_screen = get_current_screen();
		if ($get_current_screen->post_type == 'event-entry') {

			$entry_id = $_GET['post'];
			$fieldset = get_event_attendee_fieldset_id_conditional(get_post_meta($entry_id, 'event_id', true), get_post($entry_id));
			if (
				$group['key'] == $fieldset
			) {
				$group['location'] = array(
					array(
						array(
							'param'    => 'post_type',
							'operator' => '==',
							'value'    => 'event-entry',
						),
					),
				);
			}

		}
		unset($filtering[$group['key']]);

	}
	return $group;
});



// JS to remove the 'Additional attendee' repeater when editing the post in the CMS. Also a front-end version to do this.
add_action('admin_footer', function() {

    $current_screen = get_current_screen();
    if( $current_screen->id === "event-entry" ) {
        echo '
        <script>jQuery(document).ready(function($) {
            $(".acf-field[data-name=additional_attendees]").remove();
        });
        </script>';

    }

});


function do_clear_passed_event_data() {
	$args = array(
		'post_type'      => 'product',
		'posts_per_page' => -1,
		'tax_query'      => array(
			array(
				'taxonomy' => 'product_type',
				'field'    => 'slug',
				'terms'    => 'prospect_event',
			),
		),
	);
	$posts = get_posts($args);
	foreach ($posts as $post) {
		if (empty(get_post_meta($post->ID, 'event_end_date', true))) continue;
		$end = new DateTime(get_post_meta($post->ID, 'event_end_date', true) . ' ' . get_post_meta($post->ID, 'event_end_time', true));
		if (!$end) continue;

		$now = new DateTime;
		if ($end > $now) continue;

		$entryargs = [
			'post_type'      => 'event-entry',
			'posts_per_page' => -1,
			'meta_query'     => array(
				array(
					'key'   => 'event_id',
					'value' => $post->ID
				),
			)
		];
		$entries = get_posts($entryargs);
		foreach ($entries as $entry) {
			wp_delete_post($entry->ID);
		}

		$entryargs['post_type'] = 'draft-event-entry';
		$entries = get_posts($entryargs);
		foreach ($entries as $entry) {
			wp_delete_post($entry->ID);
		}

		wp_trash_post($post->ID);
	}

}

function event_are_attendees_editable($event_id)
{
	return days_to_event($event_id) > 7;
}

function days_to_event($event_id) {
	$event_start_date = get_field('event_start_date', $event_id);
	if (empty($event_start_date)) return 0; // what else can we do? no bookings is safer - client will notice and raise it
	$datetime1 = new DateTime(date('Y-m-d'));
	$datetime2 = new DateTime($event_start_date);
	$interval = $datetime1->diff($datetime2);
	return $interval->format("%r%a");
}


function attendee_details_cutoff_date($event_id) {
	$event_start_date = get_field('event_start_date', $event_id);
	if (empty($event_start_date)) return 0; // what else can we do? no bookings is safer - client will notice and raise it
    $event_start_date = new DateTime($event_start_date);
    $event_start_date->sub(new DateInterval('P7D'));
    $cut_off = $event_start_date->format('d/m/y');

    return $cut_off;
}

//add_action('wp', 'do_clear_passed_event_data');
//add_action('wp', function () { send_attendee_complete_mail(1249); } );



function array_flatten($array) {
  if (!is_array($array)) {
    return false;
  }
  $result = array();
  foreach ($array as $key => $value) {
    if (is_array($value)) {
      $result = array_merge($result, array_flatten($value));
    } else {
      $result[$key] = $value;
    }
  }
  return $result;
}


// Flattens the adult fields so the attendee_details group is at the same level
function flatten_adult_fields($array) {
  if (!is_array($array)) {
    return false;
  }
  $result = array();
  foreach ($array as $key => $value) {
      if($key == 'attendee_details') {
          $result = array_merge($result, array_flatten($value));
      } else {
        $result[$key] = $value;
      }
  }
  return $result;
}





function get_conditional_attendee_details($attendee) {

    if (!is_object($attendee)) {
        $attendee = get_post($attendee);
        if(!$attendee) {
            return false;
        }
    }

    $details = array();

    if(get_post_meta($attendee->ID, 'attendee_type', true) == 'lead') {

        $details['first_name'] = get_post_meta($attendee->ID, 'first_name', true);
        $details['last_name'] = get_post_meta($attendee->ID, 'last_name', true);
        $details['email_address'] = get_post_meta($attendee->ID, 'email_address', true);
        $details['email_address_field'] = 'email_address';
        $details['user_id'] = $attendee->ID;


    } else if(get_post_meta($attendee->ID, 'attendee_type', true) == 'adult') {

        $details['first_name'] = get_post_meta($attendee->ID, 'first_name', true);
        $details['last_name'] = get_post_meta($attendee->ID, 'last_name', true);
        $details['email_address'] = get_post_meta($attendee->ID, 'email_address_adult_attendee', true);
        $details['email_address_field'] = 'email_address_adult_attendee';
        $details['user_id'] = $attendee->ID;

    } else if(get_post_meta($attendee->ID, 'attendee_type', true) == 'child') {

        $details['first_name'] = get_post_meta($attendee->ID, 'guardian_first_name', true);
        $details['last_name'] = get_post_meta($attendee->ID, 'guardian_last_name', true);
        $details['email_address'] = get_post_meta($attendee->ID, 'email_address_child_attendee', true);
        $details['email_address_field'] = 'email_address_child_attendee';
        $details['user_id'] = $attendee->ID;

    } else { // Need to think of a better solution for lead to use the top-level fields

        $details['first_name'] = get_post_meta($attendee->ID, 'first_name', true);
        $details['last_name'] = get_post_meta($attendee->ID, 'last_name', true);
        $details['email_address'] = get_post_meta($attendee->ID, 'email_address', true);
        $details['email_address_field'] = 'email_address';
        $details['user_id'] = $attendee->ID;

    }

    return $details;

}


function behaviour_code_shortcode( ) {

    $markup = '';

    $code_of_conduct = get_field('event_behaviour_code_content', 'options');
    if($code_of_conduct):
          $markup = '<a href="#code-of-conduct-content" rel="modal:open" class="acf-field d-block code-of-conduct-link">Click here to read our behaviour code.<br/></a>
          <div id="code-of-conduct-content" class="modal">' . $code_of_conduct . '</div>';
     endif;

	return $markup;
}
add_shortcode( 'bevaviour_code', 'behaviour_code_shortcode' );




function event_terms_code_shortcode( ) {

    $markup = '';
    $markup = '<a href="#event-terms-modal" rel="modal:open">Click here to read our terms &amp; conditions</a>';

	return $markup;
}
add_shortcode( 'terms_conditions', 'event_terms_code_shortcode' );



// Allow for shortcodes in message field
add_filter('acf/load_field/type=message', function ($field ) {
    if(is_admin()) return $field;

    $field['message'] = do_shortcode($field['message']);
    return $field;

}, 10, 3);


function acf_load_field_allow_shortcode($field ) {
    if(is_admin()) return $field;

    $field['instructions'] = do_shortcode($field['instructions']);
    return $field;
}
add_filter('acf/load_field/type=select', 'acf_load_field_allow_shortcode', 10, 3);
add_filter('acf/load_field/type=true_false', 'acf_load_field_allow_shortcode', 10, 3);
