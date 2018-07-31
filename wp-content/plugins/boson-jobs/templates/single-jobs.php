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
foreach ($users_applications as $application) {
    if ($job_id == $application['job_id']) {
        $applied = true;
        break;
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
				<div class="entry-content">
					<?php the_content();?>
				</div>

				<?php if (!$applied) : ?>
					<a class="btn" href="/job-application-form?job_id=<?php echo the_ID(); ?>">Apply</a>
				<?php else : ?>
					You've already applied for this position
				<?php endif; ?>

			</article>
		</div>
	</div>
</div>

<?php get_footer(); ?>
