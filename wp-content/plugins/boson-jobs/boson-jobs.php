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
    'menu_icon'           => 'dashicons-yes',
    'can_export'          => true,
    'has_archive'         => false, // index Page
    'exclude_from_search' => false,
    'publicly_queryable'  => true,
    'rewrite'               => $rewrite,
    'capability_type'     => 'page',

  );

  // Registering your Custom Post Type
  register_post_type( 'jobs', $args_jobs );

}

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
    )
  );
}

add_action( 'init', 'create_jobtype_tax' );

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

/****************************
LOAD ACF FIELDS
*****************************/
require_once('acf-fields.php');
require_once('acf-fields-listing.php');

