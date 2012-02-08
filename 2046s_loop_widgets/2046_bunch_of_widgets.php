<?php
/**
 * Plugin name: 2046's widget loops
 * Plugin URI: 
 * Description: 2046's loop widgets boost you website prototyping.
 * Version: 0.12
 * Author: 2046
 * Author URI: 
 *
 */
/* get the main post widget*/
require_once(dirname(__FILE__).'/widgets/2046_list_of_recent_posts.php');
/* get post widget*/
require_once(dirname(__FILE__).'/widgets/2046_post_widget.php');
/* get page widget*/
require_once(dirname(__FILE__).'/widgets/2046_page_widget.php');
/* get zpravicky widget*/
require_once(dirname(__FILE__).'/widgets/2046_post_zpravicky_widget.php');

// add WP featured image support
if ( function_exists( 'add_theme_support' ) ) { 
	add_theme_support( 'post-thumbnails' ); 
}

// all credits for this hack belongs to people from
// http://wordpress.stackexchange.com/questions/14331/get-terms-by-taxonomy-and-post-type
function get_terms_by_post_type_2046($post_type,$taxonomy,$fields='all',$args){
	$q_args = array(
		'post_type' => (array)$post_type,
		'posts_per_page' => -1
	);
	$the_query = new WP_Query( $q_args );

	$terms = array();

	while ($the_query->have_posts()) { $the_query->the_post();

		global $post;

		$current_terms = get_the_terms( $post->ID, $taxonomy);
		if(!empty($current_terms)){
			foreach ($current_terms as $t){
				//avoid duplicates
				if (!in_array($t,$terms)){
					$t->count = 1;
					$terms[] = $t;
				}else{
					$key = array_search($t, $terms);
					$terms[$key]->count = $terms[$key]->count + 1;
				}
			}
		}
	}
	wp_reset_query();

	//return array of term objects
	if ($fields == "all")
		return $terms;
	//return array of term ID's
	if ($fields == "ID"){
		foreach ($terms as $t){
			$re[] = $t->term_id;
		}
		return $re;
	}
	//return array of term names
	if ($fields == "name"){
		foreach ($terms as $t){
			$re[] = $t->name;
		}
		return $re;
	}
	// get terms with get_terms arguments
	if ($fields == "get_terms"){
		$terms2 = get_terms( $taxonomy, $args );

		foreach ($terms as $t){
			if (in_array($t,$terms2)){
				$re[] = $t;
			}
		}
		return $re;
	}
}
