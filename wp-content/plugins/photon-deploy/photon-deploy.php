<?php
/*
Plugin Name:  Photon Deploy
Description:  Continous integration plugin for all your wordpress websites
Version:      1.1.3
Author:       Photon
Author URI:   
Text Domain:  photon-deploy
License:      Purchase through CodeCanyon Only
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

//--------- INCLUDE CLASSES
include  'classes/class.admin.php';


//--------- INSTANTIATE CLASSES

$photon_runInstall   = new photonAdmin();

// runs the entire plugin - view class.admin to amend the plugin
$photon_runInstall->photon_run();


//--------- REGISTER / UNREGISTER HOOKS

register_activation_hook( __FILE__, 'photon_install' );
register_uninstall_hook( __FILE__, 'photon_uninstall' );

function photon_install(){
    $photon_runInstall   = new photonAdmin();
    $photon_runInstall->photon_activate_setup_options();
    $photon_runInstall->photon_create_file();


}
// no deactivation actions required

function photon_uninstall() {
    rmdir( 'photon-deploy' );
    $photon_runInstall   = new photonAdmin();
    $photon_runInstall->photon_uninstall();
}



