<?php

$title = get_sub_field('title');
$text = get_sub_field('text');
$link_text = get_sub_field('link_text');
$link_url = get_sub_field('link_url');
$section = get_sub_field('section');

$args = [
	'numberposts' => 3,
	'offset' => 0,
	'category' => 0,
	'orderby' => 'post_date',
	'order' => 'DESC',
	'include' => '',
	'exclude' => '',
	'meta_key' => '',
	'meta_value' =>'',
	'post_status' => 'publish',
	'suppress_filters' => true
];


if ($section) {
	$args['tax_query'] = [
		[
			'taxonomy' => 'section',
			'field' => 'id',
			'terms' => $section,
			'operator' => 'IN',
		],
	];
}

$args['post_type'] = 'post';

$recent_posts = wp_get_recent_posts( $args, ARRAY_A );

// If we get less than 3 posts, we can query again (without a specific category)
if (count($recent_posts) < 3) {
	unset($args['tax_query']);
	$recent_posts = wp_get_recent_posts( $args, ARRAY_A );
}
?>

<div class="latest-news-content-block block">
	<div class="container">
		<div class="row">
			<div class="col-12 intro">
				<?php if ($title) : ?>
					<h2><?php echo $title; ?></h2>
				<?php endif; ?>
				<?php if ($text) : ?>
					<p><?php echo $text; ?></p>
				<?php endif; ?>
				<?php if ($link_text && $link_url) : ?>
					<a href="<?php echo $link_url; ?>"><?php echo $link_text; ?></a>
				<?php endif; ?>
			</div>
		</div>
		<div class="row">
			<?php foreach ($recent_posts as $post) : ?>
				<div class="col-4 post-image">
					<div class="image">
						<?php the_post_thumbnail($post['ID']); ?>
						<div class="image-overlay">
							<h4><?php echo $post['post_title']; ?></h4>
							<p><?php echo $post['post_excerpt']; ?></p>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>	
	</div>
</div>

