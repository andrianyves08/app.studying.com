<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Posts extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('upload');
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

	function get_liked_comments() {
		$data = $this->posts_model->get_liked_comments($this->session->userdata('user_id'));
		echo json_encode($data);
	}

	function create() {
		$image = NULL;
		if(!empty($this->input->post('image'))){
			$image = $this->input->post('image');
		}

		if($image != NULL || $this->input->post('posts') != NULL){
			$data = $this->posts_model->create($image, nl2br(htmlentities($this->input->post('posts'), ENT_QUOTES, 'UTF-8')), $this->session->userdata('user_id'));
			if($data){
				$this->delete_cache();
				$this->session->set_flashdata('success', 'Your posts will be reviewed!');
			}
		} else {
			$this->session->set_flashdata('error', 'Enter a posts!');
		}
		
		redirect('');
	}

	function liked() {
		$this->delete_cache();
		$liked = $this->posts_model->like_post($this->input->post('posts'), $this->input->post('user_ID'), $this->session->userdata('user_id'));

		if(!$liked){
			$this->posts_model->unlike_post($this->input->post('posts'), $this->session->userdata('user_id'));
			$data = array(
				'status' => false,
			);
		} else {
			$data = array(
				'status' => true,
			);
		}
		echo json_encode($data);;
	}

	function like_comment() {
		$this->delete_cache();
		$liked = $this->posts_model->like_comment($this->input->post('comment_ID'), $this->session->userdata('user_id'));

		if(!$liked){
			$this->posts_model->unlike_comment($this->input->post('comment_ID'), $this->session->userdata('user_id'));
			$data = array(
				'status' => false,
			);
		} else {
			$data = array(
				'status' => true,
			);
		}
		echo json_encode($data);;
	}

	function time_elapsed_string($datetime, $full = false) {
	    $now = new DateTime;
	    $ago = new DateTime($datetime);
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

	function load_more() {
		$user_ID = FALSE;
		if(!empty($this->input->post('user_ID'))){
			$user_ID = $this->input->post('user_ID');
		}

		$posts = $this->posts_model->get_posts(5, $this->input->post('start'), $user_ID);
		$output = '';


		foreach($posts as $post){
			if($post['post_status'] == 1){

			$output .= '<section class="mb-4 posts">
					      <div class="row justify-content-center">
							  <div class="col-lg-8">
								  <div class="card">
								      <div class="media mt-2">
								          <img class="ml-2 rounded-circle card-img-100 d-flex z-depth-1 mr-2 chat-mes-id" src="'.base_url().'assets/img/users/'.$post['image'].'" style="height: 50px; width: 50px" alt="Profile photo">
								          <div class="media-body">
											<h5><a class="text-dark" ';
							                if($post['user_ID'] == $this->session->userdata('user_id')){ 
							                	$output .= 'href="'.base_url().'my-profile"'; 
							                } else { 
							                 	$output .= 'href="'.base_url().'user-profile/'.$post['user_ID'].'"'; 
							                }
											$output .=  '>'.ucwords($post['first_name']).' '.ucwords($post['last_name']).'</a>';
							                if ($post['user_ID'] == $this->session->userdata('user_id')) {
							                  $output .= '<a class="float-right red-text m-1"><i class="fas fa-times delete_post" data-post-id="'.$post['post_ID'].'"></i></a>';
							                 }
											$output .= '</h5><span class="text-muted text-dark"><small>'.$this->time_elapsed_string(date("M d, Y h:i A", strtotime($post['timestamp']))).
									      		'</small></span></div>
									  </div>
								   	  <div class="card-body py-0 mt-2"> 
	            						<p class="post-text">'.ucfirst($post['posts']).'</p>';
								        if (!empty($post['post_image'])) {
							             	$output .=  '<div class="bg-image hover-overlay ripple rounded-0 mt-4">
							                              <img src="'.base_url().'assets/img/posts/'.$post['post_image'].'" class="w-100"/>
							                                <a href="#!">
							                                  <div class="mask" style="background-color: rgba(251, 251, 251, 0.2)" ></div>
							                                </a>
							                            </div>';
							            } 
							$output .= '<div class="d-flex justify-content-between mt-4">
	              						  <div>
										    <span class="total_likes total_likes_'.$post['post_ID'].'" data-post-id="'.$post['post_ID'].'"></span> 
										  </div>
	              						  <div>
										    <a class="total_comments total_comments_'.$post['post_ID'].' view_comments" data-post-id="'.$post['post_ID'].'" data-user-id="'.$post['user_ID'].'"></a>
										  </div>
										</div>
										<div class="d-flex justify-content-between text-center border-top border-bottom">
							              <button class="ml-2 liked liked_'.$post['post_ID'].' btn btn-link" data-post-id="'.$post['post_ID'].'" data-user-id="'.$post['user_ID'].'"><i class="far fa-thumbs-up mr-2"></i> Like</button>
							              <button class="ml-2 view_comments btn btn-link" data-post-id="'.$post['post_ID'].'" data-user-id="'.$post['user_ID'].'"><i class="far fa-comment-alt mr-2"></i> Comment</button>
							              <button type="button" class="btn btn-link" data-ripple-color="dark" disabled><i class="fas fa-share mr-2"></i>Share</button>
							            </div>
								        <div id="comment_section_'.$post['post_ID'].'">
								        </div>
								      </div>
								  </div>
							  </div><!--/.Card-->
							</div>
						  </div>
						</section>';
			}
		}
		echo $output;
	}


	function get_comments() {
		$comments = $this->posts_model->get_comments($this->input->post('post_ID'));

		$output = '';

		foreach($comments as $row){
			$output .= '<div class="media m-2 comments_ID_'.$row['comment_ID'].'">
				<img class="rounded-circle card-img-100 d-flex mx-auto mb-3 ml-2 chat-mes-id" src="'.base_url().'assets/img/users/'.$row['image'].'" alt="Profile Photo">
				<div class="media-body text-left ml-2">
					<h5 class="font-weight-bold m-0">
					<a class="text-dark"  href="'.base_url().'user-profile/'.$row['user_ID'].'">'.ucwords($row['first_name']).' '.ucwords($row['last_name']).'</a>';
				if ($row['user_ID'] == $this->session->userdata('user_id') || $row['owner_post'] == $this->session->userdata('user_id')){
					$output .=  '<a class="float-right red-text m-1"><i class="fas fa-times delete_comment fa-xs" data-comment-id="'.$row['comment_ID'].'" data-post-id="'.$row['post_ID'].'"></i></a>';
				}

					$output .= '</h5>'.ucwords($row['comment']);
			if (!empty($row['comment_image'])) {
            	$output .= '<div class="mt-2 h-50">
            					<div class="d-flex">
			            			<a rel="gallery_'.$row['comment_ID'].'" href="./assets/img/posts/'.hash('md5', $row['user_ID']).'/'.$row['comment_image'].'" class="swipebox"><img src="./assets/img/posts/'.hash('md5', $row['user_ID']).'/'.$row['comment_image'].'" class="img-fluid img-thumbnail" style="width: 200px;"></a>
			            		</div>
			          		</div>';
            } else {
            	$output .= '<br>';
            }

			$output .= '<span class="text-left mr-3" style="font-size: 12px;">'.$this->time_elapsed_string(date("M d, Y h:i A", strtotime($row['timestamp']))).'</span> <a class="mr-3 like_comment like_comment_'.$row['comment_ID'].'" data-comment-id="'.$row['comment_ID'].'">Like</a> <a class="view_replies" data-comment-id="'.$row['comment_ID'].'" data-post-id="'.$row['post_ID'].'" data-user-id="'.$row['user_ID'].'">Reply</a>';

			if($this->posts_model->get_total_likes_comments($row['comment_ID']) > 1){
			 	$output .= '<span class="ml-4 blue-text">'.$this->posts_model->get_total_likes_comments($row['comment_ID']).' likes</span>';
			}

			if($this->posts_model->get_total_replies($row['comment_ID']) > 0){
			 	$output .= '<a class="view_replies" data-comment-id="'.$row['comment_ID'].'" data-post-id="'.$row['post_ID'].'" data-user-id="'.$row['user_ID'].'"><span class="ml-4 blue-text">'.$this->posts_model->get_total_replies($row['comment_ID']);
			 	if($this->posts_model->get_total_replies($row['comment_ID']) > 1){
			 		$output .= ' replies</span></a>';
				} else {
					$output .= ' reply</span></a>';
				}
			}

			$output .= '<div id="add_reply_'.$row['comment_ID'].'"></div></div></div>';
		}

		$output .= '';

		echo json_encode($output);;
	}

	function get_replies() {
		$like_comment = $this->posts_model->get_replies($this->input->post('post_ID'), $this->input->post('comment_ID'));
		$delete_button = '';

		$output = '';

		foreach($like_comment as $row){
			$output .= '<div class="media mt-2 comments_ID_'.$row['comment_ID'].'">
		      <img class="rounded-circle card-img-64 d-flex mx-auto mb-2 chat-mes-id" alt="Profile Photo" src="'.base_url().'assets/img/users/'.$row['image'].'">
		      <div class="media-body text-left ml-2">
		        <h5 class="font-weight-bold m-0">
		          <a class="text-dark" href="'.base_url().'user-profile/'.$row['user_ID'].'">'.ucwords($row['first_name']).' '.ucwords($row['last_name']).'</a>
		           ';
					  if ($row['user_ID'] == $this->session->userdata('user_id') || $row['owner_post'] == $this->session->userdata('user_id')){
							$output .= '<a class="float-right red-text m-1"><i class="fas fa-times delete_comment fa-xs" data-comment-id="'.$row['comment_ID'].'" data-post-id="'.$row['post_ID'].'"></i></a>';
						}
		        $output .='</h5>'.$row['comment'];

		    if (!empty($row['comment_image'])) {
            	$output .= '<div class="mt-2 h-50">
            					<div class="d-flex">
			            			<a rel="gallery_'.$row['comment_ID'].'" href="./assets/img/posts/'.hash('md5', $row['user_ID']).'/'.$row['comment_image'].'" class="swipebox"><img src="./assets/img/posts/'.hash('md5', $row['user_ID']).'/'.$row['comment_image'].'" class="img-fluid img-thumbnail" style="width: 200px;"></a>
			            		</div>
			          		</div>';
            } else {
            	$output .= '<br>';
            }
		     
		    $output .= '<span class="text-left mr-3" style="font-size: 12px;">'.$this->time_elapsed_string(date("M d, Y h:i A", strtotime($row['timestamp']))).'</span> <a class="mr-3 like_comment like_comment_'.$row['comment_ID'].'" data-comment-id="'.$row['comment_ID'].'">Like</a>';

		    if($this->posts_model->get_total_likes_comments($row['comment_ID']) > 1){
			 	$output .= '<span class="ml-4 blue-text">'.$this->posts_model->get_total_likes_comments($row['comment_ID']).' likes</span>';
			}
		    $output .= '</div></div>'; 
		}

		$output .= '';

		echo json_encode($output);
	}

	function add_comment() {
		$this->delete_cache();
		$image = NULL;
		if(!empty($this->input->post('image'))){
			$image = $this->input->post('image');
		}

		$data = $this->posts_model->add_comments($image, $this->input->post('post_ID'), $this->input->post('comment'), $this->input->post('comment_ID'), $this->input->post('user_ID'), $this->session->userdata('user_id'));
		echo json_encode($data);
	}

	function delete_cache() {
    	$this->load->helper('cache');
    	delete_all_cache();
	}

	//Upload image summernote
	function upload_image(){
		if(isset($_FILES["image"]["name"])){
			if (!file_exists('./assets/img/posts/'.hash('md5', $this->session->userdata('user_id')))) {
				mkdir('./assets/img/posts/'.hash('md5', $this->session->userdata('user_id')), 0777, true);
			}
			$config['upload_path'] = './assets/img/posts/'.hash('md5', $this->session->userdata('user_id'));
			$config['allowed_types'] = 'jpg|jpeg|png|gif';
			//$config['max_size'] = 4096;
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('image')){
			    $this->upload->display_errors();
				echo FALSE;
			}else{
				$data = $this->upload->data();
				//Compress Image
		        $config['image_library']='gd2';
		        $config['source_image']='./assets/img/posts/'.hash('md5', $this->session->userdata('user_id'))."/".$data['file_name'];
		        $config['create_thumb']= FALSE;
	            $config['maintain_ratio']= TRUE;
	            $config['new_image']= './assets/img/posts/'.hash('md5', $this->session->userdata('user_id'))."/".$data['file_name'];
	            $config['quality']= '70%';
	            $this->load->library('image_lib', $config);
	            $this->image_lib->resize();
				
				echo $data['file_name'];
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

	function not_accept_post() {
		$data = $this->posts_model->not_accept_post($this->input->post('post_ID'), $this->input->post('user_ID'));
		echo json_encode($data);
	}

	function get_on_review_posts() {
		$data = $this->posts_model->get_on_review_posts();
		echo json_encode($data);
	}

	function get_notifications() {
		$data = $this->posts_model->get_notifications($this->session->userdata('user_id'), $this->input->post('status'));

		// approve post
		// commented
		// liked
		// replied
		// Denied post
		foreach($data as $key => $value) {
			if($value['post_ID'] == 0){
				$data[$key]['posts'] = '';
			} elseif(empty($value['posts'])){
				$data[$key]['posts'] = 'Posts has been deleted.';
			
			}
		  if($value['type'] == 1){
		  	$data[$key]['type'] = 'Your post has been approved!';
		  } elseif ($value['type'] == 2) {
		  	$data[$key]['type'] = ucwords($data[$key]['first_name']).' '.ucwords($data[$key]['last_name']).' commented on your post.';
		  } elseif($value['type'] == 3){
		  	$data[$key]['type'] = ucwords($data[$key]['first_name']).' '.ucwords($data[$key]['last_name']).' liked your post.';
		  } elseif($value['type'] == 4) {
		  	$data[$key]['type'] = ucwords($data[$key]['first_name']).' '.ucwords($data[$key]['last_name']).' replied on your comment.';
		  	$data[$key]['owner'] = $data[$key]['user_ID'];
		  	$data[$key]['user_ID'] = $data[$key]['owner'];
		  } elseif($value['type'] == 5){
		  	$data[$key]['type'] = 'You have given 20 exp by the admins for reporting bugs';
		  } else {
		  	$data[$key]['type'] = 'Your post has been denied!';
		  }
		}
		echo json_encode($data);
	}

	function seen() {
		$data = $this->posts_model->seen($this->session->userdata('user_id'));
		echo json_encode($data);
	}
}