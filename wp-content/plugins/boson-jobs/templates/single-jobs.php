<?php

$reference = get_field('reference');
$introduction_content = get_field('introduction_content');
$salary = get_field('salary');
$closing_date = get_field('closing_date');

$user = wp_get_current_user();
$users_applications = get_field('applications', 'user_' . $user->ID);

$applied = false;
$job_id = get_the_ID();

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

<div class="container">
	<div class="row">
		<div class="col-12">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="page-header">
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
				</div>
				<div class="job-spec">
					<?php if ($reference) : ?>
					<div>Reference: <?php echo $reference; ?></div>
					<?php endif; ?>
					<?php if ($salary) : ?>
					<div>Salary: <?php echo $salary; ?></div>
					<?php endif; ?>
					<?php if ($closing_date) : ?>
					<div>Closing Date: <?php echo $closing_date; ?></div>
					<?php endif; ?>
				</div>
				<div class="entry-content">
					<?php the_content();?>
				</div>

				<?php if (!$applied) : ?>
					<a class="btn" href="/job-application-form?job_id=<?php echo the_ID(); ?>"><?php echo get_field('apply_button_text', 'option'); ?></a>
				<?php else : ?>
					<?php echo get_field('position_already_applied_for_text', 'option'); ?>
				<?php endif; ?>

			</article>
		</div>
	</div>
</div>

<?php get_footer(); ?>
