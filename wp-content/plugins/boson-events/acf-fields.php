<?php
if( function_exists('acf_add_local_field_group') ):

	/*
	** Product/Event fields
	*/
	acf_add_local_field_group(array(
		'key' => 'group_5b5f13112fa53',
		'title' => 'Event Banner',
		'fields' => array(
			array(
				'key' => 'field_5b5f131985761',
				'label' => 'Event Banner',
				'name' => 'event_banner',
				'type' => 'image',
				'instructions' => 'Banner that displays above event page. Recommended to be at least 1600px wide. Leave blank if not needed or not a event product.',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'return_format' => 'array',
				'preview_size' => 'thumbnail',
				'library' => 'all',
				'min_width' => '',
				'min_height' => '',
				'min_size' => '',
				'max_width' => '',
				'max_height' => '',
				'max_size' => '',
				'mime_types' => '',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'product',
				),

			),
		),
		'menu_order' => 0,
		'position' => 'acf_after_title',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => 1,
		'description' => '',
	));



	acf_add_local_field_group(array(
	  'key' => 'group_5b6013b903006',
	  'title' => 'Event',
	  'fields' => array(
		  array(
			  'key' => 'field_5b4e0678333b1',
			  'label' => 'Enquiry Page',
			  'name' => 'enquiry_page',
			  'type' => 'post_object',
			  'instructions' => 'Select enquiry page. If selected, a "Enquire Now" button will show on the event page.',
			  'required' => 0,
			  'conditional_logic' => 0,
			  'wrapper' => array(
				  'width' => '',
				  'class' => '',
				  'id' => '',
			  ),
			  'post_type' => array(
				  0 => 'page',
			  ),
			  'taxonomy' => array(
			  ),
			  'allow_null' => 1,
			  'multiple' => 0,
			  'return_format' => 'object',
			  'ui' => 1,
		  ),
		  array(
			  'key' => 'field_5b3edb128d4c1',
			  'label' => 'Event Icon',
			  'name' => 'event_icon',
			  'type' => 'text',
			  'instructions' => 'Copy icon name from the Font Awesome website: https://fontawesome.com/icons/. Example: long-arrow-left',
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
			  'key' => 'field_5b888e712c668',
			  'label' => 'Featured?',
			  'name' => 'featured',
			  'type' => 'true_false',
			  'instructions' => 'is this a featured event?',
			  'required' => 0,
			  'conditional_logic' => 0,
			  'wrapper' => array(
				  'width' => '',
				  'class' => '',
				  'id' => '',
			  ),
			  'message' => '',
			  'default_value' => 0,
			  'ui' => 1,
			  'ui_on_text' => 'Yes',
			  'ui_off_text' => 'No',
		  ),
		  array(
			  'key' => 'field_5bb5470544e57',
			  'label' => 'Ticket Types',
			  'name' => 'ticket_types',
			  'type' => 'repeater',
			  'instructions' => 'Enter your ticket options and prices, 1 per line. Enter the ticket \'name\' first followed by a : and then the price.',
			  'required' => 0,
			  'conditional_logic' => 0,
			  'wrapper' => array(
				  'width' => '',
				  'class' => '',
				  'id' => '',
			  ),
			  'collapsed' => '',
			  'min' => 1,
			  'max' => 0,
			  'layout' => 'table',
			  'button_label' => 'Add Option',
			  'sub_fields' => array(
				  array(
					  'key' => 'field_5bb547ad92a17',
					  'label' => 'Name',
					  'name' => 'name',
					  'type' => 'text',
					  'instructions' => '',
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
					  'key' => 'field_5bb547bf92a18',
					  'label' => 'Price',
					  'name' => 'price',
					  'type' => 'number',
					  'instructions' => '',
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
					  'min' => 0,
					  'max' => '',
					  'step' => '',
				  ),
			  ),
		  ),
		  array(
			  'key' => 'field_5b4e0677667b2',
			  'label' => 'Event Form',
			  'name' => 'event_form',
			  'type' => 'post_object',
			  'instructions' => 'Select the form that is used for this booking.',
			  'required' => 0,
			  'conditional_logic' => 0,
			  'wrapper' => array(
				  'width' => '',
				  'class' => '',
				  'id' => '',
			  ),
			  'post_type' => array(
				  0 => 'acf-field-group',
			  ),
			  'taxonomy' => array(
			  ),
			  'allow_null' => 1,
			  'multiple' => 0,
			  'return_format' => 'object',
			  'ui' => 1,
		  ),
			array(
				'key' => 'field_5b872d8c2d43c',
				'label' => 'Terms & Conditions',
				'name' => 'terms_conditions',
				'type' => 'file',
				'instructions' => 'The terms & conditions file that is displayed on the booking form.',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'return_format' => 'array',
				'library' => 'all',
				'min_size' => '',
				'max_size' => '',
				'mime_types' => '',
			),
			array(
				'key' => 'field_5b237b3ed231c',
				'label' => 'Confirmation Message',
				'name' => 'confirmation_message',
				'type' => 'wysiwyg',
				'instructions' => 'This is the text that is added to the order confirmation page if this event was purchased.',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'tabs' => 'all',
				'toolbar' => 'full',
				'media_upload' => 1,
				'delay' => 0,
			),
		  array(
			  'key' => 'field_5bc9fbcd5c004',
			  'label' => 'Content Blocks',
			  'name' => 'content_blocks',
			  'type' => 'flexible_content',
			  'instructions' => '',
			  'required' => 0,
			  'conditional_logic' => 0,
			  'wrapper' => array(
				  'width' => '',
				  'class' => '',
				  'id' => '',
			  ),
			  'layouts' => array(
				  '5bc9fbd2cd9aa' => array(
					  'key' => '5bc9fbd2cd9aa',
					  'name' => 'faqs',
					  'label' => 'FAQs',
					  'display' => 'block',
					  'sub_fields' => array(
						  array(
							  'key' => 'field_5b6061866b5e2',
							  'label' => 'Heading',
							  'name' => 'heading',
							  'type' => 'text',
							  'instructions' => '',
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
							  'key' => 'field_5b6061896b5e3',
							  'label' => 'FAQ Items',
							  'name' => 'faq_items',
							  'type' => 'relationship',
							  'instructions' => '',
							  'required' => 0,
							  'conditional_logic' => 0,
							  'wrapper' => array(
								  'width' => '',
								  'class' => '',
								  'id' => '',
							  ),
							  'post_type' => array(
								  0 => 'faqs',
							  ),
							  'taxonomy' => '',
							  'filters' => '',
							  'elements' => '',
							  'min' => '',
							  'max' => '',
							  'return_format' => 'object',
						  ),
					  ),
					  'min' => '',
					  'max' => '',
				  ),
				  'layout_5bc9fc34d64e5' => array(
					  'key' => 'layout_5bc9fc34d64e5',
					  'name' => 'sponsorship',
					  'label' => 'Sponsorship',
					  'display' => 'block',
					  'sub_fields' => array(
						  array(
							  'key' => 'field_5b60527982a90',
							  'label' => 'Heading',
							  'name' => 'heading',
							  'type' => 'text',
							  'instructions' => '',
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
							  'key' => 'field_5b60527e82a91',
							  'label' => 'Content',
							  'name' => 'content',
							  'type' => 'wysiwyg',
							  'instructions' => '',
							  'required' => 0,
							  'conditional_logic' => 0,
							  'wrapper' => array(
								  'width' => '',
								  'class' => '',
								  'id' => '',
							  ),
							  'default_value' => '',
							  'tabs' => 'all',
							  'toolbar' => 'full',
							  'media_upload' => 1,
							  'delay' => 0,
						  ),
						  array(
							  'key' => 'field_5b6052a782a92',
							  'label' => 'Buttons',
							  'name' => 'buttons',
							  'type' => 'repeater',
							  'instructions' => '',
							  'required' => 0,
							  'conditional_logic' => 0,
							  'wrapper' => array(
								  'width' => '',
								  'class' => '',
								  'id' => '',
							  ),
							  'collapsed' => '',
							  'min' => 0,
							  'max' => 2,
							  'layout' => 'table',
							  'button_label' => 'Add Button',
							  'sub_fields' => array(
								  array(
									  'key' => 'field_5b6052ae82a93',
									  'label' => 'Button Text',
									  'name' => 'button_text',
									  'type' => 'text',
									  'instructions' => '',
									  'required' => 0,
									  'conditional_logic' => 0,
									  'wrapper' => array(
										  'width' => '50',
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
									  'key' => 'field_5b6052b782a94',
									  'label' => 'Button Link',
									  'name' => 'button_link',
									  'type' => 'text',
									  'instructions' => '',
									  'required' => 0,
									  'conditional_logic' => 0,
									  'wrapper' => array(
										  'width' => '50',
										  'class' => '',
										  'id' => '',
									  ),
									  'default_value' => '',
									  'placeholder' => '',
									  'prepend' => '',
									  'append' => '',
									  'maxlength' => '',
								  ),
							  ),
						  ),
					  ),
					  'min' => '',
					  'max' => '',
				  ),
				  'layout_5bc9fcbbdd54f' => array(
					  'key' => 'layout_5bc9fcbbdd54f',
					  'name' => 'volunteering',
					  'label' => 'Volunteering',
					  'display' => 'block',
					  'sub_fields' => array(
						  array(
							  'key' => 'field_5b6030052c66a',
							  'label' => 'Heading',
							  'name' => 'heading',
							  'type' => 'text',
							  'instructions' => '',
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
							  'key' => 'field_5b60300a2c66b',
							  'label' => 'Form ID',
							  'name' => 'form_id',
							  'type' => 'number',
							  'instructions' => 'You can get the ID by accessing the \'Forms\' section down the left navigation',
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
							  'min' => '',
							  'max' => '',
							  'step' => '',
						  ),
					  ),
					  'min' => '',
					  'max' => '',
				  ),
				  'layout_5bc9fd1ff55ba' => array(
					  'key' => 'layout_5bc9fd1ff55ba',
					  'name' => 'gallery',
					  'label' => 'Gallery',
					  'display' => 'block',
					  'sub_fields' => array(
						  array(
							  'key' => 'field_5b6013cd2eb7a',
							  'label' => 'Image Gallery',
							  'name' => 'gallery_item',
							  'type' => 'repeater',
							  'instructions' => 'Add multiple images to appear in gallery',
							  'required' => 0,
							  'conditional_logic' => 0,
							  'wrapper' => array(
								  'width' => '',
								  'class' => '',
								  'id' => '',
							  ),
							  'collapsed' => '',
							  'min' => 0,
							  'max' => 0,
							  'layout' => 'table',
							  'button_label' => 'Add Image',
							  'sub_fields' => array(
								  array(
									  'key' => 'field_5b6013e22eb7b',
									  'label' => 'Image',
									  'name' => 'image',
									  'type' => 'image',
									  'instructions' => '',
									  'required' => 0,
									  'conditional_logic' => 0,
									  'wrapper' => array(
										  'width' => '',
										  'class' => '',
										  'id' => '',
									  ),
									  'return_format' => 'array',
									  'preview_size' => 'thumbnail',
									  'library' => 'all',
									  'min_width' => '',
									  'min_height' => '',
									  'min_size' => '',
									  'max_width' => '',
									  'max_height' => '',
									  'max_size' => '',
									  'mime_types' => '',
								  ),
							  ),
						  ),
					  ),
					  'min' => '',
					  'max' => '',
				  ),
					'5a9d6b905f23a' => array(
						'key' => '5a9d6b905f23a',
						'name' => 'two_column_video_left',
						'label' => 'Two Column (Image/Video Left)',
						'display' => 'block',
						'sub_fields' => array(
							array(
								'key' => 'field_5b59de12cc1fd',
								'label' => 'Content type',
								'name' => 'content_type',
								'type' => 'radio',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array(
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'choices' => array(
									'image' => 'Image',
									'video' => 'Video',
								),
								'allow_null' => 0,
								'other_choice' => 0,
								'default_value' => '',
								'layout' => 'vertical',
								'return_format' => 'value',
								'save_other_choice' => 0,
							),
							array(
								'key' => 'field_5a9d6b125f122',
								'label' => 'Image',
								'name' => 'image',
								'type' => 'image',
								'instructions' => 'Image is needed whether image or video is set above. If Video, image is used as thumbnail. Image should be around 600x400px.',
								'required' => 0,
								'wrapper' => array(
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'return_format' => 'array',
								'preview_size' => 'thumbnail',
								'library' => 'all',
								'min_width' => '',
								'min_height' => '',
								'min_size' => '',
								'max_width' => '',
								'max_height' => '',
								'max_size' => '',
								'mime_types' => '',
							),
							array(
								'key' => 'field_5b10deecb123f',
								'label' => 'Video URL',
								'name' => 'video_url',
								'type' => 'url',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => array(
									array(
										array(
											'field' => 'field_5b59de12cc1fd',
											'operator' => '==',
											'value' => 'video',
										),
									),
								),
								'wrapper' => array(
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'default_value' => '',
								'placeholder' => '',
							),
							array(
								'key' => 'field_5a1d6b125f33b',
								'label' => 'Heading',
								'name' => 'heading',
								'type' => 'text',
								'instructions' => '',
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
								'key' => 'field_5a9d1b125f90d',
								'label' => 'Content',
								'name' => 'content',
								'type' => 'wysiwyg',
								'instructions' => '',
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
								'key' => 'field_5b33df1d8d9c1',
								'label' => 'Button Text',
								'name' => 'button_text',
								'type' => 'text',
								'instructions' => '',
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
								'key' => 'field_5b51df248d6d2',
								'label' => 'Button URL',
								'name' => 'button_url',
								'type' => 'url',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array(
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'default_value' => '',
								'placeholder' => '',
							),
							array(
								'key' => 'field_5a2d39e4b4d6c',
								'label' => 'Background Colour',
								'name' => 'background_colour',
								'type' => 'select',
								'instructions' => 'Select the background colour used for this block',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array(
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'choices' => array(
									'section' => 'Section',
									'white' => 'White',
									'#8dc63f' => 'Green',
									'#f3cc30' => 'Yellow',
									'#f7941d' => 'Orange',
									'#bf3051' => 'Burgundy',
									'#9dc9eb' => 'Light Blue',
									'#639144' => 'Dark Green',
									'#525c63' => 'Grey',
								),
								'default_value' => array(
									0 => 'white',
								),
								'allow_null' => 0,
								'multiple' => 0,
								'ui' => 0,
								'return_format' => 'value',
								'ajax' => 0,
								'placeholder' => '',
							),
						),
						'min' => '',
						'max' => '',
					),
					'layout_5b2ed23e2ebb5' => array(
						'key' => 'layout_5b2ed23e2ebb5',
						'name' => 'documents',
						'label' => 'Documents',
						'display' => 'block',
						'sub_fields' => array(
							array(
								'key' => 'field_5b1ed2a23ebc1',
								'label' => 'Title',
								'name' => 'title',
								'type' => 'text',
								'instructions' => '',
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
								'key' => 'field_5b1b1fb43d1c1',
								'label' => 'Documents',
								'name' => 'documents',
								'type' => 'relationship',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array(
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'post_type' => array(
									0 => 'downloads',
								),
								'taxonomy' => array(
								),
								'filters' => array(
									0 => 'search',
									1 => 'taxonomy',
								),
								'elements' => '',
								'min' => '',
								'max' => '',
								'return_format' => 'object',
							),
						),
						'min' => '',
						'max' => '',
					),
			  ),
			  'button_label' => 'Add Row',
			  'min' => '',
			  'max' => '',
		  ),
	  ),
	  'location' => array(
		  array(
			  array(
				  'param' => 'post_type',
				  'operator' => '==',
				  'value' => 'product',
			  ),
		  ),
	  ),
	  'menu_order' => 5,
	  'position' => 'normal',
	  'style' => 'default',
	  'label_placement' => 'top',
	  'instruction_placement' => 'label',
	  'hide_on_screen' => '',
	  'active' => 1,
	  'description' => '',
  ));


	/*
	** Product category fields
	*/
	acf_add_local_field_group(array(
		'key' => 'group_5b6ac94ca7b64',
		'title' => 'Event Category',
		'fields' => array(
			array(
				'key' => 'field_5b6ac956a1103',
				'label' => 'Event Category',
				'name' => 'event_category',
				'type' => 'true_false',
				'instructions' => 'Is this category for events? If set to Yes, this product category and all events within it will be hidden from the \'Shop\' area',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'message' => '',
				'default_value' => 0,
				'ui' => 1,
				'ui_on_text' => 'Yes',
				'ui_off_text' => 'No',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'taxonomy',
					'operator' => '==',
					'value' => 'product_cat',
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

	/*
	** Event Type fields
	*/

acf_add_local_field_group(array(
	'key' => 'group_5b5f06c010664',
	'title' => 'Event Type',
	'fields' => array(
		array(
			'key' => 'field_5b5f06c40dc9d',
			'label' => 'Colour',
			'name' => 'colour',
			'type' => 'color_picker',
			'instructions' => 'Select a colour to be used in the calendar for this event type',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '#84BD00',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'taxonomy',
				'operator' => '==',
				'value' => 'event-type',
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

?>
