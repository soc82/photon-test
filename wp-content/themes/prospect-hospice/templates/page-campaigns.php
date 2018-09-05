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

<div class="inner-page-wrapper">
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
	</div>
</div>

<?php if ( $items->posts ) : ?>
	<div class="tile-block block">
		<div class="row no-gutters">
			<?php foreach ($items->posts as $item) : ?>
				<?php
					$image = get_the_post_thumbnail_url($item);
				?>
				<div class="col-12 col-sm-4">
					<a class="image-tile" href="<?php the_permalink($item);?>" style="background-image: url(<?php echo $image; ?>)">
						<div class="overlay">
							<?php if($item->post_title) echo '<h4>' . $item->post_title . '</h4>'; ?>
							<span class="circle-arrow"><i class="far fa-long-arrow-right"></i></span>
						</div>
					</a>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
<?php endif; ?>

<?php get_footer(); ?>