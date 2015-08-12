<?php
/*
Template Name: Home
*/
?>
<?php get_header(); ?>
<?php if ( function_exists( 'soliloquy' ) ) { soliloquy( 'hp-slider', 'slug' ); } ?>
<div class="band" id="middle">
	<div class="container">
		<div class="four columns directions-btn icon-btn">
			<a href="<?php echo get_permalink('11'); ?>" class="btn" title="Directions"><span class="icon" style="background-image: url(<?php bloginfo('stylesheet_directory'); ?>/images/btn-icon_directions.svg);">Directions</span></a>
		</div>
		<div class="three columns call-btn icon-btn">
			<a href="<?php echo get_permalink('11'); ?>" class="btn" title="Call"><span class="icon" style="background-image: url(<?php bloginfo('stylesheet_directory'); ?>/images/btn-icon_call.svg);">Call</span></a>
		</div>
		<div class="three columns text-btn icon-btn mobile">
			<a href="sms:1-352-395–6110" class="btn" title="Text Us"><span class="icon" style="background-image: url(<?php bloginfo('stylesheet_directory'); ?>/images/btn-icon_text.svg);">Text Us</span></a>
		</div>
		<div class="three columns text-btn textus-btn icon-btn non-mobile">
			<a href="https://app.textus.biz/widget/1/kAIOWcRd6Nr4AyJns1c1cK81xWw/contents" data-fancybox-type="iframe" class="btn inline" title="Text Us"><span class="icon" style="background-image: url(<?php bloginfo('stylesheet_directory'); ?>/images/btn-icon_text.svg);">Text Us</span></a>
		</div>
		<?php /*?>
		<div class="three columns textus-btn icon-btn non-mobile">
			<script src="https://app.textus.biz/widget/1/F3GzPdp5gRWPoSAaHBlxwnW7WdU/embedded.js?textus-image=square-button&textus-type=button"></script>
			<div id="text-us-placeholder"></div>
		</div><?php */?>
		<div class="six columns">
			<a href="<?php echo get_permalink('15'); ?>" class="btn green" title="Request More Info">Request More Info</a>
		</div>
		<div class="eight columns circle-text-photo">
			<?php if(get_field('callout_left_title')) : ?><h2>
			<?php if(get_field('callout_left_link')) : ?><a href="<?php the_field('callout_left_link'); ?>" title="<?php the_field('callout_left_title'); ?>"><?php else: ?><?php endif; ?><?php the_field('callout_left_title'); ?><?php if(get_field('callout_left_link')) : ?></a><?php else: ?><?php endif; ?></h2><?php else: ?><?php endif; ?>
			<?php $callout_left_photo = get_post_meta($post->ID, 'callout_left_photo', true); if ($callout_left_photo) { ?><div class="circle-photo"><?php if(get_field('callout_left_link')) : ?><a href="<?php the_field('callout_left_link'); ?>" title="<?php the_field('callout_left_title'); ?>"><?php else: ?><?php endif; ?><img src="<?php echo wp_get_attachment_url($callout_left_photo); ?>" alt="<?php the_field('callout_left_title'); ?>" /><?php if(get_field('callout_left_link')) : ?></a><?php else: ?><?php endif; ?></div><?php } else { ?><?php } ?>
			<?php if(get_field('callout_left_content')) : ?><div class="circle-text"><?php the_field('callout_left_content'); ?></div><?php else: ?><?php endif; ?>
		</div>
		<div class="eight columns circle-text-photo">
			<?php if(get_field('callout_right_title')) : ?><h2>
			<?php if(get_field('callout_right_link')) : ?><a href="<?php the_field('callout_right_link'); ?>" title="<?php the_field('callout_right_title'); ?>"><?php else: ?><?php endif; ?><?php the_field('callout_right_title'); ?><?php if(get_field('callout_right_link')) : ?></a><?php else: ?><?php endif; ?></h2><?php else: ?><?php endif; ?>
			<?php $callout_right_photo = get_post_meta($post->ID, 'callout_right_photo', true); if ($callout_right_photo) { ?><div class="circle-photo"><?php if(get_field('callout_right_link')) : ?><a href="<?php the_field('callout_right_link'); ?>" title="<?php the_field('callout_right_title'); ?>"><?php else: ?><?php endif; ?><img src="<?php echo wp_get_attachment_url($callout_right_photo); ?>" alt="<?php the_field('callout_right_title'); ?>" /><?php if(get_field('callout_right_link')) : ?></a><?php else: ?><?php endif; ?></div><?php } else { ?><?php } ?>
			<?php if(get_field('callout_right_content')) : ?><div class="circle-text"><?php the_field('callout_right_content'); ?></div><?php else: ?><?php endif; ?>
		</div>
	</div>
</div>
<div class="band" id="look">
	<div class="container">
		<div class="sixteen columns">
			<?php if(get_field('video_box_title')) : ?><h2><?php the_field('video_box_title'); ?></h2><?php else: ?><?php endif; ?>
			<?php if(get_field('video_box_video_url')) : ?><div class="video"><iframe src="<?php the_field('video_box_video_url'); ?>" width="900" height="506" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></div><?php else: ?><?php endif; ?>
			<?php if(get_field('video_box_content')) : ?><div class="content"><?php the_field('video_box_content'); ?></div><?php else: ?><?php endif; ?>
		</div>
	</div>
</div>
<?php get_template_part('inc-why'); ?>
<!--
<style>
	<?php $other_page = 6; ?><?php if(get_field('featured_photo_gallery_hp', $other_page)) : ?>#featured-gallery .photo-gallery.fb-group<?php the_field('featured_photo_gallery_hp', $other_page); ?> { display: block; }<?php else: ?><?php endif; ?>
</style>
-->
<div class="band" id="featured-gallery">
	<div class="container">
		<?php $other_page = 6; ?><?php if($rows = get_field('photos_tab', $other_page)): ?>
		<?php $i = 1; ?><?php while(the_repeater_field('photos_tab', $other_page)): ?>
		<div class="photo-gallery fb-group<?php echo $i; ?>">
			<?php if(get_sub_field('photo_gallery_title')) : ?><div class="sixteen columns title"><h1 class="page-title"><?php the_sub_field('photo_gallery_title'); ?></h1></div><?php else: ?><?php endif; ?>
			<div class="clear"></div>
		    <div id="slider-wrapper">
		    	<div id="slider-controls">
			        <a href="#" class="prev"></a>
			        <a href="#" class="next"></a>
		    	</div>
		        <div id="slider-container-fhp">
					<?php if(get_sub_field('photo_gallery')): ?>
					<?php while(has_sub_field('photo_gallery')): ?>
						<div class="slider"><?php if(get_sub_field('photo')) : ?><img src="<?php the_sub_field('photo'); ?>" /><?php else: ?><?php endif; ?></div>
					<?php endwhile; ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php $i++; ?><?php endwhile; ?>
		<?php endif; ?>
	</div>
</div>
<div class="band" id="blog">
	<div class="container">
		<div class="sixteen columns">
			<h2 class="title"><a href="<?php echo get_permalink('12'); ?>"><?php $other_page = 12; ?><?php if(get_field('page_title_override', $other_page)) : ?><?php the_field('page_title_override', $other_page); ?><?php else: ?><?php echo get_the_title('12'); ?><?php endif; ?></a></h2>
		</div>
		<?php $posts = get_field('featured_blog_events'); if( $posts ): ?>
		<?php foreach( $posts as $post): // variable must be called $post (IMPORTANT) ?>
			<?php setup_postdata($post); ?>
		<div class="four columns featured-blog-post fbp<?php echo ($xyz++%4); ?>">
			<h3 class="blog-title"><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php if(get_field('entry_number')) : ?><span class="entry-number">BLOG ENTRY <?php the_field('entry_number'); ?>:</span><br /><?php else: ?><?php endif; ?><?php the_title(); ?></a></h3>
			<?php $featured_image = get_post_meta($post->ID, 'featured_image', true); if ($featured_image) { ?><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><img src="<?php echo wp_get_attachment_url($featured_image); ?>" alt="<?php the_title(); ?>" class="featured-image" /></a><?php } else { ?><?php } ?>
			<?php if(get_field('override_teaser_hp')) : ?><div class="override-teaser"><?php the_field('override_teaser_hp'); ?></div><?php else: ?><?php the_excerpt(); ?><?php endif; ?>
			<?php the_tags( '<div class="tags"><p>TAGGED: ', ', ', '</p></div>'); ?>
		</div>
		<?php endforeach; ?>
		<?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
		<?php endif; ?>
	</div>
</div>
<div class="band" id="map">

<!-- SnapWidget -->
<iframe src="http://snapwidget.com/p/widget/?id=BdMlB9ibVq&t=184" title="Instagram Widget" class="snapwidget-widget" allowTransparency="true" frameborder="0" scrolling="no" style="border:none; overflow:hidden; width:100%; height:300px"></iframe>
<!-- END: SNAPWIDGETt -->

</div>
<?php get_footer(); ?>