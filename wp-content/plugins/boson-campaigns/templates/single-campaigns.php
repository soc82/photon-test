<?php get_header(); ?>

<div class="container">
	<div class="row">
		<div class="col-12">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="page-header">
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
				</div>
				
				<div class="entry-content">
					<?php the_content();?>
					<a href="../" class="btn"><i class="fal fa-arrow-left"></i> Back to Campaigns</a>
				</div>

			</article>
		</div>
	</div>
</div>

<?php get_template_part('inc/template-builder/call-to-action-block');?>

<?php get_footer(); ?>
