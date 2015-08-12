<?php get_search_form(); ?>
<ul class="blogsubnav">
    <?php wp_list_categories('title_li=<h3>Categories</h3>'); ?>
    <li class="blog-title"><h3>Subscribe</h3>
        <ul>
            <li class="rss"><a href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('Syndicate this site using RSS'); ?>"><?php _e('RSS Feed'); ?></a></li>
        </ul>
    </li>
</ul>