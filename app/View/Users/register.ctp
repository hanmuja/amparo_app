<h1><?php echo __("Register")?></h1>
<div><?php echo __("You may request access to Arcade Tracker by filling out this form.");?></div>
<div><?php echo __("If your account is approved, you will receive an email with credentials to log in.");?></div>
<br>
<?php echo $this->Form->create($model); ?>
<?php echo $this->Form->input($model.".first_name", array("label"=>__("First Name"), "class"=>"set_size_input"))?>
<?php echo $this->Form->input($model.".last_name", array("label"=>__("Last Name"), "class"=>"set_size_input"))?>
<?php echo $this->Form->input($model.".username", array("label"=>__("Username"), "class"=>"set_size_input"))?>
<?php echo $this->Form->input($model.".email", array("label"=>__("Email"), "class"=>"set_size_input"))?>
<?php echo "<div>".$this->Form->input($model.'.pending_comment', array("label"=>__("Optional Comments"), "class"=>"set_size_input"))."</div>";?>
<?php echo $this->Utils->form_separator();?>
<?php echo $this->Form->end(array("label"=>"Register", "class"=>"sc_button sc_button_green"));?>