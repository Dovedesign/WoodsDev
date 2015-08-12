<?php
/*
Template Name: Floorplan Compare All
*/
?>
<?php get_header(); ?>
<div class="band floorplan" id="main">
	<div class="container">
		<div class="sixteen columns title">
			<h1 class="page-title"><?php if(get_field('page_title_override')) : ?><?php the_field('page_title_override'); ?><?php else: ?><?php echo get_the_title($ID); ?><?php endif; ?></h1>
		</div>
		<?php
		$args = array('post_type' => 'page',
		'post_status'            => 'publish',
		'post_parent'            => '7',
		'post__not_in'   => array(27),
		'orderby'            => 'menu_order',
		'order'            => 'asc',
		'showposts'            => '-1',
		);
		query_posts( $args );if (have_posts()) : echo '<div id="compare-all">'; while(have_posts()) : the_post();
		{ echo '<div class="eight columns compare post-' . get_the_ID() . '">'; ?>
		<div class="compare-fp">
			<h2 class="page-title"><?php if(get_field('page_title_override')) : ?><?php the_field('page_title_override'); ?><?php else: ?><?php echo get_the_title($ID); ?><?php endif; ?></h2>
			<div id="fp-info">
				<div class="price-info">
					<?php if(get_field('price_per_bedroom_per_month')) : ?><div class="price"><strong>$<?php the_field('price_per_bedroom_per_month'); ?></strong><span class="per">Per Bedroom / Per Month</span></div><?php else: ?><?php endif; ?>
					<?php if(get_field('info')) : ?><div class="info"><?php the_field('info'); ?></div><?php else: ?><?php endif; ?>
				</div>
				<?php if(get_field('features')) : ?><div class="features"><strong>Features</strong><?php the_field('features'); ?></div><?php else: ?><?php endif; ?>
			</div>
			<div class="button"><a class="btn green" href="<?php the_permalink() ?>" title="More Info">More Info</a></div>
		</div>
		<?php echo '</div>'; } endwhile; echo '</div>'; endif; wp_reset_query(); ?>
	</div>
</div>
<?php get_footer(); ?>