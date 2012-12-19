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