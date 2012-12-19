<div class="div_overview">
	<div id="overview_container">
		<h3>Problem Overview:</h3>
		<?php //echo $this->Utils->empty_div_row();?>
		<?php
			$label= array("label"=>__("Current Problem Type:"), "options"=>array("class"=>"problem_overview_title"));
			$value= array("label"=>ucwords($one["ProblemType"]["name"]));
			echo $this->Utils->div_row(array($label, $value));
		?>
		<?php echo $this->Utils->empty_div_row();?>
		<?php
			$label= array("label"=>__("Original Problem Type:"), "options"=>array("class"=>"problem_overview_title"));
			$value= array("label"=>ucwords($one["FirstProblemType"]["name"]));
			echo $this->Utils->div_row(array($label, $value));
		?>
		<?php echo $this->Utils->empty_div_row();?>
		<?php
			$label= array("label"=>__("Opened On:"), "options"=>array("class"=>"problem_overview_title"));
			$value= array("label"=>date("F j, Y \a\t g:i A", $one[$model]["created"]));
			echo $this->Utils->div_row(array($label, $value));
		?>
		<hr class="dotted_hr"/>
		<?php echo $this->Utils->empty_div_row();?>
		<?php
			$label= array("label"=>__("Route:"), "options"=>array("class"=>"problem_overview_title"));
			$value= array("label"=>(isset($one["Equipment"]["Location"]["Route"]["name"]))?$one["Equipment"]["Location"]["Route"]["name"]:__("-- Unasigned Route --"));
			echo $this->Utils->div_row(array($label, $value));
		?>
		<?php echo $this->Utils->empty_div_row();?>
		<?php
			$label= array("label"=>__("Location:"), "options"=>array("class"=>"problem_overview_title"));
			$value= array("label"=>$one["Equipment"]["Location"]["name"]);
			echo $this->Utils->div_row(array($label, $value));
		?>
		<?php echo $this->Utils->empty_div_row();?>
		<?php
			$label= array("label"=>__("Game:"), "options"=>array("class"=>"problem_overview_title"));
			$value= array("label"=>$one["Equipment"]["Game"]["name"]);
			echo $this->Utils->div_row(array($label, $value));
		?>
		<?php //echo $this->Utils->empty_div_row();?>
		<?php
			//$label= array("label"=>__("Equipment Description:"), "options"=>array("class"=>"problem_overview_title"));
			//$value= array("label"=>nl2br($one["Equipment"]["description"]));
			//echo $this->Utils->div_row(array($label, $value));
		?>
		<?php echo $this->Utils->empty_div_row();?>
		<?php
			$label= array("label"=>__("Equipment Type:"), "options"=>array("class"=>"problem_overview_title"));
			$value= array("label"=>nl2br($one["Equipment"]["EquipmentType"]["name"]));
			echo $this->Utils->div_row(array($label, $value));
		?>
	</div>
</div>