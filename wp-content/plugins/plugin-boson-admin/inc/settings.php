<?php

// WP Settings

/***********************************************
HIDE ADMIN TOOLBAR ON FRONTEND
***********************************************/
show_admin_bar(false);


/***********************************************
IMAGE THUMBNAIL SIZES
***********************************************/
/* Default WP Sizes
thumb - 150 x 150
medium - 300 x 300
large - 1024 x 1024
*/
add_image_size( 'logo', 800, 140 );
add_image_size( 'small', 600, 600 );
add_image_size( 'medium-large', 800, 800 );
add_image_size( 'full-width', 1366, 1366 );


/***********************************************
REMOVE ITEMS FROM ADMIN MENU (FOR ALL USERS)
***********************************************/
add_action( 'admin_menu', 'my_remove_menu_pages' );
function my_remove_menu_pages() {
  //remove_menu_page( 'index.php' );                  //Dashboard
  //remove_menu_page( 'edit.php' );                   //Posts
  //remove_menu_page( 'upload.php' );                 //Media
  //remove_menu_page( 'edit.php?post_type=page' );    //Pages
  remove_menu_page( 'edit-comments.php' );            //Comments
  //remove_menu_page( 'themes.php' );                 //Appearance
  //remove_menu_page( 'plugins.php' );                //Plugins
  //remove_menu_page( 'users.php' );                  //Users
  //remove_menu_page( 'tools.php' );                  //Tools
  //remove_menu_page( 'options-general.php' );        //Settings
}

/***********************************************
SET IMAGE QUALITY
***********************************************/
add_filter( 'jpeg_quality', 'custom_image_quality' );
add_filter( 'wp_editor_set_quality', 'custom_image_quality' );
function custom_image_quality( $quality ) {
    return 70;
}

/***********************************************
DISABLE DASHBOARD WIDGETS
***********************************************/
function disable_default_dashboard_widgets() {

  // disable default dashboard widgets
  //remove_meta_box('dashboard_right_now', 'dashboard', 'core');
  remove_meta_box('dashboard_activity', 'dashboard', 'core');
  remove_meta_box('dashboard_recent_comments', 'dashboard', 'core');
  remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');
  remove_meta_box('dashboard_plugins', 'dashboard', 'core');

  remove_meta_box('dashboard_quick_press', 'dashboard', 'core');
  remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');
  remove_meta_box('dashboard_primary', 'dashboard', 'core');
  remove_meta_box('dashboard_secondary', 'dashboard', 'core');

  // disable Simple:Press dashboard widget
  remove_meta_box('sf_announce', 'dashboard', 'normal');
}
add_action('admin_menu', 'disable_default_dashboard_widgets');

/***********************************************
SET ERROR REPORTING
***********************************************/
//define('WP_DEBUG', true);
//define('WP_DEBUG_LOG', true);
//define('WP_DEBUG_DISPLAY', false);
//@ini_set('display_errors', 0);