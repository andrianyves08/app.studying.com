<?php
	class Tools_model extends CI_Model {

    public function __construct(){
        $this->load->database();
        //$this->db2 = $this->load->database('opencart', TRUE);
    }

	public function get_facebook_ads($user_ID){
		$this->db->where('user_ID', $user_ID);
		$query = $this->db->get('users_facebook_ads');
		return $query->result_array();
	}
}