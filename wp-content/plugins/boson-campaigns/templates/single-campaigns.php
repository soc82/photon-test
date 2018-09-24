<?php get_header(); ?>

<div class="inner-page-wrapper">
	<div class="container">
		<div class="row">
			<div class="col-12 col-lg-7">
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

			<div class="col-12 offset-lg-1 col-lg-4">
				<div class="sidebar-sub-menu bg-yellow">
					<div class="sidebar-inner">
							<h3>Campaigns</h3>
							<?php $campaign_args = array(
									'post_type'	=> 'campaigns',
									'orderby'	=> 'date',
									'order'	=> 'ASC',
									'post__not_in'	=> array(get_the_ID()),
							);
							$campaign_query = new WP_Query($campaign_args);
							if($campaign_query->have_posts()):
								echo '<ul>';
								while($campaign_query->have_posts()): $campaign_query->the_post();
									echo '<li>' . get_the_title() . '</li>';
								endwhile;
								echo '</ul>';
							endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php get_template_part('inc/template-builder/call-to-action-block');?>

<?php get_footer(); ?>
