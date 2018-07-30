<?php

$reference = get_field('reference');
$introduction_content = get_field('introduction_content');
$salary = get_field('salary');
$closing_date = get_field('closing_date');

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
