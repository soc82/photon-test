<?php get_header(); ?>

<div class="inner-page-wrapper">
    <div class="container">
        <div class="row">

			<?php
			// Start the loop.
			while ( have_posts() ) : the_post();

				// Include the single post content template.
				get_template_part( 'template-parts/content', 'single' );

				/* 
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}
				*/

			// End of the loop.
			endwhile;?>

		</div>
	</div>
</div>

<div class="section">

	<!-- Get previous news -->
	<?php $query_args = array(
	    'post_type' => 'post',
	    'posts_per_page'  => -1,
	    'order' => 'DESC',
	    'orderby' => 'date',
	    'posts_per_page' => 3,
	    'date_query' => array(
	        array(
	            'before' => $post->post_date,  // Get posts after the current post, use current post post_date
	            'inclusive' => false, // Don't include the current post in the query
	        )
	    ),
	);

	// If category is passed, add to query
	if(!empty($_GET['category'])) :
	    $query_args['tax_query'] = [[
	        'taxonomy' => 'category',
	        'field'    => 'slug',
	        'terms'    => $_GET['category'],
	    ]];
	endif;
	$items = new WP_Query($query_args);
	if ( $items->posts ) : ?>

		<div class="container">
		    <div class="row">
		    	<div class="col-12">
		    		<h2 class="text-center">Recent articles which may interest you ...</h2>
		    	</div>
		    </div>
		</div>

	    <div class="grid-overlap">
	        <div class="row no-gutters">

	            <?php // Start the loop.
	            while ( $items->have_posts()) : $items->the_post();
	                get_template_part( 'template-parts/content', 'posts' );
	            // End the loop.
	            endwhile; ?>
	        </div>
	    </div>
	<?php endif;?>
</div>

<?php get_footer(); ?>