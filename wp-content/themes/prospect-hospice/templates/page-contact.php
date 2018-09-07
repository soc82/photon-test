<?php
/*
* Template Name: Contact Template
*/

get_header(); ?>

<?php
// Prospect HQ
$lat = get_field('config_map_lattitude', 'options');
$long = get_field('config_map_longitude', 'options');

$find_us = get_field('how_to_find_us');
$useful = get_field('useful_telephone_numbers');
?>
<?php get_template_part('inc/template-builder/hero-banner'); ?>
<div class="inner-page-wrapper">
  <div class="container">
    <div class="row">
      <div class="col-12 col-sm-6 col-lg-6">
        <div class="contact-details-wrapper">
          <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
          <?php the_content(); ?>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-lg-5 offset-lg-1">
        <?php if(get_field('contact_form_id')):
            echo '<div class="contact-form">';
              echo do_shortcode('[gravityform id="' . get_field('contact_form_id') . '" ajax=true" title="false" description="false"]');
            echo '</div>';
          endif; ?>
      </div>
    </div>
  </div>
</div>

<div class="contact-map" id="contact-map"></div>

<?php if(array_filter($find_us) || array_filter($useful)): ?>
  <div class="contact-additional block">
    <div class="container">
      <div class="row">
        <?php if(array_filter($find_us)):
          echo '<div class="col-12 col-md-6 col-lg-5 how-to-find-us">';
            if($find_us['section_heading']) echo '<h3 class="section-heading">' . $find_us['section_heading'] . '</h3>';
            if($find_us['content']) echo $find_us['content'];
            if($find_us['find_shop_button']['button_text'] && $find_us['find_shop_button']['button_link']):
              echo '<a href="' . get_permalink($find_us['find_shop_button']['button_link']) . '" class="btn" title="' . $find_us['find_shop_button']['button_text'] . '">' . $find_us['find_shop_button']['button_text'] . '</a>';
            endif;
          echo '</div>';
        endif; ?>
        <?php if(array_filter($useful)):
          echo '<div class="col-12 col-md-6 col-lg-7">';
            if($useful['section_heading']) echo '<h3 class="section-heading">' . $useful['section_heading'] . '</h3>';
            if($useful['numbers']):
              echo '<ul class="useful-numbers">';
                foreach($useful['numbers'] as $number):
                  echo '<li>';
                    if($number['label']) echo '<div class="label">' . $number['label'] . '</div>';
                    if($number['number']) echo '<div class="number">' . $number['number'] . '</div>';
                  echo '</li>';
                endforeach;
              echo '</ul>';
            endif;
          echo '</div>';
        endif; ?>
      </div>
    </div>
  </div>
<?php endif; ?>

<?php get_footer(); ?>

<?php
$shop_args = array(
  'post_type' => 'shop',
  'post_per_page' => -1,
);
$shop_query = new WP_Query($shop_args);
if($shop_query->have_posts()):
  $shop_locations = array();
  while($shop_query->have_posts()): $shop_query->the_post();
    $address = get_field('shop_address', get_the_ID());
    if($address):
      $shop_locations[] = '["' . $address['address'] . '","' . $address['lat'] . '","' . $address['lng'] . '"],';
    endif;
  endwhile;
  wp_reset_postdata();
endif; ?>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDQJsfiggkELXzjTTH3xUKjsef9cBtXLdQ"></script>
<script>
  var map = new google.maps.Map(document.getElementById('contact-map'), {
    zoom: 12,
    center: new google.maps.LatLng(<?php echo $lat; ?>, <?php echo $long; ?>),
    scrollwheel: false,
    mapTypeControl: false,
    styles: [
        {
            "featureType": "water",
            "elementType": "geometry",
            "stylers": [
                {
                    "color": "#7bb4cc"
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
                    "color": "#DEDEDE"
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
                    "color": "#AAAAAA"
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

  var infowindow = new google.maps.InfoWindow();

  var office =  ['Prospect Hospice', <?php echo $lat; ?>, <?php echo $long; ?>];
  var officeMarker = new google.maps.Marker({
    position: new google.maps.LatLng(<?php echo $lat; ?>, <?php echo $long; ?>),
    map: map,
    title: 'Prospect Hospice',
    animation: google.maps.Animation.DROP,
    icon: {
      url: "<?php echo get_stylesheet_directory_uri(); ?>/img/marker.png",
      scaledSize: new google.maps.Size(40, 55)
    }
  });
  google.maps.event.addListener(officeMarker, 'click', (function(officeMarker) {
    return function() {
      infowindow.setContent(office[0]);
      infowindow.open(map, officeMarker);
    }
  })(officeMarker));


</script>
