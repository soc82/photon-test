<?php

/*************************************
** Event Functions
**************************************/

/*
** Create custom 'Event' product type
*/
function register_prospect_event_product_type() {

    class WC_Product_Event extends WC_Product {

        public $product_type = 'prospect_event';
        public function __construct( $product ) {
            parent::__construct( $product );
        }

		public function get_sold_individually($context = 'view')
		{
			return true; // means no quantity
		}

		public function is_virtual()
		{
			return true;
		}

	}
}
add_action( 'init', 'register_prospect_event_product_type' );


function add_prospect_event_package_product( $types ){
   $types[ 'prospect_event' ] = __( 'Event' );
return $types;

}
add_filter( 'product_type_selector', 'add_prospect_event_package_product' );

function prospect_woocommerce_product_class( $classname, $product_type ) {

    if ( $product_type == 'prospect_event' ) { // notice the checking here.
        $classname = 'WC_Product_Event';
    }

    return $classname;
}

add_filter( 'woocommerce_product_class', 'prospect_woocommerce_product_class', 10, 2 );

// First Register the Tab by hooking into the 'woocommerce_product_data_tabs' filter
add_filter( 'woocommerce_product_data_tabs', 'prospect_add_event_data_tab' );
function prospect_add_event_data_tab( $product_data_tabs ) {
    $product_data_tabs['event_details'] = array(
        'label' => __( 'Event Details', 'woocommerce' ),
        'target' => 'event_details',
        'class'     => array( 'show_if_event' ),
    );
    return $product_data_tabs;
}


function prospect_product_admin_js() {

    if ('product' != get_post_type()) :
        return;
    endif;
    ?>
    <script type='text/javascript'>

        jQuery( function($){
            $( 'body' ).on( 'woocommerce-product-type-change', function( event, select_val, select ) {
              console.log(select_val);
                if ( select_val === 'prospect_event' ) {
                    $('#event_details, #acf-group_5b6013b903006, .event_details_tab').show();
                    $('.advanced_options, .linked_product_options, .attribute_options, .shipping_options, .inventory_options').hide();
                    $('.event_details_options a').trigger('click');
                } else if ( select_val === 'simple' ) {
                    $('#event_details, .inventory_options, #acf-group_5b6013b903006, .event_details_tab').hide();
                    $('.general_options, .pricing, .inventory_tab, .shipping_options, .linked_product_tab, .attribute_tab, .advanced_tab').show();
                } else if ( select_val === 'variable' ) {
                    $('#event_details, .inventory_options, #acf-group_5b6013b903006, .event_details_tab').hide();
                    $('.variations_tab, .inventory_tab, .shipping_options, .linked_product_tab, .attribute_tab, .advanced_tab').show();
                }
            } );
            $( 'select#product-type' ).change();

            $('#event_bookable').change(function() {
                if($('#event_bookable').prop('checked')) {
                    $('.external-booking-link-field').hide();
                    $('.booking-form-key-field').show();
                    jQuery('*[data-name="event_form"]').show();
                    jQuery('*[data-name="ticket_types"]').show();

                } else {
                    $('.external-booking-link-field').show();
                    $('.booking-form-key-field').hide();
                    jQuery('*[data-name="event_form"]').hide();
                    jQuery('*[data-name="ticket_types"]').hide();
                }
            } );
            $( '#event_bookable' ).change();
        } );
    </script>
    <style>
    .show_if_event { display: none; }
    </style>
		<script>
      function initAutocomplete() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -33.8688, lng: 151.2195},
          zoom: 13,
          mapTypeId: 'roadmap'
        });

        // Create the search box and link it to the UI element.
        var input = document.getElementById('event_location');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });

        var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          if (places.length == 0) {
            return;
          }

          // Clear out the old markers.
          markers.forEach(function(marker) {
            marker.setMap(null);
          });
          markers = [];

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }
            var icon = {
              url: place.icon,
              size: new google.maps.Size(71, 71),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25)
            };

            // Create a marker for each place.
            markers.push(new google.maps.Marker({
              map: map,
              icon: icon,
              title: place.name,
              position: place.geometry.location
            }));

            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
          });
          map.fitBounds(bounds);
        });
      }

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyALC9P4YEEszUhuvABxSqXk8PzYSKa0T1c&libraries=places&callback=initAutocomplete"
         async defer></script>
		<style>
			.show_if_prospect_event { display: block; }
			#woocommerce-product-data ul.wc-tabs li.event_details_tab a:before { font-family: WooCommerce; content: '\e00e'; }
		</style>
    <?php

}
add_action('admin_footer', 'prospect_product_admin_js');


/*
** Custom woocommerce data panels for event product type
*/
add_action('woocommerce_product_data_panels', 'prospect_custom_product_data_fields');
function prospect_custom_product_data_fields() {
    global $post;

    // Note the 'id' attribute needs to match the 'target' parameter set above
    ?> <div id = 'event_details' class = 'panel woocommerce_options_panel' > <?php
        ?> <div class = 'options_group' >

				<div class="options-group">
            <p class="form-field">
              <label for="event_bookable">Bookable On Website?: <?php //print_r(get_post_meta($post->ID, 'event_bookable')); die();?> </label>
              <input type="checkbox" name="event_bookable" id="event_bookable" <?php if(!empty(get_post_meta($post->ID, 'event_bookable')[0]) && get_post_meta($post->ID, 'event_bookable')[0] != '') echo 'checked'; ?> />
            </p>

            <p class="form-field external-booking-link-field">
              <label for="external_booking_link">Booking Link (external): </label>
              <input type="text" name="external_booking_link" id="external_booking_link" class="short" <?php if(get_post_meta($post->ID, 'external_booking_link')) echo 'value="' . get_post_meta($post->ID, 'external_booking_link', true) . '"'; ?> />
            </p>
						<p class="form-field">
							<label for="event_start_date">Start Date: </label>
							<input type="date" name="event_start_date" id="event_start_date" class="short" <?php if(get_post_meta($post->ID, 'event_start_date')) echo 'value="' . get_post_meta($post->ID, 'event_start_date', true) . '"'; ?> />
						</p>
						<p class="form-field">
							<label for="event_start_time">Start Time: </label>
							<input type="time" name="event_start_time" id="event_start_time" class="short" <?php if(get_post_meta($post->ID, 'event_start_time')) echo 'value="' . get_post_meta($post->ID, 'event_start_time', true) . '"'; ?> />
						</p>

						<p class="form-field">
							<label for="event_end_date">End Date: </label>
							<input type="date" name="event_end_date" id="event_end_date" class="short" <?php if(get_post_meta($post->ID, 'event_end_date')) echo 'value="' . get_post_meta($post->ID, 'event_end_date', true) . '"'; ?> />
						</p>
					<p class="form-field">
						<label for="event_end_time">End Time: </label>
						<input type="time" name="event_end_time" id="event_end_time" class="short" <?php if(get_post_meta($post->ID, 'event_end_time')) echo 'value="' . get_post_meta($post->ID, 'event_end_time', true) . '"'; ?> />
					</p>

					<p class="form-field">
						<label for="event_location">Location: </label>
						<input type="text" name="event_location" id="event_location" class="short" <?php if(get_post_meta($post->ID, 'event_location')) echo 'value="' . get_post_meta($post->ID, 'event_location', true) . '"'; ?> />
						<div id="map"></div>
					</p>

				</div>

      </div>
    </div><?php
}


function prospect_save_event_custom_fields($post_id) {

    $bookable = $_POST['event_bookable'];
    if (!empty($bookable)) {
        update_post_meta($post_id, 'event_bookable', esc_attr($bookable));
    }else {
        update_post_meta($post_id, 'event_bookable', '');
    }

    $external_booking_link = $_POST['external_booking_link'];
    //if (!empty($external_booking_link)) {
        update_post_meta($post_id, 'external_booking_link', esc_attr($external_booking_link));
    //}
    $start_date = $_POST['event_start_date'];
    //if (!empty($start_date)) {
        update_post_meta($post_id, 'event_start_date', esc_attr($start_date));
    //}
		$start_time = $_POST['event_start_time'];
    //if (!empty($start_time)) {
        update_post_meta($post_id, 'event_start_time', esc_attr($start_time));
    //}
		$end_date = $_POST['event_end_date'];
		//if (!empty($end_date)) {
				update_post_meta($post_id, 'event_end_date', esc_attr($end_date));
		//}
		$end_time = $_POST['event_end_time'];
		//if (!empty($end_time)) {
				update_post_meta($post_id, 'event_end_time', esc_attr($end_time));
		//}
		$location = $_POST['event_location'];
		//if (!empty($location)) {
				update_post_meta($post_id, 'event_location', esc_attr($location));
		//}

}

add_action( 'woocommerce_process_product_meta_prospect_event', 'prospect_save_event_custom_fields'  );



/**
** Exclude event products from displaying in shop
*/
function prospect_exclude_events_query( $q ) {

    // Loop through product categories and find any that have event category set to true
    $categories = get_terms('product_cat');
    if($categories){
      $event_cats = array();
      foreach($categories as $cat){
        if(get_field('event_category', 'product_cat_' . $cat->term_id)){
          $event_cats[] = $cat->term_id;
        }
      }
    }
    // If any found, filter them out of the normal Woocommerce proudct query
    if(!empty($event_cats)) {
      $tax_query = (array) $q->get( 'tax_query' );
      $tax_query[] = array(
             'taxonomy' => 'product_cat',
             'field' => 'term_id',
             'terms' => $event_cats,
             'operator' => 'NOT IN'
      );
      $q->set( 'tax_query', $tax_query );
    }

}
add_action( 'woocommerce_product_query', 'prospect_exclude_events_query' );


/**
* Exclude any product categories which have been set as Event Category
*/
function get_subcategory_terms( $terms, $taxonomies, $args ) {

	$new_terms 	= array();

	if ( in_array( 'product_cat', $taxonomies ) && !is_admin() && is_shop() ) {
	    foreach ( $terms as $key => $term ) {
        $event_cal = get_field('event_category', 'product_cat_' . $term->term_id);
        if(!$event_cal){
          $new_terms[] = $term;
        }
	    }
	    $terms = $new_terms;
	}
  return $terms;
}
add_filter( 'get_terms', 'get_subcategory_terms', 10, 3 );


/*******************************
** Generic Woocommerce functions
*******************************/

// Set custom placeholder image
add_filter('woocommerce_placeholder_img_src', 'prospect_woocommerce_placeholder_image');
function prospect_woocommerce_placeholder_image( $src ) {
	$src = get_stylesheet_directory_uri() . '/img/coming-soon.jpg';
	return $src;
}

remove_action( 'woocommerce_sidebar' , 'woocommerce_get_sidebar', 10 );



// Change terminology used in Woocomerce
function prospect_custom_terminology(  $translated_text, $text, $text_domain ) {

  // bail if not modifying frontend woocommerce text
  if ( is_admin() || 'woocommerce' !== $text_domain ) {
    return $translated_text;
  }

  if ( 'Coupon code' === $text ) {
    $translated_text = __( 'Promo code', 'woocommerce' );

	} elseif ( 'Apply coupon' === $text ) {
    $translated_text = __( 'Apply', 'woocommerce' );
	} elseif ( 'Related products' === $text ) {
    $translated_text = __( 'You might also like...', 'woocommerce' );
	}

    return $translated_text;
}
add_filter( 'gettext', 'prospect_custom_terminology', 20, 3 );


/**
 * Overwrite product_tag taxonomy properties to effectively hide it from WP admin ..
 */
add_action('init', function() {
    register_taxonomy('product_tag', 'product', [
        'public'            => false,
        'show_ui'           => false,
        'show_admin_column' => false,
        'show_in_nav_menus' => false,
        'show_tagcloud'     => false,
    ]);
}, 100);

/**
 * .. and also remove the column from Products table - it's also hardcoded there.
 */
add_action( 'admin_init' , function() {
    add_filter('manage_product_posts_columns', function($columns) {
        unset($columns['product_tag']);
        return $columns;
    }, 100);
});


/**
* Show cart contents / total Ajax
*/
add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment' );

function woocommerce_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;
	ob_start(); ?>
	<a class="top-bar-cart" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php _e('View your shopping cart', 'prospect'); ?>"><i class="fal fa-shopping-bag"></i><?php echo $woocommerce->cart->get_cart_total(); ?></a>
	<?php
	$fragments['a.cart-customlocation'] = ob_get_clean();
	return $fragments;
}


/********************
** Wrapper functions
********************/

// Unhook Woocommerce wrappers
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

// Hook in Boson functions to add in own prospect wrappers
add_action('woocommerce_before_main_content', 'prospect_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'prospect_wrapper_end', 10);


function prospect_wrapper_start() {
 if(is_singular('product')):
  	$product = wc_get_product( get_the_ID());
  	$type = $product->get_type();
  else:
    $type = 'not-product';
  endif;
  echo '<div class="page-inner-wrapper ' . $type .'" >';
  echo '<div class="container">';
    echo '<div class="row">';
      echo '<div class="col-12">';
}
function prospect_wrapper_end() {
    echo '</div></div></div></div>';
}

// Declare Woocomerce theme support for prospect
function prospect_woocommerce_theme_support() {
  add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'prospect_woocommerce_theme_support' );


/********************************
** Product category modifications
*********************************/


// Remove category descriptions & title (included in banner instead)
remove_action( 'woocommerce_archive_description', 'woocommerce_product_archive_description', 10, 2 );
remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10, 2 );

// Wrap product category listings
function prospect_product_cat_thumbnail_wrapper_start( ) {
  echo '<div class="product-image-wrapper">';
};
add_action( 'woocommerce_before_subcategory_title', 'prospect_product_cat_thumbnail_wrapper_start', 9, 2 );

function prospect_product_cat_thumbnail_wrapper_end( ) {
  echo '</div>'; // End .product-image-wrapper
  echo '<div class="product-content-wrapper">';
};
add_action( 'woocommerce_before_subcategory_title', 'prospect_product_cat_thumbnail_wrapper_end', 11, 2 );



// Add button to product category listings
function prospect_product_cat_btn( $category ) {
    echo '</div>'; // End .product-cat-content-wrapper
    echo '<span class="btn btn-arrow-right">' . __('View products', 'prospect') . '</span>';
};
add_action( 'woocommerce_after_subcategory_title', 'prospect_product_cat_btn', 10, 1 );


/*
** Change number or products per row to 4
*/
add_filter('loop_shop_columns', 'prospect_product_columns');
if (!function_exists('loop_columns')) {
	function prospect_product_columns() {
		return 4;
	}
}


/********************************
** Product listing modifications
*********************************/

// Remove woocommerce link that only
//remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10, 2 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 15 );

// Wrap product listing item
function prospect_product_thumbnail_wrapper_start( ) {
  echo '<div class="product-image-wrapper">';
};
add_action( 'woocommerce_before_shop_loop_item_title', 'prospect_product_thumbnail_wrapper_start', 5, 2 );

function prospect_product_thumbnail_wrapper_end( ) {
  echo '</div>';
  echo '<div class="product-content-wrapper">';
};
add_action( 'woocommerce_before_shop_loop_item_title', 'prospect_product_thumbnail_wrapper_end', 15, 2 );

function prospect_product_btn( $category ) {
    echo '</div>'; // End .product-content-wrapper
    echo '<span class="btn btn-arrow-right">' . __('View', 'prospect') . '</span>';
};
add_action( 'woocommerce_after_shop_loop_item', 'prospect_product_btn', 14 );



/********************************
** Single product modifications
*********************************/

/*
** Here we are bypassing the normal woocommerce single product template and using a custom one.
** (Just because there aren't many woocommerce product similarities for events)
*/

add_filter('wc_get_template_part', 'prospect_single_event_template_redirect', 10, 3);
function prospect_single_event_template_redirect($template, $slug, $name) {
    if ($name === 'single-product' && $slug === 'content') {
        $product = wc_get_product( get_the_ID());
        if ( $product->get_type() == 'prospect_event' ) {
          $temp = get_stylesheet_directory() . '/templates/event-template.php';
          if($temp) {
             $template = $temp;
          }
        }
    }
    return $template;
}


/*
** Add wrapper to single product images
*/
add_action('woocommerce_before_single_product_summary', 'prospect_single_product_image_wrapper_start', 19);
function prospect_single_product_image_wrapper_start() {
  echo '<div class="single-product-images-wrapper">';
}
add_action('woocommerce_before_single_product_summary', 'prospect_single_product_image_wrapper_end', 21);
function prospect_single_product_image_wrapper_end() {
  echo '</div>';
}


/*
** Remove product data from product page
*/
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );


/*
** Change the related products output number
*/
function woo_related_products_limit() {
 global $product;
 $args['posts_per_page'] = 3;
 return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'prospect_related_products_output' );
 function prospect_related_products_output( $args ) {
 $args['posts_per_page'] = 3;
 $args['columns'] = 3;
 return $args;
}


/*
** Remove Woocommerce product reviews tab
*/
add_filter( 'woocommerce_product_tabs', 'prospect_remove_reviews_tab', 98 );
function prospect_remove_reviews_tab( $tabs ) {
    unset( $tabs['reviews'] );
    unset($tabs['additional_information']);
    return $tabs;
}




/***************************************
** Cart
***************************************/


/*
** Swap up-sells around with cart totals so up-sells is lower priority
*/
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
add_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display', 15 );



// Hide other shipping options if Free Delivery is available
function prospect_hide_other_shipping_if_free( $rates ) {
	$free = array();
	foreach ( $rates as $rate_id => $rate ) {
		if ( 'free_shipping' === $rate->method_id ) {
			$free[ $rate_id ] = $rate;
			break;
		}
	}
	return ! empty( $free ) ? $free : $rates;
}
add_filter( 'woocommerce_package_rates', 'prospect_hide_other_shipping_if_free', 100 );


add_action( 'woocommerce_review_order_before_submit', 'add_privacy_checkbox', 9 );
function add_privacy_checkbox() {
  $privacy_policy = get_field('privacy_policy_page', 'options');
  woocommerce_form_field( 'privacy_policy', array(
    'type' => 'checkbox',
    'class' => array('form-row privacy'),
    'label_class' => array('woocommerce-form__label woocommerce-form__label-for-checkbox checkbox'),
    'input_class' => array('woocommerce-form__input woocommerce-form__input-checkbox input-checkbox'),
    'required' => true,
    'label' => 'I\'ve read and accept the <a href="' . get_permalink($privacy_policy) . '">Privacy Policy</a>',
  ));
}
add_action( 'woocommerce_checkout_process', 'privacy_checkbox_error_message' );
function privacy_checkbox_error_message() {
  if ( ! (int) isset( $_POST['privacy_policy'] ) ) {
    wc_add_notice( __( 'You have to agree to our privacy policy in order to proceed' ), 'error' );
  }
}


/*
** Add marketing consent to checkout
*/
add_action( 'woocommerce_review_order_before_submit', 'custom_checkout_field_with_markketing_consent_option' );
function custom_checkout_field_with_markketing_consent_option( $checkout ) {

  $user = wp_get_current_user();
  $consent_meta = get_user_meta($user->ID, 'marketing_consent');
  // Only show marketing consent if not already checked
  if($consent_meta == 'no'):
      woocommerce_form_field('newsletter_checkbox', array(
          'type' => 'checkbox',
          'class' => array('form-row privacy'),
          'label_class' => array('woocommerce-form__label woocommerce-form__label-for-checkbox checkbox'),
          'input_class' => array('woocommerce-form__input woocommerce-form__input-checkbox input-checkbox'),
          'label' => __('Subscribe to our newsletter?'),
          'required' => false,
      ), '');
    endif;
}


/*
** Save user meta on checkout completion
*/
add_action( 'woocommerce_checkout_update_order_meta', 'marketing_consent_option_update_user_meta' );
function marketing_consent_option_update_user_meta( $order_id ) {
  $user_id = get_post_meta( $order_id, '_customer_user', true );
  $consent_meta = get_user_meta($user_id, 'marketing_consent');
  if($consent_meta == 'no'):
    if ( isset($_POST['newsletter_checkbox']) ) {
      update_user_meta( $user_id, 'marketing_consent', 'yes' );
    } else {
      update_user_meta( $user_id, 'marketing_consent', 'no' );
    }
  endif;
}


/*
** Get Add to Cart link - Used for custom event pages
*/
function prospect_add_product_to_cart($post_id) {
  global $woocommerce;
  $url = $woocommerce->cart->get_cart_url() . '?add-to-cart=' . $post_id;
  return $url;
}

/*
** Redirect after add to cart - removes the add-to-cart query arg used in event template

add_action('woocommerce_add_to_cart_redirect', 'prospect_to_cart_redirect');
function prospect_to_cart_redirect($url = false) {
  if(!empty($url)) {
    return $url;
  }
  return wc_get_cart_url() . add_query_arg(array(), remove_query_arg(array('add-to-cart', 'quantity', 'event_entry_id')));
}
*/

function my_get_the_product_thumbnail_url( $size = 'shop_catalog' ) {
  global $post;
  $image_size = apply_filters( 'single_product_archive_thumbnail_size', $size );
  return get_the_post_thumbnail_url( $post->ID, $image_size );
}



/***************************************
** My Account
***************************************/

function prospect_get_userdata( $user_id, $key ) {
   if ( ! prospect_is_userdata( $key ) ) {
       return get_user_meta( $user_id, $key );
   }

   $userdata = get_userdata( $user_id );

   if ( ! $userdata || ! isset( $userdata->{$key} ) ) {
       return '';
   }

   return $userdata->{$key};
}

/*
** Additional account fields
*/
function prospect_get_account_fields() {

  echo "How you would like to hear from us <a href='/how-you-hear-from-us/'>Click Here</a>";

    return apply_filters( 'prospect_account_fields', array(
        /*'fundraising_opt_in' => array(
            'type'        => 'checkbox',
            'label'       => __( 'I\'m happy to receive communications regarding fundraising events & ideas', 'prospect' ),
            //'placeholder' => __( 'Some text...', 'prospect' ),
            'required'    => false,
        ),
        'job_opt_in' => array(
            'type'        => 'checkbox',
            'label'       => __( 'I\'m happy to be considered for similar jobs i have previously applied for', 'prospect' ),
            'required'    => false,
        ),*/
    ) );
}

/**
 * Add fields to registration form and account area.
*/
function prospect_print_user_frontend_fields() {
    $fields            = prospect_get_account_fields();
    $is_user_logged_in = is_user_logged_in();

    foreach ( $fields as $key => $field_args ) {
        $value = null;

        if ( $is_user_logged_in && ! empty( $field_args['hide_in_account'] ) ) {
            continue;
        }

        if ( ! $is_user_logged_in && ! empty( $field_args['hide_in_registration'] ) ) {
            continue;
        }

        if ( $is_user_logged_in ) {
            $user_id = prospect_get_edit_user_id();
            $value   = prospect_get_userdata( $user_id, $key );
        }

        $value = isset( $field_args['value'] ) ? $field_args['value'] : $value;

        woocommerce_form_field( $key, $field_args, array_shift($value) );
    }
}
add_action( 'woocommerce_edit_account_form', 'prospect_print_user_frontend_fields', 10 );

/**
 * Add fields to admin area.
*/
function prospect_print_user_admin_fields() {
    $fields = prospect_get_account_fields();
    ?>
    <h2><?php _e( 'Additional Information', 'iconic' ); ?></h2>
    <table class="form-table" id="iconic-additional-information">
        <tbody>
        <?php foreach ( $fields as $key => $field_args ) { ?>
            <?php
            if ( ! empty( $field_args['hide_in_admin'] ) ) {
                continue;
            }

            $user_id = prospect_get_edit_user_id();
            $value   = prospect_get_userdata( $user_id, $key );
            ?>
            <tr>
                <th>
                    <label for="<?php echo $key; ?>"><?php echo $field_args['label']; ?></label>
                </th>
                <td>
                    <?php $field_args['label'] = false; ?>
                    <?php woocommerce_form_field( $key, $field_args, array_shift($value) ); ?>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php
}
add_action( 'show_user_profile', 'prospect_print_user_admin_fields', 30 ); // admin: edit profile
add_action( 'edit_user_profile', 'prospect_print_user_admin_fields', 30 ); // admin: edit other users

/**
 * Get currently editing user ID (frontend account/edit profile/edit other user).
*/
function prospect_get_edit_user_id() {
    return isset( $_GET['user_id'] ) ? (int) $_GET['user_id'] : get_current_user_id();
}


function prospect_is_userdata( $key ) {
    $userdata = array(
        'user_pass',
        'user_login',
        'user_nicename',
        'user_url',
        'user_email',
        'display_name',
        'nickname',
        'first_name',
        'last_name',
        'description',
        'rich_editing',
        'user_registered',
        'role',
        'jabber',
        'aim',
        'yim',
        'show_admin_bar_front',
    );

    return in_array( $key, $userdata );
}



function prospect_save_account_fields( $customer_id ) {
    $fields = prospect_get_account_fields();
    $sanitized_data = array();

    foreach ( $fields as $key => $field_args ) {

        $sanitize = isset( $field_args['sanitize'] ) ? $field_args['sanitize'] : 'wc_clean';
        $value    = isset( $_POST[ $key ] ) ? call_user_func( $sanitize, $_POST[ $key ] ) : '';

        if ( prospect_is_userdata( $key ) ) {
    			$sanitized_data[ $key ] = $value;
    			continue;
    		}

        update_user_meta( $customer_id, $key, $value );
    }


    if ( ! empty( $sanitized_data ) ) {
        $sanitized_data['ID'] = $customer_id;
        wp_update_user( $sanitized_data );
    }

}

add_action( 'woocommerce_created_customer', 'prospect_save_account_fields' ); // register/checkout
add_action( 'personal_options_update', 'prospect_save_account_fields' ); // edit own account admin
add_action( 'edit_user_profile_update', 'prospect_save_account_fields' ); // edit other account admin
add_action( 'woocommerce_save_account_details', 'prospect_save_account_fields' ); // edit WC account



/*
** Send email notifications to different people based on product
** This now overrides the standard woocommerce email recipient settings
*/
add_filter( 'woocommerce_email_recipient_new_order', 'woocommerce_event_recipient_email', 10, 2 );
function woocommerce_event_recipient_email( $recipient, $order ) {
    if ( ! is_a( $order, 'WC_Order' ) ) return $recipient;

    $events = false;
    $standard = false;

    foreach( $order->get_items() as $item_id => $line_item ){

        $product = wc_get_product( $line_item->get_product_id() );
        if( $product->is_type( 'prospect_event' ) ) {
          $events = true;
        } else {
          $standard = true;
        }

    }

    if($events && $standard){
      $recipient .= ', fundraising&events@prospect-hospice.net';
    } else if($events) {
      $recipient = 'fundraising&events@prospect-hospice.net';
    } else {
      $recipient = 'alisonmoore@prospect-hospice.net';
    }


    return $recipient;
}



// Hook in
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );

// Our hooked in function - $fields is passed via the filter!
function custom_override_checkout_fields( $fields ) {

  $chosen_methods = WC()->session->get('chosen_shipping_methods');
  $chosen_shipping = $chosen_methods[0];

    $store_args = array(
      'post_type' => 'shop',
      'posts_per_page'  => -1,
      'order' => 'ASC',
      'orderby' => 'name',
    );
    $stores_array = array('-'=>'Please select');
    $stores = new WP_Query($store_args);
    if($stores) :
      foreach ($stores->posts as $store) :
        $stores_array[$store->post_title] = $store->post_title;
      endforeach;
    endif;


    $fields['order']['shipping_store'] = array(
      'type'          => 'select',
      'label'     => __('Which store will you want to collect it from?', 'woocommerce'),
      'options'       => $stores_array,
      'required'  => true,
      'class'     => array('form-row-wide'),
      'clear'     => true
    );

  return $fields;

}

/**
 * Display field value on the order edit page
 */

add_action( 'woocommerce_admin_order_data_after_shipping_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1 );

function my_custom_checkout_field_display_admin_order_meta($order){
    $display = false;
    foreach ( $order->get_shipping_methods() as $shipping_method  ) {
		$shipping_method_id = current( explode( ':', $shipping_method['method_id'] ) );
		if ($shipping_method_id == 'local_pickup') {
		    $display = true;
        }
    }
    if ($display) echo '<p><strong>'.__('Store Pickup From Checkout Form').':</strong> ' . get_post_meta( $order->get_id(), '_shipping_store', true ) . '</p>';
}

//add_filter('woocommerce_order_get_shipping_address_1', function ($value, $order) {
//	$display = false;
//	foreach ( $order->get_shipping_methods() as $shipping_method  ) {
//		$shipping_method_id = current( explode( ':', $shipping_method['method_id'] ) );
//		if ($shipping_method_id != 'local_pickup') {
//			$display = true;
//		}
//		if (!$display) {
//		    $value = '';
//        }
//	}
//	return $value;
//}, 10, 2);
//

add_filter('wc_customer_order_csv_export_order_row', function ($order_data, $order) {
    $storepickup = false;
    
    foreach ( $order->get_shipping_methods() as $shipping_method  ) {
		$shipping_method_id = current( explode( ':', $shipping_method['method_id'] ) );
		if ($shipping_method_id == 'local_pickup') {
			$storepickup = true;
		}
	}

	if ($storepickup) {
        $order_data['shipping_company'] = '';
        $order_data['shipping_address_1'] = '';
        $order_data['shipping_address_2'] = '';
        $order_data['shipping_postcode'] = '';
        $order_data['shipping_city'] = '';
        $order_data['shipping_state'] = '';
        $order_data['shipping_state_code'] = '';
        $order_data['shipping_country'] = '';
    } else {
	    $order_data['meta:_shipping_store'] = '';
    }


	return $order_data;
}, 99, 2);

/**
 * Update the order meta with field value
**/
add_action('woocommerce_checkout_update_order_meta', 'my_custom_checkout_field_update_order_meta');
function my_custom_checkout_field_update_order_meta( $order_id ) {
    if ($_POST['shipping_store']) update_post_meta( $order_id, 'Store Pickup', esc_attr($_POST['shipping_store']));
}
/**
 * Add the field to order emails
 **/
add_filter('woocommerce_email_order_meta_keys', 'my_custom_checkout_field_order_meta_keys');
function my_custom_checkout_field_order_meta_keys( $keys ) {
    $keys[] = 'Store Pickup';
    return $keys;
}


/*
** Add custom content to order confirmation page
*/
add_filter('woocommerce_thankyou_order_received_text', 'woo_change_order_received_text', 10, 2 );
function woo_change_order_received_text( $str, $order ) {
    $items = $order->get_items();
    foreach($items as $item){
      $confirmation_text = get_field('confirmation_message', $item['product_id']);
      if($confirmation_text){
        $str = $str . '<p class="woocommerce-thankyou-order-received">' . $confirmation_text . '</p>';
      }
    }
    return $str;
}


// JS to show/hide shipping fields if shipping method is changed
add_action('wp_footer', 'woo_shipping_fields_show_hide', 50);
function woo_shipping_fields_show_hide() {
    if ( ! is_checkout() ) return;
    ?>
    <script type="text/javascript">
        jQuery(function($){
            $( document.body ).on( 'update_checkout', function(){

              var selectedShipping = $('.shipping_method:checked').val();
              if(selectedShipping == 'local_pickup:2'){
                $('.woocommerce-shipping-fields').hide();
                $('#shipping_store_field').show();
              } else {
                $('.woocommerce-shipping-fields').show();
                $('#shipping_store_field').hide();

              }
            });
            $(document.body).trigger('update_checkout');
        });
    </script>
    <?php
}
