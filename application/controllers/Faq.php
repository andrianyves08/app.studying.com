<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faq extends CI_Controller {

	function check_session(){
		if(!$this->session->userdata('admin_logged_in')){
			redirect('admin/login');
		}
	}

	public function index()	{
		$this->check_session();
		$page = 'faq';
		$data['title'] = strtoupper($page);
		$data['first_name'] = $this->session->userdata('admin_firstname');
		$data['last_name'] = $this->session->userdata('admin_lastname');
		$data['admin_id'] = $this->session->userdata('admin_id');
		$data['admin_status'] = $this->session->userdata('admin_position');
		$data['settings'] = $this->settings_model->get_settings();
		$data['faqs'] = $this->faq_model->get_all_faqs();

		$this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/nav', $data);
		$this->load->view('admin/faq', $data);
		$this->load->view('templates/admin/footer');
        $this->load->view('templates/admin/scripts');
	}

	public function edit_faq($id){
		$this->check_session();
		$page = 'faq';
		$data['title'] = strtoupper($page);
		$data['first_name'] = $this->session->userdata('admin_firstname');
		$data['last_name'] = $this->session->userdata('admin_lastname');
		$data['admin_id'] = $this->session->userdata('admin_id');
		$data['admin_status'] = $this->session->userdata('admin_position');
		$data['settings'] = $this->settings_model->get_settings();
		$data['faqs'] = $this->faq_model->get_all_faqs($id);
		$data['all_categories'] = $this->resources_model->get_categories();

		$this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/nav', $data);
		$this->load->view('admin/faq-edit', $data);
		$this->load->view('templates/admin/footer');
		$this->load->view('templates/admin/scripts');
	}

	function create() {
		$this->form_validation->set_error_delimiters('<script type="text/javascript">$(function(){toastr.error("', '")});</script>');
        $this->form_validation->set_rules('type', 'Type', 'required');
        $this->form_validation->set_rules('question', 'Question', 'required');
        $this->form_validation->set_rules('answer', 'Answer', 'required');
        $this->form_validation->set_rules('category', 'Category', 'required');

	    if ($this->form_validation->run() === FALSE) {
			$this->session->set_flashdata('multi',validation_errors());
	        redirect('admin/frequently-asked-questions');
	    } else {
			$create = $this->faq_model->create_question($this->input->post('type'), $this->input->post('category'), $this->input->post('question'), $this->input->post('answer'));
			if($create){
				$this->session->set_flashdata('success', 'Q and A created successfully');
			} else {
				$this->session->set_flashdata('error', 'question already exist');
			}
			redirect('admin/frequently-asked-questions');
	    }
	}

	function update() {
		$this->form_validation->set_error_delimiters('<script type="text/javascript">$(function(){toastr.error("', '")});</script>');
        $this->form_validation->set_rules('type', 'Type', 'required');
        $this->form_validation->set_rules('question', 'Question', 'required');
        $this->form_validation->set_rules('answer', 'Answer', 'required');

	    if ($this->form_validation->run() === FALSE) {
			$this->session->set_flashdata('multi',validation_errors());
	        redirect('admin/frequently-asked-questions/'.$this->input->post('faq_ID'));
	    } else {
			$create = $this->faq_model->update_question($this->input->post('faq_ID'), $this->input->post('type'), $this->input->post('category'), $this->input->post('question'), $this->input->post('answer'));
			if($create){
				$this->session->set_flashdata('success', 'Q and A updated successfully');
			} else {
				$this->session->set_flashdata('error', 'question already exist');
			}
			redirect('admin/frequently-asked-questions/'.$this->input->post('faq_ID'));
	    }
	}

	function delete() {
		$data = $this->faq_model->delete_question($this->input->post('id'));
		echo json_encode($data);
	}
}