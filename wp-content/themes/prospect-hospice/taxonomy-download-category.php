<?php
$query_args = array(
	'post_type' => 'downloads',
	'posts_per_page'  => -1,
	'order' => 'DESC',
	'orderby' => 'name',
);

if (isset($_GET['downloads_search']) && $_GET['downloads_search']) {
	$query_args['s'] = $_GET['downloads_search'];
}
if (isset($_GET['department']) && $_GET['department'] && $_GET['department'] != 'all') {
	$query_args['tax_query'] = [
		[
          	'taxonomy' => 'department',
          	'field'    => 'slug',
          	'terms'    => $_GET['department'],
      	]
	];
}
$items = new WP_Query($query_args);
$terms = prospect_get_downloads_filters();

get_header(); ?>


<div class="container">

	<div class="row filters">
		<div class="col-12">
			<form method="get">
				Search:
				<input value="<?php echo (isset($_GET['downloads_search']) ? $_GET['downloads_search'] : '') ?>" class="autosubmit-field" type="text" name="downloads_search">
				<select class="autosubmit-field" name="department">
					<option value="all">All</option>
					<?php foreach($terms as $term) : ?>
						<option
							value="<?php echo $term->slug; ?>"
							<?php if (isset($_GET['department']) && $_GET['department'] == $term->slug) { echo ' selected '; } ?>
							>
							<?php echo $term->name; ?>
						</option>
					<?php endforeach; ?>
				</select>
			</form>
		</div>
	</div>

	<?php if ( $items->posts ) : ?>
		<div class="row downloads-list">
			<?php foreach ($items->posts as $item) : ?>
				<?php
				$file_name = get_the_title($item->ID);
				$file = get_field('file', $item->ID);
				$file_description = get_field('file_description', $item->ID);
				?>
				<div class="col-xs-12 col-sm-6 col-md-4">
					<div class="item">
						<a href="<?php echo $file;?>"><h5><?php echo $file_name;?></h5></a>
						<?php echo $file_description; ?>
						<div class="row actions">
							<a href="<?php echo $file;?>" class="btn">Download</a>
						</div>
					</div>
				</div>
			<?php endforeach;?>
		</div>
	<?php endif; ?>

	<?php get_template_part('template-parts/benefits-section'); ?>

</div>

<?php get_footer(); ?>
