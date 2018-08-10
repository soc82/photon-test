<?php
/*
** Register custom shortcodes here
*/

/*
** Shortcode for Prospect to display user variables within their content
** See full list of user data here: https://codex.wordpress.org/Function_Reference/get_userdata
*/
function prospect_shortcode_user($atts) {

  global $user_login;
  $user = wp_get_current_user();

  $fallback = $atts['fallback'];
  $field = $atts['field'];

  if($field) {
    if($field == 'first_name') {
      $field = $user->first_name;
    } elseif($field == 'last_name') {
      $field = $user->last_name;
    } elseif($field == 'full_name') {
      $field = $user->first_name . ' ' . $user->last_name;
    } else {
      $field = null;
    }
  }

  if ($user_login):
    if($field):
      return $field;
    else:
      return $fallback;
    endif;
  else:
    return $fallback;
  endif;

}
add_shortcode( 'prospect_user', 'prospect_shortcode_user' );



?>
