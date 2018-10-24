<?php


function custom_post_type_event() {

	/********************
	Event Entries POST TYPE
	 ********************/
	$labels_event_entries = array(
		'name'                => _x( 'Draft Event Entries', 'Post Type General Name', 'vanilla' ),
		'singular_name'       => _x( 'Draft Event Entry', 'Post Type Singular Name', 'vanilla' ),
		'menu_name'           => __( 'Draft Event Entries', 'vanilla' ),
		'parent_item_colon'   => __( 'Parent Draft Event Entry', 'vanilla' ),
		'all_items'           => __( 'All Draft Event Entries', 'vanilla' ),
		'view_item'           => __( 'View Draft Event Entry', 'vanilla' ),
		'add_new_item'        => __( 'Add New Draft Event Entry', 'vanilla' ),
		'add_new'             => __( 'Add New', 'vanilla' ),
		'edit_item'           => __( 'Edit Draft Event Entry', 'vanilla' ),
		'update_item'         => __( 'Update Draft Event Entry', 'vanilla' ),
		'search_items'        => __( 'Search Draft Event Entry', 'vanilla' ),
		'not_found'           => __( 'Not Found', 'vanilla' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'vanilla' ),
	);

	$args_events_entries = array(
		'label'               => __( 'Saved Event Bookings', 'vanilla' ),
		'description'         => __( 'Saved entry data from event form', 'vanilla' ),
		'labels'              => $labels_event_entries,
		'supports'            => array( 'title' ),
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => false,
		'hierarchical'        => true,
		'show_in_admin_bar'   => false,
		'menu_position'       => 4,
		'menu_icon'           => 'dashicons-yes',
		'can_export'          => true,
		'has_archive'         => false, // index Page
		'exclude_from_search' => false,
		'publicly_queryable'  => false,
		'capability_type'     => 'post',
	);

	// Registering your Custom Post Type
	register_post_type( 'draft-event-entry', $args_events_entries );


  /********************
  Event Entries POST TYPE
  ********************/
  $labels_event_entries = array(
    'name'                => _x( 'Event Bookings', 'Post Type General Name', 'vanilla' ),
    'singular_name'       => _x( 'Event Booking', 'Post Type Singular Name', 'vanilla' ),
    'menu_name'           => __( 'Event Bookings', 'vanilla' ),
    'parent_item_colon'   => __( 'Parent Event Entry', 'vanilla' ),
    'all_items'           => __( 'All Event Entries', 'vanilla' ),
    'view_item'           => __( 'View Event Entry', 'vanilla' ),
    'add_new_item'        => __( 'Add New Event Entry', 'vanilla' ),
    'add_new'             => __( 'Add New', 'vanilla' ),
    'edit_item'           => __( 'Edit Event Entry', 'vanilla' ),
    'update_item'         => __( 'Update Event Entry', 'vanilla' ),
    'search_items'        => __( 'Search Event Entry', 'vanilla' ),
    'not_found'           => __( 'Not Found', 'vanilla' ),
    'not_found_in_trash'  => __( 'Not found in Trash', 'vanilla' ),
  );

  $args_events_entries = array(
    'label'               => __( 'Event Entries', 'vanilla' ),
    'description'         => __( 'Entry data from event form', 'vanilla' ),
    'labels'              => $labels_event_entries,
    'supports'            => array( 'title' ),
    'public'              => false,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'show_in_nav_menus'   => true,
    'hierarchical'        => true,
    'show_in_admin_bar'   => true,
    'menu_position'       => 4,
    'menu_icon'           => 'dashicons-yes',
    'can_export'          => true,
    'has_archive'         => false, // index Page
    'exclude_from_search' => false,
    'publicly_queryable'  => false,
    'capability_type'     => 'post',
  );

  // Registering your Custom Post Type
  register_post_type( 'event-entry', $args_events_entries );

}
add_action( 'init', 'custom_post_type_event', 0 );



 ?>
