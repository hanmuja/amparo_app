<h1><?php echo __("Forgot your password?")?></h1>

<?php 
	//STAGE 2. When the user has entered his username, we ask if he wants to answer his secret questions and reset the password, or if he wants to receive a new password to his email.
	if(isset($this->data["User"])):
?>
	<?php if($secret_questions):?>
		<?php if($right_answers):?>
			<p><?php echo __("Everything went right %s, now you can enter your new password.", $this->data[$model]["first_name"])?></p>
			<?php echo $this->Form->create($model, array("url"=>array("plugin"=>null, "controller"=>$controller, "action"=>"unlogged_change_password")));?>
				<?php echo $this->Form->input($model.".id", array("type"=>"hidden"))?>
				<?php echo $this->Form->input("AuxElm.key", array("type"=>"hidden", "default"=>$key))?>
				<?php echo $this->Utils->empty_div_row();?>
				<?php echo $this->Form->input($model.".password", array("label"=>__("New Password")))?>
				<?php echo $this->Utils->empty_div_row();?>
				<?php echo $this->Form->input("AuxElm.password", array("label"=>__("Retype New Password")))?>
				<?php echo $this->Utils->empty_div_row();?>
				<?php echo $this->Utils->form_separator();?>
				<?php echo $this->Utils->empty_div_row();?>
			<?php echo $this->Form->end(array("label"=>__("Change Password"), "class"=>"link sc_button sc_button_green"));?>
		<?php else:?>
			<?php echo $this->Html->script("recovery_options")?>
			<p><?php echo __("These are the options we offer to reset your password:")?></p>
			
			<?php echo $this->Form->radio('AuxElm.recovery_option', array("0"=>__("Answer your secret questions.")), array("legend"=>false, "class"=>"recovery_option", "onchange"=>"show_selected_recovery_option()"));?>
			<br clear="all"/>
			<br clear="all"/>
			<div id="div_AuxElmRecoveryOption0" class="div_recovery_form" style="display:none">
				<?php echo $this->Form->create($model, array("style"=>"margin-left: 40px"));?>
					<?php echo $this->Form->input($model.".id", array("type"=>"hidden"))?>
					<?php echo $this->Utils->empty_div_row();?>
					<?php echo $this->Form->input($model.".answer1", array("label"=>$this->data[$model]["question1"]))?>
					<?php echo $this->Utils->empty_div_row();?>
					<?php echo $this->Form->input($model.".answer2", array("label"=>$this->data[$model]["question2"]))?>
					<?php echo $this->Utils->empty_div_row();?>
					<?php echo $this->Utils->form_separator();?>
					<?php echo $this->Utils->empty_div_row();?>
				<?php echo $this->Form->end(array("label"=>__("Send"), "class"=>"link sc_button sc_button_green"));?>
				<br clear="all"/>
				<br clear="all"/>
				<br clear="all"/>
			</div>
			<?php echo $this->Form->radio('AuxElm.recovery_option', array("1"=>__("Receive a new password in your email.")), array("legend"=>false, "class"=>"recovery_option", "onchange"=>"show_selected_recovery_option()"));?>
			<br clear="all"/>
			<br clear="all"/>
			<div id="div_AuxElmRecoveryOption1" class="div_recovery_form" style="display:none">
				<?php echo $this->Form->create($model, array("url"=>array("plugin"=>null, "controller"=>$controller, "action"=>"remember_email"), "style"=>"margin-left: 40px"));?>
					<?php echo $this->Form->input($model.".id")?>
					<?php echo $this->Form->input($model.'.email',array('label'=>__("Email"), "after"=>"<span>".__("Enter your email.")."</span>"));?>
					<?php echo $this->Utils->empty_div_row();?>
				<?php echo $this->Form->end(array("label"=>__("Send"), "class"=>"link sc_button sc_button_green"));?>
			</div>
		<?php endif;?>
	<?php else:?>
		<p><?php //echo __("You have not setup your secrect questions. Please confirm your account's email to receive a new password.")?></p>
		<?php echo $this->Form->create($model, array("url"=>array("plugin"=>null, "controller"=>$controller, "action"=>"remember_email")));?>
			<?php echo $this->Form->input($model.".id")?>
			<?php echo $this->Form->input($model.'.email',array('label'=>__("Email"), "style"=>"margin-right: 10px; width: 300px;", "after"=>"<span>".__("Enter the email associated to your account.")."</span>"));?>
			<?php echo $this->Utils->empty_div_row();?>
		<?php echo $this->Form->end(array("label"=>__("Continue"), "class"=>"link sc_button sc_button_green"));?>
	<?php endif;?>
	
<?php 

	//Stage 1. When the not logged user goes to "forgot your password". We ask for the username.
	else:
		
?>
	<p><?php echo __("To reset your password first enter your username.")?></p>
	<?php echo $this->Form->create($model);?>
		<?php echo $this->Form->input($model.'.username',array('label'=>__("Username"), "style"=>"margin-right: 10px; width: 300px;", "after"=>"<span>".__("Please enter your username.")."</span>"));?>
		<?php echo $this->Utils->empty_div_row();?>
	<?php echo $this->Form->end(array("label"=>__("Continue"), "class"=>"link sc_button sc_button_green"));?>
<?php endif;?>