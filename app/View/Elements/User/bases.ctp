<?php
        $serial= -1;
        if(isset($this->data[$model])){
                foreach($this->data[$model] as $i=>$component){
                        if($i>$serial){
                                $serial= $i;
                        }
                }
        }
?>	
<div id="tr_base_folder" style="display:none" serial="<?php echo $serial?>">
        <table>
                <?php
                        $trs= array();
                        $tr= array();
                
                        $actions= array();
                        
						$button= array();
						$dialog_options= array();
						$dialog_options["title"]= "'".__("Select a Folder")."'";
						$dialog_options["width"]= 600;
						$dialog_options["dialog_id"]= SHORTCUTS_DIALOG_DIV;
						$button["dialog_options"]= $dialog_options;
						$button["class"]= "edit link crud_button ".CRUD_THEME." sc_button_gray sc_button_image_22";
						$button["url"]= array("plugin"=>null, "controller"=>$controller, "action"=>"select_folder", "REPLACEME");
						$button["label"]= $this->Html->image("crud/edit.gif", array("align"=>"absmiddle"));
						$actions[] = $button;
						
						$options= array();
						$options["onclick"]= "remove_row(this)";
						$button= array();
						$button["allowed"]= true;
						$button["class"]= "remove link crud_button ".CRUD_THEME." sc_button_gray sc_button_image_22";
						$button["html_options"]= $options;
						$button["label"]= $this->Html->image("crud/remove.gif", array("align"=>"absmiddle"));
						$actions[]= $button;
                        
                        $actions_buttons= $this->CustomTable->button_group($actions);
                        $tr[]= array($actions_buttons, array("class"=>"actions", "width"=>"60px"));
                        $tr[]= $this->Form->input("User.REPLACEME.Folders.folder", array("label"=>false, 'type' => 'hidden', 'div' => array('class' => 'input text two_column'))).
                        	$this->Form->label("User.REPLACEME.Folders.folder", "", array('id' => 'UserREPLACEMEFoldersFolder_label'));
                        
                        $trs[]= $tr;
                        
                        echo $this->Html->tableCells($trs);
                ?>
        </table>
</div>