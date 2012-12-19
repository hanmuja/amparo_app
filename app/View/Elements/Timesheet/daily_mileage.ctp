	<?php echo $this->Utils->form_section(__("Daily Mileage"));?>
	<?php 
	
		$ths= array();
		$ths[]= array("label"=>__("From Location"));
		$ths[]= array("label"=>__("To Location"));
		$ths[]= array("label"=>__("Round Trip"));
		$ths[]= array("label"=>__("Miles"));
		
		$trs= array();
		if(isset($one["DailyMileage"]) && $one["DailyMileage"]){
                        $total_mileages = 0;
			foreach($one["DailyMileage"] as $i=>$component){
                          
                          $mult = $component['round_trip'] ? 2 : 1;
                          
                          $mileages = 0;
                          $find = false;
                          foreach($component['FromLocation']['StartMile'] as $start)
                          {
                            if($start['location_end'] == $component['to_location_id'])
                            {
                              $mileages = $start['distance'] * $mult;
                              $find = true;
                            }
                          }
                          foreach($component['FromLocation']['EndMile'] as $start)
                          {
                            if($start['location_start'] == $component['to_location_id'] && !$find)
                            {
                              $mileages = $start['distance'] * $mult;
                              $find = true;
                            }
                          }
                          
                          $total_mileages+= $mileages;
                          
				$tr= array();
				$tr[]= $component['FromLocation']['name'];
                                $tr[]= $component['ToLocation']['name'];
                                $tr[]= $component['round_trip'] ? __("Yes") : __("No");
				$tr[]= $mileages;
				$trs[]= $tr;
			}
			
			$tr = array();
			$tr[] = null;
			$tr[] = null;
			$tr[] = array(__("TOTAL MILES:"), array('class'=>'float_right bold'));
			$tr[] = array($total_mileages, array('class' => 'bold'));
                        $trs[] = $tr;
		}
	?>
	<div class="form_section_body">
		<?php
			echo $this->CustomTable->table
			(
				$controller, 
				array
				(
					"ths"=>$ths,
					"trs"=>$trs,
				),
				array
				(
					"id"=>"show_daily_mileage_table",
					"parent_div"=>"purchase",
					"class_table"=>"promana-head-button",
					"message_empty"=>__("No item added."),
		            "use_ajax"=>true,
					"width"=>"100%",
		            "include_paginator"=>false
				)
			); 
		?>
	</div>