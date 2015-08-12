<?php
/*
Template Name: Landing Page
*/
?>
<?php get_header(); ?>
<?php if(get_field('header_photo')) : ?>
<div class="band" id="slider-top">
    <div id="slider-wrapper">
        <div id="slider-container">
        	<div class="slider" style="background-image: url(<?php the_field('header_photo'); ?>)"></div>
        	<?php /*?><div class="slider"><img src="<?php the_field('header_photo'); ?>" alt="" /></div><?php */?>
        </div>
    </div>
</div><?php else: ?><?php endif; ?>
<div class="band" id="main">
	<div class="container">
		<?php if(get_field('sidebar')) : ?>
		<div class="four columns" id="sidebar">
			<?php the_field('sidebar'); ?>
		</div><?php else: ?><?php endif; ?>
		<div class="<?php if(get_field('sidebar')) : ?>eleven offset-by-one<?php else: ?>sixteen<?php endif; ?> columns" id="content">
			<h1 class="page-title"><?php if(get_field('page_title_override')) : ?><?php the_field('page_title_override'); ?><?php else: ?><?php echo get_the_title($ID); ?><?php endif; ?></h1>
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div class="post" id="post-<?php the_ID(); ?>">
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