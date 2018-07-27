<?php

/*************************************
** Woocommerce specific functions
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
      // This example adds a search box to a map, using the Google Place Autocomplete
      // feature. People can enter geographical searches. The search box will return a
      // pick list containing a mix of places and predicted search terms.

      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

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




// functions you can call to output text boxes, select boxes, etc.
add_action('woocommerce_product_data_panels', 'woocom_custom_product_data_fields');

function woocom_custom_product_data_fields() {
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
