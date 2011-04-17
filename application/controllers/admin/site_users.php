<?php
class Site_Users extends CI_Controller{
	function __construct(){
		parent::__construct();

		$this->load->helper('url');
		$this->load->library('tank_auth');
		$this->load->library('manage_users');
	}
	
	function index(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			
			$data['users'] = $this->manage_users->get_users();
			
			$this->load->view('tpl/header', isset($data) ? $data : array());		
			$this->load->view('admin/top_nav', $data);
			$this->load->view('admin/users/list', $data);
			$this->load->view('tpl/footer', isset($data) ? $data : array());		
		}
	}
}