<?php

include('db.php');

$date = date('Y-m-d H:i:s');
$ip = $this->Log->remoteIp;

$subject = 'File upload notification';
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
//$headers .= 'Reply-To: '.$this->general_email . "\r\n";
//$headers .= 'Return-Path: '.$this->general_email . "\r\n";
$headers .= 'From: admin@arcadetracker.com';

$body = '';

$folder_flag = 0;

$uploaded = $files;

foreach($uploaded as $file)
{

	// byte unit conversion
	$number = $file['size'];
	//$number = change_byte_unit($number);

	if ($number >= 1073741824)
	{
		$number = round($number/1073741824, 1);
		$number .= ' GB';
	}
	elseif ($number >= 1048576)
	{
		$number = round($number/1048576, 1);
		$number .= ' MB';
	}
	elseif ($number >= 1024)
	{
		$number = round($number/1024, 1);
		$number .= ' KB';
	}
	else
	{
		$number .= ' bytes';
	}

//--------------------

	// Path truncation

	$file_path = explode('/', $file['path']);
	
	$short_path = $file_path[6];
	$i = 7;
	
	while (!empty($file_path[$i]))
	{
		$short_path .= '/'.$file_path[$i];
		$i++;
	}

	// Get the 4th last character of $short_path in case of a 3 character ext.
	$dot4 = $short_path[strlen($short_path)-4];
	// Get the 3th last character of $short_path in case of a 2 character ext.
	$dot3 = $short_path[strlen($short_path)-3];
	// Get the 5th last character of $short_path in case of a 4 character ext.
	$dot5 = $short_path[strlen($short_path)-5];

	$ext_flag = false;
	if ($dot4 == '.' || $dot3 == '.' || $dot5 == '.') { $ext_flag = true; }
	
	if ($_REQUEST['send_link'] == 1 && $ext_flag)
	{
		$body .= '<b>File path</b>: <a href="'.$this->domain.'/files/'.$short_path.'" target="_blank">'.$short_path.'</a><br><b>File size</b>: '.$number.'<br><b>How to download</b>: You may click the File path; it\'s a link to the file.<br><br>';
	}
	else
	{
		if ($ext_flag)
		{
			$body .= '<b>File path</b>: '.$short_path.'<br><b>File size</b>: '.$number.'<br><b>How to download</b>: You must log in to Arcade Tracker to download this file.<br><br>';
		}
		else
		{
			$body .= '<b>Folder path</b>: '.$short_path.'<br><b>How to download</b>: You must log in to Arcade Tracker to download the files inside this folder.<br><br>';
			$folder_flag++;
		}
	}
}

//--------------------
	
	
$uploaded_count = count($uploaded);
//$user_name = ucwords($this->currentusername);

if ($uploaded_count > 1)
{
	if ($folder_flag == 0)
	{
		$email_header = 'The following files have been uploaded on '.$date.' (IP address '.$ip.'):';
	}
	elseif ($folder_flag == 1)
	{
		$email_header = 'The following folder and files have been uploaded on '.$date.' (IP address '.$ip.'):';
	}
	else
	{
		$email_header = 'The following folders and files have been uploaded on '.$date.' (IP address '.$ip.'):';
	}
}
else
{
	if ($ext_flag)
	{
		$email_header = 'The following file has been uploaded on '.$date.' by user '.$user_name.' (IP address '.$ip.'):';
	}
	else
	{
		$email_header = 'The following folder has been uploaded on '.$date.' by user '.$user_name.' (IP address '.$ip.'):';
	}
}

$engine = "java";
if(isset($_REQUEST['message_php']))
	$engine = "php";

$fmComments = $_REQUEST['message_'.$engine];

$fmComments = nl2br($fmComments);

$message = '
<html>
<body>
	<table border="0" width="700" align="left">
			<tr>
				<td style="text-align:left;">
				<img alt="Arcade Tracker" src="'.$this->domain.'/img/logo.png" style="color: #990000; font-size:16px; font-weight:bold;" />
				<hr style="color: #990000; background-color: #990000; height:8px; border:0; border-bottom:2px solid #777777;" />
				<br />
				</td>
</tr>
<tr>
	<td>
		<div style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:14px;font-weight:bold;margin-bottom:15px; width:650px;">'.$subject.'</div>
<div style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px; width:650px;margin-bottom:15px;">'.stripslashes($fmComments).'</div>
<div style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px; width:650px;margin-bottom:15px;">'.$email_header.'</div>
<div style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px; width:650px;margin-bottom:5px;">'.$body.'</div>
	</td>
</tr>
<tr>
	<td style="text-align:left;">
	<hr style="color: #990000; background-color: #990000; height:8px; border:0; border-bottom:2px solid #777777;" />
	</td>
</tr>
<tr>
	<td style="text-align:left;font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;">
		Copyright &copy; '.date('Y').' Amarca. All rights reserved.
				</td>
			</td>
	</table>
</body>
</html>';

$emails_list = array();

if(count($_REQUEST['users_'.$engine]) > 0)
{
	foreach($_REQUEST['users_'.$engine] as $user_id)
	{
		$query = "SELECT * FROM users WHERE id = $user_id";
		$result = mysql_query($query);
		$user = mysql_fetch_array($result);
		
		$emails_list[] = $user['email'];
		
		if(!empty($user['email_list']))
		{
			$emails_str = str_replace(";", ",", $user['email_list']);
			$emails = explode(',', $emails_str);
			foreach($emails as $email)
			{
				$emails_list[] = $email;
			}
		}
	}
}
	
if(!empty($_REQUEST['other_email']))
{
	$emails_str = str_replace(";", ",", $_REQUEST['other_email']);
	$emails = explode(',', $emails_str);
	foreach($emails as $email)
	{
		$emails_list[] = $email;
	}
}
	
if($this->mailOnUpload)
{
		$emails_list[] = $this->mailOnUpload;
}

foreach($emails_list as $email)
{
	$email = trim($email);
	
	@mail($email,$subject,$message,$headers);
}
