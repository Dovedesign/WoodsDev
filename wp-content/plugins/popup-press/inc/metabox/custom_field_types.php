<?php
/* --------------------------------------------------------------------
   Campo Personalizado: Titulo 2
-------------------------------------------------------------------- */

add_action( 'cpmb_render_title2', 'title2_field_PPS', 10, 1 );
function title2_field_PPS( $field ) {
	if($field['name'])
		echo '<h5 class="cpmb_metabox_title2">', $field['name'], '</h5>';
	if($field['desc'])
		echo '<p class="cpmb_metabox_description">', $field['desc'], '</p>';
}


/* --------------------------------------------------------------------
   Campo Personalizado: Vista Previa
-------------------------------------------------------------------- */

add_action( 'cpmb_render_popup_preview', 'popup_preview_field_PPS', 10, 1 );
function popup_preview_field_PPS( $field ) {
	// Get the current ID
	if( isset( $_GET['post'] ) ) $post_id = $_GET['post'];
	elseif( isset( $_POST['post_ID'] ) ) $post_id = $_POST['post_ID'];
	echo '<p style="color:#888; margin: 6px 0 0;">';
	if( !isset( $post_id ) ) {
		echo 'Save to see the preview';
	}
	else {
		echo do_shortcode('[popuppress id="'.$post_id.'"]');
		echo get_popup_PPS($post_id);
	}
	echo '</p>';
}

/* --------------------------------------------------------------------
   Campo Personalizado: Texto Plano
-------------------------------------------------------------------- */

add_action( 'cpmb_render_plain_text', 'plain_text_field_PPS', 10, 1 );
function plain_text_field_PPS( $field ) {
	if($field['std'])
		echo $field['std'];
	if($field['desc'])
		echo '<p class="cpmb_metabox_description">', $field['desc'], '</p>';
}
/* --------------------------------------------------------------------
   Campo Personalizado: Más Opciones Avanzadas
-------------------------------------------------------------------- */

add_action( 'cpmb_render_more_fields', 'more_fields_field_PPS', 10, 1 );
function more_fields_field_PPS( $field) {
	echo '<p class="cpmb-filler">Advanced Fields</p><div class="cpmb-more-fields"><h5>Advanced Options <a href="#" class="cpmb-toggle-fields">Show</a></h5></div>';
}

/* --------------------------------------------------------------------
   Campo Personalizado: Iframe
-------------------------------------------------------------------- */

add_action( 'cpmb_render_iframe', 'iframe_field_PPS', 10, 2 );
function iframe_field_PPS( $field, $meta ) {
	echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', '' !== $meta ? $meta : $field['std'], '" />','<p class="cpmb_metabox_description">', $field['desc'], '</p>';
}

/* --------------------------------------------------------------------
   Campo Personalizado: oEmbed Repetible
-------------------------------------------------------------------- */

add_action( 'cpmb_render_oembed_repeatable', 'oembed_repeatable_field_PPS', 10, 2 );
function oembed_repeatable_field_PPS( $field, $metaArray ) {
    echo '<ul id="'.$field['id'].'-repeatable" class="custom_repeatable">';  
    $i = 0;
    if ($metaArray) {  
        foreach($metaArray as $meta) {
            echo '<li class="list-repeatable">'; 
				echo '<input class="cpmb_oembed" type="text" name="'. $field['id'].'['.$i.']" id="'. $field['id'].'_'.$i.'" value="'. $meta. '" />';
				
				echo '<p class="cpmb-spinner spinner" style="display:none;"><img src="'. admin_url( '/images/wpspin_light.gif' ) .'" alt="spinner"/></p>';
				echo '<div id="'. $field['id'].'_'.$i.'_status" class="cpmb_media_status ui-helper-clearfix embed_wrap">';
					if ( $meta != '' ) {
						$check_embed = $GLOBALS['wp_embed']->run_shortcode( '[embed]'. esc_url( $meta ) .'[/embed]' );
						if ( $check_embed ) {
							echo '<div class="embed_status">';
							echo $check_embed;
							//echo '<a href="#" class="cpmb_remove_file_button" rel="', $field['id'], '" title="'.__('Remove Embed','PPS').'">Remove Embed</a>';
							echo '</div>';
						} else {
							echo __('URL is not a valid oEmbed URL.','PPS');
						}
					}
				echo '</div>';
				echo '<a class="repeatable-remove" href="#" title="Remove">Remove</a>';
				echo '<span class="sort hndle" title="Move">|||</span>';
			echo '</li>'; 
            $i++;  
        }  
    } else {  
        echo '<li class="list-repeatable">'; 
				echo '<input class="cpmb_oembed" type="text" name="'. $field['id'].'['.$i.']" id="'. $field['id'].'_'.$i.'" value="" />';
				
				echo '<p class="cpmb-spinner spinner"></p>';
				echo '<div id="'. $field['id'].'_'.$i.'_status" class="cpmb_media_status ui-helper-clearfix embed_wrap">';
					
				echo '</div>';
				echo '<a class="repeatable-remove" href="#" title="'.__('Remove','PPS').'">Remove</a>';
				echo '<span class="sort hndle" title="'.__('Move','PPS').'">|||</span>';
			echo '</li>';
    }  
    echo '</ul><a class="repeatable-add button" href="#">Add New</a>'; 
}

/* --------------------------------------------------------------------
   Campo Personalizado: Más Opciones Avanzadas
-------------------------------------------------------------------- */

add_action( 'cpmb_render_file_repeatable_link', 'file_repeatable_link_field_PPS', 10, 1 );
function file_repeatable_link_field_PPS( $field) {
	// No hacer nada
}


/* --------------------------------------------------------------------
   Campo Personalizado: File Repetible
-------------------------------------------------------------------- */

add_action( 'cpmb_render_file_repeatable', 'file_repeatable_field_PPS', 10, 2 );
function file_repeatable_field_PPS( $field, $metaArray ) {
	global $post;
    echo '<ul id="'.$field['id'].'-repeatable" class="custom_repeatable">'; 
	 
	$file_link = get_post_meta($post->ID, 'pps_file_repeatable_link',true);
	$i = 0;
    if ($metaArray) {  
        foreach($metaArray as $i => $meta) {
			$link = is_array($file_link) ? $file_link[$i] : '';
			echo '<li class="list-repeatable cpmb-file-repeatable">';
				
				echo '<input class="cpmb_upload_file" type="text" size="45" id="'. $field['id'].'_'.$i. '" name="'. $field['id'].'['.$i.']" value="', $meta, '" />';
				echo '<input class="cpmb_upload_button button" type="button" value="Upload File" />';
				
				echo '<div class="cpmb-wrap-file-link"><spam>Popup link: </spam><input class="cpmb_upload_file_link" type="text" id="'. $field['id'].'_link_'.$i. '" name="'. $field['id'].'_link['.$i.']" value="'.$link. '" /></div>';
				
				echo '<input class="cpmb_upload_file_id" type="hidden" id="', $field['id'].'_id_'.$i.'" name="', $field['id'].'_id['.$i.']" value="'. get_post_meta( $post->ID, $field['id'].'_id_'.$i,true). '" />';
				
				
				echo '<div id="'. $field['id'].'_status_'.$i.'" class="cpmb_media_status">';
					if ( $meta != '' ) {
						$check_image = preg_match( '/(^.*\.jpg|jpeg|png|gif|ico*)/i', $meta );
						if ( $check_image ) {
							echo '<div class="img_status">';
							echo '<a href="'. $link. '" target="_blank"><img src="', $meta, '" alt="" /></a>';
							echo '<a href="#" class="cpmb_remove_file_button" rel="', $field['id'].'_'.$i. '" title="'.__('Remove Image','cpmb').'">Remove Image</a>';
							echo '</div>';
						} else {
							$parts = explode( '/', $meta );
							for( $j = 0; $j < count( $parts ); ++$j ) {
								$title = $parts[$j];
							}
							echo 'File: <strong>', $title, '</strong>&nbsp;&nbsp;&nbsp; (<a href="', $meta, '" target="_blank" rel="external">Download</a> / <a href="#" class="cpmb_remove_file_button" rel="', $field['id'].'_'.$i. '">Remove</a>)';
						}
					}
				echo '</div>';
				echo '<a class="repeatable-remove" href="#" title="'.__('Remove','PPS').'">Remove</a>';
				echo '<span class="sort hndle" title="'.__('Move','PPS').'">|||</span>';
			echo '</li>'; 
			$i++; 	
				
		}
    } else {  
        echo '<li class="list-repeatable cpmb-file-repeatable">'; 
				
				echo '<input class="cpmb_upload_file" type="text" size="45" id="'. $field['id'].'_'.$i. '" name="'. $field['id'].'['.$i.']" value="" />';
				echo '<input class="cpmb_upload_button button" type="button" value="Upload File" />';
				
				echo '<div class="cpmb-wrap-file-link"><spam>Popup link: </spam><input class="cpmb_upload_file_link" type="text" id="'. $field['id'].'_link_'.$i. '" name="'. $field['id'].'_link['.$i.']" value="" /></div>';
				
				echo '<input class="cpmb_upload_file_id" type="hidden" id="', $field['id'].'_id_'.$i.'" name="', $field['id'].'_id['.$i.']" value="" />';
				
				echo '<div id="'. $field['id'].'_status_'.$i.'" class="cpmb_media_status"><spam>Image preview</spam>';
				echo '</div>';
				echo '<a class="repeatable-remove" href="#" title="'.__('Remove','PPS').'">Remove</a>';
				echo '<span class="sort hndle" title="'.__('Move','PPS').'">|||</span>';
			echo '</li>';
    }  
    echo '</ul><a class="repeatable-add button" href="#">Add New</a>'; 
}

?>