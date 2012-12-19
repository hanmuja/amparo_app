<?php

/**
 * EXTRA FUNCTIONS
 * @hanmuja
 */

class ExtraFunctions
{
	function renameDb($old, $new)
	{
		include('db.php');
		
		$result = mysql_query("SELECT * FROM settings WHERE name = 'root' LIMIT 1");
		
		$row = mysql_fetch_array($result);
		
		$root = $row['val'];
		
		$old_folder = str_replace($root.'/app/webroot/files', '', $old);
		
		$new_folder = str_replace($root.'/app/webroot/files', '', $new);
	
		mysql_query("UPDATE folders SET folder = REPLACE(folder, '$old_folder', '$new_folder')");
		
		mysql_query("UPDATE default_folders SET folder = REPLACE(folder, '$old_folder', '$new_folder')");
			
		mysql_close($con);
	}
	
	function deleteDb($path_in)
	{
		include('db.php');
		
		$result = mysql_query("SELECT * FROM settings WHERE name = 'root' LIMIT 1");
		
		$row = mysql_fetch_array($result);
		
		$root = $row['val'];
		
		$path = str_replace($root.'/app/webroot/files', '', $path_in);
		
		mysql_query("DELETE FROM folders WHERE folder like '%$path'");
		mysql_query("DELETE FROM folders WHERE folder like '%$path/%'");
	
		mysql_query("DELETE FROM default_folders WHERE folder like '%$path'");
		mysql_query("DELETE FROM default_folders WHERE folder like '%$path/%'");
			
		mysql_close($con);
	}
}
