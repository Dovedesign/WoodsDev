<div class="band" id="why">
	<div class="container">
		<div class="sixteen columns section-title">
			<h2 class="title">Why Live Here?</h2>
		</div>
	<?php
	$args = array( 'posts_per_page' => -1, 'orderby' => 'menu_order', 'order' => 'ASC', 'post_type' => 'why-live-here' );
	$rand_posts = get_posts( $args );
	foreach( $rand_posts as $post ) :  setup_postdata($post); ?>
		<div class="two columns amenity <?php echo $post->post_name;?> count<?php echo ($xyz++%5); ?> odd-even<?php echo ($fyz++%2); ?>">
			<a href="#inline-<?php echo $post->post_name;?>" class="inline">
				<p class="title"><?php echo get_the_title($ID); ?></p>
				<?php $icon_image = get_post_meta($post->ID, 'icon_image', true); if ($icon_image) { ?><div class="icon-image"><img src="<?php echo wp_get_attachment_url($icon_image); ?>" alt="<?php echo get_the_title($ID); ?>" class="amenity-icon" /></div><?php } else { ?><?php } ?>
			</a>
			<div class="popup-content" id="inline-<?php echo $post->post_name;?>" style="display: none;">
				<h3><?php echo get_the_title($ID); ?></h3>
				<?php $popup_content = get_post_meta($post->ID, 'popup_content', true); if ($popup_content) { ?><?php echo $popup_content; ?><?php } else { ?><?php } ?>
			</div>
		</div>
	<?php endforeach; wp_reset_query(); ?>
	</div>
</div>