<?php
/**
 * Template Name: Vacant Positions Template
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

$items = new WP_Query($query_args);

$terms = get_terms(array(
	'taxonomy' => 'jobtype',
	'hide_empty' => true,
));

get_header(); ?>

<?php get_template_part('inc/template-builder/hero-banner'); ?>

<div class="container">
	<div class="row intro">
		<h2><?php echo get_field('intro_heading'); ?></h2>
		<p><?php echo get_field('intro_text'); ?></p>
	</div>
	<?php if ( $items->posts ) : ?>
		<div class="row filters">
			<div class="col-12">
				<form method="get">
					<select class="autosubmit-field" name="type">
						<option value="all">All</option>
						<?php foreach($terms as $term) : ?>
							<option 
								value="<?php echo $term->slug; ?>"
								<?php if (isset($_GET['type']) && $_GET['type'] == $term->slug) { echo ' selected '; } ?>
								>
								<?php echo $term->name; ?>	
							</option>
						<?php endforeach; ?>
					</select>
				</form>
			</div>
		</div>
		<div class="row jobs-list">
			<?php foreach ($items->posts as $item) : ?>
				<div class="col-xs-12 col-sm-6 col-md-4">
					<div class="item">
						<h5><?php echo $item->post_title;?></h5>
						<div class="reference">Ref: <?php echo get_field('reference', $item->ID); ?></div>
						<div class="introduction"><small><?php echo get_field('introduction_content', $item->ID);?></small></div>
						<div class="row">
							<div class="col-6">
								<span>Salary</span>
								<div class="salary"><?php echo get_field('salary', $item->ID);?></div>
							</div>
							<div class="col-6">
								<span>Closing date</span>
								<div class="closing-date"><?php echo get_field('closing_date', $item->ID); ?></div>
							</div>
						</div>
						<div class="row actions">
							<a href="<?php the_permalink($item);?>" class="btn">Apply</a>
						</div>
					</div>
				</div>
			<?php endforeach;?>
		</div>
	<?php endif; ?>

	<?php
	$benefits_header = get_field('benefits_section_heading');
	$benefits_items = get_field('benefits_section_items');
	?>

	<?php if ($benefits_header && $benefits_items) : ?>
		<div class="row benefits">
			<div class="col-12">
				<h3><?php echo $benefits_header; ?>
			</div>
			<?php foreach ($benefits_items as $item) : ?>
				<div class="col-md-4 col-12 benefits-item">
					<span><?php echo $item['icon']; ?> <?php echo $item['text']; ?></span>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>

<?php get_footer(); ?>