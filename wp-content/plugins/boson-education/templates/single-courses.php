<?php

$sub_text = get_field('course_sub_text');
$related_courses = get_field('related_courses');
$dates = get_field('dates');
$date_string = "";
if ($dates) {
	foreach ($dates as $date) {
		$date_string .= $date['date'] . ", ";
	}
	$date_string = substr($date_string, 0, -2);
}
$start_time = get_field('start_time');
$end_time = get_field('end_time');
$venue = get_field('venue');
$cost = get_field('cost');

get_header(); ?>

<div class="container">
	<div class="row">
		<div class="col-12">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="page-header">
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
					<?php if ($sub_text) : ?>
						<h2><?php echo $sub_text; ?></h2>
					<?php endif; ?>
					<ul class="course-details">
						<?php if ($dates) : ?>
							<li>Date(s): <?php echo $date_string; ?></li>
						<?php endif; ?>
						<?php if ($start_time && $end_time) : ?>
							<li>Time: <?php echo $start_time . ' - ' . $end_time; ?></li>
						<?php endif; ?>
						<?php if ($venue) : ?>
							<li>Venue: <?php echo $venue; ?></li>
						<?php endif; ?>
						<?php if ($cost) : ?>
							<li>Cost: <?php echo $cost; ?></li>
						<?php endif; ?>
					</ul>
				</div>
				
				<div class="entry-content">
					<?php the_content();?>
				</div>

				<div class="course-cta">
					<div class="row">
						<div class="col-12">
							<a hef="#" class="btn">Book or enquire</a>
						</div>
					</div>
				</div>

				<?php if ($related_courses) : ?>
					<div class="related-courses">
						<h3>Related courses</h3>
						<div class="row">
						<?php foreach ($related_courses as $related_course) : ?>
							<div class="col-md-4 col-12">
								<a href="<?php echo get_permalink($related_course->ID); ?>">
									<h4><?php echo $related_course->post_title; ?></h4>
								</a>
							</div>
						<?php endforeach; ?>
						</div>
					</div>
				<?php endif; ?>

			</article>
		</div>
	</div>
</div>

<?php get_footer(); ?>
