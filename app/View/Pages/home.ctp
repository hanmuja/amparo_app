<?php if(!$this->Session->check("Auth.User.id")):?>
	<?php echo $this->element("login");?>
<?php else:?>
	<h1><?php echo __("Welcome to arcadetracker")?></h1>
<?php endif;?>