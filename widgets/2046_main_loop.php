<?php
/**
 * Add function to widgets_init that'll load our widget.
 * @since 0.1
 */
add_action( 'widgets_init', 'w2046_main_loop_load_widgets' );

/**
 * Register our widget.
 * 'wname_2046_main_loop_Widget' is the widget class used below.
 *
 * @since 0.1
 */
function w2046_main_loop_load_widgets() {
	register_widget( 'w2046_main_loop' );
}

/**
 * wname_2046_main_loop Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 * @since 0.1
 */
 class w2046_main_loop extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function w2046_main_loop() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'wname_2046_main_loop', 'description' => __('It let\'s you show Post or Pages anywhere. The widget let\'s you allow or disallow the loop to be shown on certain places. Plus, you can show or hide comments and it\'s form.', 'wname_2046_main_loop') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'wname_2046_main_loop-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'wname_2046_main_loop-widget', __('2046 - Final Post/Page loop', 'wname_2046_main_loop'), $widget_ops, $control_ops );
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) { 

		/* Set up some default widget settings. */
		$defaults = array(
			'the_post_type' => __(0, 'w_2046_posts'), // false, true
			'the_widget_title' => __('', 'w_2046_posts'), // false, true
			'the_post_title' => __('on', 'w_2046_posts'), // false, true
			'image_position' => __('1', 'w_2046_posts'), // 0,1
			'image_size' => __('2', 'w_2046_posts'), // none, thumbnail, large
			'image_with_link' => __('', 'w_2046_posts'), // false, true
			'with_excerpt' => __('2', 'w_2046_posts'), // ids, category, from the sa
			'postmeta' => __(array(''), 'w_2046_posts'), // author, categories, tags
			'comments_selector' => __('', 'w_2046_posts'), // true, false
			'comments_comments_closed_info' => __('on', 'w_2046_posts'), // true, false
			'location_selector' => __(true, 'w_2046_posts'), // single, id, most recent
			'restrict_to_ids' => __('', 'w_2046_posts'), // numbs
			'id_or_recent' => __(0, 'w_2046_posts'), // single, id, most recent
			'post_id' => __('', 'w_2046_posts'), // num singl
			'with_offset' => __('', 'w_2046_posts'), // num
			'stick_on_template_types' => __(array(''), 'w_2046_posts'), // author, categories, tags
			'disallow_on_ids' => __('', 'w_2046_posts'), // num
			);
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		if($instance['the_post_type'] == 0){
			$type_title = 'post';
		}else{
			$type_title = 'page';
		}
		?>
		<div id="the_widget_id_<?php echo $this->id; ?>" class="pw_2046_lw">
			<em>Note: To see the widget behave properly, when you drop the wiget in here the widget should to be saved first.</em>
			<h3>Post type</h3>
			<div class="pw_holder">
				<p class="pw_the_post_type">
					<select name="<?php echo $this->get_field_name( 'the_post_type' ); ?>" class="the_post_type" >
						<?php echo '<option '; if($instance['the_post_type'] == 0){echo 'selected="selected"';} echo' value="0" >Post</option>'; ?>
						<?php echo '<option '; if($instance['the_post_type'] == 1){echo 'selected="selected"';} echo' value="1" >Page</option>'; ?>'; ?>
					</select>
				</p>
			</div>
			<h3>Widget title</h3>
			<div class="pw_holder">
				<p class="pw_the_title">
					<input type="text" name="<?php echo $this->get_field_name( 'the_widget_title' ); ?>" value="<?php echo $instance['the_widget_title'] ?>"/>
					<br />
					<em>if empty: no title, no html, nothing</em>
				</p>
			</div>
			<h3>Content</h3>
			<div class="pw_holder">
				<p class="pw_image_position">
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="<?php echo $this->get_field_name( 'image_position' ); ?>" value="0" <?php if ($instance['image_position'] == 0) echo 'checked="checked"'; ?>> Image above the title<br />
					<input type="checkbox" name="<?php echo $this->get_field_name( 'the_post_title' ); ?>" <?php if ($instance['the_post_title'] == 'on'){ echo 'checked="checked"'; } ?> /> Show post title<br />
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="<?php echo $this->get_field_name( 'image_position' ); ?>" value="1" <?php if ($instance['image_position'] == 1) echo 'checked="checked"'; ?>> Image below the title<br />
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="<?php echo $this->get_field_name( 'image_with_link' ); ?>" <?php if ($instance['image_with_link'] == 'on'){ echo 'checked="checked"'; } ?> /> Make image as a link to the <?php echo $type_title; ?>
				</p>
				<strong>Image size</strong>
				<p class="pw_image_size">
					
					<input type="radio" name="<?php echo $this->get_field_name( 'image_size' ); ?>" value="0" <?php if ($instance['image_size'] == 0) echo 'checked="checked"'; ?>> No picture<br>
					<input type="radio" name="<?php echo $this->get_field_name( 'image_size' ); ?>" value="1" <?php if ($instance['image_size'] == 1) echo 'checked="checked"'; ?>> Thumbnail<br>
					<input type="radio" name="<?php echo $this->get_field_name( 'image_size' ); ?>" value="2" <?php if ($instance['image_size'] == 2) echo 'checked="checked"'; ?>> Medium<br />
					<input type="radio" name="<?php echo $this->get_field_name( 'image_size' ); ?>" value="3" <?php if ($instance['image_size'] == 3) echo 'checked="checked"'; ?>> Large
				</p>
				<p class="pw_with_excerpt">
					<strong>Content</strong><br />
					<input type="radio" name="<?php echo $this->get_field_name( 'with_excerpt' ); ?>" value="0" <?php if ($instance['with_excerpt'] == 0) echo 'checked="checked"'; ?>> No content<br>
					<input type="radio" name="<?php echo $this->get_field_name( 'with_excerpt' ); ?>" value="1" <?php if ($instance['with_excerpt'] == 1) echo 'checked="checked"'; ?>> Excerpt<br>
					<input type="radio" name="<?php echo $this->get_field_name( 'with_excerpt' ); ?>" value="2" <?php if ($instance['with_excerpt'] == 2) echo 'checked="checked"'; ?>> Content<br />
				</p>
				
				<p class="pw_postmeta">
					<strong>Whether to show <?php echo $type_title; ?>meta</strong>
					<fieldset class="stick_on_template_types" id="stick_on_template_types">
						<?php
						$i = 1;
						$template_types = array('Author', 'Categories', 'Tags');
						foreach ($template_types as $types){
							echo '<input';
							if(is_array($instance['postmeta'])){
								if(in_array($i,$instance['postmeta'])){
									echo ' checked="checked"';
								}
							}
							echo ' type="checkbox" name="'.$this->get_field_name( 'postmeta' ).'[]" value="'.$i.'" /> '.$types.'<br />';
							$i++;
						}
						?>
					</fieldset>
				</p>
				<strong>Show comments</strong>
				<p class="pw_comments_selector">
					<select name="<?php echo $this->get_field_name( 'comments_selector' ); ?>" class="comments_selector" >
						<?php echo '<option '; if($instance['comments_selector'] == 0){echo 'selected="selected"';} echo' value="0" >Show</option>'; ?>
						<?php echo '<option '; if($instance['comments_selector'] == 1){echo 'selected="selected"';} echo' value="1" >Hide</option>'; ?>'; ?>
					</select>
				</p>
				<p class="pw_comments_comments_closed_info">
					<input type="checkbox" name="<?php echo $this->get_field_name( 'comments_comments_closed_info' ); ?>" <?php if ($instance['comments_comments_closed_info'] == 'on'){ echo 'checked="checked"'; } ?> /> Show warning text if comments are closed
					<br />
					<em>Note: Comments will be shown on final post or page only!</em>
				</p>
			</div>
			
			<h3>Where this loop will be shown & what <?php echo $type_title; ?></h3>
			<div class="pw_holder">
				<p class="pw_location_selector">
					<select name="<?php echo $this->get_field_name( 'location_selector' ); ?>" class="location_selector" >
						<?php echo '<option '; if($instance['location_selector'] == 0){echo 'selected="selected"';} echo' value="0" >On final Post (Page)</option>'; ?>
						<?php echo '<option '; if($instance['location_selector'] == 1){echo 'selected="selected"';} echo' value="1" >Elsewhere</option>'; ?>
					</select>
					<p>
					<em>"On final post" make sense when the widget is in the sidebar on single.php or page.php.</em>
					</p>
					<p>
					<em>"Elsewhere" you have to define what <?php echo $type_title; ?> content you want to see. Good choice if you want to use it on Index page if you want to emphasize the most recent post or something like that. </em>
					</p>
				</p>
				<div class="if_elsewhere">
					<div class="id_or_recent_box">
						<h3>Which <?php echo $type_title; ?></h3>
						<p class="pw_id_or_recent">
							<select name="<?php echo $this->get_field_name( 'id_or_recent' ); ?>" class="id_or_recent" >
								<?php echo '<option '; if($instance['id_or_recent'] == 0){echo 'selected="selected"';} echo' value="0" >Select the '.$type_title.' by ID</option>'; ?>
								<?php echo '<option '; if($instance['id_or_recent'] == 1){echo 'selected="selected"';} echo' value="1" >Show the most recent</option>'; ?>
							</select>
						</p>
					</div>
					<p class="pw_post_id">
						<strong>Enter <?php echo $type_title; ?> ID</strong><br />
						<input type="text" name="<?php echo $this->get_field_name( 'post_id' ); ?>" <?php if (!empty($instance['post_id'])){ echo 'value="'.$instance['post_id'].'"'; }else{ echo 'value=""';}; ?>/>
						<br />
						<em>One only!</em>
					</p>
					<p class="pw_with_offset">
						<strong>Offset</strong><br />
						<input type="text" name="<?php echo $this->get_field_name( 'with_offset' ); ?>" <?php if (!empty($instance['with_offset'])){ echo 'value="'.$instance['with_offset'].'"'; }else{ echo 'value=""';}; ?>/>
						<br />
						<em>The offset is counted from the most recent post (by date). </em>
					</p>
					<h3>Restrict to</h3>
					<div class="pw_holder">
						<p class="restrict_to_ids">
							<strong>Restrict to post or page IDs:</strong><br />
							<input type="text" name="<?php echo $this->get_field_name( 'restrict_to_ids' ); ?>" <?php if (!empty($instance['restrict_to_ids'])){ echo 'value="'.$instance['restrict_to_ids'].'"'; }else{ echo 'value=""';}; ?>/>
							<br />
							<em>No restrictions if empty. Separate IDs by comma.</em>
						</p>
					</div>
					<h3>Prevent from being shown on</h3>
					<div class="pw_holder">
						<p class="pw_stick_on_template_types">
							<fieldset class="stick_on_template_types" id="stick_on_template_types">
								<?php
								$i = 1;
								$template_types = array('Single post', 'Single page','Home', 'Front Page', 'Archive', 'Tag/Term list', 'Category list', 'Author\'s list', 'Search', '404 error page');
								foreach ($template_types as $types){
									echo '<input';
									if(is_array($instance['stick_on_template_types'])){
										if(in_array($i,$instance['stick_on_template_types'])){
											echo ' checked="checked"';
										}
									}
									echo ' type="checkbox" name="'.$this->get_field_name( 'stick_on_template_types' ).'[]" value="'.$i.'" /> '.$types.'<br />';
									$i++;
								}
								?>
							</fieldset>
						</p>
						<p class="disallow_on_ids">
							<strong>Do not show on post/page with IDs:</strong><br />
							<input type="text" name="<?php echo $this->get_field_name( 'disallow_on_ids' ); ?>" <?php if (!empty($instance['disallow_on_ids'])){ echo 'value="'.$instance['disallow_on_ids'].'"'; }else{ echo 'value=""';}; ?>/>
							<br />
							<em>No restrictions if empty. Separate IDs by comma.</em>
						</p>
					</div>
				</div>
			</div>
			
			<style type="text/css">
				.pw_holder{background:#fff;border:1px solid #ccc;border-radius:3px;padding:0.5em;}
				.pw_2046_lw input[type=text], .pw_2046_lw select{width:100%;}
			</style>
			<script type="text/javascript">
			
				jQuery(document).ready(function(){ 
					// get this	 widget id
					// this is important! Otherwise the selection changes will change settings in other same widgets.
					var parent_widget = "#the_widget_id_<?php echo $this->id; ?>";
					// get the value form the DB
					var location_selector = <?php echo $instance['location_selector']; ?>;
					// get the value form the DB
					var id_or_recent = <?php echo $instance['id_or_recent']; ?>;
					// chek if the content type is a page
					var the_post_type = <?php echo $instance['the_post_type']; ?>;
					
					// ALL THE SAME
					// ONLOAD
					if(location_selector == 0){
						jQuery(parent_widget + " div.if_elsewhere").hide();
					}else{
						jQuery(parent_widget + " div.if_elsewhere").show();
						// SHOW the id-recent selector
						if(jQuery(parent_widget + ' .id_or_recent').val() == 0){
							jQuery(parent_widget + " .pw_with_offset").hide();
							jQuery(parent_widget + " .pw_post_id").fadeIn();
						}
						else{
							jQuery(parent_widget + " .pw_post_id").hide();
							// if the post type is post, show it else it makes "no sense"
							jQuery(parent_widget + " .pw_with_offset").fadeIn();
						};
					}
					// ON ACTIONS
					// show hide UI elements when the user change it
					jQuery(parent_widget + ' .location_selector').change(function () {
						// 0 ==curent post
						if(jQuery(this).val() == 0){
							jQuery(parent_widget + " div.if_elsewhere").hide();
						}
						else{ // 1 == elsewhere
							jQuery(parent_widget + " div.if_elsewhere").show();
						};
					});
					// ON POST
					if(the_post_type == 0){
						// ON ACTIONS
						// show hide UI elements when the user change it
						jQuery(parent_widget + ' .location_selector').change(function () {
							// 0 ==curent post
							if(jQuery(this).val() == 0){
								jQuery(parent_widget + " div.if_elsewhere").hide();
								
							}
							// 1 == elsewhere
							else{
								jQuery(parent_widget + " .id_or_recent_box").show();
								if(id_or_recent == 0){
									jQuery(parent_widget + " p.pw_with_offset").hide();
									jQuery(parent_widget + " p.pw_post_id").show();
								}else{
									jQuery(parent_widget + " p.pw_with_offset").show();
									jQuery(parent_widget + " p.pw_post_id").hide();
								}
							};
						});
					}
					// ON PAGE
					else{	// FIRST hide elements that surelly wont be used on PAGES
						jQuery(parent_widget + " .pw_with_offset," + parent_widget + " .id_or_recent_box").hide();
						
						// ON LOADS
						// show-hide elements onload - for ID || ELSEWHERE
						if(location_selector == 0){
							jQuery(parent_widget + " div.if_elsewhere").hide();
						}else{
							jQuery(parent_widget + " div.if_elsewhere").show();
							jQuery(parent_widget + " .pw_post_id").show();

						};
					// ON ACTIONS
					}
					// ACTION insie the post extra box
					// This is separate, because it happens only in the Post part anyway
					// show hide UI elements when the user change it
					jQuery(parent_widget + ' .id_or_recent').change(function () {
						if(jQuery(this).val() == 0){
							jQuery(parent_widget + " .pw_with_offset").hide();
							jQuery(parent_widget + " .pw_post_id").fadeIn();
						}else{
							jQuery(parent_widget + " .pw_post_id").hide();
							// if the post type is post, show it else it makes "no sense"
							jQuery(parent_widget + " .pw_with_offset").fadeIn();
						};
					});
					// TRIGGERS ON PAGE & POST SELECTION CHANGE
					jQuery(parent_widget + " .the_post_type").change(function(){
						// on PAGE select
						if(jQuery(this).val() == 1){
							// if location is ELSEWHERE
							if(jQuery(parent_widget + ' .location_selector').val() == 1){
								jQuery(parent_widget + " .pw_with_offset," + parent_widget + " .id_or_recent_box").hide();
								jQuery(parent_widget + " .pw_post_id").show();
							}
						}
						// on POST selection
						else{
							if(jQuery(parent_widget + ' .location_selector').val() == 1){
								// show id-recent switch
								jQuery(parent_widget + " .id_or_recent_box").show();
								// show the right selection
								if(jQuery(parent_widget + ' .id_or_recent').val() == 0){
									jQuery(parent_widget + " p.pw_with_offset").hide();
									jQuery(parent_widget + " p.pw_post_id").show();
								}else{
									jQuery(parent_widget + " p.pw_with_offset").show();
									jQuery(parent_widget + " p.pw_post_id").hide();
								}
							}
						}
					});
				});
				
			</script>	
		</div>
	<?php
	}
		/**
	 * Update the widget settings.
	 */
	function update($new_instance, $old_instance ) {
	
		$instance = $old_instance;

			/* Strip tags for title and name to remove HTML (important for text inputs). */
			$instance['the_post_type'] = strip_tags( $new_instance['the_post_type'] ); 
			$instance['the_widget_title'] = strip_tags( $new_instance['the_widget_title'] ); 
			$instance['the_post_title'] = strip_tags( $new_instance['the_post_title'] ); 
			$instance['image_size'] = strip_tags( $new_instance['image_size'] );
			$instance['image_position'] = strip_tags( $new_instance['image_position'] ); 
			$instance['image_with_link'] = strip_tags( $new_instance['image_with_link'] ); 
			$instance['with_excerpt'] = strip_tags( $new_instance['with_excerpt'] );
			$instance['postmeta'] = $new_instance['postmeta']; // array
			$instance['comments_selector'] = strip_tags( $new_instance['comments_selector'] );
			$instance['comments_comments_closed_info'] = strip_tags( $new_instance['comments_comments_closed_info'] );
			$instance['location_selector'] = strip_tags( $new_instance['location_selector'] );
			$instance['id_or_recent'] = strip_tags( $new_instance['id_or_recent'] );
			$instance['post_id'] = strip_tags( $new_instance['post_id'] );
			$instance['with_offset'] = strip_tags( $new_instance['with_offset'] );
			$instance['restrict_to_ids'] = strip_tags( $new_instance['restrict_to_ids'] );
			$instance['stick_on_template_types'] = $new_instance['stick_on_template_types']; 
			$instance['disallow_on_ids'] = $new_instance['disallow_on_ids']; 

		return $instance;
	}
	
	/**
	 * How to display the widget on the front end
	 */
	function widget($args, $instance) {
		extract( $args );
		
		// the viarables
		$the_post_type = $instance['the_post_type']; //
		$the_widget_title =$instance['the_widget_title']; //
		$the_post_title = $instance['the_post_title']; //
		$image_size = $instance['image_size'];//
		$image_position = $instance['image_position']; //
		$image_with_link = $instance['image_with_link']; //
		$with_excerpt = $instance['with_excerpt']; //
		$postmeta = $instance['postmeta']; //
		$comments_selector = $instance['comments_selector']; //
		$comments_comments_closed_info = $instance['comments_comments_closed_info']; //
		$location_selector = $instance['location_selector']; // 
		$id_or_recent = $instance['id_or_recent']; // 
		$post_id = $instance['post_id']; //
		$with_offset = $instance['with_offset']; //
		$restrict_to_ids = $instance['restrict_to_ids'];
		$stick_on_template_types = $instance['stick_on_template_types']; 
		$disallow_on_ids = $instance['disallow_on_ids']; 
		// reset the previous loops
		// just to be sure they wont manipulate the curent query
		wp_reset_postdata();
		// get the global data of curent seen post || page
		global $post;
		/* Display name from widget settings if one was input. */
			if ($the_post_type == 0){
				$selected_post_type = 'post';
			}else{
				$selected_post_type = 'page';
			}
			$args = array(
				'post_type' => $selected_post_type,
				'posts_per_page' => 1
			);
			// if they want to show particular ID instead the actual post || page
			// check if they selected location: "Elsewhere"
			if($location_selector == 1){
				// if the selected the ID
				if($id_or_recent == 0){
					// if they actually set the ID number
					if(!empty($post_id)){
						$post_id_clean = ereg_replace("[^0-9]", "", $post_id);
						$args_ids = array(
							'post__in' => array($post_id_clean)
				 		);
				 		$args = array_merge( $args , $args_ids);
			 		}
			 		// if they left the input empty, show nothing :)
			 		else{
			 			$args_ids = array(
							'post__in' => array(0)
				 		);
				 		$args = array_merge( $args , $args_ids);
			 		}
				}else{
					// they decided to offset the page
					if(!empty($with_offset)){
						$args_offset = array(
							'offset' => $with_offset
				 		);
				 		$args = array_merge( $args , $args_offset);
					}
				}
			}
			// "else" meaning, they decided to show the actual final loop,
			// presumably on sidebar in page.php or single.php
			else{
				$args_ids = array(
					'post__in' => array($post->ID)
		 		);
		 		$args = array_merge( $args , $args_ids);
			}
			
			// The Query
			$the_query = new WP_Query( $args );
			
			// RESTRICTIONS
			$stick_ids = array();
			if(!empty($restrict_to_ids)){
				// make an array if ids
				$stick_ids_clean = str_replace (" ", "", $restrict_to_ids);
				if(explode(',' ,$stick_ids_clean)){
					$stick_ids = explode(',' ,$stick_ids_clean);
				}else{
					array_push($stick_ids, $restrict_to_ids);
				}
			}
			// if there are restrictions, AND the the curent post->id is not the in the restricted array_merge
			// let it go
			if ((!empty($stick_ids)) && (!in_array($post->ID, $stick_ids))){
				return;
			}
			// disalow the widget to be seen on :
			/* how it comes
			1 Single post
			page
			2 home
			3 Front Page
			4 Archive
			5 Tag/Term list
			6 taxonomy
			7 Category list
			8 Author's list
			9 Search
			10 404 error page
			*/
			if(!empty($stick_on_template_types)){
				if(is_single() && in_array(1, $stick_on_template_types)){
					return;
				}
				if(is_page() && in_array(2, $stick_on_template_types)){
					return;
				}
				if(is_home() && in_array(3, $stick_on_template_types)){
					return;
				}
				if(is_front_page() && in_array(4, $stick_on_template_types)){
					return;
				}
				if(is_archive() && in_array(5, $stick_on_template_types)){
					return;
				}
				if(is_tag() && in_array(6, $stick_on_template_types)){
					return;
				}
				if(is_tax() && in_array(7, $stick_on_template_types)){
					return;
				}
				if(is_category() && in_array(8, $stick_on_template_types)){
					return;
				}
				if(is_author() && in_array(9, $stick_on_template_types)){
					return;
				}
				if(is_search() && in_array(10, $stick_on_template_types)){
					return;
				}
				if(is_404() && in_array(11, $stick_on_template_types)){
					return;
				}
				//var_dump($stick_on_template_types);
			}
			// Disallow for certain pages posts
			$disallow_on_ids_array = array();
			if(!empty($disallow_on_ids)){
				$disallow_on_clean = str_replace (" ", "", $disallow_on_ids);
				if(explode(',' ,$disallow_on_clean)){
					$disallow_on_ids_array = explode(',' ,$disallow_on_clean);
				}else{
					array_push($disallow_on_ids_array, $disallow_on_ids);
				}
				// if the current page has the restricted id
				// let it go
				if((is_page() || is_single()) && in_array($post->ID, $disallow_on_ids_array)){
					return;
				}
			}
			// run the LOOP
			if($the_query->have_posts()){
				echo '<div class="recent_post">'; 
				echo $before_widget;
				// if user want to see widget title
				if (!empty($the_widget_title)){
					echo '<h4>'.$the_widget_title.'</h4>';
					
				}
				// The Loop
				while ( $the_query->have_posts() ) : $the_query->the_post();
					// if user want the image here 
					if ( has_post_thumbnail() && $image_position == 0) { // check if the post has a Post Thumbnail assigned to it.
						if ($image_with_link == 'on'){
							echo '<a href="'. get_permalink() . '" title="'.get_the_title().'">';
						}
							// define thumbnail atributes
							$default_attr = array(
								'title'	=> trim(strip_tags( $the_query->post->post_title )),
							);
							if($image_size == 1){
								the_post_thumbnail('thumbnail', $default_attr);
							}
							if($image_size == 2){
									the_post_thumbnail('medium', $default_attr);
							}
							elseif($image_size == 3){
								the_post_thumbnail('large', $default_attr);
							}
						if ($image_with_link == 'on'){
							echo '</a>';
						}
					} 
					// if user want to see post title
					if($the_post_title == 'on'){
						echo '<h1>';
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
								if(is_user_logged_in()){
								edit_post_link('edit', '', ' <small class="lw_2046_pID">'.$post->ID.'</small>');
							}
						echo '</h1>';
					}
					// if user wants post thumbnail after the title
					if ( has_post_thumbnail() && $image_position == 1) { // check if the post has a Post Thumbnail assigned to it.
						if ($image_with_link == 'on'){
							echo '<a href="'. get_permalink() . '" title="'.get_the_title().'">';
						}
							// define thumbnail atributes
							$default_attr = array(
								'title'	=> trim(strip_tags( $the_query->post->post_title )),
							);
							if($image_size == 1){
								the_post_thumbnail('thumbnail', $default_attr);
							}
							if($image_size == 2){
									the_post_thumbnail('medium', $default_attr);
							}
							elseif($image_size == 3){
								the_post_thumbnail('large', $default_attr);
							}
						if ($image_with_link == 'on'){
							echo '</a>';
						}
					} 
					// if the user want the content
					if($with_excerpt == '1'){
						the_excerpt();
					}
					elseif($with_excerpt == '2'){
						the_content();
					}
					if(!empty($postmeta)){
						echo '<div class="postmeta">';
							if(in_array(1, $postmeta)){
								echo '<span class="lw2046_postmeta_author">';
								_e ('Author');
								echo ': ';
								the_author_link();
								echo '</span>';
							}
							if(in_array(2, $postmeta)){
								echo '<span class="lw2046_postmeta_Categories">';
								_e ('Categories');
								echo ': ';
								the_category(', ');
								echo '</span>';
							}
							if(in_array(3, $postmeta)){
								echo '<span class="lw2046_postmeta_tags">';
								$tags_title = __('Tags');
								the_tags($tags_title.': ',', ','<br />');
								echo '</span>';
							}
						echo '</div>';
					}
					if($comments_selector == 0){
						// show comments with the comments disabled text if disabled
						if($comments_comments_closed_info == 'on'){
						comments_template( '', true );
						}
						// show comments, when disabled do not show fucking "comments are closed" message
						else{
							if($the_query->post->comment_status == "open"){comments_template( '', true );}
						}
					}
				endwhile;

				/* After widget (defined by themes). */
				echo $after_widget;
				echo '</div>';
			} // END if have a post
		// Reset Post Data
		wp_reset_postdata();
	}

}

