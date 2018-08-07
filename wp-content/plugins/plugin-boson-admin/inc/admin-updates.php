<?php

// Admin function / updates


/***********************************************
LET EDITORS MANAGER USERS.
- - - - - - - - - - - - -
Boson tend to setup clients as editors, so this
allows them to manage other users without giving
them full administrator access.
***********************************************/
function isa_editor_manage_users() {

  if ( get_option( 'isa_add_cap_editor_once' ) != 'done' ) {

      // let editor manage users

      $edit_editor = get_role('editor'); // Get the user role
      $edit_editor->add_cap('edit_users');
      $edit_editor->add_cap('list_users');
      $edit_editor->add_cap('promote_users');
      $edit_editor->add_cap('create_users');
      $edit_editor->add_cap('add_users');
      $edit_editor->add_cap('delete_users');

      update_option( 'isa_add_cap_editor_once', 'done' );
  }

}
add_action( 'init', 'isa_editor_manage_users' );

/***********************************************
ADDING USERS TO MENU
- - - - - - - - - - -
Prevent editor from deleting, editing, or creating an administrator.
Only needed if the editor was given right to edit users
***********************************************/
class ISA_User_Caps {

  // Add our filters
  function ISA_User_Caps_Func(){
      add_filter( 'editable_roles', array(&$this, 'editable_roles'));
      add_filter( 'map_meta_cap', array(&$this, 'map_meta_cap'),10,4);
  }

  // Remove 'Administrator' from the list of roles if the current user is not an admin
  function editable_roles( $roles ){
      if( isset( $roles['administrator'] ) && !current_user_can('administrator') ){
          unset( $roles['administrator']);
      }
      return $roles;
  }

  // If someone is trying to edit or delete an
  // admin and that user isn't an admin, don't allow it
  function map_meta_cap( $caps, $cap, $user_id, $args ){
      switch( $cap ){
          case 'edit_user':
          case 'remove_user':
          case 'promote_user':
              if( isset($args[0]) && $args[0] == $user_id )
                  break;
                  elseif( !isset($args[0]) )
                  $caps[] = 'do_not_allow';
                  $other = new WP_User( absint($args[0]) );
                  if( $other->has_cap( 'administrator' ) ){
                      if(!current_user_can('administrator')){
                          $caps[] = 'do_not_allow';
                      }
                  }
                  break;
          case 'delete_user':
          case 'delete_users':
              if( !isset($args[0]) )
                  break;
                  $other = new WP_User( absint($args[0]) );
                  if( $other->has_cap( 'administrator' ) ){
                      if(!current_user_can('administrator')){
                          $caps[] = 'do_not_allow';
                      }
                  }
                  break;
          default:
              break;
      }
      return $caps;
  }

}

$isa_user_caps = new ISA_User_Caps();


/***********************************************
HIDE ALL ADMIN FROM USER LIST (EDITORS)
***********************************************/
add_action('pre_user_query','isa_pre_user_query');
function isa_pre_user_query($user_search) {

  $user = wp_get_current_user();

  if ( ! current_user_can( 'manage_options' ) ) {

      global $wpdb;

      $user_search->query_where =
      str_replace('WHERE 1=1',
              "WHERE 1=1 AND {$wpdb->users}.ID IN (
              SELECT {$wpdb->usermeta}.user_id FROM $wpdb->usermeta
              WHERE {$wpdb->usermeta}.meta_key = '{$wpdb->prefix}capabilities'
              AND {$wpdb->usermeta}.meta_value NOT LIKE '%administrator%')",
              $user_search->query_where
      );

  }
}


/***********************************************
GIVE EDITORS ABILITY TO EDIT MENUS
***********************************************/
$role_object = get_role( 'editor' );
$role_object->add_cap( 'edit_theme_options' );

// Hide Blog categories and tags
add_action('admin_menu', 'my_remove_sub_menus');
function my_remove_sub_menus() {
  //remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=category');
  remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=post_tag');
}
// REMOVE POST META BOXES
function remove_my_post_metaboxes() {
//remove_meta_box( 'categorydiv','post','normal' ); // Categories Metabox
remove_meta_box( 'tagsdiv-post_tag','post','normal' ); // Tags Metabox
}
add_action('admin_menu','remove_my_post_metaboxes');

/***********************************************
CHANGE LOGIN LOGO URL TITLE
***********************************************/
function my_login_logo_url_title() {
  return 'Boson';
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );


/***********************************************
REMOVE ACCURATE LOGIN ERROR (SECURITY)
***********************************************/
function login_error_override()
{
  return 'Incorrect login details.';
}
add_filter('login_errors', 'login_error_override');


/***********************************************
REMEMBER ME TICKED BY DEFAULT
***********************************************/
function login_checked_remember_me() {
  add_filter( 'login_footer', 'rememberme_checked' );
}
add_action( 'init', 'login_checked_remember_me' );

function rememberme_checked() {
  echo "<script>document.getElementById('rememberme').checked = true;</script>";
}


/***********************************************
CUSTOM DATE COLUMN
***********************************************/
function my_custom_columns( $columns ) {
  unset( $columns['date'] );
  $columns['mydate'] = 'Status & Date';
  return $columns;
}

function my_format_column( $column_name , $post_id ) {
  if($column_name == 'mydate'){
      echo ucfirst(get_post_status( $post_id )) . "<br>" . get_the_time( 'F jS, Y', $post_id );
  }
}

function my_column_register_sortable( $columns ) {
  $columns['mydate'] = 'mydate';
  return $columns;
}

function my_column_orderby( $vars ) {
  if ( isset( $vars['orderby'] ) && 'mydate' == $vars['orderby'] ) {
      $vars = array_merge( $vars, array(
              'orderby' => 'date'
      ) );
  }
  return $vars;
}

function my_column_init() {
  add_filter( 'manage_posts_columns' , 'my_custom_columns' );
  add_action( 'manage_posts_custom_column' , 'my_format_column' , 10 , 2 );
  add_filter( 'manage_edit-post_sortable_columns', 'my_column_register_sortable' );
  add_filter( 'manage_pages_columns' , 'my_custom_columns' );
  add_action( 'manage_pages_custom_column' , 'my_format_column' , 10 , 2 );
  add_filter( 'manage_edit-page_sortable_columns', 'my_column_register_sortable' );
  add_filter( 'request', 'my_column_orderby' );
}
add_action( 'admin_init' , 'my_column_init' );




/***********************************************
CHANGE BLOG LABEL TO NEWS
***********************************************/
add_action( 'admin_menu', 'pilau_change_post_menu_label' );
add_action( 'init', 'pilau_change_post_object_label' );
function pilau_change_post_menu_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'News';

    if (array_key_exists('edit.php', $submenu)) {
        $submenu['edit.php'][5][0]  = 'News';

    if (count($submenu['edit.php']) >= 11) {
      $submenu['edit.php'][10][0] = 'Add News';
    }

    if (count($submenu['edit.php']) >= 17) {
        $submenu['edit.php'][16][0] = 'News Tags';
    }
  }
  echo '';
}
function pilau_change_post_object_label() {
  global $wp_post_types;
  $labels = &$wp_post_types['post']->labels;
  $labels->name = 'News';
  $labels->singular_name = 'News';
  $labels->add_new = 'Add News';
  $labels->add_new_item = 'Add News';
  $labels->edit_item = 'Edit News';
  $labels->new_item = 'News';
  $labels->view_item = 'View News';
  $labels->search_items = 'Search News';
  $labels->not_found = 'No News found';
  $labels->not_found_in_trash = 'No News found in Trash';
}
