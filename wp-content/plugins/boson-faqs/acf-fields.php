<?php
if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_5b5b1df45b18a',
	'title' => 'FAQs',
	'fields' => array(
		array(
			'key' => 'field_5b5b1e0ab6b00',
			'label' => 'Question',
			'name' => 'question',
			'type' => 'text',
			'instructions' => 'If left blank, the post title will be used',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5b5b1e1cb6b01',
			'label' => 'Answer',
			'name' => 'answer',
			'type' => 'textarea',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'faqs',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => array(
		0 => 'the_content',
	),
	'active' => 1,
	'description' => '',
));

endif;