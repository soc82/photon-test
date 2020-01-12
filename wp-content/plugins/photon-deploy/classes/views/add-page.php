<?php
$photonid = '';
$photon_runAdmin   = new photonAdmin();
if(isset($_REQUEST['photon-id'])){
    $photonid = $_REQUEST['photon-id'];
?>
<input type="hidden" value="<?php echo esc_html($photonid); ?>" id="photon_id">
<?php } ?>
<div class="photon-wrapup photon-color-dgrey-bg photon-color-grey-bbottom">
    <div class="photon-rows">
        <div class="photon-columns-3 ignore">
            <div class="photon-height-20"></div>
        <img src="<?php echo plugins_url( ); ?>/photon/assets/img/logo-white.png" height="25px">
        </div>
        <div class="photon-columns-9 ignore">
            <ul class="photon-admin-menu">
                <li><a href="<?php echo admin_url('/admin.php?page=photon-add'); ?>"><?php esc_html_e( 'Add New photon', 'photon' ); ?></a></li>
                <li><a href="<?php echo admin_url('/admin.php?page=photon'); ?>"><?php esc_html_e( 'View photon', 'photon' ); ?></a></li>
                <li><a href="mailto:info@maaike.co.uk"><?php esc_html_e( 'Get Support', 'photon' ); ?></a></li>
            </ul>
        </div>
    </div>
    
</div>

<div class="photon-wrapup photon-color-dgrey-bg">
    <div class="photon-rows">
    <div class="photon-columns-9 photon-color-white-bg photon-color-xdgrey-btop photon-color-xdgrey-bbottom expand-tab">
            <div class="photon-close-tab photon-color-grey-bg photon-color-white-ft"><i class="fa fa-times"></i></div> 
            
            
                <div class="photon-feed-content text-center">
                <div class="photon-height-200"></div>
                    <img src="<?php echo plugins_url( ); ?>/photon/assets/img/ajax-loader.gif">
                    <div class="photon-height-20"></div>
                    <p class="photon-color-lgrey-ft"><?php esc_html_e( 'If you have some data, we will load your reports here!', 'photon' ); ?></p>
                <div class="photon-height-200"></div>
                </div>
            <div class="photon-height-200"></div>
        </div>
        <div class="photon-columns-3 collapse tab">
            
            <!-- CONTENT -->
            <div id="photon-form-submit" class="photon-btn photon-color-main-bg photon-color-white-ft text-center"><?php esc_html_e( 'Save your photon', 'photon' ); ?></div>
            <form id="photon-form">
                <label><?php esc_html_e( 'Name', 'photon' ); ?></label>
                <input type="text" id="name" name="name" placeholder="<?php esc_html_e( 'Label your Link something memorable'); ?>" value="<?php echo esc_html($photon_runAdmin->get_photon_meta('name', ''.$photonid.'')); ?>">

                <label><?php esc_html_e( 'URL you want to direct', 'photon' ); ?></label>
                <p><?php esc_html_e( 'Enter the full link here, i.e. http://maaike.co.uk', 'photon' ); ?></p>
                <input type="text" id="old_url" name="old_url" placeholder="<?php esc_html_e( 'Url you wish to change. Add http://', 'photon' ); ?>" value="<?php echo esc_html($photon_runAdmin->get_photon_meta('old_url', ''.$photonid.'')); ?>">

                <label><?php esc_html_e( 'How you want your redirect link to look', 'photon' ); ?></label>
                <p><?php esc_html_e( 'This will be an affix to your sites domain that when entered as an address will redirect to the Old URL', 'photon' ); ?></p>
                <input type="text" id="new_url" name="new_url" placeholder="<?php esc_html_e( 'E.g. /new/url', 'photon' ); ?>" value="<?php echo esc_html(substr($photon_runAdmin->get_photon_meta('new_url', ''.$photonid.''),1)) ; ?>">

                <label><?php esc_html_e( 'Your Brand new photon', 'photon' ); ?></label>
                <div id="brand_new_url"></div>
                <input type="hidden" id="site_url" name="site_url" value="<?php echo esc_url(site_url()); ?>">
            </form>
        </div>

        
</div>
