<?php get_header(); ?>
<div class="band blog" id="main">
	<div class="container">
		<div class="sixteen columns title">
			<h1 class="page-title"><a href="<?php echo get_permalink('12'); ?>"><?php $other_page = 12; ?><?php if(get_field('page_title_override', $other_page)) : ?><?php the_field('page_title_override', $other_page); ?><?php else: ?><?php echo get_the_title('12'); ?><?php endif; ?></a></h1>
		</div>
		<div class="eleven columns" id="content">
		<?php if (have_posts()) : ?>
			<?php while (have_posts()) : the_post(); ?>
			<div <?php post_class() ?>>
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
			<?php else :
			if ( is_category() ) { // If this is a category archive
				printf("<h2 class='center'>Sorry, but there aren't any posts in the %s category yet.</h2>", single_cat_title('',false));
			} else if ( is_date() ) { // If this is a date archive
				echo("<h2>Sorry, but there aren't any posts with this date.</h2>");
			} else if ( is_author() ) { // If this is a category archive
				$userdata = get_userdatabylogin(get_query_var('author_name'));
				printf("<h2 class='center'>Sorry, but there aren't any posts by %s yet.</h2>", $userdata->display_name);
			} else {
				echo("<h2 class='center'>No posts found.</h2>");
			} get_search_form(); endif; ?>
		</div>
		<div class="four offset-by-one columns" id="sidebar">
			<?php get_sidebar(); ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>