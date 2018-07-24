<?php

/*
   Plugin Name: Boson Web - Admin / Source
   Plugin URI: http://bosonweb.net
   Description: This plugin styles the admin login screen and adds some extra admin tidup functions.
   Version: 1.0
   Author: Boson Web
   Author URI: https://github.com/bosonweb
   License: GPL2
*/

require_once('inc/admin-styling.php'); // Admin Styling
require_once('inc/admin-updates.php'); // Functions used in admin
require_once('inc/customizer.php'); // Theme Options Customizer
require_once('inc/settings.php'); // Configuarable options
require_once('inc/useful-functions.php'); // Extra Functions used on frontend

/****************************
ADD HOMEPAGE
*****************************/
register_activation_hook( __FILE__, 'add_default_page_homepage');
function add_default_page_homepage()
{

    $page = get_page_by_title( 'Homepage' );
    if(empty($page)) {
        $post = array(
              'comment_status' => 'closed',
              'ping_status' =>  'closed' ,
              'post_author' => 1,
              'post_date' => date('Y-m-d H:i:s'),
              'post_name' => 'Homepage',
              'post_status' => 'publish' ,
              'post_title' => 'Homepage',
              'post_type' => 'page'
        );  
        //insert page and save the id
        $pageItem = wp_insert_post( $post, false );

        //save the id in the database
        update_option( 'hclpage', $pageItem );
    }
}