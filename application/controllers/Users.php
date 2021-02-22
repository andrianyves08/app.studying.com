<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('upload');
	}

	function accept_reward(){
		$this->form_validation->set_error_delimiters('<script type="text/javascript">$(function(){toastr.error("', '")});</script>');
        $this->form_validation->set_rules('reward', 'reward', 'required',array('required' => 'Click the reward'));

	    if ($this->form_validation->run() === FALSE) {
			$this->session->set_flashdata('multi', validation_errors());
	        redirect('');
	    } else {
	    	$sql = $this->user_model->daily_logins($this->session->userdata('user_id'));
	    	$rewards = $sql['days'] * 15;

			$data = $this->user_model->accept_reward($this->session->userdata('user_id'), $rewards);
			if($data){
				$this->session->set_flashdata('success', 'Gain '.$rewards.' exp');
			}
			redirect('');
	    }
	}

	function my_purchases(){
		$data = $this->programs_model->user_purchase($this->input->post('slug'), $this->session->userdata('user_id'));
		echo json_encode($data);
	}

	function my_purchases_by_section(){
		$data = $this->programs_model->my_purchases_by_section($this->input->post('slug'), $this->session->userdata('user_id'), $this->input->post('course_slug'));
		echo json_encode($data);
	}

	function refund_purchase(){
		$data = $this->user_model->refund_purchase($this->input->post('id'), $this->input->post('amount'), $this->session->userdata('user_id'));
		echo json_encode($data);
	}

	function get_user_programs(){
		$data = $this->programs_model->get_user_programs($this->session->userdata('user_id'));
		echo json_encode($data);
	}

	function index(){
		$data['settings'] = $this->settings_model->get_settings();
	}

	function create() {
		$this->form_validation->set_error_delimiters('<script type="text/javascript">$(function(){toastr.error("', '")});</script>');
        $this->form_validation->set_rules('email', 'Email', 'required');
	    if ($this->form_validation->run() === FALSE) {
			$this->session->set_flashdata('multi',validation_errors());
	        redirect('admin/users');
	    } else {
			$email = $this->input->post('email',TRUE);
		
			$create = $this->user_model->create_user($email);
			if($create){
				$this->session->set_flashdata('success', 'User Created Successfully');
			} else {
				$this->session->set_flashdata('error', 'Email already exist');
			}
			redirect('admin/users');
	    }
	}

	function change_status($user_ID) {
		if(empty($this->input->post('status', TRUE))){
			$status = '2';
		} else {
			$status = $this->input->post('status', TRUE);
		}
		$create = $this->user_model->change_status($user_ID, $status);
		if($create){
			$this->session->set_flashdata('success', 'User status changed Successfully');
		} 
		redirect('admin/users/'.$user_ID);
	}

	function change_password(){
		$page = $this->input->post('page',TRUE);
		$this->form_validation->set_error_delimiters('<script type="text/javascript">$(function(){toastr.error("', '")});</script>');
        $this->form_validation->set_rules('new_password', 'new password', 'required');
        $this->form_validation->set_rules('cnew_Password', 'confirm password', 'required|matches[new_password]');

	    if ($this->form_validation->run() === FALSE) {
			$this->session->set_flashdata('multi',validation_errors());
	        if($page == '1'){
				redirect('update-profile');
			} else {
				redirect('my-profile');
			}
	    } else {
	    	$current_password = $this->input->post('current_password',TRUE);
			$new_password = $this->input->post('new_password',TRUE);
			$cnew_Password = $this->input->post('cnew_Password',TRUE);
			$user = $this->user_model->get_users($this->session->userdata('email'));
			if(!empty($current_password)){
				if(!password_verify($current_password, $user['password'])){
					$this->session->set_flashdata('error', 'Invalid current password');
				} else {
					$create = $this->user_model->change_password($new_password, $this->session->userdata('email'));
					if($create){
						$this->session->set_flashdata('success', 'Update successfully');
					}	

				}
			} else {
				$create = $this->user_model->change_password($new_password, $this->session->userdata('email'));
				if($create){
					$this->session->set_flashdata('success', 'Update successfully');
				}	
					
			}
			if($page == '1'){
				$this->messages_model->add_member($this->session->userdata('user_id'), '1');
				redirect('login');
			} else {
				redirect('my-profile');
			}
	    }
	}

	function change_profile(){
		$this->form_validation->set_error_delimiters('<script type="text/javascript">$(function(){toastr.error("', '")});</script>');
		$this->form_validation->set_rules('first_name', 'Firt name', 'required');
		$this->form_validation->set_rules('last_name', 'Last name', 'required');
        $page = $this->input->post('page',TRUE);

	    if ($this->form_validation->run() === FALSE) {
			$this->session->set_flashdata('multi',validation_errors());
	        if($page == '1'){
				redirect('update-profile');
			} else {
				redirect('my-profile');
			}
	    } else {
		   	$this->update_profile($this->session->userdata('user_id'), hash('md5', $this->session->userdata('email')));
			if($page == '1'){
				$this->change_password();
				redirect(base_url());
			} else {
				redirect('my-profile');
			}
	    }
	}

	function update_profile($id, $email){
    	if(!empty($_FILES["profile_photo"]["name"])){
	    	$profile_photo = $email.".".pathinfo($_FILES['profile_photo']['name'], PATHINFO_EXTENSION); 

    		$config['file_name'] = $profile_photo;
			$config['upload_path'] = './assets/img/users/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif';
			$config['max_size']      = 4096;
			$this->upload->initialize($config);
			unlink('./assets/img/users/'.$profile_photo); 
			if(!$this->upload->do_upload('profile_photo')){
				$this->session->set_flashdata('error',$this->upload->display_errors());
			} else {
				$data = array('upload_data' => $this->upload->data());
				$source_path = './assets/img/users/'.$profile_photo;
				$target_path = './assets/img/users/'.$profile_photo;
				$config_manip = array(
				  'image_library' => 'gd2',
				  'source_image' => $source_path,
				  'new_image' => $target_path,
				  'maintain_ratio' => TRUE,
				  'width' => 600,
				  'quality' => '70%',
				);
				$this->load->library('image_lib', $config_manip);
				$this->image_lib->resize();
				$this->image_lib->clear();
			}
		} else {
			$profile_photo = $this->input->post('image');
		}
		$bio = '';
		if(!empty($this->input->post('bio'))){
			$bio = $this->input->post('bio');
		}

		$create = $this->user_model->change_profile($this->input->post('first_name'), $this->input->post('last_name'), $profile_photo, $bio, $this->session->userdata('email'), $this->session->userdata('user_id'));
		if($create){
			$this->session->set_flashdata('success', 'Update successfully');
		}
	}

	function track_progress(){
		$create = $this->user_model->track_progress($this->input->post('duration'), $this->input->post('progress'), $this->session->userdata('user_id'), $this->input->post('content'), $this->input->post('src'));
		echo json_encode($create);
	}

	function finished_watched(){
		//$src = $this->input->post('src');
		$create = $this->user_model->finished_video($this->session->userdata('user_id'), $this->input->post('content'));
		$data = $this->user_model->get_user_by_id($this->session->userdata('user_id'));
		$create2 = $this->user_model->level_up($this->session->userdata('user_id'), $data['user_exp']);
		if(!$create){
			$data = array(
			'success' => true
			);
		} else {
			$data = array(
			'error' => true
			);
		}
		echo json_encode($data);
	}

	function get_progress(){
		$create = $this->user_model->get_progress_video($this->input->post('content'), $this->session->userdata('user_id'));
		if($create){
			$data = array(
				'status' => true,
				'finished' => $create['status'],
				'progress' => $create['progress']
			);
		} else {
			$data = array(
				'status' => false,
				'finished' => $create['status'],
				'progress' => 0
			);
		}
		echo json_encode($data);
	}

	function last_watched(){
		$create = $this->user_model->last_watched($this->session->userdata('user_id'));
		echo json_encode($create);
	}

	function watched_video(){
		$create = $this->user_model->get_progress_content($this->session->userdata('user_id'), $this->input->post('content'));
		if($create){
			$data = array(
			'success' => true
			);
		} else {
			$data = array(
			'error' => true
			);
		}
		echo json_encode($data);
	}

	function all_watched_video(){
		$create = $this->user_model->get_all_progress_content($this->session->userdata('user_id'));
		if($create){
			$data = array(
			'success' => true
			);
		} else {
			$data = array(
			'error' => true
			);
		}
		echo json_encode($create);
	}

	function all_videos(){
		$data = $this->user_model->all_videos();
		echo json_encode($data);
	}

	function get_current_progress(){
		$create = $this->user_model->get_current_progress($this->session->userdata('user_id'));

		echo json_encode($create);
	}

	function get_level() {
		$data = $this->user_model->get_user_by_id($this->session->userdata('user_id'));
		$next_level = $this->user_model->next_level($data['level']);
		if(!$next_level){
			$next_exp =	$data['user_exp'];
		} else {
			$next_exp =	$next_level['next_exp'];
		}
		$level = $next_exp - $data['current_level'];
		$mycurrent = $data['user_exp'] - $data['current_level'];
		$percentage = ($mycurrent / $level) * 100;
		$output = '';

		$output .= '
		<div class="form-inline">
			<a class="nav-link waves-effect blue-text">
		        <strong>Level '.$data['level'].' </strong>
		    </a>
		    <div class="progress" style="width: 100px; height: 15px;">
		    	<div class="progress-bar" role="progressbar" style="width: '.$percentage.'%;" aria-valuemin="0" aria-valuemax="'.$level.'">'.$data['user_exp'].' exp
		    	</div>
		  	</div>
		</div>
		';
		echo json_encode($output);
	}

	function next(){
		$data = $this->course_model->next_module($this->input->post('course_slug'), $this->input->post('section_slug'), $this->session->userdata('user_id'));
		echo json_encode($data);
	}

	function get_course_progress() {
		$user_progress = $this->user_model->users_videos_watched(NULL, NULL, $this->session->userdata('user_id'));
		$data = $this->course_model->count_course(NULL, NULL, $this->session->userdata('user_id'));
		$percentage = ($user_progress['total'] / $data['content']) * 100;
		$data = array(
			'percentage_width' => $percentage,
			'percentage' => round($percentage),
			'total' => $user_progress['total']
		);
		echo json_encode($data);
	}

	function get_module_progress() {
		$user_progress = $this->user_model->users_videos_watched($this->input->post('slug'), NULL, $this->session->userdata('user_id'));
		$data = $this->course_model->count_course($this->input->post('slug'), NULL, $this->session->userdata('user_id'));
		$percentage = ($user_progress['total'] / $data['content']) * 100;
		$data = array(
			'percentage_width' => $percentage,
			'percentage' => round($percentage),
			'total' => $user_progress['total']
		);
		echo json_encode($data);
	}

	function get_section_progress() {
		$user_progress = $this->user_model->users_videos_watched($this->input->post('slug'), $this->input->post('section_slug'), $this->session->userdata('user_id'));
		$data = $this->course_model->count_course($this->input->post('slug'), $this->input->post('section_slug'), $this->session->userdata('user_id'));
		$percentage = ($user_progress['total'] / $data['content']) * 100;
		$data = array(
			'percentage_width' => $percentage,
			'percentage' => round($percentage),
			'total' => $user_progress['total']
		);

		echo json_encode($data);
	}

	function add_purchases() {
		$data = $this->user_model->add_purchases($this->input->post('id'));
		echo json_encode($data);
	}

	function delete_purchase() {
		$data = $this->user_model->delete_purchase($this->input->post('id'));
		echo json_encode($data);
	}

	function create_notes() {
		$data = $this->user_model->create_notes($this->input->post('section_ID'), $this->input->post('notes'), $this->session->userdata('user_id'));
		echo json_encode($data);
	}

	function get_my_notes() {
		$data = $this->user_model->get_my_notes($this->input->post('section_ID'), $this->session->userdata('user_id'));
		echo json_encode($data);
	}

	function delete_notes() {
		$data = $this->user_model->delete_notes($this->input->post('id'));
		echo json_encode($data);
	}
}