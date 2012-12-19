$(document).ready
(
	function()
	{
		$("#menu ul li").click
		(
			function()
			{
				if($(this).hasClass("inactivo"))
				{
					var padre= $(this).parent();
					
					var activo= padre.find("li.activo");
					activo.addClass("inactivo");
					activo.removeClass("activo");
					activo.attr("style", "");
					
					$(this).removeClass("inactivo");
					$(this).addClass("activo");
					
					var m_id= $(this).attr("id").split("_")[1];
					
					//Ahora voy a buscar los submenues y los oculto
					$("#menu2 ul").hide();
					
					//Y muestro el submenu del actual
					$("#m2_"+m_id).show();
					
					//Ahora, si dentro de este submenu que desplego hay alguno activo, entonces muestro su subsubmenu.
					var activo= $("#m2_"+m_id).find("li.activo");
					if(activo.length>0)
					{
						var id_activo= activo.attr("id").split("_")[1];
						
						$("#submenu ul").hide();
						$("#m4_"+id_activo).show();
					}
					
					else
					$("#submenu ul").hide();
				}
			}
		);
		
		$("#menu2 ul li").click
		(
			function()
			{
				if($(this).hasClass("inactivo"))
				{
					var padre= $(this).parent();
					
					var activo= padre.find("li.activo");
					activo.addClass("inactivo");
					activo.removeClass("activo");
					activo.attr("style", "");
					
					$(this).removeClass("inactivo");
					$(this).addClass("activo");
					
					var m_id= $(this).attr("id").split("_")[1];
					
					//Ahora voy a buscar los submenues y los oculto
					$("#submenu ul").hide();
					
					//Y muestro el submenu del actual
					$("#m4_"+m_id).show();
					
				}
				
				$("#show").click();
			}
		);
		
		$("#hide").click
		(
			function()
			{
				$("#content").animate({marginLeft: "10px"}, 100);
				$("#titulo").animate({marginLeft: "10px"}, 100);
				$("#submenu").animate({left: "-156px"}, 100);
				
				$("#show").show();
				$(this).hide();
			}
		);
		
		$("#show").click
		(
			function()
			{
				$("#content").animate({marginLeft: "146px"}, 100);
				$("#titulo").animate({marginLeft: "146px"}, 100);
				$("#submenu").animate({left: "0px"}, 100);
				
				$("#hide").show();
				$(this).hide();
			}
		);
		
		
		$(".bouncebox").bounceBox();
		$(".bouncebox").show();
		$(".bouncebox").click
		(
			function(e)
			{
				$(this).bounceBoxHide();
				e.preventDefault();
			}
		);
	}
);

function show_loading()
{
	$("#loading_container").show();
}

function hide_loading()
{
	$("#loading_container").hide();
}

function lock_dialog(dialog_id)
{
	if(typeof dialog_id == "undefined"){
		dialog_id= "my_dialog"; 
	}
	
	$("#"+dialog_id).find(".dialog_shadow").detach();
	
	var h= $("#"+dialog_id).height();
	var w= $("#"+dialog_id).width();
	$("#"+dialog_id).prepend("<div class='dialog_shadow' style='height: "+h+"px; width: "+w+"px'></div>");
}

function handle_error(errorThrown)
{
	if(errorThrown=="Forbidden")
	document.location.reload();
}

function display_bouncebox_message(box_id, message, delay, duration)
{
	setTimeout('$("#'+box_id+'").html("'+message+'");$("#'+box_id+'").bounceBoxToggle();', delay);
	setTimeout('$("#'+box_id+'").bounceBoxHide();', duration);
}

function get_ckeditor_values(ids)
{
	$(ids).each
	(
		function()
		{
			var instance = CKEDITOR.instances[this];
			$("#"+this).val(instance.getData());
		}
	);
}

function initialize_basic_datepicker2(selector)
{
    $(selector).keydown(function(){ return false; });
    
        $(selector).datepicker
        (
                { 
                        dateFormat: "mm-dd-yy",
                        changeMonth: true,
                        changeYear: true,
                        yearRange: 'c-5:c+5',
                        showButtonPanel: true
                }
        );
        
        $('button.ui-datepicker-current').live('click', function() {
    		$.datepicker._curInst.input.datepicker('setDate', new Date()).datepicker('hide').blur();
		});
}

function initialize_basic_datepicker(selector)
{
	$(selector).keydown(function(){ return false; });
	
	$(selector).datepicker
	(
		{ 
			dateFormat: "mm-dd-yy",
			changeMonth: true,
			changeYear: true,
			yearRange: 'c-10:c',
			showButtonPanel: true
		}
	);
	
	$('button.ui-datepicker-current').live('click', function() {
    	$.datepicker._curInst.input.datepicker('setDate', new Date()).datepicker('hide').blur();
	});
}

function initialize_basic_timepicker(selector, options)
{
    $(selector).keydown(function(event){
        
        var key_code = event.keyCode;
        
        var time = $(selector).val();
        var array = time.split(':');
        var sec = array[1];
        var minutes_arr = sec.split(' ');
        var minutes = parseInt(minutes_arr[0], '10');
        var ampm = "";
        
        if( typeof minutes_arr[1] != "undefined" )
            ampm = " " + minutes_arr[1];
        
        if(key_code == 38)
        {
            if(minutes < 59)
            {
                minutes = minutes + 1;
                var o = minutes.toString();
                s = '0';
                if(o.length == 1) {
                    o = s + o;
                }
                $(selector).val(array[0] + ":" + o + ampm);
            }
            else
            {
                $(selector).val(array[0] + ":00" + ampm);
            }
        }
        
        if(key_code == 40)
        {
            if(minutes > 0)
            {
                minutes = minutes - 1;
                var o = minutes.toString();
                s = '0';
                if(o.length == 1) {
                    o = s + o;
                }
                $(selector).val(array[0] + ":" + o + ampm);
            }
            else
            {
                $(selector).val(array[0] + ":59" + ampm);
            }
        }
            
        
        return false;
            
    });
    
        $(selector).timepicker
        (
                options
        );
}

/****TIMEPICKER RANGE******/

function tpStartOnHourShowCallback(hour) {
    var tpEndHour = $('#DayCheckout').timepicker('getHour');
    // Check if proposed hour is prior or equal to selected end time hour
    if (hour <= tpEndHour) { return true; }
    // if hour did not match, it can not be selected
    return false;
}
function tpStartOnMinuteShowCallback(hour, minute) {
    var tpEndHour = $('#DayCheckout').timepicker('getHour');
    var tpEndMinute = $('#DayCheckout').timepicker('getMinute');
    // Check if proposed hour is prior to selected end time hour
    if (hour < tpEndHour) { return true; }
    // Check if proposed hour is equal to selected end time hour and minutes is prior
    if ( (hour == tpEndHour) && (minute < tpEndMinute) ) { return true; }
    // if minute did not match, it can not be selected
    return false;
}

function tpEndOnHourShowCallback(hour) {
    var tpStartHour = $('#DayCheckin').timepicker('getHour');
    // Check if proposed hour is after or equal to selected start time hour
    if (hour >= tpStartHour) { return true; }
    // if hour did not match, it can not be selected
    return false;
}
function tpEndOnMinuteShowCallback(hour, minute) {
    var tpStartHour = $('#DayCheckin').timepicker('getHour');
    var tpStartMinute = $('#DayCheckin').timepicker('getMinute');
    // Check if proposed hour is after selected start time hour
    if (hour > tpStartHour) { return true; }
    // Check if proposed hour is equal to selected start time hour and minutes is after
    if ( (hour == tpStartHour) && (minute > tpStartMinute) ) { return true; }
    // if minute did not match, it can not be selected
    return false;
}


function remove_row(button)
{
  if(confirm('Are you sure?'))
  {
	$(".crud_button.remove").qtip("hide");
	
	//Need to find the parent table
	var parent_table= $(button).parents("table").first();
	
	//Remove the row
	$(button).parents("tr").first().detach();
	
	//Need to mark the class of the tr with the td.no_item_td
	parent_table.find("td.no_item_td").parent().addClass("no_item_tr");
	
	//Need to find the tr without the class no_item_tr
	if(parent_table.find("tbody tr:not(.no_item_tr)").size()==0){
		
		parent_table.find("tr.no_item_tr").show();
	}
  }
}

function initialize_shortcut_menu(shortcut_id, parent_div){
	$("#"+shortcut_id).contextMenu({
			menu: 'shortcuts_menu'
		},
		function(action, element, pos){
			if(action=="edit"){
				eval($("#"+shortcut_id).attr(action));
			}
			if(action=="delete"){
				if(confirm('Are you sure you want to delete this Shortcut from database?')){ 
					show_loading();
					$.ajax({
							url: $("#"+shortcut_id).attr("delete_url"),
							cache: false,
							success: function(m){
								hide_loading();
								$("#"+parent_div).html(m);
							}
						}
					); 
				}else{ 
					return false; 
				}
			}
			if(action=="sort"){
				var editor_instance= $("#"+shortcut_id).attr("editor_instance");
				
				$("#add_"+editor_instance).parent().hide();
				$("#save_order_"+editor_instance).parent().show();
				$("#my_shortcuts_buttons_"+editor_instance).sortable("enable");
				$("#my_shortcuts_buttons_"+editor_instance).find("div.sc_button_shortcut").addClass("sorting");
				$("#my_shortcuts_buttons_"+editor_instance).find("img.handle_image").css("display", "inline-block");
			}
		}
	);
}

function initialize_accept_suggestion_menu(suggestion_id){
	$("#"+suggestion_id).contextMenu({
			menu: 'accept_suggestion_menu',
			mouseButton: "left"
		},
		function(action, element, pos){
			eval($("#"+suggestion_id).attr(action));
		}
	);
}


function configureHtmlOutput( ev ){
	var editor = ev.editor,
		dataProcessor = editor.dataProcessor,
		htmlFilter = dataProcessor && dataProcessor.htmlFilter;

	// Output properties as attributes, not styles.
	htmlFilter.addRules(
		{
			elements :
			{
				$ : function( element )
				{
					// Output dimensions of images as width and height
					if ( element.name == 'img' ){
						var style = element.attributes.style;

						if ( style ){
							// Get the width from the style.
							var match = /(?:^|\s)width\s*:\s*(\d+)px/i.exec( style ),
								width = match && match[1];

							// Get the height from the style.
							match = /(?:^|\s)height\s*:\s*(\d+)px/i.exec( style );
							var height = match && match[1];

							if ( width ){
								element.attributes.style = element.attributes.style.replace( /(?:^|\s)width\s*:\s*(\d+)px;?/i , '' );
								element.attributes.width = width;
							}

							if ( height ){
								element.attributes.style = element.attributes.style.replace( /(?:^|\s)height\s*:\s*(\d+)px;?/i , '' );
								element.attributes.height = height;
							}
						}
					}

					// Output alignment of paragraphs using align
					if ( element.name == 'p' ){
						style = element.attributes.style;

						if ( style ){
							// Get the align from the style.
							match = /(?:^|\s)text-align\s*:\s*(\w*);/i.exec( style );
							var align = match && match[1];

							if ( align ){
								element.attributes.style = element.attributes.style.replace( /(?:^|\s)text-align\s*:\s*(\w*);?/i , '' );
								element.attributes.align = align;
							}
						}
					}

					if ( !element.attributes.style )
						delete element.attributes.style;

					return element;
				}
			}
		} );
}


function disableShortcuts()
{
  
}

/*******SELECT ALL DEFAULT  hanmuja*******/
function reload_all()
{
    var all = $(".all :checkbox");
    var checked_state = true;
    all.each(
        function()
        {
            if(!$(this).is(":checked"))
                checked_state = false;
        }
    );
    
    $("#check_all").attr("checked", checked_state);
}

function click_all()
{
    var checked_state = true;
    if(!$("#check_all").is(":checked"))
        checked_state = false;
    
    var all = $(".all :checkbox");
    all.each(
        function()
        {
            $(this).attr("checked", checked_state);
        }
    );
}

/*******SELECT ALL FOR FORMS OVER ANOTHER FORMS WITH SELECT ALL (checkboxes shortcuts) hanmuja***/

function reload_all2(id_all, class_item)
{
    var all = $("." + class_item + " :checkbox");
    var checked_state = true;
    all.each(
        function()
        {
            if(!$(this).is(":checked"))
                checked_state = false;
        }
    );
    
    $("#" + id_all).attr("checked", checked_state);
}

function click_all2(id_all, class_item)
{
    var checked_state = true;
    if(!$("#" + id_all).is(":checked"))
        checked_state = false;
    
    var all = $("." + class_item + " :checkbox");
    all.each(
        function()
        {
            $(this).attr("checked", checked_state);
        }
    );
}

function initialize_input_delete()
{
	$(".clean_input").detach();
	
	$(".input_delete").append('<span class="two_column clean_input"></span>');
	
	$(".clean_input").click(function(){
		var obj = $(this).parent('.input_delete');
		$(obj).find(':input').val('');
	});
}

function initialize_change_minutes(selector)
{
	var div_parent = $(selector).parent('div');
	//$(div_parent).append('<span class="two_column"><img src="img/green-up-arrow.gif" alt="UP" onclick="up_minutes(\'' + selector + '\')"><img src="img/green-down-arrow.gif" alt="DOWN" onclick="down_minutes(\'' + selector + '\')"></span>');
	$(div_parent).append('<span class="two_column up_down_minutes"><div class="up_minutes" onclick="up_minutes(\'' + selector + '\')"></div><div class="down_minutes" onclick="down_minutes(\'' + selector + '\')"></div></span>');
}

function up_minutes(selector)
{
	var time = $(selector).val();
    var array = time.split(':');
    var sec = array[1];
    var minutes_arr = sec.split(' ');
    var minutes = parseInt(minutes_arr[0], '10');
    var ampm = "";
    
    if( typeof minutes_arr[1] != "undefined" )
        ampm = " " + minutes_arr[1];
        
    if(minutes < 59)
    {
        minutes = minutes + 1;
        var o = minutes.toString();
        s = '0';
        if(o.length == 1) {
            o = s + o;
        }
        $(selector).val(array[0] + ":" + o + ampm);
    }
    else
    {
        $(selector).val(array[0] + ":00" + ampm);
    }
}

function down_minutes(selector)
{
	var time = $(selector).val();
    var array = time.split(':');
    var sec = array[1];
    var minutes_arr = sec.split(' ');
    var minutes = parseInt(minutes_arr[0], '10');
    var ampm = "";
    
    if( typeof minutes_arr[1] != "undefined" )
        ampm = " " + minutes_arr[1];
	
	if(minutes > 0)
	{
	    minutes = minutes - 1;
	    var o = minutes.toString();
	    s = '0';
	    if(o.length == 1) {
	        o = s + o;
	    }
	    $(selector).val(array[0] + ":" + o + ampm);
	}
	else
	{
	    $(selector).val(array[0] + ":59" + ampm);
	}
}

function hidden_down_div(selector, id_div)
{
	if($("#" + selector).is(":checked"))
	{
		$("#" + id_div).hide('slow');
	}
	else
		$("#" + id_div).show('slow');
}
