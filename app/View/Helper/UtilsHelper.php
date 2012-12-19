<?php
	App::uses('AppHelper', 'View/Helper');

    class UtilsHelper extends AppHelper
    {
		public $helpers= array("Session", "Html", "Form", "Js"=>array("Jquery"));
        
        function infobox($texto)
        {
            return $this->Html->div("infobox", $texto);
        }
        
        /**
         * Function for sum hours totals in a day
         */
        
        function getSumWeek($values)
        {
          if(!$values['Week']['is_empty'])
          {
            $total_hours_week = 0;
            $total_minutes_week = 0;
            $total_mileages_week = 0;
            $total_tolls_week = 0;
            
            $return = array();
            
            foreach($values['Day'] as $day)
            {
              if(!$day['is_empty'])
              {
                /*******hours*******/
                $hours = 0;
                $minutes = 0;
                foreach($day['DailyTime'] as $daily_time)
                {
                  $hours=(int)$hours+$daily_time['hours'];
                  $minutes=(int)$minutes+$daily_time['minutes'];
                }
                $hours+=(int)($minutes/60);
                $minutes=$minutes%60;
                if($minutes==0)$minutes="00";
                
                if(strlen($minutes) == 1) $minutes = '0'.$minutes;
                $return['hours'][$day['id']] = $hours.":".$minutes;
                
                $total_hours_week+= $hours;
                $total_minutes_week+= $minutes;
                
                /**********mileages*********/
                $mileages = 0;
                foreach($day['DailyMileage'] as $daily_mileage)
                {
                  $mult = $daily_mileage['round_trip'] ? 2 : 1;
                  $find = false;
                  foreach($daily_mileage['FromLocation']['StartMile'] as $miles)
                  {
                    if($miles['location_end'] == $daily_mileage['ToLocation']['id'])
                    {
                      $mileages+= $miles['distance'] * $mult;
                      $find = true;
                    }
                  }
                  foreach($daily_mileage['FromLocation']['EndMile'] as $miles)
                  {
                    if($miles['location_start'] == $daily_mileage['ToLocation']['id'] && !$find)
                    {
                      $mileages+= $miles['distance'] * $mult;
                      $find = true;
                    }
                  }
                }
                $mileages+=$day['additional_mileage'];
                $return['mileages'][$day['id']] = $mileages;
				
                $total_mileages_week+= $mileages;
                
                /**********tolls***********/
                $total_tolls_week+=$day['tolls'];
              }
              else
              {
                $return['hours'][$day['id']] = '';
                $return['mileages'][$day['id']] = 0;
              }
            }
			
			  $total_hours_week+=(int)($total_minutes_week/60);
              $total_minutes_week= $total_minutes_week%60;
				
              if(strlen($total_minutes_week) == 1) $total_minutes_week = '0'.$total_minutes_week;
              $return['hours']['total'] = $total_hours_week.":".$total_minutes_week;
              $return['mileages']['total'] = $total_mileages_week;
              $return['tolls']['total'] = $total_tolls_week;
              
              return $return;
          }
          else
            return false;
        }
        
        function getMiles($daily_mileage)
        {
          $mult = $daily_mileage['round_trip'] ? '2' : '1';
          if(isset($daily_mileage['FromLocation']['StartMile'])):
          foreach($daily_mileage['FromLocation']['StartMile'] as $miles)
          {
            if($miles['location_end'] == $daily_mileage['ToLocation']['id'])
            {
               return $miles['distance'] * $mult;
            }
          }
          endif;
          if(isset($daily_mileage['FromLocation']['EndMile'])):
          foreach($daily_mileage['FromLocation']['EndMile'] as $miles)
          {
            if($miles['location_start'] == $daily_mileage['ToLocation']['id'])
            {
              return $miles['distance'] * $mult;
            }
          }
          endif;
          return 0;
        }
        
		
		function caption($label, $class="seccion")
		{
			return $this->Html->tag("div", $label, array("style"=>"display:block;", "class"=>$class));
		}
		
		function empty_div_row($height=EMPTY_DIV_ROW_HEIGHT)
		{
			$div= $this->Html->tag("div", "", array("style"=>"display:table-row; height: ".$height));
			
			return $div;
		}
		
		function form_section($label="")
		{
			$div= $this->Html->tag("div", $label, array("class"=>"form_section", "style"=>"display:block;"));
			
			return $div;
		}
		
		function form_separator($height=EMPTY_DIV_ROW_HEIGHT, $border_bottom="2px solid #DCDCDC")
		{	
			return $this->Html->tag("div", " ", array("style"=>"height: ".$height."; border-bottom: ".$border_bottom."; margin-bottom: 5px;"));
		}
		
		function div_row($celdas, $div_options=array())
		{	
			$c= "";
			foreach($celdas as $celda)
			{
				extract($celda);
				if(!isset($options))
				$options= array();
				
				/*if(isset($options["style"]))
				$options["style"].= "; display: table-cell;";
				else
				$options["style"]= "display: table-cell;";*/
				
				if(!$label)
				$label= " ";
				
				$c.= $this->Html->tag("div", $label, $options);
				
				unset($label, $options);
			}
			
			/*if(isset($div_options["style"]))
			$div_options["style"].= "; display: table-row;";
			else
			$div_options["style"]= "display: table-row;";*/
			
			if(isset($div_options["class"]))
			$div_options["class"].= " div-row";
			else
			$div_options["class"]= "div-row";
			
			return $this->Html->tag("div", $c, $div_options);
		}
		
		function datepicker_headers($time=false, $lang=false)
		{
			$h = "";
			
			$h.= $this->Html->script("ui/minified/jquery.ui.datepicker.min");
			if($time)
			{
				$h.= $this->Html->css("jquery.ui.timepicker");
				$h.= $this->Html->script("ui/minified/jquery.ui.slider.min");
				$h.= $this->Html->script("ui/jquery.ui.timepicker");
			}	
			
			if($lang)
			{
				$h.= $this->Html->script("ui/i18n/jquery.ui.datepicker-".$lang);
			}
					
			return $h;
		}
		
		function get_main_menu()
		{
			$main_menu= array();
			
			//////////////////////////////////////
			
			$tickets= array();
			$tickets["label"]= __("Trouble Tickets");
			$tickets["url"]= array();
			$tickets["children"]= array();
				
				$child= array();
				$child["label"]= __("Trouble Tickets");
				$child["url"]= array("plugin"=>null, "controller"=>"Problems", "action"=>"index");
				//$child["virtual"]= true;
				$child["children"]= array();
			$tickets["children"][]= $child;
			
				$child= array();
				$child["label"]= __("Selected Ticket History");
				$child["url"]= array("plugin"=>null, "controller"=>"Problems", "action"=>"problem_history");
				$child["virtual"]= true;
				$child["show_tab_on_selected"]= true;
				$child["children"]= array();
			$tickets["children"][]= $child;
			
			//////////////////////////////////////
			
			/*$orders= array();
			$orders["label"]= __("Part Orders");
			$orders["url"]= array();
			$orders["children"]= array();*/
				$child= array();
				$child["label"]= __("Process Part Orders");
				$child["url"]= array("plugin"=>null, "controller"=>"PartOrders", "action"=>"index");
				//$child["virtual"]= true;
				$child["children"]= array();
			$tickets["children"][]= $child;
			
				$child= array();
				$child["label"]= __("Selected Part Order");
				$child["url"]= array("plugin"=>null, "controller"=>"PartOrders", "action"=>"order_history");
				$child["virtual"]= true;
				$child["show_tab_on_selected"]= true;
				$child["children"]= array();
			$tickets["children"][]= $child;
                        
                        //////////////////////////////////////
                        
                        $timesheet= array();
                        $timesheet["label"]= __("Time Sheet");
                        $timesheet["url"]= array();
                        $timesheet["children"]= array();
                                
                                $child= array();
                                $child["label"]= __("Time Sheet");
                                $child["url"]= array("plugin"=>null, "controller"=>"Timesheets", "action"=>"index");
                                $child["children"]= array();
                                        
                        $timesheet["children"][]= $child;
                        
                                $child= array();
                                $child["label"]= __("Individual Report");
                                $child["url"]= array("plugin"=>null, "controller"=>"Timesheets", "action"=>"individual_reports");
                                $child["children"]= array();
                                
                        $timesheet["children"][]= $child;
                        
                                $child= array();
                                $child["label"]= __("Hours per Locations");
                                $child["url"]= array("plugin"=>null, "controller"=>"Timesheets", "action"=>"hours_per_location");
                                $child["children"]= array();
                                
                        $timesheet["children"][]= $child;
			
			//////////////////////////////////////
			
			$inventory= array();
			$inventory["label"]= __("Inventory");
			$inventory["url"]= array();
			$inventory["children"]= array();
				
				$child= array();
				$child["label"]= __("Equipment");
				$child["url"]= array();
				$child["children"]= array();
				
					$subchild= array();
					$subchild["label"]= __("Game List");
					$subchild["url"]= array("plugin"=>null, "controller"=>"Equipment", "action"=>"index");
					$subchild["children"]= array();
					$child["children"][]= $subchild;
					
					$subchild= array();
					$subchild["label"]= __("Selected Game");
					$subchild["url"]= array("plugin"=>null, "controller"=>"Equipment", "action"=>"report_by_equipment");
					$subchild["virtual"]= true;
					$subchild["show_tab_on_selected"]= true;
					$subchild["children"]= array();
					$child["children"][]= $subchild;
					
					$subchild= array();
					$subchild["label"]= __("Equipment Types");
					$subchild["url"]= array("plugin"=>null, "controller"=>"EquipmentTypes", "action"=>"index");
					$subchild["children"]= array();
					$child["children"][]= $subchild;
					
					$subchild= array();
					$subchild["label"]= __("Parts");
					$subchild["url"]= array("plugin"=>null, "controller"=>"Parts", "action"=>"index");
					$subchild["children"]= array();
					$child["children"][]= $subchild;
					
					$subchild= array();
					$subchild["label"]= __("Locations");
					$subchild["url"]= array("plugin"=>null, "controller"=>"Locations", "action"=>"index");
					$subchild["virtual"]= true;
					$subchild["children"]= array();
					$child["children"][]= $subchild;
					
					$subchild= array();
					$subchild["label"]= __("Selected Location");
					$subchild["url"]= array("plugin"=>null, "controller"=>"Locations", "action"=>"report_by_location");
					$subchild["virtual"]= true;
					$subchild["show_tab_on_selected"]= true;
					$subchild["children"]= array();
					$child["children"][]= $subchild;
					
					$subchild= array();
					$subchild["label"]= __("Routes");
					$subchild["url"]= array("plugin"=>null, "controller"=>"Routes", "action"=>"index");
					$subchild["virtual"]= true;
					$subchild["children"]= array();
					$child["children"][]= $subchild;
					
			$inventory["children"][]= $child;
			
				$child= array();
				$child["label"]= __("Locations");
				$child["url"]= array();
				$child["children"]= array();
				
					$subchild= array();
					$subchild["label"]= __("Locations");
					$subchild["url"]= array("plugin"=>null, "controller"=>"Locations", "action"=>"index");
					$subchild["children"]= array();
					$child["children"][]= $subchild;
					
					$subchild= array();
					$subchild["label"]= __("Routes");
					$subchild["url"]= array("plugin"=>null, "controller"=>"Routes", "action"=>"index");
					$subchild["children"]= array();
					$child["children"][]= $subchild;
			$inventory["children"][]= $child;
			
			////////////////////////////////////////
			
			$inicio = array();
			$inicio['label'] = __("Inicio");
			$inicio['url'] = array();
			$inicio['children'] = array();
			
				$child= array();
				$child["label"]= __("Vouchers");
				$child["url"]= array("plugin"=>null, "controller"=>"Vouchers", "action"=>"index");
				//$child["virtual"]= true;
				$child["children"]= array();
			$inicio['children'][] = $child;
			
				$child= array();
				$child["label"]= __("Vendedores");
				$child["url"]= array("plugin"=>null, "controller"=>"Sellers", "action"=>"index");
				//$child["virtual"]= true;
				$child["children"]= array();
			$inicio['children'][] = $child;
			
				$child= array();
				$child["label"]= __("Proveedores");
				$child["url"]= array("plugin"=>null, "controller"=>"Providers", "action"=>"index");
				//$child["virtual"]= true;
				$child["children"]= array();
			$inicio['children'][] = $child;
			//////////////////////////////////////////
			
			$categories= array();
			$categories["label"]= __("Gallery");
			$categories["url"]= array();
			$categories["children"]= array();
			
				$child= array();
				$child["label"]= __("Categories");
				$child["url"]= array("plugin"=>null, "controller"=>"Categories", "action"=>"index");
				$child["virtual"]= true;
				$child["children"]= array();
			$categories["children"][]= $child;
			
				$child= array();
				$child["label"]= __("Sort Categories");
				$child["url"]= array("plugin"=>null, "controller"=>"Categories", "action"=>"sort_categories");
				$child["virtual"]= true;
				$child["show_tab_on_selected"]= true;
				$child["children"]= array();
			$categories["children"][]= $child;
			
				$child= array();
				$child["label"]= __("Add Pictures");
				$child["url"]= array("plugin"=>null, "controller"=>"Categories", "action"=>"add_pictures");
				$child["virtual"]= true;
				$child["show_tab_on_selected"]= true;
				$child["children"]= array();
			$categories["children"][]= $child;
			
			////////////////////////////////////////
			
			$blogs= array();
			$blogs["label"]= __("Blog");
			$blogs["url"]= array();
				$child= array();
				$child["label"]= __("Post");
				$child["url"]= array("plugin"=>null, "controller"=>"Posts", "action"=>"index", "blog");
				$child["children"]= array();
			$blogs["children"][]= $child;
				$child= array();
				$child["label"]= __("FAQ's");
				$child["url"]= array("plugin"=>null, "controller"=>"Posts", "action"=>"index", "faqs");
				$child["children"]= array();
			$blogs["children"][]= $child;
					
			////////////////////////////////////////
			
			$events= array();
			$events["label"]= __("Events");
			$events["url"]= array();
			$events["children"]= array();
				$child= array();
				$child["label"]= __("Events");
				$child["url"]= array("plugin"=>null, "controller"=>"Events", "action"=>"index");
				$child["virtual"]= true;
				$child["children"]= array();
			$events["children"][]= $child;
			
			////////////////////////////////////////////////////////////
			
			$fm= array();
			$fm["label"]= __("File Manager");
			$fm["url"]= array();
			$fm["children"]= array();
				$child= array();
				$child["label"]= __("File Manager");
				$child["url"]= array("plugin"=>null, "controller"=>"Filemanagers", "action"=>"index");
				$child["virtual"]= true;
				$child["children"]= array();
			$fm["children"][]= $child;
			
			////////////////////////////////////////////////////////////
			
			$licences= array();
			$licences["label"]= __("Licences");
			$licences["url"]= array();
			$licences["children"]= array();
				$child= array();
				$child["label"]= __("Licences");
				$child["url"]= array("plugin"=>null, "controller"=>"Licences", "action"=>"index");
				$child["virtual"]= true;
				$child["children"]= array();
			$licences["children"][]= $child;
			
			////////////////////////////////////////////////////////////
			
			$user= array();
			$user["label"]= $this->Session->read("Auth.User.first_name")." ".$this->Session->read("Auth.User.last_name");
			$user["url"]= array();
			$user["html_options"]= array("class"=>"user_nav", "style"=>"cursor:default");
			$user["children"]= array();
				
				$child= array();
				$child["label"]= __("My Account");
				$child["url"]= array();
				$child["children"]= array();
					
					$subchild= array();
					$subchild["label"]= __("Users");
					$subchild["url"]= array("plugin"=>null, "controller"=>"Users", "action"=>"index");
					$subchild["virtual"]= true;
					$subchild["children"]= array();
					$child["children"][]= $subchild;
					
					$subchild= array();
					$subchild["label"]= __("Pending");
					$subchild["url"]= array("plugin"=>null, "controller"=>"Users", "action"=>"pending");
					$subchild["virtual"]= true;
					$subchild["children"]= array();
					$child["children"][]= $subchild;	
				
					$subchild= array();
					$subchild["label"]= __("Roles");
					$subchild["url"]= array("plugin"=>null, "controller"=>"Roles", "action"=>"index");
					$subchild["virtual"]= true;
					$subchild["children"]= array();
					$child["children"][]= $subchild;
					
					$subchild= array();
					$subchild["label"]= __("Groups");
					$subchild["url"]= array("plugin"=>null, "controller"=>"Groups", "action"=>"index");
					$subchild["virtual"]= true;
					$subchild["children"]= array();
					$child["children"][]= $subchild;
					
					$subchild= array();
					$subchild["label"]= __("Configurations");
					$subchild["url"]= array("plugin"=>null, "controller"=>"Configurations", "action"=>"index");
					$subchild["virtual"]= true;
					$subchild["children"]= array();
					$child["children"][]= $subchild;
					
					$subchild= array();
					$subchild["label"]= __("Update my Account");
					$subchild["url"]= array("plugin"=>null, "controller"=>"Users", "action"=>"update_account");
					$subchild["children"]= array(); 
					$child["children"][]= $subchild;	
				
					$subchild= array();
					$subchild["label"]= __("Change my Password");
					$subchild["url"]= array("plugin"=>null, "controller"=>"Users", "action"=>"change_password");
					$subchild["children"]= array();    
					$child["children"][]= $subchild;
					
					$subchild= array();
					$subchild["label"]= __("Email Templates");
					$subchild["url"]= array("plugin"=>null, "controller"=>"EmailTemplates", "action"=>"index");
					$subchild["virtual"]= true;
					$subchild["children"]= array();
					$child["children"][]= $subchild;
					
					$subchild= array();
					$subchild["label"]= __("Lists");
					$subchild["url"]= array("plugin"=>null, "controller"=>"ConfigLists", "action"=>"index");
					$subchild["virtual"]= true;
					$subchild["children"]= array();
					$child["children"][]= $subchild;
					
					$subchild= array();
					$subchild["label"]= __("Sites");
					$subchild["url"]= array("plugin"=>null, "controller"=>"Sites", "action"=>"index");
					$subchild["virtual"]= true;
					$subchild["children"]= array();
					$child["children"][]= $subchild;
					
					$subchild= array();
					$subchild["label"]= __("Languages");
					$subchild["url"]= array("plugin"=>null, "controller"=>"Languages", "action"=>"index");
					$subchild["virtual"]= true;
					$subchild["children"]= array();
					$child["children"][]= $subchild;
					
					$subchild= array();
					$subchild["label"]= __("Build ACOs");
					$subchild["url"]= array("plugin"=>null, "controller"=>"Acos", "action"=>"build_acos");
					$subchild["virtual"]= true;
					$subchild["children"]= array();
					$child["children"][]= $subchild;
					
					$subchild= array();
					$subchild["label"]= __("Build Missing AROs");
					$subchild["url"]= array("plugin"=>null, "controller"=>"Aros", "action"=>"build_missing_aros");
					$subchild["virtual"]= true;
					$subchild["children"]= array();
					$child["children"][]= $subchild;
					
					$subchild= array();
					$subchild["label"]= __("Clear ACOs");
					$subchild["url"]= array("plugin"=>null, "controller"=>"Acos", "action"=>"clear_acos");
					$subchild["virtual"]= true;
					$subchild["children"]= array();
					$child["children"][]= $subchild;
					
					$subchild= array();
					$subchild["label"]= __("Friendly Permissions");
					$subchild["url"]= array("plugin"=>null, "controller"=>"FriendlyPermissionsTables", "action"=>"index");
					$subchild["virtual"]= true;
					$subchild["children"]= array();
					$child["children"][]= $subchild;
					
					$subchild= array();
					$subchild["label"]= __("Permissions Table Paths");
					$subchild["url"]= array("plugin"=>null, "controller"=>"FriendlyPermissionsTables", "action"=>"paths");
					$subchild["virtual"]= true;
					$subchild["show_tab_on_selected"]= true;
					$subchild["children"]= array();
					$child["children"][]= $subchild;
					
					$subchild= array();
					$subchild["label"]= __("Role Permissions");
					$subchild["url"]= array("plugin"=>null, "controller"=>"ArosAcos", "action"=>"role_permissions");
					$subchild["virtual"]= true;
					$subchild["children"]= array();
					$child["children"][]= $subchild;
					
					$subchild= array();
					$subchild["label"]= __("Users Permissions");
					$subchild["url"]= array("plugin"=>null, "controller"=>"ArosAcos", "action"=>"users_permissions");
					$subchild["virtual"]= true;
					$subchild["children"]= array();
					$child["children"][]= $subchild;
					
					$subchild= array();
					$subchild["label"]= __("Logout");
					$subchild["url"]= array("plugin"=>null, "controller"=>"Users", "action"=>"logout");
					$subchild["virtual"]= true;
					$subchild["children"]= array();
					$child["children"][]= $subchild;
			$user["children"][]= $child;
			
				$child= array();
				$child["label"]= __("Accounts");
				$child["url"]= array();
				$child["children"]= array();
					
					$subchild= array();
					$subchild["label"]= __("Users");
					$subchild["url"]= array("plugin"=>null, "controller"=>"Users", "action"=>"index");
					$subchild["children"]= array();
					$child["children"][]= $subchild;
					
					$subchild= array();
					$subchild["label"]= __("Pending");
					$subchild["url"]= array("plugin"=>null, "controller"=>"Users", "action"=>"pending");
					$subchild["children"]= array();
					$child["children"][]= $subchild;	
				
					$subchild= array();
					$subchild["label"]= __("Roles");
					$subchild["url"]= array("plugin"=>null, "controller"=>"Roles", "action"=>"index");
					$subchild["children"]= array();
					$child["children"][]= $subchild;
					
					$subchild= array();
					$subchild["label"]= __("Groups");
					$subchild["url"]= array("plugin"=>null, "controller"=>"Groups", "action"=>"index");
					$subchild["children"]= array();
					$child["children"][]= $subchild;
					
					$subchild= array();
					$subchild["label"]= __("Configurations");
					$subchild["url"]= array("plugin"=>null, "controller"=>"Configurations", "action"=>"index");
					$subchild["children"]= array();
					$child["children"][]= $subchild;
					
			$user["children"][]= $child;
			
				$child= array();
				$child["label"]= __("Configuration");
				$child["url"]= array();
				$child["children"]= array();
				
					$subchild= array();
					$subchild["label"]= __("Email Templates");
					$subchild["url"]= array("plugin"=>null, "controller"=>"EmailTemplates", "action"=>"index");
					$subchild["children"]= array();
					$child["children"][]= $subchild;
					
					$subchild= array();
					$subchild["label"]= __("Lists");
					$subchild["url"]= array("plugin"=>null, "controller"=>"ConfigLists", "action"=>"index");
					$subchild["children"]= array();
					$child["children"][]= $subchild;
					
					$subchild= array();
					$subchild["label"]= __("Sites");
					$subchild["url"]= array("plugin"=>null, "controller"=>"Sites", "action"=>"index");
					$subchild["children"]= array();
					$child["children"][]= $subchild;
					
					$subchild= array();
					$subchild["label"]= __("Languages");
					$subchild["url"]= array("plugin"=>null, "controller"=>"Languages", "action"=>"index");
					$subchild["children"]= array();
					$child["children"][]= $subchild;
					
			$user["children"][]= $child;
			
				$child= array();
				$child["label"]= __("ACL");
				$child["url"]= array();
				$child["children"]= array();
									
					$subchild= array();
					$subchild["label"]= __("Build ACOs");
					$subchild["url"]= array("plugin"=>null, "controller"=>"Acos", "action"=>"build_acos");
					$subchild["children"]= array();
					$child["children"][]= $subchild;
					
					$subchild= array();
					$subchild["label"]= __("Build Missing AROs");
					$subchild["url"]= array("plugin"=>null, "controller"=>"Aros", "action"=>"build_missing_aros");
					$subchild["children"]= array();
					$child["children"][]= $subchild;
										
					$subchild= array();
					$subchild["label"]= __("Clear ACOs");
					$subchild["url"]= array("plugin"=>null, "controller"=>"Acos", "action"=>"clear_acos");
					$subchild["children"]= array();
					$child["children"][]= $subchild;
					
					$subchild= array();
					$subchild["label"]= __("Friendly Permissions");
					$subchild["url"]= array("plugin"=>null, "controller"=>"FriendlyPermissionsTables", "action"=>"index");
					$subchild["children"]= array();
					$child["children"][]= $subchild;
					
					$subchild= array();
					$subchild["label"]= __("Permissions Table Paths");
					$subchild["url"]= array("plugin"=>null, "controller"=>"FriendlyPermissionsTables", "action"=>"paths");
					$subchild["virtual"]= true;
					$subchild["show_tab_on_selected"]= true;
					$subchild["children"]= array();
					$child["children"][]= $subchild;
				
					$subchild= array();
					$subchild["label"]= __("Role Permissions");
					$subchild["url"]= array("plugin"=>null, "controller"=>"ArosAcos", "action"=>"role_permissions");
					$subchild["children"]= array();
					$child["children"][]= $subchild;
					
					$subchild= array();
					$subchild["label"]= __("Users Permissions");
					$subchild["url"]= array("plugin"=>null, "controller"=>"ArosAcos", "action"=>"users_permissions");
					$subchild["children"]= array();
					$child["children"][]= $subchild;
			$user["children"][]= $child;
			
				$child= array();
				$child["label"]= __("Logout");
				$child["url"]= array("plugin"=>null, "controller"=>"Users", "action"=>"logout");
				$child["children"]= array();	
				$user["children"][]= $child;
			
			////////////////////////////////////////////////////////////
			//$main_menu[]= $tickets;
			//$main_menu[]= $timesheet;
			//$main_menu[]= $inventory;
			//$main_menu[]= $categories;
			//$main_menu[]= $blogs;
			//$main_menu[]= $events;
			//$main_menu[]= $fm;
			//$main_menu[]= $licences;
			$main_menu[]= $inicio;
			//$main_menu[]= $user;
			
			$real_main_menu= array();
			foreach($main_menu as $menu){
				$real_menu= $this->resolve_menu($menu);
				if($real_menu)
				{
					$real_main_menu["children"][]= $real_menu;
				}
			}
			
			
			return $real_main_menu;
		}

		function get_top_menu(){
			$main_menu= $this->get_main_menu();
			if(isset($main_menu["children"]) && $main_menu["children"]){
				foreach($main_menu["children"] as $i=>$menu){
					$new_menu= $this->valid_children($menu); 
					if($new_menu){
						$main_menu["children"][$i]= $new_menu;
					}
					else{
						unset($main_menu["children"][$i]);
					}
				}
			}
			
			return $main_menu;
		}
		
		function valid_children($menu){
			if(!$menu["children"] && isset($menu["virtual"])){
				return false;
			}
			
			$valid_count=0;
			if($menu["children"]){
				foreach($menu["children"] as $i=>$child){
					$new_child= $this->valid_children($child);
					if($new_child){
						$valid_count++;
						$menu["children"][$i]= $new_child;
					}
				}
			}
			$menu["valid_children"]= $valid_count;
			
			return $menu;
		}
		
		function get_account_menu()
		{
			if($this->Session->check("Auth.User.id")){
				//Default Options
				$my_account= array();
				$my_account["label"]= $this->Session->read("Auth.User.first_name")." ".$this->Session->read("Auth.User.last_name");
				$my_account["url"]= '#';
				$my_account["children"]= array();
				
				$child= array();
						$child["label"]= __("Update my Account");
						$child["url"]= array("plugin"=>null, "controller"=>"Users", "action"=>"update_account");
						$child["children"]= array();    
				$my_account["children"][]= $child;
				
				$child= array();
						$child["label"]= __("Change my Password");
						$child["url"]= array("plugin"=>null, "controller"=>"Users", "action"=>"change_password");
						$child["children"]= array();    
				$my_account["children"][]= $child;
				
				$child= array();
					$child["label"]= __("Logout");
					$child["url"]= array("plugin"=>null, "controller"=>"Users", "action"=>"logout");
					$child["children"]= array();	
				$my_account["children"][]= $child;
                                
				$my_account;
				
				return $my_account;
			}
			return false;
		}
		
		function resolve_menu(&$menu){
			if($menu["children"]){
				foreach($menu["children"] as $i=>$child){
					$real_child= $this->resolve_menu($child);
					if($real_child){
						$menu["children"][$i]= $real_child;
					}
					else{
						unset($menu["children"][$i]);
					}
				}
				
				if($menu["children"]){
					reset($menu["children"]);
					$first_child_key= key($menu["children"]);
					$menu["url"]= $menu["children"][$first_child_key]["url"];
					
					return $menu;
				}
				else{
					return false;	
				}
			}
			else{
				if($menu["url"] && in_array($menu["url"]["controller"], array('Vouchers', 'Providers', 'Sellers')))
				{
					return $menu;
				}
				elseif($menu["url"] && $this->has_permission($menu["url"])){
					return $menu;
				}
				else{
					return false;
				}
			}
		}
		
		function is_here($menu){
			$here= array();
			$here["plugin"]= $this->params["plugin"];
			$here["controller"]= $this->params["controller"];
			$here["action"]= $this->params["action"];
			
			$here= $this->Html->url($here, true);
			if($menu["url"]){
				$menu_url= $this->Html->url($menu["url"], true);
				if($menu_url==$here)
				{
					return true;
				}
			}
			
			if($menu["children"]){
				foreach($menu["children"] as $child){
					if($this->is_here($child)){
						return true;
					}
				}
			}
			
			return false;
		}

		function has_permission($url){
			if (!is_array($url)){
				return false;
			}

			extract($url);
	
			$permission = 'controllers/';
			$permission .= isset($plugin) ? Inflector::camelize($plugin) : '';
			$permission .= (isset($plugin) && isset($controller)) ? '/' : '';
			$permission .= isset($controller) ? Inflector::camelize($controller) : '';
			$permission .= (isset($controller) && isset($action)) ? '/' : '';
			$permission .= (isset($prefix) && in_array($prefix, Configure::read('Routing.prefixes'))) ? $prefix.'_' : '';
			$permission .= isset($action) ? str_replace("/","", $action): '';
			
			$permissions = $this->Session->read('Auth.Permissions');
			
			return isset($permissions[$permission]);
		}
		
		function get_urls_same_level(){
			$main_menu= $this->get_main_menu();
			$level_parent= array();
			if($main_menu && $main_menu["children"]){
				foreach($main_menu["children"] as $menu){
					$partial_answer= $this->level_parent($menu, $main_menu);
					if($partial_answer){
						$level_parent= $partial_answer;
						break;
					}
				}		
			}
			
			$here= array();
			$here["plugin"]= $this->params["plugin"];
			$here["controller"]= $this->params["controller"];
			$here["action"]= $this->params["action"];
			
			$here= $this->Html->url($here, true);
			
			$urls= array();
			if($level_parent){
				foreach($level_parent["children"] as $lp){
					$new_url= array();
					$new_url["label"]= $lp["label"];
					$new_url["url"]= $this->Html->url($lp["url"], true);
					
					if($new_url["url"]==$here){
						$new_url["selected"]= true;
						$new_url["show"]= true;
					}
					else{
						$new_url["selected"]= false;
						if(isset($lp["show_tab_on_selected"]) && $lp["show_tab_on_selected"]){
							$new_url["show"]= false;
						}
						else{
							$new_url["show"]= true;
						}
					}
					$urls[]= $new_url;
				}
			}
			
			return $urls;
		}
		
		function level_parent($menu, $parent){
			$is_here= $this->is_here($menu);
			if($is_here && !$menu["children"]){
				return $parent;
			}
			elseif(!$is_here){
				return false;
			}
			elseif($menu["children"]){
				foreach($menu["children"] as $child){
					$partial_answer= $this->level_parent($child, $menu);
					if($partial_answer){
						return $partial_answer;
					}
				}		
			}
			else{
				return false;
			}
		}
		
		function format_hours_minutes($hours, $minutes)
		{
			  $hours+=(int)($minutes/60);
			  $minutes=$minutes%60;
			  if($minutes==0)$minutes="00";
			  if(strlen($minutes) == 1) $minutes = '0'.$minutes;
			  return $hours.":".$minutes;
        }
		
		/**
		 * Write Form Select (dropdown) input fields from array
		 * Takes an multi-dimensional array(option_value_opt => array(option_label => option_class)), Select name, (optional) Default selected option, and (optional) size
		 * If size is provided and greater than 1, the multiple parameter is added
		 * If use_array_key_opt is false (default), the the option value and label are both the value of the array [no the key, array(key => value)]
		 * css classes for the container, lable, and field divs can be set with the Setter Methods (same as input)
		 */
		/*function formSelect($option_array, $name, $selected_key_opt = NULL, $size_opt = NULL, $use_array_key_opt = false) {
			
			$selected = empty($_POST) ? $selected_key_opt : $_POST[$name];
			$options = '';
			foreach($option_array as $option_value => $second_array) {	
				foreach($second_array as $option_label => $option_class) {
					$option_key = $use_array_key_opt ? $option_value : $option_label;
					$sel = $option_key == $selected ? ' selected="selected"' : '';
					$options .= '<option value="'.$option_key.'" class="'.$option_class.'" '.$sel.'>'.$option_label.'</option>';
				}
			}
			
			$parameters = 'name="'.$name.'"';
			$parameters .= $size_opt > 1 ? ' multiple="multiple" size="'.$size_opt.'"' : '';
			
			$select = '<select '.$parameters.'>';
			$select .= $options;
			$select .= '</select>';
			return $select;
		}*/
		
		function formSelect($option_array, $name, $select_parameter_array, $selected_key_opt = NULL, $use_array_key_opt = false) {
			
			$options = '';
			foreach($option_array as $option_value => $second_array) {	
				foreach($second_array as $option_label => $option_class) {
					$option_key = $use_array_key_opt ? $option_value : $option_label;
					$sel = $option_key == $selected_key_opt ? ' selected="selected"' : '';
					$options .= '<option value="'.$option_key.'" class="'.$option_class.'" '.$sel.'>'.$option_label.'</option>';
				}
			}
			
			$parameters = 'name="'.$name.'"';
			foreach($select_parameter_array as $value) {
				$parameters .= ' '.$value;
			}
			
			$select = '<select '.$parameters.'>';
			$select .= $options;
			$select .= '</select>';
			return $select;
		}
    
    
    function seconds_to_string($sec)
    {
        // start with a blank string
        $hms = "";
		
		// for days
		$days = intval(intval($sec) / 86400);
		
		$hms .= ($days > 0) ? $days. "d - " : "";
        
        // do the hours first: there are 3600 seconds in an hour, so if we divide
        // the total number of seconds by 3600 and throw away the remainder, we're
        // left with the number of hours in those seconds
        $hours = intval(intval($sec / 3600) % 24);
        
        // add hours to $hms (with a leading 0 if asked for)
        $hms .= ($days == 0 && $hours == 0) ? "" : $hours. "h - ";
        
        // dividing the total seconds by 60 will give us the number of minutes
        // in total, but we're interested in *minutes past the hour* and to get
        // this, we have to divide by 60 again and then use the remainder
        $minutes = intval(($sec / 60) % 60); 
        
        // add minutes to $hms (with a leading 0 if needed) but only if minutes are not 0
        $hms .= ($days == 0 && $hours == 0 && $minutes == 0) ? "" : $minutes."m";
        
        // seconds past the minute are found by dividing the total number of seconds
        // by 60 and using the remainder
        //$seconds = intval($sec % 60); 
        
        // add seconds to $hms (with a leading 0 if needed)
        //$hms .= $seconds."s";
        
        // if the total time is 0, show so
		$hms = empty($hms) ? 0 : $hms;
		
		// done!
        return $hms;
    }

function getTitleByDateRange($from_t, $to_t)
{
	$return_text = "";
	$from = 0;
	$to = 0;
	if($from_t != '')
	{
		list($fm, $fd, $fy) = explode('-', $from_t);
		$from = mktime(0, 0, 0, $fm, $fd, $fy);
	}
	if($to_t != '')
	{
		list($tm, $td, $ty) = explode('-', $to_t);
		$to = mktime(0, 0, 0, $tm, $td, $ty);
	}
	
	if($from)
	{
		if($to)
		{
			$return_text = "from ".date('F d, Y', $from)." to ".date('F d, Y', $to);
		}
		else
		{
			$return_text = "since ".date('F d, Y', $from);
		}
	}
	else
	{
		if($to)
		{
			$return_text = "until ".date('F d, Y', $to);
		}
		else
		{
			$return_text = "for all dates";
		}
	}
	return $return_text;
}
    
}
?>