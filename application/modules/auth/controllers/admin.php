<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends MX_Controller
{
	function __construct(){
		parent::__construct();

		if (!$this->tank_auth->is_logged_in()) redirect('auth/login');		
		
		$this->load->library('manage_users');
	}
	
	function index(){
		$data['user_id']	= $this->tank_auth->get_user_id();
		$data['username']	= $this->tank_auth->get_username();
		
		$data['users'] = $this->manage_users->get_users();
		
		
		$this->load->view('tpl/header', isset($data) ? $data : array());		
		$this->load->view('auth/admin/list', $data);
		$this->load->view('tpl/footer', isset($data) ? $data : array());		
	}
}
?>