<?php

/*************************************
** Custom functions to be add below
**************************************/

/*
** Add search form to top navigation
*/
function prospect_search_form_to_menu ( $items, $args ) {
	if( 'top-navigation' === $args->theme_location && $args->menu_id == 'top-navigation') {
		$search_form = '';
		$search_form .= '<li class="menu-item menu-item-search">';
		$search_form .= '<form method="get" class="menu-search-form" action="' . esc_url( home_url( '/' ) ) . '" /"><input class="text_input" type="text" placeholder="Search" name="s" id="s" /></form>';
		$search_form .= '</li>';
		$items = $search_form . $items;
	}
  return $items;
}
add_filter('wp_nav_menu_items','prospect_search_form_to_menu',10,2);


/*
** Gets the Donate page id
*/
function prospect_get_donate_page_ID() {
		$page = get_field('donate_page', 'options');
		if($page)
			return $page->ID;
}

/*
** Returns list of taxonomies for filtering job pages
*/
function prospect_get_jobs_filters($job_section) {
    $terms = get_terms( array(
        'taxonomy' => 'jobtype',
        'hide_empty' => true,
    ) );

    return $terms;
}


/*
** Modify ACF text and textarea fields to accept shortcodes
*/
function prospect_allow_shortcode_in_acf_fields( $value, $post_id, $field ) {
	$value = do_shortcode($value);
	return $value;
}
add_filter('acf/format_value/type=textarea', 'prospect_allow_shortcode_in_acf_fields', 10, 3);
add_filter('acf/format_value/type=text', 'prospect_allow_shortcode_in_acf_fields', 10, 3);


/*
** Checks if the background colour is dark and returns white class (for themeing)
** For use in flexible content field
*/
function prospect_dark_colour_class() {
	$background_colour = get_sub_field('background_colour', get_the_ID());
	$dark_colors = array('#bf3051', '#639144', '#525c63', '#f7941d');
	$color_class = '';
	if(in_array($background_colour, $dark_colors)){
		$color_class = 'color-white';
	}
	return $color_class;
}

/*
** Adds a close item to the menu
*/
add_filter('wp_nav_menu_items', 'prospect_add_close_item', 10, 2);
function prospect_add_close_item($items, $args){
    if( $args->theme_location == 'top-navigation' && $args->menu_id == 'mob-menu-top' ){
    	$search_form = '';
		$search_form .= '<li class="menu-item mobile-menu-item-search">';
		$search_form .= '<form method="get" class="menu-search-form" action="' . esc_url( home_url( '/' ) ) . '" /"><input class="text_input" type="text" placeholder="Search" name="s" id="s" /></form>';
		$search_form .= '</li>';
		$items = $search_form . $items;
		$items = '<a class="mp-close close">&nbsp;</a>' . $items;
    }
    return $items;
}


/*
** Change Wordpress sender email and name
*/
function prospect_sender_email( $original_email_address ) {
    return 'webmaster@prospect-hospice.net ';
}

function prospect_sender_name( $original_email_from ) {
    return 'Prospect Hospice';
}

add_filter( 'wp_mail_from', 'prospect_sender_email' );
add_filter( 'wp_mail_from_name', 'prospect_sender_name' );


/*
** Stop GF anchor scrolling on form submission
*/
add_filter( 'gform_confirmation_anchor', '__return_true' );


function wpse28782_remove_menu_items() {

    // Hide draft event entries for all
    remove_menu_page('edit.php?post_type=draft-event-entry'); // Event Entry

    // If HR User ...
    if( current_user_can( 'hr' )):
        remove_menu_page('edit.php?post_type=event-entry'); // Event Entry
        remove_menu_page('edit.php'); // Newss
        remove_menu_page('upload.php'); // Media
        remove_menu_page('link-manager.php'); // Links
        remove_menu_page('edit-comments.php'); // Comments
        remove_menu_page('edit.php?post_type=page'); // Pages
        remove_menu_page('edit.php?post_type=draft-event-entry'); // Draft event entries
        remove_menu_page('plugins.php'); // Plugins
        remove_menu_page('themes.php'); // Appearance
        remove_menu_page('users.php'); // Users
        remove_menu_page('tools.php'); // Tools
        remove_menu_page('options-general.php'); // Settings
    endif;

    if(current_user_can( 'volunteering' )):
        remove_menu_page('edit.php?post_type=event-entry'); // Event Entry
        remove_menu_page('edit.php'); // Newss
        remove_menu_page('upload.php'); // Media
        remove_menu_page('link-manager.php'); // Links
        remove_menu_page('edit-comments.php'); // Comments
        remove_menu_page('edit.php?post_type=draft-event-entry'); // Draft event entries
        remove_menu_page('plugins.php'); // Plugins
        remove_menu_page('themes.php'); // Appearance
        remove_menu_page('users.php'); // Users
        remove_menu_page('tools.php'); // Tools
        remove_menu_page('options-general.php'); // Settings
        remove_menu_page('edit.php?post_type=downloads'); // Downloads
        remove_menu_page('edit.php?post_type=courses'); // Courses
        remove_menu_page('edit.php?post_type=faqs'); // FAQs
        remove_menu_page('edit.php?post_type=shop'); // Shops
        remove_menu_page('edit.php?post_type=team'); // Team
        remove_menu_page('edit.php?post_type=testimonials'); // Testimonials
    endif;

    if (current_user_can('fundraising')):
        remove_menu_page('edit.php?post_type=downloads'); // Downloads
        remove_menu_page('edit.php?post_type=courses'); // Courses
        remove_menu_page('edit.php?post_type=faqs'); // FAQs
        remove_menu_page('edit.php?post_type=shop'); // Shops
        remove_menu_page('edit.php?post_type=team'); // Team
        remove_menu_page('edit.php?post_type=testimonials'); // Testimonials
        remove_menu_page('edit.php'); // Newss
        remove_menu_page('tools.php'); // Tools
    endif;

    if ( current_user_can('retail')):
        remove_menu_page('edit.php?post_type=draft-event-entry'); // Draft event entries
        remove_menu_page('edit.php?post_type=event-entry'); // Event entries
        remove_menu_page('edit.php'); // Newss
        remove_menu_page('tools.php'); // Tools
    endif;

    if ( current_user_can('comms_team')):
        remove_menu_page('tools.php'); // Tools
    endif;

    if ( current_user_can('super_user')):
        remove_menu_page('tools.php'); // Tools
    endif;

}
add_action( 'admin_menu', 'wpse28782_remove_menu_items' );


add_action( 'editable_roles' , 'prospect_hide_unused_roles' );
function prospect_hide_unused_roles( $roles ){
    if (current_user_can('administrator')) {
        return $roles;
    }
    unset($roles['author']);
    unset($roles['content_keeper']);
    unset($roles['contributor']);
    unset($roles['wpseo_editor']);
    unset($roles['wpseo_manager']);
    unset($roles['editor']);
    unset($roles['shop_manager']);
    unset($roles['administrator']);

    return $roles;
}

add_filter('gform_form_post_get_meta', function ($meta) {

	$meta['gravity-forms-entry-expiration'] = array (
		'deletionEnable' => '1',
		'deletionDate' => array (
			'number' => '28',
			'unit' => 'days'
		),
		'deletionRunTime' => array (
			'number' => '12',
			'unit' => 'hours'
		) );

	return $meta;
});

add_filter( 'gform_confirmation', function ($confirmation, $form) {
	if ( is_string($confirmation ) ) {
		$confirmation .= <<<EOT
<script type="text/javascript">
var url = location.href;
if (url.indexOf('?') == -1) {
	url += '?thankyou';
} else {
	url += '&thankyou';
}
window.history.pushState({}, window.title, url);
jQuery(document).ready(function () {
	ga( 'gtm1.set', 'page', location.href );
	ga( 'gtm1.send','pageview' );
});


</script>
EOT;
	}
	return $confirmation;
}, 10, 4 );

add_action('init', function (){
	add_feed('indeedjobs', 'indeedJobsFeed');
});

function indeedJobsFeed(){
	get_template_part('xml', 'indeedjobs');
}



/*
** Custom function to send donation thank you emails to get around priority issues with getting transaction id
*/
function ph_send_donation_email($status, $trans_id, $entry, $amount) {

	if($status == 'complete') {
		$subject = 'Prospect Hospice: Payment received for your online donation: ' . $entry['id'];
	} else {
		$subject = 'Prospect Hospice: Payment unsuccessful for your online donation';
	}

	$to = $entry[3] . ', fundraising&events@prospect-hospice.net';
	$body = '
	<body style="background:#EEEEEE; font-size: 16px; line-height:22px; color:#151515; font-family: Arial, sans-serif;">
		<table style="background:#EEEEEE;" width="600" cellpadding="0" cellspacing="0" align="center" style="margin: 0 auto 0 auto; width: 600px;">
			<tr>
				<td height="100"></td>
			</tr>
			<tr>
				<td width="100%" align="center">
					<table style="background:#FFFFFF" cellpadding="0" cellspacing="0">
						<tr>
							<td width="25" height="20"></td>
							<td width="175"></td>
							<td width="50"></td>
							<td width="325" align="right"></td>
							<td width="25"></td>
						</tr>
						<tr>
							<td width="25"></td>
							<td width="175"><img src="https://www.prospect-hospice.net/wp-content/themes/prospect-hospice/img/prospect-hospice.png" alt="Prospect Hospice" width="175" /></td>
							<td width="50"></td>
							<td width="325" align="right"><p style="color:#84BD00; font-size: 15px; line-height:21px; text-align:right;">Bringing confidence, comfort and care for patients and families since 1980</p></td>
							<td width="25"></td>
						</tr>
					</table>
					<table style="background:#FFFFFF" cellpadding="0" cellspacing="0" >
						<tr>
							<td width="25" height="20"></td>
							<td width="550" ></td>
							<td width="25"></td>
						</tr>
						<tr>
							<td width="25"></td>
							<td width="550" ><p style="color:#151515; font-size: 15px; line-height:21px;">
							Dear ' . $entry[1] . ' ' . $entry[2] . ',<br/>
							<br/>
							On behalf of everyone at Prospect Hospice, thank you, we have received your payment for your online donation.<br/>
							<br/>
							Payment amount: £' . $amount . '<br/>
							Payment reference: '. $entry['id'] . '<br/>
							Transaction reference: ' . $trans_id . '<br/>
							<br/>
							With thanks and kind regards,<br/>

							Prospect hospice
							</p>
							</td>
							<td width="25"></td>
						</tr>
						<tr>
							<td width="25" height="20"></td>
							<td width="550" ></td>
							<td width="25"></td>
						</tr>
					</table>
					<table style="background:#84BD00" cellpadding="0" cellspacing="0">
						<tr>
							<td width="25" height="20"></td>
							<td width="550"><td width="25"></td>
						</tr>
						<tr>
							<td width="25"></td>
							<td width="550"><p style="color:#FFFFFF; font-size: 12px; line-height:18px;">You have been sent this email as a result of donating, registering or booking a course on the Prospect Hospice website.<br/>
							<br/>
							You can change your contact preferences and how we communicate with you any time, in any of these three simple ways; call us on 01793 816161, email us on <a href="MAILTO:dataadmin@prospect-hospice.net">dataadmin@prospect-hospice.net</a> or visit <a href="http://www.prospect-hospice.net/how-you-hear-from-us">www.prospect-hospice.net/how-you-hear-from-us</a>. For more guidance on how we use your information please visit <a href="www.prospect-hospice.net/privacy-policy">www.prospect-hospice.net/privacy-policy.</a><br/>
							<br/>
							Prospect Hospice is a working name of Prospect Hospice Limited. Registered Office: Moormead Road, Wroughton, Swindon, Wiltshire, SN4 9BY. A company limited by guarantee registered in England and Wales (1494909) and a charity registered in England and Wales (280093).</p>
							</td>
							<td width="25"></td>
						</tr>
						<tr>
							<td width="25" height="20"></td>
							<td width="550"><td width="25"></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>';

	$headers  = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type: text/html; charset=".get_bloginfo('charset')."" . "\r\n";
	$headers .= "From: Prospect Hospice <communications@prospect-hospice.net>" . "\r\n";

	wp_mail( $to, $subject, $body, $headers );
}

/*
** Set sender path to from address
*/
add_action( 'phpmailer_init', 'ph_phpmailer_return_path' );
function ph_phpmailer_return_path( $phpmailer ) {
    $phpmailer->Sender = $phpmailer->From;
}
