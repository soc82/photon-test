<?php
/*
Plugin Name: Boson Web - FAQs Module
Plugin URI: http://bosonweb.net
Description: This plugin allows you to manage your faqs.
Version: 1.0
Author: Boson Web
Author URI: http://bosonweb.net
License: GPL2
*/

function custom_post_type_faqs() {

  /********************
  PROJECTS POST TYPE
  ********************/
  $labels_faqs = array(
    'name'                => _x( 'FAQs', 'Post Type General Name', 'vanilla' ),
    'singular_name'       => _x( 'FAQ', 'Post Type Singular Name', 'vanilla' ),
    'menu_name'           => __( 'FAQs', 'vanilla' ),
    'parent_item_colon'   => __( 'Parent FAQ', 'vanilla' ),
    'all_items'           => __( 'All FAQs', 'vanilla' ),
    'view_item'           => __( 'View FAQ', 'vanilla' ),
    'add_new_item'        => __( 'Add New FAQ', 'vanilla' ),
    'add_new'             => __( 'Add New', 'vanilla' ),
    'edit_item'           => __( 'Edit FAQ', 'vanilla' ),
    'update_item'         => __( 'Update FAQ', 'vanilla' ),
    'search_items'        => __( 'Search FAQ', 'vanilla' ),
    'not_found'           => __( 'Not Found', 'vanilla' ),
    'not_found_in_trash'  => __( 'Not found in Trash', 'vanilla' ),
  );
  $rewrite = array(
    'slug'                  => 'faqs',
    'with_front'            => false,
  );
  $args_faqs = array(
    'label'               => __( 'faqs', 'vanilla' ),
    'description'         => __( 'Some of the projects you provide', 'vanilla' ),
    'labels'              => $labels_faqs,
    'supports'            => array( 'title', 'editor', 'thumbnail' ),
    // 'taxonomies'            => array( 'section' ),
    'public'              => true,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'show_in_nav_menus'   => true,
    'hierarchical' => true,
    'show_in_admin_bar'   => true,
    'menu_position'       => 4,
    'menu_icon'           => 'dashicons-editor-help',
    'can_export'          => true,
    'has_archive'         => true, // index Page
    'exclude_from_search' => false,
    'publicly_queryable'  => true,
    'rewrite'               => $rewrite,
    'capability_type'     => 'page',
    'capabilities' => array(
      'edit_post'          => 'edit_faq', 
      'read_post'          => 'read_faq', 
      'delete_post'        => 'delete_faq', 
      'edit_posts'         => 'edit_faqs', 
      'edit_others_posts'  => 'edit_others_faqs', 
      'publish_posts'      => 'publish_faqs',       
      'read_private_posts' => 'read_private_faqs', 
      'create_posts'       => 'edit_faqs', 
    ),

  );

  // Registering your Custom Post Type
  register_post_type( 'faqs', $args_faqs );

}

/* Hook into the 'init' action so that the function
* Containing our post type registration is not
* unnecessarily executed.
*/
add_action( 'init', 'custom_post_type_faqs', 0 );

function create_section_tax() {
  register_taxonomy(
    'section',
    ['post', 'faqs', 'page'],
    array(
      'label' => __( 'Section' ),
      'rewrite' => array( 'slug' => 'section' ),
      'hierarchical' => true,
    )
  );
}

add_action( 'init', 'create_section_tax' );


/****************************
LOAD ACF FIELDS
*****************************/
require_once('acf-fields.php');
