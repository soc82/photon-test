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



    // For lead booker, remove any child/under ticket options as lead booker should always be an adult
    function lead_attendee_remove_child_tickets($this = 'test') {

        // Target lead booker only
        var $lead_group = jQuery('.acf-fields:visible').first();
        var $ticket_types = jQuery('[data-name=ticket_type] select:visible', $lead_group);
        var $ticket_consent = $ticket_types.closest('.acf-field').data('parent-consent');

        // Build array of ticket consents from 'parent-consent' data attribute
        var $consents = new Array();
        jQuery.each($ticket_consent, function(i, e) {
            $consents.push(e);
        });


        // Loop through ticket options (alongside $consents array), and remove any child tickets
        var $options = jQuery('[data-name=ticket_type] select:visible option', $lead_group);
        jQuery.each($options, function(i, item) {
            if($consents[i] == true) {
                jQuery($options[i]).hide();
            }
        });
    }
    lead_attendee_remove_child_tickets();



    function conditional_attendee_group($el = false) {

        var $child_added = false;
        var $children = 0;
        var $adults = 1; // Starting at 1 as the lead booker has already been added

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
                jQuery('.acf-field-clone[data-name="adult"]', $this).find(':input').prop('disabled', true);
                jQuery('.acf-field-clone[data-name="child"]', $this).find(':input:visible').prop('disabled', false);
                //jQuery('.acf-field-clone[data-name="child"] .acf-field', $this).not($hidden_child_fields).removeClass('acf-hidden').removeAttr('hidden');
                //jQuery('.acf-field-clone[data-name="adult"] .acf-field', $this).not($hidden_adult_fields).addClass('acf-hidden').attr('hidden');
                $children++;
                $child_added = true;
            } else {
                jQuery('.acf-field-clone[data-name="child"]', $this).hide();
                jQuery('.acf-field-clone[data-name="child"]', $this).find(':input').prop('disabled', true);
                jQuery('.acf-field-clone[data-name="adult"]', $this).find(':input:visible').prop('disabled', false);
                //jQuery('.acf-field-clone[data-name="child"] .acf-field', $this).not($hidden_child_fields).addClass('acf-hidden').attr('hidden');
                //jQuery('.acf-field-clone[data-name="adult"] .acf-field', $this).not($hidden_adult_fields).removeClass('acf-hidden').removeAttr('hidden');
                jQuery('.acf-field-clone[data-name="adult"]', $this).show();
                $adults++;
            }

            if(!jQuery('.acf-field-clone[data-name="child"] .acf-clone-fields .code-of-conduct-link', $this).length && jQuery('#code-of-conduct-content').length) {
                jQuery('.acf-field-clone[data-name="child"] .acf-clone-fields', $this).append('<a href="#code-of-conduct-content" rel="modal:open" class="acf-field d-block code-of-conduct-link">Click here to read our behaviour code.<br/></a>');
            }

        });


        // If more than 4 children for adult, flag up message and revert the ticket select to default
        if( $children > ($adults * 4) ) {
            alert('**Please note, for every lead booker (supervising adult), only four children can be registered. For larger groups please contact us directly on 01793 816161**');
            jQuery($el.target).val(false);
        }


    }


    jQuery('.acf-repeater').on('change', conditional_attendee_group);
    jQuery(document).on('change', '[data-name=ticket_type] select', function($el) {
        conditional_attendee_group($el);
    });
    conditional_attendee_group();


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
