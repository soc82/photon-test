<?php
/**
 * Template Name: Basic Content Template
**/

get_header(); ?>

<div class="block">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <?php the_content(); ?>
      </div>
    </div>
  </div>
</div>
<?php get_footer(); ?>
