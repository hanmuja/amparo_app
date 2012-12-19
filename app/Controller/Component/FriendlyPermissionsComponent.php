<?php
    class FriendlyPermissionsComponent extends Component 
    {
    	public $components= array("Acl");
    	public $boxes_roles= array();
		
    	function startup(){
			////////////////////////////////////////////////////////////////
			$this->boxes_roles["administrative"]= array();
			$this->boxes_roles["administrative"]["label"]= __("Administrative Functions");
			$this->boxes_roles["administrative"]["boxes"]= array();
			
			//////////////
			$box= array();
			$box["label"]= __("Edit Role Permissions");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Roles/permissions";
			$this->boxes_roles["administrative"]["boxes"][]= $box;
			
			////////////////////////////////////////////////////////////////
			$this->boxes_roles["problems"]= array();
			$this->boxes_roles["problems"]["label"]= __("Trouble Tickets Administration");
			$this->boxes_roles["problems"]["boxes"]= array();
			//////////////
			$box= array();
			$box["label"]= __("View Trouble Tickets List");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Problems/index";
			$this->boxes_roles["problems"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Add new Trouble Tickets");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Problems/add";
			$this->boxes_roles["problems"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Edit existing Trouble Tickets");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Problems/edit";
			$this->boxes_roles["problems"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Delete Trouble Tickets | database");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Problems/delete";
			$this->boxes_roles["problems"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Close Trouble Tickets");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Problems/close";
			$this->boxes_roles["problems"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Open Trouble Tickets");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Problems/open";
			$this->boxes_roles["problems"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("View Trouble Ticket History");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Problems/problem_history";
			$box["aco_paths"][]= "Problems/sessions";
			$box["aco_paths"][]= "Problems/part_orders";
			$box["aco_paths"][]= "PartOrders/check_editable";
			$this->boxes_roles["problems"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Post Updates");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "ProblemSessions/add";
			$this->boxes_roles["problems"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Edit Updates");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "ProblemSessions/edit";
			$this->boxes_roles["problems"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Delete Updates | database");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "ProblemSessions/delete";
			$this->boxes_roles["problems"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Place Orders for Parts");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "PartOrders/add";
			$this->boxes_roles["problems"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Delete entire Parts Orders | database");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "PartOrders/delete";
			$this->boxes_roles["problems"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Add new Parts to existing Orders");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "PartOrderComponents/add";
			$this->boxes_roles["problems"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Remove included Parts from Orders | database");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "PartOrderComponents/delete";
			$this->boxes_roles["problems"]["boxes"][]= $box;
			
			////////////////////////////////////////////////////////////////
			$this->boxes_roles["orders"]= array();
			$this->boxes_roles["orders"]["label"]= __("Part Orders Processing");
			$this->boxes_roles["orders"]["boxes"]= array();
			//////////////
			$box= array();
			$box["label"]= __("View Part Orders List");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "PartOrders/index";
			$this->boxes_roles["orders"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Close Part Orders");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "PartOrders/close";
			$this->boxes_roles["orders"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Open Part Orders");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "PartOrders/open";
			$this->boxes_roles["orders"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Stop Changes to Part Orders");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "PartOrders/lock";
			$this->boxes_roles["orders"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Allow Changes to Part Orders");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "PartOrders/unlock";
			$this->boxes_roles["orders"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("View Part Order Details");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "PartOrders/order_history";
			$this->boxes_roles["orders"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Process Part Order");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "PartOrderComponents/process_edit";
			$this->boxes_roles["orders"]["boxes"][]= $box;
			/////////////
			$box= array();
			$box["label"]= __("Add new Order Statuses");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "PartOrderComponents/save_os";
			$this->boxes_roles["orders"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Edit existing Orden Statuses");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "PartOrderComponents/load_os";
			$box["aco_paths"][]= "PartOrderComponents/save_os_edition";
			$this->boxes_roles["orders"]["boxes"][]= $box;
			//////////////
			/*$box= array();
			$box["label"]= __("Delete Order Statuses | database");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "PartOrderComponents/delete_os";
			$this->boxes_roles["orders"]["boxes"][]= $box;*/
			//////////////
			$box= array();
			$box["label"]= __("Create new Parts and Accept them into an Order");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "PartOrders/acceptNewPart";
			$this->boxes_roles["orders"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Select existing Parts and Accept them into an Order");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "PartOrders/selectPart";
			$box["aco_paths"][]= "PartOrders/performSelection";
			$this->boxes_roles["orders"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Reject Suggestions to include Parts into an Order");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "PartOrders/rejectSuggestion";
			$this->boxes_roles["orders"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Close Parts included in Part Orders");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "PartOrderComponents/close";
			$this->boxes_roles["orders"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Open Parts included in Part Orders");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "PartOrderComponents/open";
			$this->boxes_roles["orders"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Edit Parts included in Part Orders");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "PartOrderComponents/process_edit";
			$this->boxes_roles["orders"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Export Multiple Part Orders to Excel");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "PartOrders/export_excel";
			$this->boxes_roles["orders"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Export Individual Part Orders to Excel");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "PartOrders/export_excel_one";
			$this->boxes_roles["orders"]["boxes"][]= $box;
			
			////////////////////////////////////////////////////////////////
			$this->boxes_roles["equipment"]= array();
			$this->boxes_roles["equipment"]["label"]= __("Equipment Administration");
			$this->boxes_roles["equipment"]["boxes"]= array();
			
			//////////////
			$box= array();
			$box["label"]= __("View Game List");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Equipment/index";
			$this->boxes_roles["equipment"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Add new Games");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Equipment/add";
			$this->boxes_roles["equipment"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Edit existing Games");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Equipment/edit";
			$this->boxes_roles["equipment"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Delete Games | database");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Equipment/delete";
			$this->boxes_roles["equipment"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Retire Games");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Equipment/retire";
			$this->boxes_roles["equipment"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Unretire Games");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Equipment/unretire";
			$this->boxes_roles["equipment"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("View Equipment Types List");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "EquipmentTypes/index";
			$this->boxes_roles["equipment"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Add new Equipment Types");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "EquipmentTypes/add";
			$this->boxes_roles["equipment"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Edit existing Equipment Types");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "EquipmentTypes/edit";
			$this->boxes_roles["equipment"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Delete Equipment Types | database");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "EquipmentTypes/delete";
			$this->boxes_roles["equipment"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Retire Equipment Types");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "EquipmentTypes/retire";
			$this->boxes_roles["equipment"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Unretire Equipment Types");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "EquipmentTypes/unretire";
			$this->boxes_roles["equipment"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("View Parts Related to an Equipment Type");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "EquipmentTypes/parts";
			$this->boxes_roles["equipment"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Relate New Parts to an Equipment Type");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "EquipmentTypes/addpart";
			$this->boxes_roles["equipment"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Remove Parts from an Equipment Type");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "EquipmentTypes/removepart";
			$this->boxes_roles["equipment"]["boxes"][]= $box;//////////////
			$box= array();
			$box["label"]= __("View Parts List");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Parts/index";
			$this->boxes_roles["equipment"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Add new Parts");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Parts/add";
			$this->boxes_roles["equipment"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Edit existing Parts");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Parts/edit";
			$this->boxes_roles["equipment"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Delete Parts | databse");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Parts/delete";
			$this->boxes_roles["equipment"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Retire Parts");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Parts/retire";
			$this->boxes_roles["equipment"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Unretire Parts");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Parts/unretire";
			$this->boxes_roles["equipment"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Add new Game Names");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Equipment/save_game";
			$this->boxes_roles["equipment"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Edit existing Game Names");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Equipment/load_game";
			$box["aco_paths"][]= "Equipment/save_game_edition";
			$this->boxes_roles["equipment"]["boxes"][]= $box;
			//////////////
			/*$box= array();
			$box["label"]= __("Delete Game Names | database");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Equipment/delete_game";
			$this->boxes_roles["equipment"]["boxes"][]= $box;*/
			//////////////
			$box= array();
			$box["label"]= __("View Reports by Equipment");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Equipment/report_by_equipment";
			$this->boxes_roles["equipment"]["boxes"][]= $box;
			
			////////////////////////////////////////////////////////////////
			$this->boxes_roles["location"]= array();
			$this->boxes_roles["location"]["label"]= __("Locations Administration");
			$this->boxes_roles["location"]["boxes"]= array();
			//////////////
			$box= array();
			$box["label"]= __("View Locations list");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Locations/index";
			$this->boxes_roles["location"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Add new Locations");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Locations/add";
			$this->boxes_roles["location"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Edit existing Locations");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Locations/edit";
			$this->boxes_roles["location"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Delete Locations | database");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Locations/delete";
			$this->boxes_roles["location"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Retire Locations");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Locations/retire";
			$this->boxes_roles["location"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Unretire Locations");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Locations/unretire";
			$this->boxes_roles["location"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("View Reports by Location");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Locations/report_by_location";
			$this->boxes_roles["location"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("View Routes List");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Routes/index";
			$this->boxes_roles["location"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Add new Routes");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Routes/add";
			$this->boxes_roles["location"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Edit existing Routes");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Routes/edit";
			$this->boxes_roles["location"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Delete Routes | database");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Routes/delete";
			$this->boxes_roles["location"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Retire Routes");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Routes/retire";
			$this->boxes_roles["location"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Unretire Routes");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Routes/unretire";
			$this->boxes_roles["location"]["boxes"][]= $box;
			
			////////////////////////////////////////////////////////////////
			$this->boxes_roles["timesheets"]= array();
			$this->boxes_roles["timesheets"]["label"]= __("Time Sheets Functions");
			$this->boxes_roles["timesheets"]["boxes"]= array();
			
			//////////////
			$box= array();
			$box["label"]= __("View Time Sheet");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Timesheets/index";
			$this->boxes_roles["timesheets"]["boxes"][]= $box;
			
			//////////////
			$box= array();
			$box["label"]= __("Punch In Daily");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Timesheets/process_day";
			$this->boxes_roles["timesheets"]["boxes"][]= $box;
			
			//////////////
			$box= array();
			$box["label"]= __("Finalize Weeks");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Timesheets/finalize_week";
			$this->boxes_roles["timesheets"]["boxes"][]= $box;
			
			//////////////
			$box= array();
			$box["label"]= __("View Day Datils");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Timesheets/show_day";
			$this->boxes_roles["timesheets"]["boxes"][]= $box;
			
			//////////////
			$box= array();
			$box["label"]= __("View Individual Reports");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Timesheets/individual_reports";
			$this->boxes_roles["timesheets"]["boxes"][]= $box;
			
			//////////////
			$box= array();
			$box["label"]= __("Un-Finalize Weeks");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Timesheets/unfinalize";
			$this->boxes_roles["timesheets"]["boxes"][]= $box;
			
			//////////////
			$box= array();
			$box["label"]= __("View Hours Per Location Reports");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Timesheets/hours_per_location";
			$this->boxes_roles["timesheets"]["boxes"][]= $box;
                        
                        ////////////////////////////////////////////////////////////////
                        $this->boxes_roles["events"]= array();
                        $this->boxes_roles["events"]["label"]= __("Events Functions");
                        $this->boxes_roles["Events"]["boxes"]= array();
                        
                        //////////////
                        $box= array();
                        $box["label"]= __("Add Event");
                        $box["aco_paths"]= array();
                        $box["aco_paths"][]= "Events/add";
                        $this->boxes_roles["events"]["boxes"][]= $box;
                        
                        //////////////
                        $box= array();
                        $box["label"]= __("View Events");
                        $box["aco_paths"]= array();
                        $box["aco_paths"][]= "Events/index";
                        $this->boxes_roles["events"]["boxes"][]= $box;
                        
                        //////////////
                        $box= array();
                        $box["label"]= __("Edit Event");
                        $box["aco_paths"]= array();
                        $box["aco_paths"][]= "Events/edit";
                        $this->boxes_roles["events"]["boxes"][]= $box;
                        
                        //////////////
                        $box= array();
                        $box["label"]= __("Delete Event");
                        $box["aco_paths"]= array();
                        $box["aco_paths"][]= "Events/delete";
                        $this->boxes_roles["events"]["boxes"][]= $box;
                        
                        //////////////
                        $box= array();
                        $box["label"]= __("See All Events");
                        $box["aco_paths"]= array();
                        $box["aco_paths"][]= "Events/can_view";
                        $this->boxes_roles["events"]["boxes"][]= $box;
                        
                        //////////////
                        $box= array();
                        $box["label"]= __("Edit All Events");
                        $box["aco_paths"]= array();
                        $box["aco_paths"][]= "Events/can_edit";
                        $this->boxes_roles["events"]["boxes"][]= $box;
                        
                        //////////////
                        $box= array();
                        $box["label"]= __("Delete All Events");
                        $box["aco_paths"]= array();
                        $box["aco_paths"][]= "Events/can_delete";
                        $this->boxes_roles["events"]["boxes"][]= $box;
			
			////////////////////////////////////////////////////////////////
			$this->boxes_roles["user"]= array();
			$this->boxes_roles["user"]["label"]= __("Users Administration");
			$this->boxes_roles["user"]["boxes"]= array();
			//////////////
			$box= array();
			$box["label"]= __("Update my Account");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Users/update_account";
			$this->boxes_roles["user"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Change my Password");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Users/change_password";
			$this->boxes_roles["user"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("View Users List");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Users/index";
			$this->boxes_roles["user"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Add new Users");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Users/add";
			$this->boxes_roles["user"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Edit existing Users");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Users/edit";
			$this->boxes_roles["user"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Delete Users | database");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Users/delete";
			$this->boxes_roles["user"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Retire Users");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Users/retire";
			$this->boxes_roles["user"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Unretire Users");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Users/unretire";
			$this->boxes_roles["user"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("View Roles List");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Roles/index";
			$this->boxes_roles["user"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Add new Roles");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Roles/add";
			$this->boxes_roles["user"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Edit existing Roles");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Roles/edit";
			$this->boxes_roles["user"]["boxes"][]= $box;
			//////////////
			$box= array();
			$box["label"]= __("Delete Roles | database");
			$box["aco_paths"]= array();
			$box["aco_paths"][]= "Roles/delete";
			$this->boxes_roles["user"]["boxes"][]= $box;
		}

		function load_permissions($permissions_array)
		{
			//These roles are the boxes roles. Not the roles in table roles.
			if($this->boxes_roles)
			{
				foreach($this->boxes_roles as $role_name=>$role)
				{
					if($role["boxes"])
					{
						foreach($role["boxes"] as $j=>$box)
						{
							$permission= false;
							if($box["aco_paths"])
							{
								$permission= true;
								foreach($box["aco_paths"] as $path)
								{
									if(!in_array($path, $permissions_array))
									{
										$permission= false;
										break;
									}
								}
							}
							
							$this->boxes_roles[$role_name]["boxes"][$j]["permission"]= $permission;
						}
					}
				}
			}
		}
		
		function get_boxes_roles()
		{
			return $this->boxes_roles;
		}
		
		function get_box($box_role_name, $box_id)
		{
			if(isset($this->boxes_roles[$box_role_name]["boxes"][$box_id]))
			{
				return $this->boxes_roles[$box_role_name]["boxes"][$box_id];	
			}
			else
			{
				throw new NotFoundException(__("The box doesn't exist"));
			}
		}
		
		function toggle_box_permission($model, $foreign_key, $box_role_name, $box_id){
			App::uses($model, 'Model');
			
			$box= $this->get_box($box_role_name, $box_id);
			
			if($box["permission"]){
				if($box["aco_paths"]){
					foreach($box["aco_paths"] as $aco_path){
						$aco_path= "controllers/".$aco_path;
						$this->Acl->deny(array('model' => $model, 'foreign_key' => $foreign_key), $aco_path);
					}
				}
			}
			else{
				if($box["aco_paths"]){
					foreach($box["aco_paths"] as $aco_path){
						$aco_path= "controllers/".$aco_path;
						$this->Acl->allow(array('model' => $model, 'foreign_key' => $foreign_key), $aco_path);
					}
				}
			}
		}
	}
?>