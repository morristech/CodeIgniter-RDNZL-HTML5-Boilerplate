<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends MX_Controller{
	function __construct(){
		parent::__construct();
		
		$this->load->library('tank_auth');
		if (!$this->tank_auth->is_logged_in()) redirect('auth/login');
		
	}
	
	function index(){
		//$this->load->helper('typography');		
		//$this->load->library('wp_the_content');
		
		$data = array();
				
		$this->load->view('tpl/header', $data);
		$this->load->view('blog/admin/list', $data);
		$this->load->view('tpl/footer', $data);
	}
}