<?php get_header(); ?>
<div class="band blog" id="main">
	<div class="container">
		<div class="sixteen columns title">
			<h1 class="page-title"><a href="<?php echo get_permalink('12'); ?>"><?php $other_page = 12; ?><?php if(get_field('page_title_override', $other_page)) : ?><?php the_field('page_title_override', $other_page); ?><?php else: ?><?php echo get_the_title('12'); ?><?php endif; ?></a></h1>
		</div>
		<div class="eleven columns" id="content">
			<?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>
				<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
					<div class='entrywrapper'>
						<div class="entry">
							<h1><?php if(get_field('entry_number')) : ?><span class="entry-number">BLOG ENTRY <?php the_field('entry_number'); ?>:</span><br /><?php else: ?><?php endif; ?><?php the_title(); ?></h1>
							<div class="date-categories"><span class="blog-posts-date"><?php the_time('F j, Y') ?></span> - <span class="category">(<?php the_category(', ') ?>)</span></div>
							<?php $featured_image = get_post_meta($post->ID, 'featured_image', true); if ($featured_image) { ?><img src="<?php echo wp_get_attachment_url($featured_image); ?>" alt="<?php the_title(); ?>" class="featured-image" /><?php } else { ?><?php } ?>
							<div class="entry">
								<?php the_excerpt(); ?>
							</div>
							<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>" class="btn green read-more">Read More</a>
							<?php the_tags( '<div class="tags"><p>TAGGED: ', ', ', '</p></div>'); ?>
							<div class="clear"></div>
						</div>
					</div>
			    </div>
			    <?php endwhile; ?>
				<div class="navigation">
					<div class="alignleft"><?php next_posts_link('Previous') ?></div>
					<div class="alignright"><?php previous_posts_link('Next') ?></div>
				</div>
				<?php else : ?>
				<h2 class="center">Not Found</h2>
				<p class="center">Sorry, but you are looking for something that isn't here.</p>
			<?php endif; ?>
		</div>
		<div class="four offset-by-one columns" id="sidebar">
			<?php get_sidebar(); ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>