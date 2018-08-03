<?php
/**
 * Template Name: Job Application Template
**/
$job_id = ($_GET['job_id'] ? $_GET['job_id'] : false);
if ($job_id) {
	$job_title = get_the_title($job_id);
}
get_header(); ?>


<div class="container">
	<div class="row downloads-list">
		<div class="col-12">
			<?php if (is_user_logged_in()) : ?>
				<?php gravity_form(2); ?>
			<?php else : ?>
				<h1><?php the_title(); ?></h1>
				<?php
					$intro_text = get_field('registration_sign_in_intro_text', 'option');
				?>
				<h3><?php echo $job_title; ?></h3>
				<p><?php echo $intro_text; ?></p>
				<a class="btn" href="/my-account?job_id=<?php echo $job_id; ?>"><?php echo get_field('login_register_button_text', 'option'); ?></a>
			<?php endif; ?>
		</div>
	</div>
</div>

<?php get_footer(); ?>