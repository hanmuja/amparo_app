<?php
App::uses('AppController', 'Controller');
/**
 * Acos Controller
 *
 * @property Aco $Aco
 */
class AcosController extends AppController 
{
	public $components= array("AclExtras");
	
	function beforeFilter() {
		parent::beforeFilter(); 
		
		/**
		 * Add this to every single controller, so in the view we always know which is the current controller, model, and item name.
		 * For example, in the index, the delete, edit and add links go to the current controller, so we can copy+paste the most of the views.
		 */
		$controller= "Acos";
		$model= "Aco";
		$item= __("Aco");
		
		$this->set(compact("model", "controller", "item"));
	}
	
	function build_acos($run= false)
	{
		$controller= "Acos";
		$model= "Aco";
		$item= __("Aco");
		
		$log= false;
		if($run)
		{
			//this could take a long long time
			set_time_limit(0);
			$log= $this->AclExtras->aco_sync();
		}
		
		$this->set(compact("log", "run"));
		
		$this->set("link_group", "acl");
		$this->set("current_link", "BuildAcos");
	}
	
	function clear_acos($run= false)
	{
		$controller= "Acos";
		$model= "Aco";
		$item= __("Aco");
		
		if($run) 
		{
    		if($this->Aco->deleteAll(array('id > 0'))) 
    		{
    			$this->Aco->query("TRUNCATE TABLE " . $this->Aco->useTable );
    	        $this->Utils->flash_simple(__('ACO table cleared'), "success");
    	    } 
    	    else 
    	    {
    	        $this->Utils->flash_simple(__('ACO table not cleared'), "warning");
    	    }
	    }
		
		$this->set(compact("run"));
		$this->set("link_group", "acl");
		$this->set("current_link", "ClearAcos");
	}
}
