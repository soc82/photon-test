


<?php
/**
 * Template Name: Downloads Template
**/


get_header(); ?>

<div class="documents-wrapper">
	<div class="container">

		<div class="row">
			<div class="col-12">
				<form method="get" class="document-filter">
					<label for="document-search">Search:</label>
					<input value="<?php echo (isset($_GET['downloads_search']) ? $_GET['downloads_search'] : '') ?>" class="autosubmit-field" id="document-search" type="text" name="downloads_search">
						<?php
						$departments = get_terms(array(
						    'taxonomy' => 'department',
						    'hide_empty' => true,
						));
						if($departments):
							echo '<select class="autosubmit-field" name="department">';
								echo '<option value="all">All</option>';
									foreach($departments as $department) : ?>
										<option
											value="<?php echo $department->slug; ?>"
											<?php if (isset($_GET['department']) && $_GET['department'] == $department->slug) { echo ' selected '; } ?>
											>
											<?php echo $department->name; ?>
										</option>
							<?php endforeach;
						echo '</select>';
					endif; ?>
				</form>
			</div>
		</div>
		<?php
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
		else:
			// get all posts here
		endif;
		?>

	</div>
</div>

<?php get_footer(); ?>
