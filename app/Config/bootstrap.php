<?php
/**
 *  This file is loaded automatically by the app/webroot/index.php file after core.php
 *
 * This file should load/create any application wide configuration settings, such as 
 * Caching, Logging, loading additional configuration files.
 *
 * You should also use this file to include any files that provide global functions/constants
 * that your application uses.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.10.8.2117
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

// Setup a 'default' cache configuration for use in the application.
Cache::config('default', array('engine' => 'File'));

/**
 * The settings below can be used to set additional paths to models, views and controllers.
 *
 * App::build(array(
 *     'Plugin' => array('/full/path/to/plugins/', '/next/full/path/to/plugins/'),
 *     'Model' =>  array('/full/path/to/models/', '/next/full/path/to/models/'),
 *     'View' => array('/full/path/to/views/', '/next/full/path/to/views/'),
 *     'Controller' => array('/full/path/to/controllers/', '/next/full/path/to/controllers/'),
 *     'Model/Datasource' => array('/full/path/to/datasources/', '/next/full/path/to/datasources/'),
 *     'Model/Behavior' => array('/full/path/to/behaviors/', '/next/full/path/to/behaviors/'),
 *     'Controller/Component' => array('/full/path/to/components/', '/next/full/path/to/components/'),
 *     'View/Helper' => array('/full/path/to/helpers/', '/next/full/path/to/helpers/'),
 *     'Vendor' => array('/full/path/to/vendors/', '/next/full/path/to/vendors/'),
 *     'Console/Command' => array('/full/path/to/shells/', '/next/full/path/to/shells/'),
 *     'locales' => array('/full/path/to/locale/', '/next/full/path/to/locale/')
 * ));
 *
 */

/**
 * Custom Inflector rules, can be set to correctly pluralize or singularize table, model, controller names or whatever other
 * string is passed to the inflection functions
 *
 * Inflector::rules('singular', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 * Inflector::rules('plural', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 *
 */

/**
 * Plugins need to be loaded manually, you can either load them one by one or all of them in a single call
 * Uncomment one of the lines below, as you need. make sure you read the documentation on CakePlugin to use more
 * advanced ways of loading plugins
 *
 * CakePlugin::loadAll(); // Loads all plugins at once
 * CakePlugin::load('DebugKit'); //Loads a single plugin named DebugKit
 *
 */

 //PLUGINS
 CakePlugin::load('AclExtras');
 
 
//define('PEAR', ROOT .DS. APP_DIR .DS .'Vendor' .DS. 'PEAR' .DS);
//ini_set("include_path", PEAR . PATH_SEPARATOR . ini_get("include_path")); 


//The label to the Actions column in the tables.
define("ACTIONS_LABEL", " ");

//Each form row is a div with display= table-cell. There is an empty div between each row. Here we define the heigh of that div.
define("EMPTY_DIV_ROW_HEIGHT", "10px");

//Here we define the basic class for the buttons. If we want them to look different, we change this class and create the needed CSS.
define("BUTTONS_CLASS", "sc_buttons");
define("CRUD_THEME", "sc_button");

//This is the empty option that will appear in the form selects.
define("EMPTY_OPTION", "---");



//SOME IMAGES ____________________________________________________
//The retire image relative to img folder
define("RETIRE_IMAGE", "crud/retire.png");
define("UNRETIRE_IMAGE", "crud/unretire.png");

//The delete from database image relative to img folder
define("DELETE_IMAGE", "crud/remove.gif");
define("SMALL_DELETE_IMAGE", "crud/small/remove.gif");

define("PERMISSION_AUTHORIZED_IMAGE", "crud/active.png");
define("PERMISSION_BLOCKED_IMAGE", "crud/denied.png");
define("SMALL_PERMISSION_AUTHORIZED_IMAGE", "crud/small/active.png");
define("SMALL_PERMISSION_BLOCKED_IMAGE", "crud/small/denied.png");
define("SMALL_PERMISSION_MIXED_IMAGE", "crud/small/mixed.png");

define("ADD_IN_FORM_IMAGE", "form/plus.png");
define("EDIT_IN_FORM_IMAGE", "form/edit.gif");
define("DELETE_IN_FORM_IMAGE", "form/minus.png");
define("SAVE_IN_FORM_IMAGE", "form/disk-black.png");

define("PROBLEM_HISTORY_IMAGE", "crud/clock-history-frame.png");

define("OPEN_TICKET_IMAGE", "crud/undo.png");
define("CLOSE_TICKET_IMAGE", "crud/check.png");

//END OF IMAGES________________________________________________________________

define("SAVE_LABEL", __("Save"));

/*
 * In the tables, there is an option to add select filters. Let say we have a select with the options:
 * Yes
 * NO
 * 
 * The values for these options are 1 and 0. The comparator to these values is equal. We look for a value equal to 1 or to 0.
 * Each select option must contain the values and comparator information. So we need some string to separate the value from the comparator
 * so we can explode the full option by the separator such string to get the value and the comparator. 
 * 
 * 
 * Now, Let say we have the next options:
 * >10 and <20 Years old
 * <=10 years old
 * >=20 years old
 * 
 * The first option has to values (10 and 20) and the comparator is "between".
 * The second option has a single value (10) and the comparator is "less than or equal".
 * The second option has a single value (20) and the comparator is "greater than or equal".
 * 
 * The first option needs the comparator separator, plus a values separator to separate 10 from 20
 * */
define("VALUE_COMPARATOR_SEPARATOR", "|||");
define("VALUES_SEPARATOR", "||");


//When a user is created, an email is sent. Here we say wich EmailTemplate must be used.
define("USER_CREATION_TEMPLATE", "USER CREATED");
define("PASSWORD_RESET_TEMPLATE", "PASSWORD RESET");
define("TT_CREATION_TEMPLATE", "TROUBLE TICKET POSTED");
define("TT_EDITION_TEMPLATE", "TROUBLE TICKET EDITED");
define("POST_AN_UPDATE_TEMPLATE", "TT UPDATE POSTED");
define("REJECT_SUGGESTION_TEMPLATE", "PART SUGGESTION REJECTED");
define("CLOSE_PART_TEMPLATE", "PART CLOSED");
define("EVENT_CREATION_TEMPLATE", "EVENT CREATED");
define("EVENT_EDITION_TEMPLATE", "EVENT EDITED");
define("USER_REJECTED_TEMPLATE", "USER REJECTED");
define("USER_REGISTER_TEMPLATE", "USER REGISTER");

/*
 * The Aco path separator
 */
define('ACL_ACO_PATH_SEPARATOR', '____');

define("SUPERADMIN_ROLE_ID", 1);

define("DEFAULT_ORDER_COMPONENT_STATUS_ID", 1);

/**
 * Names of settings for bcc email.
 * 
 */

define('SETTING_EMAIL_TROUBLE_TICKET', 'trouble_ticket');
define('SETTING_EMAIL_PART_ORDER', 'part_order');
define('SETTING_EMAIL_TIMESHEET', 'timesheet');
define('SETTING_EMAIL_USER', 'user');
define('SETTING_EMAIL_EVENT', 'event');
define('SETTING_EMAIL_TIMESHEET_ADMIN', 'timesheet_admin');
define('SETTING_EMAIL_PURCHASING_ADMIN', 'purchasing_admin');
define('REGISTER', 'register');
define('REGISTER_ADMIN', 'register_admin');
define('SETTING_TMP_FRIENDLY', 'tmp_friendly');

/**
 * CKeditors definition
 */
define("SHORTCUTS_DIALOG_DIV", "shortcuts_dialog");

/**
 * Mailchimp variables
 */
define('MCAPIKEY', '68d5de43011efbaada8841ce263e1a73-us6');
define('MCLISTID', 'fa995eaa5c');


function ckeditors()
{
	$ckeditors= array();
	$ckeditors["PROBLEM_FORM_DESCRIPTION"]= __("Add/Edit Trouble Ticket | Trouble Tickets");
	$ckeditors["PROBLEM_FORM_CONFIDENTIAL_DESCRIPTION"]= __("Add/Edit Trouble Ticket (Confidential) | Trouble Tickets");
	$ckeditors["SESSION_FORM"]= __("Post/Edit an Update | Trouble Tickets");
	$ckeditors["PART_ORDER_DESCRIPTION"]= __("Place/Edit an Order for Parts | Trouble Tickets");
	$ckeditors["NEW_PART_REQUESTED"]= __("Request/Edit a New Part | Trouble Tickets");
	$ckeditors["ORDER_COMPONENT_COMMENT"]= __("Process this Part | Part Orders");
	$ckeditors["REASON_FOR_REJECTION"]= __("Reason For Rejection | Part Orders");
	//$ckeditors["EQUIPMENT_DESCRIPTION"]= __("Add/Edit Game | Game List");
	$ckeditors["PART_DESCRIPTION"]= __("Add/Edit Part | Parts");
	$ckeditors["ROUTE_DESCRIPTION"]= __("Add/Edit Route | Routes");
	$ckeditors["EMAIL_TEMPLATE_FORM"]= __("Add/Edit Email Template | Email Templates");
	$ckeditors["ROLE_DESCRIPTION"]= __("Add/Edit Role | Roles");
	$ckeditors["DAY_COMMENTS"]= __("Add/Edit Punch In | Time Sheets");
	$ckeditors["EVENT_DESCRIPTION"]= __("Add/Edit Event | Events");
	$ckeditors["GROUP_DESCRIPTION"]= __("Add/Edit GROUP | Groups");
	
	return $ckeditors;
}

function get_ckeditor_module_name($index)
{
	$ckeditors= ckeditors();
	if(isset($ckeditors[$index]))
	{
		return $ckeditors[$index];
	}
	else 
	{
		return false;
	}
}

function get_fecha_int($fecha_string, $y_pos=0, $m_pos=1, $d_pos=2)
{
	$fecha_array= explode(" ", $fecha_string);
	
	if(count($fecha_array)==1)
	{
		$date= $fecha_array[0];
		$time= "00:00:00";
	}
	if(count($fecha_array)==2)
	list($date, $time)= $fecha_array;
	
	if(count($fecha_array)==3)
	list($date, $time, $ampm)= $fecha_array;
	
	if(!isset($ampm))
	{
		if(count(explode(":", $time))==2)
		{
			list($H, $i)= explode(":", $time);
			$s=0;
		}
		elseif (count(explode(":", $time))==3) {
			list($H, $i, $s)= explode(":", $time);	
		}	
	}
	else
	{
		$time= ampm2tf($time." ".$ampm);
		list($H, $i)= explode(":", $time);
		$s=0;
	}
	
	
	$date_array= explode("-", $date);
	
	$y= $date_array[$y_pos];
	$m= $date_array[$m_pos];
	$d= $date_array[$d_pos]; 
	
	return mktime($H, $i, $s, $m, $d, $y);
}

function ampm2tf($time){
	list($time, $ampm)= explode(" ", $time);
	list($hour, $minutes)= explode(":", $time);
	
	$real_hour= $hour; 
	if($ampm=="am")
	{
		if($hour==12)
		$real_hour= 0;
	}
	if($ampm=="pm")
	{
		if($hour!=12)
		$real_hour= $hour+12-0;
	}
	
	return $real_hour.":".$minutes;
}

/**
 * Id's of problem_types for reports
 * 
 */
function out_of_order_ids()
{
	return array('1' => 'Out of Order', '5' => 'Urgent Request'); 
}

function get_post_types()
{
	return array('blog', 'faqs');
}
