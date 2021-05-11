<?php
	class Support_model extends CI_Model {

    public function __construct(){
        $this->load->database();
    }

    function get_messages(){
    	$this->db->select('*, users.id as user_ID, messages_support.id as message_ID, messages_support.name as other_user_name, messages_support.email other_email');
		$this->db->join('users', 'users.id = messages_support.from_ID', 'left');
		$query = $this->db->get('messages_support');
		return $query->result_array();
	}

	function send_message($user_ID, $message){
		$this->db->trans_begin();
		$data = array(
			'from_ID' => $user_ID,
			'message' => $message,
		);
		$this->db->insert('messages_support', $data);

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	function give_reward($user_ID, $id){
		$this->db->trans_begin();
		$this->db->set('exp', 'exp+20', FALSE);
		$this->db->where('id', $user_ID);
		$this->db->update('users');

		$this->db->set('reward_status', '1');
		$this->db->where('id', $id);
		$this->db->update('messages_support');

		$data = array(
			'type' => 3,
			'notification_option_id' => 5,
			'owner' => $user_ID,
		);
		
		$this->db->insert('users_notifications', $data);

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function new_messages(){
		$this->db->where('status', '0');
		return $this->db->count_all_results('messages_support');
	}

	public function seen(){
		$this->db->set('status', '1');
		return $this->db->update('messages_support');
	}
}