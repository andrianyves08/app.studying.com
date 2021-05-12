<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('upload');
	}

	public function index(){
		if(!$this->session->userdata('admin_logged_in')){
			redirect('admin/login');
		}
		$page = 'settings';
		$data['title'] = ucfirst($page);
		$data['first_name'] = $this->session->userdata('admin_firstname');
		$data['last_name'] = $this->session->userdata('admin_lastname');
		$data['admin_id'] = $this->session->userdata('admin_id');
		$data['admin_status'] = $this->session->userdata('admin_position');
		$data['settings'] = $this->settings_model->get_settings();
		$data['pages'] = $this->settings_model->get_pages();

		$this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/nav', $data);
		$this->load->view('admin/'.$page, $data);
		$this->load->view('templates/admin/scripts');
        $this->load->view('templates/admin/footer');
	}

	public function Pages($id){
		if(!$this->session->userdata('admin_logged_in')){
			redirect('admin/login');
		}

		$page = 'settings';
		$data['title'] = ucfirst($page);
		$data['first_name'] = $this->session->userdata('first_name');
		$data['last_name'] = $this->session->userdata('last_name');
		$data['admin_id'] = $this->session->userdata('admin_id');
		$data['admin_status'] = $this->session->userdata('admin_position');
		$data['settings'] = $this->settings_model->get_settings();
		$data['pages'] = $this->settings_model->get_pages($id);

		$this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/nav', $data);
		$this->load->view('admin/settings-edit', $data);
		$this->load->view('templates/admin/scripts');
        $this->load->view('templates/admin/footer');
	}

	public function logo() {
		$logo = $_FILES['logo']['name'];
    	$logo = "logo.".pathinfo($logo, PATHINFO_EXTENSION); 
		$config['file_name'] = $logo;
		$config['upload_path'] = './assets/img';
		$config['allowed_types'] = 'gif|jpg|png';
		$this->upload->initialize($config);
		$this->upload->overwrite = true;

		if(!$this->upload->do_upload('logo')){
			$error = array('error' => $this->upload->display_errors());
			$this->session->set_flashdata('error',$error['error']);
		} else {
			$data = array('upload_data' => $this->upload->data());
			$logo_img = $_FILES['logo']['name'];
			$this->settings_model->logo($logo);
			$this->session->set_flashdata('success', 'Your Logo has been updated');
		}
		redirect('admin/settings');
	}

	function login_video() {
		$video = $_FILES['login_video']['name'];
    	$login_video = "login_video.".pathinfo($video, PATHINFO_EXTENSION); 
		$config['file_name'] = $login_video;
		$config['upload_path'] = './assets/img/videos';
		$config['allowed_types'] = 'mkv|avi|mov|mp4';
		$config['max_size'] = '102400';
		$this->upload->initialize($config);
		$this->upload->overwrite = true;

		if(!$this->upload->do_upload('login_video')){
			$error = array('error' => $this->upload->display_errors());
			$this->session->set_flashdata('error',$error['error']);
		} else {
			$data = array('upload_data' => $this->upload->data());
			$this->settings_model->login_video($login_video);
			$this->session->set_flashdata('success', 'Your Video has been updated');
		}
		redirect('admin/settings');
	}

	function home_video() {
		$video = $_FILES['home_video']['name'];
    	$home_video = "home_video.".pathinfo($video, PATHINFO_EXTENSION); 
		$config['file_name'] = $home_video;
		$config['upload_path'] = './assets/img/videos';
		$config['allowed_types'] = 'mkv|avi|mov|mp4';
		$config['max_size'] = '102400';
		$this->upload->initialize($config);
		$this->upload->overwrite = true;

		if(!$this->upload->do_upload('home_video')){
			$error = array('error' => $this->upload->display_errors());
			$this->session->set_flashdata('error',$error['error']);
		} else {
			$data = array('upload_data' => $this->upload->data());
			$this->settings_model->home_video($home_video);
			$this->session->set_flashdata('success', 'Your Video has been updated');
		}
		redirect('admin/settings');
	}

	function music() {
		$name = $_FILES['music']['name'];
    	$music = "music.".pathinfo($name, PATHINFO_EXTENSION); 
		$config['file_name'] = $music;
		$config['upload_path'] = './assets/img';
		$config['allowed_types'] = 'mp3';
		$config['max_size'] = '102400';
		$this->upload->initialize($config);
		if(!$this->upload->do_upload('music')){
			$error = array('error' => $this->upload->display_errors());
			$this->session->set_flashdata('error',$error['error']);
		} else {
			$data = array('upload_data' => $this->upload->data());
			$this->settings_model->music($music);
			$this->session->set_flashdata('success', 'Your background music has been updated');
		}
		redirect('admin/settings');
	}

	function nav_text_color() {
		$this->settings_model->nav_text_color($this->input->post('nav_color',TRUE));
		$this->session->set_flashdata('success', 'Your color has been updated');
		redirect('admin/settings');
	}

	function update_page($id) {
		$content = $this->input->post('content');
		$config['upload_path'] = './assets/img';
		$config['allowed_types'] = 'gif|jpg|png';
		$this->upload->initialize($config);
		if(!empty($_FILES["background_image"]["name"])){
			$config['upload_path'] = './assets/img/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif';
			$this->upload->initialize($config);
			if($this->upload->do_upload('background_image')){
				$data = array('upload_data' => $this->upload->data());
				$background_image = $_FILES['background_image']['name'];
			}
		} else {
			$background_image = $this->input->post('image');
		}
		$this->settings_model->update_page($id, $background_image, $content);
		$this->session->set_flashdata('success', 'Page has been updated');
		redirect('admin/settings');
	}

	function edit_background_image() {
		$config['upload_path'] = './assets/img';
		$config['allowed_types'] = 'gif|jpg|png';
		$this->upload->initialize($config);
		if(!$this->upload->do_upload('background_image')){
			$error = array('error' => $this->upload->display_errors());
			$this->session->set_flashdata('error',$error['error']);
		} else {
			$data = array('upload_data' => $this->upload->data());
			$background_image = $_FILES['background_image']['name'];
			$this->settings_model->background_image($background_image);
			$this->session->set_flashdata('success', 'Your background image has been updated');
		}
		redirect('admin/settings');
	}
}