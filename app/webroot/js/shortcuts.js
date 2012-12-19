function add_shortcut_timestamp(ck_instance, url)
{	
	show_loading();
	$.ajax
	(
		{
            url: url,
            type: "POST",
			cache: false,
            success: function(m)
            {
            	hide_loading();
                var instance = CKEDITOR.instances[ck_instance];
                if(instance)
				{
				    instance.insertHtml(m);
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

function add_shortcut_text(message, ck_instance)
{
	var instance = CKEDITOR.instances[ck_instance];
    if(instance)
	{
	    instance.insertHtml(message);
	}
}

function add_shortcut_text_ajax(shortcut_id, ck_instance, url)
{
	show_loading();
	$.ajax
	(
		{
            url: url,
            type: "POST",
			cache: false,
            success: function(m)
            {
            	hide_loading();
                var instance = CKEDITOR.instances[ck_instance];
                if(instance)
				{
				    instance.insertHtml(m);
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

function setup_sortable(editor_instance, img_url){
	var handle_image= $("<img/>");
	handle_image.attr("src", img_url);
	handle_image.attr("align", "absmiddle");
	handle_image.addClass("handle_image");
	
	$("#my_shortcuts_buttons_"+editor_instance+" .sc_button_shortcut").each(function(){
		$(this).prepend(handle_image.clone());
	});
	
	$("#my_shortcuts_buttons_"+editor_instance).sortable({
		containment: "parent"
	});
	
	$("#my_shortcuts_buttons_"+editor_instance).sortable("disable");
}

function save_shortcuts_order(editor_instance, save_order_url){
	show_loading();
	$.ajax({
		data:get_sort_data_string(editor_instance), 
		dataType:"html", 
		error:function (XMLHttpRequest, textStatus, errorThrown){
			hide_loading();
			handle_error(errorThrown);
		}, 
		success:function (data, textStatus){
			hide_loading();
			$("#add_"+editor_instance).parent().show();
			$("#save_order_"+editor_instance).parent().hide();
			$("#my_shortcuts_buttons_"+editor_instance).sortable("disable");
			$("#my_shortcuts_buttons_"+editor_instance).find("div.sc_button_shortcut").removeClass("sorting");
			$("#my_shortcuts_buttons_"+editor_instance).find("img.handle_image").css("display", "none");
		}, 
		type:"post", 
		url:save_order_url
	});
}

function get_sort_data_string(editor_instance){
	var data="";
	$("#my_shortcuts_buttons_"+editor_instance).find("div div").each(function(){
		var current_id= $(this).attr("id")+" ";
		var current_db_id= current_id.split("shortcut_")[1].split("_"+editor_instance)[0];
		data+="&data[Order]["+current_db_id+"]=1";
	});
	return data;
}
