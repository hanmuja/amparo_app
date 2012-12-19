/**
 * FILEMANAGER INPUT
 * @param {Object} id
 * @param {Object} id_users_select
 * @param {Object} url_base
 */

 function OpenServerBrowser( url, width, height )
 {
      var iLeft = (screen.width - width) / 2 ;
      var iTop = (screen.height - height) / 2 ;
      var sOptions = "toolbar=no,status=no,resizable=yes,dependent=yes" ;
      sOptions += ",width=" + width ;
      sOptions += ",height=" + height ;
      sOptions += ",left=" + iLeft ;
      sOptions += ",top=" + iTop ;
      var oWindow = window.open( url, "BrowseWindow", sOptions ) ;
 }

 function SetUrl( url, width, height, alt )
 {
      document.getElementById(urlobj).value = url ;
      oWindow = null;
 }

/*********end*****/


function select_users_by_group(id, id_users_select, url_base)
{
  var checked = 0;
  if($("#"+id).is(":checked"))
  {
    checked=1;
  }
  
  var value = $("#"+id).val();
  
  if(checked == 0)
  {
    $.post(url_base, { group_id: value }, function(data){
      $.each(data, function(user_id){
	$("#"+id_users_select+' option[value='+user_id+']').attr('selected', false);
      });
    }, "json");
  }
  
  $(".EventGroupc").each(function(a, objx){ 
    var selected = $(objx);
    if(selected.is(":checked"))
    {
      $.post(url_base, { group_id: selected.val() }, function(data){
	$.each(data, function(user_id){
	  $("#"+id_users_select+' option[value='+user_id+']').attr('selected', true);
	});
      }, "json");
    } 
    
  });
}


function check_all_day()
{
	var all_day = $("#EventAllDay").is(":checked");
	
	if(all_day)
	{
		$("#start_time").hide();
		$("#end_time").hide();
	}
	else
	{
		$("#start_time").show();
		$("#end_time").show();
	}
}
