<?php 
if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_5b645cee4bea3',
	'title' => 'Jobs Settings',
	'fields' => array(
		array(
			'key' => 'field_5b645cffdb7cb',
			'label' => 'Position already applied for text',
			'name' => 'position_already_applied_for_text',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'You\'ve already applied for this position.',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5b645d8d8bba0',
			'label' => 'Apply button text',
			'name' => 'apply_button_text',
			'type' => 'text',
			'instructions' => 'The text that appears in the application button on the individual job pages.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Apply',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5b645e096f527',
			'label' => 'View job button text',
			'name' => 'view_job_button_text',
			'type' => 'text',
			'instructions' => 'The text that appears in the view job button on the job listing.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Apply',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5b645f2bdaa39',
			'label' => 'Login/Register button text',
			'name' => 'login_register_button_text',
			'type' => 'text',
			'instructions' => 'The text that appears on the login/register link on the job application page.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Login/Register',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'boson-jobs-settings',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

endif;