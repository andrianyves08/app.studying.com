
<?php
	class Programs_model extends CI_Model {

    public function __construct(){
        $this->load->database();
    }

    public function user_purchase($slug, $user_ID){
		$this->db->select('course.title as title, course.slug as course_slug, course.id as course_ID, course.row as row, min(course_section.slug) as section_slug, programs.slug as slug');
		$this->db->join('programs_modules', 'programs_modules.program_ID = users_programs.program_ID');
		$this->db->join('programs', 'programs.id = programs_modules.program_ID');
		$this->db->join('course', 'course.id = programs_modules.course_ID');
		$this->db->join('course_section', 'course_section.course_ID = course.id');
		$this->db->where('programs.slug', $slug);
		$this->db->where('users_programs.user_ID', $user_ID);
		$this->db->where('course.status', '1');
		$this->db->order_by('course.row', 'ASC');
		$this->db->order_by('course_section.row', 'ASC');
		$this->db->group_by('course_section.course_ID');
		$query = $this->db->get('users_programs');
		return $query->result_array();
	}


	public function user_purchase_by_section($slug, $user_ID){
		$this->db->select('course_section.name as section_name, 
			course.slug as course_slug, 
			course.id as course_ID, 
			course_section.slug as section_slug, 
			course.row as row,
			programs.slug as slug,
			course_section.slug as section_slug,
			course_section.id as section_ID
			');
		$this->db->join('programs', 'programs.id = users_programs.program_ID');
		$this->db->join('programs_modules', 'programs_modules.program_ID = programs.id');
		$this->db->join('course', 'course.id = programs_modules.course_ID');
		$this->db->join('course_section', 'course.id = course_section.course_ID');
		$this->db->where('users_programs.user_ID', $user_ID);
		$this->db->where('programs.slug', $slug);
		$this->db->where('course.status', '1');
		$this->db->where('course_section.status', '1');
		$this->db->order_by('course_section.row', 'ASC');
		$this->db->group_by('course_section.id');
		$query = $this->db->get('users_programs');
		return $query->result_array();
	}

	public function my_purchases_by_section($slug, $user_ID, $course_slug){
		$this->db->select('course_section.name as section_name, 
			course.slug as course_slug, 
			course.id as course_ID, 
			course_section.slug as section_slug, 
			course.row as row,
			programs.slug as slug,
			course_section.slug as section_slug,
			course_section.id as section_ID
			');
		$this->db->join('programs', 'programs.id = users_programs.program_ID');
		$this->db->join('programs_modules', 'programs_modules.program_ID = programs.id');
		$this->db->join('course', 'course.id = programs_modules.course_ID');
		$this->db->join('course_section', 'course.id = course_section.course_ID');
		$this->db->where('users_programs.user_ID', $user_ID);
		$this->db->where('programs.slug', $slug);
		$this->db->where('course.slug', $course_slug);
		$this->db->where('course.status', '1');
		$this->db->where('course_section.status', '1');
		$this->db->order_by('course_section.row', 'ASC');
		$this->db->group_by('course_section.id');
		$query = $this->db->get('users_programs');
		return $query->result_array();
	}

	public function get_user_programs($id){
		$this->db->select('programs.slug as slug, programs.name as name');
		$this->db->join('programs', 'programs.id = users_programs.program_ID');
		$this->db->where('users_programs.user_ID', $id);
		$query = $this->db->get('users_programs');
		return $query->result_array();
	}

	public function get_user_purchases($id = FALSE){
		$this->db->select('*, programs.slug as slug, programs.name as name');
		$this->db->join('programs', 'programs.id = users_programs.program_ID');
		$this->db->join('programs_modules', 'programs_modules.program_ID = programs.id');
		if($id !== FALSE){
			$this->db->where('programs_modules.course_ID', $id);
			$this->db->where('users_programs.user_ID', $this->session->userdata('user_id'));
			$query = $this->db->get('users_programs');
			return $query->row_array();
		}
		$this->db->where('users_programs.user_ID', $this->session->userdata('user_id'));
		$query = $this->db->get('users_programs');
		return $query->result_array();
	}

	public function get_programs($id = FALSE){
		$this->db->select('*');
		if($id === FALSE){
			$query = $this->db->get('programs');
			return $query->result_array();
		}
		$this->db->where('id', $id);
		$this->db->order_by('name', 'ASC');
		$query = $this->db->get('programs');
		return $query->row_array();
	}

	public function update_program($id, $name, $price){
		$slug = url_title($name);

		$data = array(
			'name' => $name,
			'slug' => strtolower($slug),
			'price' => $price
		);
		$this->db->where('id', $id);
		return $this->db->update('programs', $data);
	}

	public function create_program($name){
		$slug = url_title($name);

		$data = array(
			'name' => $name,
			'slug' => strtolower($slug),
		);
		return $this->db->insert('programs', $data);
	}

	public function delete_module($module_ID){
		$this->db->delete('programs_modules', array('id' => $module_ID));
	}

    public function get_modules($id){
    	$query = $this->db->query("select *, course.id as course_ID from course left join (select * from programs_modules where program_ID = '$id') programs_modules on programs_modules.course_ID = course.id where programs_modules.course_ID is NULL");
		return $query->result_array();
	}
	
	public function get_programs_modules($id = FALSE){
		$this->db->select('*, programs_modules.id as programs_modules_id, course.id as course_ID');
    	$this->db->join('course', 'course.id = programs_modules.course_ID');
    	$this->db->order_by('course.row', 'ASC');
		if($id === FALSE){
			$query = $this->db->get('programs_modules');
			return $query->result_array();
		}
		$query = $this->db->get_where('programs_modules', array('program_ID' => $id));
		return $query->result_array();
	}

	public function add_modules($program_ID, $modules){
		$this->db->trans_begin();
		$total_content = count($this->input->post('modules'));
		for($i=0; $i<$total_content; $i++) {
			if(trim($this->input->post('modules')[$i] != '')) {
		        $course_ID = $modules[$i];
		        $data = array(
					'program_ID' => $program_ID,
					'course_ID' => $course_ID
				);
				$this->db->insert('programs_modules', $data);
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

	public function add_image($image, $product_ID){
		$this->db->trans_begin();

        $data = array(
        	'product_ID' => $product_ID,
			'image' => $image
		);
		$this->db->insert('products_images', $data);

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}
}