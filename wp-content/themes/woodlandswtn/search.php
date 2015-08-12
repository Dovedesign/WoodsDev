<?php get_header(); ?>
<div class="band blog" id="main">
	<div class="container">
		<div class="sixteen columns title">
			<h1 class="page-title">Search Results</h1>
		</div>
		<div class="eleven columns" id="content">
			<?php if (have_posts()) : ?>
			<?php while (have_posts()) : the_post(); ?>
			<div <?php post_class() ?>>
			    <h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
			    <div class="entry">
			        <?php the_excerpt(); ?>
			    </div>
			</div>
			<?php endwhile; ?>
			<div class="navigation">
			    <div class="alignleft">
			        <?php previous_posts_link('Previous') ?>
			    </div>
			    <div class="alignright">
			        <?php next_posts_link('Next') ?>
			    </div>
			</div>
			<?php else : ?>
			<h2>No results found. Check our sitemap below.</h2>
			<?php echo ddsg_create_sitemap(); ?>
			<?php endif; ?>
		</div>
		<div class="four offset-by-one columns" id="sidebar">
			<?php get_sidebar(); ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>