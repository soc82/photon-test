<?php
/*
Plugin Name: Boson Web - Testimonials Module
Plugin URI: http://bosonweb.net
Description: This plugin allows you to manage your testimonials.
Version: 1.0
Author: Boson Web
Author URI: http://bosonweb.net
License: GPL2
*/

function custom_post_type_testimonials() {

  /********************
  PROJECTS POST TYPE
  ********************/
  $labels_testimonials = array(
    'name'                => _x( 'Testimonials', 'Post Type General Name', 'vanilla' ),
    'singular_name'       => _x( 'Testimonial', 'Post Type Singular Name', 'vanilla' ),
    'menu_name'           => __( 'Testimonials', 'vanilla' ),
    'parent_item_colon'   => __( 'Parent Testimonial', 'vanilla' ),
    'all_items'           => __( 'All Testimonials', 'vanilla' ),
    'view_item'           => __( 'View Testimonial', 'vanilla' ),
    'add_new_item'        => __( 'Add New Testimonial', 'vanilla' ),
    'add_new'             => __( 'Add New', 'vanilla' ),
    'edit_item'           => __( 'Edit Testimonial', 'vanilla' ),
    'update_item'         => __( 'Update Testimonial', 'vanilla' ),
    'search_items'        => __( 'Search Testimonial', 'vanilla' ),
    'not_found'           => __( 'Not Found', 'vanilla' ),
    'not_found_in_trash'  => __( 'Not found in Trash', 'vanilla' ),
  );
  $rewrite = array(
    'slug'                  => 'testimonial',
    'with_front'            => false,
  );
  $args_testimonials = array(
    'label'               => __( 'testimonials', 'vanilla' ),
    'description'         => __( 'Some of the projects you provide', 'vanilla' ),
    'labels'              => $labels_testimonials,
    'supports'            => array( 'title', 'editor', 'thumbnail' ),
    'taxonomies'            => array( 'development' ),
    'public'              => true,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'show_in_nav_menus'   => true,
    'hierarchical' => true,
    'show_in_admin_bar'   => true,
    'menu_position'       => 4,
    'menu_icon'           => 'dashicons-format-status',
    'can_export'          => true,
    'has_archive'         => true, // index Page
    'exclude_from_search' => true,
    'publicly_queryable'  => true,
    'rewrite'               => $rewrite,
    'capability_type'     => 'page',

  );

  // Registering your Custom Post Type
  register_post_type( 'testimonials', $args_testimonials );

}

/* Hook into the 'init' action so that the function
* Containing our post type registration is not
* unnecessarily executed.
*/
add_action( 'init', 'custom_post_type_testimonials', 0 );


/****************************
LOAD ACF FIELDS
*****************************/
require_once('acf-fields.php');
