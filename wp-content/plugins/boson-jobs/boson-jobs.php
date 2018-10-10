<?php
/*
Plugin Name: Boson Web - Jobs Module
Plugin URI: http://bosonweb.net
Description: This plugin allows you to manage roles and applications.
Version: 1.0
Author: Boson Web
Author URI: http://bosonweb.net
License: GPL2
*/

function custom_post_type_jobs() {

  /********************
  PROJECTS POST TYPE
  ********************/
  $labels_jobs = array(
    'name'                => _x( 'Jobs', 'Post Type General Name', 'vanilla' ),
    'singular_name'       => _x( 'Job', 'Post Type Singular Name', 'vanilla' ),
    'menu_name'           => __( 'Jobs', 'vanilla' ),
    'parent_item_colon'   => __( 'Parent Job', 'vanilla' ),
    'all_items'           => __( 'All Jobs', 'vanilla' ),
    'view_item'           => __( 'View Job', 'vanilla' ),
    'add_new_item'        => __( 'Add New Job', 'vanilla' ),
    'add_new'             => __( 'Add New', 'vanilla' ),
    'edit_item'           => __( 'Edit Job', 'vanilla' ),
    'update_item'         => __( 'Update Job', 'vanilla' ),
    'search_items'        => __( 'Search Job', 'vanilla' ),
    'not_found'           => __( 'Not Found', 'vanilla' ),
    'not_found_in_trash'  => __( 'Not found in Trash', 'vanilla' ),
  );
  $rewrite = array(
    'slug'                  => 'jobs',
    'with_front'            => false,
  );
  $args_jobs = array(
    'label'               => __( 'jobs', 'vanilla' ),
    'description'         => __( 'Some of the projects you provide', 'vanilla' ),
    'labels'              => $labels_jobs,
    'supports'            => array( 'title', 'editor', 'thumbnail' ),
    'public'              => true,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'show_in_nav_menus'   => true,
    'hierarchical' => true,
    'show_in_admin_bar'   => true,
    'menu_position'       => 4,
    'menu_icon'           => 'dashicons-clipboard',
    'can_export'          => true,
    'has_archive'         => false, // index Page
    'exclude_from_search' => false,
    'publicly_queryable'  => true,
    'rewrite'               => $rewrite,
    'capability_type' => 'jobs',
    'capabilities' => array(
        'edit_post' => 'edit_job',
        'edit_posts' => 'edit_jobs',
        'edit_others_posts' => 'edit_other_jobs',
        'publish_posts' => 'publish_jobs',
        'read_post' => 'read_job',
        'read_private_posts' => 'read_private_jobs',
        'delete_post' => 'delete_job'
    ),
    'map_meta_cap' => true

  );

  // Registering your Custom Post Type
  register_post_type( 'jobs', $args_jobs );

}

function add_theme_caps() {
    // gets the administrator role
    $admins = get_role( 'administrator' );

    $admins->add_cap( 'edit_job' ); 
    $admins->add_cap( 'edit_jobs' ); 
    $admins->add_cap( 'edit_other_jobs' ); 
    $admins->add_cap( 'publish_jobs' ); 
    $admins->add_cap( 'read_job' ); 
    $admins->add_cap( 'read_private_jobs' ); 
    $admins->add_cap( 'delete_job' );

    // Assign Custom Job Type Categories
    $admins->add_cap( 'manage_jobtype' );
    $admins->add_cap( 'edit_jobtype' );
    $admins->add_cap( 'delete_jobtype' );
    $admins->add_cap( 'assign_jobtype' );

    // Assign Custom Job Section Categories
    $admins->add_cap( 'manage_jobsection' );
    $admins->add_cap( 'edit_jobsection' );
    $admins->add_cap( 'delete_jobsection' );
    $admins->add_cap( 'assign_jobsection' );

}
add_action( 'admin_init', 'add_theme_caps');

/* Hook into the 'init' action so that the function
* Containing our post type registration is not
* unnecessarily executed.
*/
add_action( 'init', 'custom_post_type_jobs', 0 );

function create_jobtype_tax() {
  register_taxonomy(
    'jobtype',
    'jobs',
    array(
      'label' => __( 'Job Type' ),
      'rewrite' => array( 'slug' => 'jobtype' ),
      'hierarchical' => true,
      'capabilities' => array(
        'manage_terms'=> 'manage_jobtype',
        'edit_terms'=> 'edit_jobtype',
        'delete_terms'=> 'delete_jobtype',
        'assign_terms' => 'assign_jobtype'
      ),
    )
  );
}

add_action( 'init', 'create_jobtype_tax' );


function create_jobsection_tax() {
  register_taxonomy(
    'jobsection',
    'jobs',
    array(
      'label' => __( 'Job Section' ),
      'rewrite' => array( 'slug' => 'jobsection' ),
      'hierarchical' => true,
      'capabilities' => array(
        'manage_terms'=> 'manage_jobsection',
        'edit_terms'=> 'edit_jobsection',
        'delete_terms'=> 'delete_jobsection',
        'assign_terms' => 'assign_jobsection'
      ),
    )
  );
}

add_action( 'init', 'create_jobsection_tax' );

/****************************
LOAD SINGLE TEMPLATE
*****************************/
add_filter('single_template', 'jobs_single_template');
function jobs_single_template($single) {
    $cptName = 'jobs';
    global $wp_query, $post;
    $plugin_path = plugin_dir_path( __FILE__ );
    if ($post->post_type == $cptName){
        if(file_exists($plugin_path . '/templates/single-'.$cptName.'.php')) {
            return $plugin_path . '/templates/single-'.$cptName.'.php';
        }
    }
    return $single;
}

require_once('inc/form_processing.php');

// Register new menu item(s) in woocommerce's my account area and re-order
function prospect_woo_account_menu($menu) {
	unset($menu['downloads']);
	unset($menu['payment-methods']);
	$menu['orders'] =  __('Orders', 'prospect');

	$menu = array_slice($menu, 0, 4, true) +
		['applications' => __( 'Job Applications', 'prospect' )] +
		array_slice($menu, 4, count($menu)-4, true);

	return $menu;
}
add_filter ( 'woocommerce_account_menu_items', 'prospect_woo_account_menu', 15 );

// Add new URL endpoint for job applications
function prospect_add_my_account_endpoint() {
    add_rewrite_endpoint( 'applications', EP_PAGES );
}
add_action( 'init', 'prospect_add_my_account_endpoint' );
// Set the content for the new endpoint
function prospect_applications_endpoint_content() {
    include(plugin_dir_path( __FILE__ ) . 'templates/job-applications.php');
}
add_action( 'woocommerce_account_applications_endpoint', 'prospect_applications_endpoint_content' );




/****************************
LOAD ACF FIELDS
*****************************/
require_once('acf-fields.php');
require_once('acf-fields-user.php');
require_once('acf-fields-listing.php');


/*
** Allow users to view draft job post if they have applied
*/
function prospect_view_draft_jobs( $query ) {
  if(is_admin()) return;
  if(!is_user_logged_in()) return;

  if($query->get('post_type') == 'jobs') {
    if(isset($query->query['name'])) {
      $job = get_page_by_path( $query->query['name'], OBJECT, 'jobs' );
      if($job){

        $user = wp_get_current_user();

        $users_applications = get_field('applications', 'user_' . $user->ID);
        if ($users_applications) {
        	foreach ($users_applications as $application) {
        	    if ($job->ID == $application['job_id']) {
                $query->set( 'post_status', [ 'publish', 'draft' ] );
        	    }
        	}
        }

      }
    }
  }
  return $query;
}
add_action('pre_get_posts', 'prospect_view_draft_jobs');

/*
** Only display job vacancies user is a manager of
*/
add_action( 'pre_get_posts', 'prospect_manager_filter' );
function prospect_manager_filter($query) {
  if ( !is_admin()) return;

  // If administrator or super user, show all
  $user = wp_get_current_user();
  if(in_array( $user->roles[0], array('super_user', 'administrator') )) return;

  if ( in_array ( $query->get('post_type'), array('jobs') ) ) {
    $query->set( 'meta_key', 'job_vacancy_manager' );
    $query->set( 'meta_value', $user->ID );
    return;
  }
}
