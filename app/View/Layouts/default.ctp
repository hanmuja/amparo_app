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
<html xmlns="http://www.w3.org/1999/xhtml" class="no-js">
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
		echo $this->Html->css('spry/SpryMenuBarHorizontal');
		
		//echo $this->Html->css('themes/cupertino/jquery-ui-1.8.16.custom');
		echo $this->Html->css('themes/Aristo/Aristo');
		echo $this->Html->script('modernizr/modernizr-2.5.3.js');
		echo $this->Html->script('jquery');
		echo $this->Html->script('layout');
		echo $this->Html->script('shortcuts');
		
		echo $this->Html->script('ui/minified/jquery.ui.core.min');
	    echo $this->Html->script('ui/minified/jquery.ui.widget.min');
		echo $this->Html->script('ui/minified/jquery.ui.mouse.min');
		echo $this->Html->script('ui/minified/jquery.ui.datepicker.min');
		echo $this->Html->script('bouncebox-plugin/jquery.easing.1.3');
		echo $this->Html->script('ui/jquery.ui.sortable');
		echo $this->Html->script('bouncebox-plugin/jquery.bouncebox.1.0');
		echo $this->Html->script('qtip/jquery.qtip.min');
		echo $this->Html->script('jquery.contextMenu');
		echo $this->Html->script('spry/SpryMenuBar');

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
    	<div id="top">
        	<div id="header">
        		<article>
        			<div id="info_empresa">
        			Monte Hermon 109<br />
        			Col. Lomas de Chapultepec, M&eacute;xico, D.F. 11000<br />
        			Tel. (+52 55) 5258-0311, Fax (+52 55) 5258-0308
        			</div>
        		</article>
            	<?php //if($this->Session->check("Auth.User")):?>
					<?php //echo $this->element("Menu/modules_menu")?>
                <?php //endif;?>
            </div>
        </div>
		<div id="body">
			<div id="content">
                <div id="content_main">
        			<?php echo $this->Session->flash(); ?>
        			<?php echo $this->Session->flash("auth", array("element"=>"FlashMessages/warning")); ?>
                    <?php if($this->params['action'] == 'login'):?>
                        <?php
                            $urls[] = array("selected"=>true, "label"=>__('Login'), "show"=>true, "url" => 'login');
                            $urls[] = array("selected"=>false, "label"=>__('Register'), "show"=>true, "url"=>'register');
                        ?>
                    <?php elseif($this->params['action'] == 'register'): ?>
                        <?php
                            $urls[] = array("selected"=>false, "label"=>__('Login'), "show"=>true, "url" => 'login');
                            $urls[] = array("selected"=>true, "label"=>__('Register'), "show"=>true, "url"=>'register');
                        ?>
                    <?php else: ?>
			<?php $urls= $this->Utils->get_urls_same_level();?>
                    <?php endif; ?>
                        <?php if(!$urls):?>
                            <?php $urls[]= array("selected"=>true, "label"=>$title_for_layout, "show"=>true)?>
                        <?php endif;?>
                        <div class="ui-tabs ui-widget ui-widget-content ui-corner-all">
                            <ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
                                <?php foreach($urls as $i=>$url):?>
                                	<?php if($url["show"]):?>
	                                    <?php $li_class= ($url["selected"])?"ui-state-default ui-corner-top ui-tabs-selected ui-state-active":"ui-state-default ui-corner-top"?>
	                                    <?php $real_url= ($url["selected"])?"#":$url["url"]?>
	                                    <li class="<?php echo $li_class?>"><?php echo $this->Html->link($url["label"], $real_url, array("title"=>"main_tabs_inner"));?></li>
	                                <?php endif;?>
                                <?php endforeach;?>
                            </ul>
                            <div id="main_tabs_simulator" class="ui-tabs-panel ui-widget-content ui-corner-bottom">
                                <?php echo $content_for_layout?>
                            </div>
					</div>
                </div>
			</div>
		</div>
		<div id="bottom">
        	<div id="footer">Copyright &copy; <?php echo date('Y') ?></div>
		</div>
		<ul id="shortcuts_menu" class="contextMenu">
			<li class="edit"><a href="#edit">Edit</a></li>
			<li class="delete"><a href="#delete">Delete</a></li>
			<li class="sort separator"><a href="#sort">Sort</a></li>
		</ul>
		<ul id="accept_suggestion_menu" class="contextMenu">
			<li class="accept_select"><a href="#accept_select">Select an existing part</a></li>
			<li class="accept_new"><a href="#accept_new">Create a new part</a></li>
		</ul>
		<?php echo $this->Js->writeBuffer()?>
	</div>
    <div>
        <?php echo $this->element('sql_dump'); ?>
    </div>
<script type="text/javascript">
<!--
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"/img/spry/SpryMenuBarDownHover.gif", imgRight:"/img/spry/SpryMenuBarRightHover.gif"});
//-->
</script>
</body>
</html>
