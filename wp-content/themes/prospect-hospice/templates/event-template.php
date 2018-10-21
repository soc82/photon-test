<?php
/*
** Template overide for woocommerce single product (just for event product type)
*/

get_header(); ?>

<?php
$event = prospect_get_event_info();
$banner = get_field('event_banner');
$event_page = get_field('events_calendar_page', 'options');

if($banner): ?>
      </div>
    </div>
  </div>
  <div class="event-hero-banner" style="background:url(<?php echo $banner['sizes']['slider']; ?>)">
  	<div class="hero-container">
  		<p class="hero-heading" <?php if($event['color']) echo 'style="background:' . $event['color'] . '"'; ?>><?php echo get_the_title(get_the_ID()); ?></p>
  	</div>
  </div>
<?php else: ?>
    </div>
  </div>
</div>
<?php endif; ?>

<div class="single-event-details">
  <div class="container">
    <div class="row">
      <div class="col-12 col-md-8 col-lg-9 event-information">
        <?php if($event_page):
          echo '<a href="' . get_permalink($event_page) . '" class="back-to-events"><i class="fal fa-long-arrow-left"></i> Back to events</a>';
        endif; ?>
        <?php if(!$banner) echo '<h1>' . get_the_title() . '</h1>'; ?>
        <?php
        if($event):
          if($event['location']):  ?>
            <p class="event-location"><span <?php if($event['color']) echo 'style="color:' . $event['color'] . '"'; ?>>Location: </span><?php echo $event['location']; ?></p>
          <?php endif;
          if($event['start']): ?>
            <?php $time = ' @ ' . $event['start']->format('g:ia');
            if($event['start']->format('g:ia') == '12:00am') $time = '';?>
            <p class="event-start"><span <?php if($event['color']) echo 'style="color:' . $event['color'] . '"'; ?>>Start: </span><?php echo $event['start']->format('l jS F o') . $time; ?></p>
          <?php endif; ?>

          <?php $time = ' @ ' . $event['end']->format('g:ia');
            if($event['end']->format('g:ia') == '12:00am') $time = '';
            if($event['end'] && ($event['end']->format('Y-m-d')) > $event['start']->format('Y-m-d')): ?>
            <p class="event-end"><span <?php if($event['color']) echo 'style="color:' . $event['color'] . '"'; ?>>End: </span><?php echo $event['end']->format('l jS F o') . $time; ?></p>
          <?php endif;
        endif; ?>
        <div class="event-description">
          <?php the_content(); ?>
          <?php
          if(!empty(get_post_meta(get_the_ID(), 'event_bookable')[0])) :
            echo '<a href="' . add_query_arg( array( 'event' => get_the_ID()), site_url('/booking-form/')) . '" class="btn btn-arrow-right">Book Now</a>';
          else:
            if(!empty(get_post_meta(get_the_ID(), 'external_booking_link')[0])) :
              echo '<a href="' . get_post_meta(get_the_ID(), 'external_booking_link')[0] . '" class="btn btn-arrow-right" target="_blank">Book Now</a>';
            endif;
          endif;
          $event_enquiry_page = get_field('enquiry_page');
          if($event_enquiry_page):
            echo '<a href="' . get_permalink($event_enquiry_page) . '" class="btn btn-arrow-right" >Enquire Now</a>';
          endif; ?>
        </div>
      </div>
      <div class="col-12 col-md-4 col-lg-3">
        <?php if($event['location']):
          echo get_template_part('inc/event-map');
        endif; ?>
      </div>
    </div>
  </div>
</div>

<?php if (have_rows('content_blocks')) while ( have_rows('content_blocks') ) : the_row(); ?>

	<?php if( get_row_layout() == 'gallery' ): ?>

        <?php echo get_template_part('inc/template-builder/image-gallery'); ?>

    <?php elseif( get_row_layout() == 'sponsorship' ): ?>

        <div class="event-sponsorship-block block">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-10 offset-md-1 text-center">
						<?php if(get_sub_field('heading')) echo '<h3 class="section-heading">' . get_sub_field('heading') . '</h3>'; ?>
						<?php if(get_sub_field('content')) echo '<p class="content-block">' . get_sub_field('content')  . '</p>'; ?>
						<?php if (get_sub_field('buttons')) :
							echo '<div class="btn-set">';
							foreach (get_sub_field('buttons') as $button):
								if($button['button_text'] && $button['button_link'])
									echo '<a href="' . $button['button_link'] . '" class="btn btn-arrow-right">' . $button['button_text'] . '</a>';
							endforeach;
							echo '</div>';
						endif; ?>
                    </div>
                </div>
            </div>
        </div>

    <?php elseif( get_row_layout() == 'faqs' ): ?>

		<?php echo get_template_part('inc/template-builder/faqs'); ?>

    <?php elseif( get_row_layout() == 'volunteering' ): ?>

        <div class="event-volunteering-block block" <?php if($event['color']) echo 'style="background:' . $event['color'] . '"'; ?>>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <?php if(get_sub_field('heading')) echo '<h3 class="section-heading">' . get_sub_field('heading') . '</h3>'; ?>
                        <?php if(get_sub_field('form_id')) gravity_form(get_sub_field('form_id'), false, false, false, '', true); ?>
                    </div>
                </div>
            </div>
        </div>

	<?php endif; ?>

<?php endwhile; ?>


<?php get_footer(); ?>

<?php if($event['location']):
 $lat_long = prospect_get_location_long_lat($event['location']);
 if($lat_long): ?>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC136X0oNRMn3rEvmB6FzNi8_e4I66o74A"></script>
    <script>
      function initMap() {
        var uluru = {lat: <?php echo $lat_long['lat']; ?>, lng: <?php echo $lat_long['long']; ?>,};
        var map = new google.maps.Map(document.getElementById('event-map'), {
          zoom: 14,
          center: uluru,
          scrollwheel: false,
          styles: [
          {
              "featureType": "water",
              "elementType": "geometry",
              "stylers": [
                  {
                      "color": "#e9e9e9"
                  },
                  {
                      "lightness": 17
                  }
              ]
          },
          {
              "featureType": "landscape",
              "elementType": "geometry",
              "stylers": [
                  {
                      "color": "#f5f5f5"
                  },
                  {
                      "lightness": 20
                  }
              ]
          },
          {
              "featureType": "road.highway",
              "elementType": "geometry.fill",
              "stylers": [
                  {
                      "color": "#ffffff"
                  },
                  {
                      "lightness": 17
                  }
              ]
          },
          {
              "featureType": "road.highway",
              "elementType": "geometry.stroke",
              "stylers": [
                  {
                      "color": "#ffffff"
                  },
                  {
                      "lightness": 29
                  },
                  {
                      "weight": 0.2
                  }
              ]
          },
          {
              "featureType": "road.arterial",
              "elementType": "geometry",
              "stylers": [
                  {
                      "color": "#ffffff"
                  },
                  {
                      "lightness": 18
                  }
              ]
          },
          {
              "featureType": "road.local",
              "elementType": "geometry",
              "stylers": [
                  {
                      "color": "#ffffff"
                  },
                  {
                      "lightness": 16
                  }
              ]
          },
          {
              "featureType": "poi",
              "elementType": "geometry",
              "stylers": [
                  {
                      "color": "#f5f5f5"
                  },
                  {
                      "lightness": 21
                  }
              ]
          },
          {
              "featureType": "poi.park",
              "elementType": "geometry",
              "stylers": [
                  {
                      "color": "#dedede"
                  },
                  {
                      "lightness": 21
                  }
              ]
          },
          {
              "elementType": "labels.text.stroke",
              "stylers": [
                  {
                      "visibility": "on"
                  },
                  {
                      "color": "#ffffff"
                  },
                  {
                      "lightness": 16
                  }
              ]
          },
          {
              "elementType": "labels.text.fill",
              "stylers": [
                  {
                      "saturation": 36
                  },
                  {
                      "color": "#333333"
                  },
                  {
                      "lightness": 40
                  }
              ]
          },
          {
              "elementType": "labels.icon",
              "stylers": [
                  {
                      "visibility": "off"
                  }
              ]
          },
          {
              "featureType": "transit",
              "elementType": "geometry",
              "stylers": [
                  {
                      "color": "#f2f2f2"
                  },
                  {
                      "lightness": 19
                  }
              ]
          },
          {
              "featureType": "administrative",
              "elementType": "geometry.fill",
              "stylers": [
                  {
                      "color": "#fefefe"
                  },
                  {
                      "lightness": 20
                  }
              ]
          },
          {
              "featureType": "administrative",
              "elementType": "geometry.stroke",
              "stylers": [
                  {
                      "color": "#fefefe"
                  },
                  {
                      "lightness": 17
                  },
                  {
                      "weight": 1.2
                  }
              ]
          }
      ]

        });
        var marker = new google.maps.Marker({
          position: uluru,
          map: map,
          icon: {
            url: "<?php echo get_stylesheet_directory_uri(); ?>/img/marker.png",
            scaledSize: new google.maps.Size(50, 67)
          }
        });
      }
      initMap();
    </script>
<?php endif;
endif; ?>
