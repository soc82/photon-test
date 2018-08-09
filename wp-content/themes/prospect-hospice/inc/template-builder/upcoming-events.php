<?php

$title = get_sub_field('title');
$text = get_sub_field('text');


$events_args = array(
	'post_type' => 'product',
	'posts_per_page'  => 3,
	'meta_key'	=> 'event_start_date',
	'orderby'  => 'meta_value',
	'order'  => 'ASC',
	'tax_query' => array(
      	array(
          	'taxonomy' => 'product_type',
          	'field'    => 'slug',
          	'terms'    => 'prospect_event',
      	),
  	),
);
$result = new WP_Query($events_args);
if($result->have_posts()): ?>

	<div class="upcoming-events-content-block block">
		<div class="container">
			<div class="row">
				<div class="col-12 col-md-10 offset-md-1 intro">
					<?php if ($title) : ?>
						<h2 class="section-heading"><?php echo $title; ?></h2>
					<?php endif; ?>
					<?php if ($text) : ?>
						<p><?php echo $text; ?></p>
					<?php endif; ?>
				</div>
			</div>
			<?php while($result->have_posts()): $result->the_post(); ?>
				<?php
				$icon = get_field('event_icon', $post->ID);
				$start = new DateTime(get_post_meta($post->ID, 'event_start_date', true) . ' ' . get_post_meta($post->ID, 'start_time', true));
	   		$end = new DateTime(get_post_meta($post->ID, 'event_end_date', true) . ' ' . get_post_meta($post->ID, 'end_time', true));
				?>
				<div class="upcoming-event">
					<div class="col-12 col-md-10 offset-md-1">
						<div class="row">
							<div class="d-none d-md-block col-md-1">
								<?php if($icon) echo '<div class="event-icon">' . $icon . '</div>'; ?>
							</div>
							<div class="col-12 col-md-7 col-lg-8">
								<span class="start-date"><?php echo $start->format('d/m/Y'); ?></span>
								<h3><?php echo  $post->post_title; ?></h3>
							</div>
							<div class="col-12 col-md-4 col-lg-3">
								<a class="btn btn-arrow-right" href="<?php echo get_permalink($post); ?>">Register</a>
							</div>
						</div>
					</div>
				</div>
			<?php endwhile;
			wp_reset_postdata(); ?>
		</div>
	</div>
<?php endif; ?>
