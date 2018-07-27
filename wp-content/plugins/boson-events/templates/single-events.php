
<?php get_header(); ?>

<div class="page single-event">
	<div class="page-content container-fluid">
		<div class="row">
			<?php if (isset($_GET['fe_page'])) { ?>
				<div class="col-xs-12">
					<?php include_once( WP_PLUGIN_DIR . '/boson-events/front-end-editing/event-edit.php' ); ?>
				</div>
			<?php } else { ?>
				<div class="col-xs-12 col-md-8">
					<div class="card card-shadow card-completed-options">
						<div class="card-block p-30">
							<div class="row">
								<div class="col-xs-12">
											<?php get_template_part('inc/breadcrumbs'); ?>
							    		<header class="page-header">
							      			<h1 class="newsTitle"><?php the_title(); ?></h1>
													<?php $edit_url = add_query_arg(array('post_id' => get_the_ID(), 'fe_page' => 'edit-event')); ?>
													<?php echo check_can_edit_post($post, '<a href="' . $edit_url . '" class="edit-single-link"><i class="icon wb-pencil"></i></a>'); ?>
							    		</header><!-- .page-header -->
								 </div>
							</div>
							<?php // Get event fields
							$event_map = get_field('event_location');
							$start = new DateTime(get_field('event_start_date') . ' ' . get_field('start_time'));
		          $end = new DateTime(get_field('event_end_date') . ' ' . get_field('end_time'));
							$event_attendee_setting = get_field('show_attendee_list');
							$event_attendees = get_field('event_attendees');
							$current_attendees = get_field('event_attendees', '', false);
							$event_additional_details = get_field('event_additional_details');

							$current_user = wp_get_current_user();
							$current_user_id = $current_user->ID;

							?>

							<?php if($event_map): ?>
								<div class="row">
									<div class="col-xs-12">
										<div class="event-map">
											<div class="marker" data-lat="<?php echo $event_map['lat']; ?>" data-lng="<?php echo $event_map['lng']; ?>"></div>
										</div>
									</div>
								</div>
							<?php endif; ?>

							<div class="row">
								<div class="col-xs-12">
									<?php the_content(); ?>
									<?php if($event_map)
									echo '<p class="event-location"><span>Location:</span> ' . $event_map['address'] . '</p>'; ?>
									<?php if($start)
									echo '<p class="event-time"><span>Event Start:</span> ' . $start->format('d/m/Y @ h:ia') . '</p>'; ?>
									<?php if($end)
									echo '<p class="event-time"><span>Event End:</span> ' . $end->format('d/m/Y @ h:ia') . '</p>'; ?>
									<?php if(function_exists('display_likes')){
										display_likes();
									} ?>
								</div>
							</div>

						</div>
				</div>
				<?php if($event_additional_details): ?>
					<div class="card card-shadow card-completed-options">
						<div class="card-block p-30">
							<div class="row">
								<div class="col-xs-12">
									<?php echo $event_additional_details; ?>
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>
				<div class="col-xs-12 col-md-4">
					<!-- Event Attendee -->
					<div class="card card-shadow card-completed-options commentsSidebar">
						<div class="card-block p-20">

							<?php
							// Create array to store attendees
							$list_attendees = array();
							$list_attendee_ids = array();
							if($event_attendees):
								foreach($event_attendees as $event_attendee):
									// Get attendees IDs
									$list_attendees[] = $event_attendee;
									$list_attendee_ids[] = $event_attendee['ID'];
								endforeach;
							endif;
							?>

							<?php
							// If current user is attending
							if (in_array($current_user_id, $list_attendee_ids)) : ?>

									<div class="alert alert-success user-attending-notice p-0" role="alert"><i class="fa fa-check" aria-hidden="true"></i> You're attending this event</div>

									<form class="removing-attendee-form" name="removing-attendee-form" action="" method="post">
										<h4 class="font-size-15 m-b-10">No longer make it?</h4>
										<button type="submit" name="removing-attendee" class="btn btn-warning" ><i class="fa fa-times" aria-hidden="true"></i> Mark me as not-attending</button>
										<input type="hidden" name="unattending_user_id" value="<?php echo $current_user_id; ?>" />
										<input type="hidden" name="post_id" value="<?php echo get_the_ID(); ?>" />
									</form>

									<?php // If only show attendee list once user is attending
									if($event_attendee_setting == 'show attendees after'):
										echo '<div class="attendee-list">';
										echo '<h4><i class="fa fa-users" aria-hidden="true"></i> Current Attendees</h4>';
										echo '<ul class="list-group list-group-full">';
										if($list_attendees):
											foreach($list_attendees as $list_attendee): ?>
													<li class="list-group-item">
														<div class="media">
				                      <div class="media-left">
																<?php $user_photo = get_field('user_photo' , 'user_' . $list_attendee['ID'] );
																if($user_photo) :?>
																<span class="avatar" style="background-image:url(<?php echo $user_photo; ?>)"></span>
															<?php else: ?>
																<span class="avatar" style="background-image:url(<?php echo get_template_directory_uri(); ?>/img/Profile-Picture.png)"></span>
															<?php endif; ?>
				                      </div>
				                      <div class="media-body">
				                        <h4 class="media-heading"><?php echo $list_attendee['display_name']; ?></h4>
				                      </div>
				                    </div>
												 </li>
											<?php endforeach;
										else:
											echo 'There are currently no attendees';
										endif;
									  echo '</ul>';
										echo '</div>';
									endif; ?>

							<?php // Else, not currently attending
							else :?>

							<form class="adding-attendee-form" name="adding-attendee-form" action="" method="post">
								<h4>Will you be attening this event?</h4>
								<button name="adding-attendee" class="btn btn-success" ><i class="fa fa-check" aria-hidden="true"></i> Mark me as attending</button>
								<input type="hidden" name="attending_user_id" value="<?php echo $current_user_id; ?>" />
								<input type="hidden" name="post_id" value="<?php echo get_the_ID(); ?>" />
							</form>

							<?php endif; ?>


							<?php // Always show attendee list if this setting
							if($event_attendee_setting == 'show attendees always') :
								echo '<div class="attendee-list">';
								echo '<h4><i class="fa fa-users" aria-hidden="true"></i> Current Attendees</h4>';
								echo '<ul class="list-group list-group-full">';
									if($list_attendees):
										foreach($list_attendees as $list_attendee): ?>
												<li class="list-group-item">
													<div class="media">
			                      <div class="media-left">
															<?php $user_photo = get_field('user_photo' , 'user_' . $list_attendee['ID'] );
															if($user_photo): ?>
															<span class="avatar" style="background-image:url(<?php echo $user_photo; ?>)"></span>
														<?php else: ?>
															<span class="avatar" style="background-image:url(<?php echo get_template_directory_uri(); ?>/img/Profile-Picture.png)"></span>
														<?php endif; ?>
			                      </div>
			                      <div class="media-body">
			                        <h4 class="media-heading"><?php echo $list_attendee['display_name']; ?></h4>
			                      </div>
			                    </div>
											 </li>
										<?php endforeach;
									else:
										echo 'There are currently no attendees';
									endif;
									echo '</ul>';
								 echo '</div>';
							endif; ?>

							<form method="post" action="" id="add_to_calendar" target="_blank">
								 <div class="input-group">
									 <h4>Add event to your calendar</h4>
									 <p>Select your email client below</p>
									  <select name="select_email_client"  class="form-control" >
											<option value="apple">Apple Calendar</option>
											<option value="outlook">Outlook</option>
											<option value="gmail">Gmail</option>
										</select>
									</div>
									<div class="input-group m-t-20">
										<input type="hidden" name="post_id" value="<?php echo get_the_ID(); ?>" />
										<button type="submit"  class="btn btn-success" name="add_to_calendar" >Add to Calendar</button>
									</div>
							</form>

					</div>
				</div>
			</div>
			<?php } ?>
 		</div>
	</div>
</div>

<?php get_footer(); ?>
<?php if (!isset($_GET['fe_page'])) { ?>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAc8_WuNCFPaKj0JCSPlb46H9GneNvvPyY"></script>
	<script type="text/javascript">
	(function($) {

	function new_map( $el ) {
		var $markers = $el.find('.marker');
		var args = {
			zoom		: 16,
			center		: new google.maps.LatLng(0, 0),
			mapTypeId	: google.maps.MapTypeId.ROADMAP
		};
		var map = new google.maps.Map( $el[0], args);

		map.markers = [];

		$markers.each(function(){

	    	add_marker( $(this), map );

		});

		center_map( map );
		return map;
	}

	function add_marker( $marker, map ) {

		var latlng = new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') );

		var marker = new google.maps.Marker({
			position	: latlng,
			map			: map
		});

		map.markers.push( marker );

		if( $marker.html() )
		{
			var infowindow = new google.maps.InfoWindow({
				content		: $marker.html()
			});

			google.maps.event.addListener(marker, 'click', function() {

				infowindow.open( map, marker );

			});
		}

	}

	function center_map( map ) {
		// vars
		var bounds = new google.maps.LatLngBounds();
		// loop through all markers and create bounds
		$.each( map.markers, function( i, marker ){
			var latlng = new google.maps.LatLng( marker.position.lat(), marker.position.lng() );
			bounds.extend( latlng );
		});
		// only 1 marker?
		if( map.markers.length == 1 )
		{
			// set center of map
		    map.setCenter( bounds.getCenter() );
		    map.setZoom( 16 );
		}
		else
		{
			// fit to bounds
			map.fitBounds( bounds );
		}
	}

	var map = null;
	jQuery(document).ready(function(){
		jQuery('.event-map').each(function(){
			// create map
			map = new_map( jQuery(this) );
		});
	});

	})(jQuery);
	</script>
<?php } ?>
