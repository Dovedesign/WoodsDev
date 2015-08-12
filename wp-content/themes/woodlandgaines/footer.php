<?php if (!post_password_required()) { ?>
<?php $other_page = 4; ?><?php if(get_field('social_networks_footer', $other_page)): ?>
<div class="band" id="btm-social-networks">
	<div class="container">
		<div class="sixteen columns">
			<?php while(the_repeater_field('social_networks_footer', $other_page)): ?>
			<a href="<?php if(get_sub_field('link_url', $other_page)) : ?><?php the_sub_field('link_url', $other_page); ?><?php else: ?>#<?php endif; ?>" target="_blank"<?php if(get_sub_field('title', $other_page)) : ?> title="<?php the_sub_field('title', $other_page); ?>"<?php else: ?><?php endif; ?>>
				<?php if(get_sub_field('icon_image', $other_page)) : ?><img src="<?php the_sub_field('icon_image', $other_page); ?>"<?php if(get_sub_field('title', $other_page)) : ?> alt="<?php the_sub_field('title', $other_page); ?>"<?php else: ?><?php endif; ?> /><?php else: ?><?php endif; ?>
			</a>
			<?php endwhile; ?>
		</div>
	</div>
</div>
<?php endif; ?>
<div class="band" id="footer">
	<div class="container">
		<div class="sixteen columns">
	    	<div class="sitemap">
				<?php $defaults = array('menu' => 'Footer Navigation Primary', 'container'=> '', 'menu_class' => 'primary', 'menu_id' => 'footernav'); wp_nav_menu( $defaults ); ?>
			    <div class="clear"></div>
	    	</div>
	        <div class="copyright">Copyright &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>.<br /> All rights reserved <a href="" title="Privacy Policy">Privacy Policy</a>.<br /><br />
			These images and information attempt to accurately represent floor plans, buildings and amenities. However, the developer reserves the right to make changes to final plans and is not responsible for typographical errors. Please also note that regional differences will be made to accommodate indigenous plantings, the climate, and the architectural influences of the region.
			</div>
			<p id="back-top">
				<a href="#top"><span></span></a>
			</p>
		</div>
	</div>
</div>
<?php } ?>
<?php wp_footer(); ?>
</body>
</html>