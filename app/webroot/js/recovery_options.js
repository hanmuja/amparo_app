function show_selected_recovery_option()
{
	var checked= $(".recovery_option:checked");
	$(".div_recovery_form").hide();
	$("#div_"+checked.attr("id")).show();
}
