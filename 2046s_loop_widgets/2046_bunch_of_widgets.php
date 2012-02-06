<?php
/**
 * Plugin name: 2046's widget loops
 * Plugin URI: 
 * Description: 2046's loop widgets boost you website prototyping. Unlike other loop widgets "2046's loop widgets" are made with top-down logic. Meaning, when you build the content you don't think about the programming logic behind it. The only thing you have to decide is what content you want to see and where. These widgets covers the most routinely used Post and Page content logic. They are not supposed to fully cover all the possible layouts. The aim of these widgets is to speed up the process of content structuring and simplicity of usage rather then offer overwhelming complex solution where you loose your self in an instant.
 * Version: 0.1
 * Author: 2046
 * Author URI: 
 *
 */
/* get the main post widget*/
require_once(dirname(__FILE__).'/widgets/2046_list_of_recent_posts.php');
/* get post widged*/
require_once(dirname(__FILE__).'/widgets/2046_post_widget.php');
/* get page widged*/
require_once(dirname(__FILE__).'/widgets/2046_page_widget.php');

// add WP featured image support
if ( function_exists( 'add_theme_support' ) ) { 
	add_theme_support( 'post-thumbnails' ); 
}
