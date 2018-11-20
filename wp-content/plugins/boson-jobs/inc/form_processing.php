<?php

/****************************
Job application form
*****************************/

// Redirect the user back to the form (with job_id) after login/register
add_filter( 'woocommerce_login_redirect', 'prospect_woocommerce_login_reg_redirect', 10, 1 );
add_filter( 'woocommerce_registration_redirect', 'prospect_woocommerce_login_reg_redirect', 10, 1 );

function prospect_woocommerce_login_reg_redirect( $redirect ) {
	if (isset($_GET['job_id'])) {
			$form_page = get_field('job_applciation_form_page', 'options');
			if(!$form_page){
				$form_page = site_url('job-application-form/');
			}
	    $job_id = $_GET['job_id'];
	    $redirect = $form_page . '?job_id=' . $job_id;
	}
    return $redirect;
};


// Form submission
add_action( 'gform_after_submission_2', 'after_submission', 10, 2 );
function after_submission($entry, $form) {

    $user = wp_get_current_user();
    $users_applications = get_field('applications', 'user_' . $user->ID);

    // The job applied for
    $job_id = $entry[20];

    // Double check to make sure the user hasn't applied twice
    if ($users_applications) {
        foreach ($users_applications as $application) {
            if ($job_id == $application['job_id']) {
                // Delete any duplicate entries
                GFAPI::delete_entry( $entry['id'] );
                return;
            }
        }
    }
    // Apend the current application onto the list of previous applications
    $users_applications[] = [
        'job_id' => (int) $job_id,
        'job_reference' => get_field('reference', $job_id),
        'job_title' => get_the_title($job_id),
        'job_link' => get_permalink($job_id),
        'application_date' => time()
    ];


    update_field('applications', $users_applications, 'user_' . $user->ID);

		add_filter('gform_confirmation_2', 'application_completed_redirect', 100, 4);

}



add_filter('gform_confirmation_2', 'application_completed_redirect', 100, 4);
function application_completed_redirect($confirmation, $form, $lead, $ajax){

	$application_form_page = get_field('job_application_form_page', 'options');
	$confirmation = array("redirect" => add_query_arg( array(
			'job_id'	=>  $job_id = $_GET['job_id'],
			'status' => 'completed',
	), get_permalink($application_form_page)));

	return $confirmation;

}


/*
** Modify email notification to applicant
*/
add_filter( 'gform_notification_2', 'form_notification', 10, 3 );
function form_notification($notification, $form, $entry) {
    if ($notification['id'] == '5b643d267c53a') {
        $job_id = $entry[20]; // This gets the job post id
        $job = get_post($job_id);

        $job_title = $job->post_title;
        $job_content = $job->post_content;
        $job_spec = $job_content;
        $job_reference = get_field('reference', $job_id);
        $job_salary = get_field('salary', $job_id);
        $job_closing_date = get_field('closing_date', $job_id);

        $notification['message'] = str_replace('{job_title}', $job_title, $notification['message']);
        $notification['message'] = str_replace('{job_spec}', $job_spec, $notification['message']);
        $notification['message'] = str_replace('{job_reference}', $job_reference, $notification['message']);
        $notification['message'] = str_replace('{job_salary}', $job_salary, $notification['message']);
        $notification['message'] = str_replace('{job_closing_date}', $job_closing_date, $notification['message']);
    }

		return $notification;

}
