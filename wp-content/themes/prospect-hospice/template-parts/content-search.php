<article id="post-<?php the_ID(); ?>" <?php post_class('search-listing-item'); ?>>
	<div class="search-listing-content">
		<header class="entry-header">
			<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
		</header><!-- .entry-header -->

		<?php the_excerpt(); ?>
	</div>
	<a href="#" class="btn btn-arrow-right">Read more</a>
</article>
