<div id="upload_form">
    <div class="fmTH3" style="font-weight:normal; text-align:left; border:none; padding-top:5px;">
        <label for="fmReplSpaces"><input type="checkbox" id="fmReplSpaces" name="fmReplSpaces" value="1"<?php if(isset($replSpacesUpload) && $replSpacesUpload) print ' checked="checked"'; ?> /> file name =&gt; file_name</label><br/>
        <label for="fmLowerCase"><input type="checkbox" id="fmLowerCase" name="fmLowerCase" value="1"<?php if(isset($lowerCaseUpload) && $lowerCaseUpload) print ' checked="checked"'; ?> /> FileName =&gt; filename</label>
    </div>
    <div id="email_form" style="text-align:left;">
        <div class="form_section" style="display:block; margin-bottom:10px;">Send Notification</div>
        <label for="send_link"><input type="checkbox" id="send_link" name="send_link">	Include links in the notification</label>
        <br /><br />
        <?php
        include('class/db.php');
        
        if($user['Users']['all_roles']) {
            $result = mysql_query("SELECT * FROM users");
        } else {
            $user_id = $user['Users']['id'];
            $result = mysql_query("SELECT users.* FROM users_roles JOIN users ON users_roles.role_id = users.role_id WHERE users_roles.user_id = $user_id");
        }
        ?>
        <div id="notification_panels">
            <div class="notification_panel1">
                <label class="label_header">Select Users:</label>
                <select id="users_<?php echo $engine ?>" name="users_<?php echo $engine ?>" multiple="multiple" style="height: 135px; min-width:150px;">
                <?php while($row = mysql_fetch_array($result)):?>
                    <option value="<?php echo $row['id'] ?>"><?php echo $row['username'] ?></option>
                <?php endwhile;?>
                </select>
            </div>
            <?php
            $user_id = $user['Users']['id'];
            $result = mysql_query("SELECT * FROM groups WHERE groups.user_id = $user_id");
            ?>
            <div class="notification_panel2">
                <label class="label_header">Add Groups to Selection:</label>
                <div class="list_groups">
                <?php while($row = mysql_fetch_array($result)):?>
                    <div class="two_column"><label for="group_<?php echo $row['id'] ?>"><input id="group_<?php echo $row['id'] ?>" type="checkbox" name="groups[]" class="groupsc_<?php echo $engine ?>" value="<?php echo $row['id'] ?>"> <?php echo $row['name'] ?></label></div>
                <?php endwhile;?>
            </div>
        </div>
        </div>
        <label class="label_header">And/or type additional email address(es) to notify:</label>
        <input type="text" name="other_email" maxlength="200" style="width:640px;"/><br />
        <span class="help">Tip: Separate multiple email accounts with a comma (,). (i.e. <em>acc1@msn.com, acc2@aol.com; acc3@msn.com</em>)</span><br /><br />
        
        <div id="message_notification_upload">
            <label class="label_header">Additional Comments:</label>
            <textarea rows="10" cols="30" id="message_<?php echo $engine ?>" name="message_<?php echo $engine ?>"></textarea>
        </div>
    </div>
</div>

<script type="text/JavaScript" src="/js/ckeditor/ckeditor.js"></script>

<!--
<script>
	var instance = CKEDITOR.instances["message_<?php echo $engine ?>"];
	
    if(instance){
    	//delete CKEDITOR.instances["message_<?php echo $engine ?>"];
    	CKEDITOR.remove(instance);
    }

        CKEDITOR.replace
		( 
			'message_<?php echo $engine ?>',
			{
				height : "80",
				extraPlugins : 'autogrow',
				toolbar : 'basic',
				on : { 'instanceReady' : configureHtmlOutput }
	        }
		);
    
</script>
-->

<script>
	$('.groupsc_<?php echo $engine ?>').change(function(){
		var id = $(this).attr('id');
		var checked = 0;
		if($("#"+id).is(":checked"))
  		{
    		checked=1;
  		}
  
  		var value = $("#"+id).val();
  
  		if(checked == 0)
  		{
    		$.post('/Events/select_users_by_group', { group_id: value }, function(data){
      			$.each(data, function(user_id){
					$('#users_<?php echo $engine ?> option[value='+user_id+']').attr('selected', false);
  				});
			}, "json");
  		}
  
  		$(".groupsc_<?php echo $engine ?>").each(function(a, objx){ 
			var selected = $(objx);
			if(selected.is(":checked"))
			{
	  			$.post('/Events/select_users_by_group', { group_id: selected.val() }, function(data){
					$.each(data, function(user_id){
	  					$('#users_<?php echo $engine ?> option[value='+user_id+']').attr('selected', true);
					});
	  			}, "json");
		    } 
	    
	  	});
	
	});
</script>
