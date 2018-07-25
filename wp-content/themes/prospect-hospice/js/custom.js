jQuery( document ).ready(function() {

  new mlPushMenu( document.getElementById( 'mobile-menu' ), document.getElementById( 'trigger' ) );

	// Yop Menu Search
	jQuery( ".menu-search-form input" ).click(function() {
		jQuery('.menu-item-search').addClass('active');
	});

});
