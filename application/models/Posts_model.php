<?php
	class Posts_model extends CI_Model {
    public function __construct(){
        $this->load->database();
    }

    public function get_posts($limit, $start, $id = FALSE){
    	$this->db->select('users.first_name as first_name, users.last_name as last_name, users.image as image, users_posts.id as post_ID, users.id as user_ID, users_posts.status as post_status, users_posts.timestamp as timestamp, users_posts.posts as posts, users_posts.image as post_image');
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

	public function get_comments($post_ID){
		$this->db->select('users_posts_comments.*, users_posts_comments.user_ID as user_ID, users_posts_comments.id as comment_ID, users.last_name, users.first_name, users.image, users_posts_comments.id as comment_ID, , users_posts_comments.image as comment_image, users_posts.user_ID as owner_post');
    	$this->db->join('users', 'users.id = users_posts_comments.user_ID', 'left');
    	$this->db->join('users_posts', 'users_posts.id = users_posts_comments.post_ID', 'left');
		$this->db->where('users_posts_comments.post_ID', $post_ID);
		$this->db->where('users_posts_comments.parent_comment', 0);
		$this->db->order_by('users_posts_comments.timestamp', 'ASC');
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

	public function create($image, $posts, $user_ID){
		$this->db->trans_begin();
		$this->db->cache_delete('home', 'index');
		$this->db->cache_delete('default', 'index');

		$data = array(
			'user_ID' => $user_ID,
			'posts' => $posts,
			'image' => $image,
			'status' => 0,
		);
		$this->db->insert('users_posts', $data);

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function add_comments($image, $post_ID, $comment, $comment_ID, $owner_ID, $user_ID){
		$this->db->trans_begin();
		$this->db->cache_delete('home', 'index');
		$this->db->cache_delete('default', 'index');

		$query = $this->db->get_where('users_posts',array('id'=>$post_ID));
		
		if($query->num_rows() == 0){
			return false;
		} else {
			if(empty($comment_ID)){
				$data = array(
					'post_ID' => $post_ID,
					'comment' => $comment,
					'image' => $image,
					'user_ID' => $user_ID
				);
			} else {
				$data = array(
					'post_ID' => $post_ID,
					'parent_comment' => $comment_ID,
					'comment' => $comment,
					'image' => $image,
					'user_ID' => $user_ID
				);
			}
			
			$this->db->insert('users_posts_comments', $data);

			// approve/disapparove post
			// commented
			// liked
			// replied
			if($owner_ID != $user_ID){
				if(empty($comment_ID)){
					$data1 = array(
						'type' => 2,
						'post_ID' => $post_ID,
						'user_ID' => $user_ID,
						'owner' => $owner_ID
					);
				} else {
					$data1 = array(
						'type' => 4,
						'post_ID' => $post_ID,
						'user_ID' => $user_ID,
						'owner' => $owner_ID
					);
				}
				
				$this->db->insert('users_notifications', $data1);
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
		$this->db->cache_delete('home', 'index');
		$this->db->cache_delete('default', 'index');

		$data = array(
			'post_ID' => $post_ID,
			'user_ID' => $user_ID,
		);
		$this->db->insert('users_posts_reacts', $data);

		// approve/disapparove post
		// commented
		// liked
		// replied
		if($owner_ID != $user_ID){
			$data1 = array(
				'type' => 3,
				'post_ID' => $post_ID,
				'user_ID' => $user_ID,
				'owner' => $owner_ID,
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

	public function like_comment($comment_ID, $user_ID){
		$this->db->trans_begin();
		$this->db->cache_delete('home', 'index');
		$this->db->cache_delete('default', 'index');

		$data = array(
			'comment_ID' => $comment_ID,
			'user_ID' => $user_ID,
		);
		$this->db->insert('users_posts_comments_reacts', $data);

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function unlike_post($post_ID, $user_ID){
		$this->db->delete('users_posts_reacts', array('post_ID' => $post_ID, 'user_ID' => $user_ID));
	}

	public function unlike_comment($comment_ID, $user_ID){
		$this->db->delete('users_posts_comments_reacts', array('comment_ID' => $comment_ID, 'user_ID' => $user_ID));
	}

	public function delete_post($post_ID){
		$this->db->cache_delete('home', 'index');
		$this->db->cache_delete('default', 'index');
		$this->db->delete('users_posts', array('id' => $post_ID));
	}

	public function delete_comment($comment_ID){
		$this->db->cache_delete('home', 'index');
		$this->db->cache_delete('default', 'index');
		$this->db->delete('users_posts_comments', array('id' => $comment_ID));
		$this->db->delete('users_posts_comments', array('parent_comment' => $comment_ID));
	}

	public function approve_post($post_ID, $user_ID){
		$this->db->trans_begin();
		$this->db->cache_delete('home', 'index');
		$this->db->cache_delete('default', 'index');

		$this->db->set('status', '1');
		$this->db->where('id', $post_ID);
		$this->db->update('users_posts');

		// approve/disapparove post
		// commented
		// liked
		// replied
		$data1 = array(
			'type' => 1,
			'post_ID' => $post_ID,
			'owner' => $user_ID,
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

	public function not_accept_post($post_ID, $user_ID){
		$this->db->trans_begin();
		$this->db->cache_delete('home', 'index');
		$this->db->cache_delete('default', 'index');

		$this->db->set('status', '2');
		$this->db->where('id', $post_ID);

		$this->db->update('users_posts');

		// approve/disapparove post
		// commented
		// liked
		// replied
		$data1 = array(
			'type' => 5,
			'post_ID' => $post_ID,
			'owner' => $user_ID,
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

	public function get_notifications($user_ID, $status){
		$this->db->select('users_notifications.*, users.first_name as first_name, users.last_name as last_name, users_posts.posts as posts');
    	$this->db->join('users', 'users.id = users_notifications.user_ID', 'left');
    	$this->db->join('users_posts', 'users_posts.id = users_notifications.post_ID', 'left');
		$this->db->where('users_notifications.owner', $user_ID);
		$this->db->where('users_notifications.status', $status);
		$this->db->order_by('users_notifications.timestamp', 'DESC');
		$query = $this->db->get('users_notifications');
		return $query->result_array();
	}

	public function seen($user_ID){
		$this->db->trans_begin();
		$this->db->cache_delete('home', 'index');
		$this->db->cache_delete('default', 'index');

		$this->db->set('status', '1');
		$this->db->where('owner', $user_ID);
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
}