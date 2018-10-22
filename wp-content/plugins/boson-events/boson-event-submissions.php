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
		'capabilities' => array(
	      'edit_post'          => 'edit_draft_event_entry', 
	      'read_post'          => 'read_draft_event_entry', 
	      'delete_post'        => 'delete_draft_event_entry', 
	      'edit_posts'         => 'edit_draft_event_entrys', 
	      'edit_others_posts'  => 'edit_others_draft_event_entrys', 
	      'publish_posts'      => 'publish_draft_event_entrys',       
	      'read_private_posts' => 'read_private_draft_event_entrys', 
	      'create_posts'       => 'edit_draft_event_entrys', 
	    ),
	);

	// Registering your Custom Post Type
	register_post_type( 'draft-event-entry', $args_events_entries );


  /********************
  Event Entries POST TYPE
  ********************/
  $labels_event_entries = array(
    'name'                => _x( 'Event Entries', 'Post Type General Name', 'vanilla' ),
    'singular_name'       => _x( 'Event Entry', 'Post Type Singular Name', 'vanilla' ),
    'menu_name'           => __( 'Event Entries', 'vanilla' ),
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
    'capabilities' => array(
      'edit_post'          => 'edit_event_entry', 
      'read_post'          => 'read_event_entry', 
      'delete_post'        => 'delete_event_entry', 
      'edit_posts'         => 'edit_event_entrys', 
      'edit_others_posts'  => 'edit_others_event_entrys', 
      'publish_posts'      => 'publish_event_entrys',       
      'read_private_posts' => 'read_private_event_entrys', 
      'create_posts'       => 'edit_event_entrys', 
    ),

  );

  // Registering your Custom Post Type
  register_post_type( 'event-entry', $args_events_entries );

}
add_action( 'init', 'custom_post_type_event', 0 );



 ?>
