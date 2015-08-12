<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>

	<!-- Basic Page Needs
  ================================================== -->
	<meta charset="utf-8">
	<title><?php wp_title('&laquo;', true, 'right'); ?><?php bloginfo('name'); ?></title>
	<?php wp_head(); ?>
	<?php wp_meta(); ?>
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	<?php /*?><script src="<?php bloginfo('stylesheet_directory'); ?>/scripts/jquery-1.10.1.min.js" type="text/javascript"></script><?php */?>
	<script src="<?php bloginfo('stylesheet_directory'); ?>/scripts/dropdown.js" type="text/javascript"></script>
	<script type="text/javascript">
		/* <![CDATA[ */
		$(document).ready(function(){

			// hide #back-top first
			$("#back-top").hide();

			// fade in #back-top
			$(function () {
				$(window).scroll(function () {
					if ($(this).scrollTop() > 100) {
						$('#back-top').fadeIn();
					} else {
						$('#back-top').fadeOut();
					}
				});

				// scroll body to 0px on click
				$('#back-top a').click(function () {
					$('body,html').animate({
						scrollTop: 0
					}, 300);
					return false;
				});
			});
		});
		/* ]]> */
	</script>
	<?php if ((is_page_template('page-move-in-out.php')) || (is_page_template('page-photos.php'))) { ?><!--Move In / Out & Photos-->
	<script src="http://cdn.jquerytools.org/1.2.7/full/jquery.tools.min.js" type="text/javascript"></script>
	<!-- <script src="<?php bloginfo('stylesheet_directory'); ?>/scripts/jquery.tools.min.js" type="text/javascript"></script> -->
	<script type="text/javascript">
		/* <![CDATA[ */
		$(document).ready(function(){
			$("ul.tabs").tabs("div.panes > div");
		});
		/* ]]> */
	</script>
	<?php }?>
	<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/fancybox/jquery.mousewheel-3.0.6.pack.js"></script>
	<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/fancybox/jquery.fancybox-2.1.5.pack.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/fancybox/jquery.fancybox-2.1.5.css" media="screen" />
	<script type='text/javascript' src="http://platform.twitter.com/widgets.js"></script>
	<script type="text/javascript">
		/* <![CDATA[ */
var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ? true : false;
		$(document).ready(function(){
			if(!isMobile) {
				$(".inline").fancybox({
				    helpers : {
				        overlay : {
				            css : {
				                'background' : 'rgba(0, 0, 0, 0)'
				            }
				        }
				    }
				});
				$(".fb-group a")/* .attr('rel', 'gallery') */.fancybox({
					nextEffect: 'fade',
					prevEffect: 'fade',
			        beforeShow: function () {
			            if (this.title) {

			                // New line
			                this.title += '<br />';

	                        //this will set what posts
	                        var description = this.title

	                        //add pinterest button for title
	                        this.title = '<a href="http://pinterest.com/pin/create/button/?url=' + this.href + '&media=' + this.href + '&description='+description+'" class="pin-it-button" count-layout="horizontal">'+
	                                '<img border="0" src="http://assets.pinterest.com/images/PinExt.png" title="Pin It"/></a>';

			                // Add tweet button
			                this.title += '<a href="https://twitter.com/share" class="twitter-share-button" data-count="none" data-url="' + this.href + '">Tweet</a> ';

			                // Add FaceBook like button
			                this.title += '<iframe src="//www.facebook.com/plugins/like.php?href=' + this.href + '&amp;layout=button_count&amp;show_faces=true&amp;width=500&amp;action=like&amp;font&amp;colorscheme=light&amp;height=23" class="fb-share-button" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:110px; height:23px;" allowTransparency="true"></iframe>';

			            }
			        },
			        afterShow: function() {
			            // Render tweet button
			            twttr.widgets.load();
			        },
			        helpers : {
			            title : {
			                type: 'inside'
			            }
			        }
				});
			}
			else {
$(function () {
    $('.fb-group a').on("click", function (e) {
        e.preventDefault();
    });
});
			}
		});
		/* ]]> */
	</script>

	<?php if ((is_page_template('page-floorplan.php')) || (is_page_template('page-amenities.php')) || is_single() || is_front_page()) { ?><!--FloorPlan, Amenities, Single Post, Home-->
	<script src="<?php bloginfo('stylesheet_directory'); ?>/scripts/jquery.cycle.all.js" type="text/javascript"></script>
	<script type="text/javascript">
		/* <![CDATA[ */
		$(document).ready(function(){
			$('#slider-container').after('<div id="slider-nav">').cycle({
	    		pager:  '#slider-nav',
		        prev:    '.prev',
		        next:    '.next',
		        pause: true,     // true to enable "pause on hover"
				pauseOnPagerHover: true,
				fx:     'fade',
				speed:  1500,
				timeout: 4000, // milliseconds between slide transitions (0 to disable auto advance)
	             slideResize: true,
	             containerResize: false,
	             width: '100%',
	             fit: 1,
			});
			$('#slider-container-fhp').after('<div id="slider-nav-fhp">').cycle({
	    		pager:  '#slider-nav-fhp',
		        prev:    '.prev',
		        next:    '.next',
		        pause: true,     // true to enable "pause on hover"
				pauseOnPagerHover: true,
				fx:     'fade',
				speed:  2500,
				timeout: 6000, // milliseconds between slide transitions (0 to disable auto advance)
	             slideResize: true,
	             containerResize: false,
	             width: '100%',
	             fit: 1,
			});
		});
		/* ]]> */
	</script>
	<?php }?>
	<script src="<?php bloginfo('stylesheet_directory'); ?>/scripts/jquery.equalheights-responsive.js" type="text/javascript"></script>
	<script type="text/javascript">
		/* <![CDATA[ */
		$(document).ready(function(){
			$(window).load(function() {
			  equalheight('.equal');
			});


			$(window).resize(function(){
			  equalheight('.equal');
			});
		});
		/* ]]> */
	</script>
	<script type="text/javascript" src="//use.typekit.net/yre0gne.js"></script>
	<script type="text/javascript">try{Typekit.load();}catch(e){}</script>

	<!-- Mobile Specific Metas
  ================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- CSS
  ================================================== -->
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/stylesheets/skeleton.css">
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/stylesheets/layout.css">

	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- Favicons
	================================================== -->
	<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/favicon.ico">
	<link rel="apple-touch-icon" href="<?php bloginfo('template_directory'); ?>/images/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php bloginfo('template_directory'); ?>/images/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php bloginfo('template_directory'); ?>/images/apple-touch-icon-114x114.png">
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-11958702-4', 'auto');
	  ga('send', 'pageview');

	</script>
</head>
<body <?php body_class('container-sixteen'); ?>>
<div class="band" id="top">
	<div class="container">
		<div class="four columns">
			<div class="top-directions-call">
				<a href="sms:1-352-395–6110" title="Text Us"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/btn2-icon_text.svg" alt="Text Us" /></a>
				<?php /*?><a href="<?php echo get_permalink('11'); ?>" title="Directions"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/btn2-icon_directions.svg" alt="Directions" /></a><?php */?>
				<a href="<?php echo get_permalink('11'); ?>" title="Call"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/btn2-icon_call.svg" alt="Call" /></a>
			</div>
			<h1 class="logo">
		<?php if(is_page_template('page-portal.php')) { ?><!--Guest Portal-->
				<a href="<?php echo get_permalink('147'); ?>" title="<?php bloginfo('name'); ?>"><span class="text"><?php bloginfo('name'); ?></span></a>
		<?php } elseif (is_page_template('page-portal-staff.php')) { ?><!--Staff Portal-->
				<a href="<?php echo get_permalink('717'); ?>" title="<?php bloginfo('name'); ?>"><span class="text"><?php bloginfo('name'); ?></span></a>
		<?php } else { ?>
				<a href="<?php echo get_option('home'); ?>/" title="<?php bloginfo('name'); ?>"><span class="text"><?php bloginfo('name'); ?></span></a>
		<?php } ?>
			</h1>
		</div>
		<div class="eleven offset-by-one columns">
	        <div id="nav-mobile">
				<?php $defaults = array('menu' => 'MOBILE Navigation', 'container'=> '', 'menu_class' => '', 'menu_id' => 'mobile-nav'); wp_nav_menu( $defaults ); ?>
	        </div>
	        <div id="subnav-social">
				<?php $defaults = array('menu' => 'Sub Navigation (TOP)', 'container'=> '', 'menu_class' => '', 'menu_id' => 'subnav'); wp_nav_menu( $defaults ); ?>
				<?php $other_page = 4; ?><?php if(get_field('social_networks', $other_page)): ?>
				<div class="social-networks">
					<?php while(the_repeater_field('social_networks', $other_page)): ?>
					<a href="<?php if(get_sub_field('link_url', $other_page)) : ?><?php the_sub_field('link_url', $other_page); ?><?php else: ?>#<?php endif; ?>" target="_blank"<?php if(get_sub_field('title', $other_page)) : ?> title="<?php the_sub_field('title', $other_page); ?>"<?php else: ?><?php endif; ?>>
						<?php if(get_sub_field('icon_image', $other_page)) : ?><img src="<?php the_sub_field('icon_image', $other_page); ?>"<?php if(get_sub_field('title', $other_page)) : ?> alt="<?php the_sub_field('title', $other_page); ?>"<?php else: ?><?php endif; ?> /><?php else: ?><?php endif; ?>
					</a>
					<?php endwhile; ?>
				</div>
				<?php endif; ?>
	        </div>
	        <div class="clear"></div>
	        <div id="nav">
				<?php $defaults = array('menu' => 'Main Navigation (TOP)', 'container'=> '', 'menu_class' => '', 'menu_id' => 'jsddm'); wp_nav_menu( $defaults ); ?>
	        </div>
		</div>
	</div>
</div>