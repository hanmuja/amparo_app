/**
 * 
 */
function initializeDraggableAcos() {
	$('div.aco_box').draggable({
		containment : $('#fp_acos').parent(), 
		helper : function() {
			var clon = $(this).clone();
			$('body').append(clon);
			return clon;
		},
		addClasses: false
	});
} 

/**
 * 
 */
function initializeDroppableBoxes(urlAdd) {
	$('.permissions_box').droppable({
		accept : 'div.aco_box, div.fp_assigned_path',
		activeClass: 'fp_droppable_active',
		hoverClass: 'fp_droppable_hover',
		drop : function(ev, ui) {
			var draggable = $(ui['draggable']).clone();
			draggable.find('div').detach();
			var data = new Array();
			var item_id = $(this).attr('record_id');
			data.push('data[FriendlyPermissionsItemsAco][aco_path]='+draggable.html().trim());
			data.push('data[FriendlyPermissionsItemsAco][friendly_permissions_item_id]='+item_id);
			data = data.join('&');
			
			show_loading();
			$.ajax({
				data: data,
				type: 'POST',
				url: urlAdd,
				cache: false,
				success: function(m) {
					hide_loading();
					$('#permissions_box_'+item_id).append(m);
					draggable.removeClass('unrelated');
					draggable.addClass('related');
					initializeDragglableAssignedBoxes();
				},
				error:function (XMLHttpRequest, textStatus, errorThrown) {
					handle_error(errorThrown);
				}
			});
		}
	});
}

function initializeDragglableAssignedBoxes() {
	$('div.fp_assigned_path').draggable({
		containment : $('#fp_sections'), 
		helper : function() {
			var clon = $(this).clone();
			clon.find('div').detach();
			$('body').append(clon);
			return clon;
		},
		addClasses: false
	});
}


var filterPathsRequest;
/**
 * 
 * @param String urlFilter
 */
function filterPaths(input, urlFilter) {
	if(typeof filterPathsRequest=='object' && filterPathsRequest['statusText'] != 'OK') {
		filterPathsRequest.abort();
	}
	
	var filterValue = $(input).val();
	
	show_loading();
	filterPathsRequest = $.ajax({
		data: 'filter='+filterValue,
		type: 'POST',
		url: urlFilter,
		cache: false,
		success: function(m) {
			hide_loading();
			$('#fp_inner_acos_list').html(m);
		},
		error:function (XMLHttpRequest, textStatus, errorThrown) {
			handle_error(errorThrown);
		}
	});	
}

var openStateRequest = new Array();
/**
 * 
 * 
 */
function togglePermissionBox(button, section_id, urlState) {
	if(typeof openStateRequest[section_id]=='object' && openStateRequest[section_id]['statusText'] != 'OK') {
		openStateRequest[section_id].abort();
	}
	
	var state = 'open';
	var box = $(button).parents('.fp_menu_section_box').first();
	if (box.hasClass('collapsed')) {
		//get the table outerHeight
		/*var new_height= box.find('.header').outerHeight() + box.find('.children').outerHeight();
		
		box.stop().animate({height:new_height},{easing:'easeOutBounce', complete: function(){box.css('height', 'auto');}});
		*/
		box.css('height', 'auto');
		box.removeClass('collapsed');
		
		var img_src= $(button).find('img').attr('src');
		img_src= img_src.replace('expand', 'collapse');
		$(button).find('img').attr('src', img_src);
	} else {
		//box.stop().animate({height:box.find('.header').outerHeight()},{easing:'easeOutBounce'});
		box.css('height', box.find('.header').outerHeight()+'px');
		box.addClass('collapsed');
		
		var img_src= $(button).find('img').attr('src');
		img_src= img_src.replace('collapse', 'expand');
		$(button).find('img').attr('src', img_src);
		state = 'close';
	}
	
	openStateRequest[section_id] = $.ajax({
		url: urlState+'/'+state	
	});
}

var pathOpenStateRequest = new Array();
function togglePathsBox(button, section_id, urlState) {
	if(typeof pathOpenStateRequest[section_id]=='object' && pathOpenStateRequest[section_id]['statusText'] != 'OK') {
		pathOpenStateRequest[section_id].abort();
	}
	
	var state = 'open';
	var box = $(button).parents('table').first().find('tr').first();
	if (box.hasClass('collapsed')) {
		//get the table outerHeight
		/*var new_height= box.find('.header').outerHeight() + box.find('.children').outerHeight();
		
		box.stop().animate({height:new_height},{easing:'easeOutBounce', complete: function(){box.css('height', 'auto');}});
		*/
		box.siblings().removeAttr('style');
		box.removeClass('collapsed');
		
		var img_src= $(button).find('img').attr('src');
		img_src= img_src.replace('expand', 'collapse');
		$(button).find('img').attr('src', img_src);
	} else {
		//box.stop().animate({height:box.find('.header').outerHeight()},{easing:'easeOutBounce'});
		box.siblings().css('display', 'none');
		box.addClass('collapsed');
		
		var img_src= $(button).find('img').attr('src');
		img_src= img_src.replace('collapse', 'expand');
		$(button).find('img').attr('src', img_src);
		state = 'close';
	}
	
	pathOpenStateRequest[section_id] = $.ajax({
		url: urlState+'/'+state	
	});
}

function toggleFriendlyPermission(urlToggle) {
	show_loading();
	$.ajax({	
		url: urlToggle,
		cache: false,
		success: function (m) {
			hide_loading();
			$('#full_permissions_inner').html(m);
		},
		complete: function() {
		},
		error: function(jqXHR, textStatus, errorThrown) {
			hide_loading();
			handle_error(errorThrown);
		}
	});
}

function toggleFriendlyPathPermission(urlToggle, path) {
	show_loading();
	$.ajax({	
		url: urlToggle,
		cache: false,
		type: 'POST',
		data: 'data[path]='+path,
		success: function (m) {
			hide_loading();
			$('#full_permissions_inner').html(m);
		},
		complete: function() {
		},
		error: function(jqXHR, textStatus, errorThrown) {
			hide_loading();
			handle_error(errorThrown);
		}
	});
}

/**
 * 
 */
function removePathFromItem(urlRemove) {
	show_loading();
	$.ajax({
		type: 'POST',
		url: urlRemove,
		dataType: 'json',
		cache: false,
		success: function(m) {
			hide_loading();
			if (m['status']) {
				$('#fp_path_'+m['id']+' .crud_button.remove_path').qtip('hide');
				$('#fp_path_'+m['id']).qtip('hide');
				$('#fp_path_'+m['id']).detach();
				
				if (!m['isRelated']) {
					$('#'+m['divPathId']).removeClass('related');
				}
			}
		},
		error:function (XMLHttpRequest, textStatus, errorThrown) {
			handle_error(errorThrown);
		}
	});	
}
