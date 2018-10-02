<?php

$title = get_sub_field('title');
$docs = get_sub_field('documents', false);
$document_args = array(
	'post_type' => 'downloads',
	'posts_per_page'  => -1,
	'post__in'	=> 	$docs,
);
$result = new WP_Query($document_args);
if($result->have_posts()): ?>

	<div class="documents-content-block block">
		<div class="container">
			<div class="row">
				<div class="col-12 col-md-10 offset-md-1 intro">
					<?php if ($title) : ?>
						<h2 class="section-heading"><?php echo $title; ?></h2>
					<?php endif; ?>
				</div>
			</div>
			<?php while($result->have_posts()): $result->the_post(); ?>
				<div class="document-item">
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
				</div>
			<?php endwhile;
			wp_reset_postdata(); ?>
		</div>
	</div>
<?php endif; ?>
