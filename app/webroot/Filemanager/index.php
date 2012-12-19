<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>File Manager</title>
<link rel="stylesheet" type="text/css" href="styles/reset.css" />
<link rel="stylesheet" type="text/css" href="scripts/jquery.filetree/jqueryFileTree.css" />
<link rel="stylesheet" type="text/css" href="scripts/jquery.contextmenu/jquery.contextMenu-1.01.css" />
<link rel="stylesheet" type="text/css" href="styles/filemanager.css" />
<!--[if IE]>
<link rel="stylesheet" type="text/css" href="styles/ie.css" />
<![endif]-->
</head>
<body>
<div>
<form id="uploader" method="post">
<button id="home" name="home" type="button" value="Home">&nbsp;</button>
<h1></h1>
<div id="uploadresponse"></div>
<input id="mode" name="mode" type="hidden" value="add" /> 
<input id="currentpath" name="currentpath" type="hidden" /> 
<input	id="newfile" name="newfile" type="file" />
<button id="upload" name="upload" type="submit" value="Upload"></button>
<button id="newfolder" name="newfolder" type="button" value="New Folder"></button>
<button id="grid" class="ON" type="button">&nbsp;</button>
<button id="list" type="button">&nbsp;</button>
</form>

<div id="select_folder_permission" style="width: 100%;" >
	<label for="folders">Select Starting Folder:</label>
	<select id="folders" style="min-width:200px; margin-bottom: 10px;">
	<?php
	$folders_encode = $_GET['folders'];
	$folders = json_decode(str_replace("'", "", $folders_encode), true);
	
	$user_id = $_GET['id'];
	
	if(count($folders) == 0)
	{
		?>
		<script>
			alert("You don't have access to this server.");
			window.close();
		</script>
		<?php
	}
	
	foreach($folders as $folder)
	{
		$folder_name = $folder['Folders']['folder'];
		if(isset($_POST['fileRoot']))
			if($_POST['fileRoot'] == $folder_name)
				echo "<option value='$folder_name' selected='selected'>$folder_name</option>";
			else
				echo "<option value='$folder_name'>$folder_name</option>";
		else
			echo "<option value='$folder_name'>$folder_name</option>";
	}
	?>
	</select>
</div>


<div id="splitter">
<div id="filetree"></div>
<div id="fileinfo">
<h1></h1>
</div>
</div>

<ul id="itemOptions" class="contextMenu">
	<li class="select"><a href="#select"></a></li>
	<li class="download"><a href="#download"></a></li>
	<li class="rename"><a href="#rename"></a></li>
	<li class="delete separator"><a href="#delete"></a></li>
</ul>

<script type="text/javascript" src="scripts/jquery-1.6.1.min.js"></script>
<script type="text/javascript" src="scripts/jquery.form-2.63.js"></script>
<script type="text/javascript" src="scripts/jquery.splitter/jquery.splitter-1.5.1.js"></script>
<script type="text/javascript" src="scripts/jquery.filetree/jqueryFileTree.js"></script>
<script type="text/javascript" src="scripts/jquery.contextmenu/jquery.contextMenu-1.01.js"></script>
<script type="text/javascript" src="scripts/jquery.impromptu-3.1.min.js"></script>
<script type="text/javascript" src="scripts/jquery.tablesorter-2.0.5b.min.js"></script>
<?php /*<script type="text/javascript" src="scripts/filemanager.config.js"></script> */ ?>

<?php /**Filemanager config manual by hanmuja */ ?>



<script type="text/javascript">
/*---------------------------------------------------------
  Configuration
---------------------------------------------------------*/

// Set culture to display localized messages
var culture = 'en';

// Set default view mode : 'grid' or 'list'
var defaultViewMode = 'grid';

// Autoload text in GUI - If set to false, set values manually into the HTML file
var autoload = true;

// Display full path - default : false
var showFullPath = false;

// Browse only - default : false
var browseOnly = true;

/**
 * Vars to permissions - create - delete - rename - select Folder
 * @hanmuja
 */
<?php
include('../tools/filemanager/class/acl_manager.php');
$can_create = false;
$can_remove = false;
$can_rename = false;
//$select_folder = false;
$can_download = false;
$can_upload = false;

if (getPermission(array('plugin'=>null, 'controller'=>'Folders', 'action'=>'create_folder'), $user_id, 'User')) $can_create = true;
if (getPermission(array('plugin'=>null, 'controller'=>'Folders', 'action'=>'rename_folder'), $user_id, 'User')) $can_rename = true;
if (getPermission(array('plugin'=>null, 'controller'=>'Folders', 'action'=>'remove_folder'), $user_id, 'User')) $can_remove = true;
//if (getPermission(array('plugin'=>null, 'controller'=>'Folders', 'action'=>'select_folder'), $user_id, 'User')) $select_folder = true;
if (getPermission(array('plugin'=>null, 'controller'=>'Folders', 'action'=>'can_download'), $user_id, 'User')) $can_download = true;
if (getPermission(array('plugin'=>null, 'controller'=>'Folders', 'action'=>'can_upload'), $user_id, 'User')) $can_upload = true;
?>

var can_create = <?php echo $can_create ? 'true' : 'false' ?>;
var can_remove = <?php echo $can_remove ? 'true' : 'false' ?>;
var can_rename = <?php echo $can_rename ? 'true' : 'false' ?>;
var select_folder = true;
var can_download = <?php echo $can_download ? 'true' : 'false' ?>;
var can_upload = <?php echo $can_upload ? 'true' : 'false' ?>;

// Set this to the server side language you wish to use.
var lang = 'php'; // options: php, jsp, lasso, asp, cfm, ashx, asp // we are looking for contributors for lasso, python connectors (partially developed)

var am = document.location.pathname.substring(1, document.location.pathname.lastIndexOf('/') + 1);

// Set this to the directory you wish to manage.
var fileRoot = '/files' + $("#folders").val() + '/';

//Path to the manage directory on the HTTP server
var relPath = '';//window.location.protocol + '//' + document.domain;

// Show image previews in grid views?
var showThumbs = true;

// Allowed image extensions when type is 'image'
var imagesExt = ['jpg', 'jpeg', 'gif', 'png'];

// Videos player support
// -----------------------------------------
var showVideoPlayer = false;
var videosExt = ['ogv', 'mp4', 'webm']; // Recognized videos extensions
var videosPlayerWidth = 400; // Videos Player Width
var videosPlayerHeight = 222; // Videos Player Height

// Audios player support
//-----------------------------------------
var showAudioPlayer = false;
var audiosExt = ['ogg', 'mp3', 'wav']; // Recognized audios extensions

</script>
<?php /** END */ ?>


<script type="text/javascript" src="scripts/filemanager.js"></script></div>

<script type="text/javascript">

$('#folders').change(function(){
	$.post(
		$(location).attr('href'),
		{ fileRoot: $("#folders").val() },
		function(data)  { $("body").html(data); }
	);
});

</script>

</body>
</html>
