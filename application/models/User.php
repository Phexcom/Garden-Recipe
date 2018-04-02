<?php


class User extends CI_Model
{

	public $id;
    public $firstname;
    public $lastname;
    public $email;
    public $password;
    public $dob;
    public $is_admin;
    public $is_activated;

//Loading Database
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

//Getters and Setters
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
         $this->id = $id;
    }

    public function getFirstname()
    {
    	return $this->firstname;
    }

    public function setFirstname($firstname)
    {
    	$this->firstname = $firstname;

    }

    public function getLastname()
    {
    	return $this->lastname;
    }

    public function setLastname($lastname)
    {
    	$this->lastname = $lastname;
    }

    public function getEmail()
    {
    	return $this->email;
    }

    public function setEmail($email)
    {
    	$this->email = $email;
    }

    public function getPassword(){

    	return $this->password;
    }

    public function setPassword($password)
    {
    	 $this->password = password_hash($password, PASSWORD_BCRYPT);
    }

    public function getDob()
    {
    	return $this->dob;
    }

    public function setDob($dob)
    {
    	$this->dob = $dob;
    }

   public function getIsAdmin()
    {
        return $this->is_admin;
    }


    public function setIsAdmin($isAdmin)
    {
        $this->is_admin = $isAdmin;
    }

    public function getIsActivated()
    {
        return $this->is_activated;
    }

    public function setIsActivated($isActivated)
    {
        $this->is_activated = $isActivated;
    }



    public function create(User $user)
    {
        unset($user->is_admin);
        unset($user->is_activated);
        return $this->db->insert('user', $user);
    }

    public function getAll()
    {
        $user = $this->db->get('user');
        $result_array = [];
        foreach ($user->result_array() as $row) {
            $result_array[] = $this->loadObject($row);
        }
        return $result_array;
    }

    public function get($regId)
    {
        $this->db->where('id', $regId);
        $user = $this->db->get('user');
        return $this->loadObject($user->row_array());
    }

    public function getByEmail($email)
    {
        $this->db->where('email', $email);
        $user = $this->db->get('user');
        return $this->loadObject($user->row_array());
    }

    public function activate($id)
    {
        $this->db->where('id', $id);
        $this->db->set('is_activated', '1');
        $this->db->update('user');
    }

    public function update(User $user) {
        $id = $user->getId();
        unset($user->id);
        unset($user->password);
        unset($user->is_activated);
        unset($user->is_admin);
        return $this->db->update('user',$user,['id' => $id]);
    }


    private function loadObject(array $result = null)
    {
        if (!$result) return false;
        $user = new User();
        $user->setId($result['id']);
        $user->setFirstname($result['firstname']);
        $user->setLastname($result['lastname']);
        $user->setEmail($result['email']);
        $user->password = $result['password'];
        $user->setDob($result['dob']);
        $user->setIsAdmin($result['is_admin']);
        $user->setIsActivated($result['is_activated']);
        return $user;
    }
}