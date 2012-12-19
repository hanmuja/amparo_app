<div class="login_form">
	<?php echo $this->Form->create("User", array("url"=>array("plugin"=>null, "controller"=>"Users", "action"=>"login")))?>
		<?php echo $this->Form->input("User.username", array("label"=>__("Username"), "style"=>"margin-right: 10px;"))?>
		<?php echo $this->Form->input("User.password", array("label"=>__("Password"), "style"=>"margin-right: 10px; margin-bottom: 5px;", "after"=>$this->Html->link(__("Forgot your password?"), array("plugin"=>null, "controller"=>"users", "action"=>"remember"), array("class"=>"remember_passwd"))))?>
	<?php echo $this->Form->end(array("label"=>__("Login"), "class"=>"link sc_button sc_button_blue"));?>
</div>