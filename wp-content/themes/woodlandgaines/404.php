<?php get_header(); ?>
<div class="band" id="main">
	<div class="container">
		<div class="eleven offset-by-five columns" id="content">
			<h2>Error 404 - Page Not Found</h2>
			<p>Please check our sitemap for the page you're looking for.</p>
			<?php echo ddsg_create_sitemap(); ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>