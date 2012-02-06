<?php
/**
 * Add function to widgets_init that'll load our widget.
 * @since 0.1
 */
add_action( 'widgets_init', 'w2046_page_widget' );

/**
 * Register our widget.
 * 'w_2046_pages_Widget' is the widget class used below.
 *
 * @since 0.1
 */
function w2046_page_widget() {
	register_widget( 'w2046_pages_widget' );
}

/**
 * w_2046_pages Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 * @since 0.1
 */
 class w2046_pages_widget extends WP_Widget {
	/**
	 * Widget setup.
	 */
	function w2046_pages_widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'w_2046_pages', 'description' => __('Select what pages you want to see in the widget area. Fairly complex settings ;)', 'w_2046_pages') );
		/* Widget control settings. */
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'w_2046_pages-widget' );
		/* Create the widget. */
		$this->WP_Widget( 'w_2046_pages-widget', __('2046 - page loop widget', 'w_2046_pages'), $widget_ops, $control_ops );
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array(
			'the_title' => __('', 'w_2046_pages'), // false, true
			'image_size' => __('2', 'w_2046_pages'), // none, thumbnail, large
			'page_selector' => __('1', 'w_2046_pages'), // ids, category, from the same category
			'comments_booble' => __('', 'w_2046_pages'), // false, true
			'page_ids' => __('', 'w_2046_pages'), // num, (coma delimiter)
			'parent_page_id' => __('', 'w_2046_pages'), // num, (coma delimiter)
			'with_excerpt' => __('1', 'w_2046_pages'), // false, true
			'how_many' => __('1', 'w_2046_pages'), // number
			'with_offset' => __('', 'w_2046_pages'), // num
			'show_next_link' => __('', 'w_2046_pages'), // false, true
			);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		<div id="the_widget_id_<?php echo $this->id; ?>">
			<p class="pw_the_title">
				<strong>The title</strong><br />
				<input type="text" name="<?php echo $this->get_field_name( 'the_title' ); ?>" value="<?php echo $instance['the_title'] ?>"/>
				<br />
				<small>if empty: no title, no html, nothing</small>
			</p>
			<p class="pw_image_size">
				<strong>Image size</strong><br />
				<input class="h" type="radio" name="<?php echo $this->get_field_name( 'image_size' ); ?>" value="0" <?php if ($instance['image_size'] == 0) echo 'checked="checked"'; ?>> No picture<br>
				<input class="h" type="radio" name="<?php echo $this->get_field_name( 'image_size' ); ?>" value="1" <?php if ($instance['image_size'] == 1) echo 'checked="checked"'; ?>> Thumbnail<br>
				<input class="h" type="radio" name="<?php echo $this->get_field_name( 'image_size' ); ?>" value="2" <?php if ($instance['image_size'] == 2) echo 'checked="checked"'; ?>> Medium<br />
				<input class="h" type="radio" name="<?php echo $this->get_field_name( 'image_size' ); ?>" value="3" <?php if ($instance['image_size'] == 3) echo 'checked="checked"'; ?>> Large
			</p>
			<p class="pw_the_title">
		
				<strong>Show excerpt</strong><br />
				<input id="tryme" type="checkbox" name="<?php echo $this->get_field_name( 'with_excerpt' ); ?>" <?php if ($instance['with_excerpt'] == 'on'){ echo 'checked="checked"'; } ?> />
			</p>
			<p class="pw_comments_booble">
		
				<strong>Show comments booble</strong><br />
				<input type="checkbox" name="<?php echo $this->get_field_name( 'comments_booble' ); ?>" <?php if ($instance['comments_booble'] == 'on'){ echo 'checked="checked"'; } ?> />
			</p>
			<p class="pw_page_selector">
				<strong>Select the logic</strong><br />
				<select name="<?php echo $this->get_field_name( 'page_selector' ); ?>" id="page_selector" >
					<?php echo '<option '; if($instance['page_selector'] == 0){echo 'selected="selected"';} echo' value="0" >Select pages by ID</option>'; ?>
					<?php echo '<option '; if($instance['page_selector'] == 1){echo 'selected="selected"';} echo' value="1" >Children pages of Page parent</option>'; ?>
					<?php echo '<option '; if($instance['page_selector'] == 2){echo 'selected="selected"';} echo' value="2" >Children pages of current page</option>'; ?>
				</select>
			</p>
			<hr />
			<p class="pw_page_ids">
				<strong>page id's you want to show.</strong><br />
				<input type="text" name="<?php echo $this->get_field_name( 'page_ids' ); ?>" <?php if (!empty($instance['page_ids'])){ echo 'value="'.$instance['page_ids'].'"'; }else{ echo 'value=""';}; ?>/>
				<br />
				<small>Separate them by comma. Published ONLY!</small>
			</p>
			<p class="pw_parent_page_id">
				<strong>Page parent ID</strong><br />
				<input type="text" name="<?php echo $this->get_field_name( 'parent_page_id' ); ?>" <?php if (!empty($instance['parent_page_id'])){ echo 'value="'.$instance['parent_page_id'].'"'; }else{ echo 'value=""';}; ?>/>
				<br />
				<small>ONLY one page ID !</small>
			</p>
		</div> 
		<script type="text/javascript">
			jQuery(document).ready(function(){ 
				// get this	 widget id
				// this is important! Otherwise the selection changes will change settings in other same widgets.
				var parent_widget = "#the_widget_id_<?php echo $this->id; ?>";
				//alert("the_widget_id_<?php echo $this->id; ?>");
	
				// get the value form the DB
				var init_selector = <?php echo $instance['page_selector']; ?>;
				// show-hide elements onload
				
				if(init_selector == 0){
					jQuery(parent_widget + " p.pw_page_ids").show();
					jQuery(parent_widget + " p.pw_parent_page_id").hide();
				};
				if(init_selector == 1){
					jQuery(parent_widget + " p.pw_page_ids").hide();
					jQuery(parent_widget + " p.pw_parent_page_id").show();
				};
				if(init_selector == 2){
					jQuery(parent_widget + " p.pw_page_ids").hide();
					jQuery(parent_widget + " p.pw_parent_page_id").hide();
				};
				
				// show hide UI elements when the user change it
				jQuery(parent_widget + " p select#page_selector").change(function () {
					if(jQuery(this).val() == 0){
						jQuery(parent_widget + " p.pw_page_ids").show();
						jQuery(parent_widget + " p.pw_parent_page_id").hide();
					};
					if(jQuery(this).val() == 1){
						jQuery(parent_widget + " p.pw_page_ids").hide();
						jQuery(parent_widget + " p.pw_parent_page_id").show();
					};
					if(jQuery(this).val() == 2){
						jQuery(parent_widget + " p.pw_page_ids").hide();
						jQuery(parent_widget + " p.pw_parent_page_id").hide();
					};
				});
			});
			
		</script>
	<?php
	}
	
	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['the_title'] = strip_tags( $new_instance['the_title'] ); // false, true
		$instance['image_size'] = strip_tags( $new_instance['image_size'] ); // none, thumbnail, large
		$instance['page_selector'] = strip_tags( $new_instance['page_selector'] ); // ids, category, from the same category
		$instance['comments_booble'] = strip_tags( $new_instance['comments_booble'] ); // false, true
		$instance['page_ids'] = strip_tags( $new_instance['page_ids'] ); // num, (coma delimiter)
		$instance['parent_page_id'] = strip_tags( $new_instance['parent_page_id'] ); // num
		$instance['with_excerpt'] = strip_tags( $new_instance['with_excerpt'] ); // false, true


		return $instance;
	}

	/**
	 * How to display the widget on the front end
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$the_title = $instance['the_title']; // false, true
		$image_size = $instance['image_size']; // none, thumbnail, large
		$page_selector = $instance['page_selector']; // ids, category, from the same category
		$comments_booble = $instance['comments_booble']; // false, true
		$page_ids = $instance['page_ids']; // num, (coma delimiter)
		$parent_page_id = $instance['parent_page_id']; // num
		$with_excerpt = $instance['with_excerpt']; // false, true

		/* Before widget (defined by themes). */
		echo $before_widget;
		/* Display name from widget settings if one was input. */
		
		// The Query
		// define an empty args
		$args = array(
			'post_type' => 'page',
			'post_status' => 'publish'
		);
		
		if ($page_selector == 0){
			if (!empty($page_ids)){
				// remove spaces
				$page_ids_clean = str_replace (" ", "", $page_ids);
				// convert to an array of ids
				$page_ids_exploded = explode(',' ,$page_ids_clean);
				$args_ids = array(
					'post__in' => $page_ids_exploded,
		 		);
				$args = array_merge( $args , $args_ids);
			}
		}
		elseif ($page_selector == 1){
			$page_id = $page_ids_clean = str_replace (" ", "", $parent_page_id);
			$page_id_ = explode(',' ,$page_id);
			if(!empty($page_id_[0])){
				$args_page_parent = array(
					'post_parent' => $page_id_[0]
			 	);
				$args = array_merge( $args , $args_page_parent);
			}
		}else{
			global $post;
			$args_page_parent = array(
				'post_parent' => $post->ID
		 	);
			$args = array_merge( $args , $args_page_parent);
		
		}
		//var_dump($args);
		$the_query = new WP_Query( $args );

		// The Loop
		if($the_query->have_posts()){
			if(!empty($the_title)){
				echo '<h4>'.$the_title.'</h4>';
			}
			while ( $the_query->have_posts() ) : $the_query->the_post();
				echo '<div id="page-'.get_the_ID().'"';
				post_class();
				echo '>';
					echo '<h2>';
						echo '<a href="'. get_permalink() . '" title="'. get_the_title().'">';
						the_title();
						echo '</a>';
						if($comments_booble == 'on' && ( comments_open() )){
							echo '<span class="comment_number">';
								comments_number( ':)', '1', '%' );
							echo '</span>';
							if(comments_open() == false){
									echo ' &#10013;'; //&#9873;
								}
						}
					echo '</h2>';
					// get the image if is wanted
					if($image_size == 1){
						echo '<span class="alignleft">';
							the_post_thumbnail('thumbnail');
						echo '</span>';
					}
					if($image_size == 2){
							the_post_thumbnail('medium');
					}
					elseif($image_size == 3){
						the_post_thumbnail('large');
					}
					// print the excerpt if it is wanted
					if($with_excerpt == 'on'){
						the_excerpt();
					}
				echo '</div>';
			endwhile;
		}
		wp_reset_postdata();
		
		echo $after_widget;
	}
}
