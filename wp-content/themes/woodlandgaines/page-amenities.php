<?php
/*
Template Name: Amenities
*/
?>
<?php get_header(); ?>
<div class="band" id="slider-top">
	<?php if(get_field('photo_gallery_slider')): ?>
    <div id="slider-wrapper">
    	<div id="slider-controls">
	        <a href="#" class="prev"></a>
	        <a href="#" class="next"></a>
    	</div>
        <div id="slider-container">
        <?php while(the_repeater_field('photo_gallery_slider')): ?>
        	<?php if(get_sub_field('photo')) : ?><div class="slider" style="background-image: url(<?php the_sub_field('photo'); ?>)"></div><?php else: ?><?php endif; ?>
        	<?php /*?><?php if(get_sub_field('photo')) : ?><div class="slider"><img src="<?php the_sub_field('photo'); ?>" alt="<?php the_sub_field('photo_title'); ?>" /></div><?php else: ?><?php endif; ?><?php */?>
        <?php endwhile; ?>
        </div>
    </div>
	<?php endif; ?>
</div>
<div class="band" id="main">
	<div class="container">
		<div id="tabs-amenities">
			<div class="photo-gallery">
				<div class="fb-group">
				<?php if(get_field('photo_gallery')): ?>
				<?php while(the_repeater_field('photo_gallery')): ?>
					<div class="four columns photo-gallery-img equal"><?php if(get_sub_field('photo')) : ?>
						<a rel="example_group_amenities" href="<?php the_sub_field('photo'); ?>" <?php if(get_sub_field('photo_title')) : ?>title="<?php the_sub_field('photo_title'); ?>"<?php else: ?><?php endif; ?>>
							<?php if(get_sub_field('photo_title')) : ?><p><?php the_sub_field('photo_title'); ?></p><?php else: ?><?php endif; ?>
							<img src="<?php the_sub_field('photo'); ?>" class="pg-img"<?php if(get_sub_field('photo_title')) : ?> alt="<?php the_sub_field('photo_title'); ?>"<?php else: ?><?php endif; ?> />
						</a><?php else: ?><?php endif; ?>
					</div>
				<?php endwhile; ?>
				<?php endif; ?>
					<div class="clear"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>