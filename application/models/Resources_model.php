<?php
	class Resources_model extends CI_Model {

    public function __construct(){
        $this->load->database();
    }

	public function get_all_resources($id = FALSE){
		$this->db->select('*, resources.id as resources_ID');
    	$this->db->join('resources_category', 'resources_category.resource_ID = resources.id', 'left');
    	$this->db->join('resources_type', 'resources_type.id = resources.type', 'left');
    	$this->db->join('admin', 'admin.id = resources.admin_ID');
    	$this->db->group_by('resources.id');
		if($id === FALSE){
			$query = $this->db->get('resources');;
			return $query->result_array();
		}

		$query = $this->db->get_where('resources', array('resources.id' => $id));

		return $query->row_array();
	}

	public function get_resources_categories($id = FALSE){
		$this->db->select('resources_category.resource_ID as resource_ID, category.name as category_name, resources_category.category_ID as category_ID');
    	$this->db->join('resources_category', 'resources_category.resource_ID = resources.id');
    	$this->db->join('category', 'category.id = resources_category.category_ID');
    	$this->db->order_by('timestamp', 'ASC');

    	if($id === FALSE){
			$query = $this->db->get('resources');
			return $query->result_array();
		}

		$query = $this->db->get_where('resources', array('resources.id' => $id));

		return $query->result_array();
	}

	public function get_resources_type(){
		$this->db->select('*');
   		$this->db->join('resources_type', 'resources_type.id = resources.type');
    	$this->db->order_by('timestamp', 'ASC');
		$query = $this->db->get('resources');

		return $query->result_array();
	}

	public function get_files($id){
    	$query = $this->db->get_where('resources_files', array('resource_ID' => $id));
		return $query->result_array();
	}

	public function get_categories($id = FALSE){
		if($id === FALSE){
			$query = $this->db->get('category');;
			return $query->result_array();
		}

		$query = $this->db->get_where('category', array('id' => $id));

		return $query->row_array();
	}

	public function get_keywords($id = FALSE){
		if($id === FALSE){
			$query = $this->db->get('keywords');;
			return $query->result_array();
		}

		$query = $this->db->get_where('keywords', array('id' => $id));

		return $query->row_array();
	}

	public function get_type($id = FALSE){
		if($id === FALSE){
			$query = $this->db->get('resources_type');;
			return $query->result_array();
		}

		$query = $this->db->get_where('resources_type', array('id' => $id));

		return $query->row_array();
	}

	public function create_category($name){
		$this->db->trans_begin();

		$data = array(
			'name' => strtolower($name),
		);

		$this->db->insert('category', $data);

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
		
	}

	public function create_content($admin_ID, $title, $meta_description, $type, $banner, $content, $select_category, $meta_keywords, $uploads){
		$this->db->trans_begin();

		$slug = url_title($title);

		$data = array(
			'title' => $title,
			'slug' => strtolower($slug),
			'type' => $type,
			'banner' => $banner,
			'content' => $content,
			'meta_description' => strtolower($meta_description),
			'meta_keywords' => strtolower($meta_keywords),
			'admin_ID' => $admin_ID
		);

		$this->db->insert('resources', $data);
		$query = $this->db->select('id')->where('title',$title)->get('resources')->row_array();
		$resource_ID = $query['id'];
		
		$total_category = count($this->input->post('select_category'));
		for($i=0; $i<$total_category; $i++) {
			if(trim($this->input->post('select_category')[$i] != '')) {
		        $category_ID = $select_category[$i];

		        $data2 = array(
					'resource_ID' => $resource_ID,
					'category_ID' => $category_ID
				);
		    	
				$this->db->insert('resources_category', $data2);
			}
		}

		$total_keyword = count($this->input->post('select_keyword'));
		for($i=0; $i<$total_keyword; $i++) {
			if(trim($this->input->post('select_keyword')[$i] != '')) {
		        $keyword_ID = $select_keyword[$i];
		        $data3 = array(
					'resource_ID' => $resource_ID,
					'keyword_ID' => $keyword_ID
				);
		    	
				$this->db->insert('resources_keywords', $data3);
			}
		}

		if(!empty($uploads)){
			$sql = $this->upload_file($uploads, $resource_ID);
			if(!$sql){
				return false;
			}
		}
		

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
		
	}

	public function upload_file($uploads, $resource_ID){
		$this->db->trans_begin();

		$total_files = count($uploads);
		for($i=0; $i<$total_files; $i++) {
			if(trim($uploads[$i] != '')) {
		        $file = $uploads[$i];

		        $data = array(
		        	'file' => $file,
					'resource_ID' => $resource_ID
				);
		    	
				$this->db->insert('resources_files', $data);
			}
		}

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
		
	}

	public function delete_files($resource_ID){
		$this->db->trans_begin();
		
		$this->db->delete('resources_files', array('resource_ID' => $resource_ID));

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
		
	}

	public function update($id, $title, $meta_description, $type, $banner, $content, $select_category, $meta_keywords){
		$this->db->trans_begin();
		$slug = url_title($title);

		$data = array(
			'title' => $title,
			'slug' => strtolower($slug),
			'type' => $type,
			'banner' => $banner,
			'content' => $content,
			'meta_description' => strtolower($meta_description),
			'meta_keywords' => strtolower($meta_keywords),
		);

		$this->db->set('timestamp', 'NOW()', FALSE);
		$this->db->where('id', $id);
		$this->db->update('resources', $data);

		$this->db->delete('resources_category', array('resource_ID' => $id));

		$total_category = count($this->input->post('select_category'));
		for($i=0; $i<$total_category; $i++) {
			if(trim($this->input->post('select_category')[$i] != '')) {
		        $category_ID = $select_category[$i];

		         $data2 = array(
					'resource_ID' => $id,
					'category_ID' => $category_ID
				);
		    	
				$this->db->insert('resources_category', $data2);
			}
		}

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function search_resources($search ){
		$this->db->select('*, resources_type.name as type_name');
    	$this->db->join('resources_type', 'resources_type.id = resources.type');
		$this->db->like('title', $search);
		$query = $this->db->get('resources');

		return $query->result_array();
	}
}