<?php
/*
Template Name: Floorplan
*/
?>
<?php get_header(); ?>
<div class="band floorplan" id="main">
	<div class="container">
		<div class="sixteen columns title">
			<h1 class="page-title"><?php if(get_field('page_title_override')) : ?><?php the_field('page_title_override'); ?><?php else: ?><?php echo get_the_title($ID); ?><?php endif; ?></h1>
		</div>
		<div class="eleven columns" id="photo-gallery">
			<?php if(get_field('photo_gallery')): ?>
		    <div id="slider-wrapper">
	        	<div id="slider-controls">
			        <a href="#" class="prev"></a>
			        <a href="#" class="next"></a>
	        	</div>
		        <div id="slider-container">
		        <?php while(the_repeater_field('photo_gallery')): ?>
		        	<?php if(get_sub_field('photo')) : ?><div class="slider"><img src="<?php the_sub_field('photo'); ?>" alt="" /></div><?php else: ?><?php endif; ?>
		        <?php endwhile; ?>
		        </div>
		    </div>
			<?php endif; ?>
		</div>
		<div class="four offset-by-one columns" id="fp-info">
			<div class="price-info">
				<?php if(get_field('price_per_bedroom_per_month')) : ?><div class="price"><strong>$<?php the_field('price_per_bedroom_per_month'); ?></strong><span class="per">Per Bedroom / Per Month</span></div><?php else: ?><?php endif; ?>
				<?php if(get_field('info')) : ?><div class="info"><?php the_field('info'); ?></div><?php else: ?><?php endif; ?>
			</div>
			<?php if(get_field('features')) : ?><div class="features"><strong>Features</strong><?php the_field('features'); ?></div><?php else: ?><?php endif; ?>
			<div class="button"><a class="btn green" href="<?php echo get_permalink('15'); ?>" title="I'm Interested!">I'm Interested!</a></div>
		</div>
	</div>
</div>
<?php get_template_part('inc-why'); ?>
<?php if(get_field('boxes')): ?>
<div class="band" id="boxes">
	<div class="container">
		<?php while(the_repeater_field('boxes')): ?>
		<div class="eight columns">
			<div class="box-wrap equal">
				<div class="box">
					<?php if(get_sub_field('image')) : ?><div class="box-img"><?php if(get_sub_field('link_url')) : ?><a href="<?php the_sub_field('link_url'); ?>"<?php if(get_sub_field('link_new_window')) : ?> target="_blank"<?php else: ?><?php endif; ?>><?php else: ?><?php endif; ?><img src="<?php the_sub_field('image'); ?>" /><?php if(get_sub_field('link_url')) : ?></a><?php else: ?><?php endif; ?></div><?php else: ?><?php endif; ?>
					<div class="box-info">
						<?php if(get_sub_field('title')) : ?><p class="title"><?php if(get_sub_field('link_url')) : ?><a href="<?php the_sub_field('link_url'); ?>"<?php if(get_sub_field('link_new_window')) : ?> target="_blank"<?php else: ?><?php endif; ?>><?php else: ?><?php endif; ?><?php the_sub_field('title'); ?><?php if(get_sub_field('link_url')) : ?></a><?php else: ?><?php endif; ?></p><?php else: ?><?php endif; ?>
						<?php if(get_sub_field('content')) : ?><div class="box-content"><?php the_sub_field('content'); ?></div><?php else: ?><?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		<?php endwhile; ?>
	</div>
</div>
<?php endif; ?>
<?php get_footer(); ?>