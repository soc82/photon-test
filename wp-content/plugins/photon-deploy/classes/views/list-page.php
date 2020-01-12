<?php 
$photon_runAdmin   = new photonAdmin();
?>
<div class="photon-wrapup photon-color-dgrey-bg">
    <div class="photon-rows">
        <div class="photon-columns-1 "></div>
        
        <div class="photon-columns-10">
            <ul class="photon-admin-menu">
                <li><a href="<?php echo admin_url('/admin.php?page=photon-add'); ?>"><?php esc_html_e( 'Add New photon', 'photon' ); ?></a></li>
                <li><a href="<?php echo admin_url('/admin.php?page=photon'); ?>"><?php esc_html_e( 'View photon', 'photon' ); ?></a></li>
                <li><a href="mailto:info@maaike.co.uk"><?php esc_html_e( 'Get Support', 'photon' ); ?></a></li>
            </ul>
        </div>
        <div class="photon-columns-1 "></div>
    </div>
    <div class="photon-rows">
        <div class="photon-columns-1"></div>
        <div class="photon-columns-4 mobile-full">
            <a href="<?php echo admin_url('/admin.php?page=photon-add'); ?>" class="photon-btn photon-color-main-bg photon-color-white-ft"><i class="fa fa-plus"></i> <?php esc_html_e( 'Add New photon', 'photon' ); ?></a>
            <p class="photon-ft-para photon-color-lgrey-ft admin-para large"><?php esc_html_e( 'Welcome to', 'photon' ); ?> <span class="photon-color-main-ft"><?php esc_html_e( 'photon', 'photon' ); ?></span>. </p>
            <p class="photon-ft-para photon-color-lgrey-ft admin-para"><?php esc_html_e( 'Not all URLs are pretty, therefore we aim to make your website URLs all match.', 'photon' ); ?></p>
            <p class="photon-ft-para photon-color-lgrey-ft admin-para"><?php esc_html_e( 'Create redirects through your own website url to external websites, or create short links for your internal links, the choice is yours!.', 'photon' ); ?></p>
            
            <img src="<?php echo plugins_url( ); ?>/photon/assets/img/logo-white.png" height="40px">
            <div class="photon-columns-12 text-center ">
                <div class="photon-height-30"></div>
                <input type="text" name="search-photon" id="search-photon" placeholder="<?php esc_html_e( 'Search for your photon and press enter', 'photon' ); ?>">
            </div>
        </div>
        <div class="photon-columns-6 animate-up text-right mobile-hide">
            <img src="<?php echo plugins_url(); ?>/photon/assets/img/logo-white-circle.png" height="50%">
        </div>
        <div class="photon-columns-1"></div>
    
    </div>
</div>

<div class="photon-wrapup photon-color-lgrey-bg">
<div class="photon-feed-head photon-rows photon-color-grey-ft photon-ft-normal">
            <div class="photon-columns-2 ignore text-left" id="organise-name"><?php esc_html_e( 'Name', 'photon' ); ?></div>
            <div class="photon-columns-4 text-left" id="organise-original"><?php esc_html_e( 'Original', 'photon' ); ?></div>
            <div class="photon-columns-4 text-left" id="organise-photon"><?php esc_html_e( 'New photon', 'photon' ); ?></div>
            <div class="photon-columns-1 text-left" ><?php esc_html_e( 'Clicks', 'photon' ); ?></div>
            <div class="photon-columns-1 text-right"></div>
    </div>
    <div class="photon-rows">
            
        <div class="photon-columns-12 text-center search-results">
            <?php $photon_runAdmin->photon_list(); ?>
        </div>
    </div>
</div>
