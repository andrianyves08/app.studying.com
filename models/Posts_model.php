<?php
	class Posts_model extends CI_Model {
    public function __construct(){
        $this->load->database();
    }

    public function get_review_status(){
		$this->db->select('review_post_status');
		$query = $this->db->get_where('settings', array('id' => '1'));

		return $query->row_array();
	}

	public function get_post($id = FALSE){
		$this->db->select('users.first_name as first_name, users.last_name as last_name, users.image as image, users_posts.id as post_ID, users.id as user_ID, users_posts.status as post_status, users_posts.timestamp as timestamp, users_posts.posts as posts');
    	$this->db->join('users', 'users.id = users_posts.user_ID', 'left');
		if($id === FALSE){
			$query = $this->db->get('users_posts');
			return $query->result_array();
		}
		$query = $this->db->get_where('users_posts', array('users_posts.id' => $id));
		return $query->row_array();
	}

    public function get_posts($limit, $start, $id = FALSE){
    	$this->db->select('users.first_name as first_name, users.last_name as last_name, users.image as image, users_posts.id as post_ID, users_posts.user_ID as user_ID, users_posts.status as post_status, users_posts.timestamp as timestamp, users_posts.posts as posts');
    	$this->db->join('users', 'users.id = users_posts.user_ID', 'left');
    	$this->db->order_by('users_posts.timestamp', 'DESC');
    	if(!empty($limit)){
			$this->db->limit($limit, $start);
		}
		if($id === FALSE){
			$query = $this->db->get('users_posts');
			return $query->result_array();
		}
		$query = $this->db->get_where('users_posts', array('users_posts.user_ID' => $id));
		return $query->result_array();
	}

	public function get_post_images($id){
		$this->db->select('users_posts_images.*, users_posts.user_ID');
    	$this->db->join('users_posts', 'users_posts.id = users_posts_images.post_ID');
		$query = $this->db->get_where('users_posts_images', array('post_ID' => $id));
		return $query->result_array();
	}

	public function get_comments($post_ID = FALSE){
		$this->db->select('users_posts_comments.*, users_posts_comments.user_ID as user_ID, users_posts_comments.id as comment_ID, users.last_name, users.first_name, users.image, users_posts_comments.id as comment_ID, , users_posts_comments.image as comment_image, users_posts.user_ID as owner_post');
    	$this->db->join('users', 'users.id = users_posts_comments.user_ID', 'left');
    	$this->db->join('users_posts', 'users_posts.id = users_posts_comments.post_ID', 'left');
    	$this->db->where('users_posts_comments.parent_comment', 0);
		$this->db->order_by('users_posts_comments.timestamp', 'ASC');
    	if($post_ID === FALSE){
			$query = $this->db->get('users_posts_comments');
			return $query->result_array();
		}
		$this->db->where('users_posts_comments.post_ID', $post_ID);
		$query = $this->db->get('users_posts_comments');
		return $query->result_array();
	}

	public function get_replies($post_ID, $comment_ID){
		$this->db->select('users_posts_comments.*, users_posts_comments.id as comment_ID, users.last_name, users.first_name, users.image, users_posts.user_ID as owner_post, users_posts_comments.image as comment_image');
    	$this->db->join('users', 'users.id = users_posts_comments.user_ID', 'left');
    	$this->db->join('users_posts', 'users_posts.id = users_posts_comments.post_ID', 'left');
		$this->db->where('users_posts_comments.post_ID', $post_ID);
		$this->db->where('users_posts_comments.parent_comment', $comment_ID);
		$this->db->order_by('users_posts_comments.timestamp', 'ASC');
		$query = $this->db->get('users_posts_comments');
		return $query->result_array();
	}

	public function get_users_by_names($name){
		$this->db->like('first_name', $name);
		$this->db->like('last_name', $name);
		$query = $this->db->get('users');
		return $query->row_array();
	}

	public function create($images, $posts, $user_ID, $tagged_users){
		$this->db->trans_begin();
		$this->load->model('user_model', 'users');

		$sql = $this->get_review_status();

		if($sql['review_post_status'] == 0){
			$status = 1;
		} else {
			$status = 0;
		}

		$data = array(
			'user_ID' => $user_ID,
			'posts' => $posts,
			'status' => $status,
		);
		$this->db->set('timestamp', 'NOW()', FALSE);
		$this->db->insert('users_posts', $data);
		$post_id = $this->db->insert_id();

		$total = count($tagged_users);
		for($i=0; $i<$total; $i++) {
			if(trim($tagged_users[$i] != '')) {
		        $tagged_id = $tagged_users[$i];
		        $user = $this->users->get_users($tagged_id);

		        $data2 = array(
		        	'type' => 1,
		        	'notification_option_id' => 7,
		        	'id' => $post_id,
					'notified' => $user['id'],
					'notifier' => $user_ID,
				);
				$this->db->insert('users_notifications', $data2);
			}
		}

		$total = count($images);
		for($i=0; $i<$total; $i++) {
			if(trim($images[$i] != '')) {
				$image = $images[$i];
		        $data3 = array(
		        	'post_ID' => $post_id,
		        	'image' => $image
				);
				$this->db->insert('users_posts_images', $data3);
			}
		}

		$this->db->set('exp', 'exp+30', FALSE);
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

	public function edit($post_ID, $posts, $user_ID, $tagged_users){
		$this->db->trans_begin();
		$this->db->delete('users_notifications', array('id' => $post_ID, 'notification_option_id' => 7));
		$this->load->model('user_model', 'users');

		$sql = $this->get_review_status();

		if($sql['review_post_status'] == 0){
			$status = 1;
		} else {
			$status = 0;
		}

		$data = array(
			'user_ID' => $user_ID,
			'posts' => $posts,
			'status' => $status,
		);
		$this->db->set('timestamp', 'NOW()', FALSE);
		$this->db->where('id', $post_ID);
		$this->db->update('users_posts', $data);

		$total = count($tagged_users);
		for($i=0; $i<$total; $i++) {
			if(trim($tagged_users[$i] != '')) {
		        $tagged_id = $tagged_users[$i];
		        $user = $this->users->get_users($tagged_id);
		        $data2 = array(
		        	'type' => 1,
		        	'notification_option_id' => 7,
		        	'id' => $post_ID,
					'notified' => $user['id'],
					'notifier' => $user_ID,
				);
				$this->db->insert('users_notifications', $data2);
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

	public function add_comments($image, $post_ID, $comment, $comment_ID, $owner_ID, $user_ID, $tagged_users){
		$this->db->trans_begin();
		$this->load->model('user_model', 'users');

		$query = $this->db->get_where('users_posts', array('id'=>$post_ID));
		
		if($query->num_rows() == 0){
			return false;
		} else {
			$data = array(
				'post_ID' => $post_ID,
				'parent_comment' => $comment_ID,
				'comment' => $comment,
				'image' => $image,
				'user_ID' => $user_ID
			);
		
			$this->db->set('timestamp', 'NOW()', FALSE);
			$this->db->insert('users_posts_comments', $data);

			if($owner_ID != $user_ID){
				if($comment_ID == 0){
					$data1 = array(
						'type' => 1,
						'notification_option_id' => 2,
						'id' => $post_ID,
						'notified' => $owner_ID,
						'notifier' => $user_ID
					);
				} else {
					$data1 = array(
						'type' => 1,
						'notification_option_id' => 4,
						'id' => $post_ID,
						'notified' => $owner_ID,
						'notifier' => $user_ID
					);
				}
				$sql = $this->db->insert('users_notifications', $data1);
			}

			$this->db->set('exp', 'exp+20', FALSE);
			$this->db->where('id', $user_ID);
			$this->db->update('users');

			$total = count($tagged_users);
			if($total != 0){
				for($i=0; $i<$total; $i++) {
					if(trim($tagged_users[$i] != '')) {
				        $tagged_id = $tagged_users[$i];
				        $user = $this->users->get_users($tagged_id);

				        $data2 = array(
				        	'type' => 1,
				        	'notification_option_id' => 10,
				        	'id' => $post_ID,
							'notified' => $user['id'],
							'notifier' => $user_ID,
						);
				    	
						$this->db->insert('users_notifications', $data2);
					}
				}
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

	public function get_liked($user_ID){
		$this->db->where('user_ID', $user_ID);
		$query = $this->db->get('users_posts_reacts');
		return $query->result_array();
	}

	public function total_likes($post_ID){
		$this->db->where('post_ID', $post_ID);
		return $this->db->count_all_results('users_posts_reacts');
	}

	public function total_comments($post_ID){
		$this->db->where('post_ID', $post_ID);
		return $this->db->count_all_results('users_posts_comments');
	}

	public function get_total_likes_comments($comment_ID){
		$this->db->where('comment_ID', $comment_ID);
		return $this->db->count_all_results('users_posts_comments_reacts');
	}

	public function get_total_replies($comment_ID){
		$this->db->where('parent_comment', $comment_ID);
		return $this->db->count_all_results('users_posts_comments');
	}

	public function get_liked_comments($user_ID){
		$this->db->where('user_ID', $user_ID);
		$query = $this->db->get('users_posts_comments_reacts');
		return $query->result_array();
	}

	public function like_post($post_ID, $owner_ID, $user_ID){
		$this->db->trans_begin();

		$data = array(
			'post_ID' => $post_ID,
			'user_ID' => $user_ID,
		);
		$this->db->insert('users_posts_reacts', $data);

		if($owner_ID != $user_ID){
			$data1 = array(
				'type' => 1,
				'notification_option_id' => 3,
				'id' => $post_ID,
				'notified' => $owner_ID,
				'notifier' => $user_ID,
			);
			$this->db->insert('users_notifications', $data1);
		}

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function like_comment($comment_ID, $owner_ID, $post_ID, $user_ID){
		$this->db->trans_begin();

		$data = array(
			'comment_ID' => $comment_ID,
			'user_ID' => $user_ID,
		);
		$this->db->insert('users_posts_comments_reacts', $data);
		
		if($user_ID != $owner_ID){
			$data1 = array(
				'type' => 1,
				'notification_option_id' => 8,
				'id' => $post_ID,
				'notified' => $owner_ID,
				'notifier' => $user_ID,
			);
			$this->db->insert('users_notifications', $data1);
		}
		
		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function unlike_post($post_ID, $user_ID){
		$this->db->delete('users_notifications', array('notification_option_id' => 3, 'id' => $post_ID, 'notifier' => $user_ID));
		$this->db->delete('users_posts_reacts', array('post_ID' => $post_ID, 'user_ID' => $user_ID));
	}

	public function unlike_comment($comment_ID, $user_ID){
		$this->db->delete('users_posts_comments_reacts', array('comment_ID' => $comment_ID, 'user_ID' => $user_ID));
		$this->db->delete('users_notifications', array('notification_option_id' => 8, 'type' => 1, 'notifier' => $user_ID));
	}

	public function delete_post($post_ID){
		$this->db->delete('users_posts', array('id' => $post_ID));
	}

	public function delete_comment($comment_ID){
		$this->db->delete('users_posts_comments', array('id' => $comment_ID));
		$this->db->delete('users_posts_comments', array('parent_comment' => $comment_ID));
	}

	public function approve_post($post_ID, $user_ID){
		$this->db->trans_begin();

		$this->db->set('status', '1');
		$this->db->where('id', $post_ID);
		$this->db->update('users_posts');

		$data1 = array(
			'type' => 1,
			'notification_option_id' => 1,
			'id' => $post_ID,
			'notified' => $user_ID,
		);
		$this->db->insert('users_notifications', $data1);

		$this->db->set('exp', 'exp+30', FALSE);
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

	public function deny_post($post_ID, $user_ID){
		$this->db->trans_begin();

		$this->db->set('status', '2');
		$this->db->where('id', $post_ID);
		$this->db->update('users_posts');

		$data1 = array(
			'type' => 1,
			'notification_option_id' => 6,
			'id' => $post_ID,
			'notifier' => $user_ID,
		);
		$this->db->insert('users_notifications', $data1);

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function get_on_review_posts(){
		$this->db->where('status', '0');
		return $this->db->count_all_results('users_posts');
	}

	public function get_notifications($user_ID){
		$this->db->select('users_notifications.*, users.first_name as first_name, users.last_name as last_name, users.image as image, users_posts.posts as posts, users_posts.id as post_ID');
    	$this->db->join('users', 'users.id = users_notifications.notifier', 'left');
    	$this->db->join('users_posts', 'users_posts.id = users_notifications.id', 'left');
		$this->db->where('users_notifications.notified', $user_ID);
		$this->db->order_by('users_notifications.timestamp', 'DESC');
		$query = $this->db->get('users_notifications');
		return $query->result_array();
	}

	public function seen($user_ID){
		$this->db->trans_begin();

		$this->db->set('status', '1');
		$this->db->where('notified', $user_ID);
		$this->db->update('users_notifications');

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function total_posts(){
		return $this->db->count_all('users_posts');
	}

	public function get_likers($post_ID){
		$this->db->select('users.first_name, users.last_name, users.image, users.id as user_ID');
		$this->db->join('users', 'users.id = users_posts_reacts.user_ID');
    	$this->db->order_by('users.first_name', 'ASC');
		$query = $this->db->get_where('users_posts_reacts', array('post_ID' => $post_ID));

		return $query->result_array();
	}
}