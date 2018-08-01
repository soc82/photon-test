<?php get_header(); ?>

<div class='container pad-top-50'>
  <h1 class='no-margin'>FAQs</h1>
</div>
<?php

?>
<div class='container'>
  <?php include(locate_template('/templates/partials/projects-search.php')); ?>
</div>

<div class="container pad-top-10 pad-bottom-50 overflow">
  <div class='row'>
    <div class='flex flex-wrap'>

      <?php $all_terms = get_terms('sectors');?>

      <?php foreach($all_terms as $terms):?>
        <?php   while ( have_posts() ) : the_post();?>
          <?php $post_terms_ids = wp_get_object_terms( $post->ID, 'sectors', array( 'fields' => 'ids' ) );;?>


          <?php if (in_array($terms->term_id, $post_terms_ids)):?>
            <?php //debug($post_terms_ids); ?>
            <?php
            $images = get_image_range($post->ID);

            ?>
            <a href='<?php the_permalink(); ?>' class='project-archive-boxes col-xs-12 col-sm-6 col-md-4 pad-bottom-30 flex flex-column'>
              <div class='flex flex-column flex-fill'>

                <div class='image-wrapper relative'>
                  <div class="overlay-block cover z-index-2"><p class='no-margin'>View</p></div>
                  <span class='cover' style='background: url(<?php echo $images["small"]; ?>) no-repeat center center / cover'></span>
                </div>
                <div class='green-bg  white-text  uppercase flex flex-column flex-fill align-items flex-center'>
                  <h2 class=' no-margin'><?php the_title(); ?></h2>
                </div>

              </div>
            </a>
          <?php endif; ?>


        <?php endwhile;  ?>
      <?php endforeach; ?>

      <?php
      // Start the loop.
      while ( have_posts() ) : the_post();?>
      <?php $post_terms_ids = wp_get_object_terms( $post->ID, 'sectors', array( 'fields' => 'ids' ) );?>
      <?php if(empty($post_terms_ids)):?>
        <?php
        $images = get_image_range($post->ID);

        ?>
        <a href='<?php the_permalink(); ?>' class='project-archive-boxes col-xs-12 col-sm-6 col-md-4 pad-bottom-30 flex flex-column'>
          <div class='flex flex-column flex-fill'>

            <div class='image-wrapper relative'>
              <div class="overlay-block cover z-index-2"><p class='no-margin'>View</p></div>
              <span class='cover' style='background: url(<?php echo $images["small"]; ?>) no-repeat center center / cover'></span>
            </div>
            <div class='green-bg  white-text  uppercase flex flex-column flex-fill align-items flex-center'>
              <h2 class=' no-margin'><?php the_title(); ?></h2>
            </div>

          </div>
        </a>
      <?php endif; ?>


      <?php
      // If comments are open or we have at least one comment, load up the comment template.
      if ( comments_open() || get_comments_number() ) {
        comments_template();
      }

      // End of the loop.
    endwhile;
    ?>
  </div>
</div>
</div>

<?php get_footer(); ?>
