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

</script>
