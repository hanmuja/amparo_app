<?php
	App::uses('AppHelper', 'View/Helper');
	
	/**
	* Helper for jquery ui dialog.
	*/
	class DialogHelper extends AppHelper 
	{
		public $helpers = array("Html", 'Js'=>array("Jquery"), 'Form');
		
		public $options = array();
		
		//Este id deberia ser único en todo momento en el html.
		public $id= "my_dialog";
		
		private $values= array();
		
		
		public function __construct(View $View, $settings = array()) 
		{
			parent::__construct($View, $settings);
			$this->options["disabled"]=1;
			$this->options["autoOpen"]=1;
			$this->options["buttons"]=1;
			$this->options["closeOnEscape"]=1;
			$this->options["closeText"]=1;
			$this->options["dialogClass"]=1;
			$this->options["draggable"]=1;
			$this->options["height"]=1;
			$this->options["hide"]=1;
			$this->options["maxHeight"]=1;
			$this->options["maxWidth"]=1;
			$this->options["minHeight"]=1;
			$this->options["minWidth"]=1;
			$this->options["modal"]=1;
			$this->options["position"]=1;
			$this->options["resizable"]=1;
			$this->options["show"]=1;
			$this->options["stack"]=1;
			$this->options["title"]=1;
			$this->options["width"]=1;
			$this->options["zIndex"]=1;
			
			$this->values["modal"]= "false";
			$this->values["position"]= "['center', 10]";
		}
		
		function headers()
		{
			$h= $this->Html->script('ui/jquery.ui.resizable');
			$h.= $this->Html->script('ui/jquery.ui.draggable');
			$h.= $this->Html->script('ui/jquery.ui.position');
			$h.= $this->Html->script('ui/jquery.ui.dialog');
			
			return $h;
		}
		
		function open($dialog_id=false)
		{
			if(!$dialog_id)
			{
				$dialog_id= $this->id;
			}
			
			$element= "$(\"#".$dialog_id."\")";
			
			return $element.".dialog(\"open\");";
		}
		
		function set_content($content, $dialog_id=false)
		{
			if(!$dialog_id)
			{
				$dialog_id= $this->id;
			}
			
			$element= "$(\"#".$dialog_id."\")";
			
			return $element.".html($value);";
		}
		
		function set_option($option, $value, $dialog_id=false){
			if(!$this->is_option($option))
			return "";
			
			$this->_set_option($option, $value);
			
			if(!$dialog_id)
			{
				$dialog_id= $this->id;
			}
			
			$element= "$(\"#".$dialog_id."\")";
			
			return $element.".dialog(\"option\", \"$option\", $value);";
		}
		
		function _set_option($option, $value)
		{
			$this->values[$option]= $value;
		}
		
		function is_option($option)
		{
			if(empty($option))
			return false;
			
			$option= str_replace("'", "", $option);
			$option= str_replace("\"", "", $option);
			
			if(isset($this->options[$option]))
			return true;
			else
			return false;
		}
		
		function reset($dialog_id=false)
		{
			if(!$dialog_id)
			{
				$dialog_id= $this->id;
			}
			
			$element= "$(\"#".$dialog_id."\")";
			$r= $element.".html(\"\");";
			$r.= $element.".dialog(\"option\", \"title\", \"\");";
			return $r;
		}
		
		function create($options=array(), $dialog_id=false)
		{
			$create= "";
			
			if(!$dialog_id)
			{
				$dialog_id= $this->id;
			}
			
			$element= "$(\"#".$dialog_id."\")";
			$create.= $element.".parent().detach();";
			
			$body= "$(\"body\")";
			$create.= $body.".prepend(\"<div id='".$dialog_id."'></div>\");";
			
			//Some cleaning
			$options["close"]= "function(event, ui){\$(\".token-input-dropdown\").detach();}";
			
			$options= $this->string_options($options);
			
			$create.= $element.".dialog(".$options.");";
			//$create.= $element.".parent().css(\"top\", \"-\"+(".$element.".parent().outerHeight(true)+20)+\"px\");";
			
			return $create;
		}
		
		function destroy($detach=true, $dialog_id=false)
		{
			if(!$dialog_id)
			{
				$dialog_id= $this->id;
			}
			
			$r="";
			$element= "$(\"#".$dialog_id."\")";
			
			//$r.= $element.".parent().animate({top:-1*(".$element.".parent().outerHeight(true)+20)},{easing:\"easeInCirc\"});";
			$r.= $element.".dialog(\"destroy\");";
			if($detach)
			$r.= $element.".detach();";
			
			return $r;
		}
		
		function string_options($options)
		{
			if(!$options)
			return "";
			
			foreach($options as $option=>$value)
			{
				if($this->is_option($option))
				{
					$this->_set_option($option, $value);
				}
			}
			
			$r='{';
			
			foreach($this->values as $option=>$value)
			$r.= $option.": ".$value.","; 
			
			$r= substr($r, 0, -1);
			
			$r.="}";
			
			return $r;
		}
		
		function load($url, $dialog_id=false, $send_closest_form=false)
		{
			if(!$dialog_id){
				$dialog_id= $this->id;
			}
			
			$element= "$(\"#".$dialog_id."\")";
			
			$ajax_options= array
			(
				"cache"=>false,
				"update"=>"#".$dialog_id, 
				"error"=>"handle_error(errorThrown)",
				"success"=>"hide_loading();"//.$element.".parent().animate({top:20},{easing:\"easeOutCirc\"});"
			);
			if($send_closest_form)
			{
				$ajax_options["data"]= $element.".closestForm().serialize()";	
			}

			$request= "show_loading();";
			$request.= $this->Js->request
			(
				$url, $ajax_options
			);
			
			return $request;
		}
		
		
	}