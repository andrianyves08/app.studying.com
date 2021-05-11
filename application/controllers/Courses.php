<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Courses extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->library('upload');
	}

	function check_session(){
		if(!$this->session->userdata('admin_logged_in')){
			redirect('admin/login');
		}
	}

	public function index() {
		$this->check_session();
		$page = 'course';
		$data['title'] = ucfirst($page);
		$data['first_name'] = $this->session->userdata('admin_firstname');
		$data['last_name'] = $this->session->userdata('admin_lastname');
		$data['admin_id'] = $this->session->userdata('admin_id');
		$data['admin_status'] = $this->session->userdata('admin_position');
		$data['settings'] = $this->settings_model->get_settings();
		$data['courses'] = $this->course_model->get_course();

		$this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/nav', $data);
		$this->load->view('admin/'.$page, $data);
        $this->load->view('templates/admin/footer');
		$this->load->view('templates/admin/scripts');
	}

	public function create_course($slug){
		$this->check_session();
		$page = 'course';
		$data['title'] = ucfirst($page);
		$data['first_name'] = $this->session->userdata('admin_firstname');
		$data['last_name'] = $this->session->userdata('admin_lastname');
		$data['admin_id'] = $this->session->userdata('admin_id');
		$data['admin_status'] = $this->session->userdata('admin_position');
		$data['settings'] = $this->settings_model->get_settings();
		$data['course'] = $this->course_model->get_course_content($slug);
		$data['sections'] = $this->course_model->get_section($data['course']['id']);
		$data['lessons'] = $this->course_model->get_lesson();
		$data['contents'] = $this->course_model->get_content();

		$this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/nav', $data);
		$this->load->view('admin/course-create', $data);
		$this->load->view('templates/admin/footer');
		$this->load->view('templates/admin/scripts');
	}

	public function all_contents() {
		$this->check_session();
		$page = 'course';
		$data['title'] = ucfirst($page);
		$data['first_name'] = $this->session->userdata('admin_firstname');
		$data['last_name'] = $this->session->userdata('admin_lastname');
		$data['admin_id'] = $this->session->userdata('admin_id');
		$data['admin_status'] = $this->session->userdata('admin_position');
		$data['settings'] = $this->settings_model->get_settings();
		$data['contents'] = $this->course_model->get_content_2();

		$this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/nav', $data);
		$this->load->view('admin/contents', $data);
        $this->load->view('templates/admin/footer');
		$this->load->view('templates/admin/scripts');
	}

	function sort_course(){
		$create = $this->course_model->sort_course($this->input->post('where'), $this->input->post('row'));

		echo json_encode($create);
	}

	function sort_course_2(){
		$id = $this->input->post('post_order_ids');
		for($count = 0;  $count < count($id); $count++){
			$row = $count+1;
			$name = $this->input->post('post_order_ids')[$count];
			$create = $this->course_model->sort_course_2($name, $row);
		}
		echo json_encode($create);
	}

	function get_course(){
		$data = $this->course_model->get_course_id($this->input->post('courID',TRUE));
		echo json_encode($data);
	}

	function create_title() {

		$this->course_model->create_course($this->input->post('courseName'));
		$slug = url_title($this->input->post('courseName'));
		redirect('admin/modules/'.$slug);
	}

	function update_course($id) {
		if(empty($this->input->post('editstatus', TRUE))){
			$status = '0';
		} else {
			$status = $this->input->post('editstatus', TRUE);
		}
		$data = $this->course_model->update_course_title($id, $this->input->post('edittitle'), $status);
		if($data){

			$this->session->set_flashdata('success', 'Module updated Successfully');
		}
		redirect('admin/modules');
	}

	function create_section($slug) {
		$this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('section_name', 'Section name', 'required', array('required' => 'Section name is required.'));

        if ($this->form_validation->run() === FALSE) {
        	$this->session->set_flashdata('multi',validation_errors());
			redirect('admin/modules/'.$slug);
	    } else {
			$data = $this->course_model->create_section($this->input->post('section_name'), $this->input->post('cor_id'), $slug);

			if($data){
	
				$this->session->set_flashdata('success', 'Section Created Successfully');
			} else {
				$this->session->set_flashdata('error', 'Section name already exist.');
			}
			redirect('admin/modules/'.$slug);
	    }
	}

	function get_section(){
		$data['course'] = $this->course_model->get_course_content($this->input->post('slug'));
		$data = $this->course_model->get_section($data['course']['id']);
		echo json_encode($data);
	}

	function get_section_2(){
		$data = $this->course_model->get_section_content($this->input->post('id'));
		echo json_encode($data);
	}

	function update_section() {
        $this->form_validation->set_rules('update_sec_name', 'Section name', 'required');
        if ($this->form_validation->run() === FALSE) {
			$data = array(
				'error' => true,
				'message' => validation_errors()
			);
			$this->session->set_flashdata('multi',validation_errors());
	        echo json_encode($data);
	    } else {
	  
			$create = $this->course_model->update_section($this->input->post('update_sec_name'), $this->input->post('update_sec_id'), $this->input->post('course_slug'), $this->input->post('status'));
			if(!$create){
				$data = array(
				'error' => true,
				'message' => 'Section name already exist.'
				);
			} else {
				$data = array(
				'success' => true
				);
			}
			echo json_encode($data);
	    }
	}

	function delete_section() {
		$data = $this->course_model->delete_section($this->input->post('id'), $this->input->post('course_slug'));
		echo json_encode($data);
	}

	function sort_section(){
		$id = $this->input->post('sec_order_id');
		for($count = 0;  $count < count($id); $count++){
			$row = $count+1;
			$name = $this->input->post('sec_order_id')[$count];
			$create = $this->course_model->sort_section($name, $row);
		}
		echo json_encode($create);
	}

	
	function get_lesson(){
		$data = $this->course_model->get_lesson($this->input->post('section_id',TRUE));
		echo json_encode($data);
	}

	function get_lesson_by_id($id){
		$data = $this->course_model->get_lesson_content($id);
		echo json_encode($data);
	}

	function create_lesson($slug) {
        $this->form_validation->set_rules('secID', 'Section', 'required', array('required' => 'Select section for this lesson'));
        $this->form_validation->set_rules('lesson_name', 'Lesson name', 'required');

        if ($this->form_validation->run() === FALSE) {
			$this->session->set_flashdata('multi',validation_errors());
	        redirect('admin/modules/'.$slug);
	    } else {
			$create = $this->course_model->create_lesson($this->input->post('secID'), $this->input->post('lesson_name'), $slug);
			if($create){
	
				$this->session->set_flashdata('success', 'Lesson Created Successfully');
			} else {
				$this->session->set_flashdata('error', 'Lesson name already exist');
			}
			redirect('admin/modules/'.$slug);
	    }
	}

	function update_lesson() {
		$this->form_validation->set_rules('update_les_name', 'Section name', 'required');
        if ($this->form_validation->run() === FALSE) {
			$data = array(
				'error' => true,
				'message' => validation_errors()
			);
	        echo json_encode($data);
	    } else {
			$create = $this->course_model->update_lesson($this->input->post('update_les_name'), $this->input->post('update_les_id'), $this->input->post('course_slug'), $this->input->post('status'));
			if(!$create){
				$data = array(
				'error' => true,
				'message' => 'Lesson name already exist.'
				);
			} else {
	
				$data = array(
				'success' => true
				);
			}
			echo json_encode($data);
	    }
	}

	function delete_lesson() {
		$data = $this->course_model->delete_lesson(NULL,$this->input->post('id'), $this->input->post('course_slug'));
		echo json_encode($data);
	}

	function sort_lesson(){
		$id = $this->input->post('les_order_id');
		for($count = 0;  $count < count($id); $count++){
			$row = $count+1;
			$name = $this->input->post('les_order_id')[$count];
			$create = $this->course_model->sort_lesson($name, $row);
		}
		echo json_encode($create);
	}

	function get_content_by_id($id){
		$data = $this->course_model->get_content_content($id);
		echo json_encode($data);
	}

	function create_content($slug, $lesson_ID = FALSE) {
		$this->form_validation->set_error_delimiters('<script type="text/javascript">$(function(){toastr.error("', '")});</script>');
		if(empty($lesson_ID)){
			$this->form_validation->set_rules('select_lesson', 'Select lesson for this content', 'required');
			$lesson_ID = $this->input->post('select_lesson');
		}
        if ($this->form_validation->run() === FALSE) {
			$this->session->set_flashdata('multi',validation_errors());
	        redirect('admin/modules/'.$slug);
	    } else {
			for($i=0; $i<count($this->input->post('contentitle')); $i++) {
		    	if(trim($this->input->post('contentitle')[$i] != '')) {
		    		if(empty($this->input->post('content_url')[$i])){
		    			$content_url = NULL;
		    		} else {
		    			$content_url = $this->input->post('content_url')[$i];
		    		}
			        $create = $this->course_model->create_content($lesson_ID, $this->input->post('contentitle')[$i], $content_url, $this->input->post('content')[$i], $slug);
					if($create){
			
						$this->session->set_flashdata('success', 'Content created successfully');
					} else {
						$this->session->set_flashdata('error', 'Content Title already Exist.');
					}
				}
			}
			redirect('admin/modules/'.$slug);
	    }
	}

	function sort_content(){
		$id = $this->input->post('con_order_id');
		for($count = 0;  $count < count($id); $count++){
			$row = $count+1;
			$name = $this->input->post('con_order_id')[$count];

			$create = $this->course_model->sort_content($name, $row);
		}
		echo json_encode($create);
	}


	function delete_content() {
		$data = $this->course_model->delete_content(NULL, $this->input->post('id'), $this->input->post('course_slug'));
		echo json_encode($data);
	}

	function update_content() {
		$this->form_validation->set_rules('update_con_name', 'Content title', 'required');
        if ($this->form_validation->run() === FALSE) {
			$data = array(
				'error' => true,
				'message' => validation_errors()
			);
	        echo json_encode($data);
	    } else {
		    if(!empty($_FILES["update_con_thumbnail"]["name"])){
		    	$background_image = $_FILES['update_con_thumbnail']['name'];
		    	$thumbnail = $this->input->post('update_con_id').".".pathinfo($background_image, PATHINFO_EXTENSION); 
	    		$config['file_name'] = $thumbnail;
				$config['upload_path'] = './assets/img/contents/';
				$config['allowed_types'] = 'jpg|jpeg|png|gif';
				$config['max_size']      = 1024;
				$this->upload->initialize($config);
				unlink('./assets/img/contents/'.$thumbnail); 
				if(!$this->upload->do_upload('update_con_thumbnail')){
					$this->session->set_flashdata('error',$this->upload->display_errors());
				} else {
					$data = array('upload_data' => $this->upload->data());
					$source_path = './assets/img/contents/'.$thumbnail;
					$target_path = './assets/img/contents/'.$thumbnail;
					$config_manip = array(
					  'image_library' => 'gd2',
					  'source_image' => $source_path,
					  'new_image' => $target_path,
					  'maintain_ratio' => TRUE,
					  'width' => 500,
					  'quality' => '60%',
					);

					$this->load->library('image_lib', $config_manip);
					$this->image_lib->resize();
					$this->image_lib->clear();
				}
			} else {
				$thumbnail = $this->input->post('update_con_thumbnail_orig');
			}

			if(empty($this->input->post('update_con_url'))){
    			$content_url = NULL;
    		} else {
    			$content_url = $this->input->post('update_con_url');
    		}

			$create = $this->course_model->update_content($this->input->post('update_con_id'), $this->input->post('update_con_name'), $content_url, $thumbnail, $this->input->post('update_cont_part'), $this->input->post('course_slug'), $this->input->post('content_status'));

			if($create){
	
				$this->session->set_flashdata('success', 'Content updated successfully');
			} else {
				$this->session->set_flashdata('error', 'Content Title already Exist.');
			}

			redirect('admin/modules/'.$this->input->post('course_slug'));
	    }
	}

	function update_content_by_id() {
		$this->form_validation->set_rules('update_con_name', 'Content title', 'required');
		
        if ($this->form_validation->run() === FALSE) {
			redirect('admin/contents');
	    } else {
		    if(!empty($_FILES["update_con_thumbnail"]["name"])){
		    	$background_image = $_FILES['update_con_thumbnail']['name'];
		    	$thumbnail = $this->input->post('update_con_id').".".pathinfo($background_image, PATHINFO_EXTENSION); 
	    		$config['file_name'] = $thumbnail;
				$config['upload_path'] = './assets/img/contents/';
				$config['allowed_types'] = 'jpg|jpeg|png|gif';
				$config['max_size']      = 1024;
				$this->upload->initialize($config);
				unlink('./assets/img/contents/'.$thumbnail); 
				if(!$this->upload->do_upload('update_con_thumbnail')){
					$this->session->set_flashdata('error',$this->upload->display_errors());
				} else {
					$data = array('upload_data' => $this->upload->data());
					$source_path = './assets/img/contents/'.$thumbnail;
					$target_path = './assets/img/contents/'.$thumbnail;
					$config_manip = array(
					  'image_library' => 'gd2',
					  'source_image' => $source_path,
					  'new_image' => $target_path,
					  'maintain_ratio' => TRUE,
					  'width' => 500,
					  'quality' => '60%',
					);

					$this->load->library('image_lib', $config_manip);
					$this->image_lib->resize();
					$this->image_lib->clear();
				}
			} else {
				$thumbnail = $this->input->post('update_con_thumbnail_orig');
			}
			$create = $this->course_model->update_content_by_id($this->input->post('update_con_id'), $this->input->post('update_con_name'), $this->input->post('update_con_url'), $thumbnail, $this->input->post('update_cont_part'));

			if($create){
	
				$this->session->set_flashdata('success', 'Content updated successfully');
			} else {
				$this->session->set_flashdata('error', 'Content Title already Exist.');
			}
			redirect('admin/contents');
	    }
	}

	function get_content_part(){
		$data = $this->course_model->get_content_part_by_id($this->input->post('id'));
		echo json_encode($data);
	}

	//Upload image summernote
	function upload_image(){
		if(isset($_FILES["image"]["name"])){
			$config['upload_path'] = './assets/img/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif';
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('image')){
				$this->upload->display_errors();
				return FALSE;
			}else{
				$data = $this->upload->data();
		        $config['image_library']='gd2';
		        $config['source_image']='./assets/img/'.$data['file_name'];
		        $config['create_thumb']= FALSE;
	            $config['maintain_ratio']= TRUE;
	            $config['new_image']= './assets/img/'.$data['file_name'];
	            $this->load->library('image_lib', $config);
	            $this->image_lib->resize();
				echo base_url().'assets/img/'.$data['file_name'];
			}
		}
	}

	function submit_rating(){
		$data = $this->course_model->submit_rating($this->input->post('content_ID'), $this->input->post('rating'), $this->input->post('feedback'), $this->session->userdata('user_id'));

		echo json_encode($data);
	}

	function get_content_ratings(){
		$data = $this->course_model->get_content_ratings();
		$total = array();

		foreach ($data as $row) {
			$average = ($row['sum'] / $row['total']);
			
			$total[] = [
				'content_ID' => $row['content_ID'],
				'average' => (round($average * 2) / 2)
			];
		}

		echo json_encode($total);
	}
}