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

<div class="inner-page-wrapper">
	<div class="container">
		<div class="row">
			<div class="col-12 col-lg-8">
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="page-header">
						<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
						
					</div>
					<div class="job-spec bg-yellow d-lg-none">
						<?php if ($reference) : ?>
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
											<a class="btn" href="/job-application-form?job_id=<?php echo the_ID(); ?>"><?php echo get_field('apply_button_text', 'option'); ?> <i class="fa fa-angle-right"></i></a>
										
										<?php else : // else, explain they need to register / login ?>
											
											<?php $intro_text = get_field('registration_sign_in_intro_text', 'option');
											if($intro_text) echo '<div class="register">' . $intro_text .'</div>';?>
											
											<a class="btn" href="/my-account?job_id=<?php echo $job_id; ?>"><?php echo get_field('login_register_button_text', 'option'); ?> <i class="fa fa-angle-right"></i></a>
										<?php endif; ?>
									<?php else : // else, tell user they have already applied  ?>
										<?php echo get_field('position_already_applied_for_text', 'option'); ?>
									<?php endif; ?>
								</div>
							</div>

						<?php endif;?>

					</div>
					<div class="entry-content">
						<?php the_content();?>
					</div>

					<div class="section apply-job">
						<a href="/recruitment/" class="btn btn-light-grey"><i class="fa fa-angle-left"></i> Back to vacancies</a>
						<?php if (!$applied) : // If Applied ?>

							<?php if (is_user_logged_in()) : // If user logged in, apply ?>
								<a class="btn" href="/job-application-form?job_id=<?php echo the_ID(); ?>"><?php echo get_field('apply_button_text', 'option'); ?> <i class="fa fa-angle-right"></i></a>
							
							<?php else : // else, explain they need to register / login ?>
								<a class="btn" href="/my-account?job_id=<?php echo $job_id; ?>"><?php echo get_field('login_register_button_text', 'option'); ?> to apply <i class="fa fa-angle-right"></i></a>
							<?php endif; ?>

						<?php else : // else, tell user they have already applied  ?>
							<?php echo get_field('position_already_applied_for_text', 'option'); ?>
						<?php endif; ?>
					</div>

				</article>
			</div>

			<div class="d-none d-lg-block col-lg-4">
				<div class="job-spec bg-yellow">
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
								<a class="btn" href="/job-application-form?job_id=<?php echo the_ID(); ?>"><?php echo get_field('apply_button_text', 'option'); ?> <i class="fa fa-angle-right"></i></a>
							
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
	</div>
</div>

<?php get_footer(); ?>
