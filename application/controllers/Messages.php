<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Messages extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('upload');
	}

	function check_session(){
		if(!$this->session->userdata('user_logged_in')){
			redirect('login');
		}
	}	
	
	public function index(){
		$this->check_session();
		$page = 'messages';
		$data['title'] = ucfirst($page);
		$data['settings'] = $this->settings_model->get_settings();
		$data['my_info'] = $this->user_model->get_users($this->session->userdata('email'));
		$data['next_level'] = $this->user_model->next_level($data['my_info']['level']);
		$data['music_status'] = $this->user_model->get_music_status($this->session->userdata('user_id'));
		$data['unseen_chat'] = $this->messages_model->total_message_unseen($this->session->userdata('user_id'));
		$data['all_users']  = $this->messages_model->all_users();
		$data['my_id'] = $this->session->userdata('user_id');

		$this->load->view('templates/header', $data);
        $this->load->view('templates/nav', $data);
		$this->load->view('pages/'.$page, $data);
		$this->load->view('templates/footer');
		$this->load->view('templates/scripts');
	}

	function get_users() {
		$data = $this->messages_model->get_users($this->session->userdata('user_id'));
		$output = '';
		$data2 = $this->messages_model->get_group($this->session->userdata('user_id'));
		$id=1;
		foreach($data2 as $row2){
			$output .= '<a class="start_group_chat" id="'.$id.'" data-id="'.$row2['gID'].'" data-name="'.ucwords($row2['gName']).'"><div class="card-body d-flex flex-row message_header" id="message_header'.$id.'"><img src="'.base_url().'assets/img/logo-1.png" class="mr-2 chat-mes-id-2" alt="avatar" style="height: 50px;width: 50px;"><div><h5 class="card-title font-weight-bold ">'.ucwords($row2['gName']).'</h5><p class="card-text"></div></div></a>';
			$id++;
		}

		foreach($data as $row){
			$count = $this->messages_model->message_unseen($this->session->userdata('user_id'), $row['usID']);
			if($count > 0){
				$total = '<span class="badge badge-danger badge-pill ml-4">'.$count.'</span>';
			} else {
				$total = NULL;
			}

			if($row['last'] == 0){
				$stat = 'text-danger';
			} else {
				$stat = 'text-success';
			}

			if($row['usID'] != $this->session->userdata('user_id')){
				$output .= '<a class="start_chat" id="'.$id.'" data-id="'.$row['usID'].'" data-name="'.ucwords($row['usFN']).'" data-last="'.ucwords($row['usLN']).'"><div class="card-body d-flex flex-row message_header" id="message_header'.$id.'"><img src="'.base_url().'assets/img/users/'.$row['usImg'].'" class="mr-2 chat-mes-id-2" alt="avatar" style="height: 50px;width: 50px;"><div><div class="card-title font-weight-bold "><h6><i class="fas fa-circle mr-2 '.$stat.'"></i> '.ucwords($row['usFN']).' '.ucwords($row['usLN']).'</h6></div><p class="card-text"><img src="'.base_url().'assets/img/'.$row['level_image'].'" class="rounded-circle" height="25px" width="25px" alt="avatar"> Level '.ucfirst($row['usLvl']).' '.$total.'</p></div></div></a>';
			}
			
			$id++;
		}
		$output .= '';
		echo json_encode($output);
	}

	function get_friends() {
		$data = $this->messages_model->get_users($this->session->userdata('user_id'));
		echo json_encode($data);
	}

	function get_messages() {
		$user = $this->messages_model->messages($this->input->post('limit'), $this->session->userdata('user_id'), $this->input->post('user_ID'));
		
		$max = count($user);
		$output = '';

		$i = 1;
		$other = 0;
		foreach(array_reverse($user) as $row){
			$total = $max - $other;
			if($row['fromID'] == $this->session->userdata('user_id')){
				$output .= '<div class="d-flex justify-content-end align-items-center">';
				if($row['mesStat'] == '2'){
					$output .= '<div class="card border border-light bg-white rounded-pill w-50 float-right z-depth-0 mb-1 last"><div class="card-body"><p class="card-text text-black font-italic">This message has been removed.</p></div></div>';
				} else {
					if (strtotime($row['mesSent'] > strtotime("-20 minutes"))) {
					 	$output .='<div class="card bg-primary rounded w-50 float-right z-depth-0 mb-1 last"><div class="card-body p-2"><p class="card-text text-white" style="font-size: 16px;">'.$row['chat'].'</p></div><p class="card-text text-white p-2 text-right" style="font-size: 12px;">'.date("M j, Y h:i A", strtotime($row['mesSent'])).'</p></div>';
					} else {
						$output .='<div class="card bg-primary rounded w-50 z-depth-0 mb-1 last"><div class="card-body p-2">';
					if($row['parent_message'] != 0 ){
						$chat = $this->messages_model->get_message($row['parent_message']);
						$output .= '<p class="white-text font-italic ml-3" style="font-size: 16px;">" '.$chat['message'].' "</p><p class="text-white text-left ml-3" style="font-size: 12px;">You replied to '.ucwords($chat["first_name"]).' '.ucwords($chat["last_name"]).' '.date("M j, Y h:i A", strtotime($chat['timestamp'])).'</p><hr class="mt-1 mb-3">';
					}
					$output .=	'<p class="card-text text-white" style="font-size: 16px;">'.$row['chat'].'</p></div><p class="card-text text-white p-2 text-right" style="font-size: 12px;">'.date("M j, Y h:i A", strtotime($row['mesSent'])).'<a class="delete_chat" id="'.$row['chat_ID'].'"><span class="white-text p-2">&times;</span></a></p></div>';
					}		
				}
				$output .= '<div class="profile-photo message-photo mt-2"><img src="'.base_url().'assets/img/users/'.$row['usImg'].'" alt="avatar" class="avatar ml-2 mr-0 chat-mes-id-2" style="height: 50px;width: 50px"><span class="state"></span></div></div>';
				if(($row['mesStat'] == '1') && ($i == $total)){
					$output .= '<p class="text-black font-italic float-right mr-5 pr-3" style="font-size: 12px;">Seen</p>';
				}
				$i++;
			} else {
				$other++;
				$output .= '<div class="d-flex justify-content-start mb-1 align-items-center">';
				$output .= '<div class="profile-photo message-photo"><img src="'.base_url().'assets/img/users/'.$row['usImg'].'" alt="avatar" class="avatar mr-2 ml-0 chat-mes-id-2" style="height: 50px;width: 50px"><span class="state"></span></div>';
				if($row['mesStat'] == '2'){
				$output .= ' <div class="card border border-light bg-white rounded-pill w-50 z-depth-0 mb-1 message-text"><div class="card-body"><p class="card-text text-black font-italic">This message has been removed.</p></div></div></div>';
				} else {
				$output .= '<div class="card bg-light rounded w-50 z-depth-0 mb-1 message-text"><div class="card-body p-2">';
				if($row['parent_message'] != 0 ){
					$chat = $this->messages_model->get_message($row['parent_message']);
					$output .= '<p class="black-text font-italic ml-3" style="font-size: 16px;">" '.$chat['message'].' "</p><p class="text-left ml-3 text-muted" style="font-size: 12px;">'.ucwords($row["first_name"]).' '.ucwords($row["last_name"]).' replied to You '.date("M j, Y h:i A", strtotime($chat['timestamp'])).'</p><hr class="mt-1 mb-3">';
				}
				$output .= '<p class=black-text chat_texts_'.$row['chat_ID'].'" style="font-size: 16px;">
				'.$row['chat'].'</p></div><p class="card-text text-muted p-1 ml-2 text-left" style="font-size: 12px;">'.date("M j, Y h:i A", strtotime($row['mesSent'])).'</p></div><a class="replay ml-2" data-message-id="'.$row['chat_ID'].'"><i class="fas fa-reply"></i></a></div>';
				}
			}
		}
		$output .= '';
		$seen = $this->messages_model->message_seen($this->session->userdata('user_id'), $this->input->post('user_ID'));
		echo json_encode($output);
	}

	function get_group_messages() {
		$group_data = $this->messages_model->group_messages($this->input->post('limit'), $this->session->userdata('user_id'), $this->input->post('group_ID'));
		$output = '';

		$max = count($group_data);
		$i = 1;
		$other = 0;
		foreach(array_reverse($group_data) as $row){
			$total = $max - $other;
			if($row["sender_ID"] == $this->session->userdata('user_id')){
				$output .= '<div class="d-flex justify-content-end">';
				if(($row["mesStat"] == '1') && ($i == $total)){
					$output .= '<div class="card bg-white rounded-pill text-left z-depth-0 mb-1 last"><div class="card-body p-2"><p class="card-text text-black font-italic">Seen</p></div></div>';
				}
				if($row["mesStat"] == '2'){
					$output .= '<div class="card border border-light bg-white rounded-pill w-50 float-right z-depth-0 mb-1 last"><div class="card-body"><p class="card-text text-black font-italic">This message has been removed.</p></div></div>';
				} else {
					$now = strtotime("-2 minutes");
					if ($now > strtotime($row["mesSent"])) {
					 	$output .='<div class="card bg-primary rounded w-50 float-right z-depth-0 mb-1 last"><div class="card-body p-2"><p class="card-text text-white" style="font-size: 16px;">'.$row["chat"].'</p></div><p class="card-text text-white p-2 text-right" style="font-size: 12px;">'.date("M j, Y h:i A", strtotime($row["mesSent"])).'</p></div>';
					} else {
						$output .='<div class="card bg-primary rounded w-50 z-depth-0 mb-1 last"><div class="card-body p-2">';
						if($row['parent_message'] != 0 ){
							$chat = $this->messages_model->get_group_message($row['parent_message']);
							$output .= '<p class="text-white font-italic ml-3" style="font-size: 16px;">" '.$chat['message'].' "</p><p class="text-left ml-3 text-white" style="font-size: 12px;">You replied to '.ucwords($chat["first_name"]).' '.ucwords($chat["last_name"]).' '.date("M j, Y h:i A", strtotime($chat['timestamp'])).'</p><hr class="mt-1 mb-3">';
						}
				$output .= '<p class="card-text text-white" style="font-size: 16px;">'.$row["chat"].'</p></div><p class="card-text text-white p-2 text-right" style="font-size: 12px;">'.date("M j, Y h:i A", strtotime($row["mesSent"])).'<a class="delete_group_chat" id="'.$row["chat_ID"].'"><span class="white-text p-2">&times;</span></a></p></div>';
					}		
				}
				$output .= '<div class="profile-photo message-photo mt-2"><img src="'.base_url().'assets/img/users/'.$row["usImg"].'" alt="avatar" class="avatar ml-2 mr-0 chat-mes-id-2" style="height: 50px;width: 50px"><span class="state"></span></div></div>';
				$i++;
			} else {
				$other++;
				$output .= '<div class="d-flex justify-content-start mb-1 align-items-center">';
				$output .= '<div class="profile-photo message-photo mt-2"><img src="'.base_url().'assets/img/users/'.$row["usImg"].'" alt="avatar" class="avatar mr-2 ml-0 chat-mes-id-2" style="height: 50px;width: 50px"><span class="state"></span></div>';
				if($row["mesStat"] == '2'){
				$output .= '<div class="card border border-light bg-white rounded-pill w-50 z-depth-0 mb-1 message-text"><div class="card-body"><p class="card-text text-black font-italic">This message has been removed.</p></div></div></div>';
				} else {
				$output .= '<div class="card bg-light rounded w-50 z-depth-0 mb-1 message-text"><div class="card-body p-2">';
				if($row['parent_message'] != 0 ){
					$chat = $this->messages_model->get_group_message($row['parent_message']);
					$output .= '<p class="black-text font-italic ml-3" style="font-size: 16px;">" '.$chat['message'].' "</p><p class="text-left ml-3 text-muted" style="font-size: 12px;">'.ucwords($row["first_name"]).' '.ucwords($row["last_name"]).' replied to '.ucwords($chat["first_name"]).' '.ucwords($chat["last_name"]).'</p><hr class="mt-1 mb-3">';
				}
				$output .= '<p class="card-text black-text" style="font-size: 12px;">'.ucwords($row["first_name"]).' '.ucwords($row["last_name"]).'</p><p class="card-text black-text chat_texts_'.$row['chat_ID'].'" style="font-size: 16px;">'.$row["chat"].'</p></div><p class="card-text black-text text-left mr-1 p-2" style="font-size: 12px;">'.date("M j, Y h:i A", strtotime($row["mesSent"])).'</p></div><a class="group_replay ml-2" data-message-id="'.$row['chat_ID'].'"><i class="fas fa-reply"></i></a></div>';
				}
			}
		}
		$output .= '';
		echo json_encode($output);
	}

	function create_chat() {
		$data = $this->user_model->get_users($this->input->post('user_ID'));
		echo json_encode($data);
	}

	function send_message() {
		$data = $this->messages_model->send_message($this->session->userdata('user_id'), $this->input->post('user_ID'),  nl2br(htmlentities($this->input->post('chat_message'), ENT_QUOTES, 'UTF-8')), $this->input->post('chat_ID'));
		echo json_encode($data);
	}

	function send_group_message() {
		$data = $this->messages_model->send_group_message($this->session->userdata('user_id'), $this->input->post('group_ID'), nl2br(htmlentities($this->input->post('chat_message'), ENT_QUOTES, 'UTF-8')), $this->input->post('chat_ID'));
		echo json_encode($data);
	}

	function create_message() {
		$toID = $this->user_model->get_users($this->input->post('user_ID'));
		if(!$toID){
			$data = array(
				'error' => true,
				'message' => 'User does not exist.'
			);
		} else {
			$data = $this->messages_model->message_sent($this->session->userdata('user_id'), $toID['id'], $this->input->post('chat_message'));
		}
		echo json_encode($data);
	}

	function delete_message() {
		$data = $this->messages_model->message_delete($this->input->post('chat'));
		echo json_encode($data);
	}

	function delete_group_message() {
		$data = $this->messages_model->group_message_delete($this->input->post('chat'));
		echo json_encode($data);
	}

	function create_group() {
		$create = $this->messages_model->create_group($this->session->userdata('user_id'), $this->input->post('group_name'), $this->input->post('members'));
		if($create){
			$this->session->set_flashdata('success', 'Group Created Successfully');
		} else {
			$this->session->set_flashdata('error', 'Group name already exist.');
		}
		redirect('messages');
	}

	function get_group_members() {
		$data = $this->messages_model->get_members($this->input->post('id'));
		$output = '';
		foreach($data as $row){
			$output .= '<li class="list-group-item"><a href="'.base_url().'user-profile/'.$row['user_ID'].'">'.ucwords($row['usFN']).' '.ucwords($row['usLN']).'</a></li>';
		}
		$output .= '';
		echo json_encode($output);;
	}

	function add_member() {
		$new = $this->user_model->get_users($this->input->post('id'));
		$data = $this->messages_model->add_member($new['id'], $this->input->post('group_id'));
		echo json_encode($data);;
	}

	function all_users() {
		$users = $this->messages_model->all_users();
		echo json_encode($users);
	}
}
