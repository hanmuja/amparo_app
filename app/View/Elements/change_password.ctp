<div class="change_password_form">
        <?php echo $this->Form->create("User", array("url"=>array("plugin"=>null, "controller"=>"Users", "action"=>"change_password")))?>
                <?php echo $this->Form->input("password_old", array("div" => array("class" => "input password required"), "label"=>__("Current Password"), "type" => "password", "class"=>"set_size_input", "AUTOCOMPLETE" => "off"))?>
                <?php echo $this->Form->input("password_new", array("div" => array("class" => "input password required"), "label"=>__("New Password"), "type" => "password", "class"=>"set_size_input", "AUTOCOMPLETE" => "off"))?>
                <?php echo $this->Form->input("password_repeat", array("div" => array("class" => "input password required"), "label"=>__("Re-enter Password"), "type" => "password", "class"=>"set_size_input", "AUTOCOMPLETE" => "off"))?>
        <?php echo $this->Utils->form_separator();?>
        <?php echo $this->Form->end(array("label"=>__("Change Password"), "class"=>"link sc_button sc_button_blue"));?>
</div>