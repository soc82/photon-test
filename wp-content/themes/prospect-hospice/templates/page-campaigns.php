<?php
/**
 * Template Name: Campaigns Template
**/

$query_args = array(
	'post_type' => 'campaigns',
	'posts_per_page'  => -1,
	'order' => 'DESC',
	'orderby' => 'date',
);

$items = new WP_Query($query_args);

get_header(); ?>

<div class="container">
	<div class="row">
		<div class="col-12">
			<div class="page-header">
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<div class="entry-content">
				<?php the_content();?>
			</div>
		</div>
	</div>

	<?php if ( $items->posts ) : ?>
		<div class="row campaigns-list no-gutters">
			<?php foreach ($items->posts as $item) : ?>
				<?php
				$image = get_the_post_thumbnail_url($item);
				?>
				<div class="col-xs-12 col-sm-6 col-md-3">
					<div class="item" style="background-image: url(<?php echo $image; ?>)" >
						<a href="<?php the_permalink($item);?>"><h5><?php echo $item->post_title;?></h5></a>
					</div>
				</div>
			<?php endforeach;?>
		</div>
	<?php endif; ?>
</div>

<?php get_footer(); ?>