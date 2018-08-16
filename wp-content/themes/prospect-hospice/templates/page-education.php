<?php
/**
 * Template Name: Education Template
**/
$s='';
if(isset($_GET['keyword'])) $s = $_GET['keyword'];
$query_args = array( 
	'post_type' => 'courses',
	'posts_per_page'  => -1,
	'order' => 'DESC',
	'orderby' => 'date',
	's' => $s
);

$items = new WP_Query($query_args);

// Sort courses by month-year
$course_dates = array();
if ( $items->posts ) :
	foreach ($items->posts as $post) :
		$recurring_dates = get_field('dates');
		if($recurring_dates) :
			foreach ($recurring_dates as $date) :
				$course_dates[date("Y-m",strtotime($date['date']))][$post->ID] = $post;	
			endforeach;
		endif;
	endforeach;
endif;

// Sort by date
ksort($course_dates);

get_header(); ?>

<div class="inner-page-wrapper">

	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="top-filter-wrapper">

					<?php if (get_field('intro_heading')) : ?>
						<h1 class="entry-title"><?php echo get_field('intro_heading'); ?></h1>
					<?php endif; ?>
					
					<form action="<?php echo get_page_link();?>" method="get" class="top-filter">
						<input type="text" name="keyword" placeholder="Search for a course ..." />
						<input class="btn" type="submit" value="Submit" />
					</form>

					<?php /*<?php if (get_field('intro_text')) : ?>
						<p><?php echo get_field('intro_text'); ?></p>
					<?php endif; ?> */?>

				</div>
			</div>
		</div>

		<div class="upcoming-events-content-block block">
			<div class="upcoming-event">

				<?php if ( $course_dates ) : ?>

					<!-- Course Dates (month-year) -->
					<?php foreach ($course_dates as $month => $courses) : ?>
						<div class="row month">
							<div class="col-12">
								<h3 class="title-block bg-very-light-grey"><?php echo date("F Y",strtotime($month));?></h3>
							</div>
						</div>

						<!-- Courses -->
						<?php foreach($courses as $course) : ?>
							<div class="row">
								<div class="d-none d-md-block col-md-1">
									<div class="event-icon"><i class="fal fa-calendar-alt"></i></div>
								</div>
								<div class="col-12 col-md-7 col-lg-8">
									<!-- <span class="start-date">Start</span> -->
									<h3><?php echo $course->post_title; ?></h3>
								</div>
								<div class="col-12 col-md-4 col-lg-3">
									<a class="btn btn-arrow-right" href="<?php echo get_permalink($course); ?>">Apply</a>
								</div>
							</div>	
						<?php endforeach;
					endforeach;
				else : ?>
					<div class="row">
						<div class="col-12 col-md-10 offset-md-1 intro">
							<h3>Sorry no courses found</h3>
							<p>Please try searching again or <a href="<?php echo get_page_link();?>" title="View all courses">View all courses</a></p>
						</div>
				<?php endif;?>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>