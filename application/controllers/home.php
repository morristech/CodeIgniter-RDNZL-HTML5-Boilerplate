<?php

class Home extends CI_Controller{
	function __construct(){
		parent::__construct();
	}
	
	function index(){
		$data = array();
		$this->load->view('tpl/header', $data);
		$this->load->view('home', $data);
		$this->load->view('tpl/footer', $data);
	}
}