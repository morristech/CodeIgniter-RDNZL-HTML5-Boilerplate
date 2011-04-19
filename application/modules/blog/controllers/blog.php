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
	
	function admin(){		
		if (!$this->tank_auth->is_logged_in()) redirect('auth/login');
		
		$this->load->helper('typography');		
		$this->load->library('wp_the_content');
		
		$data = array();
		
		$data['posts'] = $this->blog_posts->get_posts();
		
		$this->load->view('tpl/header', $data);
		$this->load->view('blog/admin/list', $data);
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
	
	function delete_post(){
		//require login for this process
		if (!$this->tank_auth->is_logged_in()):
			$this->json_error_msg('You must be logged in to do that.');
		endif;
		
		// make sure we've got an ID
		if(FALSE === $this->uri->segment(3)):
			$this->json_error_msg('Sorry, no post found.');		
		
		// if the ID is greater than 0, continue...
		elseif(intval($this->uri->segment(3)) > 0): 
			$find_term = $this->uri->segment(3);
			// execute the delete
			$result = $this->blog_posts->delete_post($find_term);
			// check result for any errors, handle accordingly
			if($result->has_error()):
				$this->json_error_msg($result->get_msg());
			else:
				$result = array('success' => true, 'msg' => $result->get_msg());
			endif;
			
			echo json_encode($result); 
		endif;
		
		return;		
	}
	function update_post(){
	
		if (!$this->tank_auth->is_logged_in()):
			$this->json_error_msg('You must be logged in to do that.');
		endif;
			
		if(FALSE === $this->uri->segment(3)):
			$this->json_error_msg('Sorry, no post found.');		
			
		elseif(intval($this->uri->segment(3)) > 0): 
				
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
					'datetime_published' => $this->input->post('datetime_published'),
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
	function create_post(){
	
		if (!$this->tank_auth->is_logged_in()):
			$this->json_error_msg('You must be logged in to do that.');
		endif;	
		
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
				'datetime_published' => $this->input->post('datetime_published'),
				'datetime_created' => date('Y-m-d g:i:s'),
				'status' => 'published',
				'author' => $this->tank_auth->get_user_id(),
				'last_edited_by' => $this->tank_auth->get_user_id(),
			);
		
			$result = $this->blog_posts->create_post($data);
			
			if($this->input->post('ajax')):
				if($result->has_error()):
					$this->json_error_msg($result->get_msg());
				else:
					$result_id = $this->blog_posts->get_last_insert_id();
					$result = array('success' => true, 'msg' => $result->get_msg(), 'id' => $result_id);
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