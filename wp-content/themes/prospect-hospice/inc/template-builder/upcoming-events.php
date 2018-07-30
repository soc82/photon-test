<?php

$title = get_sub_field('title');
$text = get_sub_field('text');


$events_args = array(
	'post_type' => 'product',
	'posts_per_page'  => -1,
	'tax_query' => array(
      	array(
          	'taxonomy' => 'product_type',
          	'field'    => 'slug',
          	'terms'    => 'prospect_event',
      	),
  	),
);
$result = new WP_Query($events_args);
?>



<div class="upcoming-events-content-block block">
	<div class="container">
		<div class="row">
			<div class="col-12 intro">
				<?php if ($title) : ?>
					<h2><?php echo $title; ?></h2>
				<?php endif; ?>
				<?php if ($text) : ?>
					<p><?php echo $text; ?></p>
				<?php endif; ?>
			</div>
		</div>
		<div class="row upcoming-events">
			<?php foreach ($result->posts as $post) : ?>
				<?php
				$link = $post->guid;
				$title = $post->post_title;

				$start = new DateTime(get_post_meta($post->ID, 'event_start_date', true) . ' ' . get_post_meta($post->ID, 'start_time', true));
         		$end = new DateTime(get_post_meta($post->ID, 'event_end_date', true) . ' ' . get_post_meta($post->ID, 'end_time', true));
				?>
				<div class="col-12 upcoming-event">
					<div class="row">
						<div class="col-2">

						</div>
						<div class="col-8">
							<span class="start_date"><?php echo $start->format('d-m-Y'); ?></span>
							<h3><?php echo $title; ?></h3>
						</div>
						<div class="col-2">
							<a class="btn btn-yellow" href="<?php echo $link; ?>">Register</a>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>	
	</div>
</div>