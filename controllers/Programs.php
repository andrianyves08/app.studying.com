<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Programs extends CI_Controller {

	function check_session(){
		if(!$this->session->userdata('admin_logged_in')){
			redirect('admin/login');
		}
	}

	public function index()	{
		$this->check_session();
		$page = 'programs';
		$data['title'] = ucfirst($page);
		$data['first_name'] = $this->session->userdata('admin_firstname');
		$data['last_name'] = $this->session->userdata('admin_lastname');
		$data['admin_id'] = $this->session->userdata('admin_id');
		$data['admin_status'] = $this->session->userdata('admin_position');
		if($data['admin_status'] != 2){
			$this->session->set_flashdata('error', 'You are not allowed here!');
			redirect('admin');
		}
		$data['programs'] = $this->programs_model->get_programs();
		$data['modules'] = $this->programs_model->get_programs_modules();
		$data['settings'] = $this->settings_model->get_settings();

		$this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/nav', $data);
		$this->load->view('admin/programs', $data);
        $this->load->view('templates/admin/footer');
        $this->load->view('templates/admin/scripts');
	}

	function get_program(){
		$id = $this->input->post('id');
		$data = $this->programs_model->get_programs($id);
		echo json_encode($data);
	}

	function create_program() {
		$this->programs_model->create_program($this->input->post('name'));
		redirect('admin/programs');
	}

	function update_program() {
        $this->form_validation->set_rules('program_name', 'Name', 'required');
        $this->form_validation->set_rules('program_price', 'Price', 'required');

        if ($this->form_validation->run() === FALSE) {
			$data = array(
				'error' => true,
				'message' => validation_errors()
			);
			$this->session->set_flashdata('multi',validation_errors());
	        echo json_encode($data);
	    } else {
			$create = $this->programs_model->update_program($this->input->post('program_ID'), $this->input->post('program_name'), $this->input->post('program_price'));
			if(!$create){
				$data = array(
				'error' => true,
				'message' => 'Program name already exist.'
				);
			} else {
				$data = array(
				'success' => true
				);
			}
			echo json_encode($data);
	    }
	}

	function get_modules(){
		$data = $this->programs_model->get_modules($this->input->post('id'));
		echo json_encode($data);
	}

	function add_modules() {
		$create = $this->programs_model->add_modules($this->input->post('prog_ID'), $this->input->post('modules'));

		if($create){
			$this->session->set_flashdata('success', 'Added modules successfully');
		}

		redirect('admin/programs');	
	}

	function delete_module() {
		$data = $this->programs_model->delete_module($this->input->post('id'));
		echo json_encode($data);
	}
}