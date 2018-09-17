<?php
/**
 * Template Name: Donate Template
**/

get_header(); ?>
<?php $introduction = get_field('donate_introduction');
if(is_array($introduction) && array_filter($introduction)): ?>
<div class="block donate-page-introduction">
  <div class="container">
    <div class="row">
      <div class="col-12 col-md-10 offset-md-1">
        <?php if($introduction['heading']) echo '<h1 class="section-heading">' . $introduction['heading'] . '</h1>'; ?>
        <?php if($introduction['content']) echo '<div class="donate-intro">' . $introduction['content'] . '</div>'; ?>

      </div>
    </div>
  </div>
</div>
<?php endif; ?>

<?php $donate_options = get_field('donate_options'); ?>
<div class="tile-block block">
	<div class="row no-gutters">
			<div class="col-12 col-sm-6">
				<a class="image-tile single-donation-option" href="#single-donation-form" <?php if($donate_options['single_donation']['background_image']) echo 'style="background-image: url(' . $donate_options['single_donation']['background_image']['sizes']['large'] . ');"'; ?>>
					<div class="overlay">
						<?php if($donate_options['single_donation']['heading']) echo '<h4>' . $donate_options['single_donation']['heading'] . '</h4>'; ?>
            <?php if($donate_options['single_donation']['content']) echo '<p>' . $donate_options['single_donation']['content'] . '</p>'; ?>
						<span class="circle-arrow"><i class="far fa-long-arrow-right"></i></span>
					</div>
				</a>
			</div>
      <div class="col-12 col-sm-6">
				<a class="image-tile single-donation-option" target="_blank" href="<?php echo $donate_options['regular_donations']['button_link']; ?>" <?php if($donate_options['regular_donations']['background_image']) echo 'style="background-image: url(' . $donate_options['regular_donations']['background_image']['sizes']['large'] . ');"'; ?>>
					<div class="overlay">
						<?php if($donate_options['single_donation']['heading']) echo '<h4>' . $donate_options['regular_donations']['heading'] . '</h4>'; ?>
            <?php if($donate_options['single_donation']['content']) echo '<p>' . $donate_options['regular_donations']['content'] . '</p>'; ?>
						<span class="circle-arrow"><i class="far fa-long-arrow-right"></i></span>
					</div>
				</a>
			</div>
	</div>
</div>

<?php if($donate_options['single_donation']['donate_form_id']): ?>
  <div class="block single-donation-form" id="single-donation-form">
    <div class="container">
      <div class="row">
        <div class="col-12 col-md-10 offset-md-1">
          <?php echo do_shortcode('[gravityform id="' . $donate_options['single_donation']['donate_form_id'] . '" ajax="true" title="false" description="false"]'); ?>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>
<?php get_footer(); ?>
