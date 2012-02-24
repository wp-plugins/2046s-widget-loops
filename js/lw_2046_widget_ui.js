jQuery(document).ready(function($){ 
	
	var lw_settings = function(parent_widget) { 
		//console.log($(parent_widget + ' select.page_selector').val() + ' -selector val');
		if($(parent_widget + ' select.page_selector').val() == 0){
			$(parent_widget + " div.pw_taxonomies").hide();
			$(parent_widget + " p.pw_parent_page_id").hide();
			$(parent_widget + " p.pw_post_id").show();
			$(parent_widget + " p.pw_with_offset").hide();
			$(parent_widget + " p.pw_posts_number").hide();
			$(parent_widget + " p.pw_against_taxonomy").hide();
		}else if($(parent_widget + ' select.page_selector').val() == 1){
			$(parent_widget + " div.pw_taxonomies").hide();
			$(parent_widget + " p.pw_post_id").hide();
			$(parent_widget + " p.pw_parent_page_id").show();
			$(parent_widget + " p.pw_against_taxonomy").hide();
		}
		// 2,3
		else if( $(parent_widget + ' select.page_selector').val() < 4){
			$(parent_widget + " div.pw_taxonomies").hide();
			$(parent_widget + " p.pw_post_id").hide();
			$(parent_widget + " p.pw_parent_page_id").hide();
			$(parent_widget + " p.pw_with_offset").hide();
			$(parent_widget + " p.pw_against_taxonomy").hide();
		}
		else if($(parent_widget + ' select.page_selector').val() == 5){
			$(parent_widget + " div.pw_taxonomies").hide();
			$(parent_widget + " p.pw_post_id").hide();
			$(parent_widget + " p.pw_parent_page_id").hide();
			$(parent_widget + " p.pw_with_offset").show();
			$(parent_widget + " p.pw_posts_number").show();
			$(parent_widget + " p.pw_against_taxonomy").show();
		}
		// 4
		else {
			$(parent_widget + " div.pw_taxonomies").show();
			$(parent_widget + " p.pw_post_id").hide();
			$(parent_widget + " p.pw_parent_page_id").hide();
			$(parent_widget + " p.pw_with_offset").hide();
			$(parent_widget + " p.pw_posts_number").hide();
			$(parent_widget + " p.pw_against_taxonomy").hide();
		};
	};
	
	var location_select = function(This){
		if($(This).attr('value') == 0){
			parent_widget = 'div#' + $(This).parents('div.pw_2046_lw').attr('id');
			//console.log($(This).attr('value') + 'on save 0 ' + parent_widget);
			jQuery(parent_widget + " div.if_elsewhere").hide();
		}else{
			parent_widget = 'div#' + $(This).parents('div.pw_2046_lw').attr('id');
			//console.log($(This).attr('value') + ' on save 1 ' + parent_widget);
			jQuery(parent_widget + " div.if_elsewhere").show();
			// show various inputs
			lw_settings(parent_widget);
		}
	}
	
	//
	// do stuf when the widget is dropped in
	//
	$('div.widgets-sortables').bind('sortstop',function(event,ui){
		$('p.lw_type_change_note').hide();
		//console.log('just dropped in');
		$('#widgets-right select.location_selector').each( function() {
			location_select(this);
		});
		// asmselect
		// enhance multiple select
		$("div.pw_2046_lw select[multiple]").asmSelect({
			addItemTarget: 'bottom',
		});
		
	});
	
	//
	// do some stuff on load
	//
	// hide the saving note
	$('p.lw_type_change_note').hide();
	
	$('#widgets-right select.location_selector').each( function() {
		location_select(this);
	});
	// asmselect
	// enhance multiple select
	$("div.pw_2046_lw select[multiple]").asmSelect({
		addItemTarget: 'bottom',
	});
	
	//
	// react on ajax sucess (on save)
	//
	$('body').ajaxSuccess(function(evt, request, settings) {
		$('p.lw_type_change_note').hide();
		
		$('#widgets-right select.location_selector').each( function() {
			location_select(this);
		});
		// asmselect
		// enhance multiple select
		$("div.pw_2046_lw select[multiple]").asmSelect({
			addItemTarget: 'bottom',
		});
	});
	
	
	//
	// ON CHANGES
	//
	
	// set the actual post_type value in memory
	var parent_div = '';
	var old_type ='';
	$(document).delegate('select.the_post_type', 'focusin', function(ev) {
		  	old_type = $(this).attr('value');
		  	parent_div = $(this).parents('div.pw_2046_lw').attr('id');
	});
	// show-hide all the settings if the user has changed the post_type
	$(document).delegate('select.the_post_type', 'change', function(ev) {
			if(old_type == $(this).attr('value')){
				// show the settings
				$('div.lw_2046_left, div.lw_2046_right').slideDown();
				// hide the note
				$('.lw_type_change_note').hide();
			}else{
				// hide the settings
				$('div.lw_2046_left, div.lw_2046_right').slideUp();
				// show the note
				$('.lw_type_change_note').show();
			};
	});
	// single or elsewhere
	$(document).delegate('select.location_selector', 'change', function(ev) {
		// define the parent widget always, because you never know if there are not more same widgets
		parent_widget = 'div#' + $(this).parents('div.pw_2046_lw').attr('id');
		console.log(parent_widget + ' parent_widget');
		// final loop
		if($(parent_widget + ' select.location_selector').attr('value') == 0){
			
			console.log($(parent_widget + ' select.location_selector').attr('value') + ' if');
			jQuery(parent_widget + " div.if_elsewhere").hide();
		}
		// elsewhere
		else{
			console.log($(parent_widget + ' select.page_selector').attr('value') + ' <- selector val');
			// show the div with settings
			jQuery(parent_widget + " div.if_elsewhere").show();
			// show various inputs
			lw_settings(parent_widget);
		}
	});
	
	$(document).delegate('select.page_selector', 'change', function(ev) {
		// define the parent widget always, because you never know if there are not more same widgets
		parent_widget = 'div#' + $(this).parents('div.pw_2046_lw').attr('id');
		// show various inputs
		lw_settings(parent_widget);
	});
});
