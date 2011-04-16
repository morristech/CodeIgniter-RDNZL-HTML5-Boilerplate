<?php

class Blog extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->library('parser');		
	}
	
	function index(){
		$this->load->helper('typography');		
		$this->load->library('wp_the_content');
		
		$data = array();
		
		$data['posts'] = array(
			array(
			'id' => '1',
			'post_title' => 'Lorem ipsum dolor sit amet',
			'post_content' => $this->wp_the_content->wpautop(
'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce eget est mi, et porttitor dui. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.
			
Pellentesque commodo semper luctus. <b><i>Integer tristique enim ut arcu</i>,</b> consectetur imperdiet. Sed imperdiet leo mollis felis mattis sed venenatis orci scelerisque. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Duis dignissim mi metus, quis pharetra velit. Donec quam lectus, consequat quis consequat in, facilisis sed enim. In hac habitasse platea dictumst. 

Duis sem ipsum, pellentesque et eleifend scelerisque, tempor non dui. ')
			),
			array(
			'id' => '2',
			'post_title' => 'Fusce eget est mi',
			'post_content' => $this->wp_the_content->wpautop(
'Fusce eget est mi, et porttitor dui. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Pellentesque commodo semper luctus. 

Integer tristique enim ut arcu consectetur imperdiet. Sed imperdiet leo mollis felis mattis sed venenatis orci scelerisque. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Duis dignissim mi metus, quis pharetra velit. 

<blockquote>Donec quam lectus, consequat quis consequat in, facilisis sed enim. </blockquote>

In hac habitasse platea dictumst. Duis sem ipsum, pellentesque et eleifend scelerisque, tempor non dui. ')
			),
			array(
			'id' => '3',
			'post_title' => 'Sed imperdiet leo mollis',
			'post_content' => $this->wp_the_content->wpautop('Sed imperdiet leo mollis felis mattis sed venenatis orci scelerisque. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. 
			
Duis dignissim mi metus, quis pharetra velit. Donec quam lectus, consequat quis consequat in, facilisis sed enim. In hac habitasse platea dictumst. Duis sem ipsum, pellentesque et eleifend scelerisque, tempor non dui. 

<ul><li>Lorem ipsum dolor sit amet</li><li>consectetur adipiscing elit</li><li>Fusce eget est mi</li><li>et porttitor dui.</li></ul>

Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Pellentesque commodo semper luctus. Integer tristique enim ut arcu consectetur imperdiet. ')
			)
		);
		
		$this->load->view('tpl/header', $data);
		$this->load->view('blog/list', $data);
		$this->load->view('tpl/footer', $data);
	}
}