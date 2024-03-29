<?php
/**
 * This code is part of the FileManager software (www.gerd-tentler.de/tools/filemanager), copyright by
 * Gerd Tentler. Obtain permission before selling this code or hosting it on a commercial website or
 * redistributing it over the Internet or in any other medium. In all cases copyright must remain intact.
 */
 
function fmCloseButton($id = '') {
	return	'<table border="0" cellspacing="0" cellpadding="0" width="16" height="16"><tr>' .
			'<td id="' . $id . '" class="fmTH3" align="center"' .
			' onMouseOver="this.className=\'fmTH4\'"' .
			' onMouseOut="this.className=\'fmTH3\'"' .
			' onMouseDown="this.className=\'fmTH5\'"' .
			' onMouseUp="this.className=\'fmTH4\'"' .
			' onClick="fmLib.fadeOut(fmLib.opacity, fmLib.dialog)">&times;</td>' .
			'</tr></table>';
}

?>
<script type="text/javascript">
var fmWebPath = '<?php print addslashes($fmWebPath); ?>';
var fmContSettings = fmMsg = fmEntries = {};
var fmSoundManagerReady = false;
</script>

<script src="<?php print $fmWebPath; ?>/js/tools.js" type="text/javascript"></script>
<script src="<?php print $fmWebPath; ?>/js/ajax.js" type="text/javascript"></script>
<script src="<?php print $fmWebPath; ?>/js/syntax.js" type="text/javascript"></script>
<script src="<?php print $fmWebPath; ?>/js/codeedit.js" type="text/javascript"></script>
<script src="<?php print $fmWebPath; ?>/js/codeview.js" type="text/javascript"></script>
<script src="<?php print $fmWebPath; ?>/js/filemanager.js" type="text/javascript"></script>
<script src="<?php print $fmWebPath; ?>/js/parser.js" type="text/javascript"></script>
<script src="<?php print $fmWebPath; ?>/js/flashreplace.js" type="text/javascript"></script>
<script src="<?php print $fmWebPath; ?>/soundmanager/soundmanager2-nodebug-jsmin.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php print $fmWebPath; ?>/css/filemanager.css" type="text/css">
<?php
/**
 * Add css forms - hanmuja
 */
 ?>
<link rel="stylesheet" href="<?php print $fmWebPath; ?>/css/notifications.css" type="text/css">

<script type="text/javascript">
soundManager.debugMode = false;
soundManager.useFlashBlock = false;
soundManager.url = fmWebPath + '/soundmanager/';
soundManager.flashVersion = 9;
soundManager.useMovieStar = true;
soundManager.useHTML5Audio = true;
soundManager.onready(function() { fmSoundManagerReady = soundManager.supported(); });
</script>

<div id="fmInfo" class="fmDialog fmShadow" onMouseOver="fmLib.setContMenu(false)" onMouseOut="fmLib.setContMenu(true)">
<table border="0" cellspacing="0" cellpadding="0"><tr>
<td class="fmTH1"><div id="fmInfoText" class="fmDialogTitle"></div></td>
<td class="fmTH1" style="padding-right:3px; cursor:move" align="right"><?php print fmCloseButton(); ?></td>
</tr><tr>
<td class="fmTH1" colspan="2" style="padding:1px">
<div id="fmInfoText2" class="fmTD2" style="padding:4px"></div></td>
</tr></table>
</div>

<div id="fmMenu" class="fmDialog fmShadow" onMouseOver="fmLib.setContMenu(false)" onMouseOut="fmLib.setContMenu(true)">
<table border="0" cellspacing="0" cellpadding="0"><tr>
<td class="fmTH1"><div id="fmMenuText" class="fmDialogTitle" style="width:180px"></div></td>
<td class="fmTH1" style="padding-right:3px; cursor:move" align="right"><?php print fmCloseButton(); ?></td>
</tr><tr>
<td class="fmTH1" colspan="2" style="padding:1px">
<div id="fmMenuText2" class="fmTD2"></div></td>
</tr></table>
</div>

<div id="fmError" class="fmDialog fmShadow" onMouseOver="fmLib.setContMenu(false)" onMouseOut="fmLib.setContMenu(true)">
<table border="0" cellspacing="0" cellpadding="0"><tr>
<td class="fmTH1"><div id="fmErrorText" class="fmDialogTitle" style="width:380px"></div></td>
<td class="fmTH1" style="padding-right:3px; cursor:move" align="right"><?php print fmCloseButton(); ?></td>
</tr><tr>
<td class="fmTH3" colspan="2" style="padding:4px">
<div id="fmErrorText2" class="fmError"></div></td>
</tr></table>
</div>

<div id="fmProgress" class="fmDialog fmShadow" style="z-index:69" onMouseOver="fmLib.setContMenu(false)" onMouseOut="fmLib.setContMenu(true)">
<table border="0" cellspacing="0" cellpadding="0"><tr>
<td class="fmTH1" style="padding:1px">
<div id="fmProgressText" class="fmTD2" style="width:215px; padding:4px"></div></td>
</tr></table>
</div>

<div id="fmRename" class="fmDialog fmShadow" onMouseOver="fmLib.setContMenu(false)" onMouseOut="fmLib.setContMenu(true)">
<form name="fmRename" class="fmForm" method="post">
<input type="hidden" name="fmMode" value="rename">
<input type="hidden" name="fmContainer" value="">
<input type="hidden" name="fmObject" value="">
<table border="0" cellspacing="0" cellpadding="0"><tr>
<td class="fmTH1"><div id="fmRenameText" class="fmDialogTitle" style="width:280px"></div></td>
<td class="fmTH1" style="padding-right:3px; cursor:move" align="right"><?php print fmCloseButton(); ?></td>
</tr><tr>
<td class="fmTH3" colspan="2" align="center" style="padding:4px">
<input type="text" name="fmName" size="40" maxlength="60" class="fmField" value=""/><br/>
<input type="submit" class="fmButton" value="OK"/>
</td>
</tr></table>
</form>
</div>

<div id="fmDelete" class="fmDialog fmShadow" onMouseOver="fmLib.setContMenu(false)" onMouseOut="fmLib.setContMenu(true)">
<form name="fmDelete" class="fmForm" method="post">
<input type="hidden" name="fmMode" value="delete">
<input type="hidden" name="fmObject" value="">
<table border="0" cellspacing="0" cellpadding="0"><tr>
<td class="fmTH1"><div id="fmDeleteText" class="fmDialogTitle" style="width:280px"></div></td>
<td class="fmTH1" style="padding-right:3px; cursor:move" align="right"><?php print fmCloseButton(); ?></td>
</tr><tr>
<td class="fmTH3" colspan="2" align="center" style="padding:4px">
<div id="fmDeleteText2" class="fmTD3"></div>
<input type="submit" class="fmButton" value="OK"/>
</td>
</tr></table>
</form>
</div>

<div id="fmPerm" class="fmDialog fmShadow" onMouseOver="fmLib.setContMenu(false)" onMouseOut="fmLib.setContMenu(true)">
<form name="fmPerm" class="fmForm" method="post">
<input type="hidden" name="fmMode" value="permissions">
<input type="hidden" name="fmObject" value="">
<table border="0" cellspacing="0" cellpadding="0"><tr>
<td class="fmTH1"><div id="fmPermText" class="fmDialogTitle" style="width:280px"></div></td>
<td class="fmTH1" style="padding-right:3px; cursor:move" align="right"><?php print fmCloseButton(); ?></td>
</tr><tr>
<td class="fmTH3" colspan="2" align="center" style="padding:4px">
<table border="0" cellspacing="2" cellpadding="2"><tr align="center">
<td class="fmTH2">&nbsp;</td>
<td id="fmPermText2" class="fmTH2"></td>
<td id="fmPermText3" class="fmTH2"></td>
<td id="fmPermText4" class="fmTH2"></td>
</tr><tr align="center">
<td id="fmPermText5" class="fmTH2" nowrap="nowrap"></td>
<td class="fmTD2" nowrap="nowrap"><input type="checkbox" name="fmPerms[0]" value="1"/></td>
<td class="fmTD2" nowrap="nowrap"><input type="checkbox" name="fmPerms[3]" value="1"/></td>
<td class="fmTD2" nowrap="nowrap"><input type="checkbox" name="fmPerms[6]" value="1"/></td>
</tr><tr align="center">
<td id="fmPermText6" class="fmTH2" nowrap="nowrap"></td>
<td class="fmTD2" nowrap="nowrap"><input type="checkbox" name="fmPerms[1]" value="1"/></td>
<td class="fmTD2" nowrap="nowrap"><input type="checkbox" name="fmPerms[4]" value="1"/></td>
<td class="fmTD2" nowrap="nowrap"><input type="checkbox" name="fmPerms[7]" value="1"/></td>
</tr><tr align="center">
<td id="fmPermText7" class="fmTH2" nowrap="nowrap"></td>
<td class="fmTD2" nowrap="nowrap"><input type="checkbox" name="fmPerms[2]" value="1"/></td>
<td class="fmTD2" nowrap="nowrap"><input type="checkbox" name="fmPerms[5]" value="1"/></td>
<td class="fmTD2" nowrap="nowrap"><input type="checkbox" name="fmPerms[8]" value="1"/></td>
</tr></table>
<input type="submit" class="fmButton" value="OK"/>
</td>
</tr></table>
</form>
</div>

<div id="fmJavaUpload" class="fmDialog fmShadow" onMouseOver="fmLib.setContMenu(false)" onMouseOut="fmLib.setContMenu(true)">
<table border="0" cellspacing="0" cellpadding="0"><tr>
<td id="fmJavaUploadText" class="fmTH1" style="padding:4px; cursor:move" align="left" nowrap="nowrap"></td>
<td class="fmTH1" style="padding-right:3px; cursor:move" align="right"><?php print fmCloseButton(); ?></td>
</tr><tr>
<td class="fmTH3" colspan="2" align="center" style="padding:4px">
<iframe name="JUpload" width="640" height="232" border="0" frameborder="0" scrolling="no"></iframe>
<form name="fmJavaUpload" class="fmForm" method="post">
<input type="hidden" name="fmMode" value="upload">
<?php //$engine = 'java'; include('email_form.php'); //hanmuja ?>
</form>
</td>
</tr></table>
</div>

<div id="fmNewFile" class="fmDialog fmShadow" onMouseOver="fmLib.setContMenu(false)" onMouseOut="fmLib.setContMenu(true)">
<form name="fmNewFile" class="fmForm" method="post" enctype="multipart/form-data">
<input type="hidden" name="fmMode" value="newFile">
<table border="0" cellspacing="0" cellpadding="0"><tr>
<td id="fmNewFileText" class="fmTH1" style="padding:4px; cursor:move" align="left" nowrap="nowrap"></td>
<td class="fmTH1" style="padding-right:3px; cursor:move" align="right"><?php print fmCloseButton(); ?></td>
</tr><tr>
<td class="fmTH3" colspan="2" align="center" style="padding:4px">
<input type="file" name="fmFile[0]" size="20" class="fmField" onClick="fmLib.newFileSelector(1)" onChange="fmLib.newFileSelector(1)"/>
<input type="file" name="fmFile[1]" size="20" class="fmField" onClick="fmLib.newFileSelector(2)" onChange="fmLib.newFileSelector(2)" style="display:none"/>
<input type="file" name="fmFile[2]" size="20" class="fmField" onClick="fmLib.newFileSelector(3)" onChange="fmLib.newFileSelector(3)" style="display:none"/>
<input type="file" name="fmFile[3]" size="20" class="fmField" onClick="fmLib.newFileSelector(4)" onChange="fmLib.newFileSelector(4)" style="display:none"/>
<input type="file" name="fmFile[4]" size="20" class="fmField" onClick="fmLib.newFileSelector(5)" onChange="fmLib.newFileSelector(5)" style="display:none"/>
<input type="file" name="fmFile[5]" size="20" class="fmField" onClick="fmLib.newFileSelector(6)" onChange="fmLib.newFileSelector(6)" style="display:none"/>
<input type="file" name="fmFile[6]" size="20" class="fmField" onClick="fmLib.newFileSelector(7)" onChange="fmLib.newFileSelector(7)" style="display:none"/>
<input type="file" name="fmFile[7]" size="20" class="fmField" onClick="fmLib.newFileSelector(8)" onChange="fmLib.newFileSelector(8)" style="display:none"/>
<input type="file" name="fmFile[8]" size="20" class="fmField" onClick="fmLib.newFileSelector(9)" onChange="fmLib.newFileSelector(9)" style="display:none"/>
<input type="file" name="fmFile[9]" size="20" class="fmField" style="display:none"/>
<?php //$engine = 'php'; include('email_form.php'); //hanmuja ?>
<input type="submit" class="fmButton" value="OK"/>
</td>
</tr></table>
</form>
</div>

<div id="fmNewDir" class="fmDialog fmShadow" onMouseOver="fmLib.setContMenu(false)" onMouseOut="fmLib.setContMenu(true)">
<form name="fmNewDir" class="fmForm" method="post">
<input type="hidden" name="fmMode" value="newDir">
<table border="0" cellspacing="0" cellpadding="0"><tr>
<td id="fmNewDirText" class="fmTH1" style="padding:4px; cursor:move" align="left" nowrap="nowrap"></td>
<td class="fmTH1" style="padding-right:3px; cursor:move" align="right"><?php print fmCloseButton(); ?></td>
</tr><tr>
<td class="fmTH3" colspan="2" align="center" style="padding:4px">
<input type="text" name="fmName" size="40" maxlength="60" class="fmField"/><br/>
<input type="submit" class="fmButton" value="OK"/>
</td>
</tr></table>
</form>
</div>

<div id="fmSearch" class="fmDialog fmShadow" onMouseOver="fmLib.setContMenu(false)" onMouseOut="fmLib.setContMenu(true)">
<form name="fmSearch" class="fmForm" method="post">
<input type="hidden" name="fmMode" value="search"/>
<table border="0" cellspacing="0" cellpadding="0"><tr>
<td id="fmSearchText" class="fmTH1" style="padding:4px; cursor:move" align="left" nowrap="nowrap"></td>
<td class="fmTH1" style="padding-right:3px; cursor:move" align="right"><?php print fmCloseButton(); ?></td>
</tr><tr>
<td class="fmTH3" colspan="2" align="center" style="padding:4px">
<input type="text" name="fmName" size="40" maxlength="60" class="fmField"/><br/>
<input type="submit" class="fmButton" value="OK"/>
</td>
</tr></table>
</form>
</div>

<div id="fmSaveFromUrl" class="fmDialog fmShadow" onMouseOver="fmLib.setContMenu(false)" onMouseOut="fmLib.setContMenu(true)">
<form name="fmSaveFromUrl" class="fmForm" method="post">
<input type="hidden" name="fmMode" value="saveFromUrl">
<input type="hidden" name="fmContainer" value="">
<input type="hidden" name="fmObject" value="">
<table border="0" cellspacing="0" cellpadding="0"><tr>
<td id="fmSaveFromUrlText" class="fmTH1" style="padding:4px; cursor:move" align="left" nowrap="nowrap"></td>
<td class="fmTH1" style="padding-right:3px; cursor:move" align="right"><?php print fmCloseButton(); ?></td>
</tr><tr>
<td class="fmTH3" colspan="2" align="center" style="padding:4px">
<input type="text" name="fmName" size="40" maxlength="255" class="fmField" value=""/>
<div class="fmTH3" style="font-weight:normal; text-align:left; border:none">
<input type="checkbox" name="fmReplSpaces" value="1"<?php if(isset($replSpacesUpload) && $replSpacesUpload) print ' checked="checked"'; //add isset - hanmuja ?>/>
file name =&gt; file_name<br/>
<input type="checkbox" name="fmLowerCase" value="1"<?php if(isset($lowerCaseUpload) && $lowerCaseUpload) print ' checked="checked"'; //add isset - hanmuja ?>/>
FileName =&gt; filename
</div>
<input type="submit" class="fmButton" value="OK"/>
</td>
</tr></table>
</form>
</div>

<div id="fmExplorer" class="fmDialog fmShadow" onMouseOver="fmLib.setContMenu(false)" onMouseOut="fmLib.setContMenu(true)">
<table border="0" cellspacing="0" cellpadding="0"><tr>
<td class="fmTH1" style="cursor:move"><div id="fmExplorerText" class="fmDialogTitle" style="width:220px"></div></td>
<td class="fmTH1" style="padding-right:3px; cursor:move" align="right"><?php print fmCloseButton(); ?></td>
</tr><tr>
<td class="fmTH1" colspan="2" style="padding:1px">
<div id="fmExplorerText2" class="fmTREEbg" style="width:245px; height:150px; overflow:auto"></div></td> <!-- Change Class to fmTREEbg --------- DARIO ----------- -->
</tr></table>
</div>

<div id="fmMediaPlayer" class="fmDialog fmShadow" onMouseOver="fmLib.setContMenu(false)" onMouseOut="fmLib.setContMenu(true)">
<table border="0" cellspacing="0" cellpadding="0"><tr>
<td class="fmTH1" style="cursor:move"><div id="fmMediaPlayerText" class="fmDialogTitle"></div></td>
<td class="fmTH1" style="padding-right:3px; cursor:move" align="right"><?php print fmCloseButton('fmCloseBtn'); ?></td>
</tr><tr>
<td class="fmTH2" colspan="2" style="padding:1px">
<div id="fmFlashCont"></div></td>
</tr></table>
</div>

<div id="fmDocViewer" class="fmDialog fmShadow" onMouseOver="fmLib.setContMenu(false)" onMouseOut="fmLib.setContMenu(true)">
<table border="0" cellspacing="0" cellpadding="0"><tr>
<td class="fmTH1" style="cursor:move"><div id="fmDocViewerText" class="fmDialogTitle"></div></td>
<td class="fmTH1" style="padding-right:3px; cursor:move" align="right"><?php print fmCloseButton(); ?></td>
</tr><tr>
<td class="fmTH2" colspan="2" align="center" style="padding:1px">
<div id="fmDocViewerCont" class="fmThumbnail" style="background-color:#FFFFFF" onMouseOver="fmLib.setContMenu(true)"></div></td>
</tr></table>
</div>

<div id="fmEditor" class="fmDialog fmShadow" onMouseOver="fmLib.setContMenu(false)" onMouseOut="fmLib.setContMenu(true)">
<table border="0" cellspacing="0" cellpadding="0"><tr>
<td class="fmTH1" style="cursor:move"><div id="fmEditorText" class="fmDialogTitle"></div></td>
<td class="fmTH1" width="14" align="right" id="fmEditorButton"></td>
<td class="fmTH1" width="8"></td>
<td class="fmTH1" style="padding-right:3px; cursor:move" align="right"><?php print fmCloseButton(); ?></td>
</tr><tr>
<td class="fmTH2" colspan="4" align="center" style="padding:1px">
<div id="fmEditorCont" class="fmThumbnail" style="background-color:#FFFFFF" onMouseOver="fmLib.setContMenu(true)"></div></td>
</tr></table>
</div>

<iframe name="fmFileAction" style="display:none"></iframe>
