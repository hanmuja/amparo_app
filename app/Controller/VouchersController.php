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
			$this->request->data[$model]['fecha'] = strtotime($this->request->data[$model]['fecha_s']);
			$this->request->data[$model]['dia_llegada'] = strtotime($this->request->data[$model]['dia_llegada_s']." ".$this->request->data[$model]['hora_llegada_s']);
			$this->request->data[$model]['dia_salida'] = strtotime($this->request->data[$model]['dia_salida_s']." ".$this->request->data[$model]['hora_salida_s']);
			
			$this->$model->create();
			if ($this->$model->saveAll($this->request->data))
			{
				$this->Utils->flash($item, "success_add");
				$this->redirect(array("plugin"=>null, "controller"=>$controller, 'action' => 'edit', $this->$model->id));
			} 
			else 
			{
				$this->Utils->flash($item, "error_add");
			}
		}
		else
		{
			$texto = '<table border="0" cellpadding="1" cellspacing="1" style="width: 600px;"><tbody>';
			$i = 0;
			while($i<10)
			{
				$texto.='<tr><td style="vertical-align: top; width: 80px;">&nbsp;</td><td>&nbsp;</td></tr>';
				$i++;
			}
			$texto.='</tbody></table>';
			
			$this->request->data[$model]['servicios'] = $texto; 
		}
		
		$sellers = $this->$model->Seller->find('list', array('order' => 'Seller.nombre'));
		$providers = $this->$model->Provider->find('list', array('order' => 'Provider.nombre'));
		
		$last_id = $this->$model->getLastId();
		
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
			$this->request->data[$model]['fecha'] = strtotime($this->request->data[$model]['fecha_s']);
			$this->request->data[$model]['dia_llegada'] = strtotime($this->request->data[$model]['dia_llegada_s']." ".$this->request->data[$model]['hora_llegada_s']);
			$this->request->data[$model]['dia_salida'] = strtotime($this->request->data[$model]['dia_salida_s']." ".$this->request->data[$model]['hora_salida_s']);
			
			$this->$model->create();
			if ($this->$model->saveAll($this->request->data))
			{
				$this->Utils->flash($item, "success_update");
				$this->redirect(array("plugin"=>null, "controller"=>$controller, 'action' => 'edit', $this->$model->id));
			} 
			else 
			{
				$this->Utils->flash($item, "error_update");
			}
		}
		else
		{
			$this->$model->recursive = -1;
			$this->request->data = $this->$model->read(null, $id);
			$this->request->data[$model]['fecha_s'] = date('d-m-Y', $this->request->data[$model]['fecha']);
			$this->request->data[$model]['dia_llegada_s'] = date('d-m-Y', $this->request->data[$model]['dia_llegada']);
			$this->request->data[$model]['hora_llegada_s'] = date('H:i', $this->request->data[$model]['dia_llegada']);
			$this->request->data[$model]['dia_salida_s'] = date('d-m-Y', $this->request->data[$model]['dia_salida']);
			$this->request->data[$model]['hora_salida_s'] = date('H:i', $this->request->data[$model]['dia_salida']);
		}
		
		$sellers = $this->$model->Seller->find('list', array('order' => 'Seller.nombre'));
		$providers = $this->$model->Provider->find('list', array('order' => 'Provider.nombre'));
		
		$last_id = $id;
		
		$this->set(compact('last_id', 'sellers', 'providers'));
		
		$this->set("edit", true);
		
		$this->render("add");
	}

	function charge_provider()
	{
		$model="Voucher";
		
		$this->$model->Provider->recursive = -1;
		$provider = $this->$model->Provider->read(null, $this->request->data['provider_id']);
		echo json_encode($provider);
		exit;
	}
	
	function vistaPrevia($id)
	{
		$model = "Voucher";
		$controller = "Vouchers";
		$item = __("Voucher");
		
		$this->$model->id = $id;
		if (!$this->$model->exists()) 
		{
			throw new NotFoundException(__('Invalid '.$item));
		}
		
		$voucher = $this->$model->read(null, $id);
		$this->set(compact('voucher'));
		
		$this->layout = null;
		
		$this->render('voucher_html');
	}
	
	function imprimirVoucher($id)
	{
		$model = "Voucher";
		$controller = "Vouchers";
		$item = __("Voucher");
		
		$this->$model->id = $id;
		if (!$this->$model->exists()) 
		{
			throw new NotFoundException(__('Invalid '.$item));
		}

		Configure::write('debug',0);
		
		$this->layout = 'pdf'; //this will use the pdf.ctp layout
		
		$save = array();
		$save[$model]['id'] = $id;
		$save[$model]['impreso'] = 1;
		$this->$model->save($save);
		
		$html = $this->requestAction(array('plugin' => null, 'controller' => $controller, 'action' => 'voucherHtml', $id), array('return'));
		//debug($html); exit;
		$this->set(compact('html'));
		
	}
	
	function voucherHtml($id)
	{
		$model = "Voucher";
		
		$voucher = $this->$model->read(null, $id);
		$this->set(compact('voucher'));
		
		$this->layout = null;
	}
}