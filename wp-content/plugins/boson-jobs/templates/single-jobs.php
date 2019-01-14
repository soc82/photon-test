<?php

$reference = get_field('reference');
$introduction_content = get_field('introduction_content');
$salary = get_field('salary');
$closing_date = get_field('closing_date');
$vacancies_page = get_field('job_vacancies_page', 'options');
$application_page = get_field('job_application_form_page', 'options');

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

$terms = get_the_terms($post, 'jobsection');

$job_section = $terms[0]->slug;

get_header(); ?>

<div class="inner-page-wrapper">
	<?php if ($job_section !== 'volunteer') : ?><div class="container"><?php endif; ?>
	<div class="row">
		<div class="col-12 <?php if ($job_section !== 'volunteer') : ?>col-lg-9<?php endif; ?>">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="flexible-content">
					<?php get_template_part('inc/flexible-content'); ?>
				</div>
				<?php if ($reference) : ?>
					<div class="job-spec bg-yellow d-lg-none">
						<div class="row">
							<div class="col-12 col-md-6">
								<div>Reference: <?php echo $reference; ?></div>
								<?php endif; ?>
								<?php if ($salary) : ?>
								<div>Salary: <?php echo $salary; ?></div>
								<?php endif; ?>
								<?php if ($closing_date) : ?>
								<div>Closing Date: <?php echo $closing_date; ?></div>
							</div>
							<div class="col-12 col-md-6">
								<?php if (!$applied) : // If not Applied ?>

									<?php if (is_user_logged_in()) : // If user logged in, apply ?>
										<a class="btn" href="<?php echo get_permalink($application_page); ?>?job_id=<?php echo the_ID(); ?>"><?php echo get_field('apply_button_text', 'option'); ?> <i class="fa fa-angle-right"></i></a>

									<?php else : // else, explain they need to register / login ?>

										<?php $intro_text = get_field('registration_sign_in_intro_text', 'option');
										if($intro_text) echo '<div class="register">' . $intro_text .'</div>';?>

										<a class="btn" href="/my-account?job_id=<?php echo $job_id; ?>"><?php echo get_field('login_register_button_text', 'option'); ?> <i class="fa fa-angle-right"></i></a>
									<?php endif; ?>
								<?php else : // else, tell user they have already applied  ?>
									<?php echo '<p>' . get_field('position_already_applied_for_text', 'option') . '</p>'; ?>
								<?php endif; ?>
							</div>
						</div>
					</div>
				<?php endif;?>

				<div class="entry-content">
					<?php the_content();?>
				</div>
				<div class="container">
					<div class="section apply-job">
						<?php if ($job_section !== 'volunteer') : ?>
							<?php if (!$applied) : // If Applied ?>

								<?php if (is_user_logged_in()) : // If user logged in, apply ?>
									<a class="btn" href="<?php echo get_permalink($application_page); ?>?job_id=<?php echo the_ID(); ?>"><?php echo get_field('apply_button_text', 'option'); ?> <i class="fa fa-angle-right"></i></a>

								<?php else : // else, explain they need to register / login ?>
									<a class="btn" href="/my-account?job_id=<?php echo $job_id; ?>"><?php echo get_field('login_register_button_text', 'option'); ?> <i class="fa fa-angle-right"></i></a>
								<?php endif; ?>

							<?php else : // else, tell user they have already applied  ?>
								<?php echo '<p>' . get_field('position_already_applied_for_text', 'option') . '</p>'; ?>
							<?php endif; ?>
						<?php endif; ?>
						<a href="<?php echo get_permalink($vacancies_page); ?>" class="btn btn-light-grey"><i class="fa fa-angle-left"></i> Back to vacancies</a>

					</div>
				</div>

			</article>
		</div>
		<?php // Only show the sidebar for paid positions ?>
		<?php if ($job_section !== 'volunteer') : ?>
		<div class="d-none d-lg-block col-lg-3">
			<div class="sidebar-sub-menu bg-yellow">
				<div class="sidebar-inner">

					<h3>Join us</h3>
					<?php if ($reference) : ?>

						<div>Reference:<br /><?php echo $reference; ?></div>
						<?php endif; ?>
						<?php if ($salary) : ?>
						<div>Salary:<br /><?php echo $salary; ?></div>
						<?php endif; ?>
						<?php if ($closing_date) : ?>
						<div>Closing Date:<br /><?php echo $closing_date; ?></div>

						<?php if (!$applied) : // If Applied ?>

							<?php if (is_user_logged_in()) : // If user logged in, apply ?>
								<a class="btn" href="<?php echo get_permalink($application_page); ?>?job_id=<?php echo the_ID(); ?>"><?php echo get_field('apply_button_text', 'option'); ?> <i class="fa fa-angle-right"></i></a>

							<?php else : // else, explain they need to register / login ?>

								<?php $intro_text = get_field('registration_sign_in_intro_text', 'option');
								if($intro_text) echo '<div class="register">' . $intro_text .'</div>';?>

								<a class="btn" href="/my-account?job_id=<?php echo $job_id; ?>"><?php echo get_field('login_register_button_text', 'option'); ?> <i class="fa fa-angle-right"></i></a>
							<?php endif; ?>

						<?php else : // else, tell user they have already applied  ?>
							<?php echo get_field('position_already_applied_for_text', 'option'); ?>
						<?php endif; ?>

					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php endif; ?>
	</div>
	<?php if ($job_section !== 'volunteer') : ?></div><?php endif; ?>
</div>

<?php get_footer(); ?>
