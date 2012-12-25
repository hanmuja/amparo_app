<?php
App::uses('AppController', 'Controller');
/**
 * Vouchers Controller
 *
 * @property Voucher $Voucher
 */
class VouchersController extends AppController 
{
	function beforeFilter(){
		parent::beforeFilter(); 
		
		/**
		 * Add this to every single controller, so in the view we always know which is the current controller, model, and item name.
		 * For example, in the index, the delete, edit and add links go to the current controller, so we can copy+paste the most of the views.
		 */
		$model= "Voucher";
		$controller= "Vouchers";
		$item= __("Voucher");
		
		$this->set(compact("model", "controller", "item"));
		
		$this->Auth->allowedActions = array('*');
	}
	
	function index()
	{
		$model= "Voucher";
		$controller= "Vouchers";
		$item= __("Voucher");
		
       $this->set("title_for_layout", $item);   
		
		$conditions= $this->CustomTable->get_conditions($controller);
		
		$this->Paginator->settings= array($model=>array("order"=>array("$model.name"=>"asc")));
		
		$paginated= $this->CustomTable->isPaginated();
		
		$this->$model->recursive = 0;
		$all= $this->paginate($conditions);
		
		//Send the list of equipment to the view and the value of paginated.
       $this->set(compact("paginated", "all"));
	}

	function add()
	{
		/**
		 * This will save us time in the copy+paste process inside every action.
		 */
		$model = "Voucher";
		$controller = "Vouchers";
		$item = __("Voucher");
     	
       $this->set("title_for_layout", __("Add ".$item));
		
		if($this->request->is('post'))
		{
			$this->$model->create();
			if ($this->$model->saveAll($this->request->data))
			{
				$this->Utils->flash($item, "success_add");
				$this->redirect(array("plugin"=>null, "controller"=>$controller, 'action' => 'index'));
			} 
			else 
			{
				$this->Utils->flash($item, "error_add");
			}
		}
		
		$sellers = $this->$model->Seller->find('list', array('order' => 'Seller.nombre'));
		$providers = $this->$model->Provider->find('list', array('order' => 'Provider.nombre'));
		
		$last_id = $this->$model->getLastId();
		
		$last_id++;
		
		$this->set(compact('last_id', 'sellers', 'providers'));
		
		$this->set("edit", false);
		
		//$this->render("form");
	}
	
	function delete($id)
	{
		$model="Voucher"; 
		$controller= "Vouchers";
		$item= __("Voucher");
     	
		if (!$this->request->is('post')) 
		{
			throw new MethodNotAllowedException();
		}
		
		$this->$model->id = $id;
		if (!$this->$model->exists()) 
		{
			throw new NotFoundException(__('Invalid '.$item));
		}
		
		if ($this->$model->delete($id)) 
		{
			$this->Utils->flash($item, "success_delete");
			$this->redirect(array("plugin"=>null, "controller"=>$controller, 'action'=>'index'));
		}
		$this->Utils->flash($item, "error_delete");
		$this->redirect(array("plugin"=>null, "controller"=>$controller, 'action' => 'index'));
	}
	
	function edit($id)
	{
		/**
		 * This will save us time in the copy+paste process inside every action.
		 */
		$model = "Voucher";
		$controller = "Vouchers";
		$item = __("Voucher");
		
		$this->$model->id = $id;
		if (!$this->$model->exists()) 
		{
			throw new NotFoundException(__('Invalid '.$item));
		}
		
		if($this->request->is('post') || $this->request->is('put'))
		{			
			$this->$model->create();
			if ($this->$model->saveAll($this->request->data)) 
			{
				$this->Utils->flash($item, "success_update");
				
				if($this->request->is('ajax'))
				{
					//$this->layout= "empty";
					$this->set("url_redirect", array("plugin"=>null, "controller"=>$controller, "action"=>"index"));
					$this->set("close", true);
					$this->render("form");
					
					return;
				}
				else
				{
					/**
					 * If this wasn't an ajax request, we just redirect to the index, to see the list.
					 */
					$this->redirect(array("plugin"=>null, "controller"=>$controller, 'action' => 'index'));
				}
			} 
			else 
			{
				$this->Utils->flash($item, "error_add");
			}
		}
		else {
			$this->request->data = $this->$model->read(null, $id);
		}
		
		$this->set("edit", true);
		
		$this->render("form");
	}

	function charge_provider()
	{
		$model="Voucher";
		
		$this->$model->Provider->recursive = -1;
		$provider = $this->$model->Provider->read(null, $this->request->data['provider_id']);
		echo json_encode($provider);
		exit;
	}
}