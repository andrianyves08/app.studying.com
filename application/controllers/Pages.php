<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->library('upload');
	}

	public function user_status(){
		$settings = $this->settings_model->get_settings();
	 	$data = array(
            'isLoggedIn' => $this->session->userdata('user_logged_in'),
            'fn' => ucwords($this->session->userdata('first_name')),
			'ln' => ucwords($this->session->userdata('last_name')),
			'status' => $settings['system_status']
        );
      	$this->output->set_header('Content-type: application/json');
        $this->output->set_output(json_encode($data));
	}

	public function maintenance(){
		$page = 'maintenance';
		$data['title'] = ucfirst($page);

		$this->load->view('pages/'.$page, $data);
		$this->load->view('templates/scripts');
	}

	public function index(){
		if(!$this->session->userdata('user_logged_in')){
			redirect('login');
		}
		$page = 'home';
		$data['title'] = ucfirst($page);
		$data['settings'] = $this->settings_model->get_settings();
		$data['my_id'] = $this->session->userdata('user_id');
		$data['music_status'] = $this->user_model->get_music_status($this->session->userdata('user_id'));
		$data['unseen_chat'] = $this->messages_model->total_message_unseen($this->session->userdata('user_id'));
		$data['last_watched'] = $this->user_model->last_watched($this->session->userdata('user_id'));
		$data['rankings'] = $this->user_model->rankings(10); 
		$data['all'] = $this->course_model->get_all(3, 0, $this->session->userdata('user_id'));
		$data['success_stories'] = $this->course_model->get_content_content(7);
		$data['first_video'] = $this->course_model->get_content_content(5);
		$data['created_at'] = $this->user_model->get_users($this->session->userdata('user_id'));
		$data['posts'] = $this->posts_model->get_posts(5, FALSE);
		$data['total_posts'] = $this->posts_model->get_posts(NULL, 0, FALSE);
		$data['pages'] = $this->settings_model->get_pages(9);
		$data['daily_logins'] = $this->user_model->daily_logins($this->session->userdata('user_id'));

		$data['user_programs'] = $this->programs_model->get_user_programs($this->session->userdata('user_id'));

		$this->load->view('templates/header', $data);
        $this->load->view('templates/nav', $data);
		$this->load->view('pages/index', $data);
		$this->load->view('templates/footer');
		$this->load->view('templates/scripts');
	}

	public function about(){
		$page = 'about';
		$data['title'] = ucfirst($page);
		$data['settings'] = $this->settings_model->get_settings();
		$data['my_id'] = $this->session->userdata('user_id');
		$data['music_status'] = $this->user_model->get_music_status($this->session->userdata('user_id'));
		$data['unseen_chat'] = $this->messages_model->total_message_unseen($this->session->userdata('user_id'));
		$data['pages'] = $this->settings_model->get_pages(7);

		$this->load->view('templates/header', $data);
        $this->load->view('templates/nav', $data);
		$this->load->view('pages/'.$page, $data);
		$this->load->view('templates/footer');
		$this->load->view('templates/scripts');
	}

	public function faq(){
		$page = 'Questions and Answers';
		$data['title'] = ucwords($page);
		$data['settings'] = $this->settings_model->get_settings();
		$data['my_id'] = $this->session->userdata('user_id');
		$data['music_status'] = $this->user_model->get_music_status($this->session->userdata('user_id'));
		$data['unseen_chat'] = $this->messages_model->total_message_unseen($this->session->userdata('user_id'));
		$data['pages'] = $this->settings_model->get_pages(1);
		$data['faqs'] = $this->faq_model->get_portal_faqs();
		$data['categories'] = $this->faq_model->get_categories();

		$this->load->view('templates/header', $data);
        $this->load->view('templates/nav', $data);
		$this->load->view('pages/q&a', $data);
		$this->load->view('templates/footer');
		$this->load->view('templates/scripts');
	}

	public function terms_and_conditions(){
		$page = 'terms and conditions';
		$data['title'] = ucwords($page);
		$data['settings'] = $this->settings_model->get_settings();
		$data['my_id'] = $this->session->userdata('user_id');
		$data['music_status'] = $this->user_model->get_music_status($this->session->userdata('user_id'));
		$data['unseen_chat'] = $this->messages_model->total_message_unseen($this->session->userdata('user_id'));
		$data['pages'] = $this->settings_model->get_pages(5);

		$this->load->view('templates/header', $data);
        $this->load->view('templates/nav', $data);
		$this->load->view('pages/terms-and-conditions', $data);
		$this->load->view('templates/footer');
		$this->load->view('templates/scripts');
	}

	public function privacy_policy(){
		$page = 'privacy policy';
		$data['title'] = ucwords($page);
		$data['settings'] = $this->settings_model->get_settings();
		$data['my_id'] = $this->session->userdata('user_id');
		$data['music_status'] = $this->user_model->get_music_status($this->session->userdata('user_id'));
		$data['unseen_chat'] = $this->messages_model->total_message_unseen($this->session->userdata('user_id'));
		$data['pages'] = $this->settings_model->get_pages(6);

		$this->load->view('templates/header', $data);
        $this->load->view('templates/nav', $data);
		$this->load->view('pages/privacy-policy', $data);
		$this->load->view('templates/footer');
		$this->load->view('templates/scripts');
	}

	public function rankings(){
		$page = 'rankings';
		$data['title'] = ucfirst($page);
		$data['settings'] = $this->settings_model->get_settings();
		$data['my_id'] = $this->session->userdata('user_id');
		$data['music_status'] = $this->user_model->get_music_status($this->session->userdata('user_id'));
		$data['unseen_chat'] = $this->messages_model->total_message_unseen($this->session->userdata('user_id'));
		$data['pages'] = $this->settings_model->get_pages(4);
		$data['ranks'] = $this->user_model->get_rank_list();
		$data['levels'] = $this->user_model->get_level_list();
		$data['rankings'] = $this->user_model->rankings();

		$this->load->view('templates/header', $data);
        $this->load->view('templates/nav', $data);
		$this->load->view('pages/'.$page, $data);
		$this->load->view('templates/footer');
		$this->load->view('templates/scripts');
	}

	public function dictionary(){
		$page = 'dictionary';
		$data['title'] = ucfirst($page);
		$data['settings'] = $this->settings_model->get_settings();
		$data['my_id'] = $this->session->userdata('user_id');
		$data['music_status'] = $this->user_model->get_music_status($this->session->userdata('user_id'));
		$data['unseen_chat'] = $this->messages_model->total_message_unseen($this->session->userdata('user_id'));
		$data['pages'] = $this->settings_model->get_pages(2);

		$this->load->view('templates/header', $data);
        $this->load->view('templates/nav', $data);
		$this->load->view('pages/'.$page, $data);
		$this->load->view('templates/footer');
		$this->load->view('templates/scripts');
	}

	public function leaderboard(){
		$page = 'leaderboard';
		$data['title'] = ucfirst($page);
		$data['settings'] = $this->settings_model->get_settings();
		$data['my_id'] = $this->session->userdata('user_id');
		$data['music_status'] = $this->user_model->get_music_status($this->session->userdata('user_id'));
		$data['unseen_chat'] = $this->messages_model->total_message_unseen($this->session->userdata('user_id'));

		$this->load->view('templates/header', $data);
        $this->load->view('templates/nav', $data);
		$this->load->view('pages/'.$page, $data);
		$this->load->view('templates/footer');
		$this->load->view('templates/scripts');
	}

	public function customer_support(){
		$page = 'help';
		$data['title'] = ucfirst($page);
		$this->load->view('pages/'.$page, $data);
		$this->load->view('templates/scripts');
	}

	public function support(){
		$page = 'support';
		$data['title'] = ucfirst($page);
		$data['settings'] = $this->settings_model->get_settings();
		$data['my_id'] = $this->session->userdata('user_id');
		$data['music_status'] = $this->user_model->get_music_status($this->session->userdata('user_id'));
		$data['unseen_chat'] = $this->messages_model->total_message_unseen($this->session->userdata('user_id'));

		$this->load->view('templates/header', $data);
        $this->load->view('templates/nav', $data);
		$this->load->view('pages/'.$page, $data);
		$this->load->view('templates/footer');
		$this->load->view('templates/scripts');
	}

	public function my_profile(){
		$page = 'profile';
		$data['title'] = ucfirst($page);
		$data['settings'] = $this->settings_model->get_settings();
		$data['my_info'] = $this->user_model->get_users($this->session->userdata('email'));
		$data['my_rank'] = $this->user_model->get_user_by_id($this->session->userdata('user_id'));
		$data['unseen_chat'] = $this->messages_model->total_message_unseen($this->session->userdata('user_id'));
		$data['music_status'] = $this->user_model->get_music_status($this->session->userdata('user_id'));
		$data['histories'] = $this->user_model->users_all_videos_watched($this->session->userdata('user_id'));
		$data['my_id'] = $this->session->userdata('user_id');
		$data['my_notes'] = $this->user_model->get_notes($this->session->userdata('user_id'));

		$data['posts'] = $this->posts_model->get_posts(5, 0, $this->session->userdata('user_id'));

		$this->load->view('templates/header', $data);
        $this->load->view('templates/nav', $data);
		$this->load->view('pages/'.$page, $data);
		$this->load->view('templates/footer');
		$this->load->view('templates/scripts');
	}

	public function view_profile($id){
		$page = 'profile';
		$data['title'] = ucfirst($page);
		$data['settings'] = $this->settings_model->get_settings();
		$data['unseen_chat'] = $this->messages_model->total_message_unseen($this->session->userdata('user_id'));
		$data['music_status'] = $this->user_model->get_music_status($this->session->userdata('user_id'));
		$data['my_info'] = $this->user_model->get_users($id);
		$data['my_rank'] = $this->user_model->get_user_by_id($id);
		$data['my_id'] = $this->session->userdata('user_id');

		$data['posts'] = $this->posts_model->get_posts(5, 0, $id);

		$this->load->view('templates/header', $data);
        $this->load->view('templates/nav', $data);
		$this->load->view('pages/'.$page, $data);
		$this->load->view('templates/footer');
		$this->load->view('templates/scripts');
	}

	public function updates(){
		$page = 'modules';
		$data['title'] = ucfirst($page);
		$data['settings'] = $this->settings_model->get_settings();
		$data['my_id'] = $this->session->userdata('user_id');
		$data['music_status'] = $this->user_model->get_music_status($this->session->userdata('user_id'));
		$data['unseen_chat'] = $this->messages_model->total_message_unseen($this->session->userdata('user_id'));
		$data['all'] = $this->course_model->get_all(FALSE, FALSE, $this->session->userdata('user_id'));
		$data['last_watched'] = $this->user_model->last_watched($this->session->userdata('user_id'));
		
		$this->load->view('templates/header', $data);
        $this->load->view('templates/nav', $data);
		$this->load->view('pages/section_updates', $data);
		$this->load->view('templates/footer');
		$this->load->view('templates/scripts');
	}

	public function modules($slug){
		$page = 'modules';
		$data['title'] = ucfirst($page);
		$data['settings'] = $this->settings_model->get_settings();
		$data['my_id'] = $this->session->userdata('user_id');
		$data['music_status'] = $this->user_model->get_music_status($this->session->userdata('user_id'));
		$data['unseen_chat'] = $this->messages_model->total_message_unseen($this->session->userdata('user_id'));
		$data['all'] = $this->course_model->get_all(FALSE, FALSE, $this->session->userdata('user_id'));
		$data['last_watched'] = $this->user_model->last_watched($this->session->userdata('user_id'));
		$data['slug'] = $slug;
		$data['courses'] = $this->course_model->search_course($slug, $this->input->post('search'), $this->session->userdata('user_id'));
		$data['sections'] = $this->course_model->search_section($slug, $this->input->post('search'), $this->session->userdata('user_id'));

		$this->load->view('templates/header', $data);
        $this->load->view('templates/nav', $data);
		$this->load->view('pages/modules', $data);
		$this->load->view('templates/footer');
		$this->load->view('templates/scripts');
	}

	public function search(){
		$page = 'modules';
		$data['title'] = ucfirst($page);
		$data['settings'] = $this->settings_model->get_settings();
		$data['my_id'] = $this->session->userdata('user_id');
		$data['music_status'] = $this->user_model->get_music_status($this->session->userdata('user_id'));
		$data['unseen_chat'] = $this->messages_model->total_message_unseen($this->session->userdata('user_id'));
		$data['last_watched'] = $this->user_model->last_watched($this->session->userdata('user_id'));
		$data['courses'] = $this->course_model->search_course(NULL, $this->input->post('search'), $this->session->userdata('user_id'));
		$data['sections'] = $this->course_model->search_section(NULL, $this->input->post('search'), $this->session->userdata('user_id'));
		$data['lessons'] = $this->course_model->search_lesson(NULL, $this->input->post('search'), $this->session->userdata('user_id'));
		$data['contents'] = $this->course_model->search_content(NULL, $this->input->post('search'), $this->session->userdata('user_id'));

		$data['faqs'] = $this->faq_model->search_faqs($this->input->post('search'));
		$data['categories'] = $this->faq_model->search_categories($this->input->post('search'));
		$data['all_faqs'] = $this->faq_model->get_portal_faqs();

		$this->load->view('templates/header', $data);
        $this->load->view('templates/nav', $data);
		$this->load->view('pages/search', $data);
		$this->load->view('templates/footer');
		$this->load->view('templates/scripts');
	}

	public function section($slug, $course_slug, $section_slug){
		$page = 'section';
		$data['title'] = ucfirst($page);
		$data['settings'] = $this->settings_model->get_settings();
		$data['my_id'] = $this->session->userdata('user_id');
		$data['unseen_chat'] = $this->messages_model->total_message_unseen($this->session->userdata('user_id'));
		if($section_slug == NULL){
			 show_404();
		}
		$data['slug'] = $slug;
		$data['courses'] = $this->course_model->get_course_content($course_slug);
		$data['sections'] = $this->course_model->get_section_by_slug($section_slug);
		$data['lessons'] = $this->course_model->get_lesson($data['sections']['id']);
		$data['contents'] = $this->course_model->get_content();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/nav', $data);
		$this->load->view('pages/section', $data);
		$this->load->view('templates/footer');
		$this->load->view('templates/scripts');
	}

	public function products(){
		$page = 'products';
		$data['title'] = ucfirst($page);
		$data['settings'] = $this->settings_model->get_settings();
		$data['my_id'] = $this->session->userdata('user_id');
		$data['unseen_chat'] = $this->messages_model->total_message_unseen($this->session->userdata('user_id'));

		$data['products'] = $this->product_model->get_all_products(NULL, 12, FALSE);
		$data['categories'] = $this->product_model->get_categories();
		$data['images'] = $this->product_model->get_images();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/nav', $data);
		$this->load->view('pages/products', $data);
		$this->load->view('templates/footer');
		$this->load->view('templates/scripts');
	}

	public function products_categories($category_slug){
		if($category_slug == 'all'){
			redirect('rated-products');
		}
		$page = 'products';
		$data['title'] = ucfirst($page);
		$data['settings'] = $this->settings_model->get_settings();
		$data['my_id'] = $this->session->userdata('user_id');
		$data['unseen_chat'] = $this->messages_model->total_message_unseen($this->session->userdata('user_id'));
		$data['category_name'] = $this->product_model->get_categories($category_slug);
		$data['products'] = $this->product_model->get_all_products(NULL, NULL, FALSE);
		$data['product_categories'] = $this->product_model->get_categories_products($category_slug);
		$data['images'] = $this->product_model->get_images();
		$data['categories'] = $this->product_model->get_categories();
		$data['category_slug'] = $category_slug;

		$this->load->view('templates/header', $data);
		$this->load->view('templates/nav', $data);
		$this->load->view('pages/products', $data);
		$this->load->view('templates/footer');
		$this->load->view('templates/scripts');
	}

	public function tools(){
		$page = 'tools';
		$data['title'] = ucfirst($page);
		$data['settings'] = $this->settings_model->get_settings();
		$data['my_id'] = $this->session->userdata('user_id');
		$data['music_status'] = $this->user_model->get_music_status($this->session->userdata('user_id'));
		$data['unseen_chat'] = $this->messages_model->total_message_unseen($this->session->userdata('user_id'));

		$data['products'] = $this->product_model->get_all_products(NULL, 12, FALSE);
		$data['categories'] = $this->product_model->get_categories();
		$data['images'] = $this->product_model->get_images();

		$this->load->view('templates/header', $data);
        $this->load->view('templates/nav', $data);
		$this->load->view('pages/tools', $data);
		$this->load->view('templates/footer');
		$this->load->view('templates/scripts');
	}

	public function login(){
		$page = 'login';
		$data['title'] = ucfirst($page);
		$data['settings'] = $this->settings_model->get_settings();
		$data['my_id'] = $this->session->userdata('user_id');
		$this->form_validation->set_error_delimiters('<script type="text/javascript">$(function(){toastr.error("', '")});</script>');
        $this->form_validation->set_rules('email', 'email', 'required');
        $this->form_validation->set_rules('password', 'password', 'required');

        if($this->form_validation->run() === FALSE){
	        $this->load->view('pages/'.$page, $data);
        } else {
            $password = $this->input->post('password');
            $user = $this->user_model->get_users($this->input->post('email'));

            $user_id = $this->user_model->login($this->input->post('email'), $password);
            if($user_id['status'] == '2'){
            	$this->session->set_flashdata('error', 'Your account has been disabled!');
                redirect('login');
            }
            if($user_id){
                $user_data = array(
                    'user_id' => $user_id['id'],
                    'email' => $user_id['email'],
                    'first_name' => $user_id['first_name'],
                    'last_name' => $user_id['last_name'],
                    'user_logged_in' => true
                );
                $this->session->set_userdata($user_data);
                $this->user_model->start_daily_login_reward($user_id['id']);
	 			if($user_id['status'] == '0' || $password == 'studying'){
	                redirect('update-profile');
	            }
                $this->session->set_flashdata('success', 'You are now logged in');
                redirect(base_url());
            } else {
                $this->session->set_flashdata('error', 'Invalid Email/Password');
                redirect('login');
            }       
        }
	}

	public function update_profile(){
		$page = 'Update Profile';
		$data['title'] = ucwords($page);
		$data['my_info'] = $this->user_model->get_users($this->session->userdata('email'));
		
        $this->load->view('pages/update-profile', $data);
        $this->load->view('templates/scripts');
	}

	public function forgot_password(){
		$page = 'Update Profile';
		$data['title'] = ucwords($page);
        $this->load->view('pages/forgot-password', $data);
        $this->load->view('templates/scripts');
	}

	public function verification(){
		$page = 'verify';
		$data['title'] = ucwords($page);
		$data['email_verify'] = $this->session->userdata('email_verify');

        $this->load->view('pages/verify', $data);
        $this->load->view('templates/scripts');
	}

	public function logout(){
		$this->user_model->logout($this->session->userdata('email'));
        $this->session->unset_userdata('user_logged_in');
        $this->session->unset_userdata($user_data);
        $this->session->set_flashdata('success', 'You are now logged out');
        redirect('login');
	}

	function rating(){
		$create = $this->user_model->check_rate($this->session->userdata('email'));
		if($create['total'] == 0){
			$data = array(
				'status' => true
			);
		} else {
			$data = array(
				'status' => false
			);
		}
        echo json_encode($data);
	}

	function send_rating(){
		$create = $this->user_model->send_rating($this->session->userdata('email'), $this->input->post('feedback_rating'), $this->input->post('feedback'));
		$this->session->set_flashdata('success', 'Thank You for your feedback. :)');
		if(!empty($this->input->post('rating_page'))){
			redirect(base_url());
		} else {
			$this->logout();
		}
	}

	function music(){
		$status = $this->input->post('id');
		$create = $this->user_model->music_status($this->session->userdata('email'), $status);
		echo json_encode($status);
	}

	function check_purchase($slug){
		$course = $this->course_model->get_course_content($slug);
		$purchases = $this->programs_model->get_user_purchases($course['id']);
		if($course['id'] != $purchases['course_ID']){
 			$data = array(
	            'is_my_purchase' => false
	        );
		}
      	$this->output->set_header('Content-type: application/json');
        $this->output->set_output(json_encode($data));
	}
}