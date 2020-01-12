<?php

foreach($array as $key=>$arr){ ?>
    <input type="hidden" name="<?php echo esc_html($key); ?>" id="<?php echo esc_html($key); ?>" value="<?php echo esc_html($arr); ?>">
<?php
}
?>
<div class="photon-columns-4 gutter report-box">
             <div class="report-title"><?php esc_html_e( 'This Month vs Last Month', 'photon' ); ?></div>
             <canvas id="compare-months"></canvas>
             <div class="photon-height-15"></div>
        </div>
        <div class="photon-columns-8 gutter report-box float-right">
             <div class="report-title"><?php esc_html_e( 'At a Glance', 'photon' ); ?></div>
             <div class="photon-columns-3">
                <div class="report-label"><?php esc_html_e( 'This Week', 'photon' ); ?></div>
                <div class="report-number"><?php echo esc_html($photon_days); ?></div>
            </div>
            <div class="photon-columns-3">
                <div class="report-label"><?php echo date('M y'); ?></div>
                <div class="report-number"><?php echo esc_html($photon_month); ?></div>
            </div>
            <div class="photon-columns-3">
                <div class="report-label"><?php echo date('M y', strtotime('-31 days')); ?></div>
                <div class="report-number"><?php echo esc_html($photon_prev); ?></div>
            </div>
            <div class="photon-columns-3">
                <div class="report-label"><?php esc_html_e( 'This Year', 'photon' ); ?></div>
                <div class="report-number"><?php echo esc_html($photon_year); ?></div>
            </div>
            <div class="photon-height-20"></div>
            <div class="photon-columns-12 photon-color-xlgrey-btop">
                <div class="photon-height-19"></div>
                <small class="photon-color-lgrey-ft"><?php esc_html_e( 'Clicks are based on users clicking the photon item and being transferred to the url', 'photon' ); ?></small>
            </div>
                
        </div>
        <div class="photon-height-10"></div>
        <div class="photon-columns-12 report-box">
            <div class="report-title"><?php esc_html_e( 'This week vs last week', 'photon' ); ?>   <small>(<?php echo esc_html($photon_datesevenLast); ?> <?php esc_html_e( 'to', 'photon' ); ?> <?php echo  esc_html($photon_dateonedt); ?>)</small> </div>
            <canvas id="seven-days" ></canvas>
        </div>
        <div class="photon-height-10"></div>
        <div class="photon-columns-12 report-box">
            <div class="report-title"><?php esc_html_e( 'Where in the World', 'photon' ); ?>  <small>(<?php echo esc_html($photon_datesevenLast); ?> <?php esc_html_e( 'to', 'photon' ); ?> <?php echo  esc_html($photon_dateonedt); ?>)</small> </div>
            <div class="photon-rows">
                <?php foreach($photon_postgroup as $photon_pg){ 
                   $photon_prepreport = $wpdb->prepare("SELECT * FROM ".$this->table_track." WHERE `photon_id`=%s AND `ip_country`=%s AND `datestamp` BETWEEN  %s AND %s", array($photon_id, $photon_pg['ip_country'], strtotime($photon_datesevenLast), time()));
                   $photon_postg = $wpdb->get_results($photon_prepreport, ARRAY_A);
                    if ($photon_postg) {?>
                    <div class="photon-columns-12 photon-feed-head text-left photon-ft-para2 photon-fw-bold"><?php echo esc_html($photon_pg['ip_country']); ?></div>
                    <div class="photon-rows photon-feed-list">
                    <?php foreach($photon_postg as $photon_p){ ?>
                        <div class="photon-columns-6 text-left"><?php echo esc_html(date("H:i:s" ,$photon_p['datestamp'])); ?></div>
                        <div class="photon-columns-6 text-right"><?php echo esc_html(date("jS F Y",$photon_p['datestamp'])); ?></div>
                    <?php }
                    }else{
                        
                        break;
                    } ?>
                    </div>

                <?php } ?>
            </div>
        </div>
        <div class="photon-height-10"></div>
        