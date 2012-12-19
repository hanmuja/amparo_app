<?php
        $serial= 0;
        if(isset($this->data["DailyTime"]) && $this->data["DailyTime"]){
                foreach($this->data["DailyTime"] as $i=>$component){
                        if($i>$serial){
                                $serial= $i;
                        }
                }
        }
?>	
<div id="tr_base_time" style="display:none" serial="<?php echo $serial?>">
        <table>
                <?php
                        $trs= array();
                        $tr= array();
                
                        $actions= array();
                        $options= array();
                        $options["onclick"]= "remove_row(this)";
                        $button= array();
                        $button["allowed"]= true;
                        $button["class"]= "remove link crud_button ".CRUD_THEME." sc_button_gray sc_button_image_22";
                        $button["html_options"]= $options;
                        $button["label"]= $this->Html->image("crud/remove.gif", array("align"=>"absmiddle"));
                        $actions[]= $button;
                        
                        $actions_buttons= $this->CustomTable->button_group($actions);
                        $tr[]= array($actions_buttons, array("class"=>"actions", "width"=>"30px"));
                        $tr[]= $this->Form->input("DailyTime.REPLACEME.location_id", array("label"=>false, "options"=>$locations, "empty"=>EMPTY_OPTION));

                        $tr[]= $this->Form->input("DailyTime.REPLACEME.hours_all", array("type"=>'text',"label"=>false, 'size' => '3', 'autocomplete'=> 'off', 'default' => '00:00'));
                        
                        $trs[]= $tr;
                        
                        echo $this->Html->tableCells($trs);
                ?>
        </table>
</div>

<?php
        $serial= 0;
        if(isset($this->data["DailyMileage"]) && $this->data["DailyMileage"]){
                foreach($this->data["DailyMileage"] as $i=>$component){
                        if($i>$serial){
                                $serial= $i;
                        }
                }
        }
?>      
<div id="tr_base_mileage" style="display:none" serial="<?php echo $serial?>">
        <table>
                <?php
                        $trs= array();
                        $tr= array();
                
                        $actions= array();
                        $options= array();
                        $options["onclick"]= "remove_row(this)";
                        $button= array();
                        $button["allowed"]= true;
                        $button["class"]= "remove link crud_button ".CRUD_THEME." sc_button_gray sc_button_image_22";
                        $button["html_options"]= $options;
                        $button["label"]= $this->Html->image("crud/remove.gif", array("align"=>"absmiddle"));
                        $actions[]= $button;
                        
                        $actions_buttons= $this->CustomTable->button_group($actions);
                        $tr[]= array($actions_buttons, array("class"=>"actions", "width"=>"30px"));
                        $tr[]= $this->Form->input("DailyMileage.REPLACEME.from_location_id", array("label"=>false, "options"=>$locations, "empty"=>EMPTY_OPTION));
                        $tr[]= $this->Form->input("DailyMileage.REPLACEME.to_location_id", array("label"=>false, "options"=>$locations, "empty"=>EMPTY_OPTION));
                        $tr[]= $this->Form->input("DailyMileage.REPLACEME.round_trip", array("type"=>'checkbox',"label"=>false));
                        
                        $trs[]= $tr;
                        
                        echo $this->Html->tableCells($trs);
                ?>
        </table>
</div>