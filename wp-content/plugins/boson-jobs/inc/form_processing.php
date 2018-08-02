<?php

/****************************
Job application form
*****************************/

add_filter( 'woocommerce_login_redirect', 'prospect_woocommerce_login_redirect', 10, 2 ); 

function prospect_woocommerce_login_redirect( $redirect, $user ) { 
	if (isset($_GET['job_id'])) {
	    $job_id = $_GET['job_id'];

	    $redirect = '/job-application-form/?job_id=' . $job_id;
	}
    return $redirect; 
}; 

add_filter( 'woocommerce_registration_redirect', 'prospect_woocommerce_registration_redirect', 10, 1 );      

function prospect_woocommerce_registration_redirect( $redirect ) { 
	if (isset($_GET['job_id'])) {
	    $job_id = $_GET['job_id'];

	    $redirect = '/job-application-form/?job_id=' . $job_id;
	}
    return $redirect; 
}; 
         
// Form submission
add_action( 'gform_after_submission_2', 'after_submission', 10, 2 );

function after_submission($entry, $form) {
    $user = wp_get_current_user();
    $users_applications = get_field('applications', 'user_' . $user->ID);

    // The job applied for
    $job_id = $entry[5];

    // Double check to make sure the user hasn't applied twice
    foreach ($users_applications as $application) {
        if ($job_id == $application['job_id']) {
            GFAPI::delete_entry( $entry['id'] );
            return;
        }
    }
    // Apend the current application onto the list of previous applications
    $users_applications[] = [
        'job_id' => (int) $job_id,
        'job_reference' => get_field('reference', $job_id),
        'job_title' => get_the_title($job_id),
        'job_link' => get_permalink($job_id),
        'application_date' => date('d/m/Y g:i a')
    ];

    update_field('applications', $users_applications, 'user_' . $user->ID);
}

// Form completion
add_filter( 'gform_confirmation_2', 'override_form_completed', 10, 4 );

function override_form_completed($confirmation, $form, $entry, $ajax) {
    $user = wp_get_current_user();
    $users_applications = get_field('applications', 'user_' . $user->ID);

    // The job applied for
    $job_id = $entry[5];

    // Double check to make sure the user hasn't applied twice
    foreach ($users_applications as $application) {
        if ($job_id == $application['job_id']) {
            $confirmation = "You have already applied for this position.";
            return $confirmation;
        }
    }
    return $confirmation;
}