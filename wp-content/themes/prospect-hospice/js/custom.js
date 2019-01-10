/*
** Setting cookie for font size accessibility options
*/
jQuery(document).ready(function() {
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

jQuery( document ).ready(function($) {

  /*
  ** Flexible content template customisations
  */
  jQuery('.flexible-content-wrapper .block').first().addClass('first-block');
  jQuery('.flexible-content-wrapper .block').last().addClass('last-block');

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
  ** Luminous Lightbox
  */
  var galleryOpts = {

  };

  var luminousOpts = {
    caption: function(trigger) {
      return jQuery(trigger).data('caption');
    }
  };
  new LuminousGallery(document.querySelectorAll(".lightbox-gallery"), galleryOpts, luminousOpts);




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


  /*
  ** Donation page
  */
  jQuery('.single-donation-option').click(function(e) {
    jQuery(this).toggleClass('active-donate-option');
    jQuery('.single-donation-form').slideToggle();
    // Scroll to a certain element
    document.querySelector('.single-donation-form').scrollIntoView({
      behavior: 'smooth'
    });
  });


  /*
  ** Anchor Scroll
  */
  $('a.image-tile[href*=#]:not([href=#])').click(function () {
  if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') || location.hostname == this.hostname) {

      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
      if (target.length) {
          $('html,body').animate({
              scrollTop: target.offset().top
          }, 1000);
          return false;
      }
  }
  });


  /* On Light up life dontation page if user dontates then send different notifcation email, the conditional logic is used in admin form */
  $('.ginput_container_product_price input').on('change',function(e){
      var donationamount = $(this).val();
      if($.isNumeric(donationamount)) {
        $('#input_36_32, #input_30_32').val(donationamount);
      } else {
        $('#input_36_32, #input_30_32').val(0);
      }
  });

});

jQuery('a[href$=".pdf"]').click(function(){
  var pdfurl=jQuery(this).attr('href');
  if (typeof ga !== 'undefined') {
    ga('gtm1.send','event', 'PDF Download', 'Download', pdfurl);
  }
  if (typeof fbq !== 'undefined') {
    fbq('track', 'ViewContent', {
      type: 'PDF Download',
      url: pdfurl
    });
  }
  return true;
});
