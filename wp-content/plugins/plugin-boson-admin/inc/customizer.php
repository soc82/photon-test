<?php

/***********************************************
SETUP THEME SUPPORT
***********************************************/
add_action( 'after_setup_theme', 'cd_setup' );
function cd_setup() {
  add_theme_support( 'customize-selective-refresh-widgets' );
  add_theme_support( 'automatic-feed-links' );
  add_theme_support( 'title-tag' );
  add_theme_support( 'post-thumbnails' );
  add_theme_support(
    'html5', array(
      'search-form',
      'comment-form',
      'comment-list',
      'gallery',
      'caption',
    )
  );
}

/***********************************************
EXTRA THEME OPTIONS
***********************************************/
/* add_action('customize_register','mytheme_customizer_options');
function mytheme_customizer_options( $wp_customize ) {

	// Primary Color
	$wp_customize->add_setting('mytheme_primary_color', array('default' => '#333333'));
	$wp_customize->add_control(
     	new WP_Customize_Color_Control(
         	$wp_customize,
         	'mytheme_custom_primary_color', //give it an ID
         	array(
             	'label'      => __( 'Primary Color', 'startline' ), //set the label to appear in the Customizer
             	'section'    => 'colors', //select the section for it to appear under
             	'settings'   => 'mytheme_primary_color' //pick the setting it applies to
         	)
     	)
  	);

  	// Secondary Color
	$wp_customize->add_setting('mytheme_secondary_color', array('default' => '#333333'));
	$wp_customize->add_control(
     	new WP_Customize_Color_Control(
         	$wp_customize,
         	'mytheme_custom_secondary_color', //give it an ID
         	array(
             	'label'      => __( 'Secondary Color', 'startline' ), //set the label to appear in the Customizer
             	'section'    => 'colors', //select the section for it to appear under
             	'settings'   => 'mytheme_secondary_color' //pick the setting it applies to
         	)
     	)
  	);

  	// Text Color
	$wp_customize->add_setting('mytheme_text_color', array('default' => '#999999'));
	$wp_customize->add_control(
     	new WP_Customize_Color_Control(
         	$wp_customize,
         	'mytheme_custom_text_color', //give it an ID
         	array(
             	'label'      => __( 'Text Color', 'startline' ), //set the label to appear in the Customizer
             	'section'    => 'colors', //select the section for it to appear under
             	'settings'   => 'mytheme_text_color' //pick the setting it applies to
         	)
     	)
  	);

	// Link Color
	$wp_customize->add_setting('mytheme_link_color', array('default' => '#333333'));
	$wp_customize->add_control(
     	new WP_Customize_Color_Control(
         	$wp_customize,
         	'mytheme_custom_link_color', //give it an ID
         	array(
             	'label'      => __( 'Link Color', 'startline' ), //set the label to appear in the Customizer
             	'section'    => 'colors', //select the section for it to appear under
             	'settings'   => 'mytheme_link_color' //pick the setting it applies to
         	)
     	)
  	);

	// Link Hover Color
	$wp_customize->add_setting('mytheme_link_hover_color', array('default' => '#333333'));
	$wp_customize->add_control(
     	new WP_Customize_Color_Control(
         	$wp_customize,
         	'mytheme_custom_link_hover_color', //give it an ID
         	array(
             	'label'      => __( 'Link Hover Color', 'startline' ), //set the label to appear in the Customizer
             	'section'    => 'colors', //select the section for it to appear under
             	'settings'   => 'mytheme_link_hover_color' //pick the setting it applies to
         	)
     	)
  	);
}
*/
/******************************
******* ADD CSS TO SITE *******
*******************************/
/* add_action( 'wp_head', 'mytheme_customize_css' );
function mytheme_customize_css() {?>
	<style type="text/css">

 		.primary-bg, .primary-color,  .jumbotron h1, h1 { color:<?php echo get_theme_mod( 'mytheme_primary_color', '#333333' ); ?>; }

 		.secondary-bg, .primary-color, h2 { color:<?php echo get_theme_mod( 'mytheme_secondary_color', '#666666' ); ?>; }

 		.text-color, body, p { color:<?php echo get_theme_mod( 'mytheme_text_color', '#999999' ); ?>; }

 		a { color:<?php echo get_theme_mod( 'mytheme_link_color', '#14123D' ); ?>; }

 		a:hover { color:<?php echo get_theme_mod( 'mytheme_link_hover_color', '#333333' ); ?>; }

 	</style>
<?php } */

/**************************
******* CUSTOM LOGO *******
**************************/
add_action('customize_register', 'custom_logo_customizer');
function custom_logo_customizer($wp_customize){
	add_theme_support( 'custom-logo', array(
	    'height'      => 140,
	    'width'       => 300,
	    'flex-height' => true,
	    'flex-width'  => true,
	    'header-text' => array( 'site-title', 'site-description' ),
	) );
}

/******************************
******* ADD CSS TO SITE *******
*******************************/
add_action( 'login_head', 'mytheme_customize_login_css' );
function mytheme_customize_login_css() {

    // Get Logo
    $custom_logo_id = get_theme_mod( 'custom_logo' );
    $logo_url = wp_get_attachment_image_src( $custom_logo_id , 'logo' );?>
    <?php if ($logo_url) : ?>
      <style type="text/css">

        /* Logo */
        .login h1 a {
            background-image: url('<?php echo $logo_url[0]; ?>');
        }

        /* Button Colour */
       .login .button-primary { background-color:<?php echo get_theme_mod( 'mytheme_primary_color', '#D9B630' ); ?>; border-color:<?php echo get_theme_mod( 'mytheme_primary_color', '#D9B630' ); ?>; }
       .login .button-primary:hover { background-color:<?php echo get_theme_mod( 'mytheme_secondary_color', '#dd9933' ); ?>; border-color:<?php echo get_theme_mod( 'mytheme_primary_color', '#dd9933' ); ?>; }

      </style>
    <?php endif;?>



<?php }
