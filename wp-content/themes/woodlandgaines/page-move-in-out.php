<?php
/*
Template Name: Move In / Out
*/
?>
<?php get_header(); ?>
<div class="band" id="main">
	<div class="container">
		<div class="four columns" id="sidebar">
			<?php if(get_field('menu')) : ?><div id="subnav-sidebar"><?php the_field('menu'); ?></div><?php else: ?><?php endif; ?>
		</div>
		<div class="eleven offset-by-one columns" id="content">
			<h1 class="page-title"><?php if(get_field('page_title_override')) : ?><?php the_field('page_title_override'); ?><?php else: ?><?php echo get_the_title($ID); ?><?php endif; ?></h1>
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div class="post" id="post-<?php the_ID(); ?>">				<?php if($rows = get_field('tabs')): ?>
				<div class="tabs-wrap">
					<ul class="tabs">
					<?php $i = 1; ?><?php while(the_repeater_field('tabs')): ?>
						<li><a href="#tab<?php echo $i; ?>"><span class="number"><?php echo $i; ?></span><div class="clear"></div><?php if(get_sub_field('tab_title')) : ?><?php the_sub_field('tab_title'); ?><?php else: ?><?php endif; ?></a></li>
					<?php $i++; ?><?php endwhile; ?>
					</ul>
					<div class="clear"></div>
					<div class="panes">
					<?php $i = 1; ?>
						<?php while(the_repeater_field('tabs')): ?>
						<div id="tab<?php echo $i; ?>" class="tab_content" <?php if($i == 1) { ?>style="display: block;"<?php } ?>>
							<?php if(get_sub_field('tab_content')) : ?><?php the_sub_field('tab_content'); ?><?php else: ?><?php endif; ?>
							<?php if(get_sub_field('video_url')) : ?><div class="video"><iframe src="<?php the_sub_field('video_url'); ?>" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></div><?php else: ?><?php endif; ?>
						</div>
						<?php $i++; ?><?php endwhile; ?>
					</div>
				</div>
				<?php endif; ?>
			</div>
			<?php endwhile; ?>
			<?php else : ?>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>