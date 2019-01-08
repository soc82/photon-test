<?php

add_action( 'wp', array( 'GFSagePayForm', 'maybe_thankyou_page' ), 5 );

GFForms::include_payment_addon_framework();

class GFSagePayForm extends GFPaymentAddOn {

	protected $_version = GF_SAGEPAY_FORM_VERSION;
	protected $_min_gravityforms_version = '1.8.12';
	protected $_slug = 'gravityforms-sagepay-form';
	protected $_path = 'gravityforms-sagepay-form/sagepay.php';
	protected $_full_path = __FILE__;
	protected $_url = 'http://www.gravityforms.com';
	protected $_title = 'Gravity Forms SagePay Form Add-On';
	protected $_short_title = 'SagePay Form';
	protected $_supports_callbacks = true;

	// Members plugin integration
	protected $_capabilities = array( 'gravityforms_sagepay_form', 'gravityforms_sagepay_form_uninstall' );

	// Permissions
	protected $_capabilities_settings_page = 'gravityforms_sagepay_form';
	protected $_capabilities_form_settings = 'gravityforms_sagepay_form';
	protected $_capabilities_uninstall = 'gravityforms_sagepay_form_uninstall';

	// Automatic upgrade enabled
	protected $_enable_rg_autoupgrade = FALSE;

	private static $_instance = null;

	public static function get_instance() {
		if ( self::$_instance == null ) {
			self::$_instance = new GFSagePayForm();
		}

		return self::$_instance;
	}

	private function __clone() {
	} /* do nothing */

	public function init_frontend() {
		parent::init_frontend();

		add_filter( 'gform_disable_post_creation', array( $this, 'delay_post' ), 10, 3 );
		add_filter( 'gform_disable_notification', array( $this, 'delay_notification' ), 10, 4 );
	}


	//----- SETTINGS PAGES ----------//

	public function plugin_settings_fields() {
		$description = '
			<p style="text-align: left;">' .
			__( 'SagePay Form allows you to accept credit card payments on their PCI compliant servers securely.', 'gravityforms-sagepay-form' ) .
			'</p>
				<br/>';

		return array(
			array(
				'title'       => '',
				'description' => $description,
				'fields'      => array(
					array(
						'name'          => 'mode',
						'label'         => __( 'Mode', 'gravityforms-sagepay-form' ),
						'type'          => 'radio',
						'choices'       => array(
							array( 'id' => 'gf_sagepay_form_mode_live', 'label' => __( 'Live', 'gravityforms-sagepay-form' ), 'value' => 'live' ),
							array( 'id' => 'gf_sagepay_form_mode_test', 'label' => __( 'Test', 'gravityforms-sagepay-form' ), 'value' => 'test' ),

						),

						'horizontal'    => true,
						'default_value' => 'live',
						'tooltip'       => '<h6>' . __( 'Mode', 'gravityforms-sagepay-form' ) . '</h6>' . __( 'Select Live to receive live payments. Select Test for testing purposes when using the SagePay Form development sandbox.', 'gravityforms-sagepay-form' )
					),
					array(
						'name'     => 'vendor_name',
						'label'    => __( 'Vendor Name ', 'gravityforms-sagepay-form' ),
						'type'     => 'text',
						'class'    => 'medium',
						'required' => true,
						'tooltip'  => '<h6>' . __( 'Vendor Name', 'gravityforms-sagepay-form' ) . '</h6>' . __( 'Please enter your vendor name provided by SagePay Form.', 'gravityforms-sagepay-form' )
					),
					array(
						'name'     => 'vendor_password',
						'label'    => __( 'Encryption Password ', 'gravityforms-sagepay-form' ),
						'type'     => 'text',
						'class'    => 'medium',
						'required' => true,
						'tooltip'  => '<h6>' . __( 'Encryption Password', 'gravityforms-sagepay-form' ) . '</h6>' . __( 'Please enter your encryption password provided by SagePay Form.', 'gravityforms-sagepay-form' )
					),
					array(
						'name'     => 'vendor_email',
						'label'    => __( 'Vendor E-Mail', 'gravityforms-sagepay-form' ),
						'type'     => 'text',
						'class'    => 'medium',
						'required' => true,
						'tooltip'  => '<h6>' . __( 'Vendor E-Mail', 'gravityforms-sagepay-form' ) . '</h6>' . __( 'An e-mail address on which you can be contacted when a transaction completes.', 'gravityforms-sagepay-form' )
					),
					array(
						'name'          => 'send_emails',
						'label'         => __( 'Send E-Mail', 'gravityforms-sagepay-form' ),
						'type'          => 'radio',
						'choices'       => array(
							array( 'id' => 'gf_sagepay_form_send_emails_no', 'label' => __( 'No One', 'gravityforms-sagepay-form' ), 'value' => '0' ),
							array( 'id' => 'gf_sagepay_form_send_emails_customer', 'label' => __( 'Customer and Vendor', 'gravityforms-sagepay-form' ), 'value' => '1' ),
							array( 'id' => 'gf_sagepay_form_send_emails_vendor', 'label' => __( 'Vendor Only', 'gravityforms-sagepay-form' ), 'value' => '2' ),

						),

						'horizontal'    => true,
						'default_value' => '2',
						'tooltip'       => '<h6>' . __( 'Send E-Mails', 'gravityforms-sagepay-form' ) . '</h6>' . __( 'Select Who to send e-mails to.', 'gravityforms-sagepay-form' )
					),
					array(
						'name'     => 'email_message',
						'label'    => __( 'Customer E-Mail Message', 'gravityforms-sagepay-form' ),
						'type'     => 'textarea',
						'class'    => 'medium',
						'required' => true,
						'tooltip'  => '<h6>' . __( 'Customer E-Mail Message', 'gravityforms-sagepay-form' ) . '</h6>' . __( 'A message to the customer which is inserted into the successful transaction e-mails only.', 'gravityforms-sagepay-form' )
					),
					array(
						'name'          => 'apply3d',
						'label'         => __( 'Apply 3D Secure', 'gravityforms-sagepay-form' ),
						'type'          => 'radio',
						'choices'       => array(
							array( 'id' => 'gf_sagepay_form_apply3d_true', 'label' => __( 'Yes', 'gravityforms-sagepay-form' ), 'value' => '1' ),
							array( 'id' => 'gf_sagepay_form_apply3d_false', 'label' => __( 'No', 'gravityforms-sagepay-form' ), 'value' => '0' ),

						),

						'horizontal'    => true,
						'default_value' => '1',
						'tooltip'       => '<h6>' . __( 'Apply 3D Secure', 'gravityforms-sagepay-form' ) . '</h6>' . __( 'Select whether you would like to do 3D Secure Check on Transactions.', 'gravityforms-sagepay-form' )
					),
					array(
						'name'          => 'trans_type',
						'label'         => __( 'Send E-Mail', 'gravityforms-sagepay-form' ),
						'type'          => 'radio',
						'choices'       => array(
							array( 'id' => 'gf_sagepay_form_trans_type_payment', 'label' => __( 'PAYMENT', 'gravityforms-sagepay-form' ), 'value' => 'PAYMENT' ),
							array( 'id' => 'gf_sagepay_form_trans_type_deferred', 'label' => __( 'DEFERRED', 'gravityforms-sagepay-form' ), 'value' => 'DEFERRED' ),
							array( 'id' => 'gf_sagepay_form_trans_type_authenticate', 'label' => __( 'AUTHENTICATE', 'gravityforms-sagepay-form' ), 'value' => 'AUTHENTICATE' ),

						),

						'horizontal'    => true,
						'default_value' => 'PAYMENT',
						'tooltip'       => '<h6>' . __( 'Send E-Mails', 'gravityforms-sagepay-form' ) . '</h6>' . __( 'Select Who to send e-mails to.', 'gravityforms-sagepay-form' )
					),
					array(
						'type' => 'save',
						'messages' => array(
											'success' => __( 'Settings have been updated.', 'gravityforms-sagepay-form' )
											),
					),
				),
			),
		);
	}

	public function feed_list_no_item_message(){
		$settings = $this->get_plugin_settings();
		if ( ! rgar( $settings, 'vendor_name' ) ){
			return sprintf( __( 'To get started, let\'s go configure your %sSagePay Form Settings%s!', 'gravityforms-sagepay-form' ), '<a href="' . admin_url( 'admin.php?page=gf_settings&subview=' . $this->_slug ) . '">', '</a>' );
		}
		else {
			return parent::feed_list_no_item_message();
		}
	}

	public function feed_settings_fields() {
		$default_settings = parent::feed_settings_fields();

		//--add SagePay Form Vendor Name field
/*		$fields = array(
			array(
				'name'     => 'vendor_name',
				'label'    => __( 'SagePay Form Vendor Name ', 'gravityforms-sagepay-form' ),
				'type'     => 'text',
				'class'    => 'medium',
				'required' => true,
				'tooltip'  => '<h6>' . __( 'SagePay Form Vendor Name', 'gravityforms-sagepay-form' ) . '</h6>' . __( 'Enter the SagePay Form email address where payment should be received.', 'gravityforms-sagepay-form' )
			),
			array(
				'name'          => 'mode',
				'label'         => __( 'Mode', 'gravityforms-sagepay-form' ),
				'type'          => 'radio',
				'choices'       => array(
					array( 'id' => 'gf_sagepay_form_mode_live', 'label' => __( 'Live', 'gravityforms-sagepay-form' ), 'value' => 'live' ),
					array( 'id' => 'gf_sagepay_form_mode_test', 'label' => __( 'Test', 'gravityforms-sagepay-form' ), 'value' => 'test' ),

				),

				'horizontal'    => true,
				'default_value' => 'live',
				'tooltip'       => '<h6>' . __( 'Mode', 'gravityforms-sagepay-form' ) . '</h6>' . __( 'Select Live to receive live payments. Select Test for testing purposes when using the SagePay Form development sandbox.', 'gravityforms-sagepay-form' )
			),
		);

		$default_settings = parent::add_field_after( 'feedName', $fields, $default_settings );
		*/

		//--------------------------------------------------------------------------------------

		//--add donation to transaction type drop down
		$transaction_type = parent::get_field( 'transactionType', $default_settings );
		$choices          = $transaction_type['choices'];
		$add_donation     = true;
		unset($transaction_type[2]);
		unset($choices[2]);
		foreach ( $choices as $choice ) {
			//add donation option if it does not already exist
			if ( $choice['value'] == 'donation' ) {
				$add_donation = false;
			}
		}
		if ( $add_donation ) {
			//add donation transaction type
			$choices[] = array( 'label' => __( 'Donations', 'gravityforms-sagepay-form' ), 'value' => 'donation' );
		}
		$transaction_type['choices'] = $choices;
		$default_settings            = $this->replace_field( 'transactionType', $transaction_type, $default_settings );

		$default_settings[3]['fields'][0]['field_map'][] = array('label' => 'Reference', 'name'=> 'vendor_data','required'=> '' );

		//-------------------------------------------------------------------------------------------------

		//--add Page Style, Continue Button Label, Cancel URL
		$fields = array(
			/*array(
				'name'     => 'pageStyle',
				'label'    => __( 'Page Style', 'gravityforms-sagepay-form' ),
				'type'     => 'text',
				'class'    => 'medium',
				'required' => false,
				'tooltip'  => '<h6>' . __( 'Page Style', 'gravityforms-sagepay-form' ) . '</h6>' . __( 'This option allows you to select which SagePay Form page style should be used if you have setup a custom payment page style with SagePay Form.', 'gravityforms-sagepay-form' )
			),
			array(
				'name'     => 'continueText',
				'label'    => __( 'Continue Button Label', 'gravityforms-sagepay-form' ),
				'type'     => 'text',
				'class'    => 'medium',
				'required' => false,
				'tooltip'  => '<h6>' . __( 'Continue Button Label', 'gravityforms-sagepay-form' ) . '</h6>' . __( 'Enter the text that should appear on the continue button once payment has been completed via SagePay Form.', 'gravityforms-sagepay-form' )
			),*/
			array(
				'name'     => 'cancelUrl',
				'label'    => __( 'Cancel URL', 'gravityforms-sagepay-form' ),
				'type'     => 'text',
				'class'    => 'medium',
				'required' => false,
				'tooltip'  => '<h6>' . __( 'Cancel URL', 'gravityforms-sagepay-form' ) . '</h6>' . __( 'Enter the URL the user should be sent to should they cancel before completing their SagePay Form payment or payment fails.', 'gravityforms-sagepay-form' )
			),
			array(
				'name'     => 'successUrl',
				'label'    => __( 'Success URL', 'gravityforms-sagepay-form' ),
				'type'     => 'text',
				'class'    => 'medium',
				'required' => false,
				'tooltip'  => '<h6>' . __( 'Success URL', 'gravityforms-sagepay-form' ) . '</h6>' . __( 'Enter the URL the user should be sent to after completing their SagePay Form payment.', 'gravityforms-sagepay-form' )
			),/*
			array(
				'name'    => 'options',
				'label'   => __( 'Options', 'gravityforms-sagepay-form' ),
				'type'    => 'options',
				'tooltip' => '<h6>' . __( 'Options', 'gravityforms-sagepay-form' ) . '</h6>' . __( 'Turn on or off the available SagePay Form checkout options.', 'gravityforms-sagepay-form' )
			),*/
			array(
				'name'    => 'notifications',
				'label'   => __( 'Notifications', 'gravityforms-sagepay-form' ),
				'type'    => 'notifications',
				'tooltip' => '<h6>' . __( 'Notifications', 'gravityforms-sagepay-form' ) . '</h6>' . __( "Enable this option if you would like to only send out this form's notifications after payment has been received. Leaving this option disabled will send notifications immediately after the form is submitted.", 'gravityforms-sagepay-form' )
			),
		);

		//Add post fields if form has a post
		$form = $this->get_current_form();
		if ( GFCommon::has_post_field( $form['fields'] ) ) {
			$post_settings = array(
				'name'    => 'post_checkboxes',
				'label'   => __( 'Posts', 'gravityforms-sagepay-form' ),
				'type'    => 'checkbox',
				'tooltip' => '<h6>' . __( 'Posts', 'gravityforms-sagepay-form' ) . '</h6>' . __( 'Enable this option if you would like to only create the post after payment has been received.', 'gravityforms-sagepay-form' ),
				'choices' => array(
					array( 'label' => __( 'Create post only when payment is received.', 'gravityforms-sagepay-form' ), 'name' => 'delayPost' ),
				),
			);

			if ( $this->get_setting( 'transactionType' ) == 'subscription' ) {
				$post_settings['choices'][] = array(
					'label'    => __( 'Change post status when subscription is canceled.', 'gravityforms-sagepay-form' ),
					'name'     => 'change_post_status',
					'onChange' => 'var action = this.checked ? "draft" : ""; jQuery("#update_post_action").val(action);',
				);
			}

			$fields[] = $post_settings;
		}

		//Adding custom settings for backwards compatibility with hook 'gform_sagepay_form_add_option_group'
		$fields[] = array(
			'name'  => 'custom_options',
			'label' => '',
			'type'  => 'custom',
		);

		$default_settings = $this->add_field_after( 'billingInformation', $fields, $default_settings );
		//-----------------------------------------------------------------------------------------

		//--get billing info section and add customer first/last name
		$billing_info   = parent::get_field( 'billingInformation', $default_settings );
		$billing_fields = $billing_info['field_map'];
		$add_first_name = true;
		$add_last_name  = true;
		foreach ( $billing_fields as $mapping ) {
			//add first/last name if it does not already exist in billing fields
			if ( $mapping['name'] == 'firstName' ) {
				$add_first_name = false;
			} else if ( $mapping['name'] == 'lastName' ) {
				$add_last_name = false;
			}
		}

		if ( $add_last_name ) {
			//add last name
			array_unshift( $billing_info['field_map'], array( 'name' => 'lastName', 'label' => __( 'Last Name', 'gravityforms-sagepay-form' ), 'required' => false ) );
		}
		if ( $add_first_name ) {
			array_unshift( $billing_info['field_map'], array( 'name' => 'firstName', 'label' => __( 'First Name', 'gravityforms-sagepay-form' ), 'required' => false ) );
		}

		$billing_info['field_map'][] = array( 'name' => 'phone', 'label' => __( 'Phone', 'gravityforms-sagepay-form' ), 'required' => false );

		$default_settings = parent::replace_field( 'billingInformation', $billing_info, $default_settings );
		//----------------------------------------------------------------------------------------------------

		//hide default display of setup fee, not used by SagePay Form
		$default_settings = parent::remove_field( 'setupFee', $default_settings );

		//--add trial period
		$trial_period     = array(
			'name'    => 'trialPeriod',
			'label'   => __( 'Trial Period', 'gravityforms-sagepay-form' ),
			'type'    => 'trial_period',
			'hidden'  => ! $this->get_setting( 'trial_enabled' ),
			'tooltip' => '<h6>' . __( 'Trial Period', 'gravityforms-sagepay-form' ) . '</h6>' . __( 'Select the trial period length.', 'gravityforms-sagepay-form' )
		);
		$default_settings = parent::add_field_after( 'trial', $trial_period, $default_settings );
		//-----------------------------------------------------------------------------------------
/*
		//--Add Try to bill again after failed attempt.
		$recurring_retry  = array(
			'name'       => 'recurringRetry',
			'label'      => __( 'Recurring Retry', 'gravityforms-sagepay-form' ),
			'type'       => 'checkbox',
			'horizontal' => true,
			'choices'    => array( array( 'label' => __( 'Try to bill again after failed attempt.', 'gravityforms-sagepay-form' ), 'name' => 'recurringRetry', 'value' => '1' ) ),
			'tooltip'    => '<h6>' . __( 'Recurring Retry', 'gravityforms-sagepay-form' ) . '</h6>' . __( 'Turn on or off whether to try to bill again after failed attempt.', 'gravityforms-sagepay-form' )
		);
		$default_settings = parent::add_field_after( 'recurringTimes', $recurring_retry, $default_settings );
*/
		//-----------------------------------------------------------------------------------------------------

		return apply_filters( 'gform_sagepay_form_feed_settings_fields', $default_settings, $form );
	}

	public function field_map_title() {
		return __( 'SagePay Form Field', 'gravityforms-sagepay-form' );
	}

	public function settings_trial_period( $field, $echo = true ) {
		//use the parent billing cycle function to make the drop down for the number and type
		$html = parent::settings_billing_cycle( $field );

		return $html;
	}

	public function set_trial_onchange( $field ) {
		//return the javascript for the onchange event
		return "
		if(jQuery(this).prop('checked')){
			jQuery('#{$field['name']}_product').show('slow');
			jQuery('#gaddon-setting-row-trialPeriod').show('slow');
			if (jQuery('#{$field['name']}_product').val() == 'enter_amount'){
				jQuery('#{$field['name']}_amount').show('slow');
			}
			else{
				jQuery('#{$field['name']}_amount').hide();
			}
		}
		else {
			jQuery('#{$field['name']}_product').hide('slow');
			jQuery('#{$field['name']}_amount').hide();
			jQuery('#gaddon-setting-row-trialPeriod').hide('slow');
		}";
	}

	public function settings_options( $field, $echo = true ) {
		$checkboxes = array(
			'name'    => 'options_checkboxes',
			'type'    => 'checkboxes',
			'choices' => array(
				array( 'label' => __( 'Do not prompt buyer to include a shipping address.', 'gravityforms-sagepay-form' ), 'name' => 'disableShipping' ),
				array( 'label' => __( 'Do not prompt buyer to include a note with payment.', 'gravityforms-sagepay-form' ), 'name' => 'disableNote' ),
			)
		);

		$html = $this->settings_checkbox( $checkboxes, false );

		//--------------------------------------------------------
		//For backwards compatibility.
		ob_start();
		do_action( 'gform_sagepay_form_action_fields', $this->get_current_feed(), $this->get_current_form() );
		$html .= ob_get_clean();
		//--------------------------------------------------------

		if ( $echo ) {
			echo $html;
		}

		return $html;
	}

	public function settings_custom( $field, $echo = true ) {

		ob_start();
		?>
		<div id='gf_sagepay_form_custom_settings'>
			<?php
			do_action( 'gform_sagepay_form_add_option_group', $this->get_current_feed(), $this->get_current_form() );
			?>
		</div>

		<script type='text/javascript'>
			jQuery(document).ready(function () {
				jQuery('#gf_sagepay_form_custom_settings label.left_header').css('margin-left', '-200px');
			});
		</script>

		<?php

		$html = ob_get_clean();

		if ( $echo ) {
			echo $html;
		}

		return $html;
	}

	public function settings_notifications( $field, $echo = true ) {
		$checkboxes = array(
			'name'    => 'delay_notification',
			'type'    => 'checkboxes',
			'onclick' => 'ToggleNotifications();',
			'choices' => array(
				array(
					'label' => __( 'Send notifications only when payment is received.', 'gravityforms-sagepay-form' ),
					'name'  => 'delayNotification',
				),
			)
		);

		$html = $this->settings_checkbox( $checkboxes, false );

		$html .= $this->settings_hidden( array( 'name' => 'selectedNotifications', 'id' => 'selectedNotifications' ), false );

		$form                      = $this->get_current_form();
		$has_delayed_notifications = $this->get_setting( 'delayNotification' );
		ob_start();
		?>
		<ul id="gf_sagepay_form_notification_container" style="padding-left:20px; margin-top:10px; <?php echo $has_delayed_notifications ? '' : 'display:none;' ?>">
			<?php
			if ( ! empty( $form ) && is_array( $form['notifications'] ) ) {
				$selected_notifications = $this->get_setting( 'selectedNotifications' );
				if ( ! is_array( $selected_notifications ) ) {
					$selected_notifications = array();
				}

				//$selected_notifications = empty($selected_notifications) ? array() : json_decode($selected_notifications);

				foreach ( $form['notifications'] as $notification ) {
					?>
					<li class="gf_sagepay_form_notification">
						<input type="checkbox" class="notification_checkbox" value="<?php echo $notification['id'] ?>" onclick="SaveNotifications();" <?php checked( true, in_array( $notification['id'], $selected_notifications ) ) ?> />
						<label class="inline" for="gf_sagepay_form_selected_notifications"><?php echo $notification['name']; ?></label>
					</li>
				<?php
				}
			}
			?>
		</ul>
		<script type='text/javascript'>
			function SaveNotifications() {
				var notifications = [];
				jQuery('.notification_checkbox').each(function () {
					if (jQuery(this).is(':checked')) {
						notifications.push(jQuery(this).val());
					}
				});
				jQuery('#selectedNotifications').val(jQuery.toJSON(notifications));
			}

			function ToggleNotifications() {

				var container = jQuery('#gf_sagepay_form_notification_container');
				var isChecked = jQuery('#delaynotification').is(':checked');

				if (isChecked) {
					container.slideDown();
					jQuery('.gf_sagepay_form_notification input').prop('checked', true);
				}
				else {
					container.slideUp();
					jQuery('.gf_sagepay_form_notification input').prop('checked', false);
				}

				SaveNotifications();
			}
		</script>
		<?php

		$html .= ob_get_clean();

		if ( $echo ) {
			echo $html;
		}

		return $html;
	}

	public function checkbox_input_change_post_status( $choice, $attributes, $value, $tooltip ) {
		$markup = $this->checkbox_input( $choice, $attributes, $value, $tooltip );

		$dropdown_field = array(
			'name'     => 'update_post_action',
			'choices'  => array(
				array( 'label' => '' ),
				array( 'label' => __( 'Mark Post as Draft', 'gravityforms-sagepay-form' ), 'value' => 'draft' ),
				array( 'label' => __( 'Delete Post', 'gravityforms-sagepay-form' ), 'value' => 'delete' ),

			),
			'onChange' => "var checked = jQuery(this).val() ? 'checked' : false; jQuery('#change_post_status').attr('checked', checked);",
		);
		$markup .= '&nbsp;&nbsp;' . $this->settings_select( $dropdown_field, false );

		return $markup;
	}

	public function option_choices() {
		return false;
		$option_choices = array(
			array( 'label' => __( 'Do not prompt buyer to include a shipping address.', 'gravityforms-sagepay-form' ), 'name' => 'disableShipping', 'value' => '' ),
			array( 'label' => __( 'Do not prompt buyer to include a note with payment.', 'gravityforms-sagepay-form' ), 'name' => 'disableNote', 'value' => '' ),
		);

		return $option_choices;
	}

	public function save_feed_settings( $feed_id, $form_id, $settings ) {

		//--------------------------------------------------------
		//For backwards compatibility
		$feed = $this->get_feed( $feed_id );

		//Saving new fields into old field names to maintain backwards compatibility for delayed payments
		$settings['type'] = $settings['transactionType'];

		if ( isset( $settings['recurringAmount'] ) ) {
			$settings['recurring_amount_field'] = $settings['recurringAmount'];
		}

		$feed['meta'] = $settings;
		$feed         = apply_filters( 'gform_sagepay_form_save_config', $feed );

		//call hook to validate custom settings/meta added using gform_sagepay_form_action_fields or gform_sagepay_form_add_option_group action hooks
		$is_validation_error = apply_filters( 'gform_sagepay_form_config_validation', false, $feed );
		if ( $is_validation_error ) {
			//fail save
			return false;
		}

		$settings     = $feed['meta'];

		//--------------------------------------------------------

		return parent::save_feed_settings( $feed_id, $form_id, $settings );
	}


	//------ SENDING TO WORLDPAY -----------//

	public function redirect_url( $feed, $submission_data, $form, $entry ) {

		//Don't process redirect url if request is a SagePay Form return
		if ( ! rgempty( 'gf_sagepay_form_return', $_GET ) ) {
			return false;
		}

		$settings = $this->get_plugin_settings();

		//updating lead's payment_status to Processing
		GFAPI::update_entry_property( $entry['id'], 'payment_status', 'Processing' );

		if( $settings['trans_type'] == 'PAYMENT' ){
			$trans_type = 'PAYMENT';
		}else if( $settings['trans_type'] == 'DEFERRED' ){
			$trans_type = 'DEFERRED';
		}else{
			$trans_type = 'AUTHENTICATE';
		}

		$invoice_id = apply_filters( 'gform_sagepay_form_invoice', '', $form, $entry );

		$entryid = $entry['id'];

		$invoice = empty( $invoice_id ) ? $entryid : $invoice_id;

		//Current Currency
		$currency = GFCommon::get_currency();

		//Customer fields
		$customer_fields = $this->customer_query_string( $feed, $entry );

		$return_url = $this->return_url( $form['id'], $entry['id'] );

		//Cancel URL
		$cancel_url = ! empty( $feed['meta']['cancelUrl'] ) ? $feed['meta']['cancelUrl'] : home_url();

		//URL that will listen to notifications from SagePay Form
		$ipn_url = add_query_arg( 'page', 'gf_sagepay_form_ipn', home_url( '/' ) );

		$vendor_name = $settings['vendor_name'];
		$mode = $settings['mode'];
		$apply3d = $settings['apply3d'];
		$email_message = $settings['email_message'];
		$send_emails = $settings['send_emails'];
		$vendor_email = $settings['vendor_email'];

		$custom_field   = $entry['id'] . '|' . wp_hash( $entry['id'] );

		switch ( $feed['meta']['transactionType'] ) {
			case 'product' :
				//build query string using $submission_data
				$payment_amount = $this->get_product_query_string( $submission_data, $entry['id'] );
				break;

			case 'donation' :
				$payment_amount = $this->get_donation_query_string( $submission_data, $entry['id'] );
				break;
/*
			case 'subscription' :
				$payment_amount = $this->get_subscription_query_string( $feed, $submission_data, $entry['id'] );
				break;*/
		}

        $time_stamp = date("ymdHis");
        $orderid = $vendor_name . "-" . $time_stamp . "-" . $invoice;

        $custom_field = $entry["id"] . "-" . wp_hash($entry["id"]);

        $first_name = $customer_fields['first_name'];
        $last_name = $customer_fields['last_name'];
        $address = $customer_fields['address1'];
        $address1 = $customer_fields['address2'];
        $country = 'GB';
        $city = $customer_fields['town'];
        $state = $customer_fields['region'];
        $postcode = $customer_fields['postcode'];
        $phone = $customer_fields['phone'];
        $email = $customer_fields['email'];

		    $sagepay_arg['VendorData'] 			= $entry[$feed['meta']['billingInformation_vendor_data']];
				$sagepay_arg['ReferrerID'] 			= 'CC923B06-40D5-4713-85C1-700D690550BF';
        $sagepay_arg['Amount'] 				= $payment_amount;

				$sagepay_arg['CustomerName']		= substr($first_name.' '.$last_name, 0, 100);
        $sagepay_arg['CustomerEMail'] 		= substr($email, 0, 255);

        $sagepay_arg['BillingSurname'] 		= substr($last_name, 0, 20);
        $sagepay_arg['BillingFirstnames'] 	= substr($first_name, 0, 20);
        $sagepay_arg['BillingAddress1'] 	= substr($address, 0, 100);
        $sagepay_arg['BillingAddress2'] 	= substr($address1, 0, 100);
        $sagepay_arg['BillingCity'] 		= substr($city, 0, 40);
		if( $country == 'US' ){
        	$sagepay_arg['BillingState'] 	= $state;
		}else{
        	$sagepay_arg['BillingState'] 	= '';
		}
        $sagepay_arg['BillingPostCode'] 	= substr($postcode, 0, 10);
        $sagepay_arg['BillingCountry'] 		= $country;
        $sagepay_arg['BillingPhone'] 		= substr($phone, 0, 20);

        $sagepay_arg['DeliverySurname'] 	= substr($last_name, 0, 20);
        $sagepay_arg['DeliveryFirstnames'] 	= substr($first_name, 0, 20);
        $sagepay_arg['DeliveryAddress1'] 	= substr($address, 0, 100);
        $sagepay_arg['DeliveryAddress2'] 	= substr($address1, 0, 100);
        $sagepay_arg['DeliveryCity'] 		= substr($city, 0, 40);
		if( $country == 'US' ){
        	$sagepay_arg['DeliveryState'] 	= $state;
		}else{
        	$sagepay_arg['DeliveryState'] 	= '';
		}
        $sagepay_arg['DeliveryPostCode'] 	= substr($postcode, 0, 10);
        $sagepay_arg['DeliveryCountry'] 	= $country;
        $sagepay_arg['DeliveryPhone'] 		= substr($phone, 0, 20);

        $sagepay_arg['FailureURL'] 			= $ipn_url;
        $sagepay_arg['SuccessURL'] 			= $ipn_url;
        $sagepay_arg['Description'] 		= sprintf(__('Order #%s' , 'gravityforms'), ltrim( $invoice, '#' ));
        $sagepay_arg['Currency'] 			= $currency;
        $sagepay_arg['VendorTxCode'] 		= $custom_field;
        $sagepay_arg['VendorEMail'] 		= $vendor_email;
        $sagepay_arg['SendEMail'] 			= $send_emails;
		if( $country == 'US' ){
        	$sagepay_arg['eMailMessage']	= $email_message;
		}
        $sagepay_arg['Apply3DSecure'] 		= $apply3d;

        $post_values = "";
        foreach( $sagepay_arg as $key => $value ) {
            $post_values .= "$key=" . trim( $value ) . "&";
        }
      	$post_values = substr($post_values, 0, -1);

		$params['VPSProtocol'] = '3.00';
		$params['TxType'] = $trans_type;
		$params['Vendor'] = $vendor_name;
	  $params['Crypt'] = $this->encryptAndEncode($post_values);



  	$query_string = http_build_query($params);

		$query_string = apply_filters( "gform_sagepay_form_query_{$form['id']}", apply_filters( 'gform_sagepay_form_query', $query_string, $form, $entry, $feed ), $form, $entry, $feed );

		if ( ! $query_string ) {
			$this->log_debug( 'NOT sending to SagePay Form: The price is either zero or the gform_sagepay_form_query filter was used to remove the querystring that is sent to SagePay Form.' );

			return '';
		}

		$url = $ipn_url."&".$query_string;

		$url = apply_filters( "gform_sagepay_form_request_{$form['id']}", apply_filters( 'gform_sagepay_form_request', $url, $form, $entry, $feed ), $form, $entry, $feed );

		$this->log_debug( "Sending to SagePay Form: {<pre>".print_r($params,TRUE)."</pre>}" );


		return $url;
	}

/*
** mcrypt_decrypt no longer supported, so new encrypt & decrypt functions below
**
	public function encryptAndEncode($strIn) {

		$settings = $this->get_plugin_settings();
		$vendorpass = $settings['vendor_password'];

		$strIn = self::pkcs5_pad($strIn, 16);
		return "@".bin2hex(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $vendorpass, $strIn, MCRYPT_MODE_CBC, $vendorpass));
	}

	public function decodeAndDecrypt($strIn) {
		$settings = $this->get_plugin_settings();
		$vendorpass = $settings['vendor_password'];
		$strIn = substr($strIn, 1);
		$strIn = pack('H*', $strIn);
		return mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $vendorpass, $strIn, MCRYPT_MODE_CBC, $vendorpass);
	}
	*/

	public function encryptAndEncode($strIn) {
			$settings = $this->get_plugin_settings();
			$vendorpass = $settings['vendor_password'];
			return "@" . bin2hex(openssl_encrypt($strIn, 'AES-128-CBC', $vendorpass, OPENSSL_RAW_DATA, $vendorpass));
	}


	public function decodeAndDecrypt($strIn) {
			$settings = $this->get_plugin_settings();
			$vendorpass = $settings['vendor_password'];
			$strIn = substr($strIn, 1);
			$strIn = pack('H*', $strIn);
			return openssl_decrypt($strIn, 'AES-128-CBC', $vendorpass, OPENSSL_RAW_DATA, $vendorpass);
	}


	public function pkcs5_pad($text, $blocksize)	{
		$pad = $blocksize - (strlen($text) % $blocksize);
		return $text . str_repeat(chr($pad), $pad);
	}

	public function decode($strIn) {
		$decodedString = self::decodeAndDecrypt($strIn);
		parse_str($decodedString, $sagePayResponse);
		return $sagePayResponse;
	}

	public function get_product_query_string( $submission_data, $entry_id ) {

		if ( empty( $submission_data ) ) {
			return false;
		}

		$query_string   = '';
		$payment_amount = rgar( $submission_data, 'payment_amount' );
		$setup_fee      = rgar( $submission_data, 'setup_fee' );
		$trial_amount   = rgar( $submission_data, 'trial' );
		$line_items     = rgar( $submission_data, 'line_items' );
		$discounts      = rgar( $submission_data, 'discounts' );

		$product_index = 1;
		$shipping      = '';
		$discount_amt  = 0;
		$cmd           = '_cart';
		$extra_qs      = '&upload=1';

		//work on products
		if ( is_array( $line_items ) ) {
			foreach ( $line_items as $item ) {
				$product_name = urlencode( $item['name'] );
				$quantity     = $item['quantity'];
				$unit_price   = $item['unit_price'];
				$options      = rgar( $item, 'options' );
				$product_id   = $item['id'];
				$is_shipping  = rgar( $item, 'is_shipping' );

				if ( $is_shipping ) {
					//populate shipping info
					$shipping .= ! empty( $unit_price ) ? "&shipping_1={$unit_price}" : '';
				} else {
					//add product info to querystring
					//$query_string .= "&item_name_{$product_index}={$product_name}&amount_{$product_index}={$unit_price}&quantity_{$product_index}={$quantity}";
				}
				//add options
				if ( ! empty( $options ) ) {
					if ( is_array( $options ) ) {
						$option_index = 1;
						foreach ( $options as $option ) {
							$option_label = urlencode( $option['field_label'] );
							$option_name  = urlencode( $option['option_name'] );
							//$query_string .= "&on{$option_index}_{$product_index}={$option_label}&os{$option_index}_{$product_index}={$option_name}";
							$option_index ++;
						}
					}
				}
				$product_index ++;
			}
		}

		//look for discounts
		if ( is_array( $discounts ) ) {
			foreach ( $discounts as $discount ) {
				$discount_full = abs( $discount['unit_price'] ) * $discount['quantity'];
				$discount_amt += $discount_full;
			}
			if ( $discount_amt > 0 ) {
				//$query_string .= "&discount_amount_cart={$discount_amt}";
			}
		}
		$desc = urlencode("Order No".$entry_id);

		//$query_string .= "{$shipping}&cmd={$cmd}{$extra_qs}";
        $query_string .= "&amount={$payment_amount}&desc={$desc}";

		//save payment amount to lead meta
		gform_update_meta( $entry_id, 'payment_amount', $payment_amount );

		return $payment_amount > 0 ? $payment_amount : false;
		//return $payment_amount > 0 ? $query_string : false;

	}

	public function get_donation_query_string( $submission_data, $entry_id ) {
		if ( empty( $submission_data ) ) {
			return false;
		}

		$query_string   = '';
		$payment_amount = rgar( $submission_data, 'payment_amount' );
		$line_items     = rgar( $submission_data, 'line_items' );
		$purpose        = '';
		$cmd            = '_donations';

		//work on products
		if ( is_array( $line_items ) ) {
			foreach ( $line_items as $item ) {
				$product_name    = $item['name'];
				$quantity        = $item['quantity'];
				$quantity_label  = $quantity > 1 ? $quantity . ' ' : '';
				$options         = rgar( $item, 'options' );
				$is_shipping     = rgar( $item, 'is_shipping' );
				$product_options = '';

				if ( ! $is_shipping ) {
					//add options
					if ( ! empty( $options ) ) {
						if ( is_array( $options ) ) {
							$product_options = ' (';
							foreach ( $options as $option ) {
								$product_options .= $option['option_name'] . ', ';
							}
							$product_options = substr( $product_options, 0, strlen( $product_options ) - 2 ) . ')';
						}
					}
					$purpose .= $quantity_label . $product_name . $product_options . ', ';
				}
			}
		}

		if ( ! empty( $purpose ) ) {
			$purpose = substr( $purpose, 0, strlen( $purpose ) - 2 );
		}

		$purpose = urlencode( $purpose );

		//truncating to maximum length allowed by SagePay Form
		if ( strlen( $purpose ) > 127 ) {
			$purpose = substr( $purpose, 0, 124 ) . '...';
		}

		$query_string = "&amount={$payment_amount}&desc={$purpose}";

		//save payment amount to lead meta
		gform_update_meta( $entry_id, 'payment_amount', $payment_amount );

		//return $payment_amount > 0 ? $query_string : false;
		return $payment_amount > 0 ? $payment_amount : false;

	}

	public function get_subscription_query_string( $feed, $submission_data, $entry_id ) {

		if ( empty( $submission_data ) ) {
			return false;
		}

		$query_string         = '';
		$payment_amount       = rgar( $submission_data, 'payment_amount' );
		$setup_fee            = rgar( $submission_data, 'setup_fee' );
		$trial_enabled        = rgar( $feed['meta'], 'trial_enabled' );
		$line_items           = rgar( $submission_data, 'line_items' );
		$discounts            = rgar( $submission_data, 'discounts' );
		$recurring_field      = rgar( $submission_data, 'payment_amount' ); //will be field id or the text 'form_total'
		$product_index        = 1;
		$shipping             = '';
		$discount_amt         = 0;
		$cmd                  = 'regular';
		$extra_qs             = '';
		$name_without_options = '';
		$item_name            = '';

		//work on products
		if ( is_array( $line_items ) ) {
			foreach ( $line_items as $item ) {
				$product_id     = $item['id'];
				$product_name   = $item['name'];
				$quantity       = $item['quantity'];
				$quantity_label = $quantity > 1 ? $quantity . ' ' : '';

				$unit_price  = $item['unit_price'];
				$options     = rgar( $item, 'options' );
				$product_id  = $item['id'];
				$is_shipping = rgar( $item, 'is_shipping' );

				$product_options = '';
				if ( ! $is_shipping ) {
					//add options

					if ( ! empty( $options ) && is_array( $options ) ) {
						$product_options = ' (';
						foreach ( $options as $option ) {
							$product_options .= $option['option_name'] . ', ';
						}
						$product_options = substr( $product_options, 0, strlen( $product_options ) - 2 ) . ')';
					}

					$item_name .= $quantity_label . $product_name . $product_options . ', ';
					$name_without_options .= $product_name . ', ';
				}
			}

			//look for discounts to pass in the item_name
			if ( is_array( $discounts ) ) {
				foreach ( $discounts as $discount ) {
					$product_name   = $discount['name'];
					$quantity       = $discount['quantity'];
					$quantity_label = $quantity > 1 ? $quantity . ' ' : '';
					$item_name .= $quantity_label . $product_name . ' (), ';
					$name_without_options .= $product_name . ', ';
				}
			}

			if ( ! empty( $item_name ) ) {
				$item_name = substr( $item_name, 0, strlen( $item_name ) - 2 );
			}

			//if name is larger than max, remove options from it.
			if ( strlen( $item_name ) > 127 ) {
				$item_name = substr( $name_without_options, 0, strlen( $name_without_options ) - 2 );

				//truncating name to maximum allowed size
				if ( strlen( $item_name ) > 127 ) {
					$item_name = substr( $item_name, 0, 124 ) . '...';
				}
			}
			$item_name = urlencode( $item_name );

		}

		$subscription_installments = rgar( $feed['meta'], 'recurringTimes' );
		$trial = '';
		//see if a trial exists
		if ( $trial_enabled ) {
			$trial_amount        = rgar( $submission_data, 'trial' ) ? rgar( $submission_data, 'trial' ) : 0;
			$trial_period_number = rgar( $feed['meta'], 'trialPeriod_length' );
			$trial_period_type   = $this->convert_interval( rgar( $feed['meta'], 'trialPeriod_unit' ), 'char' );
			$trial               = "&initialAmount={$trial_amount}&startDelayMult={$trial_period_number}&startDelayUnit={$trial_period_type}";
		}else{
			$subscription_installments--;
			$trial               = "&amount={$payment_amount}&startDelayMult=1&startDelayUnit=1";

			if( $subscription_installments == '-1'){

				$subscription_installments = '0';

			}
		}

		//check for recurring times
		$recurring_times = $subscription_installments ? '&noOfPayments=' . $subscription_installments : '';
		$recurring_retry = rgar( $feed['meta'], 'recurringRetry' ) ? '1' : '0';

		$billing_cycle_number = rgar( $feed['meta'], 'billingCycle_length' );
		$billing_cycle_type   = $this->convert_interval( rgar( $feed['meta'], 'billingCycle_unit' ), 'char' );

		$query_string = "&option=0&futurePayType={$cmd}&item_name={$item_name}{$trial}&normalAmount={$payment_amount}&MC_normalAmount={$payment_amount}&intervalMult={$billing_cycle_number}&intervalUnit={$billing_cycle_type}&{$recurring_times}";

		//save payment amount to lead meta
		gform_update_meta( $entry_id, 'payment_amount', $payment_amount );

		return $payment_amount > 0 ? $query_string : false;

	}

	public function customer_query_string( $feed, $lead ) {
		$fields = array();
        $first_name = "";
        $last_name = "";
		foreach ( $this->get_customer_fields() as $field ) {
			$field_id = $feed['meta'][ $field['meta_name'] ];
			$value    = rgar( $lead, $field_id );

			if ( $field['name'] == 'country' ) {
				$value = GFCommon::get_country_code( $value );
			} else if ( $field['name'] == 'state' ) {
				$value = GFCommon::get_us_state_code( $value );
			}

			$fields[$field['name']] = $value;

		}

		return $fields;
	}

	public function return_url( $form_id, $lead_id ) {
		$pageURL = GFCommon::is_ssl() ? 'https://' : 'http://';

		if ( $_SERVER['SERVER_PORT'] != '80' ) {
			$pageURL .= $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . $_SERVER['REQUEST_URI'];
		} else {
			$pageURL .= $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
		}

		$ids_query = "ids={$form_id}|{$lead_id}";
		$ids_query .= '&hash=' . wp_hash( $ids_query );

		return add_query_arg( 'gf_sagepay_form_return', base64_encode( $ids_query ), $pageURL );
	}

	public static function maybe_thankyou_page() {
		$instance = self::get_instance();

		if ( ! $instance->is_gravityforms_supported() ) {
			return;
		}

		if ( $str = rgget( 'gf_sagepay_form_return' ) ) {
			$str = base64_decode( $str );

			parse_str( $str, $query );
			if ( wp_hash( 'ids=' . $query['ids'] ) == $query['hash'] ) {
				list( $form_id, $lead_id ) = explode( '|', $query['ids'] );

				$form = GFAPI::get_form( $form_id );
				$lead = GFAPI::get_entry( $lead_id );

				if ( ! class_exists( 'GFFormDisplay' ) ) {
					require_once( GFCommon::get_base_path() . '/form_display.php' );
				}

				$confirmation = GFFormDisplay::handle_confirmation( $form, $lead, false );

				if ( is_array( $confirmation ) && isset( $confirmation['redirect'] ) ) {
					header( "Location: {$confirmation['redirect']}" );
					exit;
				}

				GFFormDisplay::$submission[ $form_id ] = array( 'is_confirmation' => true, 'confirmation_message' => $confirmation, 'form' => $form, 'lead' => $lead );
			}
		}
	}

	public function get_customer_fields() {
		return array(
			array( 'name' => 'first_name', 'label' => 'First Name', 'meta_name' => 'billingInformation_firstName' ),
			array( 'name' => 'last_name', 'label' => 'Last Name', 'meta_name' => 'billingInformation_lastName' ),
			array( 'name' => 'email', 'label' => 'Email', 'meta_name' => 'billingInformation_email' ),
			array( 'name' => 'address1', 'label' => 'Address', 'meta_name' => 'billingInformation_address' ),
			array( 'name' => 'address2', 'label' => 'Address 2', 'meta_name' => 'billingInformation_address2' ),
			array( 'name' => 'town', 'label' => 'City', 'meta_name' => 'billingInformation_city' ),
			array( 'name' => 'region', 'label' => 'State', 'meta_name' => 'billingInformation_state' ),
			array( 'name' => 'postcode', 'label' => 'Zip', 'meta_name' => 'billingInformation_zip' ),
			array( 'name' => 'country', 'label' => 'Country', 'meta_name' => 'billingInformation_country' ),
			array( 'name' => 'phone', 'label' => 'Phone', 'meta_name' => 'billingInformation_phone' ),
		);
	}

	public function convert_interval( $interval, $to_type ) {
		//convert single character into long text for new feed settings or convert long text into single character for sending to sagepay
		//$to_type: text (change character to long text), OR char (change long text to character)
		if ( empty( $interval ) ) {
			return '';
		}

		$new_interval = '';
		if ( $to_type == 'text' ) {
			//convert single char to text
			switch ( strtoupper( $interval ) ) {
				case '1' :
					$new_interval = 'day';
					break;
				case '2' :
					$new_interval = 'week';
					break;
				case '3' :
					$new_interval = 'month';
					break;
				case '4' :
					$new_interval = 'year';
					break;
				default :
					$new_interval = $interval;
					break;
			}
		} else {
			//convert text to single char
			switch ( strtolower( $interval ) ) {
				case 'day' :
					$new_interval = '1';
					break;
				case 'week' :
					$new_interval = '2';
					break;
				case 'month' :
					$new_interval = '3';
					break;
				case 'year' :
					$new_interval = '4';
					break;
				default :
					$new_interval = $interval;
					break;
			}
		}

		return $new_interval;
	}

	public function delay_post( $is_disabled, $form, $entry ) {

		$feed = $this->get_payment_feed( $entry );
		$submission_data = $this->get_submission_data( $feed, $form, $entry );

		if ( ! $feed || empty( $submission_data['payment_amount'] ) ){
			return $is_disabled;
		}

		return ! rgempty( 'delayPost', $feed['meta'] );
	}

	public function delay_notification( $is_disabled, $notification, $form, $entry ){

		$feed = $this->get_payment_feed( $entry );
		$submission_data = $this->get_submission_data( $feed, $form, $entry );

		if ( ! $feed || empty( $submission_data['payment_amount'] ) ){
			return $is_disabled;
		}

		$selected_notifications = is_array( rgar( $feed['meta'], 'selectedNotifications' ) ) ? rgar( $feed['meta'], 'selectedNotifications' ) : array();

		return isset( $feed['meta']['delayNotification'] ) && in_array( $notification['id'], $selected_notifications ) ? true : $is_disabled;
	}



	public function callback() {

		if ( ! $this->is_gravityforms_supported() ) {
			return false;
		}

		if( isset($_GET['VPSProtocol']) ){
			unset($_GET['page']);

			$settings = $this->get_plugin_settings();

	        //Getting Url (Live or Sandbox)
			if( $settings['mode'] != 'live' ){
				$redirect_url = 'https://test.sagepay.com/gateway/service/vspform-register.vsp';
			}else{
				$redirect_url = 'https://live.sagepay.com/gateway/service/vspform-register.vsp';
			}

			$sagepay_arg_array = array();

			foreach ($_GET as $key => $value) {
				$sagepay_arg_array[] = '<input type="hidden" name="'.esc_attr( $key ).'" value="'.esc_attr( $value ).'" />';
			}

	           echo '<!DOCTYPE html>
						<html>
						<head>
						<script>
							window.onload = function(e){
								 document.getElementById("sagepay_payment_form").submit();
							}
						</script>
						</head>
						<body>
							<form action="'.$redirect_url.'" method="post" name="sagepay_payment_form" target="_self"  id="sagepay_payment_form" >
								' . implode('', $sagepay_arg_array) . '
								<b> Please wait while you are being redirected.</b>
							</form>
						</body>
						</html>';

			exit;

		}


		$this->log_debug( 'IPN request received. Starting to process...' );

		$transaction_response = $this->decode(str_replace(' ', '+',$_REQUEST['crypt']));

		$this->log_debug( print_r( $transaction_response, true ) );

        list($entry_id, $hash) = explode("-", $transaction_response['VendorTxCode']);

		//------ Getting entry related to this IPN ----------------------------------------------//
		$entry = $this->get_entry( $entry_id . '|' . $hash );

		//Ignore orphan IPN messages (ones without an entry)
		if ( ! $entry ) {
			$this->log_error( 'Entry could not be found. Entry ID: ' . $entry['id'] . '. Aborting.' );

			return false;
		}
		$this->log_debug( 'Entry has been found.' . print_r( $entry, true ) );


		//------ Getting feed related to this IPN ------------------------------------------//
		$feed = $this->get_payment_feed( $entry );

		//Ignore IPN messages from forms that are no longer configured with the SagePay Form add-on
		if ( ! $feed || ! rgar( $feed, 'is_active' ) ) {
			$this->log_error( "Form no longer is configured with SagePay Form Addon. Form ID: {$entry['form_id']}. Aborting." );

			return false;
		}

		$this->log_debug( "Form {$entry['form_id']} is properly configured." );

		$txn_type = 'normal';

		//----- Processing IPN ------------------------------------------------------------//
		$this->log_debug( 'Processing IPN...' );
		$action = $this->process_ipn( $feed, $entry, $transaction_response['Status'], $txn_type, $transaction_response['VendorTxCode'], $transaction_response['VendorTxCode'], rgpost( 'futurePayId' ), $transaction_response['Amount'], rgpost( 'pending_reason' ), rgpost( 'reason_code' ), $transaction_response['Amount'] );
		$this->log_debug( 'IPN processing complete.' );


		if ( rgempty( 'entry_id', $action ) ) {
			return false;
		}

		//return $action;

	}

	public function get_payment_feed( $entry, $form = false ){

		$feed = parent::get_payment_feed( $entry, $form );

		if ( empty( $feed ) && ! empty($entry['id']) ){
			//looking for feed created by legacy versions
			$feed = $this->get_sagepay_form_feed_by_entry( $entry['id'] );
		}

		$feed = apply_filters( 'gform_sagepay_form_get_payment_feed', $feed, $entry, $form );

		return $feed;
	}

	private function get_sagepay_form_feed_by_entry( $entry_id ) {

		$feed_id = gform_get_meta( $entry_id, 'sagepay_feed_id' );
		$feed = $this->get_feed( $feed_id );

		return ! empty( $feed ) ? $feed : false;
	}
/*
	public function post_callback( $callback_action, $callback_result ) {
		if ( ! $callback_action ){
			return false;
		}

		if(rgpost("transStatus") == 'Y'){
			$payment_status = 'completed';
		}else{
			$payment_status = 'failed';
		}

		if(rgpost("futurePayId") == ''){
			$txn_type = 'normal';
		}else{
			$txn_type = 'subscr_payment';
		}

		//run the necessary hooks
		$entry          = GFAPI::get_entry( $callback_action['entry_id'] );
		$feed           = $this->get_payment_feed( $entry );
		$transaction_id = rgar( $callback_action, 'transaction_id' );
		$amount         = rgar( $callback_action, 'amount' );
		$subscriber_id  = rgar( $callback_action, 'subscriber_id' );
		$pending_reason = rgpost( 'pending_reason' );
		$reason         = rgpost( 'reason_code' );
		$status         = $payment_status;
		$txn_type       = $txn_type;
		$parent_txn_id  = $transaction_id;

		//run gform_sagepay_form_fulfillment only in certain conditions
		if ( rgar( $callback_action, 'ready_to_fulfill' ) && ! rgar( $callback_action, 'abort_callback' ) ) {
			$this->fulfill_order( $entry, $transaction_id, $amount, $feed );
		}
		else {
			if ( rgar( $callback_action, 'abort_callback' ) ){
				$this->log_debug( 'Callback processing was aborted. Not fulfilling entry.' );
			}
			else {
				$this->log_debug( 'Entry is already fulfilled or not ready to be fulfilled, not running gform_sagepay_form_fulfillment hook.' );
			}
		}

		$this->log_debug( 'Before gform_post_payment_status.' );
		do_action( 'gform_post_payment_status', $feed, $entry, $status, $transaction_id, $subscriber_id, $amount, $pending_reason, $reason );
		$this->log_debug( 'After gform_post_payment_status.' );

		$this->log_debug( 'Before gform_sagepay_form_ipn_' . $txn_type );
		do_action( 'gform_sagepay_form_ipn_' . $txn_type, $entry, $feed, $status, $txn_type, $transaction_id, $parent_txn_id, $subscriber_id, $amount, $pending_reason, $reason );
		$this->log_debug( 'After gform_sagepay_form_ipn_' . $txn_type );

		$this->log_debug( 'Before gform_sagepay_form_post_ipn.' );
		do_action( 'gform_sagepay_form_post_ipn', $_POST, $entry, $feed, false );
		$this->log_debug( 'After gform_sagepay_form_post_ipn.' );
	}
*/
	private function process_ipn( $config, $entry, $status, $transaction_type, $transaction_id, $parent_transaction_id, $subscriber_id, $amount, $pending_reason, $reason, $recurring_amount ) {
		$this->log_debug( "Payment status: {$status} - Transaction Type: {$transaction_type} - Transaction ID: {$transaction_id} - Parent Transaction: {$parent_transaction_id} - Subscriber ID: {$subscriber_id} - Amount: {$amount} - Pending reason: {$pending_reason} - Reason: {$reason}" );

		$action = array();

		//handles products and donation
		switch ( $status ) {
		    case "OK" :
		    case "AUTHENTICATED" :
		    case "REGISTERED" :
				//creates transaction
				$action['id']               = $transaction_id;
				$action['type']             = 'complete_payment';
				$action['transaction_id']   = $transaction_id;
				$action['amount']           = $amount;
				$action['entry_id']         = $entry['id'];
				$action['payment_date']     = gmdate( 'y-m-d H:i:s' );
				$action['payment_method']	= 'SagePay Form';
				$action['ready_to_fulfill'] = ! $entry['is_fulfilled'] ? true : false;


				$this->log_debug( "I have made it here..." );


				$this->fulfill_order( $entry, $transaction_id, $amount );

				// Custom thank you email
				ph_send_donation_email('complete', $action['transaction_id'], $entry, $action['amount']);

				//update lead, add a note
				GFAPI::update_entry( $entry );


				if ( ! $this->is_valid_initial_payment_amount( $entry['id'], $amount ) ){
					//create note and transaction
					$this->log_debug( 'Payment amount does not match product price. Entry will not be marked as Approved.' );
					GFPaymentAddOn::add_note( $entry['id'], sprintf( __( 'Payment amount (%s) does not match product price. Entry will not be marked as Approved. Transaction Id: %s', 'gravityforms-sagepay-form' ), GFCommon::to_money( $amount, $entry['currency'] ), $transaction_id ) );
					GFPaymentAddOn::insert_transaction( $entry['id'], 'payment', $transaction_id, $amount );

					$action['abort_callback'] = true;
				}else{

					GFPaymentAddOn::insert_transaction( $entry['id'], 'payment', $transaction_id, $amount );
				}


				$this->complete_payment( $entry, $action );

		    $redirect_url = !empty($config["meta"]["successUrl"]) ? $config["meta"]["successUrl"] : home_url();
				wp_redirect($redirect_url);
				exit;

				return $action;
				break;

			case 'PENDING' :
				$action['id']             = $transaction_id;
				$action['type']           = 'add_pending_payment';
				$action['transaction_id'] = $transaction_id;
				$action['entry_id']       = $entry['id'];
				$action['amount']         = $amount;
				$action['entry_id']       = $entry['id'];
				$amount_formatted         = GFCommon::to_money( $action['amount'], $entry['currency'] );
				$action['note']           = sprintf( __( 'Payment is pending. Amount: %s. Transaction Id: %s. Reason: %s', 'gravityforms-sagepay-form' ), $amount_formatted, $action['transaction_id'], $this->get_pending_reason( $pending_reason ) );

		        $redirect_url = !empty($config["meta"]["successUrl"]) ? $config["meta"]["successUrl"] : home_url();
				wp_redirect($redirect_url);
				exit;

				return $action;
				break;

		    case "FAILED" :
		    case "ABORT" :
				$transaction_response = $this->decode(str_replace(' ', '+',$_REQUEST['crypt']));
				$StatusDetail = $transaction_response['StatusDetail'];

				$action['id']             = $transaction_id;
				$action['type']           = 'fail_payment';
				$action['transaction_id'] = $transaction_id;
				$action['entry_id']       = $entry['id'];
				$action['amount']         = $amount;

				//update lead, add a note
				GFAPI::update_entry( $entry );


				if(!empty($StatusDetail)){
					GFPaymentAddOn::add_note( $entry['id'], sprintf(__("Payment has Failed. Message : %s  Transaction Id : %s", "gravityforms-sagepay-form"), $StatusDetail, $transaction_id) );

				}else{

					GFPaymentAddOn::add_note( $entry['id'], sprintf(__("Payment has Failed. Failed payments occur when they are made via your customer's bank account and could not be completed. Transaction Id: %s", "gravityforms-sagepay-form"), $transaction_id) );

				}

			  $redirect_url = !empty($config["meta"]["cancelUrl"]) ? $config["meta"]["cancelUrl"] : home_url();
				wp_redirect($redirect_url);
				exit;

				return $action;
				break;
		}

	}

	public function get_entry( $custom_field ) {

		//Valid IPN requests must have a custom field
		if ( empty( $custom_field ) ) {
			$this->log_error( 'IPN request does not have a custom field, so it was not created by Gravity Forms. Aborting.' );

			return false;
		}

		//Getting entry associated with this IPN message (entry id is sent in the 'custom' field)
		list( $entry_id, $hash ) = explode( '|', $custom_field );
		$hash_matches = wp_hash( $entry_id ) == $hash;

		//allow the user to do some other kind of validation of the hash
		$hash_matches = apply_filters( 'gform_sagepay_form_hash_matches', $hash_matches, $entry_id, $hash, $custom_field );

		//Validates that Entry Id wasn't tampered with
		if ( ! rgpost( 'test_ipn' ) && ! $hash_matches ) {
			$this->log_error( "Entry Id verification failed. Hash does not match. Custom field: {$custom_field}. Aborting." );

			return false;
		}

		$this->log_debug( "IPN message has a valid custom field: {$custom_field}" );

		$entry = GFAPI::get_entry( $entry_id );

		return $entry;
	}

	public function cancel_subscription( $entry, $feed, $note = null ) {

		parent::cancel_subscription( $entry, $feed, $note );

		$this->modify_post( rgar( $entry, 'post_id' ), rgars( $feed, 'meta/update_post_action' ) );

		return true;
	}

	public function modify_post( $post_id, $action ) {

		$result = false;

		if ( ! $post_id ){
			return $result;
		}

		switch ( $action ) {
			case 'draft':
				$post = get_post( $post_id );
				$post->post_status = 'draft';
				$result = wp_update_post( $post );
				$this->log_debug( "Set post (#{$post_id}) status to \"draft\"." );
				break;
			case 'delete':
				$result = wp_delete_post( $post_id );
				$this->log_debug( "Deleted post (#{$post_id})." );
				break;
		}

		return $result;
	}

	private function get_reason( $code ) {

		switch ( strtolower( $code ) ) {
			case 'adjustment_reversal':
				return __( 'Reversal of an adjustment', 'gravityforms-sagepay-form' );
			case 'buyer-complaint':
				return __( 'A reversal has occurred on this transaction due to a complaint about the transaction from your customer.', 'gravityforms-sagepay-form' );

			case 'chargeback':
				return __( 'A reversal has occurred on this transaction due to a chargeback by your customer.', 'gravityforms-sagepay-form' );

			case 'chargeback_reimbursement':
				return __( 'Reimbursement for a chargeback.', 'gravityforms-sagepay-form' );

			case 'chargeback_settlement':
				return __( 'Settlement of a chargeback.', 'gravityforms-sagepay-form' );

			case 'guarantee':
				return __( 'A reversal has occurred on this transaction due to your customer triggering a money-back guarantee.', 'gravityforms-sagepay-form' );

			case 'other':
				return __( 'Non-specified reason.', 'gravityforms-sagepay-form' );

			case 'refund':
				return __( 'A reversal has occurred on this transaction because you have given the customer a refund.', 'gravityforms-sagepay-form' );

			default:
				return empty( $code ) ? __( 'Reason has not been specified. For more information, contact SagePay Form Customer Service.', 'gravityforms-sagepay-form' ) : $code;
		}
	}

	public function is_callback_valid() {
		if ( rgget( 'page' ) != 'gf_sagepay_form_ipn' ) {
			return false;
		}

		return true;
	}

	private function get_pending_reason( $code ) {
		switch ( strtolower( $code ) ) {
			case 'address':
				return __( 'The payment is pending because your customer did not include a confirmed shipping address and your Payment Receiving Preferences is set to allow you to manually accept or deny each of these payments. To change your preference, go to the Preferences section of your Profile.', 'gravityforms-sagepay-form' );

			case 'authorization':
				return __( 'You set the payment action to Authorization and have not yet captured funds.', 'gravityforms-sagepay-form' );

			case 'echeck':
				return __( 'The payment is pending because it was made by an eCheck that has not yet cleared.', 'gravityforms-sagepay-form' );

			case 'intl':
				return __( 'The payment is pending because you hold a non-U.S. account and do not have a withdrawal mechanism. You must manually accept or deny this payment from your Account Overview.', 'gravityforms-sagepay-form' );

			case 'multi-currency':
				return __( 'You do not have a balance in the currency sent, and you do not have your Payment Receiving Preferences set to automatically convert and accept this payment. You must manually accept or deny this payment.', 'gravityforms-sagepay-form' );

			case 'order':
				return __( 'You set the payment action to Order and have not yet captured funds.', 'gravityforms-sagepay-form' );

			case 'paymentreview':
				return __( 'The payment is pending while it is being reviewed by SagePay Form for risk.', 'gravityforms-sagepay-form' );

			case 'unilateral':
				return __( 'The payment is pending because it was made to an email address that is not yet registered or confirmed.', 'gravityforms-sagepay-form' );

			case 'upgrade':
				return __( 'The payment is pending because it was made via credit card and you must upgrade your account to Business or Premier status in order to receive the funds. upgrade can also mean that you have reached the monthly limit for transactions on your account.', 'gravityforms-sagepay-form' );

			case 'verify':
				return __( 'The payment is pending because you are not yet verified. You must verify your account before you can accept this payment.', 'gravityforms-sagepay-form' );

			case 'other':
				return __( 'Reason has not been specified. For more information, contact SagePay Form Customer Service.', 'gravityforms-sagepay-form' );

			default:
				return empty( $code ) ? __( 'Reason has not been specified. For more information, contact SagePay Form Customer Service.', 'gravityforms-sagepay-form' ) : $code;
		}
	}

	//------- AJAX FUNCTIONS ------------------//

	public function init_ajax(){

		parent::init_ajax();

		add_action( 'wp_ajax_gf_dismiss_sagepay_form_menu', array( $this, 'ajax_dismiss_menu' ) );

	}

	//------- ADMIN FUNCTIONS/HOOKS -----------//

	public function init_admin() {

		parent::init_admin();

		$this->ensure_copy_feeds();

		//add actions to allow the payment status to be modified
		add_action( 'gform_payment_status', array( $this, 'admin_edit_payment_status' ), 3, 3 );

		if ( version_compare( GFCommon::$version, '1.8.17.4', '<' ) ){
			//using legacy hook
			add_action( 'gform_entry_info', array( $this, 'admin_edit_payment_status_details' ), 4, 2 );
		}
		else {
			add_action( 'gform_payment_date', array( $this, 'admin_edit_payment_date' ), 3, 3 );
			add_action( 'gform_payment_transaction_id', array( $this, 'admin_edit_payment_transaction_id' ), 3, 3 );
			add_action( 'gform_payment_amount', array( $this, 'admin_edit_payment_amount' ), 3, 3 );
		}

		add_action( 'gform_after_update_entry', array( $this, 'admin_update_payment' ), 4, 2 );

		//add_filter( 'gform_addon_navigation', array( $this, 'maybe_create_menu' ) );
	}

	public function maybe_create_menu( $menus ){
		$current_user = wp_get_current_user();
		$dismiss_sagepay_form_menu = get_metadata( 'user', $current_user->ID, 'dismiss_sagepay_form_menu', true );
		if ( $dismiss_sagepay_form_menu != '1' ){
			$menus[] = array( 'name' => $this->_slug, 'label' => $this->get_short_title(), 'callback' => array( $this, 'temporary_plugin_page' ), 'permission' => $this->_capabilities_form_settings );
		}

		return $menus;
	}

	public function ajax_dismiss_menu(){

		$current_user = wp_get_current_user();
		update_metadata( 'user', $current_user->ID, 'dismiss_sagepay_form_menu', '1' );
	}

	public function temporary_plugin_page(){
		$current_user = wp_get_current_user();
		?>
		<script type="text/javascript">
			function dismissMenu(){
				jQuery('#gf_spinner').show();
				jQuery.post(ajaxurl, {
						action : "gf_dismiss_sagepay_form_menu"
					},
					function (response) {
						document.location.href='?page=gf_edit_forms';
						jQuery('#gf_spinner').hide();
					}
				);

			}
		</script>

		<div class="wrap about-wrap">
			<h1><?php _e( 'SagePay Form Add-On v2.0', 'gravityforms-sagepay-form' ) ?></h1>
			<div class="about-text"><?php _e( 'Thank you for updating! The new version of the Gravity Forms SagePay Form Add-On makes changes to how you manage your SagePay Form integration.', 'gravityforms-sagepay-form' ) ?></div>
			<div class="changelog">
				<hr/>
				<div class="feature-section col two-col">
					<div class="col-1">
						<h3><?php _e( 'Manage SagePay Form Contextually', 'gravityforms-sagepay-form' ) ?></h3>
						<p><?php _e( 'SagePay Form Feeds are now accessed via the SagePay Form sub-menu within the Form Settings for the Form you would like to integrate SagePay Form with.', 'gravityforms-sagepay-form' ) ?></p>
					</div>
					<div class="col-2 last-feature">
						<img src="http://gravityforms.s3.amazonaws.com/webimages/SagePay FormNotice/NewSagePay Form2.png">
					</div>
				</div>

				<hr/>

				<form method="post" id="dismiss_menu_form" style="margin-top: 20px;">
					<input type="checkbox" name="dismiss_sagepay_form_menu" value="1" onclick="dismissMenu();"> <label><?php _e( 'I understand this change, dismiss this message!', 'gravityforms-sagepay-form' ) ?></label>
					<img id="gf_spinner" src="<?php echo GFCommon::get_base_url() . '/images/spinner.gif'?>" alt="<?php _e( 'Please wait...', 'gravityforms-sagepay-form' ) ?>" style="display:none;"/>
				</form>

			</div>
		</div>
		<?php
	}

	public function admin_edit_payment_status( $payment_status, $form, $lead ) {
		//allow the payment status to be edited when for sagepay, not set to Approved/Paid, and not a subscription
		if ( ! $this->is_payment_gateway( $lead['id'] ) || strtolower( rgpost( 'save' ) ) <> 'edit' || $payment_status == 'Approved' || $payment_status == 'Paid' || rgar( $lead, 'transaction_type' ) == 2 ) {
			return $payment_status;
		}

		//create drop down for payment status
		$payment_string = gform_tooltip( 'sagepay_edit_payment_status', '', true );
		$payment_string .= '<select id="payment_status" name="payment_status">';
		$payment_string .= '<option value="' . $payment_status . '" selected>' . $payment_status . '</option>';
		$payment_string .= '<option value="Paid">Paid</option>';
		$payment_string .= '</select>';

		return $payment_string;
	}

	public function admin_edit_payment_date( $payment_date, $form, $lead ) {
		//allow the payment status to be edited when for sagepay, not set to Approved/Paid, and not a subscription
		if ( ! $this->is_payment_gateway( $lead['id'] ) || strtolower( rgpost( 'save' ) ) <> 'edit' ) {
			return $payment_date;
		}

		$payment_date = $lead['payment_date'];
		if ( empty( $payment_date ) ) {
			$payment_date = gmdate( 'y-m-d H:i:s' );
		}

		$input = '<input type="text" id="payment_date" name="payment_date" value="' . $payment_date . '">';

		return $input;
	}

	public function admin_edit_payment_transaction_id( $transaction_id, $form, $lead ) {
		//allow the payment status to be edited when for sagepay, not set to Approved/Paid, and not a subscription
		if ( ! $this->is_payment_gateway( $lead['id'] ) || strtolower( rgpost( 'save' ) ) <> 'edit' ) {
			return $transaction_id;
		}

		$input = '<input type="text" id="sagepay_transaction_id" name="sagepay_transaction_id" value="' . $transaction_id . '">';

		return $input;
	}

	public function admin_edit_payment_amount( $payment_amount, $form, $lead ) {

		//allow the payment status to be edited when for sagepay, not set to Approved/Paid, and not a subscription
		if ( ! $this->is_payment_gateway( $lead['id'] ) || strtolower( rgpost( 'save' ) ) <> 'edit' ) {
			return $payment_amount;
		}

		if ( empty( $payment_amount ) ) {
			$payment_amount = GFCommon::get_order_total( $form, $lead );
		}

		$input = '<input type="text" id="payment_amount" name="payment_amount" class="gform_currency" value="' . $payment_amount . '">';

		return $input;
	}


	public function admin_edit_payment_status_details( $form_id, $lead ) {

		$form_action = strtolower( rgpost( 'save' ) );
		if ( ! $this->is_payment_gateway( $lead['id'] ) || $form_action <> 'edit' ) {
			return;
		}

		//get data from entry to pre-populate fields
		$payment_amount = rgar( $lead, 'payment_amount' );
		if ( empty( $payment_amount ) ) {
			$form           = GFFormsModel::get_form_meta( $form_id );
			$payment_amount = GFCommon::get_order_total( $form, $lead );
		}
		$transaction_id = rgar( $lead, 'transaction_id' );
		$payment_date   = rgar( $lead, 'payment_date' );
		if ( empty( $payment_date ) ) {
			$payment_date = gmdate( 'y-m-d H:i:s' );
		}

		//display edit fields
		?>
		<div id="edit_payment_status_details" style="display:block">
			<table>
				<tr>
					<td colspan="2"><strong>Payment Information</strong></td>
				</tr>

				<tr>
					<td>Date:<?php gform_tooltip( 'sagepay_edit_payment_date' ) ?></td>
					<td>
						<input type="text" id="payment_date" name="payment_date" value="<?php echo $payment_date ?>">
					</td>
				</tr>
				<tr>
					<td>Amount:<?php gform_tooltip( 'sagepay_edit_payment_amount' ) ?></td>
					<td>
						<input type="text" id="payment_amount" name="payment_amount" class="gform_currency" value="<?php echo $payment_amount ?>">
					</td>
				</tr>
				<tr>
					<td nowrap>Transaction ID:<?php gform_tooltip( 'sagepay_edit_payment_transaction_id' ) ?></td>
					<td>
						<input type="text" id="sagepay_transaction_id" name="sagepay_transaction_id" value="<?php echo $transaction_id ?>">
					</td>
				</tr>
			</table>
		</div>
	<?php
	}

	public function admin_update_payment( $form, $lead_id ) {
		check_admin_referer( 'gforms_save_entry', 'gforms_save_entry' );

		//update payment information in admin, need to use this function so the lead data is updated before displayed in the sidebar info section
		$form_action = strtolower( rgpost( 'save' ) );
		if ( ! $this->is_payment_gateway( $lead_id ) || $form_action <> 'update' ) {
			return;
		}
		//get lead
		$lead = GFFormsModel::get_lead( $lead_id );

        //check if current payment status is processing
        if($lead['payment_status'] != 'Processing')
            return;

		//get payment fields to update
		$payment_status = rgpost( 'payment_status' );
		//when updating, payment status may not be editable, if no value in post, set to lead payment status
		if ( empty( $payment_status ) ) {
			$payment_status = $lead['payment_status'];
		}

		$payment_amount      = GFCommon::to_number( rgpost( 'payment_amount' ) );
		$payment_transaction = rgpost( 'sagepay_transaction_id' );
		$payment_date        = rgpost( 'payment_date' );
		if ( empty( $payment_date ) ) {
			$payment_date = gmdate( 'y-m-d H:i:s' );
		} else {
			//format date entered by user
			$payment_date = date( 'Y-m-d H:i:s', strtotime( $payment_date ) );
		}

		global $current_user;
		$user_id   = 0;
		$user_name = 'System';
		if ( $current_user && $user_data = get_userdata( $current_user->ID ) ) {
			$user_id   = $current_user->ID;
			$user_name = $user_data->display_name;
		}

		$lead['payment_status'] = $payment_status;
		$lead['payment_amount'] = $payment_amount;
		$lead['payment_date']   = $payment_date;
		$lead['transaction_id'] = $payment_transaction;

		// if payment status does not equal approved/paid or the lead has already been fulfilled, do not continue with fulfillment
		if ( ( $payment_status == 'Approved' || $payment_status == 'Paid' ) && ! $lead['is_fulfilled'] ) {
			$action['id']               = $payment_transaction;
			$action['type']             = 'complete_payment';
			$action['transaction_id']   = $payment_transaction;
			$action['amount']           = $payment_amount;
			$action['entry_id']         = $lead['id'];

			$this->complete_payment( $lead, $action );
			$this->fulfill_order( $lead, $payment_transaction, $payment_amount );
		}
		//update lead, add a note
		GFAPI::update_entry( $lead );
		GFFormsModel::add_note( $lead['id'], $user_id, $user_name, sprintf( __( 'Payment information was manually updated. Status: %s. Amount: %s. Transaction Id: %s. Date: %s', 'gravityforms-sagepay-form' ), $lead['payment_status'], GFCommon::to_money( $lead['payment_amount'], $lead['currency'] ), $payment_transaction, $lead['payment_date'] ) );
	}

	public function fulfill_order( &$entry, $transaction_id, $amount, $feed = null ) {

		if ( ! $feed ) {
			$feed = $this->get_payment_feed( $entry );
		}

		$form = GFFormsModel::get_form_meta( $entry['form_id'] );
		if ( rgars( $feed, 'meta/delayPost' ) ) {
			$this->log_debug( 'Creating post.' );
			$entry['post_id'] = GFFormsModel::create_post( $form, $entry );
			$this->log_debug( 'Post created.' );
		}

		if ( rgars( $feed, 'meta/delayNotification' ) ) {
			//sending delayed notifications
			$notifications = rgars( $feed, 'meta/selectedNotifications' );
			// Commented out as using custom mail instead
			//GFCommon::send_notifications( $notifications, $form, $entry, true, 'form_submission' );
		}

		$this->log_debug( 'Before gform_sagepay_form_fulfillment.' );
		do_action( 'gform_sagepay_form_fulfillment', $entry, $feed, $transaction_id, $amount );
		$this->log_debug( 'After gform_sagepay_form_fulfillment.' );


	}

	private function is_valid_initial_payment_amount( $entry_id, $amount_paid ){

		//get amount initially sent to sagepay
		$amount_sent = gform_get_meta( $entry_id, 'payment_amount' );
		if ( empty( $amount_sent ) ){
			return true;
		}

		$epsilon = 0.00001;
		$is_equal = abs( floatval( $amount_paid ) - floatval( $amount_sent ) ) < $epsilon;
		$is_greater = floatval( $amount_paid ) > floatval( $amount_sent );

		//initial payment is valid if it is equal to or greater than product/subscription amount
		if ( $is_equal || $is_greater ){
			return true;
		}

		return false;

	}

	public function sagepay_fulfillment( $entry, $sagepay_config, $transaction_id, $amount ) {
		//no need to do anything for sagepay when it runs this function, ignore
		return false;
	}

	//------ FOR BACKWARDS COMPATIBILITY ----------------------//

	//Change data when upgrading from legacy sagepay
	public function upgrade( $previous_version ) {

		$previous_is_pre_addon_framework = version_compare( $previous_version, '2.0.dev1', '<' );

		if ( $previous_is_pre_addon_framework ) {

			//copy plugin settings
			$this->copy_settings();

			//copy existing feeds to new table
			$this->copy_feeds();

			//copy existing sagepay transactions to new table
			$this->copy_transactions();

			//updating payment_gateway entry meta to 'gravityforms-sagepay-form' from 'sagepay'
			$this->update_payment_gateway();

			//updating entry status from 'Approved' to 'Paid'
			$this->update_lead();

		}
	}

	public function update_feed_id( $old_feed_id, $new_feed_id ){
		global $wpdb;
		$sql = $wpdb->prepare( "UPDATE {$wpdb->prefix}rg_lead_meta SET meta_value=%s WHERE meta_key='sagepay_feed_id' AND meta_value=%s", $new_feed_id, $old_feed_id );
		$wpdb->query( $sql );
	}

	public function add_legacy_meta( $new_meta, $old_feed ){

		$known_meta_keys = array(
								'email', 'mode', 'type', 'style', 'continue_text', 'cancel_url', 'disable_note', 'disable_shipping', 'recurring_amount_field', 'recurring_times',	'recurring_retry', 'billing_cycle_number', 'billing_cycle_type', 'trial_period_enabled', 'trial_amount', 'trial_period_number', 'trial_period_type', 'delay_post',
								'update_post_action', 'delay_notifications', 'selected_notifications', 'sagepay_conditional_enabled', 'sagepay_conditional_field_id',	'sagepay_conditional_operator', 'sagepay_conditional_value', 'customer_fields',
								);

		foreach ( $old_feed['meta'] as $key => $value ){
			if ( ! in_array( $key, $known_meta_keys ) ){
				$new_meta[ $key ] = $value;
			}
		}

		return $new_meta;
	}

	public function update_payment_gateway() {
		global $wpdb;
		$sql = $wpdb->prepare( "UPDATE {$wpdb->prefix}rg_lead_meta SET meta_value=%s WHERE meta_key='payment_gateway' AND meta_value='sagepay'", $this->_slug );
		$wpdb->query( $sql );
	}

	public function update_lead() {
		global $wpdb;
		$sql = $wpdb->prepare(
			"UPDATE {$wpdb->prefix}rg_lead
			 SET payment_status='Paid', payment_method='SagePay Form'
		     WHERE payment_status='Approved'
		     		AND ID IN (
					  	SELECT lead_id FROM {$wpdb->prefix}rg_lead_meta WHERE meta_key='payment_gateway' AND meta_value=%s
				   	)",
			$this->_slug);

		$wpdb->query( $sql );
	}

	public function ensure_copy_feeds(){

		if ( get_option( 'gf_sagepay_form_has_feeds' ) ){
			return false;
		}

		$feeds = $this->get_feeds();
		if ( empty( $feeds ) ){
			//if feeds are empty try running upgrade again (minus transactions)

			//copy plugin settings
			$this->copy_settings();

			//copy existing feeds to new table
			$this->copy_feeds();

			//updating payment_gateway entry meta to 'gravityforms-sagepay-form' from 'sagepay'
			$this->update_payment_gateway();

			//updating entry status from 'Approved' to 'Paid'
			$this->update_lead();

			update_option( 'gf_sagepay_form_has_feeds', 1 );
		}
	}

	public function copy_settings() {
		//copy plugin settings
		$old_settings = get_option( 'gf_sagepay_form_configured' );
		$new_settings = array( 'gf_sagepay_form_configured' => $old_settings );
		$this->update_plugin_settings( $new_settings );
	}

	public function copy_feeds() {
		//get feeds
		$old_feeds = $this->get_old_feeds();

		if ( $old_feeds ) {

			$counter = 1;
			foreach ( $old_feeds as $old_feed ) {
				$feed_name       = 'Feed ' . $counter;
				$form_id         = $old_feed['form_id'];
				$is_active       = $old_feed['is_active'];
				$customer_fields = $old_feed['meta']['customer_fields'];

				$new_meta = array(
					'feedName'                     => $feed_name,
					'vendor_name'                  => $old_feed['meta'],
					'mode'                         => rgar( $old_feed['meta'], 'mode' ),
					'transactionType'              => rgar( $old_feed['meta'], 'type' ),
					'type'                         => rgar( $old_feed['meta'], 'type' ), //For backwards compatibility of the delayed payment feature
					'pageStyle'                    => rgar( $old_feed['meta'], 'style' ),
					'continueText'                 => rgar( $old_feed['meta'], 'continue_text' ),
					'cancelUrl'                    => rgar( $old_feed['meta'], 'cancel_url' ),
					'successUrl'                    => rgar( $old_feed['meta'], 'success_url' ),
					'disableNote'                  => rgar( $old_feed['meta'], 'disable_note' ),
					'disableShipping'              => rgar( $old_feed['meta'], 'disable_shipping' ),

					'recurringAmount'              => rgar( $old_feed['meta'], 'recurring_amount_field' ) == 'all' ? 'form_total' : rgar( $old_feed['meta'], 'recurring_amount_field' ),
					'recurring_amount_field'       => rgar( $old_feed['meta'], 'recurring_amount_field' ), //For backwards compatibility of the delayed payment feature
					'recurringTimes'               => rgar( $old_feed['meta'], 'recurring_times' ),
					'recurringRetry'               => rgar( $old_feed['meta'], 'recurring_retry' ),
					'paymentAmount'                => 'form_total',
					'billingCycle_length'          => rgar( $old_feed['meta'], 'billing_cycle_number' ),
					'billingCycle_unit'            => $this->convert_interval( rgar( $old_feed['meta'], 'billing_cycle_type' ), 'text' ),

					'trial_enabled'                => rgar( $old_feed['meta'], 'trial_period_enabled' ),
					'trial_product'                => 'enter_amount',
					'trial_amount'                 => rgar( $old_feed['meta'], 'trial_amount' ),
					'trialPeriod_length'           => rgar( $old_feed['meta'], 'trial_period_number' ),
					'trialPeriod_unit'             => $this->convert_interval( rgar( $old_feed['meta'], 'trial_period_type' ), 'text' ),

					'delayPost'                    => rgar( $old_feed['meta'], 'delay_post' ),
					'change_post_status'           => rgar( $old_feed['meta'], 'update_post_action' ) ? '1' : '0',
					'update_post_action'           => rgar( $old_feed['meta'], 'update_post_action' ),

					'delayNotification'            => rgar( $old_feed['meta'], 'delay_notifications' ),
					'selectedNotifications'        => rgar( $old_feed['meta'], 'selected_notifications' ),

					'billingInformation_firstName' => rgar( $customer_fields, 'first_name' ),
					'billingInformation_lastName'  => rgar( $customer_fields, 'last_name' ),
					'billingInformation_email'     => rgar( $customer_fields, 'email' ),
					'billingInformation_address'   => rgar( $customer_fields, 'address1' ),
					'billingInformation_address2'  => rgar( $customer_fields, 'address2' ),
					'billingInformation_city'      => rgar( $customer_fields, 'city' ),
					'billingInformation_state'     => rgar( $customer_fields, 'state' ),
					'billingInformation_zip'       => rgar( $customer_fields, 'zip' ),
					'billingInformation_country'   => rgar( $customer_fields, 'country' ),
					'billingInformation_phone'     => rgar( $customer_fields, 'phone' ),

				);

				$new_meta = $this->add_legacy_meta( $new_meta, $old_feed );

				//add conditional logic
				$conditional_enabled = rgar( $old_feed['meta'], 'sagepay_conditional_enabled' );
				if ( $conditional_enabled ) {
					$new_meta['feed_condition_conditional_logic']        = 1;
					$new_meta['feed_condition_conditional_logic_object'] = array(
						'conditionalLogic' =>
							array(
								'actionType' => 'show',
								'logicType'  => 'all',
								'rules'      => array(
									array(
										'fieldId'  => rgar( $old_feed['meta'], 'sagepay_conditional_field_id' ),
										'operator' => rgar( $old_feed['meta'], 'sagepay_conditional_operator' ),
										'value'    => rgar( $old_feed['meta'], 'sagepay_conditional_value' )
									),
								)
							)
					);
				} else {
					$new_meta['feed_condition_conditional_logic'] = 0;
				}


				$new_feed_id = $this->insert_feed( $form_id, $is_active, $new_meta );
				$this->update_feed_id( $old_feed['id'], $new_feed_id );

				$counter ++;
			}
		}
	}

	public function copy_transactions(){
		//copy transactions from the sagepay transaction table to the add payment transaction table
		global $wpdb;
		$old_table_name = $this->get_old_transaction_table_name();
		$this->log_debug( 'Copying old SagePay Form transactions into new table structure.' );

		$new_table_name = $this->get_new_transaction_table_name();

		$sql	=	"INSERT INTO {$new_table_name} (lead_id, transaction_type, transaction_id, is_recurring, amount, date_created)
					SELECT entry_id, transaction_type, transaction_id, is_renewal, amount, date_created FROM {$old_table_name}";

		$wpdb->query( $sql );

		$this->log_debug( "transactions: {$wpdb->rows_affected} rows were added." );
	}

	public function get_old_transaction_table_name(){
		global $wpdb;
		return $wpdb->prefix . 'rg_sagepay_form_transaction';
	}

	public function get_new_transaction_table_name(){
		global $wpdb;
		return $wpdb->prefix . 'gf_addon_payment_transaction';
	}

	public function get_old_feeds() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'rg_sagepay_form';

		$form_table_name = GFFormsModel::get_form_table_name();
		$sql     = "SELECT s.id, s.is_active, s.form_id, s.meta, f.title as form_title
					FROM {$table_name} s
					INNER JOIN {$form_table_name} f ON s.form_id = f.id";

		$this->log_debug( "getting old feeds: {$sql}" );

		$results = $wpdb->get_results( $sql, ARRAY_A );

		$this->log_debug( "error?: {$wpdb->last_error}" );

		$count = sizeof( $results );

		$this->log_debug( "count: {$count}" );

		for ( $i = 0; $i < $count; $i ++ ) {
			$results[ $i ]['meta'] = maybe_unserialize( $results[ $i ]['meta'] );
		}

		return $results;
	}

	//This function kept static for backwards compatibility
	public static function get_config_by_entry( $entry ) {

		$sagepay = GFSagePayForm::get_instance();

		$feed = $sagepay->get_payment_feed( $entry );

		if ( empty( $feed ) ) {
			return false;
		}

		return $feed['addon_slug'] == $sagepay->_slug ? $feed : false;
	}

	//This function kept static for backwards compatibility
	//This needs to be here until all add-ons are on the framework, otherwise they look for this function
	public static function get_config( $form_id ) {

		$sagepay = GFSagePayForm::get_instance();
		$feed   = $sagepay->get_feeds( $form_id );

		//Ignore IPN messages from forms that are no longer configured with the SagePay Form add-on
		if ( ! $feed ) {
			return false;
		}

		return $feed[0]; //only one feed per form is supported (left for backwards compatibility)
	}

	//------------------------------------------------------


}
