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
	
	function get_posts(){
		$data = array();
		
		$data['posts'] = $this->blog_posts->get_posts();
		echo json_encode($data['posts']);
	}
	
	function get_post(){		
		if(FALSE === $this->uri->segment(3)):
			$this->json_error_msg('Sorry, no post found.');		
		elseif(intval($this->uri->segment(3)) > 0): 
			$find_term = $this->uri->segment(3);
			echo json_encode($this->blog_posts->get_post($find_term));
		else:
			$this->json_error_msg('Sorry, no post found.');
		endif;
	}
	
	function update_post(){
	
		if (!$this->tank_auth->is_logged_in()):
			$this->json_error_msg('You must be logged in to do that.');
		endif;
			
		if(FALSE === $this->uri->segment(3)):
			$this->json_error_msg('Sorry, no post found.');		
			
		elseif(intval($this->uri->segment(3)) > 0): 
		
			//$_POST['ajax'] = true;
			//$_POST['content'] = 'Sed imperdiet leo mollis felis mattis sed venenatis orci scelerisque. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Duis dignissim mi metus, quis pharetra velit. Donec quam lectus, consequat quis consequat in, facilisis sed enim. In hac habitasse platea dictumst. Duis sem ipsum, pellentesque et eleifend scelerisque, tempor non dui. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce eget est mi, et porttitor dui. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Pellentesque commodo semper luctus. Integer tristique enim ut arcu consectetur imperdiet.';
			//$_POST['datetime_published'] = date('Y-m-d g:i:s');
			//$_POST['title'] = 'My Second Post !!!!';
		
			$find_term = $this->uri->segment(3);
			
			// get our input data and validate it
			$this->load->library('form_validation');
			$this->form_validation->CI =& $this;
			
			$this->form_validation->set_rules('ajax', 'Ajax Option', 'trim|bool|xss_clean');
			$this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
			$this->form_validation->set_rules('content', 'Content', 'trim|required|xss_clean');
			$this->form_validation->set_rules('datetime_published', 'Time Published', 'trim|xss_clean');
			
			// begin validate-or-die block
			if ($this->form_validation->run() == FALSE):
				$this->json_error_msg('There was an error in your submission');
			else:
				$data = array(
					'title' => $this->input->post('title'),
					'content' => $this->input->post('content'),
					'datetime_last_edited' => date('Y-m-d g:i:s'),
				);
			
				$result = $this->blog_posts->update_post($find_term, $data);
				
				if($this->input->post('ajax')):
					if($result->has_error()):
						$this->json_error_msg($result->get_msg());
					else:
						$result = array('success' => true, 'msg' => $result->get_msg());
					endif;
					
					echo json_encode($result); 
					return;				
				else:
					// TODO: redirecto blog/admin
					// set flash message
					redirect('blog/admin');
				endif;
			
			endif;
			// end validate-or-die block
		else:
			$this->json_error_msg('Sorry, no post found.');
		endif;
	}
	
	function json_error_msg($msg){
		if(is_string($msg)):
			$msg = array('error'=>$msg);
		else:
			return NULL;
		endif;
		
		echo json_encode($msg);
		exit();
	}

}