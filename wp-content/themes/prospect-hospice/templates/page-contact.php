<?php
/*
* Template Name: Contact Template
*/

get_header(); ?>

<?php
$lat = get_field('config_map_lattitude', 'options');
$long = get_field('config_map_longitude', 'options');
?>
<?php get_template_part('inc/template-builder/hero-banner'); ?>
<div class="inner-page-wrapper">
  <div class="container">
    <div class="row">
      <div class="col-12 col-sm-6 col-md-5">
        <div class="contact-details-wrapper">
          <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
          <?php the_content(); ?>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-md-7">

      </div>
    </div>
  </div>
</div>

<?php if($lat && $long): ?>
  <div class="contact-map" id="contact-map"></div>
<?php endif; ?>

<?php get_footer(); ?>
<?php if($lat && $long): ?>
  <script>
    function initMap() {
      var location = {lat: <?php echo $lat; ?>, lng: <?php echo $long; ?>,};
      var map = new google.maps.Map(document.getElementById('contact-map'), {
        zoom: 14,
        center: location,
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
      var marker = new google.maps.Marker({
        position: location,
        map: map,
        animation: google.maps.Animation.DROP,
        icon: {
          url: "<?php echo get_stylesheet_directory_uri(); ?>/img/marker.png",
          scaledSize: new google.maps.Size(50, 67)
        }
      });
    }

  </script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDQJsfiggkELXzjTTH3xUKjsef9cBtXLdQ&callback=initMap" async defer></script>
<?php endif; ?>
