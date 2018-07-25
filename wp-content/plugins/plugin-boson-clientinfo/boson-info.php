<?php
/*
   Plugin Name: Boson Web - Client Info Plugin
   Plugin URI: http://bosonweb.net
   Description: This plugin allows you to manage the clients generic in.
   Version: 1.0
   Author: Boson Web
   Author URI: http://bosonweb.net
   License: GPL2
   */

/***********************************************
ADVANCED CUSTOM FIELDS OPTIONS
***********************************************/
if( function_exists('acf_add_options_page') ) {

    // Theme Settings (Parent)
    acf_add_options_page(array(
        'page_title'    => 'My Info',
        'menu_title'    => 'My Info',
        'menu_slug'     => 'client-info',
        'capability'    => 'edit_posts',
        'parent_slug'   => '',
        'position'      => false,
        'icon_url'      => false,
        'redirect'      => false
    ));


    // Shop Settings
    acf_add_options_page(array(
        'page_title'    => 'Utility Settings',
        'menu_title'    => 'Utility Settings',
        'menu_slug'     => 'utility-settings',
        'capability'    => 'edit_posts',
        'parent_slug'   => '',
        'position'      => false,
        'icon_url'      => false,
        'redirect'      => false
    ));


  /****************************
  LOAD ACF FIELDS
  *****************************/
  require_once('acf-fields.php');

}

?>
