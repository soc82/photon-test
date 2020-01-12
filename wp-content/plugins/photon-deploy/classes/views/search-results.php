<?php
if(!empty($photon_results)){
    foreach($photon_results as $photon_post){
        $photon_preptwo = $wpdb->prepare("SELECT * FROM ".$this->table_track." where photon_id=%s", array($photon_post->photon_id));
        $photon_count = $wpdb->get_results($photon_preptwo);
        $photon_clicks = count($photon_count);
        $photon_output .= '<div class="photon-feed-list photon-rows photon-color-grey-ft photon-ft-normal" id="photon_'.esc_html($photon_post->photon_id).'">';
        $photon_output .= '<div class="photon-columns-2 ignore text-left photon-fw-bold"><a href="/wp-admin/admin.php?page=photon-edit&photon-id='.esc_html($photon_post->photon_id).'">'.esc_html($photon_post->name).'</a></div>';
                    
        $photon_output .= '<div class="photon-columns-4 text-left">'.esc_html($photon_post->old_url).'</div>';
        $photon_output .= '<div class="photon-columns-4 text-left"><a href="'.site_url().''.esc_html($photon_post->new_url).'" target="_blank">'.site_url().''.esc_html($photon_post->new_url).'</a></div>';
        $photon_output .= '<div class="photon-columns-1 text-left"><span class="photon-color-lgrey-ft"></span> '.esc_html($photon_clicks).'</div>';
                    
        $photon_output .= '<div class="photon-columns-1 text-right"><a href="/wp-admin/admin.php?page=photon-edit&photon-id='.esc_html($photon_post->photon_id).'" class="mobile-hide float-right"><i class="fa fa-edit"></i></a><span class="delete-photon" data-id="'.esc_html($photon_post->photon_id).'"><i class="fas fa-trash photon-ft-para float-right"></i></span></div>';
                    
        $photon_output .= '</div>';
    }
    echo $photon_output;
}else{
    ?>
    <p class="photon-admin-para large text-center"><?php esc_html_e( "Oh No! You haven't created your first photon!", "photon" ); ?></p>
    <p class="photon-photon-ft-para photon-color-grey-ft admin-para"><?php esc_html_e( "But thats ok! We can help you through it now!", "photon" ); ?><br><?php esc_html_e( "Start by clicking the button below", "photon" ); ?></p>
    <a href="<?php echo admin_url('/admin.php?page=photon-add'); ?>" class="photon-btn photon-color-main-bg photon-color-white-ft"><i class="fa fa-plus"></i> <?php esc_html_e( "Get Started Now", "photon" ); ?></a>
    <div class="photon-height-40"></div>
<?php
}