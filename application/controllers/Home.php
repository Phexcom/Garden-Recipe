<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		$this->load->view('layout/header', ['title' => "Garden Recipe | Home", 'description' => "Best online Recipe", 'authors' => "Ralph, Khawar, Fatima"]);
 		$this->load->view('home/index');
 		$this->load->view('layout/footer');

	}
}