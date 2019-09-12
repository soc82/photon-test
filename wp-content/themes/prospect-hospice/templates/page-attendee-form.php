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

<script>
// Remove the 'Are you parent guardian' field and set to yes by default
jQuery(document).ready(function($) {
    $('.acf-field[data-name="are_you_the_parent_or_guardian_of_this_child"]').find('select').val('Yes').trigger('change');
    $('.acf-field[data-name="are_you_the_parent_or_guardian_of_this_child"]').hide();
});
</script>
