<?php

$sub_text = get_field('course_sub_text');


get_header(); ?>

<div class="container">
	<div class="row">
		<div class="col-12">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="page-header">
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
					
				</div>
				
				<div class="entry-content">
					<?php the_content();?>
				</div>

			</article>
		</div>
	</div>
</div>

<?php get_footer(); ?>
