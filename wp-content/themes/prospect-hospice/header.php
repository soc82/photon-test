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
	<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/modernizr.custom.js"></script>
	<script>
	/*
	** Setting cookie for font size accessibility options
	** Load it early doors
	*/
	jQuery(document).load(function() {
		if(Cookies.get('prospect_font_size')) {
			var currentSize = Cookies.get('prospect_font_size');
			jQuery('body').addClass(currentSize);
			jQuery('.footer-accessibility a').each(function() {
				if(jQuery(this).parent('li').hasClass(currentSize)) {
					jQuery(this).parent('li').addClass('active-size');
				}
			});
		}
	});
	</script>
	<meta name="theme-color" content="#c25cc3">
	<?php wp_head(); ?>
</head>
<?php
$terms = wp_get_post_terms(get_the_ID(), 'section');
$class = "";

if ($terms) {
	$class = $terms[0]->slug;
}
?>
<body <?php body_class($class); ?>>

	<!-- Push Wrapper -->
	<div class="mobile-pusher" id="mobile-pusher">

	<!-- mobile-menu -->
	<nav id="mobile-menu" class="mobile-menu">
		<div class="menu-level">
			<?php wp_nav_menu(array(
				'container_class' => false,
				'theme_location'	=> 'main-navigation',
				'menu_class' => false,
				'menu_id'	=> false,
				'walker'  => new wp_bootstrap_navwalker() //use our custom walker
			));?>

		</div>
	</nav>
	<!-- /mobile-menu -->
	<div class="scroller"><!-- this is for emulating position fixed of the nav -->
		<div class="scroller-inner">

				<div class="top-header-bar">
					<div class="container-fluid">
						<div class="row">
							<div class="col-12">
								<?php wp_nav_menu(array(
									'container_class' => 'top-navigation-wrapper',
									'theme_location'	=> 'top-navigation',
									'menu_class' => 'top-navigiation'));?>
									<a class="top-bar-cart" href="<?php echo wc_get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><i class="fal fa-shopping-bag"></i><?php echo WC()->cart->get_cart_total(); ?></a>
							</div>
						</div>
					</div>
				</div>
				<header class="site-header">
					<div class="container-fluid">
						<div class="row">
							<div class="col-12 col-md-3 col-lg-2">
								<a href="<?php echo home_url(); ?>" class="header-logo">
									<img src="<?php echo get_stylesheet_directory_uri() . '/img/prospect-hospice.png'; ?>" alt="<?php echo get_bloginfo('name'); ?>" class="img-fluid desktop-logo" />
									<img src="<?php echo get_stylesheet_directory_uri() . '/img/prospect-hospice-white.png'; ?>" alt="<?php echo get_bloginfo('name'); ?>" class="img-fluid mobile-logo" />
								</a>
								<?php if( WC()->cart->get_cart_contents_count() > 0 ) { ?>
									<a class="top-bar-cart mobile-cart" href="<?php echo wc_get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><i class="fal fa-shopping-bag"></i><?php echo WC()->cart->get_cart_total(); ?></a>
								<?php } ?>
							</div>
							<a href="#" id="trigger" class="menu-trigger"><i class="far fa-bars"></i></a>
							<div class="col-12 col-md-9 col-lg-10 desktop-navigation">
								<?php wp_nav_menu(array(
									'container_class' => 'main-navigation-wrapper',
									'theme_location'	=> 'main-navigation',
									'menu_class' => 'main-navigiation',
									'walker' => new prospect_desktop_walker()
								));?>
							</div>
						</div>
					</div>
				</header>
