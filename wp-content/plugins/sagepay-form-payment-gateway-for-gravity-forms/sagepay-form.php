<?php
/**
 * Plugin Name: SagePay Form Gateway for Gravity Forms
 * Plugin URI: http://www.patsatech.com/
 * Description: Integrates Gravity Forms with SagePay Form Method, enabling end users to purchase goods and services through Gravity Forms.
 * Version: 99.9
 * Author: PatSaTECH
 * Author URI: http://www.patsatech.com
 * Contributors: patsatech
 * Requires at least: 3.5
 * Tested up to: 4.9.1
 *
 * Text Domain: gravityforms-sagepay-form
 * Domain Path: /lang/
 *
 * @package SagePay Form Gateway for Gravity Forms
 * @author PatSaTECH
 **
 **
 ** THIS PLUGIN HAS SINCE BEEN MODIFED BY BOSON SO DON'T UPDATE
 **
 */

define( 'GF_SAGEPAY_FORM_VERSION', '1.1.0' );

add_action( 'gform_loaded', array( 'GF_SagePay_Form_Bootstrap', 'load' ), 5 );

class GF_SagePay_Form_Bootstrap {

	public static function load(){

		if ( ! method_exists( 'GFForms', 'include_payment_addon_framework' ) ) {
			return;
		}

		require_once( 'class-gf-sagepay-form.php' );

		GFAddOn::register( 'GFSagePayForm' );
	}

}

function gf_sagepay_form(){
	return GFSagePayForm::get_instance();
}
