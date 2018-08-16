<?php
/*
Plugin Name: Boson Web - Shops Module
Plugin URI: http://bosonweb.net
Description: This plugin allows you to manage shop locations.
Version: 1.0
Author: Boson Web
Author URI: http://bosonweb.net
License: GPL2
*/

function custom_post_type_shops() {

  /********************
  shops POST TYPE
  ********************/
  $labels_shops = array(
    'name'                => _x( 'Shops', 'Post Type General Name', 'vanilla' ),
    'singular_name'       => _x( 'Shop', 'Post Type Singular Name', 'vanilla' ),
    'menu_name'           => __( 'Shops', 'vanilla' ),
    'parent_item_colon'   => __( 'Parent shop', 'vanilla' ),
    'all_items'           => __( 'All shops', 'vanilla' ),
    'view_item'           => __( 'View shop', 'vanilla' ),
    'add_new_item'        => __( 'Add New shop', 'vanilla' ),
    'add_new'             => __( 'Add New', 'vanilla' ),
    'edit_item'           => __( 'Edit shop', 'vanilla' ),
    'update_item'         => __( 'Update shop', 'vanilla' ),
    'search_items'        => __( 'Search shop', 'vanilla' ),
    'not_found'           => __( 'Not Found', 'vanilla' ),
    'not_found_in_trash'  => __( 'Not found in Trash', 'vanilla' ),
  );
  $rewrite = array(
    'slug'                  => 'shop',
    'with_front'            => false,
  );
  $args_shops = array(
    'label'               => __( 'Shops', 'vanilla' ),
    'description'         => __( 'Some of the projects you provide', 'vanilla' ),
    'labels'              => $labels_shops,
    'supports'            => array( 'title', 'editor', 'thumbnail' ),
    'public'              => true,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'show_in_nav_menus'   => true,
    'hierarchical' => true,
    'show_in_admin_bar'   => true,
    'menu_position'       => 4,
    'menu_icon'           => 'dashicons-building',
    'can_export'          => true,
    'has_archive'         => false, // index Page
    'exclude_from_search' => false,
    'publicly_queryable'  => true,
    'rewrite'               => $rewrite,
    'capability_type'     => 'page',

  );

  // Registering your Custom Post Type
  register_post_type( 'shop', $args_shops );
}

/* Hook into the 'init' action so that the function
* Containing our post type registration is not
* unnecessarily executed.
*/
add_action( 'init', 'custom_post_type_shops', 0 );

/****************************
LOAD SINGLE TEMPLATE
*****************************/
add_filter('single_template', 'shops_single_template');
function shops_single_template($single) {
    $cptName = 'shop';
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
