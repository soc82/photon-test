<?php
/**
 * Template Name: Downloads Template
**/


get_header(); ?>

<div class="documents-wrapper">
	<div class="container">

		<div class="row">
			<div class="col-12">
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
				<?php echo get_template_part('inc/document-search'); ?>
			</div>
		</div>
		<?php
		if(isset($_GET['document-category']) || isset($_GET['document-search'])):

				$document_args = array(
					'post_type' => 'downloads',
					'posts_per_page'  => 10,
					'order' => 'DESC',
					'orderby' => 'name',
					'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
				);
				if (isset($_GET['document-search']) && $_GET['document-search']):
					$document_args['s'] = $_GET['document-search'];
				endif;
				if (isset($_GET['document-category']) && $_GET['document-category'] && $_GET['document-category'] != 'all'):
					$document_args['tax_query'] = [
						[
				          	'taxonomy' => 'download-category',
				          	'field'    => 'slug',
				          	'terms'    => $_GET['document-category'],
				      	]
					];
				endif;
				$documents = new WP_Query($document_args);
				if($documents->have_posts()):
					echo '<div class="document-listing">';
						while($documents->have_posts()): $documents->the_post();
						$file = get_field('file', get_the_ID());
						if($file): ?>
								<div class="col-12 col-md-10 offset-md-1 download-item">
									<div class="row d-block">
										<div class="col-2 col-sm-1 col-md-1 inline-block-replace-middle">
											<div class="download-icon"><i class="far <?php echo prospect_file_type_icon(get_the_ID()); ?>"></i></div>
										</div>
										<div class="col-10 col-sm-11 col-md-7 col-lg-8 inline-block-replace-middle">
											<h3><?php echo $post->post_title; ?></h3>
										</div>
										<div class="col-10 offset-2 col-sm-11 offset-sm-1 col-md-4 offset-md-0  col-lg-3 inline-block-replace-middle">
											<a class="btn btn-arrow-right" href="<?php echo $file['url']; ?>" download target="_blank">Download</a>
										</div>
									</div>
								</div>
				<?php endif;
						endwhile;
			    $total_pages = $documents->max_num_pages;
			    if ($total_pages > 1) : ?>
					<div class="col-12 col-md-10 offset-md-1">
	            <div class="pagination">
	                <?php $current_page = max(1, get_query_var('paged'));
	                echo paginate_links(array(
	                    'base' => get_pagenum_link(1) . '%_%',
	                    'current' => $current_page,
	                    'total' => $total_pages,
	                    'prev_text'    => __('« prev'),
	                    'next_text'    => __('next »'),
	                ));?>
	            </div>
						</div>
			    <?php endif;
					wp_reset_postdata();
				else: ?>
						<div class="col-12">
						<p>No documents found. Please try a different search.</p>
					</div>
			<?php
				echo '</div>';
				endif;

		else:

				$categories = get_terms( array(
				    'taxonomy' => 'download-category',
				    'hide_empty' => true,
				) );
				if($categories):
					echo '<div class="row document-categories text-center">';
						foreach($categories as $category):
							echo '<div class="col-6 col-md-4 col-lg-3 inline-block-replace">';
								echo '<a href="' . get_term_link($category->term_id) . '">';
									echo '<div class="document-icon"><i class="fal fa-folder-open"></i></div>';
									echo '<p>' . $category->name . '</p>';
								echo '</a>';
							echo '</div>';
						endforeach;
					echo '</div>';
				endif;

		endif;
		?>

	</div>
</div>

<?php get_footer(); ?>
