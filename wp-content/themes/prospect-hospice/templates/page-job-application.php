<?php
/**
 * Template Name: Job Application Template
**/
$job_id = ($_GET['job_id'] ? $_GET['job_id'] : false);
if ($job_id) {
	$job = get_post($job_id);

	$reference = get_field('reference', $job_id);
	$introduction_content = get_field('introduction_content', $job_id);
	$salary = get_field('salary', $job_id);
	$closing_date = get_field('closing_date', $job_id);
}

$user = wp_get_current_user();
$users_applications = get_field('applications', 'user_' . $user->ID);
$applied = false;

// Double check to make sure the user hasn't applied twice
if ($users_applications) {
	foreach ($users_applications as $application) {
	    if ($job_id == $application['job_id']) {
	        $applied = true;
	        break;
	    }
	}
}

get_header(); ?>


<div class="inner-page-wrapper">
	<div class="container">
		<div class="row">

			<div class="col-12 col-lg-8">
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="page-header">
						<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
						<h2 class="title-block bg-yellow"><?php echo $job->post_title;?></h2>
					</div>
					<div class="entry-content">
						<div class="job-application wizard">
							<?php if (!$applied) : // If not Applied ?>

								<?php gravity_form(2); ?>

							<?php else : // else, tell user they have already applied  ?>
								<?php echo get_field('position_already_applied_for_text', 'option'); ?>
								<br clear="all" /><br /><a href="/recruitment/" class="btn btn-light-grey"><i class="fa fa-angle-left"></i> Back to vacancies</a>
							<?php endif; ?>
		
						</div>
					</div>
				</article>
			</div>

			<div class="d-none d-lg-block col-lg-4">
				<div class="job-spec bg-yellow">
					<h3>Join us</h3>
					<?php if ($reference) : ?>
						<div>Position:<br />
						<?php echo $job->post_title;?></div>
						<div>Reference:<br /><?php echo $reference; ?></div>
						<?php endif; ?>
						<?php if ($salary) : ?>
						<div>Salary:<br /><?php echo $salary; ?></div>
						<?php endif; ?>
						<?php if ($closing_date) : ?>
						<div>Closing Date:<br /><?php echo $closing_date; ?></div>
					<?php endif; ?>
				</div>
			</div>

		</div>
	</div>
</div>

<?php get_footer(); ?>