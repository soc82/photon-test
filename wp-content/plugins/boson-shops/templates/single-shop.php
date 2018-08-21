<?php

get_header(); ?>

<?php $hero_image = get_field('shop_image');
$address = get_field('shop_address');
$email = get_field('shop_email');
$tel = get_field('shop_telephone');
$speciality = get_field('speciality');
$opening_times = get_field('opening_times');
if($hero_image): ?>
	<div class="shop-hero">
	  <img src="<?php echo $hero_image['sizes']['slider']; ?>" alt="<?php echo $hero_image['alt']; ?>" />
	</div>
<?php endif; ?>

<div class="block">
	<div class="container">
		<div class="row">
			<div class="col-12 col-md-5 col-lg-3">
				<div class="shop-map" id="shop-map"></div>
			</div>
			<div class="col-12 col-md-7 col-lg-5 shop-details">
				<h1 class="shop-heading"><?php the_title(); ?></h1>
				<?php
				if($address):
					echo '<p class="shop-address">' . str_replace(',', '<br />', $address['address']) . '</p>';
				endif;
				if($tel || $email):
					echo '<div class="shop-contact">';
					if($email):
						echo '<a class="shop-email" href="MAILTO:' . $email . '">E: ' . $email . '</a>';
					endif;
					if($tel):
						echo '<a class="shop-tel" href="TEL:' . str_replace(" ", "", $tel) . '">T: ' . $tel . '</a>';
					endif;
					echo '</div>';
				endif;
				if($speciality):
					echo '<p class="shop-speciality"><strong>Speciality:</strong> ' . $speciality . '</p>';
				endif;
				if($address):
					echo '<p class="shop-times"><strong>Opening Times:</strong> ' . $opening_times . '</p>';
				endif;
				?>
			</div>
			<div class="col-12 col-lg-4">
				<div class="sidebar-sub-menu bg-yellow">
					<div class="sidebar-inner">
						<?php
							$args = array(
								'post_type'	=> 'shop',
								'posts_per_page'	=> -1,
							);
							$shop_query = new WP_Query($args);
							if($shop_query->have_posts()):
								echo '<h3>Our shops</h3>';
								echo '<ul>';
									while($shop_query->have_posts()): $shop_query->the_post();
										echo '<li><a href="' . get_permalink(get_the_ID()) . '" >' . get_the_title() . '</a></li>';
									endwhile;
									wp_reset_postdata();
								echo '</ul>';
							endif;
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>


<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDQJsfiggkELXzjTTH3xUKjsef9cBtXLdQ"></script>
<script>
  var map = new google.maps.Map(document.getElementById('shop-map'), {
    zoom: 10,
    center: new google.maps.LatLng(<?php echo $address['lat']; ?>, <?php echo $address['lng']; ?>),
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

	var myLatLng = {lat: <?php echo $address['lat']; ?>, lng: <?php echo $address['lng']; ?>};
	var marker = new google.maps.Marker({
		 position: myLatLng,
		 map: map,
		 animation: google.maps.Animation.DROP,
		 icon: {
			 url: "<?php echo get_stylesheet_directory_uri(); ?>/img/shop-marker.png",
			 scaledSize: new google.maps.Size(30, 40)
		 }
	 });


</script>
