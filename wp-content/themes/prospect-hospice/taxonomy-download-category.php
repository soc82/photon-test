<?php get_header(); ?>


<div class="documents-wrapper ">
	<div class="container">

		<div class="row">
			<div class="col-12">
				<?php $queried_object = get_queried_object();
					echo '<h1 class="entry-title">' . $queried_object->name . '</h1>'; ?>
				<?php echo get_template_part('inc/document-search'); ?>
			</div>

			<?php
			$document_args = array(
				'post_type' => 'downloads',
				'posts_per_page'  => 10,
				'order' => 'DESC',
				'orderby' => 'name',
				'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
				'tax_query'	=> array(
					array(
						'taxonomy'	=> 'download-category',
						'terms'	=> array($queried_object->term_id),
						'field'	=> 'term_id',
					)
				)
			);
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
			?>
		</div>
	</div>
</div>

<?php get_footer(); ?>
