<?php
/**
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
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
		
		echo $this->Html->css('buttons');
		echo $this->Html->css('main');
		echo $this->Html->css('default');
		echo $this->Html->css('layout');
		echo $this->Html->css('form');
		echo $this->Html->css('tables');
		echo $this->Html->css('funcionalidad');
		echo $this->Html->css('utils');
		echo $this->Html->css('helpers');
		echo $this->Html->css('bouncebox');
		echo $this->Html->css('qtip/jquery.qtip.min');
		echo $this->Html->css('context_menu/jquery.contextMenu');
		
		//echo $this->Html->css('themes/cupertino/jquery-ui-1.8.16.custom');
		echo $this->Html->css('themes/Aristo/Aristo');
		echo $this->Html->script('jquery');
		echo $this->Html->script('layout');
		echo $this->Html->script('shortcuts');
		
		echo $this->Html->script('ui/minified/jquery.ui.core.min');
	    echo $this->Html->script('ui/minified/jquery.ui.widget.min');
		echo $this->Html->script('ui/minified/jquery.ui.mouse.min');
		echo $this->Html->script('bouncebox-plugin/jquery.easing.1.3');
		echo $this->Html->script('bouncebox-plugin/jquery.bouncebox.1.0');
		echo $this->Html->script('qtip/jquery.qtip.min');
		echo $this->Html->script('jquery.contextMenu');

		//echo $scripts_for_layout;
	?>
</head>
<body>
	<div id="error_box" class="bouncebox"></div>
	<div id="success_box" class="bouncebox"></div>
	<div id="warning_box" class="bouncebox"></div>
	<div id="loading_container">
		<div id="loading"><?php echo __("Loading")?></div>
	</div>
	<div id="container">
		<div id="cuerpo">
			<div id="content">
                <div id="content_main">
                	<div id="session" style="text-align: right;">
                		<?php if($this->Session->check("Auth.User.id")):?>
                			<?php echo $this->Html->link(__("Logout"), array("plugin"=>null, "controller"=>"Users", "action"=>"logout"), array("style"=>"color: red"));?>
                		<?php endif;?>
                	</div>
        			<?php echo $this->Session->flash(); ?>
        			<?php echo $this->Session->flash("auth", array("element"=>"FlashMessages/warning")); ?>
        			
        			<?php if($this->Session->check("Auth.User")):?>
        				<?php echo $this->element("Menu/modules_menu")?>
	                	<br clear="all"/>
	                	<br clear="all"/>
        			<?php endif;?>
        			
        			<?php if(isset($link_group) && isset($current_link)):?>
        				<?php echo $this->element("Menu/current_module_menu")?>
        			<?php endif;?>
        			<?php echo $content_for_layout; ?>
                </div>
			</div>
		
		</div>
		<div id="footer">
		</div>
		<ul id="shortcuts_menu" class="contextMenu">
			<li class="edit"><a href="#edit">Edit</a></li>
			<li class="delete"><a href="#delete">Delete</a></li>
		</ul>
		<?php echo $this->Js->writeBuffer()?>
	</div>
    <br clear="all"/>
    <div>
        <?php //echo $this->element('sql_dump'); ?>
    </div>
</body>
</html>