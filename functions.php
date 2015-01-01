<?php

wp_deregister_script( 'jquery' );
wp_enqueue_script( 'jquery', 'http://code.jquery.com/jquery-latest.js' );

// Add the effects
wp_enqueue_script( 'jquery-ui-effects-core', 'http://jquery-ui.googlecode.com/svn/tags/latest/ui/jquery.effects.core.js', array( 'jquery' ) );
wp_enqueue_script( 'jquery-ui-effects-slide', 'http://jquery-ui.googlecode.com/svn/tags/latest/ui/jquery.effects.slide.js', array( 'jquery', 'jquery-ui-effects-core' ) );

function register_my_menus()
{
    register_nav_menu('header-menu',__( 'Header Menu' ));
}

add_action( 'init', 'register_my_menus' );

function glider_widgets_init() {

	register_sidebar( array(
		'name' => 'Footer',
		'id' => 'footer',
		'before_widget' => '<div>',
		'after_widget' => '</div>',
	) );
}

// from : https://wordpress.org/support/topic/checking-if-there-are-next-posts
//functions tell whether there are previous or next 'pages' from the current page
//returns 0 if no 'page' exists, returns a number > 0 if 'page' does exist
//ob_ functions are used to suppress the previous_posts_link() and next_posts_link() from printing their output to the screen

function has_previous_posts() {
ob_start();
previous_post_link();
$result = strlen(ob_get_contents());
ob_end_clean();
return $result;
}

function has_next_posts() {
ob_start();
next_post_link();
$result = strlen(ob_get_contents());
ob_end_clean();
return $result;
}


add_action( 'widgets_init', 'glider_widgets_init' );

?>