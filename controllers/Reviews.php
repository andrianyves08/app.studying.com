<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reviews extends CI_Controller {

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
		$page = 'reviews';
		$data['title'] = ucfirst($page);
		$data['first_name'] = $this->session->userdata('admin_firstname');
		$data['last_name'] = $this->session->userdata('admin_lastname');
		$data['admin_id'] = $this->session->userdata('admin_id');
		$data['admin_status'] = $this->session->userdata('admin_position');
		$data['settings'] = $this->settings_model->get_settings();
		$data['reviews'] = $this->reviews_model->get_reviews();

		$this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/nav', $data);
		$this->load->view('admin/'.$page, $data);
		$this->load->view('templates/admin/footer');
        $this->load->view('templates/admin/scripts');
	}

	public function edit_review($id){
		$this->check_session();
		$page = 'reviews';
		$data['title'] = ucfirst($page);
		$data['first_name'] = $this->session->userdata('admin_firstname');
		$data['last_name'] = $this->session->userdata('admin_lastname');
		$data['admin_id'] = $this->session->userdata('admin_id');
		$data['admin_status'] = $this->session->userdata('admin_position');
		$data['settings'] = $this->settings_model->get_settings();
		$data['reviews'] = $this->reviews_model->get_reviews($id);

		$this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/nav', $data);
		$this->load->view('admin/reviews-edit', $data);
		$this->load->view('templates/admin/footer');
		$this->load->view('templates/admin/scripts');
	}

	function create() {
        $this->form_validation->set_rules('rating', 'rating', 'required');
        $this->form_validation->set_rules('url', 'url', 'required');
        $this->form_validation->set_rules('title', 'title', 'required');

        if ($this->form_validation->run() === FALSE) {
        	$this->session->set_flashdata('multi',validation_errors());
			redirect('admin/reviews');
	    } else {
	    	$description = '';
	    	$full_name = '';
	    	$niche = '';
	    	$location = '';
	    	$testimonial = '';

	    	$title = $this->input->post('title');
	    	$rating = $this->input->post('rating');
	    	$url = $this->input->post('url');
	    	$date = $this->input->post('date');

	    	if(!empty($this->input->post('description'))) {
	    		$description = $this->input->post('description');
	    	}

	    	if(!empty($this->input->post('name'))) {
	    		$full_name = $this->input->post('name');
	    	}

	    	if(!empty($this->input->post('niche'))) {
	    		$niche = $this->input->post('niche');
	    	}

	    	if(!empty($this->input->post('location'))) {
	    		$location = $this->input->post('location');
	    	}

	    	if(!empty($this->input->post('testimonial'))) {
	    		$testimonial = $this->input->post('testimonial');
	    	}
	    	
			$data = $this->reviews_model->create_review($title, $full_name, $description, $testimonial, $rating, $niche, $location, $url, $date, $this->session->userdata('admin_position'));

			if($data){
				$this->session->set_flashdata('success', 'Review created Successfully');
			} else {
				$this->session->set_flashdata('error', 'Review video URL already exist.');
			}
			redirect('admin/reviews');
	    }
	}

	function update() {
		$id = $this->input->post('review_ID');
    	$description = '';
    	$full_name = '';
    	$niche = '';
    	$location = '';
    	$testimonial = '';

    	$title = $this->input->post('title');
    	$rating = $this->input->post('rating');
    	$url = $this->input->post('url');
    	$date = $this->input->post('date');

    	if(!empty($this->input->post('description'))) {
    		$description = $this->input->post('description');
    	}

    	if(!empty($this->input->post('name'))) {
    		$full_name = $this->input->post('name');
    	}

    	if(!empty($this->input->post('niche'))) {
    		$niche = $this->input->post('niche');
    	}

    	if(!empty($this->input->post('location'))) {
    		$location = $this->input->post('location');
    	}

    	if(!empty($this->input->post('testimonial'))) {
    		$testimonial = $this->input->post('testimonial');
    	}
    	
		$data = $this->reviews_model->update_review($id, $title, $full_name, $description, $testimonial, $rating, $niche, $location, $url, $date, $this->session->userdata('admin_position'));

		if($data){
			$this->session->set_flashdata('success', 'Review updated Successfully');
		} else {
			$this->session->set_flashdata('error', 'Review video URL already exist.');
		}
		redirect('admin/reviews/'.$id);

	}

	function delete_review() {
		$review_ID = $this->input->post('id');
		$data = $this->reviews_model->delete_review($review_ID);
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
		        //Compress Image
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
}