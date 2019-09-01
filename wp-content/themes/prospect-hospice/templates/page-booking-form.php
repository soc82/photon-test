<?php
/*
* Template Name: Event Booking Form Template
*/

acf_form_head();
get_header(); ?>

<div class="block">
  <div class="container">
    <div class="row">
      <div class="col-12 col-md-10 offset-md-1">
        <h1><?php the_title();?></h1>
        <?php the_content(); ?>
        <?php prospect_get_event_form(); ?>
      </div>
    </div>
  </div>
</div>
<?php get_footer(); ?>
<?php if(isset($_GET['event']) && $_GET['event']) {
  $terms_conditions = get_field('terms_conditions', $_GET['event']);
} ?>
<script>
    function calculate() {

        var attendees = 0;
        var price = 0;
        var $ticket_types = jQuery('[data-name=ticket_type] select:visible');

        var pricing = $ticket_types.first().closest('.acf-field').data('pricing');

        $ticket_types.each(function () {
            $this = jQuery(this);
            price = parseFloat(price, 10) + parseFloat(pricing[$this.val()], 10);
            attendees = attendees + 1;
        });

        jQuery('.event-total-attendees').replaceWith('<div class="event-total-attendees">Number of attendees: <span>' + attendees + '</span></div>');
        jQuery('.event-total-price').replaceWith('<div class="event-total-price">Total price: <span>£' + price + '</span></div>');

    }

    jQuery('.acf-repeater').on('change', calculate);
    jQuery(document).on('change', '[data-name=ticket_type] select', calculate);
    calculate();

    <?php if($terms_conditions){ ?>
      jQuery(document).ready(function($){
        var newTerms = $('[data-name="terms_&_conditions"] span.message').text().replace("Terms and Conditions", '<a href="<?php echo $terms_conditions['url']; ?>" target="_blank">Terms and Conditions</a>');
        jQuery('[data-name="terms_&_conditions"] span.message').html(newTerms);
    });
    <?php } ?>



    // TODO: Need to look at removing out any 'parent consent' ticket options from the first attendee, as this shouldn't be possible


    function acf_conditional_attendee_group() {

        var $child_added = false;

        // Hide the child form initially
        jQuery('.acf-field-clone[data-name="child"]').hide();

        var $field_group = jQuery('.acf-row:visible');


        // Loop through field groups
        jQuery.each($field_group, function (i) {

            var $this = jQuery(this);
            var $ticket_types = jQuery('[data-name=ticket_type] select:visible', $this);
            var $ticket_consent = $ticket_types.first().closest('.acf-field').data('parent-consent');


            // If child ticket selected, hide the default fields & show the child clone group
            if($ticket_consent[$ticket_types.val()] == true) {
                jQuery('.acf-field-clone[data-name="child"]', $this).show();
                jQuery('.acf-field-clone[data-name="adult"]', $this).hide();
                $child_added = true;
            } else {
                jQuery('.acf-field-clone[data-name="child"]', $this).hide();
                jQuery('.acf-field-clone[data-name="adult"]', $this).show();
            }
        });


        // Show code of conduct content if there is a child ticket added
        if(jQuery('.acf-field-clone[data-name="child"]:visible').length) {
            jQuery('#code-of-conduct-content').removeClass('d-none');
        } else {
            jQuery('#code-of-conduct-content').addClass('d-none');
        }

    }
    jQuery('.acf-repeater').on('change', acf_conditional_attendee_group);
    jQuery(document).on('change', '[data-name=ticket_type] select', acf_conditional_attendee_group);
    acf_conditional_attendee_group();


    /*
    function acf_clear_unused_fields() {

    }

    if ( 'undefined' !== typeof acf ) {
    	acf.add_filter( 'validation_complete', function( json, $form ) {
    		if ( json.valid && ! json.errors ) {
    	          acf_clear_unused_fields();
    		}

    		return json;
    	});
    }
    */



</script>
