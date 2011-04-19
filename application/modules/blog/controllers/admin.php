<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends MX_Controller{
	function __construct(){
		parent::__construct();
		
		if (!$this->tank_auth->is_logged_in()) redirect('auth/login');		

		$this->load->model('blog_posts');
	}
	
	function index(){		
		$data = array();
		
		$this->load->library('parser');		
				
		$data['posts'] = $this->blog_posts->get_posts();
		
		$this->load->view('tpl/header', $data);
		$this->load->view('blog/admin/list', $data);
		$this->load->view('tpl/footer', $data);
	}
}
