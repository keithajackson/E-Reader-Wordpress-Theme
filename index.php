<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php echo get_bloginfo('name'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<link href='http://fonts.googleapis.com/css?family=Alegreya:400italic,700italic,400,700' rel='stylesheet' type='text/css'>


<link href="<?php echo get_stylesheet_uri(); ?>" rel="stylesheet" type="text/css" />

<script>
	if(window.location.hash) {
		var hash = window.location.hash;
		var hashtourl = hash.substring(2)
		window.location.href = "/"+hashtourl;
	}
</script>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<a class="shift" id="goarchive"><span class="vertcenter">&gt;</span></a>
<a class="shift" id="gopost"><span class="vertcenter">&lt;</span></a>

<div id="blogheader" class="sticky">
	<h1>
		<?php echo get_bloginfo('name');?>
	</h1>
	<h2>
		<?php echo get_bloginfo('description'); ?>
	</h2>
	<!--<div id="blognav">
	    <nav>
	        <?php wp_nav_menu( array( 'theme_location' => 'header-menu' ) ); ?>
	    </nav>
	</div>-->
</div>

<ul id="content-container" class="sticky">

	<li id="post">
		<div class="content">
            <?php the_post(); $do_not_duplicate = get_the_ID(); ?>
            <!-- Top blognav bar -->
            <h1><?php the_title(); ?></h1>
            
            <?php the_content(); ?>
		</div>

		<div id="footer" class="sticky">
			btw: jacke can be
				<a href="http://music.karashae.com">heard</a>,
				<a href="http://www.youtube.com/jackekarashae">seen</a>, or
				<a href="http://twitter.com/jackekarashae">followed</a>!
		</div>
	</li>

	<li id="archive">
		<div class="content">
			<h2>recent posts</h2>

			<ul>
				<?php
				$my_query = new WP_Query( array( "nopaging"=>true ) );
				while ($my_query->have_posts()) :
					$my_query->the_post();
				?>
					<li><h2><a rel="<?php the_permalink(); ?>" id="<?php the_id(); ?>" title="<?php echo( basename( get_permalink() ) ); ?>"><?php the_title(); ?></a></h2> <span><?php the_time('F j Y') ?></span></li>
				<?php endwhile; wp_reset_postdata(); ?>
			</ul>

		</div>

	</li>
</ul>



<script type="text/javascript" src="<?php echo get_template_directory_uri();?>/jquery.touchSwipe.min.js"></script>
<script>
	$(document).ready(function () {
		// Cached DOM references
		var $goarchive = $('#goarchive'),
			$gopost = $('#gopost'),
			$archive = $('#archive'),
			$post = $('#post');

		function goarchive() {
			$goarchive.fadeOut(300);
			$post.hide('slide', {
				direction: 'left'
			}, 600, function () {
				$archive.scrollTop(0);
				$archive.show('slide', {
					direction: 'right'
				}, 600);
				$gopost.fadeIn(300);
			});
		};

		function gopost() {
			$gopost.fadeOut(300);
			$archive.hide('slide', {
				direction: 'right'
			}, 600, function () {
				$post.scrollTop(1);
				$post.show('slide', {
					direction: 'left'
				}, 600);
				$goarchive.fadeIn(300);
			});
		};

		function loadpost() {

			var perma = $(this).attr('rel'),
				postid = $(this).attr('id'),
				postitle = $(this).attr('title');

			$(this).parent().parent().addClass('loader');

			$post.load(perma + ' #post', function () {
				$gopost.fadeOut(300);
				$archive.hide('slide', {
					direction: 'right'
				}, 600, function () {
					$post.scrollTop(1);
					$goarchive.fadeIn(300);
					$post.show('slide', {
						direction: 'left'
					}, 600, function () {
						$('#' + postid).parent().parent().removeClass('loader');
						window.location.hash = '/' + postitle;
						if (typeof twttr != 'undefined') {
							twttr.widgets.load()
						}
					});
				});
			});
		}

		$goarchive.on('click',$goarchive,goarchive);

		$gopost.on('click',$gopost,gopost);

		$archive.find('a').on('click',$archive.find('a'),loadpost);


		/* arrow key blognav */

		$(document).keydown(function(ev) {
			if(ev.which === 39) {
				if ( $post.is(':visible') ) {
					goarchive();
				}
				return false;
			}

			if(ev.which === 37) {
				if ( $archive.is(':visible') ) {
					gopost();
				}
				return false;
			}
		});
		$("html").swipe({
		  swipeRight:function(event, direction, distance, duration, fingerCount) {
		    if ( $archive.is(':visible') ) {
					gopost();
				}
				return false;
		    //This only fires when the user swipes left
		  },
		  swipeLeft:function(event, direction, distance, duration, fingerCount) {
		    if ( $post.is(':visible') ) {
					goarchive();
				}
				return false;;
		    //This only fires when the user swipes right
		  }
		});
		$(window).scroll(function() {
			var scrollMargin = 15
		   if($(window).scrollTop() < scrollMargin 
		   	|| $(document).height() - ($(window).scrollTop() + $(window).height()) < scrollMargin) {
		       // show the scroll
		   		$("#goarchive").addClass("slideleftborder");
		   		$("#gopost").addClass("sliderightborder")
		   } else {
		   		$("#goarchive").removeClass("slideleftborder");
		   		$("#gopost").removeClass("sliderightborder")
			}
		});
		$(window).scrollTop(1);
	});

</script>

<?php wp_footer(); ?>

</body>
</html>
