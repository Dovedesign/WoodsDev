<?php

/* --------------------------------------------------------------------
   Creamos Tipo de Post "PopupPress"
-------------------------------------------------------------------- */
add_action( 'init', 'create_post_type_popuppress_PPS' );

function create_post_type_popuppress_PPS() {
	$labels = array(
		'name' => __('PopupPress', 'PPS'),
		'singular_name' => __('PopupPress', 'PPS'),
		'add_new' => __('New Popup', 'PPS'),
		'add_new_item' => __('Add New Popup', 'PPS'),
		'edit_item' => __( 'Edit Popup', 'PPS' ),
		'new_item' => __( 'New Popup', 'PPS'),
		'view_item' => __( 'View Popup', 'PPS' ),
		'search_items' => __( 'Search Popup', 'PPS' ),
		'not_found' => __( 'No Popups found', 'PPS' ),
		'not_found_in_trash' => __( 'No Popups found in Trash', 'PPS' ),
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		//'publicly_queryable' => true,
		'show_ui' => true,
		//'exclude_from_search' => false,
		'show_in_nav_menus' => false,
		
		'show_in_menu' => true,
		'rewrite' => false,
		'has_archive' => false,
		//'hierarchical' => false,
		'menu_position' => 20,
		'menu_icon' => PPS_URL.'/css/images/icon_plugin.png',
		
		'supports' => array('title','editor'),
	);
	register_post_type('popuppress',$args);
}


/* --------------------------------------------------------------------
  Filtro de Mensajes para el Tipo de Post "PopupPress"
-------------------------------------------------------------------- */
add_filter( 'post_updated_messages', 'messages_popuppress_PPS' );

function messages_popuppress_PPS( $messages ) {
	global $post, $post_ID;
	
	$messages['popuppress'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => sprintf( __('Popup updated. <a href="%s" class="pps-button-popup-'.$post_ID.'">View Popup</a>', 'PPS'), '#'),
		
		2 => __('Custom field updated.', 'PPS'),
		3 => __('Custom field deleted.', 'PPS'),
		4 => __('Popup updated.', 'PPS'),
		/* translators: %s: date and time of the revision */
		5 => isset($_GET['revision']) ? sprintf( __('Popup restored to revision from %s', 'PPS'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Popup published. <a href="%s">View Popup</a>', 'PPS'), esc_url( get_permalink($post_ID) )),
		7 => __('Popup saved.', 'PPS'),
		8 => sprintf( __('Popup submitted. <a target="_blank" href="%s">Preview Popup</a>', 'PPS'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9 => sprintf( __('Popup scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Popup</a>', 'PPS'),
		  // translators: Publish box date format, see http://php.net/date
		  date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
		10 => sprintf( __('Popup draft updated. <a target="_blank" href="%s">Preview Popup</a>', 'PPS'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		);
	return $messages;
}

/* --------------------------------------------------------------------
   Columnas para el Tipo de Post "PopupPress"
-------------------------------------------------------------------- */
add_filter("manage_edit-popuppress_columns", "popuppress_columns_PPS");
 
function popuppress_columns_PPS($columns){
	$columns = array(
		"cb" => "<input type=\"checkbox\" />",
		"title" => "Títle",
		"shortcode" => "Shortcode",
		"views" => "Total Views",
		"preview-popup" => "Preview",
		"date" => 'Date',
	);
	return $columns;
}

/* --------------------------------------------------------------------
   Contenido de las Columnas para Popups
-------------------------------------------------------------------- */
add_action('manage_popuppress_posts_custom_column','popuppress_custom_columns_PPS', 10 , 2);

function popuppress_custom_columns_PPS($column, $post_id){
	//global $post;
	$values = get_post_custom($post_id);
	
	$views_count = (int) get_post_meta($post_id, 'pps-views', true);
	
	
	$popup = do_shortcode('[popuppress id="'.$post_id.'"]');
		
	switch ($column) {
		case 'shortcode':
			echo '<p style="margin: 2px 0 0; font-size:13px;">[popuppress id="'.$post_id.'"]</p>';
			break;
			
		case 'views':
			echo '<p style="margin: 2px 0 0 6px;"><span style="font-size:13px;">'.$views_count.'</span><span style="color: #666;"> views</span><br><a class="restore-views" href="?popup_id='.$post_id.'">Restore</a></p>';
			break;
		case 'preview-popup':
			echo $popup;
			echo get_popup_PPS($post_id);
			break;
	}
}


/* --------------------------------------------------------------------
   Hacemos Ordenable la Columna "Views" para Popups
-------------------------------------------------------------------- */

add_filter( 'manage_edit-popuppress_sortable_columns', 'popuppress_sortable_columns_PPS' );
add_action( 'pre_get_posts', 'popuppress_sortable_query_PPS' );

function popuppress_sortable_columns_PPS( $columns ) {
	$columns['views'] = 'views';
	return $columns;
}
  
function popuppress_sortable_query_PPS( $query ) {  
	if( !is_admin() || !isset($_GET['post_type']) || $_GET['post_type']!='popuppress' )  
		return;  
		
	$orderby = $query->get('orderby');  
	if( 'views' == $orderby ) {  
		$query->set('meta_key','pps-views');  
		$query->set('orderby','meta_value_num');  
	}  
}  




/* --------------------------------------------------------------------
   Código Corto que Muestra el Popup
-------------------------------------------------------------------- */
add_shortcode('popuppress', 'shortcode_popuppress');

add_filter('widget_text', 'do_shortcode', 11);
function shortcode_popuppress( $atts = '', $content = null) {
	
	global $wpdb, $post;
	extract( shortcode_atts( array(
		'id' => 0,
	), $atts ) );
	
	//Desactiva el Popup en Dispositivos Moviles
	$options = get_option('pps_options');
	$mobile_detect = new Mobile_Detect;
	if ($options['prevent_mobile'] == 'true') {
		if ( $mobile_detect->isMobile() || $mobile_detect->isTablet() )
			return;
	}
	
	
	$popuppress = get_post($id);
	//Si $id está vacía o es cero
	if(empty($id) || $popuppress->post_type != 'popuppress')
		return;
	
	
	$popup_id = $id;
	$button_popup = get_button_popup_PPS($popup_id);
	$scripts_popup = get_script_popup_PPS($popup_id);
	
	$respuesta = $button_popup.$scripts_popup;
	
	//Si el Shortcode se llama fuera de un Post o Página
	//if( !in_the_loop() ){
		$main_popup = get_popup_PPS($popup_id);
		$respuesta .= $main_popup;
	//} 
	
	return $respuesta;
}

/* --------------------------------------------------------------------
   Inserta Automáticamente un Popup al Sitio
-------------------------------------------------------------------- */

add_action( 'wp_footer', 'auto_insert_popup_PPS' );
function auto_insert_popup_PPS(){
	
	//Desactiva el Popup en Dispositivos Moviles
	$options = get_option('pps_options');
	$mobile_detect = new Mobile_Detect;
	if ($options['prevent_mobile'] == 'true') {
		if ( $mobile_detect->isMobile() || $mobile_detect->isTablet() )
			return;
	}
	
	global $wp_query;
	$args = array(
		'post_type' 	=> 'popuppress',
		'posts_per_page' => -1, /* Get all popups */
		'meta_query' => array(
			array(
			   'key' => 'pps_open_in',
			   'value' => 'pages',
			   'compare' => '!=',
			)
		)
	);	
	$query_pps = new WP_Query( $args );
	if($query_pps->have_posts()):
		while($query_pps->have_posts()) : $query_pps->the_post();
			$popup_id = get_the_ID();
			$button_popup = get_button_popup_PPS($popup_id);
			$scripts_popup = get_script_popup_PPS($popup_id);
			$main_popup = get_popup_PPS($popup_id);
			$values = get_post_custom($popup_id);
			$open_in = $values['pps_open_in'][0];
			$open_in_url = $values['pps_open_in_url'][0];
			$url_actual = "http://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
			$show_popup = false;
			
			switch($open_in){
				case 'home': //$open_in == 'home' && $_SERVER["REQUEST_URI"] == '/' || is_front_page()
					if(is_home() || is_front_page() || $_SERVER["REQUEST_URI"] == '/')
						$show_popup = true;
					break;
					
				case 'all-site':
					$show_popup = true;
					//Excluimos páginas por id
					if(!empty($values['pps_exclude_pages'][0])){
						$pages_ids = explode(',', $values['pps_exclude_pages'][0]);
						if ( is_page($pages_ids) || is_single($pages_ids) )
							$show_popup = false;
					}
					break;
					
				case 'urls':
					$urls = explode(',', $open_in_url);
					foreach($urls as $url){
						$url = trim($url);
						if(strlen($url) > 1){
							//Si existe el asterisco(*) al final de la url
							if( strpos($url, '*', strlen($url)-1) !== false  ){
								//El popup se ejecutará en todas las páginas hijas de la puesta en el campo URL's
								$url = str_replace('*','',$url);
								if(strpos($url_actual, $url) !== false)
									$show_popup = true;
								
							} else {
								if($url_actual == $url || $url_actual == $url.'/')
									$show_popup = true;
							}
						}
					}
					break;
			}
			
			if($show_popup)
				echo $button_popup.$scripts_popup.$main_popup;
				
		endwhile;
	endif;
	wp_reset_postdata();
}

/* --------------------------------------------------------------------
   Generamos el Cuerpo del Popup
-------------------------------------------------------------------- */
function get_popup_PPS($popup_id = 0){
	
	$popuppress = get_post($popup_id);
	
	if(empty($popup_id) || $popuppress->post_type != 'popuppress')
		return '';
		
	// Cuerpo del Popup
	$values = get_post_custom($popup_id);
	$popup = '';
	$popup .= '<div id="popuppress-'.$popup_id.'" class="pps-popup pps-'.$values['pps_popup_style'][0].' pps-border-'.$values['pps_transparent_border'][0].'">';
		$popup .= '<div class="pps-wrap">';
			$close_x = '<div class="pps-close"><a href="#" class="pps-close-link-'.$popup_id.' pps-close-link" id="pps-close-link-'.$popup_id.'"></a></div>';
			if(isset($values['pps_show_close'][0]) and $values['pps_show_close'][0] == 'false')
				$close_x = '';
				
				$popup .= $close_x;
			if($values['pps_show_title'][0] == 'true')
				$popup .= '<div class="pps-header"><h3 class="pps-title">'.get_the_title($popup_id).'</h3></div>';
				
			$popup .= '<div class="pps-content">'.get_content_popup_PPS($popup_id).'</div>';
		$popup .= '</div><!--.pps-wrap-->';
	$popup .= '</div><!--.pps-popup-->';
	
	return $popup;
}



/* --------------------------------------------------------------------
   Función que Genera el Botón del Popup
-------------------------------------------------------------------- */
function get_button_popup_PPS($popup_id = 0){
	$values = get_post_custom($popup_id);
	$button_type = $values['pps_button_type'][0];
	$button_popup = '';
	$class_run = isset($values['pps_button_class_run'][0]) ? $values['pps_button_class_run'][0] : '';

	switch($button_type){
		case 'button':
			$button_popup = '<a href="#" class="pps-btn pps-button-popup-'.$popup_id.' '.$values['pps_button_class'][0].' '.$class_run.'"  title="'.$values['pps_button_title'][0].'">'.$values['pps_button_text'][0].'</a>';
			break;
			
		case 'plain-text':
			$button_popup = '<a href="#" class="pps-button-popup-'.$popup_id.' '.$values['pps_button_class'][0].' '.$class_run.'"  title="'.$values['pps_button_title'][0].'">'.$values['pps_button_text'][0].'</a>';
			break;
			
		case 'image':
			$button_popup = '<a href="#" class="pps-button-popup-'.$popup_id.' '.$values['pps_button_class'][0].' '.$class_run.'" title="'.$values['pps_button_title'][0].'"><img src="'.$values['pps_button_image'][0].'" alt="'.get_the_title($popup_id).'" width="'.$values['pps_img_width_button'][0].'" /></a>';
			break;
		default:
			//nothing
	}
	return $button_popup;
}


/* --------------------------------------------------------------------
   Generamos los Scripts y Estilos del Popup
-------------------------------------------------------------------- */

function get_script_popup_PPS($popup_id = 0){
	$modules_popups = '';
	//Default Options
	$opt = get_option('pps_options');
	
	//Default Values
	$values = get_post_custom($popup_id);
	
	//Popup Options
	$border_radius = (int) $values['pps_border_radius'][0];
	$border_radius2 = ($border_radius > 0) ? $border_radius + 2 : 0;
	
	//Width, Height
	$width = $values['pps_width'][0];
	$height = 'auto';
	$auto_width = isset($values['pps_auto_width'][0]) ? $values['pps_auto_width'][0] : 'false';
	
	if($values['pps_auto_height'][0] == 'false' && $values['pps_height'][0] != '')
		$height = $values['pps_height'][0].'px';
	
	$width_units = $values['pps_width_units'][0] ? $values['pps_width_units'][0] : 'px';
	$width_css = ($auto_width == 'false') ? $width.$width_units : 'auto';
	
	$left_css = ($width_units != 'px') ? '; left: ' . (int)(100 - $width)/2 .'% !important; ' : '';
	
	
			
	$position_x = ( !is_numeric($values['pps_position_x'][0]) ) ? '"auto"' : $values['pps_position_x'][0];
	$position_y = ( !is_numeric($values['pps_position_y'][0]) ) ? '"auto"' : $values['pps_position_y'][0];
	
	$auto_open = $values['pps_auto_open'][0];
	$auto_close = isset($values['pps_auto_close'][0]) ? $values['pps_auto_close'][0] : 'false';
	$delay = $values['pps_delay'][0];
	$delay_close = isset($values['pps_delay_close'][0]) ? (int) $values['pps_delay_close'][0] + $delay : 12000;
	$first_time = $values['pps_first_time'][0];
	$cookie_popup = 'pps_cookie_'.$popup_id;
	$cookie_expire = isset($values['pps_cookie_expire'][0]) ? $values['pps_cookie_expire'][0] : 'current_session';
	$cookie_days = isset($values['pps_cookie_days'][0]) ? $values['pps_cookie_days'][0] : 1;
	
	$run_method = 'click';
	
	if(isset($values['pps_run_on_hover'][0]) and $values['pps_run_on_hover'][0] == 'yes') {
		$run_method = 'mouseover';
	}	
	
	
	if(!empty($values['pps_open_hook'][0])){
		$run_method = $values['pps_open_hook'][0];
	}
	
	
	$content_by_id = isset($values['pps_content_by_id'][0]) ? $values['pps_content_by_id'][0] : '';
	$class_run = isset($values['pps_button_class_run'][0]) ? $values['pps_button_class_run'][0] : '';
	if(!empty($class_run)) {
		$class_run = ', .'.$class_run;
	}
	
	$popup_easing = isset($values["pps_popup_easing"][0]) ? $values["pps_popup_easing"][0] : '';
	
	//Slider Options
	$slider_auto = isset($values["pps_slider_auto"][0]) ? $values["pps_slider_auto"][0] : $opt["slider_auto"];
	$slider_timeout = isset($values["pps_slider_timeout"][0]) ? $values["pps_slider_timeout"][0] : $opt["slider_timeout"];
	$slider_speed = isset($values["pps_slider_speed"][0]) ? $values["pps_slider_speed"][0] : $opt["slider_speed"];
	$slider_pagination = isset($values["pps_slider_pagination"][0]) ? $values["pps_slider_pagination"][0] : $opt["slider_pagination"];
	$slider_arrows = isset($values["pps_slider_arrows"][0]) ? $values["pps_slider_arrows"][0] : $opt["slider_arrows"];
	$slider_pause = isset($values["pps_slider_pause"][0]) ? $values["pps_slider_pause"][0] : $opt["slider_pause"];
	$slider_start_at = isset($values["pps_slider_start_at"][0]) ? $values["pps_slider_start_at"][0] - 1 : 0;
	
	
	$flexSlider = '
			if(jQuery("#pps-slider-'.$popup_id.'").length){
				if(typeof jQuery.fn.popupslider == "function") {
					jQuery("#pps-slider-'.$popup_id.'").popupslider({
						slideshow: '.$slider_auto.',
						slideshowSpeed: '.$slider_timeout.',
						animationSpeed: '.$slider_speed.',
						controlNav: '.$slider_pagination.',
						directionNav: '.$slider_arrows.',
						pauseOnHover: '.$slider_pause.',
						namespace: "pps-",
						startAt: '.$slider_start_at.',
						before: function(){
							pauseVideosPopupPress('.$popup_id.');
						},
						after: function(){
							refreshTopPosition('.$popup_id.');
						},
						selector: "#slides-'.$popup_id.' > li",
					});	
				}	
			}';
	
	$bPopup = '
			jQuery("#popuppress-'.$popup_id.'").bPopup({
				closeClass: "pps-close-link-'.$popup_id.'",
				easing: "'.$popup_easing.'",
				modalClose: '.$values["pps_close_overlay"][0].',
				modalColor: "'.$values['pps_bg_overlay'][0].'",
				opacity: '.$values["pps_opacity"][0].',
				positionStyle: "'.$values["pps_position_type"][0].'",
				position: ['.$position_x.','.$position_y.'],
				speed: '.(int) $values['pps_speed'][0].',
				transition: "'.$values["pps_popup_transition"][0].'",
				zIndex: '.$values["pps_zindex"][0].',
				amsl : 0,
				onOpen: function(){
					contentFromIdPopupPress('.$popup_id.',"'.$content_by_id.'");
					updateViewsPopupPress('.$popup_id.');
					restoreVideosPopupPress('.$popup_id.');
					//centerPopupPress('.$popup_id.');
				},
				onClose: function(){
					pauseVideosPopupPress('.$popup_id.');
					removeVideosPopupPress('.$popup_id.');
				},
			});
			';
	$function_popup = $flexSlider.$bPopup;
	
	$close_function = '
		setTimeout(function(){
			if(jQuery("#popuppress-'.$popup_id.'").css("display") == "block")
				jQuery("#popuppress-'.$popup_id.'").bPopup().close();
			
		},'.$delay_close.');';
	
	$style_popup = '
	<style type="text/css">
		#popuppress-'.$popup_id.' {
			width: '.$width_css.';
			height: '.$height.'
		}
		#popuppress-'.$popup_id.'.pps-border-true {
			-webkit-border-radius: '.$border_radius2.'px;
			-moz-border-radius: '.$border_radius2.'px;
			border-radius: '.$border_radius2.'px;
		}
		#popuppress-'.$popup_id.' .pps-wrap {
			-webkit-border-radius: '.$border_radius.'px;
			-moz-border-radius: '.$border_radius.'px;
			border-radius: '.$border_radius.'px;
		}
		
		@media screen and (min-width: 768px){
			#popuppress-'.$popup_id.' {
				'.$left_css.'
			}
			#popuppress-'.$popup_id.' .pps-embed iframe {
				width: '.$opt['embed_width'].'px !important;
				height: '.$opt['embed_height'].'px !important;
			}
		}
	
	</style>';
	$script_popup = '
<script type="text/javascript">
jQuery(document).ready(function($){
	';

	if($run_method == 'leave_page' && !strstr($_SERVER['REQUEST_URI'],'/edit.php?post_type=popuppress')) {
		$script_popup .= '
		jQuery(document).bind("mouseleave",function(e){
			'.$function_popup.'
			jQuery(this).unbind("mouseleave");
		});';
	} else {
		$script_popup .= '
		jQuery(".pps-button-popup-'.$popup_id.$class_run.', a[href=pps-button-popup-'.$popup_id.']").bind("'.$run_method.'", function(e) {
			e.preventDefault();
			'.$function_popup.'
		});';
	}
	
	if( $auto_open == 'true' && !strstr($_SERVER['REQUEST_URI'],'/edit.php?post_type=popuppress')   ){
		if($first_time == 'true'){
			//Duracion de la cookie
			$expires = ($cookie_expire == 'number_days') ? ', { expires: '.$cookie_days.' }' : '';
			$cookie_value = ($cookie_expire == 'current_session') ? 'Current_Session' : $cookie_days. '_days';
			
			$script_popup .= '
			var cookieValue = jQuery.cookie("'.$cookie_popup.'");
			if(!jQuery.cookie("'.$cookie_popup.'") || cookieValue != "'.$cookie_value.'" ){
				setTimeout( function(){
					'.$function_popup.'
				}, '.$delay.');
				
				jQuery.cookie("'.$cookie_popup.'", "'.$cookie_value .'" '. $expires.', { path: "/" });';
				if($auto_close == 'true'){
					$script_popup .= $close_function;
				}
				
				$script_popup .= '
			}';
			
		} else {
			$script_popup .= '
			setTimeout( function(){
				'.$function_popup.'
			}, '.$delay.');';
			
			if($auto_close == 'true'){
				$script_popup .= $close_function;
			}
		}
	}
	
	$script_popup .= '
});
</script>';
	
	$modules_popups .= $style_popup.$script_popup;
	
	return $modules_popups;
	
}

/* --------------------------------------------------------------------
   Generamos el Contenido del Popup
-------------------------------------------------------------------- */
function get_content_popup_PPS($popup_id = 0){
	$values = get_post_custom($popup_id);
	$opt = get_option('pps_options');
	$numItems = 0;
	
	//$popup = get_post($popup_id);
	//$content_popup = $popup->post_content;
	//$content_editor = apply_filters('the_content', $content_popup);//Formatea correctamente el contenido
	//$content_editor = wpautop($content_popup);//Formatea el contenido, pero desactiva los shortcodes :/
	
	//Obtenemos el Contenido del Editor
	$query_pps = new WP_Query( array('post_type' => 'popuppress', 'p'=> $popup_id) );
	if($query_pps->have_posts()):
		while($query_pps->have_posts()) : $query_pps->the_post();
			ob_start();
			the_content();
			$content_editor  = ob_get_contents();
			ob_end_clean();
		endwhile;
	endif;
	wp_reset_postdata();
		
	$content_file = maybe_unserialize($values['pps_file_repeatable'][0]);
	$content_oembed = maybe_unserialize($values['pps_oembed_repeatable'][0]);
	$content_iframe = isset($values['pps_iframe'][0]) ? $values['pps_iframe'][0]:'';
	$content_pdf = isset($values['pps_pdf'][0]) ? $values['pps_pdf'][0]:'';
	$content_by_id = isset($values['pps_content_by_id'][0]) ? $values['pps_content_by_id'][0] : '';
	
	$content_fields = array(
		"mbox_editor" => isset($values['pps_mbox_editor_order'][0]) ? $values['pps_mbox_editor_order'][0] : 1,
		"mbox_file" => isset($values['pps_mbox_file_order'][0]) ? $values['pps_mbox_file_order'][0] : 2,
		"mbox_oembed" => isset($values['pps_mbox_oembed_order'][0]) ? $values['pps_mbox_oembed_order'][0] : 3,
		"mbox_iframe" => isset($values['pps_mbox_iframe_order'][0]) ? $values['pps_mbox_iframe_order'][0] : 4,
		"mbox_pdf" => isset($values['pps_mbox_pdf_order'][0]) ? $values['pps_mbox_pdf_order'][0] : 5,
		"mbox_by_id" => isset($values['pps_mbox_by_id_order'][0]) ? $values['pps_mbox_by_id_order'][0] : 6,
	);
	
	$content_pps = "";
	
	asort($content_fields); // Ordenamos el Contenido del Popup
	foreach ($content_fields as $key => $val) {
    	
		if($key == 'mbox_editor'){
			// Contenido de "Editor Wordpress"
			if(!empty($content_editor) && $values['pps_use_wp_editor'][0] != 'false'){
				$content_pps .= '<li><div class="pps-content-wp-editor">'.$content_editor.'</div></li>';
				$numItems++;
			}
		}
		
		if($key == 'mbox_file'){
			// Contenido de "Cargador de Archivos"
			if( !empty($content_file)) {
				$file_link = isset($values['pps_file_repeatable_link'][0]) ? maybe_unserialize($values['pps_file_repeatable_link'][0]) : '';
				foreach ($content_file as $i => $file){
					$link_star = $link_end = '';
					if(is_array($file_link) && filter_var($file_link[$i], FILTER_VALIDATE_URL)){
						$link_star = '<a href="'. $file_link[$i]. '" target="'.$opt['where_open_link'].'">';
						$link_end = '</a>';
					}
					$check_image = preg_match( '/(^.*\.jpg|jpeg|png|gif|ico*)/i', $file );
					if($check_image){
							$content_pps .= '<li>'.$link_star.'<img src="'.$file.'" class="pps-img-slider" />'.$link_end.'</li>';
							$numItems++;
					}
				}
			}
		}
		
		if($key == 'mbox_oembed'){
			global $wp_embed;
			// Contenido de "URL de Medios"
			if( !empty($content_oembed)) {
				foreach ($content_oembed as $embed){
					$check_embed = $GLOBALS['wp_embed']->run_shortcode( '[embed]'. esc_url( $embed ) .'[/embed]' );
					if($check_embed){
							$content_pps .= '<li><div class="pps-embed">'.$check_embed.'</div></li>';
							$numItems++;
					}
				}
			}
		}
			
		if($key == 'mbox_iframe'){
			// Contenido de "Iframe"
			if( !empty($content_iframe)) {
				$content_pps .= '<li><div class="pps-iframe"><iframe src="'.$content_iframe.'" height="'.$values['pps_iframe_height'][0].'"></iframe></div></li>';
				$numItems++;
			}
		}
		
		if($key == 'mbox_pdf'){
			// Contenido de "PDF"
			$filetype = wp_check_filetype($content_pdf);
			if( !empty($content_pdf) and $filetype['ext'] == 'pdf') {
				$content_pps .= '<li><div class="pps-pdf"><iframe src="http://docs.google.com/gview?url='.$content_pdf.'&embedded=true" style="width:100%; height:100%;" frameborder="0"></iframe></div></li>';
				$numItems++;
			}
		}
		
		if($key == 'mbox_by_id'){
			// Contenido por "ID de Div"
			if( !empty($content_by_id)) {
				$content_pps .= '<li><div class="pps-content-by-id"></div></li>';
				$numItems++;
			}
		}
	}
	
	if($numItems <= 1){
		$content_popup = '<div class="pps-single-popup">'.$content_pps.'</div>';
		
	}else {
		$content_popup = '<div class="pps-popupslider" id="pps-slider-'.$popup_id.'"><ul id="slides-'.$popup_id.'" class="slides-pps">'.$content_pps.'</ul></div>';
	}
	return $content_popup;
}

/* ----------------------------------------------------------------------
   Función que Inserta el Cuerpo del Popup al Contenido de un Post /Page
---------------------------------------------------------------------- */

//add_filter('the_content', 'add_popup_post_PPS', 12);

function add_popup_post_PPS($content) {
	
	$regexPopuppress = '/\[popuppress(\s+)id=(\"|\')(\d+)(\"|\')/i';
	
	$num_popups = preg_match_all($regexPopuppress, get_the_content(), $shortcodes, PREG_PATTERN_ORDER);
	
	$popup = '';
	
	if($num_popups){
		$arrayShortcodes = $shortcodes[0];
		
		foreach ($arrayShortcodes as $shortcode) {
			$popup_id = preg_replace( '/[^0-9]/i', '', $shortcode);
			$popup .= get_popup_PPS($popup_id);
		}	
	}
	return $content.$popup;
}

/* --------------------------------------------------------------------
   Función que Actualiza el Número de Vistas de un Popup
-------------------------------------------------------------------- */

add_action('wp_ajax_update_views_popups', 'update_views_PPS');
add_action('wp_ajax_nopriv_update_views_popups', 'update_views_PPS');
function update_views_PPS(){
	$popup_id = $_POST['id'];
	$plugin = $_POST['plugin'];
	$restore = $_POST['restore'];
	// Seguridad
	if(empty($popup_id) || $plugin != 'popuppress')
		return;
		
	//Si la accion es para restaurar valores
	if($restore == 'yes'){
		$views_count = 0;
		update_post_meta($popup_id, 'pps-views', 0);
	}
	else {
		//Sumamos una 'vista' al Popup
		$views_count = (int) get_post_meta($popup_id, 'pps-views', true);
		update_post_meta($popup_id, 'pps-views', ++$views_count);
	}
	
	$result = array(
		'success' => true,
		'views' => $views_count,
	);
	echo json_encode($result);
	exit;
}



?>