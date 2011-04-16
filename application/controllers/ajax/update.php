<?php 

class Update extends CI_Controller{
	function __construct(){
		parent::__construct();
	}

	function index(){
		$data = array();
		$this->load->view('ajax/update', $data);
	}
}