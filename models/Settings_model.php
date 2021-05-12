<?php
	class Settings_model extends CI_Model {

    public function __construct(){
        $this->load->database();
    }

    function get_pages($id = FALSE){
    	if($id === FALSE){
			$query = $this->db->get('pages');
			return $query->result_array();
		}

		$query = $this->db->get_where('pages', array('id' => $id));

		return $query->row_array();
	}

	function get_settings(){
		$this->db->where('id', 1);
		$query = $this->db->get('settings');

		return $query->row_array();
	}

	function logo($logo){
		$this->db->set('logo_img', $logo);
		$this->db->where('id', 1);
		return $this->db->update('settings');
	}

	function login_video($name){
		$this->db->set('login_video', $name);
		$this->db->where('id', 1);
		return $this->db->update('settings');
	}

	function home_video($name){
		$this->db->set('home_video', $name);
		$this->db->where('id', 1);
		return $this->db->update('settings');
	}

	function music($name){
		$this->db->set('music', $name);
		$this->db->where('id', 1);
		return $this->db->update('settings');
	}

	function nav_text_color($name){
		$this->db->set('nav_text_color', $name);
		$this->db->where('id', 1);
		return $this->db->update('settings');
	}

	function background_image($name){
		$this->db->set('background_image', $name);
		$this->db->where('id', 1);
		return $this->db->update('settings');
	}

	function update_page($id, $background_image, $content){
		$this->db->set('background_image', $background_image);
		$this->db->set('content', $content);
		$this->db->where('id', $id);
		return $this->db->update('pages');
	}

	function change_review_post_status($status){
		$this->db->set('review_post_status', $status);
		$this->db->where('id', 1);
		return $this->db->update('settings');
	}

	function change_system_status($status){
		$this->db->set('system_status', $status);
		$this->db->where('id', 1);
		return $this->db->update('settings');
	}
}