<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	function check_session(){
		if(!$this->session->userdata('admin_logged_in')){
			redirect('admin/login');
		}
	}

	public function index()	{
		$this->check_session();
		$page = 'home';
		$data['title'] = ucfirst($page);
		$data['first_name'] = $this->session->userdata('admin_firstname');
		$data['last_name'] = $this->session->userdata('admin_lastname');
		$data['admin_id'] = $this->session->userdata('admin_id');
		$data['admin_status'] = $this->session->userdata('admin_position');
		$data['settings'] = $this->settings_model->get_settings();
		$data['datas'] = $this->admin_model->summary();
		$data['programs'] = $this->admin_model->enrolled_programs();
		$data['yearly_sales'] = json_encode(array_values($data['datas']['yearly_sales']));
		$data['year'] = json_encode(array_values($data['datas']['year']));
		$data['monthly_sales'] = json_encode(array_values($data['datas']['monthly_sales']));
		$data['month'] = json_encode(array_values($data['datas']['month']));

		$this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/nav', $data);
		$this->load->view('admin/index', $data);
		$this->load->view('templates/admin/footer');
        $this->load->view('templates/admin/scripts');
	}

	public function users()	{
		$this->check_session();
		$page = 'users';
		$data['title'] = ucfirst($page);
		$data['first_name'] = $this->session->userdata('admin_firstname');
		$data['last_name'] = $this->session->userdata('admin_lastname');
		$data['admin_id'] = $this->session->userdata('admin_id');
		$data['admin_status'] = $this->session->userdata('admin_position');
		$data['settings'] = $this->settings_model->get_settings();
		$data['clients'] = $this->user_model->get_users();
		$data['programs'] = $this->programs_model->get_programs();

		$data['daily_logins'] = $this->user_model->daily_logins();

		$this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/nav', $data);
		$this->load->view('admin/'.$page, $data);
        $this->load->view('templates/admin/footer');
        $this->load->view('templates/admin/scripts');
	}

	public function posts()	{
		$this->check_session();
		$page = 'posts';
		$data['title'] = ucfirst($page);
		$data['first_name'] = $this->session->userdata('admin_firstname');
		$data['last_name'] = $this->session->userdata('admin_lastname');
		$data['admin_id'] = $this->session->userdata('admin_id');
		$data['admin_status'] = $this->session->userdata('admin_position');
		$data['settings'] = $this->settings_model->get_settings();

		$data['posts'] = $this->posts_model->get_posts(NULL, 0, FALSE);

		$this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/nav', $data);
		$this->load->view('admin/'.$page, $data);
        $this->load->view('templates/admin/footer');
        $this->load->view('templates/admin/scripts');
	}

	public function profile($id){
		$this->check_session();
		$page = 'users';
		$data['title'] = ucfirst($page);
		$data['first_name'] = $this->session->userdata('admin_firstname');
		$data['last_name'] = $this->session->userdata('admin_lastname');
		$data['admin_id'] = $this->session->userdata('admin_id');
		$data['admin_status'] = $this->session->userdata('admin_position');
		$data['settings'] = $this->settings_model->get_settings();
		$data['programs'] = $this->programs_model->get_programs();
		$data['modules'] = $this->user_model->get_user_module($id);
		$data['users'] = $this->user_model->get_users($id);
		$data['videos'] = $this->user_model->users_all_videos_watched($id);
		
		$this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/nav', $data);
		$this->load->view('admin/users-profile', $data);
        $this->load->view('templates/admin/footer');
        $this->load->view('templates/admin/scripts');
	}

	public function admins() {
		$this->check_session();
		$page = 'admins';
		$data['title'] = ucfirst($page);
		$data['first_name'] = $this->session->userdata('admin_firstname');
		$data['last_name'] = $this->session->userdata('admin_lastname');
		$data['admin_id'] = $this->session->userdata('admin_id');
		$data['admin_status'] = $this->session->userdata('admin_position');
		$data['settings'] = $this->settings_model->get_settings();

		if($data['admin_status'] != 2){
			$this->session->set_flashdata('error', 'You are not allowed here!');
			redirect('admin');
		}
		
		$data['admins'] = $this->admin_model->get_admins();

		$this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/nav', $data);
		$this->load->view('admin/'.$page, $data);
		$this->load->view('templates/admin/footer');
        $this->load->view('templates/admin/scripts');
	}

	public function ratings()	{
		$this->check_session();
		$page = 'ratings';
		$data['title'] = ucfirst($page);
		$data['first_name'] = $this->session->userdata('admin_firstname');
		$data['last_name'] = $this->session->userdata('admin_lastname');
		$data['admin_id'] = $this->session->userdata('admin_id');
		$data['admin_status'] = $this->session->userdata('admin_position');
		$data['settings'] = $this->settings_model->get_settings();
		if($data['admin_status'] != 2){
			$this->session->set_flashdata('error', 'You are not allowed here!');
			redirect('admin');
		}
		$data['ratings'] = $this->admin_model->get_software_ratings();

		$this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/nav', $data);
		$this->load->view('admin/'.$page, $data);
		$this->load->view('templates/admin/footer');
        $this->load->view('templates/admin/scripts');
	}

	public function support()	{
		$this->check_session();
		$page = 'support';
		$data['title'] = ucfirst($page);
		$data['first_name'] = $this->session->userdata('admin_firstname');
		$data['last_name'] = $this->session->userdata('admin_lastname');
		$data['admin_id'] = $this->session->userdata('admin_id');
		$data['admin_status'] = $this->session->userdata('admin_position');
		$data['settings'] = $this->settings_model->get_settings();
		if($data['admin_status'] != 2){
			$this->session->set_flashdata('error', 'You are not allowed here!');
			redirect('admin');
		}

		$data['messages'] = $this->support_model->get_messages();

		$this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/nav', $data);
		$this->load->view('admin/'.$page, $data);
		$this->load->view('templates/admin/footer');
        $this->load->view('templates/admin/scripts');
	}

	public function login(){
		$page = 'login';
		$data['title'] = ucfirst($page);
		$data['settings'] = $this->settings_model->get_settings();

		$this->form_validation->set_error_delimiters('<script type="text/javascript">$(function(){toastr.error("', '")});</script>');
        $this->form_validation->set_rules('email', 'email', 'required');
        $this->form_validation->set_rules('password', 'password', 'required');

        if($this->form_validation->run() === FALSE){
           	$this->load->view('templates/admin/header', $data);
			$this->load->view('admin/'.$page, $data);
			$this->load->view('templates/admin/scripts');
        } else {
            $admin_id = $this->admin_model->login($this->input->post('email'), $this->input->post('password'));

            if($admin_id['status'] == '0'){
            	$this->session->set_flashdata('error', 'Your account has been disabled!');
                redirect('admin/login');
            }

            if($admin_id){
                $admin_data = array(
                    'admin_id' => $admin_id['id'],
                    'email' => $this->input->post('email'),
                    'admin_firstname' => $admin_id['first_name'],
                    'admin_lastname' => $admin_id['last_name'],
                    'admin_position' => $admin_id['position'],
                    'admin_logged_in' => true
                );
                $this->session->set_userdata($admin_data);
                $this->session->set_flashdata('success', 'You are now logged in');
                redirect('admin/index');
            } else {
                $this->session->set_flashdata('error', 'Invalid Email/Password');
                redirect('admin/login');
            }       
        }
	}

	public function logout(){
        $this->session->unset_userdata('admin_logged_in');
        $this->session->unset_userdata('admin_id');
        $this->session->sess_destroy();
        $this->session->set_flashdata('success', 'You are now logged out');

        redirect('admin/login');
	}

	function give_reward()	{
		$data = $this->support_model->give_reward($this->input->post('user_ID'), $this->input->post('message_ID'));
		echo json_encode($data);
	}


	function get_programs_modules()	{
		$data = $this->admin_model->get_programs_modules($this->input->post('id'));
		echo json_encode($data);
	}

	function create_admin() {
		$this->form_validation->set_error_delimiters('<script type="text/javascript">$(function(){toastr.error("', '")});</script>');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('new_password', 'Password', 'required');
        $this->form_validation->set_rules('cnew_Password', 'confirm password', 'required|matches[new_password]');
        $this->form_validation->set_rules('first_name', 'First name', 'required');
        $this->form_validation->set_rules('last_name', 'last name', 'required');
        $this->form_validation->set_rules('position', 'Position', 'required');

	    if ($this->form_validation->run() === FALSE) {
			$this->session->set_flashdata('multi',validation_errors());
	        redirect('admin/admins');
	    } else {
			$create = $this->admin_model->create_admin($this->input->post('email',TRUE), $this->input->post('new_password',TRUE), $this->input->post('first_name',TRUE), $this->input->post('last_name',TRUE), $this->input->post('position',TRUE));
			if($create){
				$this->session->set_flashdata('success', 'Admin Created Successfully');
			} else {
				$this->session->set_flashdata('error', 'Email already exist');
			}
			redirect('admin/admins');
	    }
	}

	function update_admin() {
		$this->form_validation->set_error_delimiters('<script type="text/javascript">$(function(){toastr.error("', '")});</script>');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('first_name', 'First name', 'required');
        $this->form_validation->set_rules('last_name', 'last name', 'required');
        $this->form_validation->set_rules('position', 'Position', 'required');

	    if ($this->form_validation->run() === FALSE) {
			$this->session->set_flashdata('multi',validation_errors());
	        redirect('admin/admins');
	    } else {
			if(empty($this->input->post('status', TRUE))){
				$status = '0';
			} else {
				$status = $this->input->post('status', TRUE);
			}
			$create = $this->admin_model->update_admin($this->input->post('admin_ID',TRUE), $this->input->post('email'), $this->input->post('first_name',TRUE), $this->input->post('last_name',TRUE), $status, $this->input->post('position',TRUE));
			if($create){
				$this->session->set_flashdata('success', 'Admin updated Successfully');
			} else {
				$this->session->set_flashdata('error', 'Email already exist');
			}
			redirect('admin/admins');
	    }
	}

	function change_password() {
		$this->form_validation->set_error_delimiters('<script type="text/javascript">$(function(){toastr.error("', '")});</script>');
        $this->form_validation->set_rules('current_password', 'Current Password', 'required');
        $this->form_validation->set_rules('new_password', 'new password', 'required');
        $this->form_validation->set_rules('confirm_new_password', 'confirm password', 'required|matches[new_password]', array('matches' => 'Password not match'));
	    if ($this->form_validation->run() === FALSE) {
			$this->session->set_flashdata('multi',validation_errors());
	        redirect('admin/settings');
	    } else {
			$current_password = $this->input->post('current_password');
			$new_password = $this->input->post('new_password');
			$confirm_new_password = $this->input->post('confirm_new_password');
			$user = $this->admin_model->get_admins($this->session->userdata('email'));

			if(!password_verify($current_password, $user['password'])){
				$this->session->set_flashdata('error', 'Invalid current password');
			} else {
				$create = $this->admin_model->change_password($new_password, $this->session->userdata('email'));
				if($create){
					$this->session->set_flashdata('success', 'Password changed Successfully');
				}
			}
			redirect('admin/settings');
	    }
	}

	function user_change_password() {
		$this->form_validation->set_error_delimiters('<script type="text/javascript">$(function(){toastr.error("', '")});</script>');
        $this->form_validation->set_rules('new_password', 'new password', 'required');
        $this->form_validation->set_rules('confirm_new_password', 'confirm password', 'required|matches[new_password]', array('matches' => 'Password not match'));
	    if ($this->form_validation->run() === FALSE) {
			$this->session->set_flashdata('multi',validation_errors());
	        redirect('admin/users/'.$this->input->post('user_ID'));
	    } else {
			$user = $this->user_model->get_users($this->input->post('user_ID'));
			$create = $this->user_model->change_password($this->input->post('new_password'), $user['email']);
			if($create){
				$this->session->set_flashdata('success', 'Password changed Successfully');
			}	

			redirect('admin/users/'.$this->input->post('user_ID'));
	    }
	}

	function new_messages() {
		$data = $this->support_model->new_messages();
		echo json_encode($data);
	}

	function seen() {
		$data = $this->support_model->seen();
		echo json_encode($data);
	}

	function change_profile(){
	   	$data = $this->user_model->change_profile($this->input->post('first_name'), $this->input->post('last_name'), $this->input->post('image'), $this->input->post('bio'), $this->input->post('email'), $this->input->post('user_ID'));
	   	$this->session->set_flashdata('success', 'Profile updated');
		redirect('admin/users/'.$this->input->post('user_ID'));
	}

	function change_review_post_status(){
	   	$data = $this->settings_model->change_review_post_status($this->input->post('review_status'));
		redirect('admin/settings');
	}

	function change_system_status(){
	   	$data = $this->settings_model->change_system_status($this->input->post('system_status'));
		redirect('admin/settings');
	}
}