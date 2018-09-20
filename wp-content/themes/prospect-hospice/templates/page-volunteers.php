<?php
/**
 * Template Name: Voluntary Positions Template
**/

$query_args = array(
	'post_type' => 'jobs',
	'posts_per_page'  => -1,
	'order' => 'DESC',
	'orderby' => 'date',
);
// Use a tax_query if the user has specified a jobtype
if (isset($_GET['type']) && $_GET['type'] && $_GET['type'] != 'all') {
	$query_by = $_GET['type'];

	$query_args['tax_query'] = [
		[
          	'taxonomy' => 'jobtype',
          	'field'    => 'slug',
          	'terms'    => $query_by,
      	],

	];
}

$query_args['tax_query'][] = [
      		'taxonomy' => 'jobsection',
          	'field'    => 'slug',
          	'terms'    => 'volunteer',
      	];

$items = new WP_Query($query_args);

$terms = prospect_get_jobs_filters('volunteer');

get_header(); ?>

<?php get_template_part('inc/template-builder/hero-banner'); ?>

<div class="container">
	<div class="row">
		<div class="col-12">
			<h2><?php echo get_field('intro_heading'); ?></h2>
			<p><?php echo get_field('intro_text'); ?></p>
		</div>
	</div>

	<div class="row filter">
		<div class="col-12">
			<form method="get">
				<div class="dropdown">
					<select class="autosubmit-field" name="type">
						<option value="all">Filter by Type ...</option>
						<?php foreach($terms as $term) : ?>
							<option
								value="<?php echo $term->slug; ?>"
								<?php if (isset($_GET['type']) && $_GET['type'] == $term->slug) { echo ' selected '; } ?>
								>
								<?php echo $term->name; ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
			</form>
		</div>
	</div>

	<?php if ( $items->posts ) : ?>
		<div class="row jobs-list section">
			<?php foreach ($items->posts as $item) : ?>
				<div class="col-12 col-md-6 col-lg-4">
					<div class="item bg-very-light-grey">
						<a href="<?php the_permalink($item);?>"><h3 class="color-grey"><?php echo $item->post_title;?></h3></a>
						<div class="voluntry title-block bg-yellow"><i class="fal fa-heart"></i> Voluntary</div>
						<div class="reference">Ref: <?php echo get_field('reference', $item->ID); ?></div>
						<?php if(get_field('location', $item->ID)) : ?>
							<div class="location"><span>Location:</span><?php echo get_field('location', $item->ID); ?></div>
						<?php endif;?>
						<div class="closing-date"><span>Closing date:</span> <?php echo get_field('closing_date', $item->ID); ?></div>
						<div class="introduction"><small><?php echo get_field('introduction_content', $item->ID);?></small></div>
						<div class="row actions">
							<a href="<?php the_permalink($item);?>" class="btn btn-green"><?php echo get_field('view_job_button_text', 'option'); ?></a>
						</div>
					</div>
				</div>
			<?php endforeach;?>
		</div>
	<?php endif; ?>

</div>

<?php get_template_part('template-parts/benefits-section'); ?>

<?php get_template_part('inc/flexible-content'); ?>

<?php get_footer(); ?>
