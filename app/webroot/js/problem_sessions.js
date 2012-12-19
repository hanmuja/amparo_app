function toggle_session_box(button, session_id)
{
	if($("#session_div_"+session_id).hasClass("session_collapsed"))
	{
		//get the table outerHeight
		var new_height= $("#session_"+session_id).outerHeight();
		
		$("#session_div_"+session_id).stop().animate({height:new_height},{easing:'easeOutBounce'});
		$("#session_div_"+session_id).removeClass("session_collapsed");
		
		var img_src= $(button).find("img").attr("src");
		img_src= img_src.replace("expand", "collapse");
		$(button).find("img").attr("src", img_src);
	}
	else
	{
		$("#session_div_"+session_id).stop().animate({height:50},{easing:'easeOutBounce'});
		$("#session_div_"+session_id).addClass("session_collapsed");
		
		var img_src= $(button).find("img").attr("src");
		img_src= img_src.replace("collapse", "expand");
		$(button).find("img").attr("src", img_src);
	}
}

function toggle_problem_box(button)
{
	if($("#problem_main_div").hasClass("problem_collapsed"))
	{
		//get the table outerHeight
		var new_height= $("#problem_table").outerHeight();
		
		$("#problem_main_div").stop().animate({height:new_height},{easing:'easeOutBounce'});
		$("#problem_main_div").removeClass("problem_collapsed");
		
		var img_src= $(button).find("img").attr("src");
		img_src= img_src.replace("expand", "collapse");
		$(button).find("img").attr("src", img_src);
	}
	else
	{
		$("#problem_main_div").stop().animate({height:90},{easing:'easeOutBounce'});
		$("#problem_main_div").addClass("problem_collapsed");
		
		var img_src= $(button).find("img").attr("src");
		img_src= img_src.replace("collapse", "expand");
		$(button).find("img").attr("src", img_src);
	}
}
