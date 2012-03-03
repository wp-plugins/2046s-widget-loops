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
			$(parent_widget + " p.pw_meta_sort").hide();
		}
		else if($(parent_widget + ' select.page_selector').val() == 1){
			$(parent_widget + " div.pw_taxonomies").hide();
			$(parent_widget + " p.pw_post_id").hide();
			$(parent_widget + " p.pw_parent_page_id").show();
			$(parent_widget + " p.pw_against_taxonomy").hide();
			$(parent_widget + " p.pw_meta_sort").hide();
		}
		// 2,3
		else if( $(parent_widget + ' select.page_selector').val() < 4){
			$(parent_widget + " div.pw_taxonomies").hide();
			$(parent_widget + " p.pw_post_id").hide();
			$(parent_widget + " p.pw_parent_page_id").hide();
			$(parent_widget + " p.pw_with_offset").hide();
			$(parent_widget + " p.pw_against_taxonomy").hide();
			$(parent_widget + " p.pw_meta_sort").hide();
		}
		else if($(parent_widget + ' select.page_selector').val() == 4){
			$(parent_widget + " div.pw_taxonomies").show();
			$(parent_widget + " p.pw_post_id").hide();
			$(parent_widget + " p.pw_parent_page_id").hide();
			$(parent_widget + " p.pw_with_offset").show();
			$(parent_widget + " p.pw_posts_number").show();
			$(parent_widget + " p.pw_against_taxonomy").hide();
			$(parent_widget + " p.pw_meta_sort").hide();
		}
		else if($(parent_widget + ' select.page_selector').val() == 5){
			$(parent_widget + " div.pw_taxonomies").hide();
			$(parent_widget + " p.pw_post_id").hide();
			$(parent_widget + " p.pw_parent_page_id").hide();
			$(parent_widget + " p.pw_with_offset").show();
			$(parent_widget + " p.pw_posts_number").show();
			$(parent_widget + " p.pw_against_taxonomy").show();
			$(parent_widget + " p.pw_meta_sort").hide();
		}
		// 6
		else {
			$(parent_widget + " div.pw_taxonomies").hide();
			$(parent_widget + " p.pw_post_id").hide();
			$(parent_widget + " p.pw_parent_page_id").hide();
			$(parent_widget + " p.pw_with_offset").show();
			$(parent_widget + " p.pw_posts_number").show();
			$(parent_widget + " p.pw_against_taxonomy").hide();
			$(parent_widget + " p.pw_meta_sort").show();
		};
	};
	// show hide scafolding settings
	var scafoldig_select = function(This){
		parent_widget = 'div#' + $(This).parents('div.pw_2046_lw').attr('id');
		if($(parent_widget + " select.scafolding_selector").attr('value') == 0){
			jQuery(parent_widget + " p.pw_scafolding_column").hide();
			jQuery(parent_widget + " p.pw_scafolding_row").hide();
		}else{
			jQuery(parent_widget + " p.pw_scafolding_column").show();
			jQuery(parent_widget + " p.pw_scafolding_row").show();
		}
	}
	// show / hide meta_value comparison
	var meta_inputs = function(This){
		parent_widget = 'div#' + $(This).parents('div.pw_2046_lw').attr('id');
		if($(parent_widget + " select.order_by").attr('value') == 'meta_value' || $(parent_widget + " select.order_by").attr('value') == 'meta_value_num'){
			jQuery(parent_widget + " .pw_meta").show();
		}else{
			jQuery(parent_widget + " .pw_meta").hide();
		}
	}
	
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
			// asmselect
			// enhance multiple select
			$(parent_widget + ' .lw_multiple_select').asmSelect({
				addItemTarget: 'bottom'
			});
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
			// scafolding behavior
			scafoldig_select(this);
			// meta_value inputs
			meta_inputs(this);
		});
	});
	
	//
	// do some stuff on load
	//
	// hide the saving note
	$('p.lw_type_change_note').hide();
	
	$('#widgets-right select.location_selector').each( function() {
		location_select(this);
		// scafolding behavior
		scafoldig_select(this);
		// meta_value inputs
		meta_inputs(this);
	});
	
	
	//
	// react on ajax sucess (on save)
	//
	
	$('#widgets-right').ajaxComplete(function(event, XMLHttpRequest, ajaxOptions){

		// determine which ajax request is this (we're after "save-widget")
		var request = {}, pairs = ajaxOptions.data.split('&'), i, split, widget;

		for(i in pairs){
			split = pairs[i].split('=');
			request[decodeURIComponent(split[0])] = decodeURIComponent(split[1]);
		}

		// only proceed if this was a widget-save request
		if(request.action && (request.action === 'save-widget')){
			// locate the widget block
			widget = $('input.widget-id[value="' + request['widget-id'] + '"]').parents('.widget');

			// trigger manual save, if this was the save request 
			// and if we didn't get the form html response (the wp bug)
			if(!XMLHttpRequest.responseText)
				wpWidgets.save(widget, 0, 1, 0);

			// we got an response, this could be either our request above,
			// or a correct widget-save call, so fire an event on which we can hook our js
			else
				//$(document).trigger('saved_widget', widget);
				// get the asmselect and stuff
				$('p.lw_type_change_note').hide();
				$('#widgets-right select.location_selector').each( function() {
					location_select(this); 
					// TODO: the taxonomy asmselect is still not perefect
					// it needs to be runned only once and only for the concrete widget, not for all (each)
					// scafolding behavior
					scafoldig_select(this);
					// meta_value inputs
					meta_inputs(this);
				});
		}
	});
	/*
	$('body').ajaxSuccess(function(evt, request, settings) {
		console.log('on save');
		$('p.lw_type_change_note').hide();
		$('#widgets-right select.location_selector').each( function() {
			location_select(this);
			// scafolding behavior
			scafoldig_select(this);
		});
		
	});
	*/
	
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
		//console.log(parent_widget + ' parent_widget');
		// final loop
		if($(parent_widget + ' select.location_selector').attr('value') == 0){
			
			//console.log($(parent_widget + ' select.location_selector').attr('value') + ' if');
			jQuery(parent_widget + " div.if_elsewhere").hide();
		}
		// elsewhere
		else{
			//console.log($(parent_widget + ' select.page_selector').attr('value') + ' <- selector val');
			// show the div with settings
			jQuery(parent_widget + " div.if_elsewhere").show();
			// show various inputs
			lw_settings(parent_widget);
			// meta_value inputs
			meta_inputs(this);
		}
	});
	
	$(document).delegate('select.page_selector', 'change', function(ev) {
		// define the parent widget always, because you never know if there are not more same widgets
		parent_widget = 'div#' + $(this).parents('div.pw_2046_lw').attr('id');
		// show various inputs
		lw_settings(parent_widget);
		// meta_value inputs
		meta_inputs(this);
	});
	// scafolding select change
	$(document).delegate('select.scafolding_selector', 'change', function(ev) {
		// scafolding behavior
		scafoldig_select(this);;
	});
	// order_by change
	$(document).delegate('select.order_by', 'change', function(ev) {
		// scafolding behavior
		meta_inputs(this);
	});
});
