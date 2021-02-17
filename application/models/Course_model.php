<?php
	class Course_model extends CI_Model {

    public function __construct(){
        $this->load->database();
    }

    public function get_all($limit = FALSE, $row = FALSE, $id){
    	$this->db->select('
    		course_section_lesson_content.content as content_part_content,
    		course_section_lesson_content.last_updated as content_part_last_updated,
    		course_section_lesson_content.name as content_part_name,
    		course_section_lesson_content.slug as content_part_slug,
    		course_section_lesson_content.id as content_ID,
    		course_section_lesson_content.url as content_URL,
    		course_section_lesson_content.row as content_row,
    		course.slug as course_slug, 
    		course.title as course_name, 
    		course.id as course_ID, 
    		course.id as course_status, 
    		course_section_lesson.slug as lesson_slug,
    		course_section_lesson_content.slug as content_slug,
    		course_section.slug as section_slug,
    		course_section.name as section_name,
    		course_section_lesson.name as lesson_name
    	 ');
    	$this->db->join('course_section_lesson', 'course_section_lesson.id = course_section_lesson_content.lesson_ID');
    	$this->db->join('course_section', 'course_section.id = course_section_lesson.section_ID');
    	$this->db->join('course', 'course.id = course_section.course_ID');
    	$this->db->join('programs_modules', 'programs_modules.course_ID = course.id');
    	$this->db->join('users_programs', 'programs_modules.program_ID = users_programs.program_ID');
    	$this->db->join('users', 'users.id = users_programs.user_ID');
    	$this->db->where('MONTH(course_section_lesson_content.last_updated)', date('m'));
		$this->db->where('users.id', $id);
		$this->db->where('course.status', '1');
    	$this->db->order_by('course_section_lesson_content.last_updated', 'DESC');
    	if($limit !== FALSE && $row !== FALSE){
    		$this->db->limit($limit, $row);
    	}
    	

    	$query = $this->db->get('course_section_lesson_content');
		return $query->result_array();
    }

    public function search_course($slug, $search, $id){
    	$this->db->select('
    		course.slug as course_slug,
    		course.row as course_row,
    		course.title as course_title,
    		course.id as course_ID,
    		programs.slug as program_slug,
    		min(course_section.slug) as section_slug
    	');
    	$this->db->join('programs_modules', 'programs_modules.course_ID = course.id');
    	$this->db->join('programs', 'programs_modules.program_ID = programs.id');
    	$this->db->join('users_programs', 'programs_modules.program_ID = users_programs.program_ID');
    	$this->db->join('course_section', 'course.id = course_section.course_ID');
		$this->db->where('users_programs.user_ID', $id);
		if($slug != NULL){
			$this->db->where('programs.slug', $slug);
		}
		$this->db->where('course.status', '1');
		$this->db->like('course.title', $search);
    	$this->db->order_by('course.row', 'ASC');
    	$this->db->group_by('course_section.course_ID');
    	
    	$query = $this->db->get('course');
		return $query->result_array();
    }

    public function search_section($slug, $search, $id){
    	$this->db->select('
    		course.slug as course_slug,
    		course_section.name as section_name,
    		course_section.course_ID as course_ID,
    		course_section.id as section_ID,
    		course_section.slug as section_slug,
    		programs.slug as program_slug,
    	');
    	$this->db->join('course', 'course.id = course_section.course_ID');
    	$this->db->join('programs_modules', 'programs_modules.course_ID = course.id');
    	$this->db->join('programs', 'programs_modules.program_ID = programs.id');
    	$this->db->join('users_programs', 'programs_modules.program_ID = users_programs.program_ID');
    	if($slug != NULL){
			$this->db->where('programs.slug', $slug);
		}
		$this->db->where('users_programs.user_ID', $id);
		$this->db->where('course.status', '1');
		$this->db->where('course_section.status', '1');
		$this->db->like('course_section.name', $search);
    	$this->db->order_by('course.row', 'ASC');
    	$this->db->order_by('course_section.row', 'ASC');
    	
    	$query = $this->db->get('course_section');
		return $query->result_array();
    }

    public function search_lesson($slug, $search, $id){
    	$this->db->select('
    		course.slug as course_slug,
    		course_section_lesson.name as lesson_name,
    		course_section_lesson.section_ID as section_ID,
    		course_section_lesson.id as lesson_ID,
    		course_section.slug as section_slug,
    		programs.slug as program_slug
    	');
    	$this->db->join('course_section', 'course_section.id = course_section_lesson.section_ID');
    	$this->db->join('course', 'course.id = course_section.course_ID');
    	$this->db->join('programs_modules', 'programs_modules.course_ID = course.id');
    	$this->db->join('programs', 'programs_modules.program_ID = programs.id');
    	$this->db->join('users_programs', 'programs_modules.program_ID = users_programs.program_ID');
    	if($slug != NULL){
			$this->db->where('programs.slug', $slug);
		}
		$this->db->where('users_programs.user_ID', $id);
		$this->db->where('course.status', '1');
		$this->db->where('course_section.status', '1');
		$this->db->where('course_section_lesson.status', '1');
		$this->db->like('course_section_lesson.name', $search);
    	$this->db->order_by('course.row', 'ASC');
    	$this->db->order_by('course_section_lesson.row', 'ASC');
    	
    	$query = $this->db->get('course_section_lesson');
		return $query->result_array();
    }

    public function search_content($slug, $search, $id){
    	$this->db->select('
    		course.slug as course_slug,
    		course_section_lesson_content.name as content_name,
    		course_section_lesson_content.id as content_ID,
    		course_section_lesson_content.row as content_row,
    		course_section_lesson_content.lesson_ID as lesson_ID,
    		course_section.slug as section_slug,
    		programs.slug as program_slug,
    	');
    	$this->db->join('course_section_lesson', 'course_section_lesson.id = course_section_lesson_content.lesson_ID');
    	$this->db->join('course_section', 'course_section.id = course_section_lesson.section_ID');
    	$this->db->join('course', 'course.id = course_section.course_ID');
    	$this->db->join('programs_modules', 'programs_modules.course_ID = course.id');
    	$this->db->join('users_programs', 'programs_modules.program_ID = users_programs.program_ID');
    	$this->db->join('programs', 'programs_modules.program_ID = programs.id');
    	if($slug != NULL){
			$this->db->where('programs.slug', $slug);
		}
		$this->db->where('users_programs.user_ID', $id);
		$this->db->where('course.status', '1');
		$this->db->where('course_section.status', '1');
		$this->db->where('course_section_lesson.status', '1');
		$this->db->where('course_section_lesson_content.status', '1');
		$this->db->like('course_section_lesson_content.name', $search);
    	$this->db->order_by('course.row', 'ASC');
    	$this->db->order_by('course_section_lesson_content.row', 'ASC');
    	
    	$query = $this->db->get('course_section_lesson_content');
		return $query->result_array();
    }

	public function get_course($slug = FALSE){
		$this->db->select('*, course.id as courID, course.status as courstat, admin.id, admin.first_name, admin.last_name');
		$this->db->join('admin', 'admin.id = course.updated_by');
		$this->db->order_by('course.row', 'ASC');
		if($slug === FALSE){

			$query = $this->db->get('course');;
			return $query->result_array();
		}

		$query = $this->db->get_where('course', array('slug' => $slug));

		return $query->row_array();
	}

	public function sort_course($id, $row){
		$this->db->set('row', $row);
		$this->db->where('title', $id);

		$this->db->cache_delete('home', 'index');
		$this->db->cache_delete('default', 'index');
		$this->db->cache_delete('courses', 'get_section');
		$this->db->cache_delete('admin', 'modules');
		
		return $this->db->update('course');
	}

	public function sort_course_2($id, $row){
		$this->db->trans_begin();
		$this->db->set('row', $row);
		$this->db->where('id', $id);
		$this->db->update('course');

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}		
	}


	public function get_course_content($slug){
		$query = $this->db->get_where('course', array('slug' => $slug));
		return $query->row_array();
	}

	public function get_course_id($id){
		$query = $this->db->get_where('course', array('id' => $id));
		return $query->row_array();
	}

	public function create_course($courseName){
		$query = $this->db->count_all('course');
		$last = $query + 1;
		$slug = url_title($courseName);
		$data = array(
			'title' => $courseName,
			'slug' => strtolower($slug),
			'updated_by' => $this->session->userdata('admin_id'),
			'row' => $last
		);

		return $this->db->insert('course', $data);
	}

	public function update_course_title($id, $updateTitle, $status){
		$this->db->trans_begin();
		$slug = url_title($updateTitle);
		$data = array(
			'title' => $updateTitle,
			'slug' => strtolower($slug),
			'status' => $status,
			'updated_by' => $this->session->userdata('admin_id')
		);
		$this->db->where('id', $id);
		$this->db->update('course', $data);
		$this->db->cache_delete('home', 'index');
		$this->db->cache_delete('default', 'index');
		$this->db->cache_delete('courses', 'get_section');
		$this->db->cache_delete('admin', 'modules');

		$this->course_status($id, $status);

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function get_section($id = FALSE){
		if($id === FALSE){
			$this->db->order_by('row', 'ASC');

			$query = $this->db->get('course_section');
			
			return $query->result_array();
		}
		$this->db->order_by('row', 'ASC');
		$query = $this->db->get_where('course_section', array('course_id' => $id));

		return $query->result_array();
	}

	public function get_section_by_slug($slug){
		$this->db->where('slug', $slug);
		$query = $this->db->get('course_section');

		return $query->row_array();
	}

	public function get_section_content($id){
		$this->db->where('id', $id);
		$query = $this->db->get('course_section');

		return $query->row_array();
	}

	public function create_section($section, $course_id, $course_slug){
		$this->db->trans_begin();
		$this->db->from('course_section');
		$query = $this->db->count_all_results(); 
		$last = $query + 1;
		$slug = url_title($section);
		$data = array(
			'course_ID' => $course_id,
			'name' => $section,
			'slug' => strtolower($slug),
			'row' => $last,
			'updated_by' => $this->session->userdata('admin_id')
		);
		$this->db->insert('course_section', $data);
		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function update_section($name, $sec_id, $course_slug, $status){
		$this->db->trans_begin();
		$slug = url_title($name);
		$data = array(
			'name' => $name,
			'slug' => strtolower($slug),
			'status' => $status,
			'updated_by' => $this->session->userdata('admin_id')
		);
		$this->db->where('id', $sec_id);
		$this->db->update('course_section', $data);
		$this->section_status($sec_id, $status);
		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function delete_section($section_ID, $course_slug){
		$this->db->delete('course_section', array('id' => $section_ID));
		$this->delete_lesson($section_ID, FALSE, $course_slug);
	}

	public function sort_section($id, $row){
		$this->db->trans_begin();
		$this->db->set('row', $row);
		$this->db->where('id', $id);
		$this->db->update('course_section');


		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}		
	}

	public function get_lesson($section_ID = FALSE){
		if($section_ID === FALSE){
			$this->db->order_by('row', 'ASC');

			$query = $this->db->get('course_section_lesson');
			return $query->result_array();
		}
		$this->db->order_by('row', 'ASC');
		$query = $this->db->get_where('course_section_lesson', array('section_ID' => $section_ID));
		return $query->result_array();
	}

	public function get_lesson_content($id){
		$this->db->where('id', $id);
		$this->db->or_where('slug', $id);
		$query = $this->db->get('course_section_lesson');
		return $query->row_array();
	}

	public function create_lesson($section_ID, $lesson, $course_slug){
		$this->db->trans_begin();
		$slug = url_title($lesson);
		$query = $this->db->count_all('course_section_lesson');
		$last = $query + 1;
		$data = array(
			'section_ID' => $section_ID,
			'name' => $lesson,
			'slug' => strtolower($slug),
			'row' => $last,
			'updated_by' => $this->session->userdata('admin_id')
		);
		$this->db->insert('course_section_lesson', $data);
		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function update_lesson($name, $les_id, $course_slug, $status){
		$this->db->trans_begin();
		$slug = url_title($name);
		$data = array(
			'name' => $name,
			'slug' => strtolower($slug),
			'status' => $status,
			'updated_by' => $this->session->userdata('admin_id')
		);
		$this->db->where('id', $les_id);
		$this->db->update('course_section_lesson', $data);
		$this->lesson_status($les_id, $status);

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function delete_lesson($section_ID = NULL, $lesson_ID = NULL, $course_slug){
		if($section_ID != NULL and $lesson_ID == NULL){
			$query1 = $this->db->query("SELECT * FROM course_section_lesson where `section_ID` = '$section_ID'");
	        foreach ($query1->result_array() as $row){
		        $lesson = $row['id'];
				$this->delete_content($lesson, NULL, $course_slug);
			}
			$this->db->delete('course_section_lesson', array('section_ID' => $section_ID));
		}

		if($lesson_ID != NULL and $section_ID == NULL){	
			$this->db->delete('course_section_lesson', array('id' => $lesson_ID));
			$this->delete_content($lesson_ID, NULL, $course_slug);
		}
	}

	public function sort_lesson($id, $row){
		$this->db->trans_begin();
		$this->db->set('row', $row);
		$this->db->where('id', $id);
		$this->db->update('course_section_lesson');
		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}		
	}

	public function get_content($lesson_ID = FALSE){
		if($lesson_ID === FALSE){
			$this->db->order_by('row', 'ASC');

			$query = $this->db->get('course_section_lesson_content');
			return $query->result_array();
		}

		$this->db->order_by('row', 'ASC');
		$query = $this->db->get_where('course_section_lesson_content', array('lesson_ID' => $lesson_ID));

		return $query->result_array();
	}

	public function get_content_2(){
		$this->db->select('
    		course_section_lesson_content.content as content_part_content,
    		course_section_lesson_content.last_updated as content_part_last_updated,
    		course_section_lesson_content.name as content_part_name,
    		course_section_lesson_content.slug as content_part_slug,
    		course_section_lesson_content.url as content_part_url,
    		course_section_lesson_content.thumbnail as content_part_thumbnail,
    		course_section_lesson_content.id as content_ID,
    		course.slug as course_slug, 
    		course.title as course_name, 
    		course.id as course_ID, 
    		course.id as course_status, 
    		course_section_lesson.slug as lesson_slug,
    		course_section_lesson_content.slug as content_slug,
    		course_section.slug as section_slug,
    		course_section.name as section_name,
    		course_section_lesson.name as lesson_name
    	 ');
    	$this->db->join('course_section_lesson', 'course_section_lesson.id = course_section_lesson_content.lesson_ID');
    	$this->db->join('course_section', 'course_section.id = course_section_lesson.section_ID');
    	$this->db->join('course', 'course.id = course_section.course_ID');
    	$this->db->order_by('course_section_lesson_content.last_updated', 'DESC');

		$query = $this->db->get('course_section_lesson_content');
		return $query->result_array();
	}

	public function get_content_content($id){
		$query = $this->db->get_where('course_section_lesson_content', array('id' => $id));

		return $query->row_array();
	}

	public function create_content($lesson_ID, $name, $content_url, $content, $course_slug){
		$this->db->trans_begin();
		$slug = url_title($name);

		$query = $this->db->count_all('course_section_lesson_content');
		$last = $query + 1;

		$data = array(
			'lesson_ID' => $lesson_ID,
			'name' => $name,
			'slug' => strtolower($slug),
			'url' => strtolower($content_url),
			'content' => $content,
			'row' => $last,
			'updated_by' => $this->session->userdata('admin_id')
		);
		$this->db->insert('course_section_lesson_content', $data);

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}
	
	public function delete_content($lesson_ID = NULL, $ID = NULL, $course_slug){
		if($lesson_ID == NULL and $ID != NULL){	
			$this->db->delete('course_section_lesson_content', array('id' => $ID));
		
		} else {
			$this->db->delete('course_section_lesson_content', array('lesson_ID' => $lesson_ID));
		}
	}

	public function update_content($content_ID, $name, $url, $thumbnail, $content, $course_slug, $status){
		$this->db->trans_begin();
		$slug = url_title($name);

		$data = array(
			'id' => $content_ID,
			'name' => $name,
			'slug' => strtolower($slug),
			'url' => $url,
			'thumbnail' => $thumbnail,
			'content' => $content,
			'status' => $status,
			'updated_by' => $this->session->userdata('admin_id')
		);
		
		$this->db->set('last_updated', 'NOW()', FALSE);
		$this->db->where('id', $content_ID);
		$this->db->update('course_section_lesson_content', $data);
		
		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function update_content_by_id($content_ID, $name, $url, $thumbnail, $content){
		$this->db->trans_begin();
		$slug = url_title($name);

		$data = array(
			'id' => $content_ID,
			'name' => $name,
			'slug' => strtolower($slug),
			'url' => $url,
			'thumbnail' => $thumbnail,
			'content' => $content,
			'updated_by' => $this->session->userdata('admin_id')
		);
		
		$this->db->set('last_updated', 'NOW()', FALSE);
		$this->db->where('id', $content_ID);
		$this->db->update('course_section_lesson_content', $data);

		$this->db->cache_delete('admin', 'contents');
		$this->db->cache_delete('home', 'index');
		$this->db->cache_delete('default', 'index');
		$this->db->cache_delete('courses', 'get_section');
		$this->db->cache_delete('admin', 'modules');
		$this->db->cache_delete('modules', 'index');
		$this->db->cache_delete('courses', 'get_section_2');
		$this->db->cache_delete('courses', 'get_lesson_by_id');
		$this->db->cache_delete('courses', 'get_content_by_id');
		
		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function sort_content($id, $row){
		$this->db->trans_begin();
		$this->db->set('row', $row);
		$this->db->where('id', $id);
		$this->db->update('course_section_lesson_content');
		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}		
	}

	public function count_course($slug, $section_slug, $id){
		$this->db->select('count(course.id) as course, count(course_section.id) as section, count(course_section_lesson.id) as lesson, count(course_section_lesson_content.id) as content');
    	$this->db->join('course_section', 'course_section.course_ID = course.id', 'left');
    	$this->db->join('course_section_lesson', 'course_section_lesson.section_ID = course_section.id', 'left');
    	$this->db->join('course_section_lesson_content', 'course_section_lesson_content.lesson_ID = course_section_lesson.id', 'left');
    	$this->db->join('programs_modules', 'programs_modules.course_ID = course.id');
    	$this->db->join('users_programs', 'programs_modules.program_ID = users_programs.program_ID');
		$this->db->where('users_programs.user_ID', $id);
		$this->db->where('course_section_lesson_content.status', '1');
		$this->db->where('course_section_lesson_content.url IS NOT NULL');
		if($slug != NULL){
    		$this->db->where('course.slug', $slug);
    	}

    	if($section_slug != NULL){
    		$this->db->where('course_section.slug', $section_slug);
    	}
    	$query = $this->db->get('course');
    	return $query->row_array();
	}

	public function next_module($slug, $section_slug, $id){
		$this->db->select('
    		course_section.slug as section_slug,
	    	course.slug as course_slug
    	');
    	$this->db->join('course', 'course.id = course_section.course_ID', 'left');
		$where2 = "course_section.row > (SELECT row FROM course_section WHERE slug = '$section_slug')";
		$this->db->where($where2);
		$this->db->where('course.slug', $slug);
    	$this->db->order_by('course_section.row', 'ASC');
    	$this->db->limit(1);
    	$query = $this->db->get('course_section');

    	$sql = $query->row();

    	if($sql == NULL){
	    	$this->db->select('
	    		course_section.slug as section_slug,
	    		course.slug as course_slug
	    	');
	    	$this->db->join('course', 'course.id = course_section.course_ID', 'left');
	    	$this->db->join('programs_modules', 'programs_modules.course_ID = course.id');
	    	$this->db->join('users_programs', 'programs_modules.program_ID = users_programs.program_ID');
			$where = "course.row = (SELECT row+1 FROM course WHERE slug = '$slug')";
			$this->db->where($where);
			$this->db->where('users_programs.user_ID', $id);
	    	$this->db->order_by('course_section.row', 'ASC');
	    	$this->db->limit(1);
	    	
    		$query2 = $this->db->get('course_section');
    		return $query2->row_array();
    	} else {
    		return $query->row_array();
    	}
	}

	public function course_status($id, $status){
		$this->db->trans_begin();
		$this->db->set('status', $status);
		$this->db->where('course_ID', $id);
		$this->db->update('course_section');

		foreach ($this->get_section($id) as $row){
			$this->section_status($row['id'], $status);
		}

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function section_status($id, $status){
		$this->db->trans_begin();
		$this->db->set('status', $status);
		$this->db->where('section_ID', $id);
		$this->db->update('course_section_lesson');

		foreach ($this->get_lesson($id) as $row){
			$this->lesson_status($row['id'], $status);
		}

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function lesson_status($id, $status){
		$this->db->trans_begin();
		$this->db->set('status', $status);
		$this->db->where('lesson_ID', $id);
		$this->db->update('course_section_lesson_content');

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}
}