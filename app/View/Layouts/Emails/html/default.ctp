<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts.Email.html
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">

<html>
<head>
        <title><?php echo $title_for_layout;?></title>
</head>

<body>
	
	<img alt="Arcade Tracker" src="<?php echo $this->Html->url('/', true) ?>img/logo.png" style="color: #990000; font-size:16px; font-weight:bold;" />
	<hr style="color: #990000; background-color: #990000; height:8px; border:0; border-bottom:2px solid #777777;" />
	<br />
	
        <?php echo $content_for_layout;?>

        <?php /*<p>This email was sent by <a href="http://beta.arcadetracker.com">Arcade Tracker</a></p>*/ ?>
        
        <hr style="color: #990000; background-color: #990000; height:8px; border:0; border-bottom:2px solid #777777;" />
</body>
</html>
