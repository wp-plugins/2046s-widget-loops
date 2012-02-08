<?php
/**
 * Add function to widgets_init that'll load our widget.
 * @since 0.1
 */
add_action( 'widgets_init', 'w2046_recent_post_load_widgets' );

/**
 * Register our widget.
 * 'wname_Widget' is the widget class used below.
 *
 * @since 0.1
 */
function w2046_recent_post_load_widgets() {
	register_widget( 'w2046_recent_post' );
}

/**
 * wname Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 * @since 0.1
 */
 class w2046_recent_post extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function w2046_recent_post() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'wname', 'description' => __('Shows the recent post. Define how.', 'wname') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'wname-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'wname-widget', __('2046 - Leading recent post', 'wname'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the front end
	 */
	function widget($args) {
		extract( $args );
		echo $before_widget;
		/* Display name from widget settings if one was input. */
			$args = array(
				'posts_per_page' => 1
			);
			
			echo '<div class="recent_post">'; 
				// The Query
				$the_query = new WP_Query( $args );

				// The Loop
				while ( $the_query->have_posts() ) : $the_query->the_post();
					if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
						echo '<a href="'. get_permalink() . '">';
							// define thumbnail atributes
							$default_attr = array(
								'title'	=> trim(strip_tags( $the_query->post->post_title )),
							);
							the_post_thumbnail('large', $default_attr);
						echo '</a>';
					} 
					echo '<h2>';
						echo '<a href="'. get_permalink() . '" class="oversize_1" title="';
						the_title();
						echo' : ' ;
						$under_categories = get_the_category();
						foreach($under_categories as $category) { 
						 	echo $category->cat_name;
						 	if  ($category != end($under_categories) ){
						 		echo ', ';
						 	}
						} 
						echo '">';
							the_title();
						echo '</a>';
						echo '<span class="comment_number">';
							comments_number( '', '1', '%' );
						echo '</span>';
					echo '</h2>';
					
					the_excerpt();
				endwhile;

				// Reset Post Data
				wp_reset_postdata();
			echo '</div>';

		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( ) {
	
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) { ?>

		<p>
			This widget shows the: Big picture, Heading, comments and excerpt.<br />
			It is ment to stay on the Index page as a leadng post.<br />
			<br />
			This content is widgetised so you can easily drag&drop an advertisment, or semthing else on top of it, if you need so.
		</p>
	<?php
	}
}

