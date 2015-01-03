<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php echo get_bloginfo('name'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<link href='http://fonts.googleapis.com/css?family=Alegreya:400italic,700italic,400,700' rel='stylesheet' type='text/css'>


<link href="<?php echo get_template_directory_uri(); ?>/css/main.min.css" rel="stylesheet" type="text/css" />

<script>
	php_src = "<?php echo get_template_directory_uri();?>";
</script>

<?php wp_head(); ?>
</head>

<body  id="bindle" <?php body_class(); ?>>
<a class="shift" id="goarchive"><span class="vertcenter">&raquo;</span></a>
<a class="shift sliderightborder" id="gopost"><span class="vertcenter">&laquo;</span></a>

<div id="blogheader" class="sticky">
	<h1 class="non-fauxpas">
		<?php echo get_bloginfo('name');?>
	</h1>
	<h2 class="non-fauxpas">
		<?php echo get_bloginfo('description'); ?>
	</h2>
	<marquee class="fauxpas" id="fauxpas-name" direction="down">jacke karashae on the www</marquee>
	<marquee class="fauxpas" id="fauxpas-desc" behavior="alternate">all those sundry things jacke does on the information superhighway.</marquee>
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
            <div class="links-hr"></div>
	        <div class="links">
	            <?php
	            if(has_previous_posts()) {
	            	previous_post_link('<div class="prev"><span>previous: %link</span></div>');
	            } ?>
	            <?php
	            if(has_next_posts()) {
	             	next_post_link('<div class="next"><span>next: %link</span></div>');
	            }
	            ?>
			</div>
        </div>

		<div id="footer" class="sticky">
			<div id="footer-link">
				<span>
					btw: jacke can be
						<a href="http://music.karashae.com">heard</a>,
						<a href="http://www.youtube.com/jackekarashae">seen</a>, or
						<a href="http://twitter.com/jackekarashae">followed</a>!
				</span>
			</div>
			<div id="themechoice">
				<div class="btn-theme" id="theme-bindle" data-theme="bindle">light</div>
				<div class="btn-theme" id="theme-inverted" data-theme="inverted">dark</div>
				<div class="btn-theme" id="theme-fauxpas" data-theme="fauxpas">faux pas</div>
			</div>
			<div class="fauxpas" id="fauxpas-footer">
				<img src="<?php echo get_template_directory_uri();?>/img/ie.gif" />
				<img src="<?php echo get_template_directory_uri();?>/img/netscape.gif" />
				<img src="<?php echo get_template_directory_uri();?>/img/cag.gif" />
			</div>
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
					<li><h2><a href="<?php the_permalink(); ?>" id="<?php the_id(); ?>" title="<?php echo( basename( get_permalink() ) ); ?>"><?php the_title(); ?></a></h2> <span><?php the_time('F j Y') ?></span></li>
				<?php endwhile; wp_reset_postdata(); ?>
			</ul>
		</div>

	</li>
</ul>

<script type="text/javascript" src="<?php echo get_template_directory_uri();?>/js/main.min.js"></script>

<?php wp_footer(); ?>

</body>
</html>
