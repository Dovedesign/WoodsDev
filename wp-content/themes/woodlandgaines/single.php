<?php get_header(); ?>
<div class="band blog" id="main">
	<div class="container">
		<div class="sixteen columns title">
			<h1 class="page-title"><a href="<?php echo get_permalink('12'); ?>"><?php $other_page = 12; ?><?php if(get_field('page_title_override', $other_page)) : ?><?php the_field('page_title_override', $other_page); ?><?php else: ?><?php echo get_the_title('12'); ?><?php endif; ?></a></h1>
		</div>
		<div class="eleven columns" id="content">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
				<h1><?php the_title(); ?></h1>
				<div class="date-categories"><span class="blog-posts-date"><?php the_time('F j, Y') ?></span> - <span class="category">(<?php the_category(', ') ?>)</span></div>
				<?php $featured_image = get_post_meta($post->ID, 'featured_image', true); if ($featured_image) { ?><img src="<?php echo wp_get_attachment_url($featured_image); ?>" alt="<?php the_title(); ?>" class="featured-image" /><?php } else { ?><?php } ?>
				<div class="entry">
					<?php the_content(); ?>
				</div>
				<?php if(get_field('photo_gallery-post')): ?>
			    <div id="slider-wrapper">
		        	<div id="slider-controls">
				        <a href="#" class="prev"></a>
				        <a href="#" class="next"></a>
		        	</div>
			        <div id="slider-container">
			        <?php while(the_repeater_field('photo_gallery-post')): ?>
			        	<?php if(get_sub_field('photo')) : ?><div class="slider"><img src="<?php the_sub_field('photo'); ?>" alt="" /></div><?php else: ?><?php endif; ?>
			        <?php endwhile; ?>
			        </div>
			    </div>
				<?php endif; ?>
				<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
				<?php the_tags( '<div class="tags"><p>TAGGED: ', ', ', '</p></div>'); ?>
			</div>
			<div class="navigation">
				<div class="alignleft"><?php previous_post_link('%link', 'Previous') ?></div>
				<div class="alignright"><?php next_post_link('%link', 'Next') ?></div>
			</div>
			<?php endwhile; else: ?>
			<p>Sorry, no posts matched your criteria.</p>
			<?php endif; ?>
		</div>
		<div class="four offset-by-one columns" id="sidebar">
			<?php get_sidebar(); ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>