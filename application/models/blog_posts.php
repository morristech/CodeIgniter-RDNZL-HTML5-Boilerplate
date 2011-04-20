<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Blog
 *
 * This model represents blog data. It operates the following tables:
 * - blog
 * - blog_meta
 *
 * @package	RDNZL_Blog
 * @author	Wes Broadway (http://wesbroadway.com)
 */
class Blog_posts extends CI_Model
{
	private $table_name			= 'blog';		// main blog posts data
	private $meta_table_name	= 'blog_meta';	// blog post meta data
	private $error				= false;
	private $msg				= '';
	
	function get_frontend_elements(){
		return $this->get_backend_elements();
	}
	function get_backend_elements(){
		$els = array();
		$query = $this->db->query("DESCRIBE " . $this->table_name);
		
		$results = array();
		
		if($query->num_rows() > 0)
			foreach($query->result() as $row) array_push($results, $row);
			
					
		foreach($results as $field):
			//echo $field->name . ': ' . $field->type ."\n";
			//var_dump($field);
			$add_field = true;
			
			if($field->Type == 'int(11)'):
				$field->Type = 'int';
			elseif(preg_match('/enum/', $field->Type)):
				$field->Type = 'enum';				
			endif;
			
			if($field->Key == 'PRI' && $field->Type == 'int'):
				$add_field = false;
			endif;
			
			
			
			if($add_field):
				$el = array();
				$el['field_type'] = $field->Type;
				$el['nice_name'] = ucwords(str_replace('_', ' ', $field->Field));
				$el['field_name'] = $field->Field;
	
				array_push($els, (object)$el);			
			endif;
		endforeach;
		
		return $els;
		
	}
	function get_posts(){
		$this->db->order_by('datetime_created', 'desc');
		
		$query = $this->db->get($this->table_name);
		
		$results = array();

		if($query->num_rows() > 0)
			foreach($query->result() as $row) array_push($results, $row);
			
		return $results;
	}
	function get_post($find_term){
		// this will be our catch-all lookup function. currently it only finds by interger -> id
		$post = array();
		if(is_integer($find_term)):
			$post = $this->get_post_by_id($find_term);
		else:
			// maybe it's an integer disguised as a string. this calls for some recursion
			// first, cast it as an int
			$find_term = (int)$find_term;
			// then try again
			if($find_term > 0):
				// here's the recursive call:
				$post = $this->get_post($find_term);
			else:
				return array('error' => "Not an integer: {$find_term}");
			endif;
		endif;
		
		return $post;
	}

	function get_post_by_id($id){
		$this->db->where('id', $id);
		
		$query = $this->db->get($this->table_name);
		
		if($query->num_rows() == 1)
			return $query->row();
			
		$this->set_error(true);
		return;
	}
	
	function create_post($data){
		$this->db->insert($this->table_name, $data);
		$this->set_msg('Create successful');
		return $this;
	}
	function get_last_insert_id(){
		return $this->db->insert_id();
	}

	function update_post($id, $data){
		$this->db->where('id', $id);
		$this->db->update($this->table_name, $data);
		$this->set_msg('Update successful');
		return $this;
	}
	function delete_post($id){
		$this->db->where('id', $id);
		$this->db->delete($this->table_name);
		$this->set_msg('Delete successful');
		return $this;
	}

		
	function has_error(){
		return $this->error ? true : false;
	}
	function set_error($val){
		$this->error = $val;
		return $this;
	}
	function get_msg(){
		return $this->msg;
	}
	function set_msg($val){
		$this->msg = $val;
		return $this;
	}
	
}

