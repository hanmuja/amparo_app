<?php

/**
 * Include of database information
 * @hanmuja
 */
include('../../../../Config/database.php'); //Include db cakephp @hanmuja

/**
 *	Filemanager PHP connector configuration
 *
 *	filemanager.config.php
 *	config for the filemanager.php connector
 *
 *	@license	MIT License
 *	@author		Riaan Los <mail (at) riaanlos (dot) nl>
 *	@author		Simon Georget <simon (at) linea21 (dot) com>
 *	@copyright	Authors
 */


/**
 *	Check if user is authorized
 *
 *	@return boolean true is access granted, false if no access
 */
function auth() {
  // You can insert your own code over here to check if the user is authorized.
  // If you use a session variable, you've got to start the session first (session_start())
  return true;
}

function getRoot()
{
	$obj = new DATABASE_CONFIG();
	$default = $obj->default;
	
	$con = mysql_connect($default['host'], $default['login'], $default['password']);

	if (!$con)
	{
		die('Could not connect: ' . mysql_error());
	}
	
	mysql_select_db($default['database'], $con);
		
	
	$result = mysql_query("SELECT * FROM settings WHERE name = 'root'");
	
	$row = mysql_fetch_array($result);
		
	mysql_close($con);
	
	return $row['val'];
}


/**
 *	Language settings
 */
$config['culture'] = 'en';

/**
 *	PHP date format
 *	see http://www.php.net/date for explanation
 */
$config['date'] = 'd M Y H:i';

/**
 *	Icons settings
 */
$config['icons']['path'] = 'images/fileicons/';
$config['icons']['directory'] = '_Open.png';
$config['icons']['default'] = 'default.png';

/**
 *	Upload settings
 */
$config['upload']['overwrite'] = false; // true or false; Check if filename exists. If false, index will be added
$config['upload']['size'] = false; // integer or false; maximum file size in Mb; please note that every server has got a maximum file upload size as well.
$config['upload']['imagesonly'] = false; // true or false; Only allow images (jpg, gif & png) upload?

/**
 *	Images array
 *	used to display image thumbnails
 */
$config['images'] = array('jpg', 'jpeg','gif','png');


/**
 *	Files and folders
 *	excluded from filtree
 */
$config['unallowed_files']= array('.htaccess');
$config['unallowed_dirs']= array('_thumbs','.CDN_ACCESS_LOGS', 'cloudservers');

/**
 *	FEATURED OPTIONS
 *	for Vhost or outside files folder
 */
 $root = getRoot();
$config['doc_root'] = $root.'/app/webroot'; // No end slash


/**
 *	Optional Plugin
 *	rsc: Rackspace Cloud Files: http://www.rackspace.com/cloud/cloud_hosting_products/files/
 */
$config['plugin'] = null;
//$config['plugin'] = 'rsc';



//	not working yet
//$config['upload']['suffix'] = '_'; // string; if overwrite is false, the suffix will be added after the filename (before .ext)

?>