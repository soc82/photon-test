jQuery( document ).ready(function($) {

  /* News form change */
  jQuery('.filter select').change(function(){
    jQuery(this).closest("form").submit();
  });

  /*
  ** FAQ accordions
  */
  jQuery('.accordion .question').click(function() {
    if(jQuery(this).parent().hasClass('active')) {
      jQuery(this).parent().removeClass('active');
    } else {
      jQuery(this).parent().addClass('active');
    }
  });

  /*
  ** Init slick for testimonials
  */
  jQuery('.testimonials').slick({
    dots: true,
    arrows: true,
  });

  jQuery(document).ready( function () {
    jQuery('#applications-table').DataTable();
  });
  /*
  ** Form Autosubmitter
  */
  jQuery('.autosubmit-field').change(function() {
    jQuery(this).parent().submit();
  });

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

	// Yop Menu Search
	jQuery( ".menu-search-form input" ).click(function() {
		jQuery('.menu-item-search').addClass('active');
	});

  /*
  ** Lightbox image gallery
  */
  new LuminousGallery(document.querySelectorAll(".lightbox-gallery"));


  jQuery('.faqs-block .faq-question').click(function () {
      jQuery(this).next('.faq-answer').slideToggle();
      jQuery(this).parent().siblings().children().next().slideUp();
      /*
      ** Leaving this here to remind to finish off FAQ's accordion
      */

      return false;
  });



});
