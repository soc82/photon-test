<?php
/*
Plugin Name: Boson Web - Team Module
Plugin URI: http://web.boson.media
Description: This plugin allows you to manage your websites team.
Version: 1.0
Author: Boson Web
Author URI: http://web.boson.media
License: GPL2
*/

/****************************
REGISTER CUSTOM POST TYPE
*****************************/
function custom_post_type_team() {

    /********************
     TEAM POST TYPE
    ********************/
    $labels_team = array(
            'name'                => _x( 'Teams', 'Post Type General Name', 'vanilla' ),
            'singular_name'       => _x( 'Team', 'Post Type Singular Name', 'vanilla' ),
            'menu_name'           => __( 'Team', 'vanilla' ),
            'parent_item_colon'   => __( 'Parent Team', 'vanilla' ),
            'all_items'           => __( 'All Team', 'vanilla' ),
            'view_item'           => __( 'View Team', 'vanilla' ),
            'add_new_item'        => __( 'Add New Team', 'vanilla' ),
            'add_new'             => __( 'Add New', 'vanilla' ),
            'edit_item'           => __( 'Edit Team', 'vanilla' ),
            'update_item'         => __( 'Update Team', 'vanilla' ),
            'search_items'        => __( 'Search Team', 'vanilla' ),
            'not_found'           => __( 'Not Found', 'vanilla' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'vanilla' ),
    );
    $args_team = array(
            'label'               => __( 'team', 'vanilla' ),
            'description'         => __( 'Some of the team you provide', 'vanilla' ),
            'labels'              => $labels_team,
            'supports'            => array( 'title', 'editor'),
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'taxonomies'          => array('team-category'),
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 5,
            'menu_icon'           => 'dashicons-groups',
            'can_export'          => true,
            'has_archive'         => true, // index Page
            'exclude_from_search' => true,
            'publicly_queryable'  => true,
            'capability_type'     => 'page',
    );

    // Registering your Custom Post Type
    register_post_type( 'team', $args_team );
}

/* Hook into the 'init' action so that the function
 * Containing our post type registration is not
 * unnecessarily executed.
 */
add_action( 'init', 'custom_post_type_team', 0 );


add_action( 'init', 'create_team_tax' );

function create_team_tax() {
    register_taxonomy(
        'team-category',
        'team',
        array(
            'label' => __( 'Category' ),
            'rewrite' => array( 'slug' => 'team-category' ),
            'hierarchical' => true,
        )
    );
}



/****************************
LOAD TEMPLATES
*****************************/
add_filter('single_template', 'team_template');
function team_template($single) {

	/***************
	CPT NAME
	***************/
	$cptName = 'team';

    global $wp_query, $post;
    $plugin_path = plugin_dir_path( __FILE__ );
    /* Checks for single template by post type */
    if ($post->post_type == $cptName){

    	// Index Page
        if(file_exists($plugin_path . '/templates/archive-'.$cptName.'.php'))
            return $plugin_path . '/templates/archive-'.$cptName.'.php';

        // Custom Template Page
        if(file_exists($plugin_path . '/templates/page-'.$cptName.'.php'))
            return $plugin_path . '/templates/page-'.$cptName.'.php';

        // Detail Page
        if(file_exists($plugin_path . '/templates/single-'.$cptName.'.php'))
            return $plugin_path . '/templates/single-'.$cptName.'.php';

    }
    return $single;
}

/****************************
LOAD ACF FIELDS
*****************************/
require_once('acf-fields.php');


/****************************
ADD SAMPLE PAGE
*****************************/
register_activation_hook( __FILE__, 'add_default_page_team');

function add_default_page_team()
{
    $post = array(
          'comment_status' => 'closed',
          'ping_status' =>  'closed' ,
          'post_author' => 1,
          'post_date' => date('Y-m-d H:i:s'),
          'post_name' => 'Our Team',
          'post_status' => 'publish' ,
          'post_title' => 'Our Team',
          'post_type' => 'page',
    );
    //insert page and save the id
    $pageItem = wp_insert_post( $post, false );

    //save the id in the database
    update_option( 'hclpage', $pageItem );
}

?>
