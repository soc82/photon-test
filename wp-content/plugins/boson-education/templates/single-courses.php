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
$courses_page = get_field('courses_page', 'options');

get_header(); ?>

<div class="inner-page-wrapper">
	<div class="container">
		<div class="row">
			<div class="col-12 col-lg-7">
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="page-header">
						<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
					</div>

					<div class="entry-content">
						<?php the_content();?>
					</div>

					<div class="course-cta">
						<div class="row">
							<div class="col-12">
								<?php if($courses_page) echo '<a href="' . get_permlaink($courses_page) . '" class="btn btn-light-grey"><i class="fal fa-arrow-left"></i> Back to our courses</a>'; ?>
								<a href="/education/contact-us?course=<?php echo the_title();?>" class="btn">Book or enquire <i class="fal fa-arrow-right"></i></a>
							</div>
						</div>
					</div>
				</article>
			</div>

			<div class="col-12 offset-lg-1 col-lg-4">
				<div class="sidebar-sub-menu bg-yellow">
					<div class="sidebar-inner">
						<?php if ($sub_text) : ?>
							<h3><?php echo $sub_text; ?></h3>
						<?php endif; ?>

						<?php if ($dates) : ?>
							<div class="dates"><strong>Date(s):</strong><br /> <?php echo $date_string; ?></div>
						<?php endif; ?>
						<?php if ($start_time && $end_time) : ?>
							<div class="start"><strong>Time:</strong><br /> <?php echo $start_time . ' - ' . $end_time; ?></div>
						<?php endif; ?>
						<?php if ($venue) : ?>
							<div class="venue"><strong>Venue:</strong><br /> <?php echo $venue; ?></div>
						<?php endif; ?>
						<?php if ($cost) : ?>
							<div class="cost"><strong>Cost:</strong><br /> <?php echo $cost; ?></div>
						<?php endif; ?>
						<a href="/education/contact-us?course=<?php echo the_title();?>" class="btn">Book or enquire <i class="fal fa-arrow-right"></i></a>
					</div>
				</div>
			</div>

		</div>
	</div>

	<?php if ($related_courses) : ?>
		<div class="container ">
			<div class="related-courses">
				<div class="upcoming-events-content-block">
					<div class="row">
						<div class="col-12">
							<h3>Related courses</h3>
						</div>
					</div>

					<?php foreach ($related_courses as $post) : ?>
						<div class="upcoming-event">

							<div class="row">
								<div class="d-none d-md-block col-md-1">
									<div class="event-icon"><i class="fal fa-calendar-alt"></i></div>
								</div>
								<div class="col-12 col-md-7 col-lg-8">
									<!-- <span class="start-date">Start</span> -->
									<h3><?php echo  $post->post_title; ?></h3>
								</div>
								<div class="col-12 col-md-4 col-lg-3">
									<a class="btn btn-arrow-right" href="<?php echo get_permalink($post); ?>">Apply</a>
								</div>
							</div>

						</div>
					<?php endforeach;?>

				</div>
			</div>
		</div>
	<?php endif; ?>

</div>

<?php get_footer(); ?>
