<?php
/**
 * Include and setup custom metaboxes and fields.
 *
 * @category YourThemeOrPlugin
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
 */

add_filter( 'cpmb_meta_boxes', 'cpmb_sample_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function cpmb_sample_metaboxes( array $meta_boxes ) {

	// Start with an underscore to hide fields from custom fields list
	$prefix = 'pps_';
	
	// Get the current ID
	$post_id = 0;
	if( isset( $_GET['post'] ) )
		$post_id = $_GET['post'];
	
	// Default Options
	$std = get_option('pps_options');
	$values = get_post_custom($post_id);
	

	$meta_boxes['file_uploader_mbox_cpmb'] = array(
		'id'         => 'file_uploader_mbox_cpmb',
		'title'      => __( 'Image URL or Upload Image', 'cpmb' ),
		'pages'      => array( 'popuppress', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => false, // Show field names on the left
		// 'cpmb_styles' => true, // Enqueue the CPMB stylesheet on the frontend
		'fields'     => array(
			
			array(
				'name' => 'Image start',
				'id' => $prefix. 'slider_start_at_title',
				'type' => 'title',
				'desc' => __('', 'cpmb'),
			),
			array(
				'name' => __('', 'cpmb'),
				'id' => $prefix. 'slider_start_at',
				'type' => 'text_small',
				'std' => 1,
				'desc' => __('The slide that the slider should start on. (1 = first slide)', 'cpmb'),
			),
			array(
				'name' => __('Image or Image Slider', 'cpmb'),
				'id' => $prefix. 'image_slider_title',
				'type' => 'title',
				'desc' => __('Use these fields to upload images or add an image url', 'cpmb'),
			),
			
			array(
				'id' => $prefix. 'file_repeatable',
				'type' => 'file_repeatable',
				'allow' => array( 'url', 'attachment' ),
				'desc' => '',
			),
			array(
				'id' => $prefix. 'file_repeatable_link',
				'type' => 'file_repeatable_link',
				'desc' => '',
			)
		),
	);
	
	$meta_boxes[] = array(
		'id' => 'media_mbox_cpmb',
		'title' => __('Media Links', 'cpmb'),
		'pages' => array('popuppress'),
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => false, // Show field names on the left
		'fields' => array(
			array(
				'name' => __('Audio, video or other media', 'cpmb'),
				'id' => '',
				'type' => 'title',
				'desc' => __('Enter a Youtube, Vimeo, DailyMotion, SoundCloud, Twitter, or Instagram URL. Supports services listed at <a href="http://codex.wordpress.org/Embeds">Embeds</a>.', 'cpmb'),
			),
			array(
				'id' => $prefix. 'oembed_repeatable',
				'type' => 'oembed_repeatable',
				'desc' => '',
			),
		)
	);
	
	$meta_boxes[] = array(
		'id'         => 'iframe_mbox_cpmb',
		'title'      => __('Iframe Link', 'cpmb'),
		'pages'      => array( 'popuppress', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => false, // Show field names on the left
		'fields' => array(
			
			array(
				'name' => '',
				'id' => '',
				'type' => 'title2',
				'desc' => __('Add a url to load the content using Iframe', 'cpmb'),
			),
			array(
				'id' => $prefix. 'iframe',
				'type' => 'iframe',
				'desc' => '',
			),
			array(
				'name' => '',
				'id' => '',
				'type' => 'title2',
				'desc' => __('Add a height in pixels for the Iframe', 'cpmb'),
			),
			array(
				'id' => $prefix. 'iframe_height',
				'type' => 'text_small',
				'std' => '460',
				'desc' => '',
			)
		)
	);
	
	$meta_boxes[] = array(
		'id'         => 'pdf_mbox_cpmb',
		'title'      => __('Pdf Link', 'cpmb'),
		'pages'      => array( 'popuppress', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => false, // Show field names on the left
		'fields' => array(
			array(
				'name' => '',
				'id' => '',
				'type' => 'title2',
				'desc' => __('Insert PDF link', 'cpmb'),
			),
			array(
				'id' => $prefix. 'pdf',
				'type' => 'text',
				'desc' => '',
			),
		)
	);
	
	$meta_boxes[] = array(
		'id'         => 'divID_mbox_cpmb',
		'title'      => __('Custom Content from ID', 'cpmb'),
		'pages'      => array( 'popuppress', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => false, // Show field names on the left
		'fields' => array(
			
			array(
				'name' => '',
				'id' => '',
				'type' => 'title2',
				'desc' => __('Add the "id" of the container div that contains the content to insert into the Popup. e.g #div-container', 'cpmb'),
			),
			array(
				'id' => $prefix. 'content_by_id',
				'type' => 'text',
				'desc' => '',
			),
		)
	);

	$meta_boxes[] = array(
		'id' => 'preview_mbox_cpmb',
		'title' => __('Popup Preview', 'cpmb'),
		'pages' => array('popuppress'),
		'context' => 'side',
		'priority' => 'default',
		'show_names' => true, // Show field names on the left
		'fields' => array(
		
			array(
				'name' => __('Preview', 'cpmb'),
				'id' => $prefix. 'popup_preview',
				'type' => 'popup_preview',
				'desc' => __('Save to view preview', 'cpmb'),
			),
			array(
				'name' => __('Shortcode', 'cpmb'),
				'id' => '',
				'type' => 'plain_text',
				'std' => '<p style="margin: 5px 0 0; font-size:14px;">[popuppress id="'.$post_id.'"]</p>',
				'desc' => __('Use this Shortcode to display your Popup', 'cpmb'),
			),
		)
	);
	
	$meta_boxes[] = array(
		'id'         => 'button_mbox_cpmb',
		'title'      => __( 'Popup Button', 'cpmb' ),
		'pages'      => array( 'popuppress', ), // Post type
		'context'    => 'side',
		'priority'   => 'default',
		'show_names' => true, // Show field names on the left
		// 'cpmb_styles' => true, // Enqueue the CPMB stylesheet on the frontend
		'fields'     => array(
			array(
				'name' => __('Button Type', 'cpmb'),
				'id' => $prefix. 'button_type',
				'type' => 'radio',
				'std' => 'button',
				'options' => array(
					array('name' => __('Button','cpmb'), 'value' => 'button'),
					array('name' => __('Image','cpmb'), 'value' => 'image'),
					array('name' => __('Plain Text','cpmb'), 'value' => 'plain-text'),
					array('name' => __('No Button','cpmb'), 'value' => 'no-button'),
				),
				'desc' => __('Choose the type of button Popup<sub></sub>', 'cpmb'),
			),
			
			array(
				'name' => __('Button Text', 'cpmb'),
				'id' => $prefix. 'button_text',
				'type' => 'text',
				'std' => $std['button_text'],
				'desc' => __('Text for the button that opens the popup<sub></sub>', 'cpmb'),
			),
			
			array(
				'name' => __('Button Title', 'cpmb'),
				'id' => $prefix. 'button_title',
				'type' => 'text',
				'std' => $std['button_title'],
				'desc' => __('Button text on hover<sub></sub>', 'cpmb'),
			),
			array(
				'name' => __('Button Style Class', 'cpmb'),
				'id' => $prefix. 'button_class',
				'type' => 'text',
				'std' => $std['button_class'],
				'desc' => __('Add a Class to customize your button using CSS Styles.<sub></sub>', 'cpmb'),
			),
			array(
				'name' => __('Class to Execute Popup', 'cpmb'),
				'id' => $prefix. 'button_class_run',
				'type' => 'text',
				'std' => '',
				'desc' => __('This class will be used to run the popup when you click on it. E.g: run-popup. The default is "pps-button-popup-45", where 45 is the id of the popup. Without point.<sub></sub>', 'cpmb'),
			),
		
			array(
				'name' => 'Button Image',
				'id' => $prefix . 'button_image',
				'type' => 'file',
				'save_id' => false, // save ID using true
				'desc' => __('Upload an image or enter an URL.<sub></sub>', 'cpmb'),
			),
			array(
				'name' => __('Image Width Button', 'cpmb'),
				'id' => $prefix. 'img_width_button',
				'type' => 'text_small',
				'std' => $std['img_width_button'],
				'desc' => __('(px)', 'cpmb'),
			),
		),
	);

	/*
	Soluciona incompatibilidad con la opción
	"Open on Hover" de la versión anterior
	*/
	$run_method = 'click';
	if(isset($values[$prefix.'run_on_hover'][0])) {
		if($values[$prefix.'run_on_hover'][0] == 'yes') {
			$run_method = 'mouseover';
		}	
	}
	
	
	$meta_boxes[] = array(
		'id' => 'open_mbox_cpmb',
		'title' => __('Open Settings', 'cpmb'),
		'pages' => array('popuppress'),
		'context' => 'side',
		'priority' => 'default',
		'show_names' => true, // Show field names on the left
		'fields' => array(
		
			array(
				'name' => __('Open hook', 'cpmb'),
				'id' => $prefix. 'open_hook',
				'type' => 'radio',
				'std' => $run_method,
				'options' => array(
					array('name' => __('Click','cpmb'), 'value' => 'click'),
					array('name' => __('Hover','cpmb'), 'value' => 'mouseover'),
					array('name' => __('Leave page','cpmb'), 'value' => 'leave_page'),
				),
				'desc' => __('Action that will trigger the popup<sub></sub>', 'cpmb'),
			),
			
			array(
				'name' => __('Open in', 'cpmb'),
				'id' => $prefix. 'open_in',
				'type' => 'radio',
				'std' => 'pages',
				'options' => array(
					array('name' => __('Specific pages','cpmb'), 'value' => 'pages'),
					array('name' => __('Home','cpmb'), 'value' => 'home'),
					array('name' => __('All site','cpmb'), 'value' => 'all-site'),
					array('name' => __('Specific URL\'s','cpmb'), 'value' => 'urls'),
				),
				'desc' => __('Choose where to run the popup.<sub></sub>', 'cpmb'),
			),
			array(
				'name' => __('URL\'s', 'cpmb'),
				'id' => $prefix. 'open_in_url',
				'type' => 'textarea_small',
				'std' => '',
				'desc' => __('Add the Url\'s separated by commas. Use (*) at the end of the url to insert the popup at all daughters pages. E.g. (http://www.example.com/store/*)<sub></sub>', 'cpmb'),
			),
			
			array(
				'name' => __('Exclude pages', 'cpmb'),
				'id' => $prefix. 'exclude_pages',
				'type' => 'text',
				'std' => '',
				'desc' => __('Add page or post IDs separated by commas. e.g: 25,37. The popup will not appear on these pages<sub></sub>', 'cpmb'),
			),
		)
	);
	$meta_boxes[] = array(
		'id' => 'auto_open_mbox_cpmb',
		'title' => __('Automatically Open Settings', 'cpmb'),
		'pages' => array('popuppress'),
		'context' => 'side',
		'priority' => 'default',
		'show_names' => true, // Show field names on the left
		'fields' => array(
		
			array(
				'name' => __('Auto Open', 'cpmb'),
				'id' => $prefix. 'auto_open',
				'type' => 'radio_inline',
				'std' => 'false',
				'options' => array(
					array('name' => __('Yes','cpmb'), 'value' => 'true'),
					array('name' => __('Not','cpmb'), 'value' => 'false'),
				),
				'desc' => __('Opens automatically on page load<sub></sub>', 'cpmb'),
			),
			
			array(
				'name' => __('Open Delay (ms)', 'cpmb'),
				'id' => $prefix. 'delay',
				'type' => 'text',
				'std' => '2500',
				'desc' => __('Delay time to run the popup<sub></sub>', 'cpmb'),
			),
			
			array(
				'name' => __('Just first time', 'cpmb'),
				'id' => $prefix. 'first_time',
				'type' => 'radio_inline',
				'std' => 'false',
				'options' => array(
					array('name' => __('Yes','cpmb'), 'value' => 'true'),
					array('name' => __('Not','cpmb'), 'value' => 'false'),
				),
				'desc' => __('Opens only on the first load (Uses Cookies)<sub></sub>', 'cpmb'),
			),
			array(
				'name' => __('Lifetime of the Cookie', 'cpmb'),
				'id' => $prefix. 'cookie_expire',
				'type' => 'radio',
				'std' => 'current_session',
				'options' => array(
					array('name' => __('Current session','cpmb'), 'value' => 'current_session'),
					array('name' => __('Define lifetime','cpmb'), 'value' => 'number_days'),
				),
				'desc' => __('Define lifetime of the cookie.<sub></sub>', 'cpmb'),
			),
			
			array(
				'name' => __('Lifetime (days)', 'cpmb'),
				'id' => $prefix. 'cookie_days',
				'type' => 'text',
				'std' => '1',
				'desc' => __('Number which will be interpreted as days from lifetime of the cookie.<sub></sub>', 'cpmb'),
			),
			
			array(
				'name' => __('Auto close', 'cpmb'),
				'id' => $prefix. 'auto_close',
				'type' => 'radio_inline',
				'std' => 'false',
				'options' => array(
					array('name' => __('Yes','cpmb'), 'value' => 'true'),
					array('name' => __('Not','cpmb'), 'value' => 'false'),
				),
				'desc' => __('Automatically close the popup<sub></sub>', 'cpmb'),
			),
			array(
				'name' => __('Close Delay (ms)', 'cpmb'),
				'id' => $prefix. 'delay_close',
				'type' => 'text',
				'std' => '10000',
				'desc' => __('Delay time to close the popup<sub></sub>', 'cpmb'),
			),
			
		)
	);
	
	$meta_boxes[] = array(
		'id' => 'settings_mbox_cpmb',
		'title' => __('Popup Configuration', 'cpmb'),
		'pages' => array('popuppress'),
		'context' => 'side',
		'priority' => 'default',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			
			array(
				'name' => __('Popup Style', 'cpmb'),
				'id' => $prefix. 'popup_style',
				'type' => 'select',
				'std' => $std['popup_style'],
				'options' => array(
					array('name' => __('Light', 'cpmb'), 'value' => 'light'),
					array('name' => __('Dark', 'cpmb'), 'value' => 'dark'),
				),
				'desc' => __('Choose the style of the Popup<sub></sub>', 'cpmb'),
			),
			
			array(
				'name' => __('Show Transparent Border', 'cpmb'),
				'id' => $prefix. 'transparent_border',
				'type' => 'radio_inline',
				'std' => $std['transparent_border'],
				'options' => array(
					array('name' => __('Yes','cpmb'), 'value' => 'true'),
					array('name' => __('Not','cpmb'), 'value' => 'false'),
				),
				'desc' => __('Shows a transparent outline around the Popup<sub></sub>', 'cpmb'),
			),
			
			array(
				'name' => __('Border Radius (px)', 'cpmb'),
				'id' => $prefix. 'border_radius',
				'type' => 'text',
				'std' => $std['border_radius'],
				'desc' => __('Add value rounded corners to popup. 0 = no rounded corners.<sub></sub>', 'cpmb'),
			),
			
			array(
				'name' => __('Show Title', 'cpmb'),
				'id' => $prefix. 'show_title',
				'type' => 'radio_inline',
				'std' => $std['show_title'],
				'options' => array(
					array('name' => __('Yes','cpmb'), 'value' => 'true'),
					array('name' => __('Not','cpmb'), 'value' => 'false'),
				),
				'desc' => __('Displays the title of the popup<sub></sub>', 'cpmb'),
			),
			
			array(
				'name' => __('Show Close X', 'cpmb'),
				'id' => $prefix. 'show_close',
				'type' => 'radio_inline',
				'std' => 'true',
				'options' => array(
					array('name' => __('Yes','cpmb'), 'value' => 'true'),
					array('name' => __('Not','cpmb'), 'value' => 'false'),
				),
				'desc' => __('Displays the X icon close of the popup<sub></sub>', 'cpmb'),
			),
			
			array(
				'name' => __('Popup Width', 'cpmb'),
				'id' => $prefix. 'width',
				'type' => 'text_small',
				'std' => $std['popup_width'],
				'desc' => __('', 'cpmb'),
			),
			array(
				'name' => __('Width Units', 'cpmb'),
				'id' => $prefix. 'width_units',
				'type' => 'radio_inline',
				'std' => 'px',
				'options' => array(
					array('name' => __('px','cpmb'), 'value' => 'px'),
					array('name' => __('%','cpmb'), 'value' => '%'),
				),
				'desc' => __('Units of measure for the width<sub></sub>', 'cpmb'),
			),
			/*
			array(
				'name' => __('Auto Width', 'cpmb'),
				'id' => $prefix. 'auto_width',
				'type' => 'radio_inline',
				'std' => 'false',
				'options' => array(
					array('name' => __('Yes','cpmb'), 'value' => 'true'),
					array('name' => __('Not','cpmb'), 'value' => 'false'),
				),
				'desc' => __('Adjust width automatically<sub></sub>', 'cpmb'),
			),
			*/
			array(
				'name' => __('Popup Height', 'cpmb'),
				'id' => $prefix. 'height',
				'type' => 'text_small',
				'std' => $std['popup_height'],
				'desc' => __('', 'cpmb'),
			),
			array(
				'name' => __('Auto Height', 'cpmb'),
				'id' => $prefix. 'auto_height',
				'type' => 'radio_inline',
				'std' => $std['auto_height'],
				'options' => array(
					array('name' => __('Yes','cpmb'), 'value' => 'true'),
					array('name' => __('Not','cpmb'), 'value' => 'false'),
				),
				'desc' => __('Adjust height automatically<sub></sub>', 'cpmb'),
			),
			
			array(
				'name' => __('Background Overlay', 'cpmb'),
				'id' => $prefix. 'bg_overlay',
				'type' => 'colorpicker',
				'std' => $std['bg_overlay'],
				'desc' => __('Select a background color', 'cpmb'),
			),
			
			/*array(
				'name' => __('Advanced Settings', 'cpmb'),
				'id' => $prefix. 'more-fields',
				'type' => 'more_fields',
			),*/
			
			array(
				'name' => __('Opacity Overlay', 'cpmb'),
				'id' => $prefix. 'opacity',
				'type' => 'text',
				'std' => $std['opacity_overlay'],
				'desc' => __('Transparency, from 0.1 to 1<sub></sub>', 'cpmb'),
			),
			
			array(
				'name' => __('Position Type', 'cpmb'),
				'id' => $prefix. 'position_type',
				'type' => 'select',
				'std' => $std['position_type'],
				'options' => array(
					array('name' => __('Absolute', 'cpmb'), 'value' => 'absolute'),
					array('name' => __('Fixed', 'cpmb'), 'value' => 'fixed'),
				),
				'desc' => '',
			),
			array(
				'name' => __('Position X (px)', 'cpmb'),
				'id' => $prefix. 'position_x',
				'type' => 'text',
				'std' => $std['position_x'],
				'desc' => __('Position horizontal the popup. auto=center<sub></sub>', 'cpmb'),
			),
			array(
				'name' => __('Position Y (px)', 'cpmb'),
				'id' => $prefix. 'position_y',
				'type' => 'text',
				'std' => $std['position_y'],
				'desc' => __('Position vertical the popup. auto=center<sub></sub>', 'cpmb'),
			),
			array(
				'name' => __('Popup Speed (ms)', 'cpmb'),
				'id' => $prefix. 'speed',
				'type' => 'text',
				'std' => $std['popup_speed'],
				'desc' => __('Animation speed on open/close, in milliseconds<sub></sub>', 'cpmb'),
			),
			array(
				'name' => __('Popup z-index', 'cpmb'),
				'id' => $prefix. 'zindex',
				'type' => 'text',
				'std' => $std['popup_zindex'],
				'desc' => __('Set the z-index for Popup<sub></sub>', 'cpmb'),
			),
			array(
				'name' => __('Close Click Overlay', 'cpmb'),
				'id' => $prefix. 'close_overlay',
				'type' => 'radio_inline',
				'std' => $std['close_overlay'],
				'options' => array(
					array('name' => __('Yes','cpmb'), 'value' => 'true'),
					array('name' => __('Not','cpmb'), 'value' => 'false'),
				),
				'desc' => __('Should the popup close on click on overlay?<sub></sub>', 'cpmb'),
			),
			
			array(
				'name' => __('Transition Effect', 'cpmb'),
				'id' => $prefix. 'popup_transition',
				'type' => 'select',
				'std' => $std['popup_transition'],
				'options' => array(
					array('name' => __('fadeIn', 'cpmb'), 'value' => 'fadeIn'),
					array('name' => __('slideDown', 'cpmb'), 'value' => 'slideDown'),
					array('name' => __('slideIn', 'cpmb'), 'value' => 'slideIn'),
				),
				'desc' => __('The transition of the popup when it opens.<sub></sub>', 'cpmb'),
			),
			
			array(
				'name' => __('Easing Effect', 'cpmb'),
				'id' => $prefix. 'popup_easing',
				'type' => 'text',
				'std' => $std['popup_easing'],
				'desc' => sprintf(__( 'The easing of the popup when it opens. "swing" and "linear". More in %sjQuery Easing%s <sub></sub>', 'cpmb' ), '<a href="http://jqueryui.com/resources/demos/effect/easing.html" target="_blank">','</a>'),
			),
			
			array(
				'name' => __('Use WP Editor', 'cpmb'),
				'id' => $prefix. 'use_wp_editor',
				'type' => 'radio_inline',
				'std' => $std['use_wp_editor'],
				'options' => array(
					array('name' => __('Yes','cpmb'), 'value' => 'true'),
					array('name' => __('Not','cpmb'), 'value' => 'false'),
				),
				'desc' => __('If you mark "Not", the Popup will not take content from the Wordpress editor.<sub></sub>', 'cpmb'),
			),
		)
	);
	
	
	$meta_boxes[] = array(
		'id' => 'slider_mbox_cpmb',
		'title' => __('Slider Settings', 'cpmb'),
		'pages' => array('popuppress'),
		'context' => 'side',
		'priority' => 'default',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			
			array(
				'name' => __('Automatically animate', 'cpmb'),
				'id' => $prefix. 'slider_auto',
				'type' => 'radio_inline',
				'std' => $std['slider_auto'],
				'options' => array(
					array('name' => __('Yes','cpmb'), 'value' => 'true'),
					array('name' => __('Not','cpmb'), 'value' => 'false'),
				),
				'desc' => __('Automatically animate the slider<sub></sub>', 'cpmb'),
			),
			array(
				'name' => __('Transition Speed (ms)', 'cpmb'),
				'id' => $prefix. 'slider_speed',
				'type' => 'text',
				'std' => $std['slider_speed'],
				'desc' => __('Speed of the transition, in milliseconds<sub></sub>', 'cpmb'),
			),
			
			array(
				'name' => __('Timeout (ms)', 'cpmb'),
				'id' => $prefix. 'slider_timeout',
				'type' => 'text',
				'std' => $std['slider_timeout'],
				'desc' => __('Time between slide transitions, in milliseconds<sub></sub>', 'cpmb'),
			),
			array(
				'name' => __('Show pagination', 'cpmb'),
				'id' => $prefix. 'slider_pagination',
				'type' => 'radio_inline',
				'std' => $std['slider_pagination'],
				'options' => array(
					array('name' => __('Yes','cpmb'), 'value' => 'true'),
					array('name' => __('Not','cpmb'), 'value' => 'false'),
				),
				'desc' => __('Displays small buttons to scroll between slider items<sub></sub>', 'cpmb'),
			),
			array(
				'name' => __('Show arrows', 'cpmb'),
				'id' => $prefix. 'slider_arrows',
				'type' => 'radio_inline',
				'std' => $std['slider_arrows'],
				'options' => array(
					array('name' => __('Yes','cpmb'), 'value' => 'true'),
					array('name' => __('Not','cpmb'), 'value' => 'false'),
				),
				'desc' => __('Displays arrows to scroll between slider items<sub></sub>', 'cpmb'),
			),
			array(
				'name' => __('Pause on hover', 'cpmb'),
				'id' => $prefix. 'slider_pause',
				'type' => 'radio_inline',
				'std' => $std['slider_pause'],
				'options' => array(
					array('name' => __('Yes','cpmb'), 'value' => 'true'),
					array('name' => __('Not','cpmb'), 'value' => 'false'),
				),
				'desc' => __('Pause animation when the cursor is over the slider<sub></sub>', 'cpmb'),
			),
		)
	);
	
	$meta_boxes[] = array(
		'id' => 'sort_mbox_cpmb',
		'title' => __('Sort content fields', 'cpmb'),
		'pages' => array('popuppress'),
		'context' => 'side',
		'priority' => 'default',
		'show_names' => true, // Show field names on the left
		'fields' => array(
		
			array(
				'name' => '',
				'id' => '',
				'type' => 'title2',
				'desc' => __('Use these fields to sort the contents of the popup.<sub></sub>', 'cpmb'),
			),
			
			array(
				'name' => __('Wordpress Editor', 'cpmb'),
				'id' => $prefix. 'mbox_editor_order',
				'type' => 'select',
				'std' => 1,
				'options' => array(
					array('name' => __(1, 'cpmb'), 'value' => 1),
					array('name' => __(2, 'cpmb'), 'value' => 2),
					array('name' => __(3, 'cpmb'), 'value' => 3),
					array('name' => __(4, 'cpmb'), 'value' => 4),
					array('name' => __(5, 'cpmb'), 'value' => 5),
					array('name' => __(6, 'cpmb'), 'value' => 6),
				),
			),
			array(
				'name' => __('Image URL or Upload Image', 'cpmb'),
				'id' => $prefix. 'mbox_file_order',
				'type' => 'select',
				'std' => 2,
				'options' => array(
					array('name' => __(1, 'cpmb'), 'value' => 1),
					array('name' => __(2, 'cpmb'), 'value' => 2),
					array('name' => __(3, 'cpmb'), 'value' => 3),
					array('name' => __(4, 'cpmb'), 'value' => 4),
					array('name' => __(5, 'cpmb'), 'value' => 5),
					array('name' => __(6, 'cpmb'), 'value' => 6),
				),
			),
			array(
				'name' => __('Media Links', 'cpmb'),
				'id' => $prefix. 'mbox_oembed_order',
				'type' => 'select',
				'std' => 3,
				'options' => array(
					array('name' => __(1, 'cpmb'), 'value' => 1),
					array('name' => __(2, 'cpmb'), 'value' => 2),
					array('name' => __(3, 'cpmb'), 'value' => 3),
					array('name' => __(4, 'cpmb'), 'value' => 4),
					array('name' => __(5, 'cpmb'), 'value' => 5),
					array('name' => __(6, 'cpmb'), 'value' => 6),
				),
			),
			array(
				'name' => __('Iframe Link', 'cpmb'),
				'id' => $prefix. 'mbox_iframe_order',
				'type' => 'select',
				'std' => 4,
				'options' => array(
					array('name' => __(1, 'cpmb'), 'value' => 1),
					array('name' => __(2, 'cpmb'), 'value' => 2),
					array('name' => __(3, 'cpmb'), 'value' => 3),
					array('name' => __(4, 'cpmb'), 'value' => 4),
					array('name' => __(5, 'cpmb'), 'value' => 5),
					array('name' => __(6, 'cpmb'), 'value' => 6),
				),
			),
			array(
				'name' => __('Pdf Link', 'cpmb'),
				'id' => $prefix. 'mbox_pdf_order',
				'type' => 'select',
				'std' => 5,
				'options' => array(
					array('name' => __(1, 'cpmb'), 'value' => 1),
					array('name' => __(2, 'cpmb'), 'value' => 2),
					array('name' => __(3, 'cpmb'), 'value' => 3),
					array('name' => __(4, 'cpmb'), 'value' => 4),
					array('name' => __(5, 'cpmb'), 'value' => 5),
					array('name' => __(6, 'cpmb'), 'value' => 6),
				),
			),
			array(
				'name' => __('Custom Content from ID', 'cpmb'),
				'id' => $prefix. 'mbox_by_id_order',
				'type' => 'select',
				'std' => 6,
				'options' => array(
					array('name' => __(1, 'cpmb'), 'value' => 1),
					array('name' => __(2, 'cpmb'), 'value' => 2),
					array('name' => __(3, 'cpmb'), 'value' => 3),
					array('name' => __(4, 'cpmb'), 'value' => 4),
					array('name' => __(5, 'cpmb'), 'value' => 5),
					array('name' => __(6, 'cpmb'), 'value' => 6),
				),
			),
		)
	);

	return $meta_boxes;
}

add_action( 'init', 'cpmb_initialize_cpmb_meta_boxes', 9999 );
/**
 * Initialize the metabox class.
 */
function cpmb_initialize_cpmb_meta_boxes() {
			
	if ( ! class_exists( 'cpmb_Meta_Box' ) )
		require_once 'init.php';
	
}

include_once('custom_field_types.php');