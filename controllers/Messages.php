<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Messages extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('upload');
	}

	public function convert($str, $target='_blank') {
        if ($target) {
	        $target = ' target="'.$target.'"';
	    } else {
	        $target = '';
	    }
	    // find and replace link
	    $str = preg_replace('@((https?://)?([-\w]+\.[-\w\.]+)+\w(:\d+)?(/([-\w/_\.~]*(\?\S+)?)?)*)@', '<a href="$1" '.$target.'>$1</a>', $str);
	    // add "http://" if not set
	    $str = preg_replace('/<a\s[^>]*href\s*=\s*"((?!https?:\/\/)[^"]*)"[^>]*>/i', '<a href="http://$1" '.$target.'>', $str);
	    return $str;
    }

	function check_session(){
		if(!$this->session->userdata('user_logged_in')){
			redirect('login');
		}
	}

	function get_users_status() {
		$data = $this->messages_model->get_users($this->session->userdata('user_id'));
		$total = array();

		foreach ($data as $row) {
			$count = $this->messages_model->message_unseen($this->session->userdata('user_id'), $row['user_ID']);
			$total[] = [
				'user_ID' => $row['user_ID'],
				'count' => $count,
				'status' => $this->change_timezone($row['last_login']),
				'last_login' => $this->changetimefromUTC($row['last_login'])
			];
		}

		echo json_encode($total);
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
			if($row['user_ID'] != $this->session->userdata('user_id')){
				$output .= '<a class="start_chat" id="'.$id.'" data-id="'.$row['user_ID'].'" data-name="'.ucwords($row['first_name']).'" data-last="'.ucwords($row['last_name']).'"><div class="card-body d-flex flex-row message_header" id="message_header'.$id.'"><img src="'.base_url().'assets/img/users/'.$row['usImg'].'" class="rounded-circle mr-2 chat-mes-id-2" alt="avatar" style="height: 50px;width: 50px;"><div><h6 class="user_names">'.ucwords($row['first_name']).' '.ucwords($row['last_name']).' <span class="badge badge-danger badge-pill ml-2 new_messages_'.$row['user_ID'].'"></span></h6><div class="user_status"></div><img src="'.base_url().'assets/img/'.$row['level_image'].'" class="rounded-circle" height="25px" width="25px" alt="avatar"> Level '.ucfirst($row['usLvl']).'<span class="ml-2 text-muted last_login_'.$row['user_ID'].'" style="font-size: 12px;"></span></div></div></a>';
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

	function change_timezone($time, $full = FALSE) {
		$data = $this->user_model->get_users($this->session->userdata('user_id'));

		$changetime = new DateTime($time, new DateTimeZone('UTC'));
	    $changetime->setTimezone(new DateTimeZone($data['timezone']));
	    return $changetime->format('M j, Y h:i A');
	}

	function changetimefromUTC($time, $full = FALSE) {
		$data = $this->user_model->get_users($this->session->userdata('user_id'));

		$now = new DateTime;
	    $ago = new DateTime($time, new DateTimeZone('UTC'));
	    $now->setTimezone(new DateTimeZone($data['timezone']));
	    $ago->setTimezone(new DateTimeZone($data['timezone']));

	    $diff = $now->diff($ago);

	    $diff->w = floor($diff->d / 7);
	    $diff->d -= $diff->w * 7;

	    $string = array(
	        'y' => 'year',
	        'm' => 'month',
	        'w' => 'week',
	        'd' => 'day',
	        'h' => 'hour',
	        'i' => 'minute',
	        's' => 'second',
	    );
	    foreach ($string as $k => &$v) {
	      if ($diff->$k) {
	        $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
	      } else {
	        unset($string[$k]);
	      }
	    }

	    if (!$full) $string = array_slice($string, 0, 1);
	    return $string ? implode(', ', $string) . ' ago' : 'just now';
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
					$output .= '<div class="card bg-white rounded-pill w-50 text-right z-depth-0 mb-1 last"><div class="card-body"><p class="card-text dark-text font-italic">You removed this message.</p></div></div>';
				} else {
					if (strtotime($this->changetimefromUTC($row['mesSent']) > strtotime("-2 minutes"))) {
					 	$output .='<div class="card rounded float-right z-depth-0 mb-1 last" style="max-width: 60%; background: #CBDAEF;"><div class="card-body p-2"><div class="dark-text style="font-size: 16px;">'.$row['chat'].'</div></div><p class="text-muted p-2 text-right" style="font-size: 12px;">'.$this->changetimefromUTC($row['mesSent']).'</p></div>';
					} else {
						$output .='<div class="card rounded z-depth-0 mb-1 last" style="max-width: 60%; background: #CBDAEF;"><div class="card-body p-2">';
						if($row['parent_message'] != 0 ){
							$chat = $this->messages_model->get_message($row['parent_message']);
							$output .= '<div class="text-muted ml-3" style="font-size: 16px;">'.$chat['message'].'</div><p class="text-muted text-left ml-3" style="font-size: 12px;">You replied to '.ucwords($chat["first_name"]).' '.ucwords($chat["last_name"]).' '.$this->changetimefromUTC($chat['timestamp']).'</p><hr class="mt-1 mb-3">';
						}
						$output .=	'<p class="dark-text" style="font-size: 16px;">'.$row['chat'].'</p></div><p class="text-muted p-2 text-right" style="font-size: 12px;">'.$this->changetimefromUTC($row['mesSent']).'<a class="delete_chat" id="'.$row['chat_ID'].'"><span class="red-text p-2">&times;</span></a></p></div>';
					}		
				}
				$output .= '</div>';
				if(($row['mesStat'] == '1') && ($i == $total)){
					$output .= '<p class="text-muted font-italic text-right pr-3" style="font-size: 12px;">Seen</p>';
				}
				$i++;
			} else {
				$other++;
				$output .= '<div class="d-flex justify-content-start mb-1 align-items-center">';
				$output .= '<div class="profile-photo message-photo"><img src="'.base_url().'assets/img/users/'.$row['usImg'].'" alt="avatar" class="rounded-circle avatar mr-2 ml-0 chat-mes-id-2" style="height: 50px;width: 50px"><span class="state"></span></div>';
				if($row['mesStat'] == '2'){
				$output .= ' <div class="card bg-white rounded-pill z-depth-0 mb-1 message-text w-50"><div class="card-body"><p class="card-text text-black font-italic">This message has been removed.</p></div></div></div>';
				} else {
				$output .= '<div class="card border border-light bg-white rounded z-depth-0 mb-1 message-text" style="max-width: 60%"><div class="card-body p-2">';
				if($row['parent_message'] != 0 ){
					$chat = $this->messages_model->get_message($row['parent_message']);
					$output .= '<div class="text-muted ml-3" style="font-size: 16px;">'.$chat['message'].'</div><p class="text-left ml-3 text-muted" style="font-size: 12px;">'.ucwords($row["first_name"]).' '.ucwords($row["last_name"]).' replied to You '.$this->changetimefromUTC($chat['timestamp']).'</p><hr class="mt-1 mb-3">';
				}
				$output .= '<div class="black-text chat_texts_'.$row['chat_ID'].'" style="font-size: 16px;">
				'.$row['chat'].'</div></div><p class="card-text text-muted p-1 ml-2 text-left" style="font-size: 12px;">'.$this->changetimefromUTC($row['mesSent']).'</p></div><a class="replay ml-2" data-message-id="'.$row['chat_ID'].'"><i class="fas fa-reply"></i></a></div>';
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

				$output .= '<div class="d-flex justify-content-end align-items-center">';
				if($row['mesStat'] == '2'){
					$output .= '<div class="card bg-white rounded-pill w-50 text-right z-depth-0 mb-1 last"><div class="card-body"><p class="card-text dark-text font-italic">You removed this message.</p></div></div>';
				} else {
					if (strtotime($this->changetimefromUTC($row['mesSent']) > strtotime("-2 minutes"))) {
					 	$output .='<div class="card rounded float-right z-depth-0 mb-1 last" style="max-width: 60%; background: #CBDAEF;"><div class="card-body p-2"><div class="dark-text style="font-size: 16px;">'.$row['chat'].'</div></div><p class="text-muted p-2 text-right" style="font-size: 12px;">'.$this->changetimefromUTC($row['mesSent']).'</p></div>';
					} else {
						$output .='<div class="card rounded z-depth-0 mb-1 last" style="max-width: 60%; background: #CBDAEF;"><div class="card-body p-2">';
						if($row['parent_message'] != 0 ){
							$chat = $this->messages_model->get_message($row['parent_message']);
							$output .= '<div class="text-muted ml-3" style="font-size: 16px;">'.$chat['message'].'</div><p class="text-muted text-left ml-3" style="font-size: 12px;">You replied to '.ucwords($chat["first_name"]).' '.ucwords($chat["last_name"]).' '.$this->changetimefromUTC($chat['timestamp']).'</p><hr class="mt-1 mb-3">';
						}
						$output .=	'<p class="dark-text" style="font-size: 16px;">'.$row['chat'].'</p></div><p class="text-muted p-2 text-right" style="font-size: 12px;">'.$this->changetimefromUTC($row['mesSent']).'<a class="delete_chat" id="'.$row['chat_ID'].'"><span class="red-text p-2">&times;</span></a></p></div>';
					}		
				}
				$output .= '</div>';
				$i++;
			} else {
				$other++;
				$output .= '<div class="d-flex justify-content-start mb-1 align-items-center">';
				$output .= '<div class="profile-photo message-photo mt-2"><img src="'.base_url().'assets/img/users/'.$row["usImg"].'" alt="avatar" class="rounded-circle avatar mr-2 ml-0 chat-mes-id-2" style="height: 50px;width: 50px"><span class="state"></span></div>';
				if($row["mesStat"] == '2'){
				$output .= '<div class="card bg-white rounded-pill w-50 z-depth-0 mb-1 message-text"><div class="card-body"><p class="card-text text-black font-italic">This message has been removed.</p></div></div></div>';
				} else {
				$output .= '<div class="card border rounded z-depth-0 mb-1 message-text" style="max-width: 60%"><div class="card-body p-2">';
				if($row['parent_message'] != 0 ){
					$chat = $this->messages_model->get_group_message($row['parent_message']);
					$output .= '<div class="text-muted ml-3" style="font-size: 16px;">'.$chat['message'].'</div><p class="text-left ml-3 text-muted" style="font-size: 12px;">'.ucwords($row["first_name"]).' '.ucwords($row["last_name"]).' replied to '.ucwords($chat["first_name"]).' '.ucwords($chat["last_name"]).'</p><hr class="mt-1 mb-3">';
				}
				$output .= '<p class="card-text black-text" style="font-size: 12px;">'.ucwords($row["first_name"]).' '.ucwords($row["last_name"]).'</p><div class="card-text black-text chat_texts_'.$row['chat_ID'].'" style="font-size: 16px;">'.$row["chat"].'</div></div><p class="card-text text-muted text-left mr-1 p-2" style="font-size: 12px;">'.$this->changetimefromUTC($row["mesSent"]).'</p></div><a class="group_replay ml-2" data-message-id="'.$row['chat_ID'].'"><i class="fas fa-reply"></i></a></div>';
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
		$message = $this->convert($this->input->post('chat_message'));
		$data = $this->messages_model->send_message($this->session->userdata('user_id'), $this->input->post('user_ID'), $message, $this->input->post('chat_ID'));
		echo json_encode($data);
	}

	function send_group_message() {
		$tagged_users_id = $this->get_tagged_users($this->input->post('chat_message'), '<a href="./user-profile/', '">@');
		$message = $this->convert($this->input->post('chat_message'));

		$data = $this->messages_model->send_group_message($this->session->userdata('user_id'), $this->input->post('group_ID'), $message, $this->input->post('chat_ID'), $tagged_users_id);
		echo json_encode($data);
	}

	function get_tagged_users($str, $startDelimiter, $endDelimiter){
		$contents = array();
		$startDelimiterLength = strlen($startDelimiter);
		$endDelimiterLength = strlen($endDelimiter);
		$startFrom = $contentStart = $contentEnd = 0;
		while (false !== ($contentStart = strpos($str, $startDelimiter, $startFrom))) {
		    $contentStart += $startDelimiterLength;
		    $contentEnd = strpos($str, $endDelimiter, $contentStart);
			    if (false === $contentEnd) {
			      break;
			    }
		    $contents[] = substr($str, $contentStart, $contentEnd - $contentStart);
		    $startFrom = $contentEnd + $endDelimiterLength;
		}

		return $contents;
	}

	function create_message() {
		$toID = $this->user_model->get_users($this->input->post('user_ID'));
		if(!$toID){
			$data = array(
				'error' => true,
				'message' => 'User does not exist.'
			);
		} else {
			$message = $this->convert($this->input->post('chat_message'));
			$data = $this->messages_model->send_message($this->session->userdata('user_id'), $toID['id'], $message, 0);
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
		echo json_encode($output);
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