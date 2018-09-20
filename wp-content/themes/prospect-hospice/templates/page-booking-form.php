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
        <?php the_content(); ?>
        <?php prospect_get_event_form(); ?>
      </div>
    </div>
  </div>
</div>
<?php get_footer(); ?>

<?php
if(isset($_GET['event'])):
  $product = wc_get_product($_GET['event']); ?>
  <script>
    jQuery('.acf-repeater').change(function(){
      var repeaterRows = jQuery('.acf-repeater .acf-row').not('.acf-clone').length + 1;
      jQuery('.event-total-attendees').replaceWith('<div class="event-total-attendees">Number of attendees: <span>' + repeaterRows + '</span></div>');
      jQuery('#total_number_attendees').val(repeaterRows);
      jQuery('.event-total-price').replaceWith('<div class="event-total-price">Total price: <span>£' + (repeaterRows * <?php echo $product->get_price(); ?> + '</span></div>'));
    });
    jQuery('.acf-repeater').change();
  </script>
<?php endif; ?>
