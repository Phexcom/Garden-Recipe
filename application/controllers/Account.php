<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {

	public function index()
	{
        if (!$this->session->has_userdata('id')) {
            return redirect('/account/login');
        }
        if ($this->session->is_admin) {
            return redirect('/admin/');
        }

		
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->model(
            ['user']
        );

        //Recipes By a Particular User
        // $Recipes = $this->recipe->getAllByUserId(
        //     $this->session->userdata('id')
        // );
        
        $user =  $this->session->userdata('id');
        
        $image = md5(strtolower(trim($this->session->userdata('email'))));

        $image = 'https://www.gravatar.com/avatar/'.$image.'?s=400';

        $this->load->view('layout/header', ['title' => "Garden Recipe | Register", 'description' => "Best online Recipe", 'authors' => "Ralph, Khawar, Fatima"]);
        $this->load->view('account/index', [
            'firstname'         => $this->session->userdata('firstname'),
            'lastname'          => $this->session->userdata('lastname'),
            'email'             => $this->session->userdata('email'),
            // 'recipes'           => $recipes,
            'image'             => $image,
            'user'              => $user
        ]);
        $this->load->view('layout/footer');
	}


	// Function for handling Login
	public function login(){

		if ($this->session->has_userdata('id')) {
            return redirect('/account');
        }

        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->model('user');
        $data = [];

        // Form Validation Rules for Login
        $this->form_validation->set_rules(
            'email',
            'Email',
            ['trim','required', 'valid_email']
        );

        $this->form_validation->set_rules(
            'password',
            'Password',
            ['trim','required']
        );

        if ($this->input->method(true) === "POST") {
            // print_r($this->input->post());
            if ($this->form_validation->run() == true) {
                $email = $this->input->post('email');
                $password = $this->input->post('password');
                $user = new User();
                $user = $user->getByEmail($email);
                // if email is found
                if ($user && password_verify($password, $user->getPassword())) {
                    if ($user->getIsActivated()) {
                        $this->session->set_userdata(
                            [
                                'id'                => $user->getId(),
                                'firstname'         => $user->getFirstname(),
                                'lastname'          => $user->getLastname(),
                                'email'             => $user->getEmail(),
                                'is_admin'          => $user->getIsAdmin()
                            ]
                        );
                        return redirect('/account/');
                    } else {
                        $data['error'] =
                            "Account not activated. Please check your email for activation link";
                    }
                } else {
                    $data['error'] = "Invalid email OR password";
                }
            }
        }



		$this->load->view('layout/header', ['title' => "Garden Recipe | Login", 'description' => "Best online Recipe", 'authors' => "Ralph, Khawar, Fatima"]);
 		$this->load->view('account/login');
 		$this->load->view('layout/footer');
	}



	// Function for handling Register
	public function register(){
		if ($this->session->has_userdata('id')) {
            return redirect('/account/');
        }

         $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->model(['user','activation']);

        // Form Validation Rules for Registration
        $this->form_validation->set_rules(
            'firstname',
            'Firstname',
             ['trim','required', 'max_length[100]']
        );

        $this->form_validation->set_rules(
            'lastname',
            'Lastname',
             ['trim','required', 'max_length[100]']
        );

        $this->form_validation->set_rules(
            'email',
            'Email',
            ['trim','required','valid_email', 'max_length[100]','is_unique[user.email]'],
            ['is_unique' => "Email address is already registered."]
        );

        $this->form_validation->set_rules(
            'password',
            'Password',
            ['trim','required','min_length[8]']
        );

        $this->form_validation->set_rules(
            'confirmpassword',
            'Password Confirmation',
            ['trim','matches[password]']
        );

        
        $this->form_validation->set_rules(
            'dob',
            'Date Of Birth',
            ['trim','required']
        );

        if ($this->input->method(true) === "POST") {
        	// print_r($this->input->post());
            if ($this->form_validation->run() == true) {
                $this->load->database();
                $this->db->trans_begin();
                $user = new User();
                $user->setFirstname($this->input->post('firstname'));
                $user->setLastname($this->input->post('lastname'));
                $user->setEmail($this->input->post('email'));
                $user->setPassword($this->input->post('password'));
                $user->setDob($this->input->post('dob'));

                

                if (!$this->user->create($user)) {
                    $this->db->trans_rollback();
                }
                // store token and send email
                $last_id = $this->db->insert_id();
                $random = $this->__generateToken();
                $activation = new Activation();
                $activation->setAccountId($last_id);
                $activation->setToken($random);
                if (!$this->activation->create($activation)) {
                    $this->db->trans_rollback();
                }
                $this->db->trans_commit();
                // Send email
                $token = $random . $last_id;
                $this->__sendMail($user, $token);
                $this->session->set_flashdata('message', 'Registration Successful. Check your email for activation link');
                return redirect('/account/login/');
            }
        }



		$this->load->view('layout/header', ['title' => "Garden Recipe | Register", 'description' => "Best online Recipe", 'authors' => "Ralph, Khawar, Fatima"]);
 		$this->load->view('account/register');
 		$this->load->view('layout/footer');
	}

    public function edituser($id){

        if (!$this->session->has_userdata('id')) {
            return redirect('/account/login');
        }
        if ($this->session->is_admin) {
            return redirect('/admin/');
        }

        
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->model(
            ['user']
        );

        if (!$id) {
            return redirect('/account');
        }

        // User must exist in db
        if(!$user = $this->user->get($id)) {
            $this->session->set_flashdata('message','User does not exist.');
            return redirect('/account');
        }

        // Form Validation Rules for Edit
        $this->form_validation->set_rules(
            'firstname',
            'Firstname',
             ['trim','required', 'max_length[100]']
        );

        $this->form_validation->set_rules(
            'lastname',
            'Lastname',
             ['trim','required', 'max_length[100]']
        );

        $this->form_validation->set_rules(
            'email',
            'Email',
            ['trim','required','valid_email', 'max_length[100]'],
            ['required' => "Email Field can't be empty"]
        );

         if ($this->input->method(true) === "POST") {
            if ($this->form_validation->run() == true) {
                $user = new User();
                $user->setId($id);
                $user->setFirstname($this->input->post('firstname'));
                $user->setLastname($this->input->post('lastname'));
                $user->setEmail($this->input->post('email'));
                if ($this->user->update($user)) {
                    $this->session->set_flashdata(
                        'message', 'User updated successfully!'
                    );
                    return $this->logout();
                } else {
                    $this->session->set_flashdata(
                        'error', 'User could not be updated. Try again!'
                    );
                }
            }
        }

    }

	public function logout()
    {
        $this->session->sess_destroy();
        return redirect('home');
    }

   // Activating User account
    public function activate($token)
    {
        if (strlen($token) < 21) {
            return redirect('/');
        }
        $token_string = substr($token, 0, 20);
        $id = str_replace($token_string, '', $token);
        if (!ctype_digit($id)) {
            return redirect('/');
        }
        $this->load->model(['activation','user']);
        $activation = $this->activation->get($id, $token_string);
        if (!$activation) {
            $this->session->set_flashdata('message', 'Account Activation Failed');
            return redirect('/');
        }
        $this->activation->delete($id, $token_string);
        // Activate user in User table
        $this->user->activate($id);
        $this->session->set_flashdata('message', 'Activation successful.
         Login below');
        return redirect('/account/login');
    }




     //Sending Activation Email
    private function __sendMail($user, $token)
    {
        $this->load->library('email');
        $link = site_url('/account/activate/'.$token.'/');
        $this->email->from('carphex@gmail.com', 'Carphex');
        $this->email->to($user->getEmail());
        $this->email->subject('Verification Email from Garden Recipe');
        $this->email->message('<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>Garden Recipe Email Verification</title><style type="text/css">body{font-family: ubuntu;background-color: white;color: gray; text-align: center;}</style></head><body><h2>Hello '.$user->getFirstname().' </h2><p>Your registeration request was recieved Below is your activation link.</p><br><br><p>Click the link below to activate your account.</p><p><pre><h3><a href="'.$link.'">Activate Account</a></h3></pre></p><br><br><p>After Activation you will be able to login with your account Email: '.$user->getEmail().' and the password you created</p><br><br><br><h1>Thank you for Registering on Garden Recipe</h1></body></html>');
        $this->email->send();
    }

    //Generating Token
    private function __generateToken($length = 20)
    {
        $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $str = '';
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $str .= $keyspace[random_int(0, $max)];
        }
        return $str;
    }
}