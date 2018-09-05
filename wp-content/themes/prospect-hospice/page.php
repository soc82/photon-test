<?php get_header(); ?>

<div class="inner-page-wrapper">

	<?php get_template_part('inc/flexible-content'); ?>

	<div class="container">
		<div class="row">
			<div class="col-12">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php echo the_content();?>
				<?php endwhile; ?>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>
