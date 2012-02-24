<?php
/**
 * Plugin name: 2046's widget loops
 * Plugin URI: http://wordpress.org/extend/plugins/2046s-widget-loops/
 * Description: 2046's loop widgets boost you website prototyping.
 * Version: 0.2
 * Author: 2046
 * Author URI: http://2046.cz
 *
 */

/**
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'w2046_main_loop_load_widgets' );

/**
 * Register our widget.
 * 'wname_2046_main_loop_Widget' is the widget class used below.
 */
function w2046_main_loop_load_widgets() {
	register_widget( 'w2046_main_loop' );
}

/**
 * wname_2046_main_loop Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 */
 class w2046_main_loop extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function w2046_main_loop() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'wname_2046_main_loop', 'description' => __('It let\'s you show Post or Pages anywhere. The widget let\'s you allow or disallow the loop to be shown on certain places. Plus, you can show or hide comments and it\'s form.', 'wname_2046_main_loop') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 620, 'height' => 350, 'id_base' => 'wname_2046_main_loop-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'wname_2046_main_loop-widget', __('2046\'s - loop widget', 'wname_2046_main_loop'), $widget_ops, $control_ops );
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
			'image_position' => __(1, 'w_2046_posts'), // 0,1
			'image_size' => __(2, 'w_2046_posts'), // none, thumbnail, large
			'image_with_link' => __('', 'w_2046_posts'), // false, true
			'with_excerpt' => __(2, 'w_2046_posts'), // ids, category, from the sa
			'postmeta' => __(array(''), 'w_2046_posts'), // Date, author, categories, tags
			'comments_booble' => __('', 'w_2046_posts'), // false, true
			'comments_selector' => __('', 'w_2046_posts'), // true, false
			'comments_comments_closed_info' => __('on', 'w_2046_posts'), // true, false
			'navigation' => __('', 'w_2046_posts'), // true, false
			'location_selector' => __(true, 'w_2046_posts'), // single, id, most recent
			'restrict_to_ids' => __('', 'w_2046_posts'), // numbs
			'taxonomy' => __(array(''), 'w_2046_posts'), // numbs
			'taxonomy_comarison' => __('OR', 'w_2046_posts'), // numbs
			'against_taxonomy' => __('', 'w_2046_posts'), // names
			'posts_number' => __('', 'w_2046_posts'), // numbs
			'page_selector' => __(0, 'w_2046_pages'), // ids, category, from the same category
			'parent_page_id' => __('', 'w_2046_pages'), // num, (coma delimiter)
			//'tax_selector' => __(0, 'w_2046_posts'), // single, id, most recent
			'post_id' => __('', 'w_2046_posts'), // num singl
			'with_offset' => __('', 'w_2046_posts'), // num
			'stick_on_template_types' => __(array(''), 'w_2046_posts'), 
			'disallow_on_ids' => __('', 'w_2046_posts'), // num
			'navigation' => __('', 'w_2046_posts'), // num
			'debug' => __('', 'w_2046_posts'), // num
		);

		// get all custom "post" types
		$args_types=array(
			'public'   => true, // publicaly visible
			//'_builtin' => false, // only not built in
			//'capability_type' => 'post' // and only types of post
		); 
		
		$post_types = get_post_types($args_types,'objects'); 
		// remove attachment post type from the array .. we do not need it
		unset($post_types['attachment']);

		$instance = wp_parse_args( (array) $instance, $defaults ); 
		?>
		<div id="the_widget_id_<?php echo $this->id; ?>" class="pw_2046_lw">
			
				<h3>Post type</h3>
				<div class="pw_type_holder">
					<?php // if more then default post types exists, built select box
					//$i = 0;
					if (count($post_types) > 1){ ?>
						<p class="pw_the_post_type">
							<strong>Select post type</strong><br />
							<select name="<?php echo $this->get_field_name( 'the_post_type' ); ?>" id="the_post_type" class="the_post_type">
								<?php 
								foreach($post_types as $post_t){
									echo '<option '; if($instance['the_post_type'] == $post_t->name ){echo 'selected="selected"';} echo' value="'.$post_t->name.'" >'.$post_t->labels->singular_name.'</option>';
									
									// define generally the title of the type
									if($instance['the_post_type'] == $post_t->name ){
										$type_title = $post_t->labels->singular_name;
										$actual_type_name = $post_t->name;
										$the_type = $post_t->capability_type;
									}
									//$i++;
								} ?>
							</select>
						</p>
					<?php } ?>
				</div>
			<?php 
			// get all the avaiable taxonomies
			$all_taxonomies = get_object_taxonomies($actual_type_name,'objects');
			?>
			<div class="lw_2046_left">
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
						<input type="checkbox" name="<?php echo $this->get_field_name( 'the_post_title' ); ?>" <?php if ($instance['the_post_title'] == 'on'){ echo 'checked="checked"'; } ?> /> Show <?php echo $type_title; ?> title<br />
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
					<p class="pw_comments_booble">
						<input type="checkbox" name="<?php echo $this->get_field_name( 'comments_booble' ); ?>" <?php if ($instance['comments_booble'] == 'on'){ echo 'checked="checked"'; } ?> /> Show comments booble
					</p>
					<p class="pw_with_excerpt">
						<strong>Content</strong><br />
						<input type="radio" name="<?php echo $this->get_field_name( 'with_excerpt' ); ?>" value="0" <?php if ($instance['with_excerpt'] == 0) echo 'checked="checked"'; ?>> No content<br>
						<input type="radio" name="<?php echo $this->get_field_name( 'with_excerpt' ); ?>" value="1" <?php if ($instance['with_excerpt'] == 1) echo 'checked="checked"'; ?>> Excerpt<br>
						<input type="radio" name="<?php echo $this->get_field_name( 'with_excerpt' ); ?>" value="2" <?php if ($instance['with_excerpt'] == 2) echo 'checked="checked"'; ?>> Content<br />
					</p>
				
					<p class="pw_postmeta">
						<strong>Whether to show metadata for <?php echo $type_title; ?></strong>
						<fieldset class="stick_on_template_types" id="stick_on_template_types">
							<?php
							// create temporary list of current taxonomy types
							$tmp_all_tax = array();
							foreach ($all_taxonomies as $each_tax){
								if($each_tax->name == 'post_format'){
									continue;
								}
								array_push( $tmp_all_tax, $each_tax->name);
							}
							$template_types = array('Date', 'Author');
							//$template_types = array_merge($template_types, $tmp_all_tax);
							// render checkboxes for author, and date
							foreach ($template_types as $types){
								echo '<input';
								if(is_array($instance['postmeta'])){
									if(in_array($types,$instance['postmeta'])){
										echo ' checked="checked"';
									}
								}
								echo ' type="checkbox" name="'.$this->get_field_name( 'postmeta' ).'[]" value="'.$types.'" /> '.$types.'<br />';
							}
							// render check boxes fro taxonomies
							foreach ($tmp_all_tax as $types){
								echo '<input';
								if(is_array($instance['postmeta'])){
									if(in_array($types,$instance['postmeta'])){
										echo ' checked="checked"';
									}
								}
								$tax_name = get_taxonomy($types);
								echo ' type="checkbox" name="'.$this->get_field_name( 'postmeta' ).'[]" value="'.$types.'" /> '.$tax_name->labels->name.'<br />';
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
				<h3>Navigation</h3>
				<p class="pw_navigation">
					<select name="<?php echo $this->get_field_name( 'navigation' ); ?>" class="navigation" >
						<option value="">Without navigation</option>
						<?php echo '<option '; if($instance['navigation'] == 1){echo 'selected="selected"';} echo' value="1" >Prev-Next. Only on final page.</option>';
						echo '<option '; if($instance['navigation'] == 2){echo 'selected="selected"';} echo' value="2" >Prev-Next links</option>';
						if (function_exists('wp_pagenavi')) {
							echo '<option '; if($instance['navigation'] == 3){echo 'selected="selected"';} echo' value="3" >WP PageNavi</option>'; 
						} ?>
					</select>
					<?php if (!function_exists('wp_pagenavi')) { ?>
						<em>If the <a href="http://wordpress.org/extend/plugins/wp-pagenavi/" target="_blank">WP Page Navi</a> is installed it will be listed here too.</em>
					<?php } ?>
				</p>
			</div>
			<div class="lw_2046_right">
				<h3>Where this loop will be shown & what</h3>
				
				<p class="pw_location_selector">
					<select name="<?php echo $this->get_field_name( 'location_selector' ); ?>" class="location_selector" >
						<?php echo '<option '; if($instance['location_selector'] == 0){echo 'selected="selected"';} echo' value="0" >On final Post (Page)</option>'; ?>
						<?php echo '<option '; if($instance['location_selector'] == 1){echo 'selected="selected"';} echo' value="1" >Elsewhere</option>'; ?>
					</select>
					<p>
					<em>"On final post" make sense when the widget is on single.php / page.php.</em>
					</p>
					<p>
					<em>"Elsewhere" you have to define what <?php echo $type_title; ?> content you want to see. Good choice if you want to use it on Index page if you want to emphasize the most recent post or something like that. </em>
					</p>
				</p>
				<div class="if_elsewhere">
					<h3>Which <?php echo $type_title; ?></h3>
					<div class="pw_holder">
						<p class="pw_page_selector">
							<strong>Select the logic</strong><br />
							<select name="<?php echo $this->get_field_name( 'page_selector' ); ?>" class="page_selector" >
								<?php 
								echo '<option '; if($instance['page_selector'] == 0){echo 'selected="selected"';} echo' value="0" >Select '.$type_title.'(s) by IDs</option>';
								// if the type is hyerarchical / page type
								if($the_type == 'page'){
									echo '<option '; if($instance['page_selector'] == 1){echo 'selected="selected"';} echo' value="1" >Children pages of '.$type_title.' parent</option>';
									echo '<option '; if($instance['page_selector'] == 2){echo 'selected="selected"';} echo' value="2" >Children pages of displayed '.$type_title.'</option>';
									echo '<option '; if($instance['page_selector'] == 3){echo 'selected="selected"';} echo' value="3" >'.$type_title.'(s) from the same hierarchy level</option>';
								}
								// if there are any taxonomies
								if(!empty($all_taxonomies)){
									echo '<option '; if($instance['page_selector'] == 4){echo 'selected="selected"';} echo' value="4" >Selected taxonomy</option>';
									echo '<option '; if($instance['page_selector'] == 5){echo 'selected="selected"';} echo' value="5" >From the same taxonomy</option>'; 
								}?>
							</select>
						</p>
						<p class="pw_parent_page_id">
							<strong><?php echo $type_title; ?> parent ID</strong><br />
							<input type="text" name="<?php echo $this->get_field_name( 'parent_page_id' ); ?>" <?php if (!empty($instance['parent_page_id'])){ echo 'value="'.$instance['parent_page_id'].'"'; }else{ echo 'value=""';}; ?>/>
							<br />
							<small>ONLY one page ID !</small>
						</p>
						<p class="pw_post_id">
							<strong>Enter <?php echo $type_title; ?> ID(s)</strong><br />
							<input type="text" name="<?php echo $this->get_field_name( 'post_id' ); ?>" <?php if (!empty($instance['post_id'])){ echo 'value="'.$instance['post_id'].'"'; }else{ echo 'value=""';}; ?>/>
							<br />
							<em>Separate IDs by comma.</em>
						</p>

						<?php 
						 
						$iter = 0;
						// filter objects
						//$all_taxonomies = wp_filter_object_list($all_taxonomies, array('_builtin' => false));
						echo '<div class="pw_taxonomies">';
						foreach($all_taxonomies as $each_taxonomy){
							//var_dump($each_taxonomy);
							$each_taxonomy_label = $each_taxonomy->label;
							$each_taxonomy_name =  $each_taxonomy->name;
				
							$terms_args = array(
					
							);
							$terms = get_terms( $each_taxonomy_name, $terms_args );
					
							if(count($terms) > 0){
								echo '<p class="pw_taxonomy">';
									if($iter == 0){ echo '<h4>Select taxonomy term</h4>';}
									$iter++;
									echo '<strong>'.$each_taxonomy_label.'</strong>';
									// select id problem
									echo '<select multiple="multiple" size="5" name="'.$this->get_field_name( 'taxonomy' ).'['.$each_taxonomy_name.'][]" id="'. $this->get_field_id( 'taxonomy' ).'">';
										$i = 0;
										foreach($terms as $term){
											if($i == 0){echo '<option value="">no restrictions</option>';};
											echo '<option ';
											if(!empty($instance['taxonomy'][$each_taxonomy_name])){
												if(in_array($term->term_id, $instance['taxonomy'][$each_taxonomy_name])){echo 'selected="selected"';}
											}
											echo ' value="'.$term->term_id.'">'.$term->name.' ('.$term->count .')</option>';
											$i++;
										}
									echo '</select>
								</p>';
							}
						}
						if(count($all_taxonomies) > 1){
							echo '<p>'; ?>
								<strong>The comparison type</strong>
								<select name="<?php echo $this->get_field_name( 'taxonomy_comarison' ); ?>" class="taxonomy_comarison" >
									<?php echo '<option '; if($instance['taxonomy_comarison'] == 'OR'){echo 'selected="selected"';} echo' value="OR" >Matching one of the selected terms (OR)</option>'; ?>
									<?php echo '<option '; if($instance['taxonomy_comarison'] == 'AND'){echo 'selected="selected"';} echo' value="AND" >Is releated to all selected terms (AND)</option>'; ?>'; ?>
								</select>
							<?php 
						}
						echo '</div>';
						// 5 ?>
 						<p class="pw_against_taxonomy">
							Select against which <?php echo $type_title; ?> taxonomy you want to match the loop<br />
							<?php 
							foreach($all_taxonomies as $each_taxonomy){ 
								// remove the post_format from the list
								if($each_taxonomy->name == 'post_format'){
									continue;
								}
								echo '<input type="radio" name="'. $this->get_field_name( 'against_taxonomy' ).'" value="'.$each_taxonomy->name.'"'; if ($instance['against_taxonomy'] == $each_taxonomy->name) {echo 'checked="checked"';} echo '> '.$each_taxonomy->label; ?> <br>
							<?php } ?>
						</p>
						<p class="pw_posts_number">
							<strong>Number of posts</strong><br />
							<input type="text" name="<?php echo $this->get_field_name( 'posts_number' ); ?>" <?php if (!empty($instance['posts_number'])){ echo 'value="'.$instance['posts_number'].'"'; }else{ echo 'value=""';}; ?>/>
						</p>
						<p class="pw_with_offset">
							<strong>Offset</strong><br />
							<input type="text" name="<?php echo $this->get_field_name( 'with_offset' ); ?>" <?php if (!empty($instance['with_offset'])){ echo 'value="'.$instance['with_offset'].'"'; }else{ echo 'value=""';}; ?>/>
							<br />
							<em>The offset is counted from the most recent post (by date). </em>
						</p>

					</div>
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
								$template_types = array('Single post', 'Home', 'Front Page', 'Archive', 'Tag/Term list', 'Category list', 'Author\'s list', 'Search', '404 error page');
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
				<input type="checkbox" name="<?php echo $this->get_field_name( 'debug' ); ?>" value="1" <?php if ($instance['debug'] == 1) echo 'checked="checked"'; ?>> debug
			</div>
			<p class="lw_type_change_note">
				In order to load the appropriate settings for the selected "post type" you have to save the widget.
			</p>
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
			$instance['comments_booble'] = strip_tags( $new_instance['comments_booble'] ); // false, true
			$instance['comments_selector'] = strip_tags( $new_instance['comments_selector'] );
			$instance['comments_comments_closed_info'] = strip_tags( $new_instance['comments_comments_closed_info'] );
			$instance['navigation'] = strip_tags( $new_instance['navigation'] );
			$instance['location_selector'] = strip_tags( $new_instance['location_selector'] );
			$instance['page_selector'] = strip_tags( $new_instance['page_selector'] );
			$instance['parent_page_id'] = strip_tags( $new_instance['parent_page_id'] );
			$instance['taxonomy'] = $new_instance['taxonomy'];
			$instance['taxonomy_comarison'] = $new_instance['taxonomy_comarison'];
			$instance['against_taxonomy'] = strip_tags($new_instance['against_taxonomy']);
			$instance['post_id'] = strip_tags( $new_instance['post_id'] );
			$instance['posts_number'] = strip_tags( $new_instance['posts_number'] );
			$instance['with_offset'] = strip_tags( $new_instance['with_offset'] );
			$instance['restrict_to_ids'] = strip_tags( $new_instance['restrict_to_ids'] );
			$instance['stick_on_template_types'] = $new_instance['stick_on_template_types']; 
			$instance['disallow_on_ids'] = $new_instance['disallow_on_ids'];
			$instance['debug'] = $new_instance['debug'];  

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
		$comments_booble = $instance['comments_booble']; // false, true
		$comments_selector = $instance['comments_selector']; //
		$comments_comments_closed_info = $instance['comments_comments_closed_info']; //
		$location_selector = $instance['location_selector']; // 
		$page_selector = $instance['page_selector']; // 
		$post_id = $instance['post_id']; //
		$parent_page_id = $instance['parent_page_id']; //
		$taxonomies = $instance['taxonomy']; //
		$taxonomy_comarison = $instance['taxonomy_comarison'];
		$against_taxonomy = $instance['against_taxonomy'];
		$with_offset = $instance['with_offset']; //
		$posts_number = $instance['posts_number']; //
		$restrict_to_ids = $instance['restrict_to_ids'];
		$stick_on_template_types = $instance['stick_on_template_types']; 
		$disallow_on_ids = $instance['disallow_on_ids']; 
		$navigation = $instance['navigation'];
		$debug = $instance['debug'];  
		// reset the previous loops
		// just to be sure they wont manipulate the curent query
		wp_reset_postdata();
		//wp_reset_query();
		// get the global data of curent seen post || page
		global $post;
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		/* Display name from widget settings if one was input. */

		$args = array(
			'post_type' => $the_post_type,
			//'paged' => $paged,
		);
		// if they want to show particular ID instead the actual post || page
		// check if they selected location: "Elsewhere"
		if($location_selector == 1){
			// divide by types post | page_selector
			// for post types
			if($the_post_type == 'post'){
				// if the selected the ID
				if($page_selector == 0){
					// if they actually set the ID number
					if(!empty($post_id)){
						$post_id_clean = ereg_replace(" ", "", $post_id);
						$post_ids_array = explode(',', $post_id_clean);
						$args_ids = array(
							'post__in' => $post_ids_array
				 		);
				 		$args = array_merge( $args , $args_ids);
			 		}
			 		// if they left the input empty, show nothing :)
			 		/*else{
			 			$args_ids = array(
							'post__in' => array(0)
				 		);
				 		$args = array_merge( $args , $args_ids);
			 		}*/
				}
				// selected taxonnomy
				elseif($page_selector == 4){
					if(!empty($taxonomies)){
						// define the basic arguments, the relation
						$args_taxonomies = array(
							'tax_query' => array(
								'relation' => $taxonomy_comarison
								)
							);
						// for each taxonomy, like categories tags, etc.
						// add the array to the tax_query : for taxonomy by its ID show post under term IDS
						foreach($taxonomies as $taxonomy => $value){
							// if there are any terms under the taxonomy selected
							if(!empty($value[0])){
								$args_taxonomies_tax_query = array(
									'taxonomy' => $taxonomy, // get & set the tax name (key)
									'field' => 'id',
									'terms' => $value // add the term ID array (val)
								);
								// add to arrays to tax query a < b
								array_push( $args_taxonomies['tax_query'], $args_taxonomies_tax_query);
							}
						}
						// merge tax query with the main array
						$args = array_merge( $args, $args_taxonomies);
					}
				}
				// From the same taxonomy as the current page
				elseif($page_selector == 5){
					if(!empty($against_taxonomy)){
						$current_terms  = wp_get_post_terms( $post->ID, $against_taxonomy, array("fields" => "ids"));
						$args_taxonomies_against = array(
						'tax_query' => array(
								//'relation' => 'AND',
								array(
									'taxonomy' => $against_taxonomy,
									'field' => 'id',
									'terms' => $current_terms//array( '25')
								)
							)
						);
						// add to arrays to query
						$args = array_merge( $args, $args_taxonomies_against);
					}
				}else{
					// they decided to offset the page
					if(!empty($with_offset)){
						$args_offset = array(
							'offset' => $with_offset
				 		);
				 		$args = array_merge( $args , $args_offset);
					}
					// number posts defined
					if(!empty($posts_number)){
						$args_number = array(
							'posts_per_page' => $posts_number
				 		);
				 		$args = array_merge( $args , $args_number);
					}
				}
			}
			// for page types
			else{
				// 0 Select Page(s) by IDs
				if($page_selector == 0){
					$args_ids = array(
						'post__in' => $post_id,
			 		);
			 		$args = array_merge( $args , $args_ids);
			 		echo 'page-s by id';
		 		}
				// 1 Children pages of Page parent
				elseif($page_selector == 1){
					$args_parent_id = array(
						'post_parent' => $parent_page_id,
						'posts_per_page' => $posts_number,
			 		);
			 		$args = array_merge( $args , $args_parent_id);
				}
				// 2 Children pages of displayed Page
				elseif($page_selector == 2){
					$args_parent_id = array(
						'post_parent' => $post->ID,
						'posts_per_page' => $posts_number,
						'order' => 'ASC',
						'orderby' => 'menu_order'
			 		);
			 		$args = array_merge( $args , $args_parent_id);
				}
				// 3 Page(s) from the same hierarchy level
				elseif($page_selector == 3){
					if($post->post_parent != 0){
						$args_parent = array(
							'post_parent' => $post->post_parent,
							'posts_per_page' => $posts_number,
							'order' => 'ASC',
							'orderby' => 'menu_order'
				 		);
				 		$args = array_merge( $args , $args_parent);
			 		}else{
			 			return;
			 		}
				}
				// selected taxonnomy
				elseif($page_selector == 4){
					if(!empty($taxonomies)){
						// define the basic arguments, the relation
						$args_taxonomies = array(
							'tax_query' => array(
								'relation' => $taxonomy_comarison
								)
							);
						// for each taxonomy, like categories tags, etc.
						// add the array to the tax_query : for taxonomy by its ID show post under term IDS
						foreach($taxonomies as $taxonomy => $value){
							// if there are any terms under the taxonomy selected
							if(!empty($value[0])){
								$args_taxonomies_tax_query = array(
									'taxonomy' => $taxonomy, // get & set the tax name (key)
									'field' => 'id',
									'terms' => $value // add the term ID array (val)
								);
								// add to arrays to tax query a < b
								array_push( $args_taxonomies['tax_query'], $args_taxonomies_tax_query);
							}
						}
						// merge tax query with the main array
						$args = array_merge( $args, $args_taxonomies);
					}
				}
				// 5   From the same taxonomy as the curently seen post.page
				elseif($page_selector == 5){
					if(!empty($against_taxonomy)){
						$current_terms  = wp_get_post_terms( $post->ID, $against_taxonomy, array("fields" => "ids"));
						$args_taxonomies_against = array(
						'tax_query' => array(
								//'relation' => 'AND',
								array(
									'taxonomy' => $against_taxonomy,
									'field' => 'id',
									'terms' => $current_terms//array( '25')
								)
							)
						);
						// add to arrays to query
						$args = array_merge( $args, $args_taxonomies_against);
					}
				}
			}
		}
		// "else" meaning, they decided to show the actual final loop,
		// presumably on sidebar in page.php or single.php
		else{
			$args_ids = array(
				'post__in' => array($post->ID),
				'posts_per_page' => 1
	 		);
	 		$args = array_merge( $args , $args_ids);
		}
	
	if($debug == 1){
		echo '<p class="lw_2046_debug"><strong>Debug (query args)</strong><br><pre>';
			var_dump($args);
		echo '</pre></p>';
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
			if(is_home() && in_array(2, $stick_on_template_types)){
				return;
			}
			if(is_front_page() && in_array(3, $stick_on_template_types)){
				return;
			}
			if(is_archive() && in_array(4, $stick_on_template_types)){
				return;
			}
			if(is_tag() && in_array(5, $stick_on_template_types)){
				return;
			}
			if(is_tax() && in_array(6, $stick_on_template_types)){
				return;
			}
			if(is_category() && in_array(7, $stick_on_template_types)){
				return;
			}
			if(is_author() && in_array(8, $stick_on_template_types)){
				return;
			}
			if(is_search() && in_array(9, $stick_on_template_types)){
				return;
			}
			if(is_404() && in_array(10, $stick_on_template_types)){
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
			echo $before_widget;
			// if user want to see widget title
			if (!empty($the_widget_title)){
				echo '<h4>'.$the_widget_title.'</h4>';
				
			}
			// The Loop
			while ( $the_query->have_posts() ) : $the_query->the_post();
				echo '<div ';
				post_class();
				echo '>';
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
								if(is_user_logged_in()){
								edit_post_link('edit', '', ' <small class="lw_2046_pID">'.$post->ID.'</small>');
							}
						echo '</h2>';
					}
					if($comments_booble == 'on'){
						echo '<span class="wl2046_comment_number">';
							comments_number( ':)	', '1', '%' );
							if(comments_open() == false){
								echo ' &#10013;'; //&#9873;
							}
						echo '</span>';
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
							if(in_array('Date', $postmeta)){
								echo '<span class="lw2046_postmeta_date">';
								_e ('Posted on');
								echo ': '. get_the_date().'</span>';
							}
							if(in_array('Author', $postmeta)){
								echo '<span class="lw2046_postmeta_author">';
								_e ('Author');
								echo ': ';
								the_author_link();
								echo '</span>';
							}
							// work on taxonomies
							foreach($postmeta as $meta){
								// pass the Data and author
								if ($meta == 'Date' || $meta == 'Author'){
									continue;
								}
								$args=array(
									'name' => $meta
								);
								$output = 'objects'; // or objects
								$tax = get_taxonomy($meta);//get_taxonomies($args,$output);
								// get terms
								$taxo_terms = get_the_term_list( $the_query->post->ID, $meta, '', ', ', '' ); 
								// write label
								if(!empty($taxo_terms)){
									// print label
									echo $tax->labels->name . ': ';
									// print terms
									echo $taxo_terms;
								}
							}
						echo '</div>';
					}
					// Create navigation // on final pages
					if(($navigation == 1) && (is_page() || is_single())){
						echo '<div class="navigation">';
							previous_post_link('<div class="nav-previous">%link</div>');
							next_post_link('<div class="nav-next">%link</div>'); 
						echo '</div>';
					}
					// comments
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
				echo '</div>';
			endwhile;
			// Create navigation
			if($navigation == 2){
				echo '<div class="navigation">';
					previous_posts_link('&#171; Previous');
					next_posts_link('Next &#187;');
					//posts_nav_link(' &#183; ', 'previous page', 'next page');
				echo '</div>';
			}
			// show the scribus page navi (if installed)
			if ($navigation == 3 && function_exists('wp_pagenavi')) { 
				wp_pagenavi( array( 'query' => $the_query ) );
			}
			/* After widget (defined by themes). */
			echo $after_widget;
		} // END if have a post
	// Reset Post Data
	wp_reset_postdata();
	}

}

// add WP featured image support
if ( function_exists( 'add_theme_support' ) ) { 
	add_theme_support( 'post-thumbnails' ); 
}

// add js and css to the widget admin page
add_action( 'admin_print_scripts-widgets.php', 'f2046_lw_insert_custom_js', 11 );
function f2046_lw_insert_custom_js() {
	wp_register_script('lw_2046_widget_ui',plugins_url( 'js/lw_2046_widget_ui.js' , __FILE__ ));
	wp_enqueue_script('lw_2046_widget_ui');
}

add_action('admin_print_styles-widgets.php', 'f2046_lw_insert_custom_css');
function f2046_lw_insert_custom_css(){
	wp_register_style('style_lw_2046', plugins_url( 'css/style_lw_2046.css' , __FILE__ ),false,0.1,'all');
	wp_enqueue_style( 'style_lw_2046');
}
