<?php
/**
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'w2046_page_widget' );

/**
 * Register our widget.
 * 'w_2046_pages_Widget' is the widget class used below.
 *
 */
function w2046_page_widget() {
	register_widget( 'w2046_pages_widget' );
}

/**
 * w_2046_pages Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 */
 class w2046_pages_widget extends WP_Widget {
	/**
	 * Widget setup.
	 */
	function w2046_pages_widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'w_2046_pages', 'description' => __('It let\'s you select one or many Pages from the selected category or all. It let\'s you allow or disallow the loop to be show on certain places and much more.', 'w_2046_pages') );
		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'w_2046_pages-widget' );
		/* Create the widget. */
		$this->WP_Widget( 'w_2046_pages-widget', __('2046\'s - Page loop widget', 'w_2046_pages'), $widget_ops, $control_ops );
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
			'stick_on_ids' => __('', 'w_2046_posts'), // num
			'disallow_on_template_types' => __(array(''), 'w_2046_posts'), //__('', 'w_2046_posts'), // names
			'disallow_on_ids' => __('', 'w_2046_posts'), // num
			);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		<div id="the_widget_id_<?php echo $this->id; ?>" class="pw_2046_lw">
			<em>Note: To see the widget behave properly, when you drop the wiget in here the widget should to be saved first.</em>
			<h3>Widget title</h3>
			<div class="pw_holder">
				<p class="pw_the_title">
					<input type="text" name="<?php echo $this->get_field_name( 'the_title' ); ?>" value="<?php echo $instance['the_title'] ?>"/>
					<br />
					<em>if empty: no title, no html, nothing</em>
				</p>
			</div>
			<h3>Content</h3>
			<div class="pw_holder">
				<p class="pw_image_size">
					<strong>Image size</strong><br />
					<input class="h" type="radio" name="<?php echo $this->get_field_name( 'image_size' ); ?>" value="0" <?php if ($instance['image_size'] == 0) echo 'checked="checked"'; ?>> No picture<br>
					<input class="h" type="radio" name="<?php echo $this->get_field_name( 'image_size' ); ?>" value="1" <?php if ($instance['image_size'] == 1) echo 'checked="checked"'; ?>> Thumbnail<br>
					<input class="h" type="radio" name="<?php echo $this->get_field_name( 'image_size' ); ?>" value="2" <?php if ($instance['image_size'] == 2) echo 'checked="checked"'; ?>> Medium<br />
					<input class="h" type="radio" name="<?php echo $this->get_field_name( 'image_size' ); ?>" value="3" <?php if ($instance['image_size'] == 3) echo 'checked="checked"'; ?>> Large
				</p>
				<p class="pw_with_excerpt">
					<strong>Content</strong><br />
					<input type="radio" name="<?php echo $this->get_field_name( 'with_excerpt' ); ?>" value="0" <?php if ($instance['with_excerpt'] == 0) echo 'checked="checked"'; ?>> No content<br>
					<input type="radio" name="<?php echo $this->get_field_name( 'with_excerpt' ); ?>" value="1" <?php if ($instance['with_excerpt'] == 1) echo 'checked="checked"'; ?>> Excerpt<br>
					<input type="radio" name="<?php echo $this->get_field_name( 'with_excerpt' ); ?>" value="2" <?php if ($instance['with_excerpt'] == 2) echo 'checked="checked"'; ?>> Content<br />
				</p>
				<p class="pw_comments_booble">
					<input type="checkbox" name="<?php echo $this->get_field_name( 'comments_booble' ); ?>" <?php if ($instance['comments_booble'] == 'on'){ echo 'checked="checked"'; } ?> /> Show comments booble
				</p>
			</div>
			<em>Title of the post is present always.</em>
			<h3>Which Pages to show</h3>
			<div class="pw_holder">
				<p class="pw_page_selector">
					<strong>Select the logic</strong><br />
					<select name="<?php echo $this->get_field_name( 'page_selector' ); ?>" id="page_selector" >
						<?php echo '<option '; if($instance['page_selector'] == 0){echo 'selected="selected"';} echo' value="0" >Select pages by IDs</option>'; ?>
						<?php echo '<option '; if($instance['page_selector'] == 1){echo 'selected="selected"';} echo' value="1" >Children pages of Page parent</option>'; ?>
						<?php echo '<option '; if($instance['page_selector'] == 2){echo 'selected="selected"';} echo' value="2" >Children pages of displayed page</option>'; ?>
						<?php echo '<option '; if($instance['page_selector'] == 3){echo 'selected="selected"';} echo' value="3" >Pages from the same hierarchy level</option>'; ?>
					</select>
					<br />
					<em>The logic relates to the Page which is being displayed.</em>
				</p>

				<p class="pw_page_ids">
					<strong>Page ID's you want to show.</strong><br />
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
			<h3>Restrict to</h3>
			<div class="pw_holder">
				<p class="stick_on_ids">
					<strong>Restrict to Page IDs:</strong><br />
					<input type="text" name="<?php echo $this->get_field_name( 'stick_on_ids' ); ?>" <?php if (!empty($instance['stick_on_ids'])){ echo 'value="'.$instance['stick_on_ids'].'"'; }else{ echo 'value=""';}; ?>/>
					<br />
					<em>No restrictions if empty. Separate IDs by comma.</em>
				</p>
			</div>
			<h3>Prevent from being shown on</h3>
			<div class="pw_holder">
				<p class="pw_disallow_on_template_types">
					<fieldset class="disallow_on_template_types" id="disallow_on_template_types">
						<?php
						$i = 1;
						$template_types = array('Single post', 'Single page', 'Home', 'Front Page', 'Archive', 'Tag/Term list', 'Category list', 'Author\'s list', 'Search', '404 error page');
						foreach ($template_types as $types){
							echo '<input';
							if(is_array($instance['disallow_on_template_types'])){
								if(in_array($i,$instance['disallow_on_template_types'])){
									echo ' checked="checked"';
								}
							}
							echo ' type="checkbox" name="'.$this->get_field_name( 'disallow_on_template_types' ).'[]" value="'.$i.'" /> '.$types.'<br />';
							$i++;
						}
						?>
					</fieldset>
				</p>
				<p class="disallow_on_ids">
					<strong>Do not show on page with IDs:</strong><br />
					<input type="text" name="<?php echo $this->get_field_name( 'disallow_on_ids' ); ?>" <?php if (!empty($instance['disallow_on_ids'])){ echo 'value="'.$instance['disallow_on_ids'].'"'; }else{ echo 'value=""';}; ?>/>
					<br />
					<em>No restrictions if empty. Separate IDs by comma.</em>
				</p>
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
		$instance['stick_on_ids'] = strip_tags( $new_instance['stick_on_ids'] ); // num
		$instance['disallow_on_template_types'] = $new_instance['disallow_on_template_types'] ; // array
		$instance['disallow_on_ids'] = strip_tags( $new_instance['disallow_on_ids'] ); // num

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
		$stick_on_ids = $instance['stick_on_ids']; //num
		$disallow_on_template_types = $instance['disallow_on_template_types'];
		$disallow_on_ids = $instance['disallow_on_ids']; // num
		
		wp_reset_postdata();
		global $post;
		/* Display name from widget settings if one was input. */
		
		// The Query
		// define an empty args
		$args = array(
			'post_type' => 'page',
			'post_status' => 'publish'
		);
		// check if the content should not stick on some extra ids
		$stick_ids = array();
		if(!empty($stick_on_ids)){
			// make an array if ids
			$stick_ids_clean = str_replace (" ", "", $stick_on_ids);
			if(explode(',' ,$stick_ids_clean)){
				$stick_ids = explode(',' ,$stick_ids_clean);
			}else{
				array_push($stick_ids, $stick_on_ids);
			}
		}
		// if there are restrictions, AND the the curent post->id is not the in the restricted array_merge
		// let it go
		if ((!empty($stick_ids)) && (!in_array($post->ID, $stick_ids))){
			return;
		}
		//var_dump($page_selector);
		elseif ($page_selector == 0){
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
		}
		elseif($page_selector == 3){
			$its_parent = $post->post_parent;
			if(!empty($its_parent)){
				$args_page_parent = array(
					'post_parent' => $its_parent
			 	);
				$args = array_merge( $args , $args_page_parent);
			}
			
		}else{
			//
			$args_page_parent = array(
				'post_parent' => $post->ID,
		 	);
			$args = array_merge( $args , $args_page_parent);
		}
		//var_dump($args);
		$the_query = new WP_Query( $args );
		// check if there are no post id restrictions (where to and where not to show the content)
		$stick_ids = array();
		if(!empty($stick_on_ids)){
			// make an array if ids
			$stick_ids_clean = str_replace (" ", "", $stick_on_ids);
			if(explode(',' ,$stick_ids_clean)){
				$stick_ids = explode(',' ,$stick_ids_clean);
			}else{
				array_push($stick_ids, $stick_on_ids);
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
		  Page
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
		if(!empty($disallow_on_template_types)){
			if(is_single() && in_array(1, $disallow_on_template_types)){
				return;
			}
			if(is_page() && in_array(2, $disallow_on_template_types)){
				return;
			}
			if(is_home() && in_array(3, $disallow_on_template_types)){
				return;
			}
			if(is_front_page() && in_array(4, $disallow_on_template_types)){
				return;
			}
			if(is_archive() && in_array(5, $disallow_on_template_types)){
				return;
			}
			if(is_tag() && in_array(6, $disallow_on_template_types)){
				return;
			}
			if(is_tax() && in_array(7, $disallow_on_template_types)){
				return;
			}
			if(is_category() && in_array(8, $disallow_on_template_types)){
				return;
			}
			if(is_author() && in_array(9, $disallow_on_template_types)){
				return;
			}
			if(is_search() && in_array(10, $disallow_on_template_types)){
				return;
			}
			if(is_404() && in_array(11, $disallow_on_template_types)){
				return;
			}
			//var_dump($disallow_on_template_types);
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
		// The Loop
		if($the_query->have_posts()){
			/* Before widget (defined by themes). */
			echo $before_widget;
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
						if(is_user_logged_in()){
							edit_post_link('edit', '', ' <small class="lw_2046_pID">'.$post->ID.'</small>');
						}
						if($comments_booble == 'on' && ( comments_open() )){
							echo '<span class="wl2046_comment_number">';
								comments_number( ':)	', '1', '%' );
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
					if($with_excerpt == '1'){
						the_excerpt();
					}
					elseif($with_excerpt == '2'){
						the_content();
					}
				echo '</div>';
			endwhile;
			echo $after_widget;
		}
		wp_reset_postdata();
	}
}
