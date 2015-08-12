<?php

// This will Hide the WordPress jquery load and replace with the one chosen below
if( !is_admin()){
	wp_deregister_script('jquery');
	wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"), false, '1.11.2');
	wp_enqueue_script('jquery');
}

add_action( 'soliloquy_api_on_load', 'tgm_soliloquy_autoplay_vimeo_on_load' );
function tgm_soliloquy_autoplay_vimeo_on_load( $data ) {

    ob_start();
    ?>
    var slide_video = soliloquy_<?php echo $data['id']; ?>.find('.soliloquy-item:not(.soliloquy-clone):eq(' + currentIndex + ') .soliloquy-video-icon');
    if ( slide_video.length > 0 ) {
        var video_type = slide_video.data('soliloquy-video-type');
        if ( 'vimeo' == video_type ) {
            var video_id = slide_video.data('soliloquy-video-id');
            if ( ! soliloquy_vimeo[video_id] ) {
                setTimeout(function(){
                    slide_video.trigger('click');
                }, 500);
            }
        }
    }
    <?php
    echo ob_get_clean();

}

add_action( 'soliloquy_api_after_transition', 'tgm_soliloquy_autoplay_vimeo_on_transition' );
function tgm_soliloquy_autoplay_vimeo_on_transition( $data ) {

    ob_start();
    ?>
    var slide_video = $(element).find('.soliloquy-video-icon');
    if ( slide_video.length > 0 ) {
        var video_type = slide_video.data('soliloquy-video-type');
        if ( 'vimeo' == video_type ) {
            var video_id = slide_video.data('soliloquy-video-id');
            if ( ! soliloquy_vimeo[video_id] ) {
                setTimeout(function(){
                    slide_video.trigger('click');
                }, 500);
            }
        }
    }
    <?php
    echo ob_get_clean();

}

add_action( 'soliloquy_api_on_load', 'tgm_soliloquy_autoplay_youtube_on_load' );
function tgm_soliloquy_autoplay_youtube_on_load( $data ) {

    ob_start();
    ?>
    var slide_video = soliloquy_<?php echo $data['id']; ?>.find('.soliloquy-item:not(.soliloquy-clone):eq(' + currentIndex + ') .soliloquy-video-icon');
    if ( slide_video.length > 0 ) {
        var video_type = slide_video.data('soliloquy-video-type');
        if ( 'youtube' == video_type ) {
            var video_id = slide_video.data('soliloquy-video-id');
            if ( ! soliloquy_youtube[video_id] ) {
                setTimeout(function(){
                    slide_video.trigger('click');
                }, 500);
            }
        }
    }
    <?php
    echo ob_get_clean();

}

add_action( 'soliloquy_api_after_transition', 'tgm_soliloquy_autoplay_youtube_on_transition' );
function tgm_soliloquy_autoplay_youtube_on_transition( $data ) {

    ob_start();
    ?>
    var slide_video = $(element).find('.soliloquy-video-icon');
    if ( slide_video.length > 0 ) {
        var video_type = slide_video.data('soliloquy-video-type');
        if ( 'youtube' == video_type ) {
            var video_id = slide_video.data('soliloquy-video-id');
            if ( ! soliloquy_youtube[video_id] ) {
                setTimeout(function(){
                    slide_video.trigger('click');
                }, 500);
            }
        }
    }
    <?php
    echo ob_get_clean();

}

/*
// This will add Widget's to the theme
function arphabet_widgets_init() {

	register_sidebar( array(
		'name' => 'Footer',
		'id' => 'home_right_1',
		'description' => __( 'Widgets in this area will be shown in the Footer.' ),
		'before_widget' => '<div>',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="rounded">',
		'after_title' => '</h2>',
	) );
}
add_action( 'widgets_init', 'arphabet_widgets_init' );
*/

remove_action('wp_head', 'wp_generator');

add_filter('login_errors',create_function('$a', "return null;"));

// This will Hide the WordPress Upgrade Message in the Dashboard
add_action('admin_menu','wphidenag');
function wphidenag() {
remove_action( 'admin_notices', 'update_nag', 3 );
}

// This will made the Image Link Default to none; so when uploading a new image it doesn't automatically set to link to itself
update_option('image_default_link_type','none');

// This will made the Image Alignment Default to none; so when uploading a new image it sets the alignment to none
update_option('image_default_align','none');

// This will add Menu's to the theme
add_theme_support( 'menus' );

/* Allow SVG through WordPress Media Uploader */

function cc_mime_types( $mimes ){
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter( 'upload_mimes', 'cc_mime_types' );

function is_tree($pid) {      // $pid = The ID of the page we're looking for pages underneath
	global $post;         // load details about this page
	$anc = get_post_ancestors( $post->ID );
	foreach($anc as $ancestor) {
		if(is_page() && $ancestor == $pid) {
			return true;
		}
	}
	if(is_page()&&(is_page($pid)))
		return true;   // we're at the page or at a sub page
	else
		return false;  // we're elsewhere
};

/*
function kriesi_pagination($pages = '', $range = 2)
{
     $showitems = ($range * 2)+1;

     global $paged;
     if(empty($paged)) $paged = 1;

     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }

     if(1 != $pages)
     {
         echo "<div class='pagination'>";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo;</a>";
         if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a>";

         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>";
             }
         }

         if ($paged < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a>";
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>&raquo;</a>";
         echo "</div>\n";
     }
}
*/

/*// This will allow WordPress to upload vCards
add_filter('upload_mimes', 'add_vcard_upload_support');
function add_vcard_upload_support($mimes)
{
	$mimes['vcf|vcard'] = 'text/x-vcard';
	return $mimes;
}*/

/*// you can get the Root parent by adding this snippet to your functions.php:
function get_root_parent($page_id) {
global $wpdb;
	$parent = $wpdb->get_var("SELECT post_parent FROM $wpdb->posts WHERE post_type='page' AND ID = '$page_id'");
	if ($parent == 0) return $page_id;
	else return get_root_parent($parent);
}
//then use this in your template:
//$root_parent = get_root_parent($post->ID);*/

/*// excerpt stop stripping links and formatting
function improved_trim_excerpt($text) {
        global $post;
        if ( '' == $text ) {
                $text = get_the_content('');
                $text = apply_filters('the_content', $text);
                $text = str_replace('\]\]\>', ']]&gt;', $text);
                $text = preg_replace('@<script[^>]*?>.*?</script>@si', '', $text);
                $text = strip_tags($text, '<p><a><br><strong><h1><h2><h3>');
                $excerpt_length = 60;
                $words = explode(' ', $text, $excerpt_length + 1);
                if (count($words)> $excerpt_length) {
                        array_pop($words);
                        array_push($words, ' <a href="'. get_permalink($post->ID) . '">' . 'read more &gt;' . '</a>');
                        $text = implode(' ', $words);
                }
        }
        return $text;
}
remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'improved_trim_excerpt');*/


// excerpt stop stripping links and formatting
function improved_trim_excerpt($text) {
        global $post;
        if (is_front_page()) {
                $text = get_the_content('');
                $excerpt_length = 25;
                $words = explode(' ', $text, $excerpt_length + 1);
                if (count($words)> $excerpt_length) {
                        array_pop($words);
                        array_push($words, '' . '...' . '');
                        $text = implode(' ', $words);
                }
        }
        else {
                $text = get_the_content('');
                $text = apply_filters('the_content', $text);
                $text = str_replace('\]\]\>', ']]&gt;', $text);
                $text = preg_replace('@<script[^>]*?>.*?</script>@si', '', $text);
                $text = strip_tags($text, '<p><a><br><strong><h1><h2><h3>');
                $excerpt_length = 50;
                $words = explode(' ', $text, $excerpt_length + 1);
                if (count($words)> $excerpt_length) {
                        array_pop($words);
                        array_push($words, '');
                        $text = implode(' ', $words);
                }
        }
        return $text;
}
remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'improved_trim_excerpt');


/*
// Custom Sidebar Teaser length (LIKE ON JCLEWIS HEALTH SITE)

function get_the_sidebar_excerpt($excerpt_length = 15, $ending = '...', $superending = null)
{
    $text = get_the_content('');
    $text = apply_filters('the_content', $text);
    $text = str_replace('\]\]\>', ']]&gt;', $text);
    $text = preg_replace('@<script[^>]*?>.*?</script>@si', '', $text);
    $text = strip_tags($text, '<p><a><br><strong><h1><h2><h3>');

	$words = preg_split("/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
	if ( count($words) > $excerpt_length ) {
		array_pop($words);
		$text = implode(' ', $words);
		$text = $text . $ending;
		return '<p>'.$text.'</p>'.$superending;
	} else {
		$text = implode(' ', $words);
		return '<p>'.$text.'</p>';
	}
}
*/
/*<?php echo get_the_sidebar_excerpt(); ?>*/

/*// Custom News Ticker Teaser length

function get_the_newsticker_excerpt($excerpt_length = 10, $ending = ' ...', $superending = null)
{
	$text = get_the_content('');
	$text = strip_shortcodes( $text );

	$text = apply_filters('the_content', $text);
	$text = str_replace(']]>', ']]&gt;', $text);
	$text = strip_tags($text);

	$words = preg_split("/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
	if ( count($words) > $excerpt_length ) {
		array_pop($words);
		$text = implode(' ', $words);
		$text = $text . $ending;
		return '<p>'.$text.'</p>'.$superending;
	} else {
		$text = implode(' ', $words);
		return '<p>'.$text.'</p>';
	}
}*/
/*<?php echo get_the_newsticker_excerpt(); ?>*/

/*// custom admin login logo max 325px Width max 67px Height
function custom_login_logo() {
	echo '<style type="text/css">
	h1 a { background-image: url('.get_bloginfo('template_directory').'/images/custom-login-logo.png) !important; background-size: 144px 68px !important; }
	</style>';
}
add_action('login_head', 'custom_login_logo');*/

/*// custom exclude categories from blog/news & archive page
function exclude_category($query) {
	if ( $query->is_home || $query->is_archive ) {
		$query->set('cat', '-4,-3,-5');
	}
return $query;
}

add_filter('pre_get_posts', 'exclude_category');

// custom exclude categories from wp_get_archives pull
add_filter( 'getarchives_where', 'customarchives_where' );
add_filter( 'getarchives_join', 'customarchives_join' );

function customarchives_join( $x ) {
	global $wpdb;
	return $x . " INNER JOIN $wpdb->term_relationships ON ($wpdb->posts.ID = $wpdb->term_relationships.object_id) INNER JOIN $wpdb->term_taxonomy ON ($wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id)";
}

function customarchives_where( $x ) {
	global $wpdb;
	$exclude = '4,3,5'; // category id to exclude
	return $x . " AND $wpdb->term_taxonomy.taxonomy = 'category' AND $wpdb->term_taxonomy.term_id NOT IN ($exclude)";
}*/

/*// custom excerpt teaser length for ALL
function new_excerpt_length($length) {
	return 25;
}
add_filter('excerpt_length', 'new_excerpt_length');

function new_excerpt_more($post) {
	return '<a href="'. get_permalink($post->ID) . '">' . '...' . '</a>';
}
add_filter('excerpt_more', 'new_excerpt_more');*/

/*// custom excerpt teaser length if page or ALL
function new_excerpt_length($length) {
	if (is_front_page()) {
		return 14;
	}
	else {
		return 50;
	}
}
add_filter('excerpt_length', 'new_excerpt_length');

function new_excerpt_more($post) {
	return '<a href="'. get_permalink($post->ID) . '">' . '...' . '</a>';
}
add_filter('excerpt_more', 'new_excerpt_more');*/

/*// Manipulate Child Pages of a specific page to auto apply an assigned template
$page_children = get_pages('child_of=24');
foreach($page_children as $child){
	$current_page_template = get_post_meta($child->ID,'_wp_page_template',true);
	if($current_page_template != 'bio-attorney.php') update_post_meta($child->ID,'_wp_page_template','bio-attorney.php');
}*/

/*// Manipulate Child Pages to Use Parent Page Templates Automatically
function switch_page_template(){
    global $post;
        if(is_page()){// Checks if current post type is a page, rather than a post

    $current_page_template = get_post_meta($post->ID,'_wp_page_template',true);
        $parent_page_template = get_post_meta($post->post_parent,'_wp_page_template',true);
        $parents = (is_page() && $post->post_parent==$post->ID) ? return true : return false;
    if($parents){update_post_meta($post->ID,'_wp_page_template',$parent_page_template,$current_page_template);

        }// End check for page
}
add_action('save_post','switch_page_template');*/

/*// Automatically remove p tags on images
function filter_ptags_on_images($content){
    return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

add_filter('the_content', 'filter_ptags_on_images');*/

/*// Restrict ADMIN menu items based on username, replace username with an actual user's name.
function remove_menus()
{
    global $menu;
    global $current_user;
    get_currentuserinfo();

    if($current_user->user_login == 'username')
    {
        $restricted = array(__('Posts'),
                            __('Media'),
                            __('Links'),
                            __('Pages'),
                            __('Comments'),
                            __('Appearance'),
                            __('Plugins'),
                            __('Users'),
                            __('Tools'),
                            __('Settings')
        );
        end ($menu);
        while (prev($menu)){
            $value = explode(' ',$menu[key($menu)][0]);
            if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
        }// end while

    }// end if
}
add_action('admin_menu', 'remove_menus');*/

?>