<?php

/*************************************
** Event Functions
**************************************/

/*
** Create custom 'Event' product type
*/
function register_prospect_event_product_type() {

    class WC_Product_package extends WC_Product {

        public $product_type = 'prospect_event';
        public function __construct( $product ) {
            parent::__construct( $product );
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
        $classname = 'WC_Product_package';
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
        jQuery(document).ready(function () {
            //for Price tab
            jQuery('.product_data_tabs .general_tab').addClass('show-field').show();
            jQuery('#general_product_data .pricing').addClass('show-field').show();
            //for Inventory tab
            jQuery('.inventory_options').addClass('show-field').show();
            jQuery('#inventory_product_data ._manage_stock_field').addClass('show-field').show();
            jQuery('#inventory_product_data ._sold_individually_field').parent().addClass('show-field').show();
            jQuery('#inventory_product_data ._sold_individually_field').addClass('show-field').show();
        });
				jQuery( function($){
				    $( 'body' ).on( 'woocommerce-product-type-change', function( event, select_val, select ) {
				        if ( select_val === 'prospect_event' ) {
				            $( '.event_details_tab' ).show();
				        } else {
									$( '.event_details_tab' ).hide();
								}
				    } );
				    $( 'select#product-type' ).change();
				} );
    </script>
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
			.show_if_event { display: none; }
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

    $start_date = $_POST['event_start_date'];
    if (!empty($start_date)) {
        update_post_meta($post_id, 'event_start_date', esc_attr($start_date));
    }
		$start_time = $_POST['event_start_time'];
    if (!empty($start_time)) {
        update_post_meta($post_id, 'event_start_time', esc_attr($start_time));
    }

		$end_date = $_POST['event_end_date'];
		if (!empty($end_date)) {
				update_post_meta($post_id, 'event_end_date', esc_attr($end_date));
		}
		$end_time = $_POST['event_end_time'];
		if (!empty($end_time)) {
				update_post_meta($post_id, 'event_end_time', esc_attr($end_time));
		}

		$location = $_POST['event_location'];
		if (!empty($location)) {
				update_post_meta($post_id, 'event_location', esc_attr($location));
		}

}

add_action( 'woocommerce_process_product_meta_prospect_event', 'prospect_save_event_custom_fields'  );



/**
** Exclude event product type from shop query
*/
function prospect_exclude_events_query( $q ) {

    $tax_query = (array) $q->get( 'tax_query' );
    $tax_query[] = array(
           'taxonomy' => 'product_cat',
           'field' => 'slug',
           'terms' => array( 'clothing' ), // Don't display products in the clothing category on the shop page.
           'operator' => 'NOT IN'
    );

    $q->set( 'tax_query', $tax_query );

}
add_action( 'woocommerce_product_query', 'prospect_exclude_events_query' );




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



add_action('woocommerce_before_single_product_summary', 'prospect_single_product_image_wrapper_start', 19);
function prospect_single_product_image_wrapper_start() {
  echo '<div class="single-product-images-wrapper">';
}
add_action('woocommerce_before_single_product_summary', 'prospect_single_product_image_wrapper_end', 21);
function prospect_single_product_image_wrapper_end() {
  echo '</div>';
}



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
  $consent_meta = get_user_meta($user->id, 'marketing_consent');
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
