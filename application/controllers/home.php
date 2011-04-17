<?php

class Home extends CI_Controller{
	function __construct(){
		parent::__construct();
	}
	
	function index(){
		// project home page = the README.markdown file
		$this->load->helper('markdown');
		$readme_fn = FCPATH . 'README.markdown';
		$page_copy = file_exists($readme_fn) 
						? Markdown(file_get_contents($readme_fn)) 
						: ('README.markdown could not be found.<br><br>' . $readme_fn);
		
		// set up the data to pass into the view
		$data = array('page_copy' => $page_copy);
		
		// load the header, content view, and footer
		$this->load->view('tpl/header', isset($data) ? $data : array());
		$this->load->view('home', $data);
		$this->load->view('tpl/footer', isset($data) ? $data : array());
	}
}