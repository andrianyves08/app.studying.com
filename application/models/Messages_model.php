<?php
	class Messages_model extends CI_Model {

    public function __construct(){
        $this->load->database();
    }

    public function get_message($chat_ID){
		$this->db->select('messages.*, users.first_name, users.last_name');
		$this->db->join('users', 'messages.fromID = users.id');
		$this->db->where('messages.id', $chat_ID);
		$query = $this->db->get('messages');
		return $query->row_array();
	}

	public function get_group_message($chat_ID){
		$this->db->select('group_messages.*, users.first_name, users.last_name');
		$this->db->join('users', 'group_messages.sender_ID = users.id');
		$this->db->where('group_messages.id', $chat_ID);
		$query = $this->db->get('group_messages');
		return $query->row_array();
	}

	public function all_users(){
		$this->db->select('id, first_name, last_name');
		$this->db->where('status', '1');
		$this->db->order_by('first_name', 'ASC');
		$query = $this->db->get('users');

		return $query->result_array();
	}

	public function get_users($user_ID){
		$this->db->select('users.id as usID, users.first_name as usFN, users.last_name as usLN, users.level as usLvl, users.image as usImg, level.name, users.login_status as last, level.image as level_image');
		$this->db->join('users', 'messages.toID = users.id or messages.fromID = users.id');
		$this->db->join('users_level', 'users.level = users_level.level');
		$this->db->join('level', 'level.id = users_level.name');
		$this->db->where('messages.fromID', $user_ID);
		$this->db->or_where('messages.toID', $user_ID);
		$this->db->group_by("users.id");
		$this->db->order_by('max(messages.timestamp)', 'DESC');
		$query = $this->db->get('messages');
		return $query->result_array();
	}

	public function get_group($user_ID){
		$this->db->select('users.first_name as usFN, users.last_name as usLN, users.level as usLvl, users.image as usImg, users.login_status as last, group_name.id as gID, group_name.name as gName, group_name.admin_ID as gAdmin, group_members.user_ID as gMembers');
		$this->db->join('users', 'group_members.user_ID = users.id', 'left');
		$this->db->join('group_name', 'group_members.group_ID = group_name.id', 'left');
		$this->db->where('group_members.user_ID', $user_ID); 

		$query = $this->db->get('group_members');
		return $query->result_array();
	}

	public function get_members($group_id){
		$this->db->select('users.id as user_ID, users.first_name as usFN, users.last_name as usLN, group_members.user_ID as gMembers, users.image as usImg');
		$this->db->join('users', 'group_members.user_ID = users.id', 'left');
		$this->db->where('group_members.group_ID', $group_id); 
		$this->db->order_by('users.first_name', 'DESC');

		$query = $this->db->get('group_members');
		return $query->result_array();
	}

	public function messages($limit, $user_ID, $toID){
		$this->db->select('users.image as usImg, messages.fromID as fromID, messages.toID as toID, messages.message as chat, messages.status as mesStat, messages.timestamp as mesSent, messages.id as chat_ID, messages.parent_message as parent_message, users.first_name as first_name, users.last_name as last_name');
		$this->db->join('users', 'messages.fromID = users.id');
		$where = "(fromID = '$toID' AND toID = '$user_ID') OR (fromID = '$user_ID' AND toID = '$toID')";
		$this->db->where($where);
		$this->db->order_by('messages.timestamp', 'DESC');
		if(!empty($limit)){
			$this->db->limit($limit);
		}

		$query = $this->db->get('messages');
		return $query->result_array();
	}

	public function group_messages($limit, $user_ID, $group_ID){
		$this->db->select('users.image as usImg, group_messages.sender_ID as sender_ID, group_messages.group_ID as group_ID, group_messages.message as chat, group_messages.status as mesStat, group_messages.timestamp as mesSent, group_messages.id as chat_ID, group_messages.parent_message as parent_message, users.first_name as first_name, users.last_name as last_name');
		$this->db->join('users', 'group_messages.sender_ID = users.id');
		$where = "(group_ID = '$group_ID' AND sender_ID = '$user_ID') OR (group_ID = '$group_ID' AND sender_ID != '$user_ID')";
		$this->db->where($where);
		$this->db->order_by('group_messages.timestamp', 'DESC');
		$this->db->limit($limit);

		$query = $this->db->get('group_messages');
		return $query->result_array();
	}

	public function send_message($user_ID, $toID, $message, $chat_ID){
		$this->db->trans_begin();
		$data = array(
			'toID' => $toID,
			'fromID' => $user_ID,
			'message' => $message,
			'parent_message' => $chat_ID,
			'status' => '0'
		);

		$this->db->set('exp', 'exp+10', FALSE);
		$this->db->where('id', $user_ID);
		$this->db->update('users');

		$this->db->insert('messages', $data);
		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function send_group_message($user_ID, $group_ID, $message, $chat_ID){
		$this->db->trans_begin();
		$data = array(
			'group_ID' => $group_ID,
			'sender_ID' => $user_ID,
			'parent_message' => $chat_ID,
			'message' => $message,
			'status' => '0'
		);

		$this->db->set('exp', 'exp+10', FALSE);
		$this->db->where('id', $user_ID);
		$this->db->update('users');

		$this->db->insert('group_messages', $data);
		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function message_seen($user_ID, $toID){
		$this->db->set('status', '1');
		$this->db->where('toID', $user_ID);
		$this->db->where('fromID', $toID);
		$this->db->where('status', '0');

		$this->db->update('messages');

		return true;
	}

	public function message_unseen($user_ID, $toID){
		$this->db->where('toID', $user_ID);
		$this->db->where('fromID', $toID);
		$this->db->where('status', '0');

		return $this->db->count_all_results('messages');
	}

	public function total_message_unseen($user_ID){
		$this->db->where('toID', $user_ID);
		$this->db->where('status', '0');

		return $this->db->count_all_results('messages');
	}


	public function message_delete($id){
		$this->db->set('status', '2');
		$this->db->where('id', $id);

		$this->db->update('messages');
	}

	public function group_message_delete($id){
		$this->db->set('status', '2');
		$this->db->where('id', $id);

		$this->db->update('group_messages');
	}

	public function add_member($id, $group_ID){
		$data = array(
			'user_ID' => $id,
			'group_ID' => $group_ID
		);

		$this->db->insert('group_members', $data);
	}

	public function create_group($user_ID, $name, $members){
		$this->db->trans_begin();

		$data = array(
			'admin_ID' => $user_ID,
			'name' => $name
		);

		$this->db->insert('group_name', $data);
		$groupID = $this->db->count_all('group_name');

		$data3 = array(
			'user_ID' => $user_ID,
			'group_ID' => $groupID
		);

		$this->db->insert('group_members', $data3);
		$total_content = count($this->input->post('members'));
		for($i=0; $i<$total_content; $i++) {
			if(trim($this->input->post('members')[$i] != '')) {
		        $member = $members[$i];

		        $data2 = array(
					'user_ID' => $member,
					'group_ID' => $groupID
				);
		    	
				$this->db->insert('group_members', $data2);
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
}