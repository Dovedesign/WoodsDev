<?php
/*
Template Name: Contact
*/
?>
<?php get_header(); ?>
<div class="band" id="main">
	<div class="container">
		<div class="sixteen columns title">
			<h1 class="page-title"><?php if(get_field('page_title_override')) : ?><?php the_field('page_title_override'); ?><?php else: ?><?php echo get_the_title($ID); ?><?php endif; ?></h1>
		</div>
	</div>
</div>
<div class="band" id="main-contact">
	<div class="container">
		<?php if(get_field('contact_info')) : ?>
		<div class="eight columns contact-info">
			<div class="contact-wrap"><?php the_field('contact_info'); ?></div>
		</div>
		<?php else: ?><?php endif; ?>
		<?php $map_photo = get_post_meta($post->ID, 'map_photo', true); if ($map_photo) { ?>
		<div class="eight columns map-photo">
			<?php if(get_field('map_link_url')) : ?><a href="<?php the_field('map_link_url'); ?>" target="_blank"><?php else: ?><?php endif; ?><img src="<?php echo wp_get_attachment_url($map_photo); ?>" alt="<?php the_title(); ?>" /><?php if(get_field('map_link_url')) : ?></a><?php else: ?><?php endif; ?>
		</div>
		<?php } else { ?><?php } ?>
	</div>
</div>
<div class="band" id="map">
	<iframe src="https://www.google.com/maps/d/embed?mid=z2u_KzU9Y4-4.kCkL15Eh_E9E" width="100%" height="500"></iframe>
</div>
<?php get_footer(); ?>