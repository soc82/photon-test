<?php
require_once  'class.load.php';

require_once  'git-php/src/GitRepository.php';

use Cz\Git;

if ( ! class_exists( 'photonAdmin', false ) ) {

class photonAdmin {

    protected $loader;
    protected $photon;
    protected $version;
    public $table_list;
    public $table_track;

    public function __construct() {
        
        $this->photon_loader();
        $this->photon_hooks();
        
        $this->version = '1.0';

        $this->table_repo= 'photon_repo';
        
    }

    //  ----- SETUP INSTALL FEATURES

    private function photon_loader() {
        $this->loader = new photonThemeClassLoader($this->photon_get_version());
        $this->photon = new Cz\Git\GitRepository();
        $this->photon->getRepositoryPath('https://github.com/soc82/photon-test.git');
    }

    public function photon_run() {
        $this->loader->run();
    }

    //  ---- HOOKS

    public function photon_hooks() {
       $this->loader->add_action( 'admin_enqueue_scripts', $this, 'photon_run_scripts' );
       $this->loader->add_action( 'admin_menu', $this, 'photon_admin_menu' );

       // -- ajax settings for admin sections

       $this->loader->add_action("wp_ajax_photon_save_lists", $this, "photon_ajax_save_lists");
       $this->loader->add_action("wp_ajax_photon_delete_lists", $this, "photon_ajax_delete_lists");
       $this->loader->add_action("wp_ajax_photon_search_lists", $this, "photon_ajax_search_lists");
       $this->loader->add_action("wp_ajax_photon_get_reports", $this, "photon_ajax_get_reports");

    }

    // ---- MENU
    public function photon_admin_menu(){
        add_menu_page('photon', 'photon', 'manage_options', 'photon', [$this, 'photon_the_list'], plugins_url() . '/photon/assets/img/icons/photon.png', '10');
        add_submenu_page('','Add New photon', 'Add New','manage_options', 'photon-add', [$this, 'photon_add'], '', '');
        add_submenu_page('','Edit photon', 'Edit','manage_options', 'photon-edit', [$this, 'photon_edit'], '', '');
        add_submenu_page('', 'Settings', 'Settings', 'manage_options', 'photon-settings', [$this, 'photon_settings']); 
    }

    // ---- Install on activation
    
    public function photon_activate_setup_options(){
        global $wpdb;
        
        if($wpdb->get_var("SHOW TABLES LIKE '".$this->table_repo."'") != $this->table_repo) {
            $wpdb->query("CREATE TABLE IF NOT EXISTS ".$this->table_repo." (
                `photon_id` int(11) NOT NULL,
                `repository_url` varchar(500) NOT NULL,
                `live_sftp_host` text NOT NULL,
                `live_sftp_username` text NOT NULL,
                `live_sftp_password` text NOT NULL,
                `live_branch` text NOT NULL,
                `staging_sftp_host` text NOT NULL,
                `staging_sftp_username` text NOT NULL,
                `staging_sftp_password` text NOT NULL,
                `staging_branch` text NOT NULL,
                `local_sftp_host` text NOT NULL,
                `local_sftp_username` text NOT NULL,
                `local_sftp_password` text NOT NULL,
                `local_branch` text NOT NULL,
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
            
            
           
            
            $wpdb->query("ALTER TABLE ".$this->table_list."
            ADD UNIQUE KEY `photon_id` (`photon_id`)");
        
            
            $wpdb->query("ALTER TABLE ".$this->table_list."
            MODIFY `photon_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;");
            
            
        }
        
        
    }

    // ---- UnInstall
    
    public function photon_uninstall(){
        global $wpdb;
        
        $wpdb->query("DROP TABLE ".$this->table_repo."");
       
        
    }
    // ---- PAGES 
    public function photon_the_list() {
        include(dirname(__FILE__).'/views/list-page.php');
    }

    public function photon_add() {
        include(dirname(__FILE__).'/views/add-page.php');
    }

    public function photon_edit() {
        include(dirname(__FILE__).'/views/add-page.php');
    }

    public function photon_setting() {
        include(dirname(__FILE__).'/views/settings-page.php');
    }

    // ---- SCRIPTS

    public function photon_run_scripts(){
        $screen = get_current_screen();
        
        wp_register_script('photon-admin-js',  plugins_url() . '/photon/assets/js/admin.js', array(), time());
        wp_localize_script( 'photon-admin-js', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ))); 
       
        wp_register_script('photon-charts-js', plugins_url() . '/photon/assets/js/chart.js', array(), time());
        wp_register_style( 'photon-font',  '//fonts.googleapis.com/css?family=Thasadith:400,700', array(), time());
        wp_register_style( 'photon-cssadmin',  plugins_url() . '/photon/assets/css/style.css', array(), time());
        wp_register_script('photon-fontawesome', plugins_url()  . '/photon/assets/js/fontawesome.js', array(), time());
        
       
        if($screen->id == 'toplevel_page_photon' || $screen->id == 'admin_page_photon-add' || $screen->id == 'admin_page_photon-edit'){
            wp_enqueue_script( 'photon-fontawesome' );
            wp_enqueue_style(  'photon-font' ); 
            wp_enqueue_style(  'photon-cssadmin' );
            wp_enqueue_script( 'photon-admin-js' );
            wp_enqueue_script( 'photon-charts-js' );
        }
    }

    // ---- ON THE FLY FEED

    public function photon_ajax_get_reports(){
        global $wpdb;
        $array = array();

        $photon_id   = $_POST['photon_id'];
        $photon_prepone = $wpdb->prepare("SELECT * FROM ".$this->table_track." WHERE `photon_id`='%s'", array($photon_id));
        $photon_preptwo = $wpdb->prepare("SELECT * FROM ".$this->table_track." WHERE `photon_id`='%s'  AND `ip_country` != '' GROUP BY `ip_country`", array($photon_id));
        $photon_post = $wpdb->get_results($photon_prepone, ARRAY_A);
        $photon_postgroup  = $wpdb->get_results($photon_preptwo, ARRAY_A);

        $photon_count      = count($photon_post);
        $photon_today      = 0;
        $photon_daytwo     = 0;
        $photon_daythree   = 0;
        $photon_dayfour    = 0;
        $photon_dayfive    = 0;
        $photon_daysix     = 0;
        $photon_dayseven   = 0;
        $photon_days       = 0;
        $photon_month      = 0;
        $photon_prev       = 0;
        $photon_year       = 0;
        $photon_loc  = '';

        $photon_todayLast      = 0;
        $photon_daytwoLast     = 0;
        $photon_daythreeLast   = 0;
        $photon_dayfourLast    = 0;
        $photon_dayfiveLast    = 0;
        $photon_daysixLast     = 0;
        $photon_daysevenLast   = 0;

        $photon_thisMonth  = date('Ym');
        $photon_prevMonth  = date('Ym', strtotime('-31 days'));

        $array['photon_thisMonth'] = $photon_thisMonth;
        $array['photon_prevMonth'] = $photon_prevMonth;

        $array['clicks_this_week'] = esc_html( "Clicks this week", "photon" ); 
        $array['clicks_last_week'] = esc_html( "Clicks last week", "photon" ); 
        $array['clicks_this_month'] = esc_html(date('M'));
        $array['clicks_last_month'] = esc_html(date('M', strtotime('-31 days')));
        $array['clicks_per_day'] = esc_html( "Clicks per day", "photon" ); 

        foreach($photon_post as $p){
            // Today
            if(date('Ymd') == date('Ymd', $p['datestamp'])){
                $photon_today++;
                $array['photon_today'] = $photon_today;  
            }else{
                $array['photon_today'] = $photon_today;  
            }
            // Past 7 days
            if(date('Ymd', strtotime('-1 day')) == date('Ymd', $p['datestamp'])){
                $photon_daytwo++;
                $array['photon_daytwo'] = $photon_daytwo;
                
            }else{
                $array['photon_daytwo'] = $photon_daytwo;
            }
            if(date('Ymd', strtotime('-2 day')) == date('Ymd', $p['datestamp'])){
                $photon_daythree++;
                $array['photon_daythree'] = $photon_daythree;
                
            }else{
                $array['photon_daythree'] = $photon_daythree;
            }
            if(date('Ymd', strtotime('-3 day')) == date('Ymd', $p['datestamp'])){
                $photon_dayfour++;
                $array['photon_dayfour'] = $photon_dayfour;
                
            }else{
                $array['photon_dayfour'] = $photon_dayfour;
            }
            if(date('Ymd', strtotime('-4 day')) == date('Ymd', $p['datestamp'])){
                $photon_dayfive++;
                $array['photon_dayfive'] = $photon_dayfive;
                
            }else{
                $array['photon_dayfive'] = $photon_dayfive;
            }
            if(date('Ymd', strtotime('-5 day')) == date('Ymd', $p['datestamp'])){
                $photon_daysix++;
                $array['photon_daysix'] = $photon_daysix;
                
            }else{
                $array['photon_daysix'] = $photon_daysix;
            }
            if(date('Ymd', strtotime('-6 day')) == date('Ymd', $p['datestamp'])){
                $photon_dayseven++;
                $array['photon_dayseven'] = $photon_dayseven;
                
            }else{
                $array['photon_dayseven'] = $photon_dayseven;
            }

            // Past 7 days YEAR BEFORE
            // Today
            if(date('Ymd', strtotime('-7 day')) == date('Ymd', $p['datestamp'])){
                $photon_todayLast++;
                $array['photon_todayLast'] = $photon_todayLast;
                
            }else{
                $array['photon_todayLast'] = $photon_todayLast;
            }
            if(date('Ymd', strtotime('-8 day')) == date('Ymd', $p['datestamp'])){
                $photon_daytwoLast++;
                $array['photon_daytwoLast'] = $photon_daytwoLast;
                
            }else{
                $array['photon_daytwoLast'] = $photon_daytwoLast;
            }
            if(date('Ymd', strtotime('-9 day')) == date('Ymd', $p['datestamp'])){
                $photon_daythreeLast++;
                $array['photon_daythreeLast'] = $photon_daythreeLast;
                
            }else{
                $array['photon_daythreeLast'] = $photon_daythreeLast;
            }
            if(date('Ymd', strtotime('-10 day')) == date('Ymd', $p['datestamp'])){
                $photon_dayfourLast++;
                $array['photon_dayfourLast'] = $photon_dayfourLast;
                
            }else{
                $array['photon_dayfourLast'] = $photon_dayfourLast;
            }
            if(date('Ymd', strtotime('-11 day')) == date('Ymd', $p['datestamp'])){
                $photon_dayfiveLast++;
                $array['photon_dayfiveLast'] = $photon_dayfiveLast;
                
            }else{
                $array['photon_dayfiveLast'] = $photon_dayfiveLast;
            }
            if(date('Ymd', strtotime('-12 day')) == date('Ymd', $p['datestamp'])){
                $photon_daysixLast++;
                $array['photon_daysixLast'] = $photon_daysixLast;
                
            }else{
                $array['photon_daysixLast'] = $photon_daysixLast;
            }
            if(date('Ymd', strtotime('-13 day')) == date('Ymd', $p['datestamp'])){
                $photon_daysevenLast++;
                $array['photon_daysevenLast'] = $photon_daysevenLast;
            }else{
                $array['photon_daysevenLast'] = $photon_daysevenLast;
            }
            $photon_dateonedt  = date('jS M');
            $photon_dateone    = date('D');
            $photon_datetwo    = date('D', strtotime('-1 day'));
            $photon_datethree  = date('D', strtotime('-2 day'));
            $photon_datefour   = date('D', strtotime('-3 day'));
            $photon_datefive   = date('D', strtotime('-4 day'));
            $photon_datesix    = date('D', strtotime('-5 day'));
            $photon_dateseven  = date('D', strtotime('-6 day'));

            $array['photon_dateonedt'] = $photon_dateonedt;
            $array['photon_dateone'] = $photon_dateone;
            $array['photon_datetwo'] = $photon_datetwo;
            $array['photon_datethree'] = $photon_datethree;
            $array['photon_datefour'] = $photon_datefour;
            $array['photon_datefive'] = $photon_datefive;
            $array['photon_datesix'] = $photon_datesix;
            $array['photon_dateseven'] = $photon_dateseven;

            $photon_dateoneLast    = date('jS M ', strtotime('-7 days'));
            $photon_datetwoLast    = date('jS M ', strtotime('-8 days'));
            $photon_datethreeLast  = date('jS M ', strtotime('-9 days'));
            $photon_datefourLast   = date('jS M ', strtotime('-10 days'));
            $photon_datefiveLast   = date('jS M ', strtotime('-11 days'));
            $photon_datesixLast    = date('jS M ', strtotime('-12 days'));
            $photon_datesevenLast  = date('jS M ', strtotime('-13 days'));

            $array['photon_dateoneLast'] = $photon_dateoneLast;
            $array['photon_datetwoLast'] = $photon_datetwoLast;
            $array['photon_datethreeLast'] = $photon_datethreeLast;
            $array['photon_datefourLast'] = $photon_datefourLast;
            $array['photon_datefiveLast'] = $photon_datefiveLast;
            $array['photon_datesixLast'] = $photon_datesixLast;
            $array['photon_datesevenLast'] = $photon_datesevenLast;
            

            // total in past 7 days
            if($p['datestamp'] > strtotime('-7 day')){
                $photon_days++;
                $array['photon_days'] = $photon_days;
            }
           
            // This Month
            if($photon_thisMonth == date('Ym', $p['datestamp'])){
                $photon_month++;
                $array['photon_month'] = $photon_month;
            }
            // Previous Month
            if($photon_prevMonth == date('Ym', $p['datestamp'])){
                $photon_prev++;
                $array['photon_prev'] = $photon_prev;
            }
            // Past Year
            if(date('Y') == date('Y', $p['datestamp'])){
                $photon_year++;
                $array['photon_year'] = $photon_year;
            }


            

        }
        
       
        include(dirname(__FILE__).'/views/report.php');
       
        exit();

    }

    public function photon_getCountry() {
        $photon_ip="";
        if (getenv("HTTP_CLIENT_IP")) $photon_ip = getenv("HTTP_CLIENT_IP");
        else if(getenv("HTTP_X_FORWARDED_FOR")) $photon_ip = getenv("HTTP_X_FORWARDED_FOR");
        else if(getenv("REMOTE_ADDR")) $photon_ip = getenv("REMOTE_ADDR");
        else $photon_ip = "";

       
            $photon_curl = curl_init();

            curl_setopt_array($photon_curl, array(
                CURLOPT_URL => "//api.ipstack.com/".$photon_ip."?access_key=090574caa2a8317afc5a52490ef3da08&format=1",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache"
                ),
            ));

            $photon_response = curl_exec($photon_curl);
            $photon_err = curl_error($photon_curl);

            curl_close($photon_curl);

            $photon_response = json_decode($photon_response, true); //because of true, it's in an array
            $photon_location = $photon_response['country_name'];
            return $photon_location;
        
        
        
    }

    // ---- SAVE LISTS

    public function photon_ajax_save_lists(){
        global $wpdb;
        $photon_id = isset($_POST['photon_id']);
        $photon_data = explode("&",$_POST['data']);
        foreach($photon_data as $d){
            $dt = explode("=",$d);
            if($dt[0] == 'name'){
                $photon_name = str_replace("+", " ", $dt[1]);
            }
            if($dt[0] == 'old_url'){
                $photon_old = utf8_decode(urldecode($dt[1]));
            }
            if($dt[0] == 'new_url'){
                
                if (strpos(utf8_decode(urldecode($dt[1])), '/') === 0) {
                    $photon_new = utf8_decode(urldecode($dt[1]));
                }else{
                    $photon_new = '/'.utf8_decode(urldecode($dt[1]));
                }

            }
           
        }
        if($photon_id == ''){
            $photon_prep = $wpdb->prepare( 
                "INSERT INTO  ".$this->table_list." (`photon_id`, `name`, `old_url`, `new_url`, `affix_url`) 
                VALUES (%d, %s,%s, %s, %s);", 
                    array(
                    NULL, 
                    $photon_name, 
                    $photon_old,
                    $photon_new,
                    ''
                    ));
            $wpdb->query($photon_prep);
        }else{
            $photon_prep = $wpdb->prepare( "UPDATE ".$this->table_list." SET `name`='%s', `old_url`='%s', `new_url`='%s' where `photon_id`='%s'", 
                    array( 
                        $photon_name, 
                        $photon_old,
                        $photon_new,
                        $photon_id
                    ));
            $wpdb->query($photon_prep);
            
        }
        exit();
    }

    

    
     // ---- SEARCH LISTS
     public function photon_ajax_search_lists(){
        global $wpdb;
        $photon_data = $_POST['data'];
        $photon_type = $_POST['type'];
        $photon_searchdata = $photon_data;

        if($photon_type == 'search'){
            $photon_prep = $wpdb->prepare("SELECT * FROM ".$this->table_list." where `name` LIKE %s OR `old_url` LIKE %s OR `new_url` LIKE %s", array("%" .$wpdb->esc_like($photon_searchdata). "%","%" .$wpdb->esc_like($photon_searchdata). "%","%" .$wpdb->esc_like($photon_searchdata). "%"));
            $photon_results = $wpdb->get_results($photon_prep);
        }
        $photon_output  = '';

        
        include(dirname(__FILE__).'/views/search-results.php');
        
        exit();

     }
    
     // ---- DELETE LISTS

     public function photon_ajax_delete_lists(){
        global $wpdb;
        $data = $_POST['data'];
        $prep = $wpdb->prepare("DELETE FROM ".$this->table_list." WHERE `photon_id`='%s'", array($data));
        $wpdb->query($prep);
        exit();
     }



    // ---- FEED LIST

    public function photon_list(){
        global $wpdb;
       
        // No need to prepare -- taken from codex
        $photon_results = $wpdb->get_results("SELECT * FROM `".$this->table_list."`");
        $photon_output  = '';

        include(dirname(__FILE__).'/views/search-results.php');
      
    }

    // ---- GET META FOR LIST

    public function get_photon_meta($photon_key, $photon_postid){
        global $wpdb;
        $photon_prep = $wpdb->prepare("SELECT * FROM ".$this->table_list." WHERE `photon_id`='%s'", array($photon_postid));
        $photon_result = $wpdb->get_results($photon_prep, ARRAY_A);
       
        $p = '';
        foreach($photon_result as $photon_post){
            $p = $photon_post[''.$photon_key.''];
        }
        return $p;
    }


    // PHOTON

    public function photon_create_file(){
        

        // create a new file in repo
        $filename = $this->photon->getRepositoryPath() . '/readme.txt';
        file_put_contents($filename, "Lorem ipsum
            dolor
            sit amet
        ");

        // commit
        $this->photon->addFile($filename);
        $this->photon->commit('init commit');
    }

    // ---- VERSION
    public function photon_get_version() {
        return $this->version;
    }
}
}
