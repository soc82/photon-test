<?php
/*
* Template Name: Shops Template
*/

get_header(); ?>

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
endif; ?>

<div class="shop-map-wrapper">
  <div class="shop-map" id="shop-map"></div>
  <?php
  if($shop_query->have_posts()):
    $i = 0;
    echo '<div class="shops-sidebar-wrapper">';
      echo '<div class="shops-sidebar-inner">';
        while($shop_query->have_posts()): $shop_query->the_post();
          $address = get_field('shop_address', get_the_ID());
          $email = get_field('shop_email', get_the_ID());
          $tel = get_field('shop_telephone', get_the_ID());
          echo '<div class="shop-item" data-lat="' . $address['lat'] . '" data-marker-id="' . $i . '">';
            echo '<p class="shop-name">' . get_the_title() . '</p>';
            if($address):
              echo '<span class="shop-address">' . $address['address'] . '</span>';
            endif;
            /*
            if($tel):
              echo '<a class="shop-tel" href="TEL:' . str_replace(" ", "", $tel) . '">' . $tel . '</span>';
            endif;
            if($email):
              echo '<a class="shop-email" href="MAILTO:' . $email . '">' . $email . '</a>';
            endif;
            */
            echo '<a href="' . get_permalink() . '">View Shop</a>';
          echo '</div>';
          $i++;
        endwhile;
      echo '</div>';
    echo '</div>';
  endif; ?>
</div>

<?php get_footer(); ?>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDQJsfiggkELXzjTTH3xUKjsef9cBtXLdQ"></script>
<script>
  var map = new google.maps.Map(document.getElementById('shop-map'), {
    zoom: 10,
    center: new google.maps.LatLng(51.5264768, -1.7850049),
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

  <?php if($shop_locations): ?>
    var shops = [<?php foreach($shop_locations as $location):
        echo $location;
      endforeach;   ?>];
    var shops, i;
    var id = 0;
    for (i = 0; i < shops.length; i++) {
        shopMarkers = new google.maps.Marker({
        position: new google.maps.LatLng(shops[i][1], shops[i][2]),
        map: map,
        id: id,
        animation: google.maps.Animation.DROP,
        icon: {
          url: "<?php echo get_stylesheet_directory_uri(); ?>/img/shop-marker.png",
          scaledSize: new google.maps.Size(30, 40)
        }
      });


      google.maps.event.addListener(shopMarkers, 'click', (function(shopMarkers, i) {
        return function() {
          jQuery('.shop-item').each(function(){
            jQuery(this).removeClass('active-shop');
            if(jQuery(this).attr('data-lat') == shops[i][1]) {
              jQuery(this).addClass('active-shop');
            }
          });
          jQuery('.shops-sidebar-inner').find('.active-shop').prependTo('.shops-sidebar-inner');
          map.setCenter(shopMarkers.getPosition());
          infowindow.setContent(shops[i][0]);
          infowindow.open(map, shopMarkers);
        }
      })(shopMarkers, i));



  <?php endif; ?>

  }



</script>
