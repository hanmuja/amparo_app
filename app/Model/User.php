<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 * @property Role $Role
 * @property User $Creator
 */
class User extends AppModel 
{
	public $displayField= "fullname";
	
	public $actsAs = array('Acl' => array('type' => 'requester'), "Containable");
/**
 * Validation rules
 *
 * @var array
 */
	public $validate= array();
 
	function __construct($id = false, $table = null, $ds = null) 
	{
		parent::__construct($id, $table, $ds);

		$this->validate = array
		(
			'username' => array(
				'notempty' => array(
					'rule' => array('notempty'),
					'message' => __('Enter a Username.'),
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
				'isUnique' => array(
					'rule' => array('isUnique'),
					'message' => __('The Username already exists.'),
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				)
			),
			'password' => array(
				'notempty' => array(
					'rule' => array('notempty'),
					'message' => __('Enter a Password'),
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'email' => array(
				'email' => array(
					'rule' => array('email'),
					'message' => __('Enter a valid Email Address'),
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
				/*'isUnique' => array(
					'rule' => array('isUnique'),
					'message' => __('The email already exist.'),
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				)*/
			),
			'email_list' => array(
				'email' => array(
					'rule' => array('multiEmail'),
					'message' => __('At least one address is invalid. Enter a comma separated list of valid Email Addresses'),
					'allowEmpty' => true,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'role_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __('Select a Role'),
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'first_name' => array(
				'notempty' => array(
					'rule' => array('notempty'),
					'message' => __("Enter the user's First Name"),
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'last_name' => array(
				'notempty' => array(
					'rule' => array('notempty'),
					'message' => __("Enter the user's Last Name"),
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			/*'employee_number' => array(
				'isUnique' => array(
					'rule' => array('isUnique'),
					'message' => __('There is an user with this employee number.'),
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				)
			),*/
			'default_location' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'default_route' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'created_by' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
		);
	}

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Role' => array(
			'className' => 'Role',
			'foreignKey' => 'role_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Creator' => array(
			'className' => 'User',
			'foreignKey' => 'created_by',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	public $hasMany = array(
		'LocationsUser' => array(
			'className' => 'LocationsUser',
			'foreignKey' => 'user_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
        'UsersRole' => array(
                'className' => 'UsersRole',
                'foreignKey' => 'user_id',
                'dependent' => true,
                'conditions' => '',
                'fields' => '',
                'order' => '',
                'limit' => '',
                'offset' => '',
                'exclusive' => '',
                'finderQuery' => '',
                'counterQuery' => ''
        ),
		'Folders' => array(
			'className' => 'Folder',
			'foreignKey' => 'user_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
	);
	
	public $hasAndBelongsToMany = array(
		'Location' => array(
			'className' => 'Location',
			'joinTable' => 'locations_users',
			'foreignKey' => 'user_id',
			'associationForeignKey' => 'location_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		'RoleCanSee' => array(
                        'className' => 'Role',
                        'joinTable' => 'users_roles',
                        'foreignKey' => 'user_id',
                        'associationForeignKey' => 'role_id',
                        'unique' => true,
                        'conditions' => '',
                        'fields' => '',
                        'order' => '',
                        'limit' => '',
                        'offset' => '',
                        'finderQuery' => '',
                        'deleteQuery' => '',
                        'insertQuery' => ''
                ),
	);
	
	function beforeSave($options = array()) 
	{
		if(isset($this->data['User']['password']))
        $this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
		
		$this->get_fullname();
		
        return true;
    }
    
    function get_fullname()
    {	
    	if(isset($this->data["User"]["first_name"]) || isset($this->data["User"]["first_name"]))
		{
			if(isset($this->data["User"]["first_name"]) && isset($this->data["User"]["first_name"]))
			{
				$this->data["User"]["fullname"]= $this->data["User"]["last_name"].", ".$this->data["User"]["first_name"];
			}
			elseif (isset($this->data["User"]["first_name"])) 
			{
				if(isset($this->data["User"]["id"]))
				{
					//get the last_name
					$current= $this->find("first", array("fields"=>array("id", "last_name")));	
					if($current)
					{
						if($current["User"]["last_name"])
						{
							$this->data["User"]["fullname"]= $current["User"]["last_name"].", ".$this->data["User"]["first_name"];
						}
						else 
						{
							$this->data["User"]["fullname"]= $this->data["User"]["first_name"];
						}
					}
					else 
					{
						$this->data["User"]["fullname"]= $this->data["User"]["first_name"];
					}
				}
				else
				{
					$this->data["User"]["fullname"]= $this->data["User"]["first_name"];
				}
			}
			else 
			{
				if(isset($this->data["User"]["id"]))
				{
					//get the last_name
					$current= $this->find("first", array("fields"=>array("id", "first_name")));	
					if($current)
					{
						if($this->data["User"]["last_name"])
						{
							$this->data["User"]["fullname"]= $this->data["User"]["last_name"].", ".$current["User"]["first_name"];
						}
						else 
						{
							$this->data["User"]["fullname"]= $current["User"]["first_name"];
						}
					}
					else 
					{
						$this->data["User"]["fullname"]= $this->data["User"]["last_name"];
					}
				}
				else
				{
					$this->data["User"]["fullname"]= $this->data["User"]["last_name"];
				}
			}
		}
    }

	function parentNode() 
	{
        if (!$this->id && empty($this->data)) 
        {
            return null;
        }
        if (isset($this->data['User']['role_id'])) 
        {
        	$roleId = $this->data['User']['role_id'];
        } else 
        {
            $roleId = $this->field('role_id');
        }
        if (!$roleId) 
        {
        	return null;
        } else 
        {
            return array('Role' => array('id' => $roleId));
        }
    }
	
	function multiEmail($check) { 
		
		App::import('Component', 'Utils');
    	$utils = new UtilsComponent(new ComponentCollection());
		
		$array_check = $utils->list_to_array($check['email_list']);
		
		$return = true;
		
		foreach($array_check as $email)
		{
			if(!$utils->valid_email($email))
				$return = false;
		}
		
		return $return;
	}
	
	
	function users_roles($id)
	{
          $this->contain('RoleCanSee');
          
          $user = $this->read(null, $id);
          
          $users = array();
          $conditions = array();
          
          if(!$user['User']['all_roles'] && !$user['User']['is_developer'])
          {
            $roles_ids = array();
            foreach($user['RoleCanSee'] as $role)
            {
              $roles_ids[] = $role['id'];
            }
            $conditions['and']['User.role_id'] = $roles_ids;
          }
          
          
          $users = $this->find('list', array('conditions' => $conditions, 'order' => 'User.fullname ASC'));
          return $users;
        }

}
