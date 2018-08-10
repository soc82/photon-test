jQuery( document ).ready(function($) {

  /*
  ** Flexible content template customisations
  */
  jQuery('.flexible-content-wrapper .block').first().addClass('first-block');
  jQuery('.flexible-content-wrapper .block').last().addClass('last-block');


  /*
  ** Setting cookie for font size accessibility options
  */
  if(Cookies.get('prospect_font_size')) {
    var currentSize = Cookies.get('prospect_font_size');
    jQuery('body').addClass(currentSize);
    jQuery('.footer-accessibility a').each(function() {
      if(jQuery(this).parent('li').hasClass(currentSize)) {
        jQuery(this).parent('li').addClass('active-size');
      }
    });
  }
  jQuery('.footer-accessibility a').click(function() {
    var textSize = jQuery(this).parent().attr('class');
    jQuery('body').removeClass('accessibility-small accessibility-normal accessibility-large').addClass(textSize);
    jQuery('.footer-accessibility a').each(function() {
      jQuery(this).parent('li').removeClass('active-size');
    });
    jQuery(this).parent('li').addClass('active-size');
    Cookies.set('prospect_font_size', textSize, { expires:10000, path: '' });
    return false;
  });

  /*
  ** Mobile menu
  */
  new mlPushMenu( document.getElementById( 'mobile-menu' ), document.getElementById( 'trigger' ) );


  /*
  ** Lightbox image gallery
  */
  new LuminousGallery(document.querySelectorAll(".lightbox-gallery"));

  // Top Menu Search
	jQuery( ".menu-search-form input" ).click(function() {
		jQuery('.menu-item-search').addClass('active');
	});

  /*
  ** FAQ accordions
  */
  jQuery('.faqs-block .faq-question').click(function() {
    if(jQuery(this).parent().hasClass('active-faq')) {
      jQuery(this).parent().removeClass('active-faq');
    } else {
      jQuery(this).parent().addClass('active-faq');
    }
  });

  /*
  ** Init slick for testimonials
  */
  jQuery('.testimonials').slick({
    dots: false,
    arrows: true,
  });

  jQuery(document).ready( function () {
    jQuery('#applications-table').DataTable();
  });
  /*
  ** Form Autosubmitter
  */
  jQuery('.autosubmit-field').change(function() {
    jQuery(this).closest("form").submit();
  });




});
