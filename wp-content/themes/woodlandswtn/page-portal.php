<?php
/*
Template Name: Guest Portal
*/
?>
<?php get_header(); ?>
<div class="band" id="main">
	<div class="container">
		<div class="four columns" id="sidebar">
			<?php if(get_field('menu')) : ?><div id="subnav-sidebar"><?php the_field('menu'); ?></div><?php else: ?><?php endif; ?>
		</div>
		<div class="twelve columns" id="content">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div class="post" id="post-<?php the_ID(); ?>">
				<div>
		    	<?php $welcome_photo = get_post_meta($post->ID, 'welcome_photo', true); if ($welcome_photo) { ?><div class="welcome-photo"><img src="<?php echo wp_get_attachment_url($welcome_photo); ?>" alt="<?php the_title(); ?>" /></div><?php } else { ?><?php } ?></div>
		    	<div class="clear"></div>
				<?php if(get_field('callouts')): ?>
				<ul class="callouts">
				<?php while(the_repeater_field('callouts')): ?>
					<li class="three columns">
						<?php if(get_sub_field('photo')) : ?><?php if(get_sub_field('link_url')) : ?><a href="<?php the_sub_field('link_url'); ?>"><?php else: ?><?php endif; ?><img src="<?php the_sub_field('photo'); ?>" class="callout-photo" /><?php if(get_sub_field('link_url')) : ?></a><?php else: ?><?php endif; ?><?php else: ?><?php endif; ?>
					</li>
					<?php endwhile; ?>
				</ul>
				<?php endif; ?>
			    <div class="entry">
			    	<?php the_content(''); ?>
			    </div>
			</div>
			<?php endwhile; ?>
			<?php else : ?>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>