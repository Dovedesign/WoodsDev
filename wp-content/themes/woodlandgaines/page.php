<?php get_header(); ?>
<div class="band" id="main">
	<div class="container">
		<div class="four columns" id="sidebar">
			<?php if(get_field('menu')) : ?><div id="subnav-sidebar"><?php the_field('menu'); ?></div><?php else: ?><?php endif; ?>
		</div>
		<div class="eleven offset-by-one columns" id="content">
			<h1 class="page-title"><?php if(get_field('page_title_override')) : ?><?php the_field('page_title_override'); ?><?php else: ?><?php echo get_the_title($ID); ?><?php endif; ?></h1>
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div class="post" id="post-<?php the_ID(); ?>">
			    <div class="entry">
			    	<?php the_content(''); ?>
					<?php if(is_page('20')) { ?><!--Downloads + Forms-->
					<?php if(get_field('lease_documents')): ?>
					<div class="lease-documents">
						<span class="title-header">Lease Documents</span>
					<?php while(the_repeater_field('lease_documents')): ?>
						<div class="document">
							<?php if(get_sub_field('file_title')) : ?><a href="<?php if(get_sub_field('file')) : ?><?php the_sub_field('file'); ?><?php else: ?>#<?php endif; ?>" target="_blank" title="<?php the_sub_field('file_title'); ?>">- <?php the_sub_field('file_title'); ?></a><?php else: ?><?php endif; ?>
						</div>
						<?php endwhile; ?>
					</div>
					<?php endif; ?>
					<?php if(get_field('helpful_guides')): ?>
					<div class="helpful-guides">
						<span class="title-header">Helpful Guides</span>
					<?php while(the_repeater_field('helpful_guides')): ?>
						<div class="document">
							<?php if(get_sub_field('file_title')) : ?><a href="<?php if(get_sub_field('file')) : ?><?php the_sub_field('file'); ?><?php else: ?>#<?php endif; ?>" target="_blank" title="<?php the_sub_field('file_title'); ?>">- <?php the_sub_field('file_title'); ?></a><?php else: ?><?php endif; ?>
						</div>
						<?php endwhile; ?>
					</div>
					<?php endif; ?>
			        <?php } if(is_page('18')) { ?><!--FAQ-->
					<?php if(get_field('faq')): ?>
					<div class="faqs">
					<?php while(the_repeater_field('faq')): ?>
						<div class="faq">
							<?php if(get_sub_field('question')) : ?><div class="question"><?php the_sub_field('question'); ?></div><?php else: ?><?php endif; ?>
							<?php if(get_sub_field('answer')) : ?><div class="answer"><?php the_sub_field('answer'); ?></div><?php else: ?><?php endif; ?>
						</div>
						<?php endwhile; ?>
					</div>
					<?php endif; ?>
			        <?php }?>
					<?php if(is_page('14')) { ?><!--Site Map-->
			        <?php echo ddsg_create_sitemap(); ?>
			        <?php }?>
			    </div>
			</div>
			<?php endwhile; ?>
			<?php else : ?>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>