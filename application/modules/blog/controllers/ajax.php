<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends MX_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('blog_posts');
	}
	
	function get_posts(){
		$data = array();
		
		$data['posts'] = $this->blog_posts->get_posts();
		echo json_encode($data['posts']);
	}
	
	function get_post(){		
		if(FALSE === $this->uri->segment(4)):
			$this->json_error_msg('Sorry, no post found.');		
		elseif(intval($this->uri->segment(4)) > 0): 
			$find_term = $this->uri->segment(4);
			echo json_encode($this->blog_posts->get_post($find_term));
		else:
			$this->json_error_msg('Sorry, no post found.');
		endif;
	}
	function update_post(){
	
		if (!$this->tank_auth->is_logged_in()):
			$this->json_error_msg('You must be logged in to do that.');
		endif;
			
		if(FALSE === $this->uri->segment(4)):
			$this->json_error_msg('Sorry, no post found.');		
			
		elseif(intval($this->uri->segment(4)) > 0): 
		
			$find_term = $this->uri->segment(4);
			
			// get our input data and validate it
			$this->load->library('form_validation');
			$this->form_validation->CI =& $this;
			
			$this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
			$this->form_validation->set_rules('content', 'Content', 'trim|required|xss_clean');
			
			// begin validate-or-die block
			if ($this->form_validation->run() == FALSE):
				$this->json_error_msg('There was an error in your submission');
			else:
				$data = array(
					'title' => $this->input->post('title'),
					'content' => $this->input->post('content'),
					'datetime_last_edited' => strtotime('now'),
				);
			
				$result = $this->blog_posts->update_post($find_term, $data);
				
				if($result->has_error()):
					$this->json_error_msg($result->get_msg());
				else:
					$result = array('success' => true, 'msg' => $result->get_msg());
				endif;
				
				echo json_encode($result); 
				return;				
			
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
?>