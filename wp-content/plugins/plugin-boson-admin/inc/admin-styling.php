<?php

/***********************************************
ADD LOGIN PAGE STYLESHEET
***********************************************/
function my_custom_login() {
echo '<link rel="stylesheet" type="text/css" href="' . plugins_url() . '/plugin-boson-admin/css/login-page.css" />';
}
add_action('login_head', 'my_custom_login');

/***********************************************
CHANGE LOGIN PAGE LOGO URL
***********************************************/
function my_login_logo_url() {
  return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

/***********************************************
ADD ADMIN STYLESHEET
***********************************************/
function admin_style() {
  wp_enqueue_style('admin-styles', plugins_url() . '/plugin-boson-admin/css/admin.css');
}
add_action('admin_enqueue_scripts', 'admin_style');
