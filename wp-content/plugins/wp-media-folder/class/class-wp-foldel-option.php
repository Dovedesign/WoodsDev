<?php

require_once( WP_MEDIA_FOLDER_PLUGIN_DIR . '/class/class-media-folder.php' );
class Media_Folder_Option {

    function __construct() {
        add_action('admin_menu', array($this,'add_settings_menu'));
        /** Load admin js * */
        add_action('admin_enqueue_scripts', array($this, 'loadAdminScripts'));
        /** Load admin css  * */
        add_action('admin_init', array($this, 'addAdminStylesheets'));
        add_action('admin_init', array($this, 'add_option_gallery'));
        add_action('wp_ajax_update_opt', array($this, 'update_opt') );
        
        if(in_array('nextgen-gallery/nggallery.php',get_option( 'active_plugins' ))){
            if(!get_option('wpmf_import_nextgen_gallery',false)){
                add_action( 'admin_notices', array($this, 'wpmf_whow_notice'), 3);
            }
        }
        
        add_action('wp_ajax_update_opt', array($this, 'update_opt') );
        add_action('wp_ajax_import_gallery', array($this, 'import_gallery') );
        add_action( 'wp_ajax_import_categories', array($this,'wpmf_impo_taxo') );
        add_action( 'wp_ajax_wpmf_add_dimension', array($this,'add_dimension') );
        add_action( 'wp_ajax_wpmf_remove_dimension', array($this,'remove_dimension') );
        add_action( 'wp_ajax_wpmf_add_weight', array($this,'add_weight') );
        add_action( 'wp_ajax_wpmf_remove_weight', array($this,'remove_weight') );
        add_action( 'wp_ajax_wpmf_edit', array($this,'edit') );
    }
    
    
    public function add_option_gallery(){
        if(!get_option('wpmf_gallery_image_size_value',false)){
            add_option('wpmf_gallery_image_size_value', '["thumbnail","medium","large","full"]');
        }
        if(!get_option('wpmf_padding_masonry',false)){
            add_option('wpmf_padding_masonry', 5);
        }
        
        if(!get_option('wpmf_padding_portfolio',false)){
            add_option('wpmf_padding_portfolio', 10);
        }
        
        if(!get_option('wpmf_usegellery',false)){
            add_option('wpmf_usegellery', 1);
        }
        
        if(!get_option('wpmf_useorder',false)){
            add_option('wpmf_useorder', 1,'','yes');
        }
        
        if(!get_option('wpmf_folder_option1', false)){
                add_option('wpmf_folder_option1', 0, '', 'yes' );
        }
        
        if(!get_option('wpmf_active_media', false)){
                add_option('wpmf_active_media', 0, '', 'yes' );
        }
        
        if(!get_option('wpmf_folder_option2', false)){
                add_option('wpmf_folder_option2', 1, '', 'yes' );
        }
        
        $option1 = get_option('wpmf_folder_option1');
        if($option1==1) $this->wpmf_auto_create_folder();
        
        $dimensions = array( '400x300', '640x480', '800x600', '1024x768', '1600x1200');
        $dimensions_string = json_encode($dimensions);
        if(!get_option('wpmf_default_dimension', false)){
            add_option('wpmf_default_dimension', $dimensions_string, '', 'yes' );
        }
        
        if(!get_option('wpmf_selected_dimension', false)){
            add_option('wpmf_selected_dimension', $dimensions_string, '', 'yes' );
        }
        
        $weights = array( array('0-61440','kB'),array('61440-122880','kB') ,array('122880-184320','kB'),array('184320-245760','kB'),array('245760-307200','kB'));
        $weight_string = json_encode($weights);
        if(!get_option('wpmf_weight_default', false)){
            add_option('wpmf_weight_default', $weight_string, '', 'yes' );
        }
        
        if(!get_option('wpmf_weight_selected', false)){
            add_option('wpmf_weight_selected', $weight_string, '', 'yes' );
        }
    }


    public function loadAdminScripts() {
        if(isset($_GET['page']) && $_GET['page']=='option-folder'){
            wp_register_script('script-option', plugins_url( '/assets/js/script-option.js', dirname(__FILE__) ));
            wp_enqueue_script('script-option');
        }
    }

 
    public function addAdminStylesheets() {
        wp_enqueue_style('wpmf-setting-style',plugins_url( '/assets/css/setting_style.css', dirname(__FILE__) ));   
    }
    
    public function wpmf_whow_notice(){
	echo '<script type="text/javascript">'.PHP_EOL
		. 'function importWpmfgallery(doit,button){'.PHP_EOL
		    .'jQuery(button).closest("p").find(".spinner").show().css({"visibility":"visible"});'.PHP_EOL
		    .'jQuery.post(ajaxurl, {action: "import_gallery" , doit :doit}, function(response) {'.PHP_EOL
			.'jQuery(button).closest("div#wpmf_error").hide();'.PHP_EOL
                        .'if(doit===true){'.PHP_EOL
                            .'jQuery("#wpmf_error").after("<div class=\'updated\'> <p><strong>'. __('NextGEN galleries successfully imported in WP Media Folder','wpmf') .'</strong></p></div>");'.PHP_EOL
                        .'}'.PHP_EOL
		    .'});'.PHP_EOL
		. '}'.PHP_EOL
	    . '</script>';
	echo '<div class="error" id="wpmf_error">'
		. '<p>'
		. __('You\'ve just installed WP Media Folder, to save your time we can import your nextgen gallery into WP Media Folder','wpmf')
		    . '<a href="#" class="button button-primary" style="margin: 0 5px;" onclick="importWpmfgallery(true,this);" id="wmpfImportgallery">'.__('Sync/Import NextGEN galleries','wpmf').'</a> or <a href="#" onclick="importWpmfgallery(false,this);" style="margin: 0 5px;" class="button">'.__('No thanks ','wpmf').'</a><span class="spinner" style="display:none; margin:0; float:none"></span>'
		. '</p>'
	    . '</div>';	    
    }

    public function add_settings_menu(){
         add_options_page('Setting Folder Options', 'Media Folder', 'manage_options', 'option-folder', array($this,'view_folder_options'));
    }
  
    public function view_folder_options() {
        if(isset($_POST['btn_wpmf_save'])){
            if(isset($_POST['dimension'])){
                $selected_d = json_encode($_POST['dimension']);
                update_option('wpmf_selected_dimension',$selected_d);
            }else{
                update_option('wpmf_selected_dimension','[]');
            }
            
            if(isset($_POST['weight'])){
                $selected_w = array();
                foreach ($_POST['weight'] as $we){
                    $s = explode(',', $we);
                    $selected_w[] = array($s[0],$s[1]);
                }
                
                $se_w = json_encode($selected_w);
                update_option('wpmf_weight_selected',$se_w);
            }else{
                update_option('wpmf_weight_selected','[]');
            }
            
            if(isset($_POST['padding_gallery'])){
                $padding_themes = $_POST['padding_gallery'];
                foreach ($padding_themes as $key => $padding_theme){
                    if (!is_numeric($padding_theme)) {
                        if($key == 'wpmf_padding_masonry'){
                            $padding_theme = 5;
                        }else{
                            $padding_theme = 10;
                        }
                    }
                    $padding_theme = (int) $padding_theme;
                    if ($padding_theme > 30 || $padding_theme < 0) {
                        if($key == 'wpmf_padding_masonry'){
                            $padding_theme = 5;
                        }else{
                            $padding_theme = 10;
                        }
                    }

                    $pad = get_option($key);
                    if(!isset($pad)){
                        add_option($key, $padding_theme);
                    }else{
                        update_option($key, $padding_theme);
                    }
                }
            }
            if(isset($_POST['size_value'])){
                $size_value = json_encode($_POST['size_value']);
                update_option('wpmf_gallery_image_size_value', $size_value);
            }
            
            
            $this->update_option_checkbox('wpmf_folder_option1');
            $this->update_option_checkbox('wpmf_active_media');
            $this->update_option_checkbox('wpmf_usegellery');
            $this->update_option_checkbox('wpmf_useorder');
            $this->get_success_message();
        }
        
        $option1 = get_option('wpmf_folder_option1');
        $wpmf_active_media = get_option('wpmf_active_media');
        $btnoption = get_option('wpmf_use_taxonomy');
        $btn_import_categories = get_option('_wpmf_import_notice_flag');
        
        $padding_masonry = get_option('wpmf_padding_masonry');
        $padding_portfolio = get_option('wpmf_padding_portfolio');
        $size_selected = json_decode(get_option('wpmf_gallery_image_size_value'));
        $usegellery = get_option('wpmf_usegellery');
        $useorder = get_option('wpmf_useorder');
        
        $s_dimensions = get_option('wpmf_default_dimension');
        $a_dimensions = json_decode($s_dimensions);
        $string_s_de = get_option('wpmf_selected_dimension');
        $array_s_de = json_decode($string_s_de);
        
        $s_weights = get_option('wpmf_weight_default');
        $a_weights = json_decode($s_weights);
        $string_s_we = get_option('wpmf_weight_selected');
        $array_s_we = json_decode($string_s_we);
        require_once( WP_MEDIA_FOLDER_PLUGIN_DIR . 'class/pages/wp-folder-options.php' );
    }
    
    public function get_success_message()
    {
        require_once( WP_MEDIA_FOLDER_PLUGIN_DIR . 'class/pages/saved_info.php' );
    }
    
    public function update_option_checkbox($option){
        if(isset($_POST[$option])){
            update_option( $option, $_POST[$option] );
        }
    }
    
    public function update_opt(){
        $label = $_POST['label'];
        $value = $_POST['value'];
        $optionInfos = update_option( $label, $value );
        if($optionInfos instanceof WP_Error){
            wp_send_json($optionInfos->get_error_messages());
        }else{
            $optionInfos = get_option($label);
            wp_send_json($optionInfos);
        }
    }
    
    public function import_gallery(){
        global $wpdb;
        $option_import = get_option('wpmf_import_nextgen_gallery');
        if($_POST['doit']==='true'){
            update_option('wpmf_import_nextgen_gallery', 'yes');
        }else{
            update_option('wpmf_import_nextgen_gallery', 'no');
        }
        
        if($_POST['doit'] == 'true'){
            //if($wpdb->get_var("SHOW TABLES LIKE 'wp_ngg_gallery'") == 'wp_ngg_gallery') {
                $gallerys = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix.'ngg_gallery', OBJECT );
                $site_url = get_site_url();
                $site_path = get_home_path();
                $upload_dir = wp_upload_dir();

                if(count($gallerys) > 0 ){
                    foreach ($gallerys as $gallery){
                        $gallery_path = $gallery->path;
                        $gallery_path = str_replace('\\', '/', $gallery_path);
                        // create folder from nextgen gallery
                        $sql = $wpdb->prepare( "SELECT $wpdb->terms.term_id FROM $wpdb->terms,$wpdb->term_taxonomy WHERE name=%s AND parent=0 AND $wpdb->terms.term_id=$wpdb->term_taxonomy.term_id",array($gallery->title) );
                        $term_id = $wpdb->get_results( $sql );
                        if(!$term_id){
                            $inserted = wp_insert_term($gallery->title, 'wpmf-category',array('parent'=>0));
                            $term_id_insert = $inserted['term_id'];
                        }else{
                            $term_id_insert = $term_id;
                        }
                        // =========================
                        $table_pictute = $wpdb->prefix.'ngg_pictures';
                        $image_childs = $wpdb->get_results( "SELECT * FROM  $table_pictute WHERE galleryid = ".$gallery->gid, OBJECT );
                        if(count($image_childs) > 0 ){
                            foreach ($image_childs as $image_child){
                                $sql1 = $wpdb->prepare( "SELECT COUNT(*) FROM $wpdb->posts WHERE post_content=%s",array("[wpmf-nextgen-image-$image_child->pid]") );
                                $check_import = $wpdb->get_var($sql1);
                                if($check_import == 0){
                                    $url_image = $site_url.$gallery_path.'/'.$image_child->filename;
                                    $content = $this->getContent($url_image);
                                    $file_info = new finfo(FILEINFO_MIME_TYPE);
                                    $mime_type = $file_info->buffer($content);
                                    $ext =  $this->FileExt($mime_type);

                                    if( !file_exists( $upload_dir['path'].'/'. $image_child->filename ) ) {
                                        $filename = $image_child->filename;
                                    }else{
                                        $filename = uniqid() . $ext ;
                                    }

                                    $upload = file_put_contents($upload_dir['path'].'/'. $filename,$content);
                                    // upload images
                                    $attachment = array(
                                        'guid' => $upload_dir['url'].'/'. $filename,
                                        'post_mime_type' => ($ext=='.jpg')?'image/jpeg':'image/'.substr($ext,1),
                                        'post_title' => str_replace($ext, '', $filename),
                                        'post_content' => '[wpmf-nextgen-image-'.$image_child->pid.']',
                                        'post_status' => 'inherit'
                                    );

                                    $image_path = $upload_dir['path'].'/'. $filename;
                                    $attach_id = wp_insert_attachment($attachment,$image_path);
                                    $attach_data = wp_generate_attachment_metadata($attach_id,$image_path);
                                    wp_update_attachment_metadata($attach_id, $attach_data);

                                    // create image in folder
                                    wp_set_object_terms((int)$attach_id,(int)$term_id_insert,'wpmf-category',true);
                                        //===============
                                }
                            }
                        }
                       
                        
                    }
                }
            //}
        }
    }
    
    function getContent($url) {
            if ($url == '') {
                return '';
            }

            if (!function_exists('curl_version')) {
                if (!$content = @file_get_contents($url)) {
                    return '';
                }
            } else {
                $options = array(
                    CURLOPT_RETURNTRANSFER => true, // return content
                    CURLOPT_FOLLOWLOCATION => true, // follow redirects
                    CURLOPT_AUTOREFERER => true, // set referer on redirect
                    CURLOPT_CONNECTTIMEOUT => 60, // timeout on connect
                    CURLOPT_SSL_VERIFYPEER => false // Disabled SSL Cert checks
                );
               
                $ch = curl_init($url);
                curl_setopt_array($ch, $options);
                $content = curl_exec($ch);
                curl_close($ch);
            }

        return $content;
    }
    
    function FileExt($contentType){
            $map = array(
                'application/pdf'   => '.pdf',
                'application/zip'   => '.zip',
                'image/gif'         => '.gif',
                'image/jpeg'        => '.jpg',
                'image/png'         => '.png',
                'text/css'          => '.css',
                'text/html'         => '.html',
                'text/javascript'   => '.js',
                'text/plain'        => '.txt',
                'text/xml'          => '.xml',
            );
            if (isset($map[$contentType]))
            {
                return $map[$contentType];
            }

            $pieces = explode('/', $contentType);
            return '.' . array_pop($pieces);
    }
    
    public function wpmf_impo_taxo(){
        return Wp_Media_Folder::wpmf_import_categories();
    }
    
    public function wpmf_auto_create_folder(){
        $taxo = Wp_Media_Folder::get_taxonomy();
        $roles = array('administrator','editor','author');
        $users = get_users();
        foreach ($users as $user){
            $user_data = get_userdata( $user->ID );
            $user_roles = $user_data->roles;
            if(in_array($user_roles[0], $roles)){
                $inserted = wp_insert_term($user->user_login, $taxo,array('parent'=>0));
                if ( !is_wp_error($inserted) ) {
                    $updateted = wp_update_term( $inserted['term_id'], $taxo, array('term_group' => $user->ID) );
                }
            }
        }
    }
    
    public function add_dimension(){
        if(isset($_POST['width_dimension']) && isset($_POST['height_dimension'])){
            $min = $_POST['width_dimension'];
            $max = $_POST['height_dimension'];
            $new_dimension = $min.'x'.$max;
            $s_dimensions = get_option('wpmf_default_dimension');
            $a_dimensions = json_decode($s_dimensions);
            if(in_array($new_dimension, $a_dimensions) == false){
                array_push($a_dimensions,$new_dimension);
                update_option('wpmf_default_dimension', json_encode($a_dimensions));
                wp_send_json($new_dimension);
            }else{
                wp_send_json(false);
            }
        }
    }
    
    public function edit_selected($option_name,$old_value,$new_value){
        $s_selected = get_option($option_name);
        $a_selected = json_decode($s_selected);
        
        if(in_array($old_value, $a_selected) == true){
            $key_selected = array_search($old_value,$a_selected);
            $a_selected[$key_selected] = $new_value;
            update_option($option_name, json_encode($a_selected));
        }
    }
    
    
    public function remove_selected($option_name,$value){
        $s_selected = get_option($option_name);
        $a_selected = json_decode($s_selected);
        if(in_array($value, $a_selected) == true){
            $key_selected = array_search($value,$a_selected);
            unset($a_selected[$key_selected]);
            $a_selected = array_slice($a_selected,0,count($a_selected));
            update_option($option_name, json_encode($a_selected));
        }
    }
    
    public function remove_dimension(){
        if(isset($_POST['value']) && $_POST['value'] != ''){
            // remove dimension
            $s_dimensions = get_option('wpmf_default_dimension');
            $a_dimensions = json_decode($s_dimensions);
            if(in_array($_POST['value'], $a_dimensions) == true){
                $key = array_search($_POST['value'],$a_dimensions);
                unset($a_dimensions[$key]);
                $a_dimensions = array_slice($a_dimensions,0,count($a_dimensions));
                $update_demen = update_option('wpmf_default_dimension', json_encode($a_dimensions));
                if ( is_wp_error($update_demen) ) {
                    wp_send_json($update_demen->get_error_message());
                }else{
                    $this->remove_selected('wpmf_selected_dimension',$_POST['value']); // remove selected
                    wp_send_json(true);
                }
            }else{
                wp_send_json(false);
            }
        }
    }
    
    public function edit(){
        if(isset($_POST['old_value']) && $_POST['old_value'] != '' && isset($_POST['new_value']) && $_POST['new_value'] != ''){
            $label = $_POST['label'];
            if($label == 'dimension'){
                $s_dimensions = get_option('wpmf_default_dimension');
                $a_dimensions = json_decode($s_dimensions);
                if((in_array($_POST['old_value'], $a_dimensions) == true) && (in_array($_POST['new_value'], $a_dimensions) == false)){
                    $key = array_search($_POST['old_value'],$a_dimensions);
                    $a_dimensions[$key] = $_POST['new_value'];
                    $update_demen = update_option('wpmf_default_dimension', json_encode($a_dimensions));
                    if ( is_wp_error($update_demen) ) {
                            wp_send_json($update_demen->get_error_message());
                    }else{
                        $this->edit_selected('wpmf_selected_dimension',$_POST['old_value'],$_POST['new_value']); // edit selected
                        wp_send_json(array('value' => $_POST['new_value']));
                    }
                }else{
                    wp_send_json(false);
                }
            }else{
                $s_weights = get_option('wpmf_weight_default');
                $a_weights = json_decode($s_weights);
                if(isset($_POST['unit'])){
                    $old_values = explode(',', $_POST['old_value']);
                    $old = array($old_values[0],$old_values[1]);
                    $new_values = explode(',', $_POST['new_value']);
                    $new = array($new_values[0],$new_values[1]);
                    
                    if((in_array($old, $a_weights) == true) && (in_array($new, $a_weights) == false)){
                        $key = array_search($old,$a_weights);
                        $a_weights[$key] = $new;
                        $new_labels = explode('-', $new_values[0]);
                        if($new_values[1] == 'kB'){
                            $label = ($new_labels[0]/1024).' '.$new_values[1].'-'.($new_labels[1]/1024).' '.$new_values[1];
                        }else{
                            $label = ($new_labels[0]/(1024*1024)).' '.$new_values[1].'-'.($new_labels[1]/(1024*1024)).' '.$new_values[1];
                        }
                        $update_weight = update_option('wpmf_weight_default', json_encode($a_weights));
                        if ( is_wp_error($update_weight) ) {
                            wp_send_json($update_weight->get_error_message());
                        }else{
                            $this->edit_selected('wpmf_weight_selected',$old,$new); // edit selected
                            wp_send_json(array('value' => $new_values[0] , 'label' => $label));
                        }
                    }else{
                        wp_send_json(false);
                    }
                }
            }
        }
    }


    public function add_weight(){
        if(isset($_POST['min_weight']) && isset($_POST['max_weight'])){
            if(!$_POST['unit'] || $_POST['unit'] == 'kB'){
                $min = $_POST['min_weight']*1024;
                $max = $_POST['max_weight']*1024;
                $unit = 'kB';
            }else{
                $min = $_POST['min_weight']*1024*1024;
                $max = $_POST['max_weight']*1024*1024;
                $unit = 'MB';
                
            }
            $new_unit = $unit;
            $label = $_POST['min_weight'].' '.$unit.'-'.$_POST['max_weight'].' '.$unit;
            $new_weight = array($min.'-'.$max,$unit);
            
            $s_weights = get_option('wpmf_weight_default');
            $a_weights = json_decode($s_weights);
            if(in_array($new_weight, $a_weights) == false){
                array_push($a_weights,$new_weight);
                update_option('wpmf_weight_default', json_encode($a_weights));
                wp_send_json(array('key' => $min.'-'.$max, 'unit' => $unit ,'label' => $label));
            }else{
                wp_send_json(false);
            }
        }
    }
    
    public function remove_weight(){
        if(isset($_POST['value']) && $_POST['value'] != ''){
            $s_weights = get_option('wpmf_weight_default');
            $a_weights = (array)json_decode($s_weights);
            $unit = $_POST['unit'];
            $weight_remove = array($_POST['value'],$unit);
            if(in_array($weight_remove, $a_weights) == true){
                $key = array_search($weight_remove,$a_weights);
                unset($a_weights[$key]);
                $a_weights = array_slice($a_weights,0,count($a_weights));
                $update_weight = update_option('wpmf_weight_default', json_encode($a_weights));
                if ( is_wp_error($update_weight) ) {
                    wp_send_json($update_weight->get_error_message());
                }else{
                    $this->remove_selected('wpmf_weight_selected',$weight_remove);  // remove selected
                    wp_send_json(true);
                }
            }else{
                wp_send_json(false);
            }
        }
    }
}