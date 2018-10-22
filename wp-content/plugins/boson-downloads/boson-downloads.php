<?php
/*
Plugin Name: Boson Web - Downloads Module
Plugin URI: http://bosonweb.net
Description: This plugin allows you to manage your downloads.
Version: 1.0
Author: Boson Web
Author URI: http://bosonweb.net
License: GPL2
*/

function custom_post_type_downloads() {

  /********************
  PROJECTS POST TYPE
  ********************/
  $labels_downloads = array(
    'name'                => _x( 'Downloads', 'Post Type General Name', 'vanilla' ),
    'singular_name'       => _x( 'Download', 'Post Type Singular Name', 'vanilla' ),
    'menu_name'           => __( 'Downloads', 'vanilla' ),
    'parent_item_colon'   => __( 'Parent Download', 'vanilla' ),
    'all_items'           => __( 'All Downloads', 'vanilla' ),
    'view_item'           => __( 'View Download', 'vanilla' ),
    'add_new_item'        => __( 'Add New Download', 'vanilla' ),
    'add_new'             => __( 'Add New', 'vanilla' ),
    'edit_item'           => __( 'Edit Download', 'vanilla' ),
    'update_item'         => __( 'Update Download', 'vanilla' ),
    'search_items'        => __( 'Search Download', 'vanilla' ),
    'not_found'           => __( 'Not Found', 'vanilla' ),
    'not_found_in_trash'  => __( 'Not found in Trash', 'vanilla' ),
  );
  $rewrite = array(
    'slug'                  => 'downloads',
    'with_front'            => false,
  );
  $args_downloads = array(
    'label'               => __( 'downloads', 'vanilla' ),
    'description'         => __( 'Some of the projects you provide', 'vanilla' ),
    'labels'              => $labels_downloads,
    'supports'            => array( 'title', 'editor', 'thumbnail' ),
    // 'taxonomies'            => array( 'section' ),
    'public'              => true,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'show_in_nav_menus'   => true,
    'hierarchical'        => true,
    'show_in_admin_bar'   => true,
    'menu_position'       => 4,
    'menu_icon'           => 'dashicons-download',
    'can_export'          => true,
    'has_archive'         => true, // index Page
    'exclude_from_search' => false,
    'publicly_queryable'  => true,
    'rewrite'               => $rewrite,
    'capability_type'     => 'page',
    'capabilities' => array(
      'edit_post'          => 'edit_download', 
      'read_post'          => 'read_download', 
      'delete_post'        => 'delete_download', 
      'edit_posts'         => 'edit_downloads', 
      'edit_others_posts'  => 'edit_others_downloads', 
      'publish_posts'      => 'publish_downloads',       
      'read_private_posts' => 'read_private_downloads', 
      'create_posts'       => 'edit_downloads', 
    ),
  );

  // Registering your Custom Post Type
  register_post_type( 'downloads', $args_downloads );

}

/* Hook into the 'init' action so that the function
* Containing our post type registration is not
* unnecessarily executed.
*/
add_action( 'init', 'custom_post_type_downloads', 0 );

/*
function create_department_tax() {
  register_taxonomy(
    'department',
    ['downloads'],
    array(
      'label' => __( 'Department' ),
      'rewrite' => array( 'slug' => 'department' ),
      'hierarchical' => true,
    )
  );
}
add_action( 'init', 'create_department_tax' );
*/

function create_doc_category_tax() {
  register_taxonomy(
    'download-category',
    ['downloads'],
    array(
      'label' => __( 'Category' ),
      'rewrite' => array( 'slug' => 'document-category' ),
      'hierarchical' => true,
    )
  );
}
add_action( 'init', 'create_doc_category_tax' );


/*
** Get the file type and return relevant FA icon
*/
function prospect_file_type_icon($post_id) {
  $icon = '';
  $file = get_field('file', $post_id);
  if(!$file){
    return 'fa-file';
  }
  $type = $file['subtype'];
  $images = array('jpeg','png','jpe','jpg','gif','bmp','ico','tiff','tif','svg','svgz');
  $text = array('txt','htm','html');
  $archives = array('zip','rar','exe','msi','cab');
  $audio_video = array('mp3','qt', 'mov');

  if(in_array($file['subtype'],$images)) {
    $icon = 'fa-file-image';
  } elseif(in_array($file['subtype'],$text)) {
    $icon = 'fa-file-alt';
  } elseif(in_array($file['subtype'],$archives)) {
    $icon = 'fa-file-archive';
  } elseif(in_array($file['subtype'],$audio_video)) {
    $icon = 'fa-file-audio';
  } elseif($file['subtype'] == 'pdf') {
    $icon = 'fa-file-pdf';
  } elseif($file['subtype'] == 'doc') {
    $icon = 'fa-file-word';
  } elseif($file['subtype'] == 'xls') {
    $icon = 'fa-file-excel';
  } elseif($file['subtype'] == 'ppt') {
    $icon = 'fa-file-powerpoint';
  } else {
    $icon = 'fa-file';
  }
  return $icon;
}


/****************************
LOAD ACF FIELDS
*****************************/
require_once('acf-fields.php');
