<?php
/*
Template Name: Home page
*/
get_header(); ?>

<?php
$homepage_blocks = get_field('homepage_blocks');
if($homepage_blocks):
  $num_blocks = count($homepage_blocks);
  $i = 0;
  echo '<div class="homepage-blocks">';
    foreach($homepage_blocks as $block): ?>

        <a class="homepage-item <?php if($num_blocks == 3 && $i == 2) echo 'full-width-item'; ?>"
          <?php if($block['page_link']) echo 'href="' . get_permalink($block['page_link']) . '"'; ?>
          >
          <?php if($block['background_image']) echo '<div class="image-background" style="background:url(' . $block['background_image']['sizes']['large']  . ')"></div>'; ?>
          <?php if($block['heading']) echo '<h2>' . $block['heading'] . '</h2>'; ?>
          <?php if($block['page_link']) echo '<span class="circle-arrow"><i class="far fa-long-arrow-right"></i></span>'; ?>
        </a>

    <?php
    $i++;
  endforeach;
  echo '</div>';
endif;
?>

<?php get_footer(); ?>
