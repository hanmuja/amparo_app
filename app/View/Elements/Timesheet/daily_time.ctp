	<?php echo $this->Utils->form_section(__("Daily Time"));?>
	<?php 
	
		$ths= array();
		$ths[]= array("label"=>__("Location"));
		$ths[]= array("label"=>__("Hours"));
		
		$trs= array();
		if(isset($one["DailyTime"]) && $one["DailyTime"]){
                        $total_hours = 0;
                        $total_minutes = 0;
			foreach($one["DailyTime"] as $i=>$component){
				$tr= array();
				$tr[]= $component['Location']['name'];
                                $minutes = strlen($component['minutes']) == 1 ? '0'.$component['minutes'] : $component['minutes'];
				$tr[]= $component['hours'].":".$minutes;
				$trs[]= $tr;
                                $total_hours+=$component['hours'];
                                $total_minutes+=$component['minutes'];
			}
			$total_hours+=(int)($total_minutes/60);
                        $total_minutes=$total_minutes%60;
                        if($total_minutes==0)$total_minutes="00";
                        $total_minutes = strlen($total_minutes) == 1 ? '0'.$total_minutes : $total_minutes;
                        $hours_total = $total_hours.":".$total_minutes;
			$tr = array();
			$tr[] = array(__("TOTAL HOURS:"), array('class'=>'float_right bold'));
			$tr[] = array($hours_total, array('class'=>'bold'));
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
					"id"=>"show_daily_time_table",
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