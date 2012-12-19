<?php
App::uses('AppController', 'Controller');
/**
 * Folders Controller
 *
 * @property Folder $Folder
 */
class FoldersController extends AppController 
{
	function beforeFilter(){
		parent::beforeFilter(); 
		
		/**
		 * Add this to every single controller, so in the view we always know which is the current controller, model, and item name.
		 * For example, in the index, the delete, edit and add links go to the current controller, so we can copy+paste the most of the views.
		 */
		$model= "Folder";
		$controller= "Folders";
		$item= __("Folder");
		
		$this->set(compact("model", "controller", "item"));
	}
	
	function create_folder()
	{
		//debug($this->data); exit;
		$root = $this->Session->read('root');
		$default_folder = $root."/app/webroot/files";
		
		$folder_to_create = $this->data['parent_path']."/".$this->data['title'];
		
		if(mkdir($default_folder.$folder_to_create, 0755))
		{
			$result = array();
			$result['status'] = true;
			$result['id'] = str_replace("/", "_", $folder_to_create);
			$result['path'] = $folder_to_create;
			echo json_encode($result);
		}
		else {
			echo json_encode(array('status' => false));
		}
		
		exit;
	}
	
	function rename_folder()
	{
		$controller = "Folders";
		$model = "Folder";
		$items = __($controller);
		
		$root = $this->Session->read('root');
		$default_folder = $root."/app/webroot/files";
		
		$old_folder = $default_folder.$this->data['path'];
		
		$parent_path = $this->data['parent_path'];
		if($parent_path == '/')
			$new_path = $parent_path.$this->data['new_name'];
		else
			$new_path = $parent_path."/".$this->data['new_name'];
			
		$new_folder = $default_folder.$new_path;
		
		if(rename($old_folder, $new_folder))
		{
			$this->renameDb($this->data['path'], $new_path);
			$result = array();
			$result['status'] = true;
			$result['id'] = str_replace("/", "_", $new_path);
			$result['path'] = $new_path;
			echo json_encode($result);
		}
		else {
			echo json_encode(array('status' => false));
		}
		
		exit;
	}
	
	function remove_folder()
	{
		//debug($this->data); exit;
		$root = $this->Session->read('root');
		$default_folder = $root."/app/webroot/files";
		
		$folder_to_remove = $this->data['path'];
		
		if($this->rrmdir($default_folder.$folder_to_remove))
		{
			$this->removeDb($folder_to_remove);
			
			$result = array();
			$result['status'] = true;
			echo json_encode($result);
		}
		else {
			echo json_encode(array('status' => false));
		}
		
		exit;
	}
	
	# recursively remove a directory
	function rrmdir($dir) {
	    foreach(glob($dir . '/*') as $file) {
	        if(is_dir($file))
	            $this->rrmdir($file);
	        else
	            unlink($file);
	    }
	    return rmdir($dir);
	}
	
	function renameDb($old, $new)
	{
		$controller = "Folders";
		$model = "Folder";
		$items = __($controller);
		
		$conditions = array();
		$conditions['and']['folder like'] = "%$old%";
		
		/**
		 * SAVE IN FOLDERS
		 */
		$this->$model->recursive = -1;
		$folders = $this->$model->find('all', array('fields' => array('id', 'folder'), 'conditions' => $conditions));
		
		$folders_save = array();
		
		foreach($folders as $folder)
		{
			$folder[$model]['folder'] = str_replace($old, $new, $folder[$model]['folder']);
			$folders_save[] = $folder;
		}
		
		$this->$model->saveAll($folders_save);
		
		/**
		 * SAVE IN DEFAULT FOLDERS
		 */
		$this->loadModel("DefaultFolders");
		$this->DefaultFolders->recursive = -1;
		$folders = $this->DefaultFolders->find('all', array('fields' => array('id', 'folder'), 'conditions' => $conditions));
		
		$folders_save = array();
		
		foreach($folders as $folder)
		{
			$folder['DefaultFolders']['folder'] = str_replace($old, $new, $folder['DefaultFolders']['folder']);
			$folders_save[] = $folder;
		}
		
		$this->DefaultFolders->saveAll($folders_save);
	}
	
	function removeDb($folder)
	{
		$controller = "Folders";
		$model = "Folder";
		$items = __($controller);
		
		$conditions = array();
		$conditions['and']['folder like'] = "%$folder%";
		
		/**
		 * DELETE IN FOLDERS
		 */
		$this->$model->recursive = -1;
		$folders = $this->$model->find('all', array('fields' => array('id', 'folder'), 'conditions' => $conditions));
		
		foreach($folders as $folder)
		{
			$this->$model->delete($folder[$model]['id']);
		}
		
		/**
		 * DELETE IN DEFAULT FOLDERS
		 */
		$this->loadModel("DefaultFolders");
		$this->DefaultFolders->recursive = -1;
		$folders = $this->DefaultFolders->find('all', array('fields' => array('id', 'folder'), 'conditions' => $conditions));
		
		foreach($folders as $folder)
		{
			$this->DefaultFolders->delete($folder[DefaultFolders]['id']);
		}
	}
	
	function select_folder()
	{
		return false;
	}
	
	function can_download()
	{
		return false;
	}
	
	function can_upload()
	{
		return false;
	}
	
	function can_search()
	{
		return false;
	}
	
	function can_copy()
	{
		return false;
	}
	
	function can_move()
	{
		return false;
	}
	
	function can_bulk_download()
	{
		return false;
	}
}
