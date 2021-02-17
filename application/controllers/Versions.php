<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Versions extends CI_Controller {

	public function section_2($course_slug, $section_slug){
		$page = 'modules';
		$data['title'] = ucfirst($page);
		$data['settings'] = $this->settings_model->get_settings();
		$data['unseen_chat'] = $this->messages_model->total_message_unseen($this->session->userdata('user_id'));

		//$this->output->cache(1440);
		if($section_slug == NULL){
			 show_404();
		}
		$data['courses'] = $this->course_model->get_course_content($course_slug);
		$data['sections'] = $this->course_model->get_section_by_slug($section_slug);
		$data['lessons'] = $this->course_model->get_lesson($data['sections']['id']);
		$data['contents'] = $this->course_model->get_content();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/nav', $data);
		$this->load->view('pages/section_2', $data);
		$this->load->view('templates/footer');
		$this->load->view('templates/scripts');
	}

	public function section_3($slug = FALSE){
		$page = 'modules';
		$data['title'] = ucfirst($page);
		$data['settings'] = $this->settings_model->get_settings();
		$data['unseen_chat'] = $this->messages_model->total_message_unseen($this->session->userdata('user_id'));
		if($slug === FALSE){
			$slug = 'week-0-pre-1st-lesson-videos';
		}
		$data['courses'] = $this->course_model->get_course_content($slug);
		$data['sections'] = $this->course_model->get_section($data['courses']['id']);
		$data['lessons'] = $this->course_model->get_lesson();
		$data['contents'] = $this->course_model->get_content();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/nav', $data);
		$this->load->view('pages/section_3', $data);
		$this->load->view('templates/footer');
		$this->load->view('templates/scripts');
	}

	public function section_4($slug = FALSE){
		$page = 'section';
		$data['title'] = ucfirst($page);
		$data['settings'] = $this->settings_model->get_settings();
		$data['unseen_chat'] = $this->messages_model->total_message_unseen($this->session->userdata('user_id'));
		
		if($slug === FALSE){
			$slug = 'learn-ecom-services-use-my-team';
		}

		$data['courses'] = $this->course_model->get_course_content($slug);

		$this->output->cache(720);
		$data['sections'] = $this->course_model->get_section($data['courses']['id']);
		$data['lessons'] = $this->course_model->get_lesson();
		$data['contents'] = $this->course_model->get_content();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/nav', $data);
		$this->load->view('pages/section_4', $data);
		$this->load->view('templates/footer');
		$this->load->view('templates/scripts');
	}
}
