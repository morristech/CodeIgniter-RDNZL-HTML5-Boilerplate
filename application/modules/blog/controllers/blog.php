<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Blog extends MX_Controller{
	function __construct(){
		parent::__construct();
		$this->load->library('parser');		
		$this->load->model('blog_posts');
	}
	
	function index(){
		$this->load->helper('typography');		
		$this->load->library('wp_the_content');
		
		$data = array();
		
		$data['posts'] = $this->blog_posts->get_posts();
		
		$this->load->view('tpl/header', $data);
		$this->load->view('list', $data);
		$this->load->view('tpl/footer', $data);
	}
}