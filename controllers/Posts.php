<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Posts extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('upload');
	}

	
	function get_post() {
		$data = $this->posts_model->get_post($this->input->post('post_ID'));
		echo json_encode($data);
	}

	function get_full_post() {
		$post = $this->posts_model->get_post($this->input->post('post_ID'));
		$output = '';

		if($post['post_status'] == 1){
			$output .=	'<div class="media mt-2"><img class="ml-2 rounded-circle card-img-100 d-flex z-depth-1 mr-2 chat-mes-id" src="'.base_url().'assets/img/users/'.$post['image'].'" style="height: 50px; width: 50px" alt="'.ucwords($post['first_name']).' '.ucwords($post['last_name']).' profile photo"><div class="media-body"><h5><a class="text-dark profile_popover" href="'.base_url().'user-profile/'.$post['user_ID'].'" data-user-id="'.$post['user_ID'].'">'.ucwords($post['first_name']).' '.ucwords($post['last_name']).'</a>'; 	
			$output .= '<button type="button" class="close mr-2" data-dismiss="modal" aria-label="Close">x</button>';
			$output .= '</h5><span class="text-muted text-dark"><small>'.$this->changetimefromUTC($post['timestamp']).'</small></span></div></div><div class="card-body py-0 mt-2">'.ucfirst($post['posts']);
			$output .= '<div class="mt-4 mb-2"><span class="total_likes total_likes_'.$post['post_ID'].'" data-post-id="'.$post['post_ID'].'"></span><span class="float-right text-center total_comments total_comments_'.$post['post_ID'].' mb-2" data-post-id="'.$post['post_ID'].'" data-user-id="'.$post['user_ID'].'"></span></div><div class="d-flex justify-content-between text-center border-top border-bottom w-100"><a class="p-3 ml-2 liked liked_'.$post['post_ID'].'" data-post-id="'.$post['post_ID'].'" data-user-id="'.$post['user_ID'].'"><i class="far fa-thumbs-up mr-2"></i> Like</a><a class="p-3 ml-2 view_comments" data-post-id="'.$post['post_ID'].'" data-user-id="'.$post['user_ID'].'"><i class="far fa-comment-alt mr-2"></i> Comment</a><p class="p-3 text-red text-muted" disabled><i class="fas fa-share mr-2"></i>Share</p></div><div class="full_post_comments'.$post['post_ID'].'">';
			$comments = $this->posts_model->get_comments($post['post_ID']);
			foreach ($comments as $comment) { 
    			$output .= '<div class="media m-2 comments_ID_'.$comment['comment_ID'].'"><img class="rounded-circle card-img-100 d-flex mx-auto mb-3 ml-2 chat-mes-id" src="'.base_url().'assets/img/users/'.$comment['image'].'" alt="Profile Photo"><div class="media-body text-left ml-2"><div class="bg-light rounded p-2"><h6 class="font-weight-bold m-0"><a class="text-dark profile_popover" href="./user-profile/'.$comment['user_ID'].'" data-user-id="'.$post['user_ID'].'">'.ucwords($comment['first_name']).' '.ucwords($comment['last_name']).'</a>';
                if($comment['user_ID'] == $this->session->userdata('user_id')){
    				$output .= '<a class="float-right red-text m-1"><i class="fas fa-times delete_comment fa-xs" data-comment-id="'.$comment['comment_ID'].'" data-post-id="'.$comment['post_ID'].'"></i></a>';
                } 
    			$output .= '</h6>'.$comment['comment'];
				if(!empty($comment['comment_image'])) {
 					$output .= '<div class="mt-2 h-50"><div class="d-flex"><a rel="gallery_'.$comment['comment_ID'].'" href="'.base_url().'assets/img/posts/'.hash('md5', $comment['user_ID']).'/'.$comment['comment_image'].'" class="swipebox"><img src="'.base_url().'assets/img/posts/'.hash('md5', $comment['user_ID']).'/'.$comment['comment_image'].'" class="img-fluid img-thumbnail" style="width: 200px;"></a></div></div>';
				} 
				$output .= '</div><div class="mb-2"><a class="ml-2 like_comment like_comment_'.$comment['comment_ID'].'" data-comment-id="'.$comment['comment_ID'].'" data-user-id="'.$comment['user_ID'].'" data-post-id="'.$comment['post_ID'].'">Like</a><a class="ml-2 view_replies" data-comment-id="'.$comment['comment_ID'].'" data-post-id="'.$comment['post_ID'].'" data-user-id="'.$comment['user_ID'].'" data-post="1">Reply</a><span class="text-left ml-2" style="font-size: 12px;">'.$this->time_elapsed_string($comment['timestamp']).'</span>';
 
	            $sql= $this->posts_model->get_total_replies($comment['comment_ID']);
	            $sql2= $this->posts_model->get_total_likes_comments($comment['comment_ID']);

				if($sql2 > 0){
					$output .= '<span class="float-right blue-text"><i class="far fa-thumbs-up"></i> '.$sql2.'</span></div>';
				} else {
					$output .= '</div>';        
				}
				if($sql > 0){
					if($sql > 1){
						$output .= '<a class="ml-4 view_replies" data-comment-id="'.$comment['comment_ID'].'" data-post-id="'.$comment['post_ID'].'" data-user-id="'.$comment['user_ID'].'" data-post="1"><i class="fas fa-reply mr-2"></i> '.$sql.' replies</a>';
					} else {
						$output .= '<a class="ml-4 view_replies" data-comment-id="'.$comment['comment_ID'].'" data-post-id="'.$comment['post_ID'].'" data-user-id="'.$comment['user_ID'].'" data-post="1"><i class="fas fa-reply mr-2"></i> '.$sql.' reply</a>';
					}
				}
				$output .= '<div id="full_post_add_reply_'.$comment['comment_ID'].'"></div></div></div>';
			}
			$output .= 	'</div></div><a class="text-center view_comments_'.$post['post_ID'].' view_comments mb-2" data-post-id="'.$post['post_ID'].'" data-user-id="'.$post['user_ID'].'"></a></div>';
		}
		echo json_encode($output);
	}

	function get_post_images() {
		$images = $this->posts_model->get_post_images($this->input->post('post_ID'));
		$data = array();
		$i = 0;
		foreach ($images as $image) {
			$data[] = [
				'id' => $image['id'],
		        'post_ID' => $image['post_ID'],
		        'image' => $image['image'],
		        'user_ID' => hash('md5', $image['user_ID']),
		        'index' => $i
			];
			$i++;
		}
		echo json_encode($data);
	}

	function total_likes() {
		$data = $this->posts_model->total_likes($this->input->post('post_ID'));
		echo json_encode($data);
	}

	function total_comments() {
		$data = $this->posts_model->total_comments($this->input->post('post_ID'));
		echo json_encode($data);
	}

	function get_liked() {
		$data = $this->posts_model->get_liked($this->session->userdata('user_id'));
		echo json_encode($data);
	}

	function get_likers() {
		$data = $this->posts_model->get_likers($this->input->post('post_ID'));
		foreach($data as $key => $value) {
		  	$data[$key]['first_name'] = ucwords($data[$key]['first_name']).' '.ucwords($data[$key]['last_name']);
		}
		echo json_encode($data);
	}

	function get_liked_comments() {
		$data = $this->posts_model->get_liked_comments($this->session->userdata('user_id'));
		echo json_encode($data);
	}

	function create() {
		$photos = array();
		if(isset($_FILES['post_image'])) {
            if (!file_exists('./assets/img/posts/'.hash('md5', $this->session->userdata('user_id')))) {
				mkdir('./assets/img/posts/'.hash('md5', $this->session->userdata('user_id')), 0777, true);
				$fi = 0;
			} else {
				$files = scandir('./assets/img/posts/'.hash('md5', $this->session->userdata('user_id')));
				$fi = count($files)-2;
			}

            $files = $_FILES;
            $count = count($_FILES ['post_image'] ['name']);
            $uploads = $_FILES['post_image']['name'];
            for ($i = 0; $i < $count; $i ++) {
                $_FILES['post_image']['name'] = $files['post_image']['name'][$i];
                $_FILES['post_image']['type'] = $files['post_image']['type'][$i];
                $_FILES['post_image']['tmp_name'] = $files['post_image']['tmp_name'][$i];
                $_FILES['post_image']['error'] = $files['post_image']['error'][$i];
                $_FILES['post_image']['size'] = $files['post_image']['size'][$i];

                $image_name = hash('md5', $this->session->userdata('user_id')).$fi.".".pathinfo($_FILES['post_image']['name'], PATHINFO_EXTENSION); 
	            $config['allowed_types'] = 'gif|jpg|png';
	            $config['upload_path'] = './assets/img/posts/'.hash('md5', $this->session->userdata('user_id'));
	            $config['file_name'] = $image_name;
                $this->upload->initialize($config);

                if($this->upload->do_upload('post_image')){
                     $data = $this->upload->data();
                    //Compress photo
                    $config['photo_library']='gd2';
                    $config['source_image']='./assets/img/posts/'.hash('md5', $this->session->userdata('user_id'))."/".$image_name;
                    $config['create_thumb']= FALSE;
                    $config['maintain_ratio']= TRUE;
                    $config['new_image']= './assets/img/posts/'.hash('md5', $this->session->userdata('user_id'))."/".$image_name;
                    $config['quality']= '70%';
                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();
                    $photos[] = $image_name; 
                }
                $fi++;
            }
        }
		$tagged_users_id = $this->get_tagged_users($this->input->post('posts'), '<a href="./user-profile/', '">@');
		
		if($photos != NULL || $this->input->post('posts') != NULL){
			$status = $this->posts_model->get_review_status();
			$posts = $this->convert($this->input->post('posts'));
			$data = $this->posts_model->create($photos, $posts, $this->session->userdata('user_id'), $tagged_users_id);
			if($status['review_post_status'] == 0){
				$this->session->set_flashdata('success', 'Post created successfully! gained 30 exp!');
			} else {
				$this->session->set_flashdata('success', 'Your post will be reviewed!');
			}
		} else {
			$this->session->set_flashdata('error', 'Enter a posts!');
		}
		redirect('');
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

	function edit() {
		$tagged_users_id = $this->get_tagged_users($this->input->post('edit_post_value'), '<a href="./user-profile/', '">@');
		if($this->input->post('edit_post_value') != NULL){
			$status = $this->posts_model->get_review_status();
			$data = $this->posts_model->edit($this->input->post('post_ID'), $this->input->post('edit_post_value'), $this->session->userdata('user_id'), $tagged_users_id);
			if($status['review_post_status'] == 0){
				$this->session->set_flashdata('success', 'Post updated successfully!');
			} else {
				$this->session->set_flashdata('success', 'Your post will be reviewed!');
			}
		} else {
			$this->session->set_flashdata('error', 'Enter a posts!');
		}

		redirect('');
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

	function liked() {
		if($this->input->post('status') == 1){
			$this->posts_model->unlike_post($this->input->post('posts'), $this->session->userdata('user_id'));
			$data = array(
				'status' => false,
			);
		} else {
			$this->posts_model->like_post($this->input->post('posts'), $this->input->post('user_ID'), $this->session->userdata('user_id'));
			$data = array(
				'status' => true,
			);
		}
		echo json_encode($data);
	}

	function like_comment() {
		if($this->input->post('status') == 1){
			$this->posts_model->unlike_comment($this->input->post('comment_ID'), $this->session->userdata('user_id'));
			$data = array(
				'status' => false,
			);
		} else {
			$this->posts_model->like_comment($this->input->post('comment_ID'), $this->input->post('user_ID'), $this->input->post('post_ID'), $this->session->userdata('user_id'));
			$data = array(
				'status' => true,
			);
		}
		echo json_encode($data);
	}

	function changetimefromUTC($time) {
		$data = $this->user_model->get_users($this->session->userdata('user_id'));

	    $changetime = new DateTime($time, new DateTimeZone('UTC'));
	    $changetime->setTimezone(new DateTimeZone($data['timezone']));
	    return $changetime->format('M j, Y h:i A');
	}

	function time_elapsed_string($time, $full = false) {
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

	function isMobile() {
		return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
	}

	function load_more() {
		if(!empty($this->input->post('user_ID'))){
			$user_ID = $this->input->post('user_ID');
		} else {
			$user_ID = FALSE;
		}
		$posts = $this->posts_model->get_posts(5, $this->input->post('start'), $user_ID);
		$output = '';

		foreach($posts as $post){
			if($post['post_status'] == 1){
				$output .=	'<div class="card posts mb-4"><div class="media mt-2"><img class="ml-2 rounded-circle card-img-100 d-flex z-depth-1 mr-2 chat-mes-id" src="'.base_url().'assets/img/users/'.$post['image'].'" style="height: 50px; width: 50px" alt="'.ucwords($post['first_name']).' '.ucwords($post['last_name']).' profile photo"><div class="media-body"><h5><a class="text-dark profile_popover" href="'.base_url().'user-profile/'.$post['user_ID'].'" data-user-id="'.$post['user_ID'].'">'.ucwords($post['first_name']).' '.ucwords($post['last_name']).'</a>'; 
				if ($post['user_ID'] == $this->session->userdata('user_id')) {
					$output .= '<a class="float-right mr-2 post_popover" data-toggle="popover" alt="'.$post['post_ID'].'" data-post-id="'.$post['post_ID'].'"><i class="fas fa-ellipsis-v"></i></span></a>';
				}
				$output .= '</h5><span class="text-muted text-dark"><small>'.$this->changetimefromUTC($post['timestamp']).'</small></span></div></div><div class="card-body py-0 mt-2">'.ucfirst($post['posts']);
				$images = $this->posts_model->get_post_images($post['post_ID']);
				$total = count($images);
				if (!empty($images)) {
					 $all_images = array();
					$total = count($images);
					foreach ($images as $image) {
						$all_images[] = base_url().'assets/img/posts/'.hash('md5', $post['user_ID']).'/'.$image['image'];
					}
					if($total == 1){
						$output .='<div class="mt-2"><span class="view_post" data-post-id="'.$image['post_ID'].'" data-user-id="'.$post['user_ID'].'"><a class="imgs-grid-image" data-id="0"><img src="'.base_url().'./assets/img/posts/'.hash('md5', $post['user_ID']).'/'.$image['image'].'" class="img-fluid img-thumbnail" style="width: 300px;"></a></span></div>';
					} else {
						$output .= '<span class="view_post" data-post-id="'.$image['post_ID'].'" data-user-id="'.$post['user_ID'].'"><span class="post_images_'.$post['post_ID'].'"></span></span>
							<script>
			                  var images = '.json_encode($all_images).';
			                  $(function() {
			                    $(".post_images_'.$post['post_ID'].'").imagesGrid({
			                        images: '.json_encode($all_images).',
			                        align: true,
			                        getViewAllText: function(imgsCount) { return "View all" }
			                    });
			                  });
			                </script>';
					}
				}
				$output .= '<div class="mt-4 mb-2"><span class="total_likes total_likes_'.$post['post_ID'].'" data-post-id="'.$post['post_ID'].'"></span><span class="float-right text-center total_comments total_comments_'.$post['post_ID'].' mb-2" data-post-id="'.$post['post_ID'].'" data-user-id="'.$post['user_ID'].'"></span></div><div class="d-flex justify-content-between text-center border-top border-bottom w-100"><a class="p-3 ml-2 liked liked_'.$post['post_ID'].'" data-post-id="'.$post['post_ID'].'" data-user-id="'.$post['user_ID'].'"><i class="far fa-thumbs-up mr-2"></i> Like</a><a class="p-3 ml-2 view_comments" data-post-id="'.$post['post_ID'].'" data-user-id="'.$post['user_ID'].'"><i class="far fa-comment-alt mr-2"></i> Comment</a><p class="p-3 text-red text-muted" disabled><i class="fas fa-share mr-2"></i>Share</p></div><div id="comment_section_'.$post['post_ID'].'">';
				$comments = $this->posts_model->get_comments($post['post_ID']);
				$q=1; 
				foreach ($comments as $comment) { 
        			$output .= '<div class="media m-2 comments_ID_'.$comment['comment_ID'].'"><img class="rounded-circle card-img-100 d-flex mx-auto mb-3 ml-2 chat-mes-id" src="'.base_url().'assets/img/users/'.$comment['image'].'" alt="Profile Photo"><div class="media-body text-left ml-2"><div class="bg-light rounded p-2"><h6 class="font-weight-bold m-0"><a class="text-dark profile_popover" href="'.base_url().'user-profile/'.$comment['user_ID'].'" data-user-id="'.$post['user_ID'].'">'.ucwords($comment['first_name']).' '.ucwords($comment['last_name']).'</a>';
                    if($comment['user_ID'] == $this->session->userdata('user_id')){
        				$output .= '<a class="float-right red-text m-1"><i class="fas fa-times delete_comment fa-xs" data-comment-id="'.$comment['comment_ID'].'" data-post-id="'.$comment['post_ID'].'"></i></a>';
                    } 
        			$output .= '</h6>'.$comment['comment'];
				if(!empty($comment['comment_image'])) {
					$output .= '<div class="mt-2 h-50"><div class="d-flex"><a rel="gallery_'.$comment['comment_ID'].'" href="'.base_url().'assets/img/posts/'.hash('md5', $comment['user_ID']).'/'.$comment['comment_image'].'" class="swipebox"><img src="'.base_url().'assets/img/posts/'.hash('md5', $comment['user_ID']).'/'.$comment['comment_image'].'" class="img-fluid img-thumbnail" style="width: 200px;"></a></div></div>';
				} 
				$output .= '</div><div class="mb-2"><a class="ml-2 like_comment like_comment_'.$comment['comment_ID'].'" data-comment-id="'.$comment['comment_ID'].'" data-user-id="'.$comment['user_ID'].'" data-post-id="'.$comment['post_ID'].'">Like</a><a class="ml-2 view_replies" data-comment-id="'.$comment['comment_ID'].'" data-post-id="'.$comment['post_ID'].'" data-user-id="'.$comment['user_ID'].'" data-post="0">Reply</a><span class="text-left ml-2" style="font-size: 12px;">'.$this->time_elapsed_string($comment['timestamp']).'</span>';
     
                $sql= $this->posts_model->get_total_replies($comment['comment_ID']);
                $sql2= $this->posts_model->get_total_likes_comments($comment['comment_ID']);

				if($sql2 > 0){
					$output .= '<span class="float-right blue-text"><i class="far fa-thumbs-up"></i> '.$sql2.'</span></div>';
				} else {
					$output .= '</div>';        
				}
				if($sql > 0){
					if($sql > 1){
						$output .= '<a class="ml-4 view_replies" data-comment-id="'.$comment['comment_ID'].'" data-post-id="'.$comment['post_ID'].'" data-user-id="'.$comment['user_ID'].'" data-post="0"><i class="fas fa-reply mr-2"></i> '.$sql.' replies</a>';
					} else {
						$output .= '<a class="ml-4 view_replies" data-comment-id="'.$comment['comment_ID'].'" data-post-id="'.$comment['post_ID'].'" data-user-id="'.$comment['user_ID'].'" data-post="0"><i class="fas fa-reply mr-2"></i> '.$sql.' reply</a>';
					}
				} 
				$output .= '<div id="add_reply_'.$comment['comment_ID'].'"></div></div></div>';
				if($q == 2){break;} $q++; }
			$output .= 	'</div></div><a class="text-center view_comments_'.$post['post_ID'].' view_comments mb-2" data-post-id="'.$post['post_ID'].'" data-user-id="'.$post['user_ID'].'"></a></div>';
			}
		}
		echo $output;
	}

	function get_comments() {
		$comments = $this->posts_model->get_comments($this->input->post('post_ID'));
		$output = '';

		foreach($comments as $row){
			$output .= '<div class="media m-2 comments_ID_'.$row['comment_ID'].'"><img class="rounded-circle card-img-100 d-flex mx-auto mb-3 ml-2 chat-mes-id" src="'.base_url().'assets/img/users/'.$row['image'].'" alt="Profile Photo"><div class="media-body text-left ml-2"><div class="bg-light rounded p-2"><h6 class="font-weight-bold m-0"><a class="text-dark profile_popover" href="'.base_url().'user-profile/'.$row['user_ID'].'" data-user-id="'.$row['user_ID'].'">'.ucwords($row['first_name']).' '.ucwords($row['last_name']).'</a>';
			if ($row['user_ID'] == $this->session->userdata('user_id')){
				$output .=  '<a class="float-right red-text m-1"><i class="fas fa-times delete_comment fa-xs" data-comment-id="'.$row['comment_ID'].'" data-post-id="'.$row['post_ID'].'"></i></a>';
			}
			$output .= '</h6>'.ucfirst($row['comment']);
			if (!empty($row['comment_image'])) {
         		$output .= '<div class="mt-2 h-50"><div class="d-flex"><a rel="gallery_'.$row['comment_ID'].'" href="'.base_url().'assets/img/posts/'.hash('md5', $row['user_ID']).'/'.$row['comment_image'].'" class="swipebox"><img src="'.base_url().'assets/img/posts/'.hash('md5', $row['user_ID']).'/'.$row['comment_image'].'" class="img-fluid img-thumbnail" style="width: 200px;"></a></div></div>';
			}
			$output .= '</div><div class="mb-2"><a class="ml-2 like_comment like_comment_'.$row['comment_ID'].'" data-comment-id="'.$row['comment_ID'].'" data-user-id="'.$row['user_ID'].'" data-post-id="'.$row['post_ID'].'">Like</a><a class="ml-2 view_replies" data-comment-id="'.$row['comment_ID'].'" data-post-id="'.$row['post_ID'].'" data-user-id="'.$row['user_ID'].'" data-post="'.$this->input->post('post').'">Reply</a><span class="text-left ml-2" style="font-size: 12px;">'.$this->time_elapsed_string($row['timestamp']).'</span>';

			if($this->posts_model->get_total_likes_comments($row['comment_ID']) > 0){
				$output .= '<span class="float-right blue-text"><i class="far fa-thumbs-up"></i> '.$this->posts_model->get_total_likes_comments($row['comment_ID']).'</span></div>';
			} else {
				$output .= '</div>';
			}
			if($this->posts_model->get_total_replies($row['comment_ID']) > 0){
				$output .= '<a class="ml-4 view_replies" data-comment-id="'.$row['comment_ID'].'" data-post-id="'.$row['post_ID'].'" data-user-id="'.$row['user_ID'].'" data-post="'.$this->input->post('post').'"><i class="fas fa-reply mr-2"></i> '.$this->posts_model->get_total_replies($row['comment_ID']);
				if($this->posts_model->get_total_replies($row['comment_ID']) > 1){
					$output .= ' replies</a>';
				} else {
					$output .= ' reply</a>';
				}
			}
			$output .= '<div id="add_reply_'.$row['comment_ID'].'"></div></div></div>';
		}
		$output .= '';
		echo json_encode($output);
	}

	function get_replies() {
		$like_comment = $this->posts_model->get_replies($this->input->post('post_ID'), $this->input->post('comment_ID'));
		$delete_button = '';
		$output = '';

		foreach($like_comment as $row){
			$output .= '<div class="media mt-2 comments_ID_'.$row['comment_ID'].'"><img class="rounded-circle card-img-64 d-flex mx-auto mb-2 chat-mes-id" alt="Profile Photo" src="'.base_url().'assets/img/users/'.$row['image'].'"><div class="media-body text-left ml-2"><div class="bg-light rounded p-2"><h6 class="font-weight-bold m-0"><a class="text-dark profile_popover" href="'.base_url().'user-profile/'.$row['user_ID'].'" data-user-id="'.$row['user_ID'].'">'.ucwords($row['first_name']).' '.ucwords($row['last_name']).'</a>';
			if ($row['user_ID'] == $this->session->userdata('user_id') || $row['owner_post'] == $this->session->userdata('user_id')){
				$output .= '<a class="float-right red-text m-1"><i class="fas fa-times delete_comment fa-xs" data-comment-id="'.$row['comment_ID'].'" data-post-id="'.$row['post_ID'].'"></i></a>';
			}
			$output .= '</h6>'.ucfirst($row['comment']);
			if (!empty($row['comment_image'])) {
				$output .= '<div class="mt-2 h-50"><div class="d-flex"><a rel="gallery_'.$row['comment_ID'].'" href="'.base_url().'assets/img/posts/'.hash('md5', $row['user_ID']).'/'.$row['comment_image'].'" class="swipebox"><img src="'.base_url().'assets/img/posts/'.hash('md5', $row['user_ID']).'/'.$row['comment_image'].'" class="img-fluid img-thumbnail" style="width: 200px;"></a></div></div>';
			}
		    $output .= '</div><a class="ml-2 like_comment like_comment_'.$row['comment_ID'].'" data-comment-id="'.$row['comment_ID'].'" data-user-id="'.$row['user_ID'].'" data-post-id="'.$row['post_ID'].'">Like</a><span class="ml-2 text-left" style="font-size: 12px;">'.$this->time_elapsed_string($row['timestamp']).'</span>';

		    if($this->posts_model->get_total_likes_comments($row['comment_ID']) > 1){
				$output .= '<span class="float-right blue-text"><i class="far fa-thumbs-up"></i> '.$this->posts_model->get_total_likes_comments($row['comment_ID']).'</span>';
			}
		    $output .= '</div></div>'; 
		}
		$output .= '';
		echo json_encode($output);
	}

	function add_comment() {
		$image = NULL;
		if(!empty($this->input->post('image'))){
			$image = $this->input->post('image');
		}

		$tagged_users_id = $this->get_tagged_users($this->input->post('comment'), '<a href="'.base_url().'user-profile/', '">@');

		$data = $this->posts_model->add_comments($image, $this->input->post('post_ID'), $this->input->post('comment'), $this->input->post('comment_ID'), $this->input->post('user_ID'), $this->session->userdata('user_id'), $tagged_users_id);
		echo json_encode($data);
	}

	//Upload image summernote
	function upload_image(){
		if(isset($_FILES["image"]["name"])){
			if (!file_exists('./assets/img/posts/'.hash('md5', $this->session->userdata('user_id')))) {
				mkdir('./assets/img/posts/'.hash('md5', $this->session->userdata('user_id')), 0777, true);
				$fi = 0;
			} else {
				$files = scandir('./assets/img/posts/'.hash('md5', $this->session->userdata('user_id')));
				$fi = count($files)-2;
			}
			$fi = $fi + 1;

			$image_name = $fi.".".pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION); 
			$config['upload_path'] = './assets/img/posts/'.hash('md5', $this->session->userdata('user_id'));
			$config['allowed_types'] = 'jpg|jpeg|png|gif';
	        $config['file_name'] = $image_name;

			$this->upload->initialize($config);
			if(!$this->upload->do_upload('image')){
			    $this->upload->display_errors();
				echo FALSE;
			}else{
				$data = $this->upload->data();
				//Compress Image
		        $config['image_library']='gd2';
		        $config['source_image']='./assets/img/posts/'.hash('md5', $this->session->userdata('user_id'))."/".$image_name;
		        $config['create_thumb']= FALSE;
	            $config['maintain_ratio']= TRUE;
	            $config['new_image']= './assets/img/posts/'.hash('md5', $this->session->userdata('user_id'))."/".$image_name;
	            $config['quality']= '70%';
	            $this->load->library('image_lib', $config);
	            $this->image_lib->resize();
				
				echo $image_name;
			}
		}
	}

	function delete_post() {
		$data = $this->posts_model->delete_post($this->input->post('post_ID'));
		echo json_encode($data);
	}

	function delete_comment() {
		$data = $this->posts_model->delete_comment($this->input->post('comment_ID'));
		echo json_encode($data);
	}

	function approve_post() {
		$data = $this->posts_model->approve_post($this->input->post('post_ID'), $this->input->post('user_ID'));
		echo json_encode($data);
	}

	function deny_post() {
		$data = $this->posts_model->deny_post($this->input->post('post_ID'), $this->input->post('user_ID'));
		echo json_encode($data);
	}

	function get_on_review_posts() {
		$data = $this->posts_model->get_on_review_posts();
		echo json_encode($data);
	}

	function get_notifications() {
		$data = $this->posts_model->get_notifications($this->session->userdata('user_id'));

		// approve post
		// commented
		// liked
		// replied
		// Support
		// Denied post
		// Tagge in a post
		foreach($data as $key => $value) {
			if($value['id'] == 0){
				$data[$key]['posts'] = '';
			} elseif(empty($value['posts'])){
				$data[$key]['posts'] = 'Posts has been deleted.<br>';
			}
		  if($value['notification_option_id'] == 1){
		  	$data[$key]['notification_option_id'] = 'Your post has been approved!';
		  	$data[$key]['timestamp'] = $this->time_elapsed_string($data[$key]['timestamp']);
		  } elseif ($value['notification_option_id'] == 2) {
		  	$data[$key]['notification_option_id'] = ucwords($data[$key]['first_name']).' '.ucwords($data[$key]['last_name']).' commented on your post.';
		  	$data[$key]['timestamp'] = $this->time_elapsed_string($data[$key]['timestamp']);
		  } elseif($value['notification_option_id'] == 3){
		  	$data[$key]['notification_option_id'] = ucwords($data[$key]['first_name']).' '.ucwords($data[$key]['last_name']).' liked your post.';
		  	$data[$key]['timestamp'] = $this->time_elapsed_string($data[$key]['timestamp']);
		  } elseif($value['notification_option_id'] == 4) {
		  	$data[$key]['notification_option_id'] = ucwords($data[$key]['first_name']).' '.ucwords($data[$key]['last_name']).' replied on your comment.';
		  	$data[$key]['timestamp'] = $this->time_elapsed_string($data[$key]['timestamp']);
		  } elseif($value['notification_option_id'] == 5){
		  	$data[$key]['notification_option_id'] = 'You have given 20 exp by the admins for reporting bugs';
		  	$data[$key]['timestamp'] = $this->time_elapsed_string($data[$key]['timestamp']);
		  }  elseif($value['notification_option_id'] == 6) {
		  	$data[$key]['notification_option_id'] = 'Your post has been denied!';
		  	$data[$key]['timestamp'] = $this->time_elapsed_string($data[$key]['timestamp']);
		  } elseif($value['notification_option_id'] == 7) {
		  	$data[$key]['notification_option_id'] = ucwords($data[$key]['first_name']).' '.ucwords($data[$key]['last_name']).' tagged you n a post!';
		  	$data[$key]['timestamp'] = $this->time_elapsed_string($data[$key]['timestamp']);
		  } elseif($value['notification_option_id'] == 8) {
		  	$data[$key]['notification_option_id'] = ucwords($data[$key]['first_name']).' '.ucwords($data[$key]['last_name']).' liked your comment';
		  	$data[$key]['timestamp'] = $this->time_elapsed_string($data[$key]['timestamp']);
		  } elseif($value['notification_option_id'] == 9) {
		  	$data[$key]['notification_option_id'] = ucwords($data[$key]['first_name']).' '.ucwords($data[$key]['last_name']).' follows you';
		  	$data[$key]['posts'] = '';
		  	$data[$key]['timestamp'] = $this->time_elapsed_string($data[$key]['timestamp']);
		  } elseif($value['notification_option_id'] == 10) {
		  	$data[$key]['notification_option_id'] = ucwords($data[$key]['first_name']).' '.ucwords($data[$key]['last_name']).' mentions you in a comment';
		  	$data[$key]['timestamp'] = $this->time_elapsed_string($data[$key]['timestamp']);
		  } elseif($value['notification_option_id'] == 11) {
		  	$data[$key]['notification_option_id'] = ucwords($data[$key]['first_name']).' '.ucwords($data[$key]['last_name']).' mentions you in a group chat';
		  	$value[$key]['id'] = 0;
		  	$data[$key]['posts'] = '';
		  	$data[$key]['timestamp'] = $this->time_elapsed_string($data[$key]['timestamp']);
		  }
		}
		echo json_encode($data);
	}

	function seen() {
		$data = $this->posts_model->seen($this->session->userdata('user_id'));
		echo json_encode($data);
	}
}