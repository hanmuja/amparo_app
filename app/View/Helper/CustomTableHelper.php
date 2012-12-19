<?php
	App::uses('AppHelper', 'View/Helper');

    class CustomTableHelper extends AppHelper{
		public $helpers= array("Html", "Form", "Js"=>array("Jquery"), "Paginator", "Session", "Utils", "Dialog", "Text");
		
		public $check_permissions= true;
		
		private function date_labels() {
			$date_labels= array();
			$date_labels["initial"] = __("Initial Date");
			$date_labels["final"] = __("Final Date");
			
			return $date_labels;	
		}
		//public $check_permissions= false;
		
		function defaults(){
			 $defaults= array();
			 $defaults["filter_submit"]= __("Filter");
			 $defaults["message_empty"]= __("No item found.");
			 $defaults["width"]= "99.9%";
			 $defaults["class_table"]= "tabla_paginadora";
			 $defaults["use_ajax"]= true;
			 $defaults["clear_filters"]= true;
			 $defaults["view_limits"]= array(5, 10, 20, 50, 100);
			 $defaults["include_paginator"]= true;
			 $defaults["filters_inside_th"]= true;
			 
			 return $defaults;
		}
		
		function header_defaults(){
			$defaults= array();
			$defaults["sortable"]= false;
			$defaults["filterable"]= false;
			$defaults["date_filter"]= false;
			$defaults["select_options"]= array();
			
			return $defaults;
		}
		
		function button_defaults(){
			$defaults= array();
			$defaults["html_options"]= array();
			$defaults["dialog_options"]= array();
			$defaults["class"]= false;
			$defaults["url"]= false;
			$defaults["inner_html"]= false;
			$defaults["allowed"]= false;
			
			return $defaults;
		}
		
		function get_table_header_params($ths, $controller, $table_options){
			//Get the configuration data
			extract($table_options);
				
			$thead= array();
            $filters= array();
            $show_filters= false;
            
			foreach($ths as $j=>$th){
				$th= array_merge($this->header_defaults(), $th);
				extract($th);
				
				if($sortable){
					$url_paginator_tmp= array();
					if(isset($this->Paginator->options["url"])){
						$url_paginator_tmp= $this->Paginator->options["url"];
						$url_aux= $url_paginator_tmp;
						$url_aux["page"]= 1;
						$this->Paginator->options(array("url"=>$url_aux));	
					}
					$sort= $this->Paginator->sort($field, $label, array("url"=>$url_base, "page"=>1));
					$thead[]= $sort;
					
					if(isset($this->Paginator->options["url"])){
						$this->Paginator->options(array("url"=>$url_paginator_tmp));	
					}
				}else{
					$thead[]= $label;
                }
				
                if($filterable){
                    $filter_options= array();
                    
					if($date_filter){
						$initial_id = 'DateFilter'.$controller.str_replace('.', '', $field)."CustomTableInitialDate";
						$final_id = 'DateFilter'.$controller.str_replace('.', '', $field)."CustomTableFinalDate";	
						
						$initial_default = false;
						if($this->Session->check('DateFilters.'.$controller.'.'.$field.'.custom_table_datefilter.initial.value')) {
							$initial_default = $this->Session->read('DateFilters.'.$controller.'.'.$field.'.custom_table_datefilter.initial.value');
							$this->Js->buffer('add_date_filtered_class_to_column("'.$controller.'", '.$j.')');
						}
						
						$final_default = false;
						if($this->Session->check('DateFilters.'.$controller.'.'.$field.'.custom_table_datefilter.final.value')) {
							$final_default = $this->Session->read('DateFilters.'.$controller.'.'.$field.'.custom_table_datefilter.final.value');
							$this->Js->buffer('add_date_filtered_class_to_column("'.$controller.'", '.$j.')');
						}
						$this->Js->buffer('highlight_date_filtered_column("'.$controller.'")');
						
						$initial_date = $this->Form->input('DateFilter.'.$controller.'.'.$field.'.CustomTableInitialDate', array('type'=>'hidden', 'class'=>'filter daterange initial', 'id'=>$initial_id, 'default'=>$initial_default));
						$final_date = $this->Form->input('DateFilter.'.$controller.'.'.$field.'.CustomTableFinalDate', array('type'=>'hidden', 'class'=>'filter daterange final', 'id'=>$final_id, 'default'=>$final_default));
						
						$new_filter= $initial_date.$final_date;
						$this->Js->buffer('initialize_date_filter("'.$initial_id.'", "'.$final_id.'", "initial", "'.$parent_div.'","'.$this->Html->url($url_base, true).'", "'.$this->Html->url('/', true).'", "'.$initial_default.'" , "'.$final_default.'", '.json_encode($this->date_labels()).')');
						$this->Js->buffer('initialize_date_filter("'.$initial_id.'", "'.$final_id.'", "final", "'.$parent_div.'", "'.$this->Html->url($url_base, true).'", "'.$this->Html->url('/', true).'", "'.$initial_default.'" , "'.$final_default.'", '.json_encode($this->date_labels()).')');
						$this->Js->buffer('$("#'.$initial_id.'").next().css("float", "left")');
						$this->Js->buffer('$("#'.$final_id.'").next().css("float", "right")');
						
						$initial_date_value = '';
						if($this->Session->check('DateFilters.'.$controller.'.'.$field.'.custom_table_datefilter.initial.value')) {
							$initial_date_value = $this->Session->read('DateFilters.'.$controller.'.'.$field.'.custom_table_datefilter.initial.value');
						}
						$final_date_value = '';
						if($this->Session->check('DateFilters.'.$controller.'.'.$field.'.custom_table_datefilter.final.value')) {
							$final_date_value = $this->Session->read('DateFilters.'.$controller.'.'.$field.'.custom_table_datefilter.final.value');
						}
						$qtip_options= array();
						$qtip_options['content']['title']= __('Initial Date');
						$qtip_options['content']['text']= $initial_date_value;
						$qtip_options['position']= array('my'=>'bottom center', 'at'=>'top center');
						$this->Js->buffer('$("#'.$parent_div.' #'.$initial_id.'").next().qtip('.json_encode($qtip_options).');');
						
						$qtip_options= array();
						$qtip_options['content']['title']= __('Final Date');
						$qtip_options['content']['text']= $final_date_value;
						$qtip_options['position']= array('my'=>'bottom center', 'at'=>'top center');
						$this->Js->buffer('$("#'.$parent_div.' #'.$final_id.'").next().qtip('.json_encode($qtip_options).');');
					}else{
						if($use_ajax){
	                        $filter_options["div"]= false;
	                        $filter_options["style"]= "padding: 0; margin: auto; width: 99%;";
	                        $filter_options["label"]= false;
							$filter_options["autocomplete"]= "off";
							
							if($select_options){
								$filter_options["onchange"]= "filtrar('".$parent_div."', '".$this->Html->url($url_base)."')";
							}else{
	                        	$filter_options["onkeyup"]= "filtrar('".$parent_div."', '".$this->Html->url($url_base)."')";
							}
	                    }else{
							$filter_options["label"]= $label;	
						}
	                    $filter_options["class"]= $input_filter_class;
	                    
	                    //Intento leer de la session un valor para este campo
	                    if($this->Session->check("Filters.".$controller.".".$field)){
	                    	$session_value= $this->Session->read("Filters.".$controller.".".$field);
							
							if(is_array($session_value)){
								$session_value_string="";
								foreach($session_value as $vs)
								$session_value_string.= $vs.VALUES_SEPARATOR;
								$session_value= substr($session_value_string, 0, -2);
							}
							
	                    	if($this->Session->check("Comparators.".$controller.".".$field)){
								$filter_options["default"]= $session_value.VALUE_COMPARATOR_SEPARATOR.$this->Session->read("Comparators.".$controller.".".$field);
							}else{
								$filter_options["default"]= $session_value;
							}
	                    }
						
						$filter_options["hl_index"]= $j;
	                    if($select_options){
	                    	$aux_select_options= array();  
							$aux_select_options[""]= EMPTY_OPTION;
	                    	foreach($select_options as $option){
								extract($option);
								if(!isset($comparator)){
									$comparator= "equal";
								}
								$option_value= $value.VALUE_COMPARATOR_SEPARATOR.$comparator;
								$aux_select_options[$option_value]= $display;
								
								unset($comparator);
								
							} 
	                        $filter_options["options"]= $aux_select_options;
	                    }else{
	                        $filter_options["type"]= "text";
	                    }
	                    $new_filter= $this->Form->input("Filters.".$controller.".".$field, $filter_options);
	                    
	                    if(isset($extra_fields) && is_array($extra_fields) && $extra_fields){
							foreach($extra_fields as $i=>$ef){
								$new_filter.= $this->Form->input("ExtraFilters.".$controller.".".$field.".ExtraFiltersValues.".$i, array("type"=>"hidden", "class"=>"filter extra", "default"=>$ef));
							}
						}
					}
					
					$filters[]= $new_filter;
                    
                    $show_filters= true;
                }else{
                    if($use_ajax)
                    $filters[]= "";
                }
				
				unset($sortable, $filterable, $field, $label, $select_options, $extra_fields);
			}
			return compact("thead", "filters", "show_filters");
		}
		
		private function resolve_options($options, $controller){
			$options= array_merge($this->defaults(), $options);
			        
			if(!isset($options["input_filter_class"])){
				$options["input_filter_class"]= "filter";
			}else{
				$options["input_filter_class"].= " filter";
			}
			
			//Define the default options
			if(!isset($options["parent_div"]) ){
				$options["parent_div"]= $controller;
			}
			
			if(!isset($options["id"])){
				$options["id"]="";
			}else{
				$options["id"]= "id='".$options["id"]."'";
			}
			
			if(!isset($options["url_base"])){
            	$options["url_base"]= array("plugin"=>null, "controller"=>$controller, "action"=>"index/");
			}
			
			return $options;
		}
		
		/**
		* @param string $controller The name of the controller we are working on.
		* @param array $table An array which represents the table information. It includes the next options:
		*	"ths": An array with the thead information. It has this format:
		*	"ths"=>array
		*	(
		*		0 => array
		*		(
		*			"label"=>__("First Name"), //The label that will appear in the th.
		*			"field"=>"Model.firstname", //The database field. It is mandatory if you will use sort or filter.
		*			"sortable"=>true,  //true to say if the field in this th will be used to sort. By default is false. 
		* 			"filterable"=>true,  //true to say if the field in this th will have a filter. By default is false.
		*		),
		*		1 => array
		*		(
		*			"label"=>__("Last Name"),
		*			"field"=> "Model.lastname", 
		*			"sortable"=>true,
		*			"filterable"=>true,
		*		),
		*		2 => array 
		*		(
		*			"label"=>"# Children" //In this case there is not sort nor filter.
		*		)
		*		,
		*		.
		*		.
		*	)
		*
		*	"trs": The array with the data to show.
		*	"trs"=> array
		*	(
		*		0 =>array( array(dato_0_1, array("class"=>"actions")), dato_0_2, dato_0_3, ..... , dato_0_n) //A row of data. Each cell could be a data or an array with the data in the first position, and an array of html options in the second position.
		*		1 =>array( dato_1_1, dato_1_2, dato_1_3, ..... , dato_1_n) //A row of information
		*		.
		*		.
		*		.
		*		m=>array( dato_m_1, dato_m_2, dato_m_3, ..... , dato_m_n) //A row of information
		*	)
		*
		* @param array	$options: Es un array con aspectos configurables de la tabla:
		*		-class: La clase de la tabla.
		*		-class_paginador: La clase de la tabla paginadora.
		*		-width: El ancho de la tabla.
		*		-parent_div: El id del div padre de esta tabla. OBLIGATORIO.
		*		-class_enlaces: Es la clase que tendran los enlaces de ordenamiento, teniendo en cuenta que estos no son enlaces tipicos.
		*		-prev_img: La ruta de la imagen a usar como prev relativa a la carpeta webroot/img/
		*		-next_img: La ruta de la imagen a usar como next relativa a la carpeta webroot/img/
		*		-contador: true para que aparezca el contador bajo la tabla.
		*		-class_contador: La clase del <p> que tendrá al contador.
		*		-texto_contador: El texto del contador, teniendo en cuenta los tags definidos por cake:
		*			-%page% La pagina actual
		*			-%pages% El numero de paginas
		*			-%current% La pagina actual
		*			-%count% El numero de registros en todal.
		*			-%start% El numero del registro que inicia la pagina actual.
		*			-%end% El numero del registro que termina la pagina actual.
		*		-url_base: The sort and filter url base. By default is the controller index.
		*/
        function table($controller, $table, $options){
        	$options= $this->resolve_options($options, $controller);
			        
			//Get the configuration data
			extract($options);
			
			$options_paginator= array();
			if($use_ajax){
				$options_paginator["update"]= "#".$parent_div;
				$options_paginator["before"]= "show_loading();";
				$options_paginator["complete"]= "hide_loading();";
			}	
			
            $this->Paginator->options($options_paginator);
			
			extract($this->get_table_header_params($table["ths"], $controller, $options));

            $t= "";
            if($show_filters && !$use_ajax){
				$params_paginator= $this->Paginator->params();
				
				$url_form= $this->url_form($url_base);
				
                $t.= "<div class='filtros'>";
                $t.= $this->Form->create(null, array("url"=>$url_form));
				$t.= $this->Utils->empty_div_row();
                foreach($filters as $filter)
                {	
                	$t.= $filter;
					$t.= $this->Utils->empty_div_row();
				}
                $t.= $this->Form->end($filter_submit);
                $t.= "</div>";    
            }
			
			if($clear_filters && $use_ajax && $show_filters && !$filters_inside_th){
				$clear_button= array();
				$clear_options= array();
				$clear_options["onclick"]= 'clear_filters("'.$parent_div.'", "'.$this->Html->url($url_base, true).'", '.json_encode($this->date_labels()).');';
				//$clear_button["permission_url"]= $url_base;
				$clear_button["label"]= __("Clear Filters");
				$clear_button["class"]= CRUD_THEME." link clear_filters crud_button sc_button_gray sc_crud_top";
				$clear_button["html_options"]= $clear_options;
				
				if(isset($table["buttons"])){
					$table["buttons"][]= array($clear_button);
				}else{
					$table["buttons"]= array();
					$table["buttons"][]= array($clear_button);
				}
			}
			
			//Aqui voy a colocar los botones
			if(isset($table["buttons"]) && $table["buttons"]){
				$buttons= $this->buttons($table["buttons"]);
				$t.= $buttons;
			}
			
			if($table["trs"] || $use_ajax){
				if(!$table['trs']){
					$table["trs"][]= array(array($this->Utils->infobox($message_empty), array("class"=>"no_item_td", "colspan"=>"100%")));
				}else{
					if($this->Session->check("CustomTableHighlights.".$controller)){
						$highlights= $this->Session->read("CustomTableHighlights.".$controller);
						$table["trs"]= $this->highlights_trs($table["trs"], $highlights);
					}
				}
				
				if($include_paginator){
					$tr_info= $this->paginator_body($controller, $options);
					$table["trs"][]= $tr_info;	
				}
				
				if(isset($table["table_actions"])){
					$table_actions= $table["table_actions"];
				}
				else{
					$table_actions= array();
				}
				
				if($clear_filters && $use_ajax && $show_filters && $filters_inside_th){
					$clear_button= array();
					$clear_options= array();
					$clear_options["onclick"]= 'clear_filters("'.$parent_div.'", "'.$this->Html->url($url_base, true).'", '.json_encode($this->date_labels()).');';
					//$clear_button["permission_url"]= $url_base;
					$clear_button["label"]= $this->Html->image('crud/small/clear.png', array('align'=>'absmiddle'));
					$clear_button["class"]= "clear_filters link crud_button ".CRUD_THEME." sc_button_gray sc_button_image_16";
					$clear_button["html_options"]= $clear_options;
					$table_actions[]= $clear_button;
				}

				if($table_actions && $filters_inside_th){
					$filters[0]= $this->button_group($table_actions);
					$qtip_options= array();
					$qtip_options['content']= __('Clear Filters');
					if(isset($qtip_options["style"])){
						unset($qtip_options["style"]);
					}
					$qtip_options['position']= array('my'=>'bottom left', 'at'=>'top center');
					$this->Js->buffer('$(".crud_button.clear_filters").qtip('.json_encode($qtip_options).');');
				}
				
				
				$t.= "<table $id class='$class_table pagination_row' width='$width'>";
				$t.="	<thead>";
				$t.= $this->Html->tableHeaders($thead);
	            if($show_filters && $use_ajax){
	            	$t.= $this->Html->tableHeaders($filters);	
	            }
				$t.="	</thead>";
				$t.="	<tbody>";
				$t.= $this->Html->tableCells($table["trs"], array("class"=>"odd"));
				$t.="	</tbody>";
				$t.="</table>";
			}
			else{
				$t.= $this->Utils->infobox($message_empty);
			}
			
            //if($ver_filtros && $use_ajax)
            $t.= $this->Html->script('tabla');
            
			return $t;
		}

		function highlights_trs($trs, $highlights){
			foreach($trs as $r=>$row)
			{
				foreach($row as $i=>$cell)
				{
					if(is_array($cell))
					{
						if(isset($highlights[$i]))
						{
							$trs[$r][$i][0]= $this->Text->highlight($trs[$r][$i][0], $highlights[$i],array("html"=>true, 'format' => '<span class="custom_table_highlight">\1</span>'));
						}
					}
					else
					{
						if(isset($highlights[$i]))
						{
							$trs[$r][$i]= $this->Text->highlight($trs[$r][$i], $highlights[$i],array("html"=>true, 'format' => '<span class="custom_table_highlight">\1</span>'));
						}
					}
				}
			}
			
			return $trs;
		}
        
		function button_group($btn_group, $group_html_options= array()){
			$group_string="";
			foreach($btn_group as $button){
				$button= array_merge($this->button_defaults(), $button);
				extract($button);
				
				if(!$inner_html)
				{
					if(isset($html_options["class"]))
					$html_options["class"].=" crud_button_inner ".BUTTONS_CLASS;
					else
					$html_options["class"]="crud_button_inner";
					
					//Primero miro si es un dialogo.
					if($dialog_options)
					{
						$dialog_id= $this->Dialog->id;
						if(isset($dialog_options["dialog_id"]))
						{
							$dialog_id= $dialog_options["dialog_id"];
							unset($dialog_options["dialog_id"]);
						}
						
						$dialog_launch= $this->Dialog->create($dialog_options, $dialog_id);
						//The url is extracted from button
						$dialog_load= $this->Dialog->load($url, $dialog_id);
						if(isset($html_options["onclick"]))
						$html_options["onclick"].= $dialog_launch.$dialog_load;
						else
						$html_options["onclick"]= $dialog_launch.$dialog_load;
						
						$inner_html= $this->Html->tag("div", $label, $html_options);
					}
					else 
					{
						if($url)
						$inner_html= $this->Html->link($label, $url, $html_options);
						else 
						$inner_html= $this->Html->tag("div", $label, $html_options);
					}
				}
				
				if($allowed)
				{
					$check_permissions_tmp= $this->check_permissions;
					$this->check_permissions= false;
				}
				
				if($this->check_permissions && false)
				{
					if(!isset($permission_url))
					{
						$permission_url= $url;
					}
					if($permission_url && $this->Utils->has_permission($permission_url))
					{
						$group_string.= $this->Html->tag("div", $inner_html, array("class"=>$class));						
					}
					
				}
				else 
				{
					$group_string.= $this->Html->tag("div", $inner_html, array("class"=>$class));	
				}
				
				if($allowed)
				{
					$this->check_permissions= $check_permissions_tmp;
				}
				unset($url, $permission_url, $class, $allowed);
			}
			
			if(isset($group_html_options["class"]))
			$group_html_options["class"].= " crud_button_group ".BUTTONS_CLASS;
			else
			$group_html_options["class"]= "crud_button_group ".BUTTONS_CLASS;
			
			
			if($group_string)
			return $this->Html->tag("div", $group_string, $group_html_options);
		}
		
		function buttons($buttons, $div_options=array())
		{
			$button_groups= "";
			foreach ($buttons as $btn_group) 
			{
                          $html_options = array();
                          if(isset($btn_group['html_options']))
                          {
                            $html_options = $btn_group['html_options'];
                            unset($btn_group['html_options']);
                          }
				$button_groups.= $this->button_group($btn_group, $html_options);
			}
			
			if(isset($div_options["class"]))
			    $div_options["class"].= " crud_buttons ".BUTTONS_CLASS;
			else
			    $div_options["class"]= " crud_buttons ".BUTTONS_CLASS;
			
			return $this->Html->tag("div", $button_groups, $div_options);
		}
		
		function url_form($url_base)
		{
			$params_paginator= $this->Paginator->params();
				
			$url_base["page"]= $params_paginator["page"];
			$url_base["limit"]= $params_paginator["limit"];
			if($params_paginator["order"])
			{
				$url_base["sort"]= key($params_paginator["order"]);
				$url_base["direction"]= $this->Paginator->sortDir();
			}
			
			return $url_base;
		} 
		
        function paginator_body($controller, $options)
        {
        	$options= array_merge($this->defaults(), $options);
			
            extract($options);
			
			//Necesito saber si se enviaron imagenes para las 4 opciones (prev, next, first, last)
			//si no se envió para alguna entonces trabajaré textos
            if(isset($images_paginator)){
				extract($images_paginator);
				
				$first= $this->Html->image($first_img, array("align"=>"absmiddle"));
				$prev= $this->Html->image($prev_img, array("align"=>"absmiddle"));
				$next= $this->Html->image($next_img, array("align"=>"absmiddle"));
				$last= $this->Html->image($last_img, array("align"=>"absmiddle"));
				
				$escape= false;
			} else {
				$prev= __("<");
				$next= __(">");
				$first= __("|<");
				$last= __(">|");
				
				$escape= true;
			}
			
			if(!isset($url_base))
            $url_base= array("plugin"=>null, "controller"=>$controller, "action"=>"index/");
			
            $results_number= $this->Paginator->counter(array("format" => __("%count%")));
			$start= $this->Paginator->counter(array("format" => __("%start%")));
			$end= $this->Paginator->counter(array("format" => __("%end%")));
			
			/*****************Form para cambiar el limit de la tabla***************************/
			$params_paginator= $this->Paginator->params();
			
			/*$form_options= array();
			$form_options["url"]= $this->Paginator->url($url_base);
			$form_options["class"]= "tabla_limit_form";
			
			if($use_ajax)
			$form_options["onsubmit"]= "change_limit('".$parent_div."', '".$this->Html->url($url_base)."'); return false;";
			else
			{	
				$form_options["url"]= $this->url_form($url_base);
				$form_options["onsubmit"]= "submit_limit_form(this)";
			}
				
			$limit_form= $this->Form->create(null, $form_options);
			$limit_form.= $this->Html->tag("span", __("View"), array("style"=>"float:left"));
			
			$limit_options= array();
			$limit_options["label"]= false;
			$limit_options["div"]= false;
			$limit_options["default"]= $params_paginator["limit"];
			$limit_options["class"]= "input_limit";
			$limit_options["style"]= "width: 30px; text-align: center; margin-right: 3px;";
            $limits= $this->Form->input("Tabla.limit", $limit_options);
			$limit_form.= $limits;
			$limit_form.= $this->Form->end(array("label"=>__("Go"), "div"=>false, "class"=>CRUD_THEME." sc_button_gray"));
			*/
			/*****************FIN de Form para cambiar el limit de la tabla***************************/
            
            $view_separator= $this->Html->tag("div", "|", array("class"=>"view_separator"));
            
            $td= "";
            
			$td.= "<span class='numero_resultados'>".$start."-".$end."</span> of <span class='numero_resultados'>".$results_number."</span>";
			$td.= $view_separator;
			
            $btn_first= ($this->Paginator->first($first))?$this->Paginator->first($first, array("tag"=>"div", "url"=>$url_base, "escape"=>$escape, "class"=>CRUD_THEME." sc_button_gray sc_pag_button link")):$this->Html->tag("div", $first, array("class"=>CRUD_THEME." link sc_button_gray sc_pag_button disabled"));
			$btn_prev= $this->Paginator->prev($prev, array("tag"=>"div", "url"=>$url_base, "escape"=>$escape, "class"=>"sc_button sc_button_gray sc_pag_button"), null, array("tag"=>"div", 'class' => CRUD_THEME.' link sc_button_gray sc_pag_button disabled', "escape"=>$escape));
			$btn_next= $this->Paginator->next($next, array("tag"=>"div", "url"=>$url_base, "escape"=>$escape, "class"=>"sc_button sc_button_gray sc_pag_button"), null, array("tag"=>"div", 'class' => CRUD_THEME.' link sc_button_gray sc_pag_button disabled', "escape"=>$escape));
			$btn_last= ($this->Paginator->last($last))?$this->Paginator->last($last, array("tag"=>"div", "url"=>$url_base, "escape"=>$escape, "class"=>CRUD_THEME." sc_button_gray sc_pag_button link")):$this->Html->tag("div", $last, array("class"=>CRUD_THEME." sc_button_gray sc_pag_button disabled link"));
			
			$td.= $this->Html->tag("div", $btn_first.$btn_prev.$btn_next.$btn_last, array("class"=>BUTTONS_CLASS." crud_button_group"));
			$td.= $view_separator;
			$td.= $this->Paginator->numbers(array("separator"=>"&nbsp&nbsp&nbsp", "tag"=>"div", "url"=>$url_base, "class"=>"link clasic_link crud_button"));
			
			$view= __("View").": ";
			foreach ($view_limits as $vl) 
			{
				if($vl<=100)
				{
					if($vl==$params_paginator["limit"])
					$view.=$this->Html->tag("div", $vl, array("class"=>"crud_button current_limit"))." ";
					else
					$view.=$this->Html->tag("div", $vl, array("class"=>"link clasic_link crud_button", "onclick"=>"change_limit_link('".$parent_div."', '".$this->Html->url($url_base)."', $vl)"))." ";
				}
			}
			
			$td.= $this->Html->tag("div", $view, array("class"=>"pag_view"));
			
            //$td.= $this->Html->tag("div", $limit_form, array("style"=>"float: right"));
			
            $tr_info= array();
            $tr_info[]= array($td, array("class"=>"fila_paginador", "colspan"=>"100%"));
			
            return $tr_info;
        }
        
        function table_filter($controller, $trs, $options) {
        	if($this->Session->check("CustomTableHighlights.".$controller)){
				$highlights= $this->Session->read("CustomTableHighlights.".$controller);
				$trs= $this->highlights_trs($trs, $highlights);
			}
					
        	$options= array_merge($this->defaults(), $options);
        	
            extract($options);
            
            $this->Paginator->options(array(
                'update' => '#'.$parent_div,
                'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
                'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false))
            ));
            
			$options["use_ajax"]= true;
			
			if(!$trs)
			$trs[]= array(array($this->Utils->infobox($message_empty), array("colspan"=>"100%")));
			
            $tr_info= $this->paginator_body($controller, $options);
			$trs[]= $tr_info;
            
			$this->Js->buffer('highlight_date_filtered_column("'.$controller.'")');
			
            return $this->Html->tableCells($trs, array("class"=>"odd"));
        }
    }
?>
