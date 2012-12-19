<?php
App::uses('AppController', 'Controller');
/**
 * Shortcuts Controller
 *
 * @property Shortcut $Shortcut
 */
class ShortcutsController extends AppController {
		
	function beforeFilter() 
	{
		parent::beforeFilter(); 
		
		$this->Auth->allowedActions= array("*");
		
		$model= "Shortcut";
		$controller= "Shortcuts";
		$item= __("Shortcut");
		
		$this->set(compact("model", "controller", "item"));
	}

	function my_shortcuts($ckeditor_name, $ckeditor_instance=false, $parent_div=false)
	{
		$model= "Shortcut";
		$controller= "Shortcuts";
		$item= __("Shortcut");
		
		$conditions= array();
		$conditions["ShortcutModule.module"]= $ckeditor_name;
		$conditions["ShortcutModule.user_id"]= $this->Auth->user("id");
		$modules= $this->$model->ShortcutModule->find("all", array("conditions"=>$conditions, 'order'=>array('ShortcutModule.position ASC')));
		$shortcuts= array();
		
		if($modules){
			foreach($modules as $module){
				$shortcuts[]["Shortcut"]= $module["Shortcut"];
			}
		}
		
		if (!empty($this->request->params['requested'])){
        	return $shortcuts;
        }
		$this->set(compact("shortcuts", "ckeditor_instance", "ckeditor_name", "parent_div"));
		$this->set("dont_perform_request", true);
	}
	
	function timestamp()
	{
		echo date("m-d-Y, g:i a").": ";
		exit;
	}
	
	function add($ckeditor_name, $parent_div, $ckeditor_instance){
		$model= "Shortcut";
		$controller= "Shortcuts";
		$item= __("Shortcut");
		
		if($this->request->is('post')){
			$this->request->data[$model]["user_id"]= $this->Auth->user("id");
			if($this->request->data["AuxElm"]["Modules"]){
				foreach($this->request->data["AuxElm"]["Modules"] as $i=>$module){
					$this->request->data["ShortcutModule"][$i]["module"]= $module;
					$this->request->data["ShortcutModule"][$i]["user_id"]= $this->Auth->user("id");
				}	
				
				$this->$model->create();
				if ($this->$model->saveAll($this->data)){
					$this->Utils->flash($item, "success_add");
					
					if($this->request->is('ajax')){
						$this->layout= "empty";
						$this->set("url_redirect", array("plugin"=>null, "controller"=>$controller, "action"=>"my_shortcuts", $ckeditor_name, $ckeditor_instance, $parent_div));
						$this->set("close", true);
						$this->set(compact("ckeditor_name", "parent_div"));
						$this->render("form");
						return;
					}
					else{
						$this->redirect(array("plugin"=>null, "controller"=>$controller, 'action' => 'index'));
					}
				} 
				else{
					$this->Utils->flash($item, "error_add");
				}
			}else{
				$this->Utils->flash_simple(__("You must select at least one editor."), "error");	
			}
		}
		
		$this->set(compact("ckeditor_name"));
		$this->set("edit", false);
		
		$this->render("form");
	}

	function edit($id, $ckeditor_name, $parent_div, $ckeditor_instance){
		$model= "Shortcut";
		$controller= "Shortcuts";
		$item= __("Shortcut");
     	
        $this->set("title_for_layout", __("Edit ".$item));   
		
		$this->$model->id = $id;
		if (!$this->$model->exists()){
			throw new NotFoundException(__('Invalid '.$item));
		}
		
		if($this->request->is('post') || $this->request->is('put')){
			if($this->request->data["AuxElm"]["Modules"]){
				$this->$model->ShortcutModule->deleteAll(array("ShortcutModule.shortcut_id"=>$this->data[$model]["id"], "ShortcutModule.user_id"=>$this->Auth->user("id")));
				foreach($this->request->data["AuxElm"]["Modules"] as $i=>$module){
					$this->request->data["ShortcutModule"][$i]["module"]= $module;
					$this->request->data["ShortcutModule"][$i]["user_id"]= $this->Auth->user("id");
				}	
				$this->$model->create();
				if ($this->$model->saveAll($this->request->data)){
					$this->Utils->flash($item, "success_add");
					if($this->request->is('ajax')){
						$this->layout= "empty";
						$this->set("url_redirect", array("plugin"=>null, "controller"=>$controller, "action"=>"my_shortcuts", $ckeditor_name, $ckeditor_instance, $parent_div));
						$this->set("close", true);
						$this->set(compact("ckeditor_name", "parent_div"));
						$this->render("form");
						return;
					}else{
						$this->redirect(array("plugin"=>null, "controller"=>$controller, 'action' => 'index'));	
					}
				} 
				else{
					$this->Utils->flash($item, "error_add");
				}
			}else{
				$this->Utils->flash_simple(__("You must select at least one editor."), "error");
			}
		}else{
			$this->request->data = $this->$model->read(null, $id);
			if($this->data["ShortcutModule"]){
				foreach($this->data["ShortcutModule"] as $sc_module){
					$this->request->data["AuxElm"]["Modules"][]= $sc_module["module"];
				}
			}
		}
		
		$this->set("edit", true);
		$this->set(compact("ckeditor_name"));
		$this->render("form");
	}

	function get_text($id){
		$model= "Shortcut";
		$controller= "Shortcuts";
		$item= __("Shortcut");
		
		$one= $this->$model->findByIdAndUserId($id, $this->Auth->user("id"));
		if($one){
			echo $one[$model]["message"];
		}
		else{
			echo "";
		}
		exit;
	}
	
	function delete($id, $ckeditor_name, $ckeditor_instance, $parent_div){
		$model= "Shortcut";
		$controller= "Shortcuts";
		$item= __("Shortcut");
		
		$this->$model->id = $id;
		if (!$this->$model->exists()){
			throw new NotFoundException(__('Invalid '.$item));
		}
		
		if ($this->$model->delete($id)){
			$this->Utils->flash($item, "success_delete");
		}
		else{
			$this->Utils->flash($item, "error_delete");
		}
		
		$conditions= array();
		$conditions["ShortcutModule.module"]= $ckeditor_name;
		$conditions["ShortcutModule.user_id"]= $this->Auth->user("id");
		$this->$model->ShortcutModule->contain($model);
		$modules= $this->$model->ShortcutModule->find("all", array("conditions"=>$conditions));
		
		$shortcuts= array();
		
		if($modules){
			foreach($modules as $module){
				$shortcuts[]["Shortcut"]= $module["Shortcut"];
			}
		}
		
		$this->set(compact("shortcuts", "ckeditor_instance", "ckeditor_name", "parent_div"));
		$this->set("dont_perform_request", true);
		$this->render("my_shortcuts");
	}
	
	function save_order($ckeditor_name){
		$model= "Shortcut";
		$controller= "Shortcuts";
		$item= __("Shortcuts");
		
		if($this->request->is('post')){
			if($this->data["Order"]){
				$ids= array_keys($this->data["Order"]);
				
				//We need to know that every single id belongs to the logged user.
				$save_data= array();
				$conditions= array();
				$conditions["ShortcutModule.user_id"]= $this->Auth->user("id");
				$conditions["ShortcutModule.module"]= $ckeditor_name; 
				foreach($ids as $position=>$id){
					$conditions["ShortcutModule.shortcut_id"]= $id;
					$this->$model->ShortcutModule->contain();
					$sm= $this->$model->ShortcutModule->find("first", array("conditions"=>$conditions));
					
					if($sm){
						$update= array();
						$update["ShortcutModule"]["id"]= $sm["ShortcutModule"]["id"];
						$update["ShortcutModule"]["position"]= $position;
						
						$save_data[]= $update;
					}
				}
				
				if($save_data){
					$this->$model->ShortcutModule->create();
					$this->$model->ShortcutModule->saveAll($save_data);
				}
			}
		}
		exit;
	}
}
