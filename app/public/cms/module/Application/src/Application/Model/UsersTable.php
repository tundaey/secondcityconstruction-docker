<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Application\Model\ShareFunctions;
use Zend\Db\Adapter\Adapter;

class UsersTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
	
    public function fetchAll()
    {
    	$resultSet = $this->tableGateway->select();
    	return $resultSet;
    }
    
    public function fetch($key, $value)
    {
    	$resultSet = $this->tableGateway->select(array($key=>$value));
    	return $resultSet->current();
    }
    
    public function updatePassword(Users $auth)
    {
        $data = array(
        		'usr_password'  		    => $auth->usr_password,
        );
        $this->tableGateway->update($data, array('usr_id' => $auth->usr_id));
    }
    
    public function saveUser(Users $auth)
    {   
        $data = array(
        		'usr_name' 				    => $auth->usr_name,
        		'usr_last_name'			    => $auth->usr_last_name,
        		'usr_email'  		        => $auth->usr_email,
        		'usr_email_confirmed'  	    => $auth->usr_email_confirmed,
        		'usr_url'  			        => $auth->usr_url,
        		'usr_active'  			    => $auth->usr_active,
        		'usr_password_salt'  	    => $auth->usr_password_salt,
        		'usr_password'  		    => $auth->usr_password,
        		'usr_registration_date'     => $auth->usr_registration_date,
        		'usr_registration_token'  	=> $auth->usr_registration_token,
        		'usr_ref' 	                => $auth->usr_ref,
        		'usr_ip'                    => $auth->usr_ip,
        		'usr_device'                => $auth->usr_device,
        );
        
        $this->tableGateway->insert($data);
    }
	
    public function saveSettings(Users $auth, $identity)
    {
    	$data = array(
    			'usr_name' 				    => $auth->usr_name,
    			'usr_last_name'			    => $auth->usr_last_name,
    			'usr_email'  		        => $auth->usr_email,
    	);
    	
    	$identity->usr_name = $auth->usr_name;
    	$identity->usr_last_name = $auth->usr_last_name;
    	$identity->usr_email = $auth->usr_email;
    	
    	$this->tableGateway->update($data, array('usr_id' => (int)$identity->usr_id));
    }
    
    public function getUserByEmail($usr_email)
    {
    	$rowset = $this->tableGateway->select(array('usr_email' => $usr_email));
    	$row = $rowset->current();
    	if (!$row) {
    		throw new \Exception("Could not find row $usr_email");
    	}
    	return $row;
    }
    
    public function getUserByToken($token)
    {
    	$rowset = $this->tableGateway->select(array('usr_registration_token' => $token));
    	$row = $rowset->current();
    	if (!$row) {
    		throw new \Exception("Could not find row $token");
    	}
    	return $row;
    }
    
    public function activateUser($usr_id)
    {
    	$data['usr_active'] = 1;
    	$data['usr_email_confirmed'] = 1;
    	$this->tableGateway->update($data, array('usr_id' => (int)$usr_id));
    }
    
    public function deleteBusiness($bus_id)
    {
        $this->tableGateway->delete(array('bus_id' => $bus_id));
    }	
}