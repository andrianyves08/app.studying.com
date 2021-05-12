<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->library('upload');
	}

	function changetimefromUTC($time, $timezone) {
	    $changetime = new DateTime($time, new DateTimeZone('UTC'));
	    $changetime->setTimezone(new DateTimeZone($timezone));
	    return $changetime->format('M j, Y h:i A');
	}

	function timezone()	{
		$timezones = array(
		    'Pacific/Midway'       => "-11",
		    'US/Hawaii'            => "-10",
		    'US/Alaska'            => "-9",
		    'US/Pacific'           => "-8",
		    'US/Arizona'           => "-7",
		    'America/Mexico_City'  => "-6",
		    'US/Eastern'           => "-5",
		    'America/Caracas'      => "-4.5",
		    'Canada/Newfoundland'  => "-3.5",
		    'America/Buenos_Aires' => "-3",
		    'Atlantic/Stanley'     => "-2",
		    'Atlantic/Azores'      => "-1",
		    'Europe/London'        => "0",
		    'Europe/Amsterdam'     => "1",
		    'Europe/Athens'        => "2",
		    'Asia/Baghdad'         => "3",
		    'Asia/Tehran'          => "3.5",
		    'Asia/Baku'            => "4",
		    'Asia/Kabul'           => "4.5",
		    'Asia/Karachi'         => "5",
		    'Asia/Kolkata'         => "5.5",
		    'Asia/Kathmandu'       => "5.75",
		    'Asia/Yekaterinburg'   => "6",
		    'Asia/Bangkok'         => "7",
		    'Asia/Hong_Kong'       => "8",
		    'Asia/Tokyo'           => "9",
		    'Australia/Adelaide'   => "9.5",
		    'Australia/Sydney'     => "10",
		    'Asia/Vladivostok'     => "11",
		    'Pacific/Auckland'     => "12",
		);
		$timezone = array_search($this->input->post('timezone'), $timezones);
		$this->user_model->insert_timezone($timezone, $this->session->userdata('user_id'));
		$this->session->set_userdata('timezone', $timezone);
	}

	public function user_status(){
		$settings = $this->settings_model->get_settings();

		// Check if the admin account is also logged-in in order to use the system even if its undermaintenance.
		if($this->session->userdata('user_logged_in') || $this->session->userdata('admin_logged_in')){
			// if($this->session->userdata('admin_id') == 13){
			$user = TRUE;
			// } else {
			// 	$user = FALSE;
			// }
		} else {
			$user = FALSE;
		}
		
		// a = admin
	 	$data = array(
            'isLoggedIn' => $user,
            'fn' => ucwords($this->session->userdata('first_name')),
			'ln' => ucwords($this->session->userdata('last_name')),
			'status' => $settings['system_status'],
			'a' => $this->session->userdata('admin_logged_in'),
        );

      	$this->output->set_header('Content-type: application/json');
        $this->output->set_output(json_encode($data));
	}

	public function maintenance(){
		$page = 'maintenance';
		$data['title'] = ucfirst($page);

		$settings = $this->settings_model->get_settings();
		if($settings['system_status'] == 1){
			redirect(base_url());
		}

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
		$data['my_purchases'] = $this->programs_model->get_user_programs($this->session->userdata('user_id'));
		$data['my_id'] = $this->session->userdata('user_id');
		$data['music_status'] = $this->user_model->get_music_status($this->session->userdata('user_id'));
		$data['unseen_chat'] = $this->messages_model->total_message_unseen($this->session->userdata('user_id'));
		$data['last_watched'] = $this->user_model->last_watched($this->session->userdata('user_id'));
		$data['rankings'] = $this->user_model->rankings(10); 
		$data['all'] = $this->course_model->get_all(3, 0, $this->session->userdata('user_id'));
		$data['success_stories'] = $this->course_model->get_content_content(7);
		$data['first_video'] = $this->course_model->get_content_content(5);
		$data['my_info'] = $this->user_model->get_users($this->session->userdata('user_id'));
		$data['posts'] = $this->posts_model->get_posts(4, FALSE);
		$data['total_posts'] = $this->posts_model->get_posts(NULL, 0, FALSE);
		$data['pages'] = $this->settings_model->get_pages(9);
		$data['daily_logins'] = $this->user_model->daily_logins($this->session->userdata('user_id'));
		$data['users'] = $this->user_model->get_users();
		$data['user_programs'] = $this->programs_model->get_user_programs($this->session->userdata('user_id'));
		$data['comments'] = $this->posts_model->get_comments();

		if((date('j') - date('j', strtotime($data['daily_logins']['timestamp']))) > 1 ){
			$this->user_model->reset_login_streak($this->session->userdata('user_id'));
		}
		
		if(!$this->session->userdata('timezone')){
			$data['timezone'] = 'UTC';
		} else {
			$data['timezone'] = $this->session->userdata('timezone');
		}

		$this->load->view('templates/header', $data);
        $this->load->view('templates/nav', $data);
		$this->load->view('pages/index', $data);
		$this->load->view('templates/footer');
		$this->load->view('templates/scripts');
	}

	public function messages(){
		$page = 'messages';
		$data['title'] = ucfirst($page);
		$data['settings'] = $this->settings_model->get_settings();
		$data['my_info'] = $this->user_model->get_users($this->session->userdata('user_id'));
		$data['next_level'] = $this->user_model->next_level($data['my_info']['level']);
		$data['music_status'] = $this->user_model->get_music_status($this->session->userdata('user_id'));
		$data['unseen_chat'] = $this->messages_model->total_message_unseen($this->session->userdata('user_id'));
		$data['all_users']  = $this->messages_model->all_users();
		$data['my_id'] = $this->session->userdata('user_id');
		$data['my_purchases'] = $this->programs_model->get_user_programs($this->session->userdata('user_id'));

		if(!$this->session->userdata('timezone')){
			$data['timezone'] = 'UTC';
		} else {
			$data['timezone'] = $this->session->userdata('timezone');
		}

		$this->load->view('templates/header', $data);
        $this->load->view('templates/nav', $data);
		$this->load->view('pages/'.$page, $data);
		$this->load->view('templates/footer');
		$this->load->view('templates/scripts');
	}

	public function about(){
		$page = 'about';
		$data['title'] = ucfirst($page);
		$data['settings'] = $this->settings_model->get_settings();
		$data['my_purchases'] = $this->programs_model->get_user_programs($this->session->userdata('user_id'));
		$data['my_id'] = $this->session->userdata('user_id');
		$data['music_status'] = $this->user_model->get_music_status($this->session->userdata('user_id'));
		$data['unseen_chat'] = $this->messages_model->total_message_unseen($this->session->userdata('user_id'));
		$data['pages'] = $this->settings_model->get_pages(7);
		$data['my_info'] = $this->user_model->get_users($this->session->userdata('user_id'));

		if(!$this->session->userdata('timezone')){
			$data['timezone'] = 'UTC';
		} else {
			$data['timezone'] = $this->session->userdata('timezone');
		}

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
		$data['my_purchases'] = $this->programs_model->get_user_programs($this->session->userdata('user_id'));
		$data['my_id'] = $this->session->userdata('user_id');
		$data['music_status'] = $this->user_model->get_music_status($this->session->userdata('user_id'));
		$data['unseen_chat'] = $this->messages_model->total_message_unseen($this->session->userdata('user_id'));
		$data['pages'] = $this->settings_model->get_pages(1);
		$data['faqs'] = $this->faq_model->get_portal_faqs();
		$data['categories'] = $this->faq_model->get_categories();
		$data['my_info'] = $this->user_model->get_users($this->session->userdata('user_id'));

		if(!$this->session->userdata('timezone')){
			$data['timezone'] = 'UTC';
		} else {
			$data['timezone'] = $this->session->userdata('timezone');
		}

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
		$data['my_purchases'] = $this->programs_model->get_user_programs($this->session->userdata('user_id'));
		$data['my_id'] = $this->session->userdata('user_id');
		$data['music_status'] = $this->user_model->get_music_status($this->session->userdata('user_id'));
		$data['unseen_chat'] = $this->messages_model->total_message_unseen($this->session->userdata('user_id'));
		$data['pages'] = $this->settings_model->get_pages(5);
		$data['my_info'] = $this->user_model->get_users($this->session->userdata('user_id'));

		if(!$this->session->userdata('timezone')){
			$data['timezone'] = 'UTC';
		} else {
			$data['timezone'] = $this->session->userdata('timezone');
		}

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
		$data['my_purchases'] = $this->programs_model->get_user_programs($this->session->userdata('user_id'));
		$data['my_id'] = $this->session->userdata('user_id');
		$data['music_status'] = $this->user_model->get_music_status($this->session->userdata('user_id'));
		$data['unseen_chat'] = $this->messages_model->total_message_unseen($this->session->userdata('user_id'));
		$data['pages'] = $this->settings_model->get_pages(6);
		$data['my_info'] = $this->user_model->get_users($this->session->userdata('user_id'));

		if(!$this->session->userdata('timezone')){
			$data['timezone'] = 'UTC';
		} else {
			$data['timezone'] = $this->session->userdata('timezone');
		}

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
		$data['my_purchases'] = $this->programs_model->get_user_programs($this->session->userdata('user_id'));
		$data['my_id'] = $this->session->userdata('user_id');
		$data['music_status'] = $this->user_model->get_music_status($this->session->userdata('user_id'));
		$data['unseen_chat'] = $this->messages_model->total_message_unseen($this->session->userdata('user_id'));
		$data['pages'] = $this->settings_model->get_pages(4);
		$data['ranks'] = $this->user_model->get_rank_list();
		$data['levels'] = $this->user_model->get_level_list();
		$data['rankings'] = $this->user_model->rankings();
		$data['my_info'] = $this->user_model->get_users($this->session->userdata('user_id'));

		if(!$this->session->userdata('timezone')){
			$data['timezone'] = 'UTC';
		} else {
			$data['timezone'] = $this->session->userdata('timezone');
		}

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
		$data['my_purchases'] = $this->programs_model->get_user_programs($this->session->userdata('user_id'));
		$data['my_id'] = $this->session->userdata('user_id');
		$data['music_status'] = $this->user_model->get_music_status($this->session->userdata('user_id'));
		$data['unseen_chat'] = $this->messages_model->total_message_unseen($this->session->userdata('user_id'));
		$data['pages'] = $this->settings_model->get_pages(2);
		$data['my_info'] = $this->user_model->get_users($this->session->userdata('user_id'));

		if(!$this->session->userdata('timezone')){
			$data['timezone'] = 'UTC';
		} else {
			$data['timezone'] = $this->session->userdata('timezone');
		}

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
		$data['my_purchases'] = $this->programs_model->get_user_programs($this->session->userdata('user_id'));
		$data['my_id'] = $this->session->userdata('user_id');
		$data['music_status'] = $this->user_model->get_music_status($this->session->userdata('user_id'));
		$data['unseen_chat'] = $this->messages_model->total_message_unseen($this->session->userdata('user_id'));
		$data['my_info'] = $this->user_model->get_users($this->session->userdata('user_id'));

		if(!$this->session->userdata('timezone')){
			$data['timezone'] = 'UTC';
		} else {
			$data['timezone'] = $this->session->userdata('timezone');
		}

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
		$data['my_purchases'] = $this->programs_model->get_user_programs($this->session->userdata('user_id'));
		$data['my_id'] = $this->session->userdata('user_id');
		$data['music_status'] = $this->user_model->get_music_status($this->session->userdata('user_id'));
		$data['unseen_chat'] = $this->messages_model->total_message_unseen($this->session->userdata('user_id'));
		$data['my_info'] = $this->user_model->get_users($this->session->userdata('user_id'));

		if(!$this->session->userdata('timezone')){
			$data['timezone'] = 'UTC';
		} else {
			$data['timezone'] = $this->session->userdata('timezone');
		}

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
		$data['my_purchases'] = $this->programs_model->get_user_programs($this->session->userdata('user_id'));
		$data['my_info'] = $this->user_model->get_users($this->session->userdata('user_id'));
		$data['my_rank'] = $this->user_model->get_user_by_id($this->session->userdata('user_id'));
		$data['unseen_chat'] = $this->messages_model->total_message_unseen($this->session->userdata('user_id'));
		$data['music_status'] = $this->user_model->get_music_status($this->session->userdata('user_id'));
		$data['histories'] = $this->user_model->users_all_videos_watched($this->session->userdata('user_id'));
		$data['my_id'] = $this->session->userdata('user_id');
		$data['my_notes'] = $this->user_model->get_notes($this->session->userdata('user_id'));

		$data['posts'] = $this->posts_model->get_posts(5, 0, $this->session->userdata('user_id'));

		$data['count_posts'] = $this->user_model->count_posts($this->session->userdata('user_id'));
		$data['count_followers'] = $this->user_model->count_followers($this->session->userdata('user_id'));
		$data['count_following'] = $this->user_model->count_following($this->session->userdata('user_id'));

		$data['users'] = $this->user_model->get_users();
		$data['comments'] = $this->posts_model->get_comments();

		if(!$this->session->userdata('timezone')){
			$data['timezone'] = 'UTC';
		} else {
			$data['timezone'] = $this->session->userdata('timezone');
		}

		$this->load->view('templates/header', $data);
        $this->load->view('templates/nav', $data);
		$this->load->view('pages/'.$page, $data);
		$this->load->view('templates/footer');
		$this->load->view('templates/scripts');
	}

	public function view_profile($id){
		$page = 'user profile';
		if($this->session->userdata('user_id') == $id){
			redirect('my-profile');
		}
		$data['title'] = ucfirst($page);
		$data['settings'] = $this->settings_model->get_settings();
		$data['my_purchases'] = $this->programs_model->get_user_programs($this->session->userdata('user_id'));
		$data['unseen_chat'] = $this->messages_model->total_message_unseen($this->session->userdata('user_id'));
		$data['music_status'] = $this->user_model->get_music_status($this->session->userdata('user_id'));
		$data['my_info'] = $this->user_model->get_users($id);
		$data['my_rank'] = $this->user_model->get_user_by_id($id);
		$data['my_id'] = $this->session->userdata('user_id');

		$data['posts'] = $this->posts_model->get_posts(5, 0, $id);

		$data['count_posts'] = $this->user_model->count_posts($id);
		$data['count_followers'] = $this->user_model->count_followers($id);
		$data['count_following'] = $this->user_model->count_following($id);

		$data['is_following'] = $this->user_model->is_following($id, $this->session->userdata('user_id'));
		$data['comments'] = $this->posts_model->get_comments();

		$data['users'] = $this->user_model->get_users();

		if(!$this->session->userdata('timezone')){
			$data['timezone'] = 'UTC';
		} else {
			$data['timezone'] = $this->session->userdata('timezone');
		}

		$this->load->view('templates/header', $data);
        $this->load->view('templates/nav', $data);
		$this->load->view('pages/profile', $data);
		$this->load->view('templates/footer');
		$this->load->view('templates/scripts');
	}

	public function updates(){
		$page = 'modules';
		$data['title'] = ucfirst($page);
		$data['settings'] = $this->settings_model->get_settings();
		$data['my_purchases'] = $this->programs_model->get_user_programs($this->session->userdata('user_id'));
		$data['my_id'] = $this->session->userdata('user_id');
		$data['music_status'] = $this->user_model->get_music_status($this->session->userdata('user_id'));
		$data['unseen_chat'] = $this->messages_model->total_message_unseen($this->session->userdata('user_id'));
		$data['all'] = $this->course_model->get_all(FALSE, FALSE, $this->session->userdata('user_id'));
		$data['last_watched'] = $this->user_model->last_watched($this->session->userdata('user_id'));
		$data['my_info'] = $this->user_model->get_users($this->session->userdata('user_id'));

		if(!$this->session->userdata('timezone')){
			$data['timezone'] = 'UTC';
		} else {
			$data['timezone'] = $this->session->userdata('timezone');
		}
		
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
		$data['my_purchases'] = $this->programs_model->get_user_programs($this->session->userdata('user_id'));
		$data['my_id'] = $this->session->userdata('user_id');
		$data['music_status'] = $this->user_model->get_music_status($this->session->userdata('user_id'));
		$data['unseen_chat'] = $this->messages_model->total_message_unseen($this->session->userdata('user_id'));
		$data['all'] = $this->course_model->get_all(FALSE, FALSE, $this->session->userdata('user_id'));
		$data['last_watched'] = $this->user_model->last_watched($this->session->userdata('user_id'));
		$data['slug'] = $slug;
		$data['courses'] = $this->course_model->search_course($slug, $this->input->post('search'), $this->session->userdata('user_id'));
		$data['sections'] = $this->course_model->search_section($slug, $this->input->post('search'), $this->session->userdata('user_id'));
		$data['my_info'] = $this->user_model->get_users($this->session->userdata('user_id'));

		if(!$this->session->userdata('timezone')){
			$data['timezone'] = 'UTC';
		} else {
			$data['timezone'] = $this->session->userdata('timezone');
		}

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
		$data['my_purchases'] = $this->programs_model->get_user_programs($this->session->userdata('user_id'));
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
		$data['blogs'] = $this->resources_model->search_resources($this->input->post('search'));
		$data['total_results'] = count($data['courses']) + count($data['sections']) + count($data['lessons']) + count($data['contents']) + count($data['faqs']) + count($data['blogs']);
		$data['my_info'] = $this->user_model->get_users($this->session->userdata('user_id'));

		if(!$this->session->userdata('timezone')){
			$data['timezone'] = 'UTC';
		} else {
			$data['timezone'] = $this->session->userdata('timezone');
		}

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
		$data['my_purchases'] = $this->programs_model->get_user_programs($this->session->userdata('user_id'));
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
		$data['my_info'] = $this->user_model->get_users($this->session->userdata('user_id'));

		$data['my_ratings'] = $this->course_model->get_content_ratings($this->session->userdata('user_id'));

		if(!$this->session->userdata('timezone')){
			$data['timezone'] = 'UTC';
		} else {
			$data['timezone'] = $this->session->userdata('timezone');
		}

		$this->load->view('templates/header', $data);
		$this->load->view('templates/nav', $data);
		$this->load->view('pages/section', $data);
		$this->load->view('templates/footer');
		$this->load->view('templates/scripts');
	}

	public function tools(){
		$page = 'tools';
		$data['title'] = ucfirst($page);
		$data['settings'] = $this->settings_model->get_settings();
		$data['my_purchases'] = $this->programs_model->get_user_programs($this->session->userdata('user_id'));
		$data['my_id'] = $this->session->userdata('user_id');
		$data['music_status'] = $this->user_model->get_music_status($this->session->userdata('user_id'));
		$data['unseen_chat'] = $this->messages_model->total_message_unseen($this->session->userdata('user_id'));

		$data['products'] = $this->rated_product_model->search_products(NULL, 12, $this->input->post('tools'));
		$data['images'] = $this->rated_product_model->get_images();

		$data['product_name'] = $this->input->post('tools');
		$data['my_info'] = $this->user_model->get_users($this->session->userdata('user_id'));

		if(!$this->session->userdata('timezone')){
			$data['timezone'] = 'UTC';
		} else {
			$data['timezone'] = $this->session->userdata('timezone');
		}

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
		$data['my_purchases'] = $this->programs_model->get_user_programs($this->session->userdata('user_id'));
		$data['my_id'] = $this->session->userdata('user_id');

		$settings = $this->settings_model->get_settings();
		if($settings['system_status'] == 0){
			redirect('maintenance');
		}

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
        $this->session->sess_destroy();
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