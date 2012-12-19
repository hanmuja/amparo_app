<?php
    class CustomTableComponent extends Component {
        public $components= array('Session', 'Utils');
		private $paginated= true;
		private $conditions= array();
		private $use_saved_params_actions= array("delete", "retire", "unretire");
		
		public $controller_object;
		
		function startup($controller_object) {
			$this->controller_object= $controller_object;
			$controller= $controller_object->name;
			
			if($controller_object->request->is('ajax')){
				//debug($controller_object->data);
			}
			//We'll save the limit, sort and page per controller and if the request is ajax it will use them
			$pagination_params= array();
			if($controller_object->params["named"]){
				if(isset($controller_object->params["named"]["sort"])){
					$pagination_params["sort"]= $controller_object->params["named"]["sort"];
				}
				if(isset($controller_object->params["named"]["limit"])){
					$pagination_params["limit"]= $controller_object->params["named"]["limit"];
				}
				if(isset($controller_object->params["named"]["page"])){
					$pagination_params["page"]= $controller_object->params["named"]["page"];
				}
			}
			
			/**
			 * If no pagination params were sent and the request is ajax, I will check in session if there are pagination
			 * params for the current controller.
			 */
			$current_action= $controller_object->params["action"];
			$referer= Router::parse($controller_object->referer(null, true));
			$referer_action= $referer["action"];
			
			$use_pagination_params= $this->Session->check("CustomTable.UsePaginationParams.".$controller.".".$referer_action);
			if(!$pagination_params && ($controller_object->request->is("ajax") || $use_pagination_params)){
				if($this->Session->check("CustomTable.PaginationParams.".$controller.".".$current_action)){
					$session_pagination_params= $this->Session->read("CustomTable.PaginationParams.".$controller.".".$current_action);
					$current_named_params= $controller_object->request->params["named"];
					$controller_object->request->params["named"]= array_merge($current_named_params, $session_pagination_params);
				}
			}
			
			/**
			 * If some pagination param was sent, we will write it in session.
			 */
			if($pagination_params){
				$this->Session->write("CustomTable.PaginationParams.".$controller.".".$current_action, $pagination_params);
			}
			
			if(in_array($current_action, $this->use_saved_params_actions)){
				$this->Session->write("CustomTable.UsePaginationParams.".$controller.".".$referer_action, "1");
			}else{
				$this->Session->delete("CustomTable.UsePaginationParams.".$controller.".".$referer_action);
			}
			
			
			$this->paginated= true;
			if(isset($controller_object->data["CustomTableHighlights"][$controller])){
				$this->Session->delete("CustomTableHighlightsTmp.".$controller);
				$this->Session->write("CustomTableHighlightsTmp.".$controller, $controller_object->data["CustomTableHighlights"][$controller]);
			}
			
			if(isset($controller_object->data["Filters"][$controller])){
				$filters= $controller_object->data["Filters"][$controller];
				$this->resolve_filters($filters, $controller);
				$this->paginated= false;
			}
			
			if(isset($controller_object->data["ExtraFilters"][$controller])){
				$extra_filters= $controller_object->data["ExtraFilters"][$controller];
				$this->Session->write("ExtraFilters.".$controller, $extra_filters);
			}
			
			if(isset($controller_object->data["DateFilter"][$controller])){
				$filters = $controller_object->data['DateFilter'][$controller];
				$this->resolve_date_filters($filters, $controller);
			}
			
			$this->Session->delete("CustomTableHighlightsTmp.".$controller);
			
			$this->conditions= array();
		}

		function resolve_date_filters($filters, $controller, $current_path=false) {
			if(is_array($filters) && isset($filters["CustomTableInitialDate"])) {
				$date_filters_values = array();
				if($filters["CustomTableInitialDate"]) {
					$initial_value = $filters["CustomTableInitialDate"].VALUE_COMPARATOR_SEPARATOR.">equal";
					$initial_value = $this->extract_comparator($initial_value);
					
					$date_filters_values['custom_table_datefilter']['initial'] = $initial_value;
				}
				if(isset($filters["CustomTableFinalDate"]) && $filters["CustomTableFinalDate"]) {
					$final_value = $filters["CustomTableFinalDate"].VALUE_COMPARATOR_SEPARATOR."<equal";
					$final_value = $this->extract_comparator($final_value);
					
					$date_filters_values['custom_table_datefilter']['final'] = $final_value;
				}
				
				if($date_filters_values) {
					$this->Session->write("DateFilters.".$controller.".".$current_path, $date_filters_values);
				} else {
					$this->Session->delete("DateFilters.".$controller.".".$current_path);
				}
				
			} elseif(is_array($filters)) {
				foreach($filters as $add_to_path => $new_filters) {
					$new_path= ($current_path)?$current_path.".".$add_to_path:$add_to_path;
					$this->resolve_date_filters($new_filters, $controller, $new_path);
				}
			} 
		}
		
		function resolve_filters($filters, $controller, $current_path=false){
			if(is_array($filters)) {
				foreach($filters as $add_to_path => $new_filters) {
					$new_path= ($current_path)?$current_path.".".$add_to_path:$add_to_path;
					$this->resolve_filters($new_filters, $controller, $new_path);
				}
			} else {
				$value= $this->extract_comparator($filters);
				
				//Check if the value contains the comparator 
				if(is_array($value)){
					extract($value);
					
					if(isset($comparator))
					$this->Session->write("Comparators.".$controller.".".$current_path, $comparator);
					
				} else {
					if($this->Session->check("CustomTableHighlightsTmp.".$controller.".".$current_path)) {
						$hl_index= $this->Session->read("CustomTableHighlightsTmp.".$controller.".".$current_path);
						$this->Session->write("CustomTableHighlights.".$controller.".".$hl_index, $value);	
					}
				}
				$this->Session->write("Filters.".$controller.".".$current_path, $value);
			}
		}
		
		//It receives the controller object, and the controller name
		function custom_startup($controller_object, $controller)
		{
			$this->paginated= true;
			if(isset($controller_object->data["Filters"][$controller]))
			{
				$filters= $controller_object->data["Filters"][$controller];
				$this->resolve_filters($filters, $controller);
				$this->paginated= false;
			}
			if(isset($controller_object->data["ExtraFilters"][$controller]))
			{
				$extra_filters= $controller_object->data["ExtraFilters"][$controller];
				$this->Session->write("ExtraFilters.".$controller, $extra_filters);
			}
		}
		
		function extract_comparator($value)
		{
			$information= explode(VALUE_COMPARATOR_SEPARATOR, $value); 
			if(count($information)==2)
			{
				list($value_string, $comparator)= $information; 
				
				$values= explode(VALUES_SEPARATOR, $value_string); 
				if(count($values)>1)
				$value= $values;
				else
				$value= $value_string;
				
				$return= array();
				$return["value"]= $value;
				$return["comparator"]= $comparator;
				return 	$return;
			}
			else 
			{
				return $value;
			}
			
		}
		
		function isPaginated()
		{
			return $this->paginated;
		}
		
		function get_filters_conditions($filters, $controller, $current_path=false){
			if(is_array($filters)){
				foreach($filters as $add_to_path => $new_filters){
					$new_path= ($current_path)?$current_path.".".$add_to_path:$add_to_path;
					$this->get_filters_conditions($new_filters, $controller, $new_path);
				}
			} else {
				$value= $filters;
				
				if($this->Session->check("Comparators.".$controller.".".$current_path)){
					$comparator= $this->Session->read("Comparators.".$controller.".".$current_path);
				} else{
					$comparator= "LIKE";
				}
				if($value || $value=="0"){
					if($comparator=="LIKE") {
						$value= (($comparator=="LIKE")?"%":"").$value.(($comparator=="LIKE")?"%":"");
					}
					$comparator= $this->comparator($comparator);
					
					if($this->Session->check("ExtraFilters.".$controller.".".$current_path.".ExtraFiltersValues")) {
						$or= array();
						$or[$current_path." ".$comparator]= $value;
						
						$extras= $this->Session->read("ExtraFilters.".$controller.".".$current_path.".ExtraFiltersValues");
						if($extras) {
							foreach($extras as $extra){
								//$extra= str_replace(EXTRA_FIELDS_SEPARATOR, ".", $extra);
								$or[$extra." ".$comparator]= $value;
							}
						}
						
						$this->conditions["and"][]["or"]= $or;
					}
					else 
					{
						$this->conditions["and"][$current_path." ".$comparator]= $value;	
					}
				}
			}
		}

		function get_date_filters_conditions($filters, $controller, $current_path=false) {
			if(is_array($filters) && isset($filters["custom_table_datefilter"])) {
				foreach($filters["custom_table_datefilter"] as $params) {
					$comparator= $this->comparator($params["comparator"]);
					$value = $this->Utils->get_fecha_int($params["value"], 2, 0, 1);
					//To include the whole day, we must add 86399 seconds
					if($comparator == '<=') {
						$this->conditions["and"][][$current_path." ".$comparator]= $value+86399;
					} else {
						$this->conditions["and"][][$current_path." ".$comparator]= $value;
					}
				}
			} elseif(is_array($filters)){
				foreach($filters as $add_to_path => $new_filters){
					$new_path= ($current_path)?$current_path.".".$add_to_path:$add_to_path;
					$this->get_date_filters_conditions($new_filters, $controller, $new_path);
				}
			} 
		}
		
		function get_conditions($controller) {			
			$this->conditions= array();
			if($this->Session->check("Filters.".$controller)) {
				$filters= $this->Session->read("Filters.".$controller);
				//In this function we calculate the conditions
				$this->get_filters_conditions($filters, $controller);
			}
			
			if($this->Session->check('DateFilters.'.$controller)) {
				$filters = $this->Session->read('DateFilters.'.$controller);
				$this->get_date_filters_conditions($filters, $controller);
			}
			//debug($this->conditions);
			return $this->conditions;
		}
		
		function comparator($comparator)
		{
			$translate= array();
			$translate["equal"]= "=";
			$translate[">equal"]= ">=";
			$translate["<equal"]= "<=";
			$translate["between"]= "BETWEEN ? AND ?";
			
			if(isset($translate[$comparator]))
			return $translate[$comparator];
			else
			return $comparator;
		}
	}