<?php get_header(); ?>
<div class="band" id="main">
	<div class="container">
		<div class="four columns" id="sidebar">
			<div id="subnav-sidebar">
				<?php $defaults = array('menu' => 'Main Navigation (TOP)', 'container'=> '', 'menu_class' => '', 'menu_id' => 'main-nav'); wp_nav_menu( $defaults ); ?>
			</div>
		</div>
		<div class="eleven offset-by-one columns" id="content">
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