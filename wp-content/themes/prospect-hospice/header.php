<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>
	<link rel="apple-touch-icon" sizes="180x180" href="<?php bloginfo('stylesheet_directory'); ?>/img/favicons/apple-touch-icon.png">
	<link rel="icon" type="image/png" href="<?php bloginfo('stylesheet_directory'); ?>/img/favicons/favicon-32x32.png" sizes="32x32">
	<link rel="icon" type="image/png" href="<?php bloginfo('stylesheet_directory'); ?>/img/favicons/favicon-16x16.png" sizes="16x16">
	<link rel="manifest" href="<?php bloginfo('stylesheet_directory'); ?>/img/favicons/manifest.json">
	<link rel="mask-icon" href="<?php bloginfo('stylesheet_directory'); ?>/img/favicons/safari-pinned-tab.svg" color="#5bbad5">
	<meta name="theme-color" content="#c25cc3">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div class="page-wrapper">
	<div class="top-header-bar">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<?php wp_nav_menu(array(
						'container_class' => 'top-navigation-wrapper',
						'theme_location'	=> 'top-navigation',
						'menu_class' => 'top-navigiation'));?>
				</div>
			</div>
		</div>
	</div>
	<header class="site-header">
		<div class="container">
			<div class="row">
				<div class="col-3 col-lg-2">
					<a href="<?php echo home_url(); ?>" class="header-logo">
						<img src="<?php echo get_stylesheet_directory_uri() . '/img/prospect-hospice.png'; ?>" alt="<?php echo get_bloginfo('name'); ?>" class="img-fluid" />
					</a>
				</div>
				<div class="col-9 col-lg-10">
					<?php wp_nav_menu(array(
						'container_class' => 'main-navigation-wrapper',
						'theme_location'	=> 'main-navigation',
						'menu_class' => 'main-navigiation'));?>
				</div>
			</div>
		</div>
	</header>
