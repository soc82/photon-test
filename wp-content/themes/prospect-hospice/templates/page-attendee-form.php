<?php
/*
* Template Name: Event Attendee Form Template
*/
acf_form_head();
get_header(); ?>

<div class="block">
  <div class="container">
    <div class="row">
      <div class="col-12 col-md-10 offset-md-1">
        <?php the_content(); ?>
        <?php prospect_get_attendee_form(); ?>
      </div>
    </div>
  </div>
</div>
<?php acf_enqueue_uploader(); ?>
<?php get_footer(); ?>

<?php
if(false):
  $product = wc_get_product($_GET['event']); ?>
  <script>
    jQuery('.acf-repeater').change(function(){
      var repeaterRows = jQuery('.acf-repeater .acf-row').not('.acf-clone').length + 1;
      jQuery('.event-total-attendees').text('Number of attendees: ' + repeaterRows);
      jQuery('#total_number_attendees').val(repeaterRows);
      jQuery('.event-total-price').text('Total price: ' + (repeaterRows * <?php echo $product->get_price(); ?>));
    });
    jQuery('.acf-repeater').change();
  </script>
<?php endif; ?>
