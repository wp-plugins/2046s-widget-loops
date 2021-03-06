<?php
/**
 * Plugin name: 2046's widget loops
 * Plugin URI: http://wordpress.org/extend/plugins/2046s-widget-loops/
 * Description: 2046's loop widgets boost you website prototyping.
 * Version: 1.0
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
	// localization
	load_plugin_textdomain( 'p_2046s_loop_widget', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/'); 
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
		$widget_ops = array( 
			'classname' => 'wname_2046_main_loop',
			'description' => __('It let\'s you show Post or Pages anywhere. The widget let\'s you allow or disallow the loop to be shown on certain places. Plus, you can show or hide comments and it\'s form.','p_2046s_loop_widget') 
		);	

		/* Widget control settings. */
		$control_ops = array( 
			'width' => 620,
			'height' => 350,
			'id_base' => 'wname_2046_main_loop-widget' 
		);

		/* Create the widget. */
		$this->WP_Widget( 'wname_2046_main_loop-widget', __('2046\'s - loop widget', 'p_2046s_loop_widget'), $widget_ops, $control_ops );
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) { 
		
		/* Set up some default widget settings. */
		$defaults = array(
			'the_post_type' => 'post', // false, true
			'the_widget_title' => '', // false, true
			'the_widget_user_title' => '', // false, true
			'the_widget_user_note' => '', // false, true
			'edit_link' => 'on', // false, true
			'html_heading' => 'h2', // h1, h2, ...
			'the_post_title' => 'on', // false, true
			'the_post_title_link' => 'on', // false, true
			'image_position' => 1, // 0,1
			'image_size' => 2, // none, thumbnail, large
			'image_with_link' => 0, // false, true
			'with_excerpt' => 2, // ids, category, from the sa
			'postmeta' => array(''), // Date, author, categories, tags
			'comments_booble' => '', // false, true
			'comments_selector' =>1, // true, false
			'comments_comments_closed_info' => 'on', // true, false
			'navigation' => '', // true, false
			'scafolding_selector' => 0, //
			'scafolding_row' => '', // 
			'scafolding_column' => '', // 
			'location_selector' => true, // single, id, most recent
			'restrict_to_ids' => '', // numbs
			'restrict_to_ids_with_childs' => 0,
			'taxonomy' => array(''), // numbs
			'taxonomy_comparison' => 'OR', // numbs
			'order_by' => 'date', 
			'the_order' => 'DESC', 
			'meta_key_sort' => '',
			//'meta_compare' => __('', 'p_2046s_loop_widget'), // not needed - we use the tax_query
			'compare' => '=',
			'meta_key' => '',
			'meta_value' => '',  
			'against_taxonomy' => '', // names
			'posts_number' => '', // numbs
			'page_selector' => 0, // ids, category, from the same category
			'parent_page_id' => '', // num, (coma delimiter)
			//'tax_selector' => __(0, 'p_2046s_loop_widget'), // single, id, most recent
			'post_id' => '', // num singl
			'with_offset' => '', // num
			'stick_on_template_types' => array(''), 
			'disallow_on_ids' => '', // num
			'navigation' => '', // num
			'paging' => true, // true, false
			'permissions' => '-1', //all-  anyone,  level_0 - subcriber, level_1 - contributor , level_2 Author, level_7 editor, level_10 administrator
			'debug' => '', // num
		);

		// get all custom "post" types
		$args_types=array(
			'public'	=> true, // publicaly visible
			//'_builtin' => false, // only not built in
			//'capability_type' => 'post' // and only types of post
		); 
		
		$post_types = get_post_types($args_types,'objects'); 
		// remove attachment post type from the array .. we do not need it
		unset($post_types['attachment']);

		$instance = wp_parse_args( (array) $instance, $defaults ); 
		
		echo '<div id="the_widget_id_'.$this->id.'" class="pw_2046_lw">';
				// permissions
				$capabilities = array( 'all' => __('Anyone') , 'level_0' => __('Subcriber'), 'level_1' => __('Contributor') , 'level_4' => __('Author'), 'level_7' => __('Editor'), 'level_10' => __('Administrator'));
				echo '
				<h3>'. __('Widget user info', 'p_2046s_loop_widget').'</h3>
				<div class="pw_holder">
					<div class="widget_user_title_holder">
						<strong>'.__('Widget admin title','p_2046s_loop_widget').'</strong><br />
						<input id="in-widget-title"  type="text" name="'. $this->get_field_name( 'the_widget_user_title' ).'" value="'. $instance['the_widget_user_title'] .'"/>
						<br />
						<em>'.__('It helps you distiguish widgets. Used only in this admin area.', 'p_2046s_loop_widget').'</em>
					</div>
					<div class="the_widget_user_note_holder">
						<strong>'.__('Widget note','p_2046s_loop_widget').'</strong><br />
						<textarea style="width:99%" placeholder="'.__('Describe the widget intention here', 'p_2046s_loop_widget').'" name="'. $this->get_field_name( 'the_widget_user_note' ).'">'.$instance['the_widget_user_note'].'</textarea>
						<br />
						<em>'.__('This note is used only in this admin area.', 'p_2046s_loop_widget').'</em>
					</div>
				</div>
				<h3>'. __('Permissions, Post types', 'p_2046s_loop_widget').'</h3>
				<div class="pw_holder">
					<div class="pw_permissions_holder">
						<p class="pw_the_post_type">
							<strong>'.__('Who can see the result','p_2046s_loop_widget').'</strong><br />
							<select name="'. $this->get_field_name( 'permissions' ) .'" id="permissions" class="permissions">';
								foreach($capabilities as $user => $value){
									echo '<option '; if($instance['permissions'] == $user ){echo 'selected="selected"';} echo' value="'.$user.'" >'.$value.'</option>';
								} 
							echo '</select>
						</p>
					</div>';
					echo '<h3>'.__('Post type','p_2046s_loop_widget').'</h3>
					<div class="pw_type_holder">';
						// if more then default post types exists, built select box
						//$i = 0;
						if (count($post_types) > 1){
							// post type
							echo '<p class="pw_the_post_type">
								<strong>'.__('Select post type','p_2046s_loop_widget').'</strong><br />
								<select name="'. $this->get_field_name( 'the_post_type' ) .'" id="the_post_type" class="the_post_type">';
									foreach($post_types as $post_t){
										echo '<option '; if($instance['the_post_type'] == $post_t->name ){echo 'selected="selected"';} echo' value="'.$post_t->name.'" >'.$post_t->labels->singular_name.'</option>';
									
										// define generally the title of the type
										if($instance['the_post_type'] == $post_t->name ){
											$type_title = $post_t->labels->singular_name;
											$actual_type_name = $post_t->name;
											$the_type = $post_t->capability_type;
										}
										//$i++;
									} 
								echo '</select>
							</p>';
						}
					echo '</div>
				</div>';
			// get all the avaiable taxonomies
			$all_taxonomies = get_object_taxonomies($actual_type_name,'objects');
			echo '<div class="lw_2046_left">
				<h3>'. __('Widget title', 'p_2046s_loop_widget').'</h3>
				<div class="pw_holder">
					<p class="pw_the_title">
						<input type="text" name="'. $this->get_field_name( 'the_widget_title' ).'" value="'. $instance['the_widget_title'] .'"/>
						<br />
						<em>'.__('if empty: no title, no html, nothing', 'p_2046s_loop_widget').'</em>
					</p>
				</div>
				<h3>'.__('Content','p_2046s_loop_widget').'</h3>
				<div class="pw_holder">
					<p class="pw_title_settings">
						<strong>'.__('Title', 'p_2046s_loop_widget').'</strong><br />
						<input type="checkbox" name="'. $this->get_field_name( 'the_post_title' ).'"'; if ($instance['the_post_title'] == 'on'){ echo 'checked="checked"'; } echo '/>'.__('Show title','p_2046s_loop_widget').
						' <input type="checkbox" name="'. $this->get_field_name( 'the_post_title_link' ).'"'; if ($instance['the_post_title_link'] == 'on'){ echo 'checked="checked"'; } echo '/>'.__('as a link', 'p_2046s_loop_widget').
						' <input type="checkbox" name="'. $this->get_field_name( 'edit_link' ).'"'; if ($instance['edit_link'] == 'on'){ echo 'checked="checked"'; } echo '/>'.__('Show edit link', 'p_2046s_loop_widget');
						$heading_array = array('h1','h2','h3','h4','h5', 'span');
						echo '<select name="'. $this->get_field_name( 'html_heading' ).'" class="navigation">';
							foreach($heading_array as $h){
								echo '<option '; if($instance['html_heading'] == $h){echo 'selected="selected"';} echo' value="'.$h.'" >'.$h.'</option>';
							}
						echo '</select>
					</p>
					<p class="pw_image_size">
						<strong>Image</strong>
						<select name="'. $this->get_field_name( 'image_size' ).'" class="image_size">
							<option name="'. $this->get_field_name( 'image_size' ).'" value="0"'; if ($instance['image_size'] == 0) echo ' selected="selected"'; echo '> '.__('No picture','p_2046s_loop_widget').'</option>
							<option name="'. $this->get_field_name( 'image_size' ).'" value="1"'; if ($instance['image_size'] == 1) echo ' selected="selected"'; echo '> '.__('Thumbnail','p_2046s_loop_widget').'</option>
							<option name="'. $this->get_field_name( 'image_size' ).'" value="2"'; if ($instance['image_size'] == 2) echo ' selected="selected"'; echo '> '.__('Medium','p_2046s_loop_widget').'</option>
							<option name="'. $this->get_field_name( 'image_size' ).'" value="3"'; if ($instance['image_size'] == 3) echo ' selected="selected"'; echo '> '.__('Large','p_2046s_loop_widget').'</option>
						</select>
					</p>
					<p class="image_settings">
						<strong class="image_position_title">'.__('Image position', 'p_2046s_loop_widget').'</strong><br />
						<select name="'. $this->get_field_name( 'image_position' ).'" class="image_position">
							<option name="'. $this->get_field_name( 'image_position' ) .'" value="0" '; if ($instance['image_position'] == 0) {echo 'selected="selected"';} echo '> '.__('Image above the title','p_2046s_loop_widget').'</option>
							<option name="'. $this->get_field_name( 'image_position' ) .'" value="1" '; if ($instance['image_position'] == 1) {echo 'selected="selected"';} echo '> '.__('Image below the title','p_2046s_loop_widget').'</option>
						</select>
						<strong>'.__('Image linking', 'p_2046s_loop_widget').'</strong><br />
						<select name="'. $this->get_field_name( 'image_with_link' ).'" class="image_with_link">
							<option name="'. $this->get_field_name( 'image_with_link' ).'" value="0" '; if ($instance['image_with_link'] == '0'){ echo 'selected="selected" '; } echo '> '.__('Image without link','p_2046s_loop_widget').'</option>
							<option name="'. $this->get_field_name( 'image_with_link' ).'" value="1" '; if ($instance['image_with_link'] == '1'){ echo 'selected="selected" '; } echo '> '.__('Image as a link to the','p_2046s_loop_widget').' "'. $type_title.'"</option>
							<option name="'. $this->get_field_name( 'image_with_link' ).'" value="2" '; if ($instance['image_with_link'] == '2'){ echo 'selected="selected" '; } echo '> '.__('Image as a link to it\'s "large" version','p_2046s_loop_widget').'</option>
						</select>
					</p>
					<p class="pw_comments_booble">
						<input type="checkbox" name="'. $this->get_field_name( 'comments_booble' ).'" '; if ($instance['comments_booble'] == 'on'){ echo 'checked="checked"'; } echo'/> '.__('Show comments booble','p_2046s_loop_widget').'
					</p>
					<p class="pw_with_excerpt">
						<strong>'.__('Content','p_2046s_loop_widget').'</strong><br />
						<input type="radio" name="'. $this->get_field_name( 'with_excerpt' ).'" value="0" '; if ($instance['with_excerpt'] == 0) echo 'checked="checked"'; echo '> '.__('No content','p_2046s_loop_widget').'<br>
						<input type="radio" name="'. $this->get_field_name( 'with_excerpt' ).'" value="1" '; if ($instance['with_excerpt'] == 1) echo 'checked="checked"'; echo '> '.__('Excerpt','p_2046s_loop_widget').'<br>
						<input type="radio" name="'. $this->get_field_name( 'with_excerpt' ).'" value="2" '; if ($instance['with_excerpt'] == 2) echo 'checked="checked"'; echo '> '.__('Content','p_2046s_loop_widget').'<br />
					</p>
				
					<p class="pw_postmeta">
						<strong>'.__('Whether to show metadata for','p_2046s_loop_widget').' '. $type_title.'</strong>
						<fieldset class="stick_on_template_types">';
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
							// render check boxes for taxonomies
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
							
						echo '</fieldset>
					</p>
					<strong class="show_comments_title">'.__('Show comments','p_2046s_loop_widget').'</strong>
					<p class="pw_comments_selector">
						<select name="'. $this->get_field_name( 'comments_selector' ).'" class="comments_selector" >
							<option '; if($instance['comments_selector'] == 0){echo 'selected="selected"';} echo ' value="0" >'.__('Show','p_2046s_loop_widget').'</option>
							<option '; if($instance['comments_selector'] == 1){echo 'selected="selected"';} echo ' value="1" >'.__('Hide','p_2046s_loop_widget').'</option>
						</select>
					</p>
					<p class="pw_comments_comments_closed_info">
						<input type="checkbox" name="'. $this->get_field_name( 'comments_comments_closed_info' ).'"'; if ($instance['comments_comments_closed_info'] == 'on'){ echo 'checked="checked"'; } echo' /> '.__('Show warning text if comments are closed','p_2046s_loop_widget').'
						<br />
						<em>'.__('Note: Comments will be shown on final post or page only!','p_2046s_loop_widget').'</em>
					</p>
				</div>
				<h3 class="navigation_title">'.__('Navigation','p_2046s_loop_widget').'</h3>
				<p class="pw_navigation">
					<select name="'. $this->get_field_name( 'navigation' ).'" class="navigation" >
						<option value="">'.__('Without navigation','p_2046s_loop_widget').'</option>
						<option '; if($instance['navigation'] == 1){echo 'selected="selected"';} echo' value="1" >'.__('Prev-Next. Only on final page','p_2046s_loop_widget').'</option>
						<option '; if($instance['navigation'] == 2){echo 'selected="selected"';} echo' value="2" >'.__('Prev-Next links','p_2046s_loop_widget').'</option>';
						if (function_exists('wp_pagenavi')) {
							echo '<option '; if($instance['navigation'] == 3){echo 'selected="selected"';} echo' value="3">WP PageNavi</option>'; 
						}
						echo '<option '; if($instance['navigation'] == 4){echo 'selected="selected"';} echo' value="4" >'.__('Link to category list','p_2046s_loop_widget').'</option>';
					echo '</select>';
					if (!function_exists('wp_pagenavi')) {
						echo '<em>'.__('If the <a href="http://wordpress.org/extend/plugins/wp-pagenavi/" target="_blank">WP Page Navi</a> is installed it will be listed here too.','p_2046s_loop_widget').'</em>';
					} 
					echo '<p class="pw_paging">
						<input type="checkbox" name="'. $this->get_field_name( 'paging' ).'"'; if ($instance['paging'] == true){ echo 'checked="checked"'; } echo' /> '.__('Allow to the pagination','p_2046s_loop_widget').'
						<br />
						<em>'.__('Note: If you want to see only the content you filter here, not affected by WP inner pagination, uncheck it here.','p_2046s_loop_widget').'</em>
					</p>';
				echo '</p>
				<h3>'.__('Scafolding','p_2046s_loop_widget').'</h3>
				<div class="pw_holder">
					<strong>'.__('type of structure','p_2046s_loop_widget').'</strong>
					<p class="pw_scafolding_selector">
						<select name="'. $this->get_field_name( 'scafolding_selector' ).'" class="scafolding_selector" >
							<option '; if($instance['scafolding_selector'] == 0){echo 'selected="selected"';} echo' value="0">'.__('Basic Wordpress classes','p_2046s_loop_widget').'</option>
							<option '; if($instance['scafolding_selector'] == 1){echo 'selected="selected"';} echo' value="1">'.__('One column per row','p_2046s_loop_widget').'</option>
							<option '; if($instance['scafolding_selector'] == 2){echo 'selected="selected"';} echo' value="2">'.__('Many Columns per row','p_2046s_loop_widget').'</option>
						</select>
						<em>'.__('Custom classes are added to the basic Wordress classes','p_2046s_loop_widget').'</em>
					</p>
					<p class="pw_scafolding_row">
						<strong>'.__('Row div class','p_2046s_loop_widget').'</strong><br />
						<input type="text" name="'. $this->get_field_name( 'scafolding_row' ).'" value="'. $instance['scafolding_row'] .'"/>
						<em>'.__('In Boostrap it will be "row"','p_2046s_loop_widget').'</em>
					</p>
					<p class="pw_scafolding_column">
						<strong>'.__('Column div class','p_2046s_loop_widget').'</strong><br />
						<input type="text" name="'. $this->get_field_name( 'scafolding_column' ).'" value="'. $instance['scafolding_column'] .'"/>
						<em>'.__('In Boostrap it can be "span3"','p_2046s_loop_widget').'</em>	
					</p>
					<em>'.__('Note: see ','p_2046s_loop_widget').'<a href="http://twitter.github.com/bootstrap/scaffolding.html" target="_blank">Boostrap</a></em>
				</div>
			</div>
			<div class="lw_2046_right">
				<h3>'.__('Where this loop will be shown & what','p_2046s_loop_widget').'</h3>
				
				<p class="pw_location_selector">
					<select name="'. $this->get_field_name( 'location_selector' ).'" class="location_selector">
						<option '; if($instance['location_selector'] == 0){echo 'selected="selected"';} echo' value="0">'.__('On final Post (Page)','p_2046s_loop_widget').'</option>
						<option '; if($instance['location_selector'] == 2){echo 'selected="selected"';} echo' value="2">'.__('Gallery (Images of post/page)','p_2046s_loop_widget').'</option>
						<option '; if($instance['location_selector'] == 1){echo 'selected="selected"';} echo' value="1">'.__('Elsewhere','p_2046s_loop_widget').'</option>
					</select>
					<p>
					<em>'.__('"On final post" make sense when the widget is on single.php / page.php.','p_2046s_loop_widget').'</em>
					</p>
					<p>
					<em>'.__('"Images of final post/page (gallery)": The content settings are applied to the gallery images.').'</em>
					</p>
					<p>
					<em>'.__('"Elsewhere": you decide which','p_2046s_loop_widget').' "'. $type_title.'" '.__('content you want to see, how and where.','p_2046s_loop_widget').'</em>
					</p>
				</p>
				<div class="if_elsewhere">
					<h3 class="which_part">'.__('Which','p_2046s_loop_widget').' '. $type_title.'</h3>
					<div class="pw_holder">
						<p class="pw_page_selector">
							<strong>'.__('Select the logic','p_2046s_loop_widget').'</strong><br />
							<select name="'. $this->get_field_name( 'page_selector' ).'" class="page_selector">';
								echo '<option '; if($instance['page_selector'] == 0){echo 'selected="selected"';} echo' value="0" >'.__('Select','p_2046s_loop_widget').' '.$type_title.'(s) by IDs</option>';
								// if the type is hyerarchical / page type
								if($the_type == 'page'){
									echo '<option '; if($instance['page_selector'] == 1){echo 'selected="selected"';} echo' value="1">'.__('Children pages of','p_2046s_loop_widget').' '.$type_title.' '.__('parent','p_2046s_loop_widget').'</option>
									<option '; if($instance['page_selector'] == 2){echo 'selected="selected"';} echo' value="2">'.__('Children pages of displayed','p_2046s_loop_widget').' '.$type_title.'</option>
									<option '; if($instance['page_selector'] == 3){echo 'selected="selected"';} echo' value="3">'.$type_title.' '.__('(s) from the same hierarchy level','p_2046s_loop_widget').'</option>';
								}
								// if there are any taxonomies
								if(!empty($all_taxonomies)){
									echo '<option '; if($instance['page_selector'] == 4){echo 'selected="selected"';} echo' value="4">'.__('Selected taxonomy','p_2046s_loop_widget').'</option>
									<option '; if($instance['page_selector'] == 5){echo 'selected="selected"';} echo' value="5">'.__('From the same taxonomy','p_2046s_loop_widget').'</option>'; 
								}
									echo '<option '; if($instance['page_selector'] == 6){echo 'selected="selected"';} echo' value="6">'.__('By the custom meta values','p_2046s_loop_widget').'</option>
							</select>
							<em>'.__('Help your self as you like.. empty values simply do not make restrictions.','p_2046s_loop_widget').'</em>
						</p>
						<p class="pw_parent_page_id">
							<strong>'. $type_title.' '.__('parent ID','p_2046s_loop_widget').'</strong><br />
							<input type="text" name="'. $this->get_field_name( 'parent_page_id' ).'" ';if (!empty($instance['parent_page_id'])){ echo 'value="'.$instance['parent_page_id'].'"'; }else{ echo 'value=""';} echo '/>
							<br />
							<small>'.__('ONLY one page ID !','p_2046s_loop_widget').'</small>
						</p>
						<p class="pw_post_id">
							<strong>'.__('Enter','p_2046s_loop_widget').' '. $type_title.' ID(s)</strong><br />
							<input type="text" name="'. $this->get_field_name( 'post_id' ).'" '; if (!empty($instance['post_id'])){ echo 'value="'.$instance['post_id'].'"'; }else{ echo 'value=""';} echo'/>
							<br />
							<em>'.__('Separate IDs by comma.','p_2046s_loop_widget').'<br />
							'.__('In the case of gallery, only first ID will be used. If empty the ID of visited post/page is used.','p_2046s_loop_widget').'</em>
						</p>';
						$iter = 0;
						// filter objects
						//$all_taxonomies = wp_filter_object_list($all_taxonomies, array('_builtin' => false));
						echo '<div class="pw_taxonomies">';
						foreach($all_taxonomies as $each_taxonomy){
							$each_taxonomy_label = $each_taxonomy->label;
							$each_taxonomy_name =  $each_taxonomy->name;
				
							$terms_args = array(
					
							);
							$terms = get_terms( $each_taxonomy_name, $terms_args );
					
							if(count($terms) > 0){
								echo '<p class="pw_taxonomy">';
									if($iter == 0){ echo '<h4>'.__('Select taxonomy term','p_2046s_loop_widget').'</h4>';}
									$iter++;
									echo '<strong>'.$each_taxonomy_label.'</strong>';
									// select id problem
									echo '<select multiple="multiple" size="5" name="'.$this->get_field_name( 'taxonomy' ).'['.$each_taxonomy_name.'][]" id="'. $this->get_field_id( 'taxonomy' ).'" class="lw_multiple_select" title="'.__('Please select a','p_2046s_loop_widget').' '.$each_taxonomy_label.'">';
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
								</p>
								<em>'.__('Warning! The number for each term counted for all post/page/cutom post types all together.','p_2046s_loop_widget').'</em>
								<br /><br />
								<em>'.__('Note! If you see the taxonomy selector multiplied, don not panic. These are just virtual copies, a bug.','p_2046s_loop_widget').'</em>
								<br /><br />
								';
							}
						}
						if(count($all_taxonomies) > 1){
							echo '
								<strong>'.__('The comparison type','p_2046s_loop_widget').'</strong>
								<select name="'. $this->get_field_name( 'taxonomy_comparison' ).'" class="taxonomy_comparison">
									<option '; if($instance['taxonomy_comparison'] == 'OR'){echo 'selected="selected"';} echo' value="OR">'.__('Matching one of the selected terms','p_2046s_loop_widget').' (OR)</option>
									<option '; if($instance['taxonomy_comparison'] == 'AND'){echo 'selected="selected"';} echo' value="AND">'.__('Is releated to all selected terms','p_2046s_loop_widget').' (AND)</option>
								</select>';
						}
						echo '</div>';
						// 5 
 						echo '<p class="pw_against_taxonomy">
							'.__('Select against which','p_2046s_loop_widget').' '. $type_title.' '.__('taxonomy you want to match the loop','p_2046s_loop_widget').'<br />';
							foreach($all_taxonomies as $each_taxonomy){ 
								// remove the post_format from the list
								if($each_taxonomy->name == 'post_format'){
									continue;
								}
								echo '<input type="radio" name="'. $this->get_field_name( 'against_taxonomy' ).'" value="'.$each_taxonomy->name.'"'; if ($instance['against_taxonomy'] == $each_taxonomy->name) {echo 'checked="checked"';} echo '> '.$each_taxonomy->label.' <br>';
							}
						echo '</p>
						<p class="pw_posts_number">
							<strong>'.__('Number of posts','p_2046s_loop_widget').'</strong><br />
							<input type="text" name="'. $this->get_field_name( 'posts_number' ).'" '; if (!empty($instance['posts_number'])){ echo 'value="'.$instance['posts_number'].'"'; }else{ echo 'value=""';} echo'/>
						</p>
						<p class="pw_with_offset">
							<strong>'.__('Offset','p_2046s_loop_widget').'</strong><br />
							<input type="text" name="'. $this->get_field_name( 'with_offset' ).'" '; if (!empty($instance['with_offset'])){ echo 'value="'.$instance['with_offset'].'"'; }else{ echo 'value=""';} echo '/>
							<br />
						</p>
						<p class="pw_meta_sort">
							<strong>'.__('Meta key','p_2046s_loop_widget').'</strong><br />
							<input type="text" name="'. $this->get_field_name( 'meta_key' ).'" '; if (!empty($instance['meta_key'])){ echo 'value="'.$instance['meta_key'].'"'; }else{ echo 'value=""';} echo '/>
							<br /><em>'.__('The exact "meta key" name. Both key and value must be present!','p_2046s_loop_widget').'</em>
							<br /><br />
							<strong>'.__('Meta value','p_2046s_loop_widget').'</strong><br />
							<input type="text" name="'. $this->get_field_name( 'meta_value' ).'" '; if (!empty($instance['meta_value'])){ echo 'value="'.$instance['meta_value'].'"'; }else{ echo 'value=""';} echo '/>
							<br /><em>'.__('The exact "meta value" name. Both key and meta must be present!','p_2046s_loop_widget').'</em>
							<br /><br />
							'.__('Meta comparison','p_2046s_loop_widget').'<br />
							<select name="'. $this->get_field_name( 'compare' ).'" class="compare">';
								$comp_types = array(  '=', '!=', '>', '>=', '<', '<=', 'LIKE', 'NOT LIKE', 'IN', 'NOT IN' ); // 'BETWEEN', 'NOT BETWEEN'
								foreach($comp_types as $types){
									echo '<option '; if($instance['compare'] == $types){echo 'selected="selected"';} echo' value="'.$types.'" >'.$types.'</option>';
								} 
							echo '</select>
						</p>
					</div>
					<h3>'.__('Order','p_2046s_loop_widget').'</h3>
					<div class="pw_holder">
						<p class="pw_the_order">
							<strong>'.__('Order','p_2046s_loop_widget').'</strong>
							<select name="'. $this->get_field_name( 'the_order' ).'" class="the_order">
								<option '; if($instance['the_order'] == 'ASC'){echo 'selected="selected"';} echo' value="ASC">'.__('Ascendingly','p_2046s_loop_widget').'</option>
								<option '; if($instance['the_order'] == 'DESC'){echo 'selected="selected"';} echo' value="DESC">'.__('Descendingly','p_2046s_loop_widget').'</option>
							</select>
						</p>
						<p class="pw_order_by">
							<strong>'.__('Order by','p_2046s_loop_widget').'</strong>
							<select name="'. $this->get_field_name( 'order_by' ).'" class="order_by">';
								// list if possible orders
								// not inluded: 
								if($the_type == 'page'){
									$posible_orders = array('none','ID', 'title', 'date','modified','rand','comment_count','menu_order', 'parent', 'meta_value','meta_value_num');
								}else{
									$posible_orders = array('none','ID', 'title', 'date','modified','rand','comment_count', 'meta_value','meta_value_num','menu_order');
								}
								foreach($posible_orders as $order){
									echo '<option '; if($instance['order_by'] == $order){echo 'selected="selected"';} echo' value="'.$order.'" >'.$order.'</option>'; 
								}
							echo '</select>
							<em>'.__('meta_value sorts: alphabetically / meta_value_num: sorts numerically / parent: ID','p_2046s_loop_widget').'</em>
							<span class="pw_meta">
								<br /><br />'.__('Meta key','p_2046s_loop_widget').'<br />
								<input type="text" name="'. $this->get_field_name( 'meta_key_sort' ).'" '; if (!empty($instance['meta_key_sort'])){ echo 'value="'.$instance['meta_key_sort'].'"'; }else{ echo 'value=""';} echo'/>
								<br /><em>'.__('The exact meta key name.','p_2046s_loop_widget').'</em>
							</span>
						</p>
					</div>
					<h3 class="restrict_to">'.__('Restrict to','p_2046s_loop_widget').'</h3>
					<div class="pw_holder restrict_to">
						<p class="restrict_to_ids">
							<strong>'.__('Restrict to post or page IDs:','p_2046s_loop_widget').'</strong><br />
							<input type="text" name="'. $this->get_field_name( 'restrict_to_ids' ).'" '; if (!empty($instance['restrict_to_ids'])){ echo 'value="'.$instance['restrict_to_ids'].'"'; }else{ echo 'value=""';} echo'/>
							<br />
							<em>'.__('No restrictions if empty. Separate IDs by comma.','p_2046s_loop_widget').'</em>
							<br /><br />
							<select name="'. $this->get_field_name( 'restrict_to_ids_with_childs' ).'" class="restrict_to_ids_with_childs">
								<option '; if($instance['restrict_to_ids_with_childs'] == 0){echo 'selected="selected"';} echo' value="0">'.__('only on given IDs','p_2046s_loop_widget').'</option>
								<option '; if($instance['restrict_to_ids_with_childs'] == 1){echo 'selected="selected"';} echo' value="1">'.__('only on child pages of given ID','p_2046s_loop_widget').'</option>
								<option '; if($instance['restrict_to_ids_with_childs'] == 2){echo 'selected="selected"';} echo' value="2">'.__('for given IDs and it\'s children pages','p_2046s_loop_widget').'</option>
							</select>
						</p>
					</div>
					<h3 class="prevent_from">'.__('Prevent from being shown on','p_2046s_loop_widget').'</h3>
					<div class="pw_holder prevent_from">
						<p class="pw_stick_on_template_types">
							<fieldset class="stick_on_template_types" id="stick_on_template_types">';
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
							echo '</fieldset>
						</p>
						<p class="disallow_on_ids">
							<strong>'.__('Do not show on post/page with IDs:','p_2046s_loop_widget').'</strong><br />
							<input type="text" name="'. $this->get_field_name( 'disallow_on_ids' ).'" '; if (!empty($instance['disallow_on_ids'])){ echo 'value="'.$instance['disallow_on_ids'].'"'; }else{ echo 'value=""';} echo '/>
							<br />
							<em>'.__('No restrictions if empty. Separate IDs by comma.','p_2046s_loop_widget').'</em>
						</p>
					</div>
				</div>
				<input type="checkbox" name="'. $this->get_field_name( 'debug' ).'" value="1" '; if ($instance['debug'] == 1) {echo 'checked="checked"';} echo '> debug
			</div>
			<p class="lw_type_change_note">
				'.__('In order to load the appropriate settings for the selected "post type" you have to save the widget.','p_2046s_loop_widget').'
			</p>
		</div>';
	}
	
	/**
	 * Update the widget settings.
	 */
	function update($new_instance, $old_instance ) {
	
		$instance = $old_instance;

			/* Strip tags for title and name to remove HTML (important for text inputs). */
			$instance['the_post_type'] = strip_tags( $new_instance['the_post_type'] ); 
			$instance['the_widget_title'] = $new_instance['the_widget_title']; // "strip_tags" removed for qtranslate to work such as <!--:en-->Recomendation<!--:--><!--:cs-->Doporučujeme<!--:-->
			$instance['the_widget_user_title'] = strip_tags( $new_instance['the_widget_user_title'] ); 
			$instance['the_widget_user_note'] = strip_tags( $new_instance['the_widget_user_note'] ); 
			$instance['the_post_title'] = strip_tags( $new_instance['the_post_title'] );
			$instance['the_post_title_link'] = strip_tags( $new_instance['the_post_title_link'] );
			$instance['edit_link'] = strip_tags( $new_instance['edit_link'] );  
			$instance['html_heading'] = strip_tags( $new_instance['html_heading'] ); 
			$instance['image_size'] = strip_tags( $new_instance['image_size'] );
			$instance['image_position'] = strip_tags( $new_instance['image_position'] ); 
			$instance['image_with_link'] = strip_tags( $new_instance['image_with_link'] ); 
			$instance['with_excerpt'] = strip_tags( $new_instance['with_excerpt'] );
			$instance['postmeta'] = $new_instance['postmeta']; // array
			$instance['comments_booble'] = strip_tags( $new_instance['comments_booble'] ); // false, true
			$instance['comments_selector'] = strip_tags( $new_instance['comments_selector'] );
			$instance['comments_comments_closed_info'] = strip_tags( $new_instance['comments_comments_closed_info'] );
			$instance['navigation'] = strip_tags( $new_instance['navigation'] );
			$instance['scafolding_selector'] = strip_tags( $new_instance['scafolding_selector'] );
			$instance['scafolding_row'] = preg_replace("/[^A-Za-z0-9\s-\_]/", "", $new_instance['scafolding_row'] ); // letters, numbers, dash, underscore
			$instance['scafolding_column'] = preg_replace("/[^A-Za-z0-9\s-\_]/", "", $new_instance['scafolding_column']); // letters, numbers, dash, underscore
			$instance['location_selector'] = strip_tags( $new_instance['location_selector'] );
			$instance['page_selector'] = strip_tags( $new_instance['page_selector'] );
			$instance['parent_page_id'] = preg_replace("/[^0-9\s,]/", "", $new_instance['parent_page_id'] ); // numbers, spaces, dashes
			$instance['taxonomy'] = $new_instance['taxonomy']; //array
			$instance['taxonomy_comparison'] = $new_instance['taxonomy_comparison']; // array
			$instance['against_taxonomy'] = strip_tags($new_instance['against_taxonomy']);
			$instance['order_by'] = strip_tags($new_instance['order_by']);
			$instance['the_order'] = strip_tags($new_instance['the_order']);
			$instance['meta_key_sort'] = strip_tags($new_instance['meta_key_sort']);
			$instance['compare'] = $new_instance['compare'];
			$instance['meta_value'] = strip_tags($new_instance['meta_value']);
			$instance['meta_key'] = strip_tags($new_instance['meta_key']);
			$instance['post_id'] = preg_replace("/[^0-9\s,]/", "", $new_instance['post_id'] ); // numbers, spaces, dashes
			$instance['posts_number'] = preg_replace("/[^0-9]/", "", $new_instance['posts_number'] );// number
			$instance['with_offset'] = preg_replace("/[^0-9]/", "", $new_instance['with_offset'] ); // only number
			$instance['restrict_to_ids'] = preg_replace("/[^0-9\s,]/", "", $new_instance['restrict_to_ids'] );// numbers, spaces, dashes
			$instance['restrict_to_ids_with_childs'] = preg_replace("/[^0-9\s,]/", "", $new_instance['restrict_to_ids_with_childs'] );// numbers, spaces, dashes
			$instance['stick_on_template_types'] = $new_instance['stick_on_template_types']; 
			$instance['disallow_on_ids'] = preg_replace("/[^0-9\s,]/", "", $new_instance['disallow_on_ids']);// numbers, spaces, dashes
			$instance['paging'] = $new_instance['paging'];  
			$instance['permissions'] = $new_instance['permissions']; 
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
		$the_widget_title = $instance['the_widget_title']; //
		$the_widget_user_title = $instance['the_widget_user_title']; //
		$the_widget_user_note = $instance['the_widget_user_note']; //
		$html_heading = $instance['html_heading']; //
		$the_post_title = $instance['the_post_title']; //
		$the_post_title_link = $instance['the_post_title_link'];
		$edit_link = $instance['edit_link']; //
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
		$taxonomy_comparison = $instance['taxonomy_comparison'];
		$against_taxonomy = $instance['against_taxonomy'];
		$the_order = $instance['the_order'];
		$order_by = $instance['order_by'];
		$meta_value = $instance['meta_value'];
		$meta_key = $instance['meta_key'];
		$meta_key_sort = $instance['meta_key_sort'];
		$compare = $instance['compare'];
		$with_offset = $instance['with_offset']; //
		$posts_number = $instance['posts_number']; //
		$restrict_to_ids = $instance['restrict_to_ids'];
		$restrict_to_ids_with_childs = $instance['restrict_to_ids_with_childs'];
		$stick_on_template_types = $instance['stick_on_template_types']; 
		$disallow_on_ids = $instance['disallow_on_ids']; 
		$navigation = $instance['navigation'];
		$scafolding_selector = $instance['scafolding_selector'];
		$scafolding_column = $instance['scafolding_column'];
		$scafolding_row  = $instance['scafolding_row'];
		$paging = $instance['paging'];
		$permissions = $instance['permissions'];
		$debug = $instance['debug'];
		
		
		// check the user level
		if( $permissions == 'all' || current_user_can( $permissions )){
			// reset the previous loops
			// just to be sure they wont manipulate the curent query
			wp_reset_postdata();
			//wp_reset_query();
			// get the global data of curent seen post || page
			global $post;
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			/* Display name from widget settings if one was input. */
			// init the val.
			$p_id = '';
			$args = array(
				'post_type' => $the_post_type,
			);
			// allow diallow pagination
			if ($paging == true){
				$pages = array(
					'paged' => $paged
					);
				$args = array_merge( $args , $pages);
			}else{
				$pages = array(
				'nopaging' => true
				);
				$args = array_merge( $args , $pages);
			}
			// if they want to show particular ID instead the actual post || page
			// check if they selected location: "Elsewhere"
			if($location_selector == 1){
				// sorting
				$sorting_args = array(
					'order' => $the_order,
					'orderby' => $order_by,
					'meta_key' => $meta_key_sort
				);
				$args = array_merge( $args , $sorting_args);
			
				// divide by types post | page_selector
				// for post types post(linear) || page (hierarchycal)
				// linear in this case
				if(!is_post_type_hierarchical($the_post_type)){
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
								'posts_per_page' => $posts_number,
								'offset' => $with_offset,
								'tax_query' => array(
									'relation' => $taxonomy_comparison
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
										'terms' => $value,  // add the term ID array (val)
									);
									// add to arrays to tax query a < b
									array_push( $args_taxonomies['tax_query'], $args_taxonomies_tax_query);
								}
							}
							// merge tax query with the main array
							$args = array_merge( $args, $args_taxonomies);
						}else{
							$args_taxonomies = array(
								'posts_per_page' => $posts_number,
								'offset' => $with_offset,
								);
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
								),
								'posts_per_page' => $posts_number
							);
							$args = array_merge( $args, $args_taxonomies_against);
						}
					}
					// restrict to these post|page with these meta
					elseif($page_selector == 6 && !empty($meta_key) && !empty($meta_value)){
						$args_meta_restriction = array(
							'meta_query' => array(
								array(
									'key' => $meta_key,
									'value' => $meta_value,
									'compare' => $compare
								)
							),
							'posts_per_page' => $posts_number
						);
						$args = array_merge( $args, $args_meta_restriction);
					}else{
						// they decided to offset the page
						if(!empty($with_offset)){
							$args_offset = array(
								'offset' => $with_offset,
								'posts_per_page' => $posts_number
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
				// for page types (hierarchical)
				else{
					// 0 Select Page(s) by IDs
					if($page_selector == 0){
						$post_id_clean = ereg_replace(" ", "", $post_id);
						$post_ids_array = explode(',', $post_id_clean);
						// if empty the no restriction are applied
						if(!empty($post_ids_array[0])){
							$args_ids = array(
								'post__in' => $post_ids_array
					 		);
					 		$args = array_merge( $args , $args_ids);
				 		}
						/*$args_ids = array(
							'post__in' => $post_id,
				 		);
				 		$args = array_merge( $args , $args_ids);*/
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
								'order' => $the_order,
								'orderby' => $order_by
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
								'posts_per_page' => $posts_number,
								'tax_query' => array(
									'relation' => $taxonomy_comparison
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
						}else{
					
							$args_taxonomies = array(
								'posts_per_page' => $posts_number
								);
							// merge tax query with the main array
							$args = array_merge( $args, $args_taxonomies);
						}
					}
					// 5	From the same taxonomy as the curently seen post.page
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
								),
								'posts_per_page' => $posts_number
								
							);
							// add to arrays to query
							$args = array_merge( $args, $args_taxonomies_against);
						}
					}elseif($page_selector == 6 && !empty($meta_key) && !empty($meta_value)){
						$args_meta_restriction = array(
							'meta_query' => array(
								array(
									'key' => $meta_key,
									'value' => $meta_value,
									'compare' => $compare
								)
							),
							'posts_per_page' => $posts_number
						);
						$args = array_merge( $args, $args_meta_restriction);
					}else{
						$args_meta_restriction = array(
							'posts_per_page' => $posts_number
						);
						$args = array_merge( $args, $args_meta_restriction);
					}
				}
			}

			// or gallery of the final post
			elseif($location_selector == 2){
				// lets make the gallery the WP_query way, so we can wrap the image as like the posts
				// get the images parent post ID
				if (!empty($post_id)){
					$ids_clean = str_replace (" ", "", $post_id);
					if(explode(',' ,$ids_clean)){
						$expl_ids = explode(',' ,$ids_clean);
						$p_id = $expl_ids[0];
					}else{
						$p_id = $ids_clean;
					}
				}else{
					$p_id = $post->ID;
				}
				$args = array( 
					'post_parent' => $p_id, // Get data from the current post
					'post_type' => 'attachment', // Only bring back attachments
					'post_mime_type' => 'image', // Only bring back attachments that are images
					'posts_per_page' => $posts_number, // Show us the first result
					'offset' => $with_offset,
					'post_status' => 'inherit', // Attachments default to "inherit", rather than published. Use "inherit" or "all". 
					'orderby' =>  $order_by,
					'order' => $the_order,
				);
		
			}
			// "else" meaning, they decided to show the actual final loop,
			// presumably on sidebar in page.php or single.php
			//
			elseif($location_selector == 0){
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
		
			// if we do not process the post gallery only
			if($location_selector != 2){
				// RESTRICTIONS
				$stick_ids = array();
				if(!empty($restrict_to_ids)){
					// make an array if ids
					$stick_ids_clean = str_replace (" ", "", $restrict_to_ids);
					// do it for these page IDS
					//echo '-----'.$restrict_to_ids_with_childs.'------';
					if($restrict_to_ids_with_childs == 0){
						if(explode(',' ,$stick_ids_clean)){
							$stick_ids = explode(',' ,$stick_ids_clean);
						}else{
							array_push($stick_ids, $restrict_to_ids);
						}
					}
					// do it for child pages of the selected IDs
					elseif($restrict_to_ids_with_childs == 1){
						// Set up the objects needed
						// make an array out of given IDs
						$parents = explode(',' ,$stick_ids_clean);
						// add child pagesto the array 
						foreach($parents as $each){
							$childs = get_children(array('post_parent' => $each));
							foreach($childs as $child){
								array_push($stick_ids, $child->ID);
							}
						}
					}
					// do it for selected IDs & their child pages
					else{
						// Set up the objects needed
						// make an array out of given IDs
						$parents = explode(',' ,$stick_ids_clean);
						foreach($parents as $each){
							// add each parent to the array_merge first
							array_push($stick_ids, $each);
							 
							$childs = get_children(array('post_parent' => $each));
							// add child pages to the array as well 
							foreach($childs as $child){
								if($child->ID == $post->ID){
									array_push($stick_ids, $child->ID);
								}
							}
						}
					}
					// if there are restrictions, AND the the curent post->id is not in the restricted array_merge-d $stick_ids
					// let it go
					if (!in_array($post->ID, $stick_ids)){
						return;
					}
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
			}
			// The Query
			$the_query = new WP_Query( $args );
			// run the LOOP
			if($the_query->have_posts()){
				// scafolding
				// classical WP
				if($scafolding_selector == 0){
					echo $before_widget;
				}
				// if user want to see widget title
				if (!empty($the_widget_title)){
					echo '<h4 class="widget_title '.$widget_id.'">'.__($the_widget_title).'</h4>';
				
				}
				
				// when one per row 
					// than do not render div here
				// many per row
				if($scafolding_selector == 2){
					echo '<div class="'.$scafolding_row.'">';
				}
				// The Loop
				while ( $the_query->have_posts() ) : $the_query->the_post();

					if($scafolding_selector == 1){
						// row
						echo '<div ';
						post_class($scafolding_row);
						echo '>';
						// column
						if(!empty($scafolding_column)){
							echo '<div class="'.$scafolding_column.'">';
						}
					}
					// scafolding column
					elseif ($scafolding_selector == 2){
						echo '<div ';
						post_class($scafolding_column);
						echo '>';
					}
					// basic WP class
					else{
						echo '<div ';
						post_class();
						echo '>';
					}
						// if user want the image here 
						if ( has_post_thumbnail() && ($image_position == 0)) { // check if the post has a Post Thumbnail assigned to it.
							echo f_2046_build_image($the_query->post, $image_with_link, $image_size, $p_id);
						}
						// gallery
						if(($location_selector == 2 && $image_position == 0) && ($image_size != 0)){
							echo f_2046_gallery_builder($the_query->post->ID, $image_size, $image_with_link);
						}
						// if user want to see post title
						if($the_post_title == 'on'){
							echo '<'.$html_heading.'>';
								if($the_post_title_link == 'on'){
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
								}
									the_title();
								if($the_post_title_link == 'on'){
									echo '</a>';
								}
									if(is_user_logged_in() && $edit_link == 'on'){
									edit_post_link('edit', '', ' <small class="lw_2046_pID">'.$the_query->post->ID.'</small>');
								}
							echo '</'.$html_heading.'>';
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
							echo f_2046_build_image($the_query->post, $image_with_link, $image_size, $p_id);
						} 
						// if the user want the content and we are not going to render the gallery
						if($with_excerpt == '1' && $location_selector != 2){
							the_excerpt();
						}
						elseif($with_excerpt == '2' && $location_selector != 2){
							global $more;
							$more = 0;
							the_content();
						}
						// gallery
						if(($location_selector == 2 && $image_position == 1) && ($image_size != 0)){
							echo f_2046_gallery_builder($the_query->post->ID, $image_size, $image_with_link, $p_id);
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
					// scafolding column
					if ($scafolding_selector == 1){
						if(!empty($scafolding_column)){
							echo '</div><!-- END column -->';
						}
						echo '</div><!-- END row -->';
					}else{
						echo '</div><!-- END post (or, and) column -->';
					}
				endwhile;
				// scafolding classical WP
				if ($scafolding_selector == 0){
					/* After widget (defined by themes). */
					echo $after_widget;
				}
				elseif($scafolding_selector == 2){
					echo '</div>';
				}
				// Create navigation
				if($navigation == 2){
					echo '<div class="navigation">';
						previous_posts_link(__('&#171; previous','p_2046s_loop_widget'), $the_query->max_num_pages);
						next_posts_link(__('next &#187;','p_2046s_loop_widget'), $the_query->max_num_pages);
						//posts_nav_link(' &#183; ', 'previous page', 'next page');
					echo '</div>';
				}
				// show the scribus page navi (if installed)
				if ($navigation == 3 && function_exists('wp_pagenavi')) { 
					wp_pagenavi( array( 'query' => $the_query ) );
				}
				// show the link to category list
				if ($navigation == 4) { 
					$all_cats = get_the_category();
					echo '<div class="navigation">
						<a class="link_to_category_list" href="'.get_category_link($all_cats[0]->term_id).'">'.__("view all &rarr;","p_2046s_loop_widget").'</a>
					</div>';
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
			} // END if have a post
		// Reset Post Data
		wp_reset_postdata();
		} // end user check
	}

} // END of class

// build image html
function f_2046_build_image($post_, $image_with_link, $image_size) {
	$post_thumbnail_id = get_post_thumbnail_id( $post_->ID );
	$output = '';
	// make the image link to the post/page
	if ($image_with_link == 1){
		$output .= '<a href="'. get_permalink($post_->ID) . '" title="'.get_the_title($post_->ID).'" class="page_link img_link">';
	}
	// make the image link to it's large version
	if ($image_with_link == 2){
		$image_large_src = wp_get_attachment_image_src( $post_thumbnail_id, 'large');
		// set links to large image and image's title
		$output .= '<a href="'. $image_large_src[0] . '" class="image_link img_link">';
	}
		// define thumbnail atributes
		$default_attr = array(
			'title'	=> trim(strip_tags( $post_->post_title )),
		);
		if($image_size == 1){
			$img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post_->ID ), 'thumbnail' );
			$output .='<img src="'.$img_src[0] .'" alt="'.$post_title.'"/>';
			//$output .= wp_get_attachment_image( $post_thumbnail_id, 'thumbnail'); //get_the_post_thumbnail('thumbnail', $default_attr);
		}
		if($image_size == 2){
			$img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post_->ID ), 'medium' );
			$output .='<img src="'.$img_src[0] .'" alt="'.$post_title.'"/>';
			//$output .= wp_get_attachment_image( $post_thumbnail_id, 'medium'); //get_the_post_thumbnail('medium', $default_attr);
		}
		elseif($image_size == 3){
			$img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post_->ID ), 'large' );
			$output .='<img src="'.$img_src[0] .'" alt="'.$post_title.'"/>';
			//$output .= wp_get_attachment_image( $post_thumbnail_id, 'large'); //get_the_post_thumbnail('large', $default_attr);
		}
	
	if ($image_with_link > 0){
		$output .= '</a>';
	}
	
	return $output;
	
}
// add WP featured image support
if ( function_exists( 'add_theme_support' ) ) { 
	add_theme_support( 'post-thumbnails' ); 
}
// gallery function_exists
function f_2046_gallery_builder($p_ID, $image_size, $link, $p_id){
	$l_image_attributes = wp_get_attachment_image_src($p_ID , 'large');
	$sizes = array('','thumbnail', 'medium','large');
	foreach($sizes as $key=>$value){
		if($key == $image_size){
			$thmb_size = $value;
		}
	}
	$default_img_attr = array(
		'class'	=> "image $thmb_size lightbox",
	);
	// image without link
	if($link == 0){
		$output = wp_get_attachment_image( $p_ID, $thmb_size, false);
	}
	// image with link to post/page
	elseif($link == 1){
		$img_src = wp_get_attachment_image_src( $p_ID, $thmb_size );
		$post_title = get_the_title($p_id);
		$output = '<a href="'.get_page_link($p_id).'"  title="'.$post_title.'"><img src="'.$img_src[0] .'" alt="'.$post_title.'"/></a>';
	}
	// image with link to large sizes
	else{
		$output = '<a href="'.$l_image_attributes[0].'">'. wp_get_attachment_image( $p_ID, $thmb_size, false).'</a>';
	}
	return $output;
}
// add js and css to the widget admin page
add_action( 'admin_print_scripts-widgets.php', 'f2046_lw_insert_custom_js', 11 );
function f2046_lw_insert_custom_js() {
	wp_register_script('lw_2046_widget_ui',plugins_url( 'js/lw_2046_widget_ui.js' , __FILE__ ));
	wp_enqueue_script('lw_2046_widget_ui');
	// ams sellect
	// http://code.google.com/p/jquery-asmselect/
	//wp_register_script('lw_2046_asm_select',plugins_url( 'js/asmselect/jquery.asmselect.js' , __FILE__ ));
	//wp_enqueue_script('lw_2046_asm_select');

}

add_action('admin_print_styles-widgets.php', 'f2046_lw_insert_custom_css');
function f2046_lw_insert_custom_css(){
	wp_register_style('style_lw_2046', plugins_url( 'css/style_lw_2046.css' , __FILE__ ),false,0.1,'all');
	wp_enqueue_style( 'style_lw_2046');
	if ( get_option('w2046_options') == 1){
		wp_register_style('style_lw_2046_helper', plugins_url( 'css/style_lw_2046_helper.css' , __FILE__ ),false,0.1,'all');
		wp_enqueue_style( 'style_lw_2046_helper');
	}

}

/*
//  -------- create admin UI ---------------
*/


class options_page {
	function __construct() {
		add_action('admin_menu', array(&$this, 'admin_menu'));
	}
	
	function w2046_register_settings() {
		register_setting( 'w2046_options', 'w2046_widget_screen' );
	}
	
	function admin_menu () {
		add_options_page('2046\'s loop widget','2046\'s loop widget','manage_options','options_page_slug',array($this, 'settings_page'));
	}
	
	function  settings_page () {
		if ( ! isset( $_REQUEST['updated'] ) )
			$_REQUEST['updated'] = false; // This checks whether the form has just been submitted. 
		
		$db_value = get_option('w2046_options');
		echo'<div class=”wrap”><p>';
			screen_icon();
			echo '<h2>2046\'s loop widget</h2></p><br />';

				if ($_POST['w2046_options'][0] != $db_value) {
					// fast validatethe data
					$input = ( esc_attr($_POST['w2046_options'][0]));
					// insert in to the database
					update_option( 'w2046_options', $input );
					$current_screen_value = $input;
					
					?>
					<div class="updated"><p><strong><?php _e('Options updated' ); ?></strong></p></div>
					<?php
				}else{
					//echo '<div class="updated"><p><strong>Nothing to be updated</strong></p></div>';
					$current_screen_value = get_option('w2046_options');
				}

				echo '<p>The only purpose of this is to rearrange the admin widget layout giving us more space.</p>
		
				<form action="" method="post" id="w2046_loop_w_layout">';
					//echo settings_fields('w2046_loop');
					settings_fields( 'w2046_options' );
					    /* This function outputs some hidden fields required by the form,
					    including a nonce, a unique number used to ensure the form has been submitted from the admin page
					    and not somewhere else, very important for security */
					echo '
					<input type="checkbox" name="w2046_options[]" value="1"';if( $current_screen_value == 1 ){ echo ' checked="checked"';} ; echo'  />
					<input type="submit" name="submit" value="Save" />
					</br>
					<em>Check this box if you want more space.</em>
					<br />
					<img src="'.plugin_dir_url(__FILE__).'/images/widget-scrn.jpg" alt="" />
				</form>
			</div>
		</div>';
	}
}
new options_page;


