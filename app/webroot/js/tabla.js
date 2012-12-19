var filtrar_request= new Array();
function filtrar(padre, url_base)
{
    if(typeof filtrar_request[padre]=="object")
    filtrar_request[padre].abort();
    
    var cadena_paginator= get_extra_url_params(padre);
    
    //Ahora necesito sacar todos los valores que haya en los filtros
    var data= "";
    $("#"+padre+" .filter").each(
        function(){
        	var name= $(this).attr("name");
            data+=name+"="+$(this).val()+"&";
            
            if(!$(this).hasClass("extra") && !$(this).hasClass("daterange")){
            	name= name.replace("Filters", "CustomTableHighlights");
            	data+=name+"="+$(this).attr("hl_index")+"&";	
            }
        }
    );
    show_loading();
    filtrar_request[padre]= $.ajax({
            url: url_base+"/"+cadena_paginator,
            data: data,
            type: "POST",
			cache: false,
            success: function(m)
            {
                $("#"+padre+" table tbody").html(m);
                hide_loading();
                
    			if(typeof limit_change!="undefined")
    			{
    				$("#"+padre).find(".input_limit").focus();
    				var val = $("#"+padre).find(".input_limit").val();
    				$("#"+padre).find(".input_limit").val("");
    				$("#"+padre).find(".input_limit").val(val);  
    			}
            },
            error: function(jqXHR, textStatus, errorThrown)
			{
				hide_loading();
				handle_error(errorThrown);
			}
        }
    );
}

function change_limit_link(padre, url_base, new_limit){
	if(typeof filtrar_request[padre]=="object")
    filtrar_request[padre].abort();
    
    var cadena_paginator= get_extra_url_params(padre);
    cadena_paginator= cadena_paginator.replace(/limit:\d*/, "");
    cadena_paginator+= "limit:"+new_limit;
    
    show_loading();
    filtrar_request[padre]= $.ajax({
        url: url_base+"/"+cadena_paginator,
        type: "POST", 
		cache: false,
        success: function(m){
        	hide_loading();
            $("#"+padre).html(m);
        },
        error: function(jqXHR, textStatus, errorThrown){
			hide_loading();
			handle_error(errorThrown);
		}
	});
}

function change_limit(padre, url_base)
{
	if(typeof filtrar_request[padre]=="object")
    filtrar_request[padre].abort();
    
    var cadena_paginator= get_extra_url_params(padre);
    filtrar_request[padre]= $.ajax
    (
        {
            url: url_base+"/"+cadena_paginator,
            type: "POST", 
			cache: false,
            success: function(m)
            {
                $("#"+padre).html(m);
				$("#"+padre).find(".input_limit").focus();
				var val = $("#"+padre).find(".input_limit").val();
				$("#"+padre).find(".input_limit").val("");
				$("#"+padre).find(".input_limit").val(val);
            },
            error: function(jqXHR, textStatus, errorThrown)
			{
				hide_loading();
				handle_error(errorThrown);
			}
        }
    );
}

function submit_limit_form(formulario)
{	
	formulario= $(formulario);
	
	//Borro el limite del formulario
	formulario.attr("action", formulario.attr("action").replace(/\/limit:\d*/, ""));
	
	//Encuentro el nuevo limite
	var cadena_limit= "";
	var limit= formulario.find(".input_limit").val();
	limit= parseInt(limit);
    if(!isNaN(limit) && typeof limit==="number")
    cadena_limit= "limit:"+limit;
    
    formulario.attr("action", formulario.attr("action")+"/"+cadena_limit);
}

/*
 * This script is made to add the limit and the sort params to the export links 
 * */

function get_extra_url_params(padre)
{
	var asc=  $("#"+padre).find("a.asc");
    var desc= $("#"+padre).find("a.desc");
        
    var ordenar= false;        
    if(asc.length>0){
        ordenar= true;
        direction= "asc";
        
        campo= asc.attr("href").split("sort")[1].split(":")[1].split("/")[0];
    }else{
        if(desc.length>0){
            ordenar= true;
            direction= "desc";
            
            campo= desc.attr("href").split("sort")[1].split(":")[1].split("/")[0];
        }
    }
    
    var cadena_ordenar="";
    if(ordenar)
    cadena_ordenar= "sort:"+campo+"/direction:"+direction;
    
    //Ahora necesito saber cual es el limite
    var cadena_limit= "";
    
    //If the limit is the form
    //var limit= $("#"+padre).find(".input_limit").val();
    //If the limit is the link
    var limit= $("#"+padre).find(".current_limit").html();
    limit= parseInt(limit);
    if(!isNaN(limit) && typeof limit==="number")
    cadena_limit= "limit:"+limit;
    
    var cadena_paginator="";
    if(cadena_ordenar.length>0)
    cadena_paginator= cadena_ordenar+"/"+cadena_limit;
    else
    cadena_paginator= cadena_limit;
    
    return cadena_paginator;
}

/*
 * Function to add the limit and sort params to link's href
 */
function add_url_params(link, padre){
	link= $(link);

	//Primero elimino el limit y el limit si lo tiene
	link.attr("href", link.attr("href").replace(/\/limit:\d*/, ""));
	
	//Ahora elimino el sort
	link.attr("href", link.attr("href").replace(/\/sort:[^\.\/]*\.[^\.\/]*/, ""));
	
	//Ahora elimino el direction
	link.attr("href", link.attr("href").replace(/\/direction:[^\/]*/, ""));
	
	extra_params= get_extra_url_params(padre);
	link.attr("href", link.attr("href")+"/"+extra_params);
}
var x;
var date_ranges_request = new Array();
function initialize_date_filter(initial_id, final_id, type, parent_div, url_filter, app_base_url, min_val, max_val, date_labels) {
	if(type=='initial'){
		selector = "#"+initial_id;
	} else {
		selector = "#"+final_id;
	}
	
	if(min_val=='' || type=='initial') {
		min_val = null;
	}
	if(max_val=='' || type=='final'){
		max_val = null;
	}
	$("#"+parent_div+" "+selector).datepicker({ 
		dateFormat: "mm-dd-yy",
		changeMonth: true,
		changeYear: true,
		yearRange: '-20:+20',
		showOn: "button",
		buttonImage: app_base_url+"img/date_filter/"+type+".png",
		buttonImageOnly: true,
		showButtonPanel: true,
		minDate: min_val,
		maxDate: max_val,
		onSelect: function(dateText, instance){
			if(type=='initial'){
				reset_qtip(parent_div, final_id, 'minDate', dateText, date_labels['final'], 'right');
			} else {
				reset_qtip(parent_div, initial_id, 'maxDate', dateText, date_labels['initial'], 'left');
			}
			filtrar(parent_div, url_filter);
			
			$(this).next().qtip('option', 'content.text', dateText);
			if(typeof date_ranges_request[parent_div]=="object"){
    			date_ranges_request[parent_div].abort();
    		}
    		
    		$(this).parents('th').first().addClass('date_filtered_column');
		},
		beforeShow: function( input ) {
			setTimeout(function() {
				var buttonPane = $( input ).datepicker( "widget" ).find( ".ui-datepicker-buttonpane" );
				var btn = $('<button class="ui-datepicker-current ui-state-default ui-priority-secondary ui-corner-all" type="button">Clear</button>');  
		   		btn.unbind("click").bind("click", function () {  
		    		$.datepicker._clearDate( input );
		    		var parent_th = $(input).parents('th').first();
		    		
		    		var remove_date_filtered_class = true;
		    		parent_th.find('input').each(function() {
		    			if($(this).val() != '') {
		    				remove_date_filtered_class = false;
		    			}
		    		});
		    		if(remove_date_filtered_class) {
		    			$(input).parents('th').first().removeClass('date_filtered_column');
		    		}
		    		
		    		if(type=='initial'){
		    			reset_qtip(parent_div, final_id, 'minDate', null, date_labels['final'], 'right');
					} else {
						reset_qtip(parent_div, initial_id, 'maxDate', null, date_labels['initial'], 'left');
					}
					$(input).next().qtip('option', 'content.text', '...');
		  		});  
		  		btn.appendTo( buttonPane );  
		 	}, 1);  
		}  
	});
}

function reset_qtip(parent_div, input_id, datepicker_limit_option, datepicker_limit_value, qtip_title_label, img_align) {
	var qtip_options;
	$("#"+parent_div+" #"+input_id).datepicker( "option", datepicker_limit_option, datepicker_limit_value);
						
	//For some reason, after changing the option, the image is reloaded, so we need to add the qtip and align again
	qtip_options = new Array();
	qtip_options['position']= {'my':'bottom center', 'at':'top center'};
	if($("#"+parent_div+" #"+input_id).val()=='') {
		date_label = '';
	} else {
		date_label = $("#"+parent_div+" #"+input_id).val();
	}
	qtip_options['content'] = { 'title': qtip_title_label, 'text': date_label};
	$("#"+parent_div+" #"+input_id).next().qtip(qtip_options);
	$("#"+parent_div+" #"+input_id).next().css('float', img_align);
}

function clear_filters(parent_div, filter_url, date_labels){
	$('#'+parent_div+' .filter').val('');
	filtrar(parent_div, filter_url);
	
	//I need to remove the qtip from the datepicker buttons
	$('#'+parent_div+' .filter.hasDatepicker.initial').each(function(){
		$(this).next().qtip('option', 'content.text', '...');
	});
	
	$('#'+parent_div+' .filter.hasDatepicker.final').each(function(){
		$(this).next().qtip('option', 'content.text', '...');
	});
	
	$('th.date_filtered_column').each(function(){$(this).removeClass('date_filtered_column')});
	highlight_date_filtered_column(parent_div);
}

function highlight_date_filtered_column(parent_div){
	var columns_to_highlight = new Array();
	$('th.date_filtered_column').each(function(){
		var iterator = 0;
		$(this).parent().find('th').each(function(){
			if($(this).hasClass('date_filtered_column')) {
				columns_to_highlight.push(iterator);
			}
			iterator++;
		});
	});
	
	$(columns_to_highlight).each(function(){
		var column= this;
		$("#"+parent_div+" tbody tr").each(function(){
			$($(this).find("td")[column]).css('background-color', '#FFFFA1');
		});
	});
}

function add_date_filtered_class_to_column(parent_div, column){
	$($("#"+parent_div+" table thead tr").last().find("th")[column]).addClass("date_filtered_column");
}
