<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Resources extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('upload');
	}

	function check_session(){
		if(!$this->session->userdata('admin_logged_in')){
			redirect('admin/login');
		}
	}

	public function index()	{
		$this->check_session();
		$page = 'resources';
		$data['title'] = ucfirst($page);
		$data['first_name'] = $this->session->userdata('admin_firstname');
		$data['last_name'] = $this->session->userdata('admin_lastname');
		$data['admin_id'] = $this->session->userdata('admin_id');
		$data['admin_status'] = $this->session->userdata('admin_position');
		$data['settings'] = $this->settings_model->get_settings();
		$data['resources'] = $this->resources_model->get_all_resources();
		$data['categories'] = $this->resources_model->get_resources_categories();

		$this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/nav', $data);
		$this->load->view('admin/'.$page, $data);
		$this->load->view('templates/admin/footer');
        $this->load->view('templates/admin/scripts');
	}

	public function create_resource(){
		$this->check_session();
		$page = 'resources';
		$data['title'] = ucfirst($page);
		$data['first_name'] = $this->session->userdata('admin_firstname');
		$data['last_name'] = $this->session->userdata('admin_lastname');
		$data['admin_id'] = $this->session->userdata('admin_id');
		$data['admin_status'] = $this->session->userdata('admin_position');
		$data['settings'] = $this->settings_model->get_settings();
		$data['categories'] = $this->resources_model->get_categories();

		$this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/nav', $data);
		$this->load->view('admin/resources-create', $data);
		$this->load->view('templates/admin/footer');
		$this->load->view('templates/admin/scripts');
	}

	public function edit_resource($id){
		$this->check_session();
		$page = 'resources';
		$data['title'] = ucfirst($page);
		$data['first_name'] = $this->session->userdata('admin_firstname');
		$data['last_name'] = $this->session->userdata('admin_lastname');
		$data['admin_id'] = $this->session->userdata('admin_id');
		$data['admin_status'] = $this->session->userdata('admin_position');
		$data['settings'] = $this->settings_model->get_settings();
		$data['resource'] = $this->resources_model->get_all_resources($id);
		$data['resource_categories'] = $this->resources_model->get_resources_categories($id);
		$data['all_categories'] = $this->resources_model->get_categories();

		$data['files'] = $this->resources_model->get_files($id);

		$this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/nav', $data);
		$this->load->view('admin/resources-edit', $data);
		$this->load->view('templates/admin/footer');
		$this->load->view('templates/admin/scripts');
	}

	public function create_content() {
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('title', 'title', 'required');
		$this->form_validation->set_rules('type', 'type', 'required');
		$this->form_validation->set_rules('meta_description', 'description', 'required');
		$this->form_validation->set_rules('meta_keywords', 'keywords', 'required');
		$this->form_validation->set_rules('content', 'content', 'required');
        
        if ($this->form_validation->run() === FALSE) {
			$this->session->set_flashdata('multi',validation_errors());
	        redirect('admin/resources/create');
	    } else {
			if(empty($_FILES["banner"]["name"])){
				$banner = 'blogs_banner.png';
			} else {
				$banner = $_FILES['banner']['name'];
				$config['file_name'] = $banner;
				$config['upload_path'] = './assets/img/blogs';
				$config['allowed_types'] = 'gif|jpg|png';
				$this->upload->initialize($config);
				$this->upload->overwrite = true;
				if(!$this->upload->do_upload('banner')){
					$error = array('error' => $this->upload->display_errors());
					$this->session->set_flashdata('error',$error['error']);
				} else {
					$data = array('upload_data' => $this->upload->data());
				}
			}

			$uploads = NULL;
		    if (isset($_FILES['resource_file'])) {
		        $files = $_FILES;
		        $count = count($_FILES ['resource_file'] ['name']);
				$uploads = $_FILES['resource_file']['name'];

		        for ($i = 0; $i < $count; $i ++) {
		            $_FILES['resource_file']['name'] = $files['resource_file']['name'][$i];
					$_FILES['resource_file']['type'] = $files['resource_file']['type'][$i];
					$_FILES['resource_file']['tmp_name'] = $files['resource_file']['tmp_name'][$i];
					$_FILES['resource_file']['error'] = $files['resource_file']['error'][$i];
					$_FILES['resource_file']['size'] = $files['resource_file']['size'][$i];

					$config['upload_path'] = './assets/img/resources';
					$config['max_size'] = '102400';
					$config['allowed_types'] = '*';
					$config['remove_spaces'] = FALSE;

					$this->upload->initialize($config);
					$this->upload->overwrite = true;

					if(!($this->upload->do_upload('resource_file'))){
						$error=array('error' => $this->upload->display_errors());
						$this->session->set_flashdata('error',$error['error']);
					}
				}
			}

			$create=$this->resources_model->create_content($this->session->userdata('admin_id'), $this->input->post('title'), $this->input->post('meta_description'), $this->input->post('type'), $banner, $this->input->post('content'), $this->input->post('select_category'), $this->input->post('meta_keywords'), $uploads);

			if($create){
				$this->session->set_flashdata('success', 'Content Created Successfully');
			} else {
				$this->session->set_flashdata('error', 'Content name already exist.');
			}
			redirect('admin/resources/create');
	    }
	}

	function get_category() {
		$data = $this->resources_model->get_categories();
	    echo json_encode($data);
	}

	function create_category() {
		$category_name = $this->input->post('name');
		if(empty($category_name)){
			$data = array(
				'error' => true,
				'message' => 'Category name required'
			);
		} else {
			$data = $this->resources_model->create_category($category_name);
			if(!$data){
				$data = array(
					'error' => true,
					'message' => 'Category name already exist!'
				);
			}
		}
	    echo json_encode($data);
	}

	function update() {
		$config['upload_path'] = './assets/img/blogs';
		$config['allowed_types'] = 'gif|jpg|png';
		$this->upload->initialize($config);

		if(!empty($_FILES["banner"]["name"])){
			$config['upload_path'] = './assets/img/blogs/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif';
			$this->upload->initialize($config);
			if($this->upload->do_upload('banner')){
				$data = array('upload_data' => $this->upload->data());
				$banner = $_FILES['banner']['name'];
			}
		} else {
			$banner = $this->input->post('image');
		}

		if(isset($_FILES["files"]["name"])){
			$files = $_FILES;
	        $count = count($_FILES ['resource_file'] ['name']);
			$uploads = $_FILES['resource_file']['name'];

	        for ($i = 0; $i < $count; $i ++) {
	            $_FILES['resource_file']['name'] = $files['resource_file']['name'][$i];
				$_FILES['resource_file']['type'] = $files['resource_file']['type'][$i];
				$_FILES['resource_file']['tmp_name'] = $files['resource_file']['tmp_name'][$i];
				$_FILES['resource_file']['error'] = $files['resource_file']['error'][$i];
				$_FILES['resource_file']['size'] = $files['resource_file']['size'][$i];

				$config['upload_path'] = './assets/img/resources';
				$config['max_size'] = '102400';
				$config['allowed_types'] = '*';
				$config['remove_spaces'] = FALSE;

				$this->upload->initialize($config);
				$this->upload->overwrite = true;

				if(!($this->upload->do_upload('resource_file'))){
					$error=array('error' => $this->upload->display_errors());
					$this->session->set_flashdata('error',$error['error']);
				} else {
					$this->resources_model->delete_files($this->input->post('resource_ID'));
					$this->resources_model->upload_file($uploads, $this->input->post('resource_ID'));
				}
			}
		}
		
		$create = $this->resources_model->update($this->input->post('resource_ID'), $this->input->post('title'), $this->input->post('meta_description'), $this->input->post('type'), $banner, $this->input->post('content'), $this->input->post('select_category'), $this->input->post('meta_keywords'));

		if($create){
			$this->session->set_flashdata('success', 'Resource update Successfully');
		} else {
			$this->session->set_flashdata('error', 'Resource name already exist.');
		}

		redirect('admin/resources/edit/'.$this->input->post('resource_ID'));
	}

	//Upload image summernote
	function upload_image(){
		if(isset($_FILES["image"]["name"])){
			$config['upload_path'] = './assets/img/blogs/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif';
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('image')){
				$this->upload->display_errors();
				return FALSE;
			}else{
				$data = $this->upload->data();
		        //Compress Image
		        $config['image_library']='gd2';
		        $config['source_image']='./assets/img/blogs/'.$data['file_name'];
		        $config['create_thumb']= FALSE;
	            $config['maintain_ratio']= TRUE;
	            $config['new_image']= './assets/img/blogs/'.$data['file_name'];
	            $this->load->library('image_lib', $config);
	            $this->image_lib->resize();
				echo base_url().'assets/img/blogs/'.$data['file_name'];
			}
		}
	}

	function upload_file() {
		if(isset($_FILES["file"]["name"])){
			$config['upload_path'] = './assets/img/blogs/';
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('file')){
				$this->upload->display_errors();
				return FALSE;
			} else {
				$data = $this->upload->data();
				echo base_url().'assets/img/blogs/'.$_FILES['file']['name'];
			}
		}
	}
}