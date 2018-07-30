<?php get_header();
$architect = get_field('architect');
$architect_link = get_field('architect_link');
$client_ = get_field('client_');
$client_link = get_field('client_link');
$photography = get_field('photography');
$photography_link = get_field('photography_link');
$youtube_video = get_field('youtube_video');
?>
<?php include(locate_template('/templates/partials/project-slider.php')); ?>

<div class="container pad-bottom-50 single-project pad-top-50">
  <h1 class='no-margin pad-bottom-30'><?php the_title(); ?></h1>
  <?php
  // Start the loop.
  while ( have_posts() ) : the_post();?>
  <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="entry-content ">
      <div class='pad-bottom-40'>
        <?php the_content();?>


        <?php if($youtube_video):?>
          <div class="embed-container">
            <?php the_field('youtube_video'); ?>
          </div>
          <span class='pad-bottom-30 block clear'></span>
        <?php endif; ?>

        <?php if($architect || $client_ || $photography):?>
          <div class='font-italic flex align-items flex-row-m flex-column flex-wrap '>
            <span class='none block-m'>(</span>
            <span class='pad-left-5 none block-m'></span>
            <?php if($architect):?>
              <span>Architect: <a target='_blank' href='<?php echo $architect_link; ?>'><?php echo $architect; ?></a> </span>
            <?php endif;?>
            <?php if($client_):?>
              <span class='pad-left-10 none block-m'></span>
              <span>Client: <a target='_blank' href='<?php echo $client_link; ?>'><?php echo $client_; ?></a> </span>
            <?php endif;?>
            <?php if($photography):?>
              <span class='pad-left-10 none block-m'></span>
              <span>Photography: <a target='_blank' href='<?php echo $photography_link; ?>'><?php echo $photography; ?></a> </span>
            <?php endif;?>
            <span class='pad-left-5 none block-m'></span>
            <span class='none block-m'>)</span>
          </div>
        <?php endif; ?>

      </div>
      <div class='share-icons'>
        <?php echo do_shortcode('[addtoany]'); ?>
      </div>
      <span class='pad-bottom-30 block clear'></span>
      <a href='/projects' class='blue-button block inline-block-m'><i class="far fa-arrow-left pad-right-40 "></i>Back to projects</a>

    </div>
  </article>

  <?php
  // If comments are open or we have at least one comment, load up the comment template.
  if ( comments_open() || get_comments_number() ) {
    comments_template();
  }

  // End of the loop.
endwhile;
?>

</div>

<?php get_footer(); ?>
