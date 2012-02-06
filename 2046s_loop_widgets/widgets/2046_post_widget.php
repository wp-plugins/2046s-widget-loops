<?php
/**
 * Add function to widgets_init that'll load our widget.
 * @since 0.1
 */
add_action( 'widgets_init', 'w2046_post_widget' );

/**
 * Register our widget.
 * 'w_2046_posts_Widget' is the widget class used below.
 *
 * @since 0.1
 */
function w2046_post_widget() {
	register_widget( 'w2046_posts_widget' );
}

/**
 * w_2046_posts Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 * @since 0.1
 */
 class w2046_posts_widget extends WP_Widget {
	/**
	 * Widget setup.
	 */
	function w2046_posts_widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'w_2046_posts', 'description' => __('Select what posts you want to see in the widget area. Fairly complex settings ;)', 'w_2046_posts') );
		/* Widget control settings. */
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'w_2046_posts-widget' );
		/* Create the widget. */
		$this->WP_Widget( 'w_2046_posts-widget', __('2046 - post loop widget', 'w_2046_posts'), $widget_ops, $control_ops );
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array(
			'the_title' => __('', 'w_2046_posts'), // false, true
			'image_size' => __('2', 'w_2046_posts'), // none, thumbnail, large
			'cat_selector' => __('1', 'w_2046_posts'), // ids, category, from the same category
			'comments_booble' => __('', 'w_2046_posts'), // false, true
			'category' => __('', 'w_2046_posts'), // category selector - all, select
			'post_ids' => __('', 'w_2046_posts'), // num, (coma delimiter)
			'with_excerpt' => __('1', 'w_2046_posts'), // false, true
			'how_many' => __('1', 'w_2046_posts'), // number
			'with_offset' => __('', 'w_2046_posts'), // num
			'show_next_link' => __('', 'w_2046_posts'), // false, true
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
			<p class="pw_cat_selector">
				<strong>Select the logic</strong><br />
				<select name="<?php echo $this->get_field_name( 'cat_selector' ); ?>" id="cat_selector" >
					<?php echo '<option '; if($instance['cat_selector'] == 0){echo 'selected="selected"';} echo' value="0" >Select posts by ID</option>'; ?>
					<?php echo '<option '; if($instance['cat_selector'] == 1){echo 'selected="selected"';} echo' value="1" >Category</option>'; ?>
					<?php echo '<option '; if($instance['cat_selector'] == 2){echo 'selected="selected"';} echo' value="2" >From the same category</option>'; ?>
				</select>
			</p>
		
			<hr />
			<p class="pw_post_ids">
				<strong>Post id's you want to show.</strong><br />
				<input type="text" name="<?php echo $this->get_field_name( 'post_ids' ); ?>" <?php if (!empty($instance['post_ids'])){ echo 'value="'.$instance['post_ids'].'"'; }else{ echo 'value=""';}; ?>/>
				<br />
				<small>Separate them by comma. Published ONLY!</small>
			</p>
			<p class="pw_category">
				<strong>Select category</strong><br />
				<select name="<?php echo $this->get_field_name( 'category' ); ?>" id="<?php echo $this->get_field_id( 'category' ); ?>">
					<?php
					$categories = get_terms('category','hide_empty=0');
					echo '<option value="">all</option>';
					foreach ($categories as $category){
						echo  '<option ';
						if(strip_tags( $instance['category'] ) == $category->term_id)
							echo 'selected="selected"';
						echo' value="'.$category->term_id.'">'.$category->name.'</option>';
					}
					?>
				</select>
			</p>
			<p class="pw_how_many">
				<strong>Number of posts</strong><br />
				<input type="text" name="<?php echo $this->get_field_name( 'how_many' ); ?>" <?php if (!empty($instance['how_many'])){ echo 'value="'.$instance['how_many'].'"'; }else{ echo 'value=""';}; ?>/>
			</p>
			<p class="pw_with_offset">
				<strong>Offset</strong><br />
				<input type="text" name="<?php echo $this->get_field_name( 'with_offset' ); ?>" <?php if (!empty($instance['with_offset'])){ echo 'value="'.$instance['with_offset'].'"'; }else{ echo 'value=""';}; ?>/>
				<br />
				<small>If this should be a list of next posts above the top recent post then the offset will be logicaly 1.</small>
			</p>
			<!--<p class="pw_show_next_link">
				<strong>Show next link</strong><br />
				<input type="checkbox" name="<?php echo $this->get_field_name( 'show_next_link' ); ?>" <?php if ($instance['show_next_link'] == 'on'){ echo 'checked="checked"'; } ?> />
			</p>-->
		</div> 
		<script type="text/javascript">
			jQuery(document).ready(function(){ 
				// get this	 widget id
				// this is important! Otherwise the selection changes will change settings in other same widgets.
				var parent_widget = "#the_widget_id_<?php echo $this->id; ?>";
				// get the widget parent id when droped in the sidebar
				/*jQuery('div.widgets-sortables').bind('sortstop',function(event,ui){
					//setTimeout(function(){
						var id_attr = jQuery( '.pw_cat_selector' ).closest( '.widget' ).attr("id");//.find( 'input[name="widget-id"]' ).val();
						alert(id_attr);
					//}, 600);
					
					//var parent_widget = "#the_widget_id_<?php echo $this->id; ?>";
				});*/
				// get the value form the DB
				var init_selector = <?php echo $instance['cat_selector']; ?>;
				// show-hide elements onload
				
				if(init_selector == 0){
					jQuery(parent_widget + " p.pw_post_ids").show();
					jQuery(parent_widget + " p.pw_category, " + parent_widget + " p.pw_how_many, " + parent_widget + " p.pw_with_offset, " + parent_widget + " p.pw_show_next_link").hide();
				};
				if(init_selector == 1){
					jQuery(parent_widget + " p.pw_post_ids").hide();
					jQuery(parent_widget + " p.pw_category, " + parent_widget + " p.pw_how_many, " + parent_widget + " p.pw_with_offset, " + parent_widget + " p.pw_show_next_link").show();
				};
				if(init_selector == 2){
					jQuery(parent_widget + " p.pw_post_ids, " + parent_widget + " p.pw_category").hide();
					jQuery(parent_widget + " p.pw_how_many, " + parent_widget + " p.pw_with_offset, " + parent_widget + " p.pw_show_next_link").show();
				};
				
				// show hide UI elements when the user change it
				jQuery(parent_widget + " p select#cat_selector").change(function () {
					if(jQuery(this).val() == 0){
						jQuery(parent_widget + " p.pw_post_ids").show();
						jQuery(parent_widget + " p.pw_category, " + parent_widget + " p.pw_how_many, " + parent_widget + " p.pw_with_offset, " + parent_widget + " p.pw_show_next_link").hide();
					};
					if(jQuery(this).val() == 1){
						jQuery(parent_widget + " p.pw_post_ids").hide();
						jQuery(parent_widget + " p.pw_category, " + parent_widget + " p.pw_how_many, " + parent_widget + " p.pw_with_offset, " + parent_widget + " p.pw_show_next_link").show();
					};
					if(jQuery(this).val() == 2){
						jQuery(parent_widget + " p.pw_post_ids, " + parent_widget + " p.pw_category").hide();
						jQuery(parent_widget + " p.pw_how_many, " + parent_widget + " p.pw_with_offset, " + parent_widget + " p.pw_show_next_link").show();
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
		$instance['cat_selector'] = strip_tags( $new_instance['cat_selector'] ); // ids, category, from the same category
		$instance['comments_booble'] = strip_tags( $new_instance['comments_booble'] ); // false, true
		$instance['category'] = strip_tags( $new_instance['category'] ); // category selector - all, select
		$instance['post_ids'] = strip_tags( $new_instance['post_ids'] ); // num, (coma delimiter)
		$instance['with_excerpt'] = strip_tags( $new_instance['with_excerpt'] ); // false, true
		$instance['how_many'] = strip_tags( $new_instance['how_many'] ); // number
		$instance['with_offset'] = strip_tags( $new_instance['with_offset'] ); // num
		//$instance['show_next_link'] = strip_tags( $new_instance['show_next_link'] ); // false, true


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
		$cat_selector = $instance['cat_selector']; // ids, category, from the same category
		$comments_booble = $instance['comments_booble']; // false, true
		$category = $instance['category']; // category selector - all, select
		$post_ids = $instance['post_ids']; // num, (coma delimiter)
		$with_excerpt = $instance['with_excerpt']; // false, true
		$how_many = $instance['how_many']; // number
		$with_offset = $instance['with_offset']; // num
		//$show_next_link = $instance['show_next_link']; // false, true
		

		/* Before widget (defined by themes). */
		echo $before_widget;
		
		// Get the current shown post informations
		global $post;
		// this hack the exeptional cases such as empty search result, when on search page ;)
		if(empty($post->ID)){
			$post->ID = 0;
		}
		// The Query
		// define an empty args
		$args = array(
			'post_type' => 'post',
			'post_status' => 'publish',
			'post__not_in' => array( $post->ID )
		);
		
		if ($cat_selector == 0){
			if (!empty($post_ids)){
				// remove spaces
				$post_ids_clean = str_replace (" ", "", $post_ids);
				// convert to an array of ids
				$post_ids_exploded = explode(',' ,$post_ids_clean);
				//echo count($post_ids_exploded);
				//var_dump($post_ids_exploded);
				// add it to the args
				$args_ids = array(
					'post__in' => $post_ids_exploded,
					'posts_per_page' => count($post_ids_exploded)
		 		);
				$args = array_merge( $args , $args_ids);
			}
		}
		elseif ($cat_selector == 1 || $cat_selector == 2){
			// how many posts has to shown
			if (!empty($how_many)){
				$args_how_many = array(
					'posts_per_page' => $how_many
		 		);
				$args = array_merge( $args , $args_how_many);
			}
			// offset
			if (!empty($with_offset)){
				$args_with_offset = array(	
					'offset' => $with_offset
		 		);
				$args = array_merge( $args , $args_with_offset);
			}
			//from the same category as the shown post
			if($cat_selector == 2){
				// of on selected post types
				// which actually doesn't make sense for this logical
				// do not restrict ( to nonsense page term_id) & show all
				if(!is_page() && !is_search() && !is_archive()){
					$given_categories = get_the_category( $post->ID );
					$tmp_category_list = array();
					foreach($given_categories as $each){
						array_push($tmp_category_list, $each->term_id);
					}
					$args_same_category = array(
						'category__in' => $tmp_category_list
				 	);
					$args = array_merge( $args , $args_same_category);
				} 
			}else{
				// add category to the array
				if (!empty($category)){
					$args_category = array(
						'cat' => $category
			 		);
					$args = array_merge( $args , $args_category);
				}
			}
		}
		$the_query = new WP_Query( $args );
		
		// The Loop
		if ($the_query->have_posts()){
			if(!empty($the_title)){
				echo '<h4>'.$the_title.'</h4>';
			}
			while ( $the_query->have_posts() ) : $the_query->the_post();
				echo '<div id="post-'.get_the_ID().'" ';
				post_class();
				echo '>';
					echo '<h2>';
						echo '<a href="'. get_permalink() . '" title="';
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
						if($comments_booble == 'on'){
							echo '<span class="comment_number">';
								comments_number( ':)	', '1', '%' );
								if(comments_open() == false){
									echo ' &#10013;'; //&#9873;
								}
							echo '</span>';
						}
					echo '</h2>';
					// get the image if is wanted
					// define thumbnail atributes
					$default_attr = array(
						'title'	=> trim(strip_tags( $the_query->post->post_title )),
					);
					if($image_size == 1){
						echo '<span class="alignleft">';
						
							the_post_thumbnail('thumbnail', $default_attr);
						echo '</span>';
					}
					if($image_size == 2){
							the_post_thumbnail('medium', $default_attr);
					}
					elseif($image_size == 3){
						the_post_thumbnail('large', $default_attr);
					}
					// print the excerpt if it is wanted
					if($with_excerpt == 'on'){
						the_excerpt();
					}
				echo '</div>';
			endwhile;
		}
		/*if($show_next_link == 'on'){
			posts_nav_link();
			if(function_exists('wp_pagenavi')){
				wp_pagenavi( array( 'query' => $the_query ) );
			}
		}
		*/
		
		// Reset Post Data
		wp_reset_postdata();
		
		echo $after_widget;
	}
}
