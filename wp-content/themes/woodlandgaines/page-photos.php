<?php
/*
Template Name: Photos
*/
?>
<?php get_header(); ?>
<div class="band" id="main">
	<div class="container">
		<div id="tabs-photos-videos">
			<div class="tabs-wrap">
				<ul class="tabs">
					<li><a href="#tab-photos">Photos</a></li>
					<li><a href="#tab-videos">Videos</a></li>
				</ul>
			</div>
			<div class="clear"></div>
			<div class="panes">
				<?php if($rows = get_field('photos_tab')): ?>
				<div class="photos-tab">
					<?php $i = 1; ?><?php while(the_repeater_field('photos_tab')): ?>
					<div class="photo-gallery">
						<?php if(get_sub_field('photo_gallery_title')) : ?><div class="sixteen columns title"><h1 class="page-title"><?php the_sub_field('photo_gallery_title'); ?></h1></div><?php else: ?><?php endif; ?>
						<div class="fb-group">
							<div id="pg<?php echo $i; ?>"></div>
						<?php if(get_sub_field('photo_gallery')): ?>
						<?php while(has_sub_field('photo_gallery')): ?>
							<div class="four columns photo-gallery-img equal"><?php if(get_sub_field('photo')) : ?><a rel="example_group<?php echo $i; ?>" href="<?php the_sub_field('photo'); ?>" <?php if(get_sub_field('photo_title')) : ?>title="<?php the_sub_field('photo_title'); ?>"<?php else: ?>title="Photo"<?php endif; ?>><img src="<?php the_sub_field('photo'); ?>" class="pg-img" alt="<?php if(get_sub_field('photo_title')) : ?><?php the_sub_field('photo_title'); ?><?php else: ?>Photo<?php endif; ?>" /></a><?php else: ?><?php endif; ?></div>
						<?php endwhile; ?>
						<?php endif; ?>
						<div class="clear"></div>
						</div>
					</div>
					<?php $i++; ?><?php endwhile; ?>
				</div>
				<?php endif; ?>
				<?php if($rows = get_field('videos_tab')): ?>
				<div class="videos-tab">
					<?php $i = 1; ?><?php while(the_repeater_field('videos_tab')): ?>
					<div class="photo-gallery">
						<?php if(get_sub_field('video_gallery_title')) : ?><div class="sixteen columns title"><h1 class="page-title"><?php the_sub_field('video_gallery_title'); ?></h1></div><?php else: ?><?php endif; ?>
						<div class="fb-video-group">
							<div id="vg<?php echo $i; ?>"></div>
						<?php if(get_sub_field('video_gallery')): ?>
						<?php while(has_sub_field('video_gallery')): ?>
							<div class="eight columns photo-gallery-img">
							<?php if(get_sub_field('video_url')) : ?><div class="videos"><iframe src="<?php the_sub_field('video_url'); ?>" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></div><?php else: ?><?php endif; ?>
							</div>
						<?php endwhile; ?>
						<?php endif; ?>
						<div class="clear"></div>
						</div>
					</div>
					<?php $i++; ?><?php endwhile; ?>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>