<?php
/**
 * Template Name: Education Template
**/

$query_args = array(
	'post_type' => 'courses',
	'posts_per_page'  => -1,
	'order' => 'DESC',
	'orderby' => 'date',
);

$items = new WP_Query($query_args);

get_header(); ?>

<div class="container">
	<div class="row intro">
		<div class="col-12">
			<h2><?php echo get_field('intro_heading'); ?></h2>
			<p><?php echo get_field('intro_text'); ?></p>
		</div>
	</div>

	<?php if ( $items->posts ) : ?>
		<div class="row courses-list">
			<?php foreach ($items->posts as $item) : ?>
				<div class="col-xs-12 col-sm-6 col-md-4">
					<div class="item">
						<a href="<?php the_permalink($item);?>"><h5><?php echo $item->post_title;?></h5></a>
						
					</div>
				</div>
			<?php endforeach;?>
		</div>
	<?php endif; ?>
</div>

<?php get_footer(); ?>