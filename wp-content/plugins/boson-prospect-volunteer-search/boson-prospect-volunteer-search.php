<?php
/*
   Plugin Name: Boson Web - Prospect Volunteering search
   Plugin URI: http://bosonweb.net
   Description: This plugin powers the vulunteering position skills search.
   Version: 1.0
   Author: Ashley Coles - Boson Web
   Author URI: http://bosonweb.net
   License: GPL2
   */

require_once('inc/Prospect_volunteer_search.php');
// require_once('acf-fields.php');

add_shortcode('volunteer-search', array('Prospect_volunteer_search', 'shortcode'));

function init_action() {
   if (!is_admin()) {
   	$volunteer_search = new Prospect_volunteer_search();
   }
}

add_action('init', 'init_action');

// Register an options page
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page('Volunteering Search Settings');
}
// Load custom fields