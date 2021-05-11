<?php
	class User_model extends CI_Model {

    public function __construct(){
        $this->load->database();
        //$this->db2 = $this->load->database('opencart', TRUE);
    }
   
    function verify($email, $verification_code){
		$this->db->where('email', strtolower($email));
		$this->db->order_by('timestamp', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get('users_verify_email');

		$result = $query->row_array();
		if(!empty($result) && password_verify($verification_code, $result['verification_code'])){
			$hashed_password = password_hash('studying', PASSWORD_DEFAULT);
			$this->db->set('password', $hashed_password);
			$this->db->where('email', strtolower($email));
			$this->db->update('users');

			return $query->row_array();
		} else {
			return false;
		}
	}

	function create_verification($email, $verification_code){
		$hashed_verifcation = password_hash($verification_code, PASSWORD_DEFAULT);
    	$data = array(
			'email' => strtolower($email),
			'verification_code' => $hashed_verifcation
		);
		$this->db->insert('users_verify_email', $data);
	}

    function music_status($email, $status){
    	$this->db->set('music_status', $status);
		$this->db->where('email', $email);
		return $this->db->update('users');
	}

	public function login($email, $password){
		$this->db->where('email', strtolower($email));
		$query = $this->db->get('users');
		$result = $query->row_array();
		if($result['status'] == '0'){
			return $query->row_array();
		} else {
			if(!empty($result) && password_verify($password, $result['password'])){
				$this->db->set('last_login', 'NOW()', FALSE);
				$this->db->set('login_status', '1');
				$this->db->set('music_status', '1');
				$this->db->where('email', strtolower($email));
				$this->db->update('users');

				return $query->row_array();
			} else {
				return false;
			}
		}
	}

	public function get_rank_list(){
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get('level');
		return $query->result_array();
	}

	public function get_level_list(){
		$query = $this->db->get('users_level');
		return $query->result_array();
	}

	public function logout($email){
		$this->db->set('login_status', '0');
		$this->db->where('email', strtolower($email));
		$this->db->update('users');
	}

	public function get_users($email = FALSE){
		if($email === FALSE){
			$query = $this->db->get('users');
			return $query->result_array();
		}
		$this->db->where('email', $email);
		$this->db->or_where('id', $email);
		$query = $this->db->get('users');
		return $query->row_array();
	}

	public function get_user_module($id){
		$this->db->select('users_programs.id as user_program_id, programs.id as program_ID, programs.name as name, users_programs.created_at, users_programs.amount, users_programs.status');
		$this->db->join('users', 'users.id = users_programs.user_ID');
		$this->db->join('programs', 'users_programs.program_ID = programs.id');
		$this->db->where('users.id', $id);
		$query = $this->db->get('users_programs');
		return $query->result_array();
	}

	function get_user_by_id($id){
		$this->db->select('*, users_level.exp as current_level, level.name as level_name,
			users.exp as user_exp');
		$this->db->join('users_level', 'users.level = users_level.level');
		$this->db->join('level', 'level.id = users_level.name');
		$this->db->where('users.id', $id);
		$query = $this->db->get('users');
		return $query->row_array();
	}

	public function next_level($level){
		$nextlevel = $level+'1';
		$this->db->select('*, users_level.exp as next_exp');
		$this->db->join('level', 'level.id = users_level.name');
		$this->db->where('users_level.level', $nextlevel);
		
		$query = $this->db->get('users_level');
		return $query->row_array();
	}

	public function rankings($limit = FALSE){
		$this->db->select('users.id, users.exp, users.first_name, users.last_name, users.level, level.name, level.image');
		$this->db->join('users_level', 'users.level = users_level.level');
		$this->db->join('level', 'level.id = users_level.name');
		$this->db->where('users.status', '1');
		$this->db->order_by('users.level', 'DESC');
		if($limit !== FALSE){
			$this->db->limit(10);
		}

		$query = $this->db->get('users');
		return $query->result_array();
	}

	function create_user($email){
		$this->db->trans_begin();
		$hashed_password = password_hash('studying', PASSWORD_DEFAULT);
		$data = array(
			'email' => strtolower($email),
			'password' => $hashed_password,
			'status' => 1,
			'level' => 1,
			'exp' => 0,
			'created_at' => date('Y-m-d H:i:s'),
			'last_login' => NULL,
			'music_status' => '1'
		);
		$this->db->insert('users', $data);
		$query1 = $this->get_users($email);
		$numberteam = count($this->input->post('modules'));
	    for($i=0; $i<$numberteam; $i++) {
	    	if(trim($this->input->post('modules')[$i] != '')) {
		        $program = $this->input->post('modules')[$i];
		        $sql = $this->programs_model->get_programs($program);
		    	$data1 = array(
					'user_ID' => $query1['id'],
					'program_ID' => $program,
					'amount' => $sql['price']
				);
				$this->db->set('created_at', 'NOW()', FALSE);
				$this->db->insert('users_programs', $data1);
	      	}
	    }
		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	function change_password($new_password, $email){
		$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
		$this->db->set('password', $hashed_password);
		$this->db->where('email', strtolower($email));
		return $this->db->update('users');
	}

	function change_profile($first_name, $last_name, $profile_photo, $bio, $email, $user_ID){	
		$this->db->set('first_name', strtolower($first_name));
		$this->db->set('last_name', strtolower($last_name));
		$this->db->set('image', $profile_photo);
		$this->db->set('bio', $bio);
		$this->db->set('status', '1');
		$this->db->set('email', strtolower($email));
		$this->db->where('id', $user_ID);
		return $this->db->update('users');
	}

	function change_status($user_ID, $status){
		$this->db->trans_begin();
		$data = array(
			'status' => $status
		);
		$this->db->where('id', $user_ID);
		$this->db->update('users', $data);
		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	function track_progress($duration, $progress, $user_ID, $content_ID, $src){
		$query =  $this->db->where('content_ID',$content_ID)->where('user_ID',$user_ID)->from("video_watched")->count_all_results();
		if($query == 0){
			$data2 = array(
			'src' => $src,
	        'content_ID' => $content_ID,
	        'user_ID'  => $user_ID
			);
			$this->db->insert('video_watched', $data2);
		}
		$data = array(
			'src'  => $src,
	        'progress'  => $progress,
	        'duration'  => $duration,
	        'content_ID'  => $content_ID,
	        'user_ID'  => $user_ID
		);
		return $this->db->replace('videos', $data);
	}

	function get_progress_video($content, $user_ID){
		$this->db->select('*, video_watched.status as status');
    	$this->db->join('video_watched', 'video_watched.content_ID = videos.content_ID', 'left');
		$this->db->where('videos.user_ID', $user_ID);
		$this->db->where('videos.content_ID', $content);
		$query = $this->db->get('videos');
		return $query->row_array();
	}

	function finished_video($user_ID, $content){
		$query = $this->db->where('content_ID',$content)->where('user_ID',$user_ID)->where('status', '1')->from("video_watched")->count_all_results();
		if($query == 0){
			$this->db->set('status', '1');
			$this->db->where('user_ID', $user_ID);
			$this->db->where('content_ID', $content);
			$this->db->update('video_watched');
			$this->db->set('exp', 'exp+50', FALSE);
			$this->db->where('id', $user_ID);
			$this->db->update('users');
			return true;
		} else {
			return false;
		}
	}

	function last_watched($user_id){
		$this->db->select('course.title as name, course.slug as slug, course_section_lesson_content.id as content_ID, course_section_lesson_content.name as content_name, course_section_lesson_content.row as content_row, course_section_lesson_content.url as content_url, course_section.slug as section_slug, programs.slug as program_slug');
	    $this->db->join('course_section_lesson_content', 'course_section_lesson_content.id = videos.content_ID');
	    $this->db->join('course_section_lesson', 'course_section_lesson.id = course_section_lesson_content.lesson_ID');
	    $this->db->join('course_section', 'course_section.id = course_section_lesson.section_ID');
	    $this->db->join('course', 'course.id = course_section.course_ID');
	    $this->db->join('programs_modules', 'course.id = programs_modules.course_ID');
	    $this->db->join('programs', 'programs.id = programs_modules.program_ID');
		$this->db->where('videos.user_ID', $user_id);
		$this->db->order_by('videos.timestamp', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get('videos');
		return $query->row_array();
	}

	function users_videos_watched($slug, $section_slug, $user_id){
		$this->db->select('count(video_watched.user_ID) as total');
	    $this->db->join('course_section_lesson_content', 'course_section_lesson_content.id = video_watched.content_ID');
	    $this->db->join('course_section_lesson', 'course_section_lesson.id = course_section_lesson_content.lesson_ID');
	    $this->db->join('course_section', 'course_section.id = course_section_lesson.section_ID');
	    $this->db->join('course', 'course.id = course_section.course_ID');
	    $this->db->where('course_section_lesson_content.status', '1');
		$this->db->where('video_watched.user_ID', $user_id);
		$this->db->where('video_watched.status', '1');
		if($slug != NULL){
    		$this->db->where('course.slug', $slug);
    	}

    	if($section_slug != NULL){
    		$this->db->where('course_section.slug', $section_slug);
    	}

		$query = $this->db->get('video_watched');
		return $query->row_array();
	}

	function users_all_videos_watched($user_id){
		$this->db->select('course.row as row, course.title as name, course_section_lesson_content.name as content_name, video_watched.timestamp as timestamp, video_watched.status as status, course_section_lesson_content.id as content_ID, course.slug as course_slug, course_section.slug as section_slug, programs.slug as program_slug');
	    $this->db->join('course_section_lesson_content', 'course_section_lesson_content.id = video_watched.content_ID');
	    $this->db->join('course_section_lesson', 'course_section_lesson.id = course_section_lesson_content.lesson_ID');
	    $this->db->join('course_section', 'course_section.id = course_section_lesson.section_ID');
	    $this->db->join('course', 'course.id = course_section.course_ID');
	    $this->db->join('programs_modules', 'course.id = programs_modules.course_ID');
	    $this->db->join('programs', 'programs.id = programs_modules.program_ID');
		$this->db->where('video_watched.user_ID', $user_id);
		$this->db->order_by('video_watched.timestamp', 'DESC');

		$query = $this->db->get('video_watched');
		return $query->result_array();
	}

	function level_up($user_id, $exp){
		$this->db->trans_begin();
		$this->db->select('*');
		$this->db->where('exp <=', $exp);
		$this->db->order_by('exp', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get('users_level');
		$row2 = $query->row_array();
		$this->db->set('level', $row2['level']);
		$this->db->where('id', $user_id);
		$this->db->update('users');

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	function get_progress_content($user_ID, $content_ID){
		$query = $this->db->get_where('video_watched', array('user_ID' => $user_ID, 'content_ID' => $content_ID, 'status' => '1'));

		return $query->row_array();
	}

	function get_current_progress($user_ID){
		$this->db->select('*, video_watched.status as status');
	    $this->db->join('video_watched', 'videos.content_ID = video_watched.content_ID');
		$query = $this->db->get_where('videos', array('videos.user_ID' => $user_ID));

		return $query->result_array();

	}

	function get_all_progress_content($user_ID){
		$query = $this->db->get_where('video_watched', array('user_ID' => $user_ID, 'status' => '1'));

		return $query->result_array();
	}

	function finished_lesson($user_ID, $lesson_ID){
		$this->db->trans_begin();

		$data = array(
			'user_ID' => $user_ID,
			'lesson_ID' => $lesson_ID,
		);

		$this->db->insert('users_progress', $data);

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	function users_progress($user_ID){
		$query = $this->db->where('user_ID',$user_ID)->from('video_watched')->count_all_results();

		return $query;
	}

	function add_purchases($id){
		$this->db->trans_begin();
		$numberteam = count($this->input->post('modules'));
	    for($i=0; $i<$numberteam; $i++) {
	    	if(trim($this->input->post('modules')[$i] != '')) {
		        $program = $this->input->post('modules')[$i];
		    	$sql = $this->programs_model->get_programs($program);

		    	$data1 = array(
					'user_ID' => $id,
					'program_ID' => $program,
					'amount' => $sql['price']
				);
				$this->db->set('created_at', 'NOW()', FALSE);
				$this->db->insert('users_programs', $data1);
	      	}
	    }

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	function delete_purchase($id){
		$this->db->delete('users_programs', array('id' => $id));		
	}

	function refund_purchase($program_ID, $amount){
		$this->db->trans_begin();

		$this->db->set('amount', 'amount-'. $amount.'',false);
		$this->db->set('status', '2');
		$this->db->where('id', $program_ID);
		$this->db->update('users_programs');

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else {
		    $this->db->trans_commit();
		    return true;
		}	
	}

	function check_rate($email){
		$this->db->select('count(*) as total');
		$this->db->where('email', strtolower($email));
		$query = $this->db->get('software_rating');
		$result = $query->row_array();

		return $result;
	}

	function send_rating($email, $feedback_rating, $feedback){
    	$this->db->trans_begin();

    	$data = array(
			'email' => $email,
			'rating' => $feedback_rating,
			'comments' => $feedback
		);

		$this->db->insert('software_rating', $data);

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	 public function get_last_progress(){
    	$this->db->select('*');
    	$this->db->where('user_ID', $this->session->userdata('user_id'));
    	$this->db->order_by('timestamp', 'DESC');
		$this->db->limit(1);

    	$query = $this->db->get('videos');
		return $query->row_array();
    }

    public function create_notes($section_ID, $notes, $user_ID){
	 	$this->db->trans_begin();

    	$data = array(
			'user_ID' => $user_ID,
			'notes' => $notes,
			'section_ID' => $section_ID
		);

		$this->db->insert('users_notes', $data);

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
    }

    public function get_my_notes($section_ID, $user_ID){
    	$this->db->where('section_ID', $section_ID);
    	$this->db->where('user_ID', $user_ID);
    	$this->db->order_by('timestamp', 'DESC');

    	$query = $this->db->get('users_notes');
    	return $query->result_array();
    }

    public function get_notes($user_ID){
    	$this->db->select('course.slug as course_slug, course_section.name as section_name, course_section.slug as section_slug, users_notes.notes as notes');
    	$this->db->join('course_section', 'course_section.id = users_notes.section_ID');
    	$this->db->join('course', 'course.id = course_section.course_ID');
    	$this->db->where('users_notes.user_ID', $user_ID);
    	$this->db->order_by('users_notes.timestamp', 'DESC');

    	$query = $this->db->get('users_notes');
    	return $query->result_array();
    }

    function delete_notes($id){
		$this->db->delete('users_notes', array('id' => $id));		
	}

    function all_videos(){
    	$this->db->where('duration is NOT NULL', NULL, FALSE);
		$this->db->group_by('src');
		$query = $this->db->get('videos');
		return $query->result_array();
	}

    function accept_reward($user_ID, $days){
		$this->db->trans_begin();
		$days = $days + 1;
		$this->db->set('timestamp', 'NOW()', FALSE);
		$this->db->set('streak', 'streak+1', FALSE);
		if($days == 30){
			$this->db->set('status', 1);
		}
		$this->db->set('days', 'days+1', FALSE);
		$this->db->where('user_ID', $user_ID);
		$this->db->update('users_daily_login');

		$this->db->set('exp', 'exp+60', FALSE);
		$this->db->where('id', $user_ID);
		$this->db->update('users');

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

    function daily_logins($user_ID = FALSE){
    	if($user_ID === FALSE){
    		$this->db->select('users_daily_login.*, users.first_name, users.last_name');
			$this->db->join('users', 'users.id = users_daily_login.user_ID');
			$query = $this->db->get('users_daily_login');
			return $query->result_array();
		}
		$this->db->where('user_ID', $user_ID);
		$query = $this->db->get('users_daily_login');
		return $query->row_array();
	}

	function start_daily_login_reward($user_ID){
		$timestamp = strtotime('today 9pm');
		$time = date("Y-m-d H:i:s", $timestamp);

		$data = array(
			'user_ID' => $user_ID,
	        'days' => '1'
		);
		$this->db->set('timestamp', 'NOW() - INTERVAL 1 DAY', FALSE);
        $this->db->set('date_started', $time);
		$this->db->insert('users_daily_login', $data);
	}

    function get_music_status($user_ID){
    	$this->db->select('music_status');
		$this->db->where('id', $user_ID);
		$query = $this->db->get('users');
		return $query->row_array();
	}

	function follow($following, $follower){
		$this->db->trans_begin();
    	$data = array(
    		'following' => $following,
			'follower' => $follower
		);

		$this->db->insert('users_follow', $data);

		$user_follower = $this->db->insert_id();
        $data2 = array(
        	'type' => 4,
        	'notification_option_id' => 9,
        	'id' => $user_follower,
			'notified' => $following,
			'notifier' => $follower,
		);
    	
		$this->db->insert('users_notifications', $data2);

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	function unfollow($following, $follower){
		$this->db->delete('users_follow', array('following' => $following, 'follower' => $follower));
		$this->db->delete('users_notifications',  array(
        	'type' => 4,
        	'notification_option_id' => 9,
			'notified' => $following,
			'notifier' => $follower,
		));
	}

	function is_following($following, $follower){
		$this->db->select('count(*) as total');
		$query = $this->db->get_where('users_follow', array('following' => $following, 'follower' => $follower));

		return $query->row_array();
	}

	function count_posts($user_ID){
		$this->db->select('count(*) as total');
		$query = $this->db->get_where('users_posts', array('user_ID' => $user_ID));

		return $query->row_array();
	}

	function count_followers($user_ID){
		$this->db->select('count(*) as total');
		$query = $this->db->get_where('users_follow', array('following' => $user_ID));

		return $query->row_array();
	}

	function count_following($user_ID){
		$this->db->select('count(*) as total');
		$query = $this->db->get_where('users_follow', array('follower' => $user_ID));

		return $query->row_array();
	}

	function get_followers($user_ID){
		$this->db->select('*');
		$this->db->join('users', 'users.id = users_follow.follower');
		$query = $this->db->get_where('users_follow', array('following' => $user_ID));

		return $query->result_array();
	}

	function get_following($user_ID){
		$this->db->select('users_follow.*, users.first_name, users.last_name, users.image');
		$this->db->join('users', 'users.id = users_follow.following');
		$query = $this->db->get_where('users_follow', array('follower' => $user_ID));

		return $query->result_array();
	}

	function insert_timezone($timezone, $user_ID){
		$this->db->trans_begin();

		$this->db->set('timezone', $timezone);
		$this->db->where('id', $user_ID);
		$this->db->update('users');

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	function update_user_status($user_ID){
    	$this->db->set('last_login', 'NOW()', FALSE);
		$this->db->where('id', $user_ID);
		return $this->db->update('users');
	}

	function reset_login_streak($user_ID){
		$this->db->set('timestamp', 'NOW() - INTERVAL 1 DAY', FALSE);
        $this->db->set('days', 0);
		$this->db->where('user_ID', $user_ID);
		return $this->db->update('users_daily_login');
	}
}