<?php 
  function changetimefromUTC($time, $timezone) {
    $changetime = new DateTime($time, new DateTimeZone('UTC'));
    $changetime->setTimezone(new DateTimeZone($timezone));
    return $changetime->format('M j, Y h:i A');
  }

  function time_elapsed_string($time, $timezone, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($time, new DateTimeZone('UTC'));
    $now->setTimezone(new DateTimeZone($timezone));
    $ago->setTimezone(new DateTimeZone($timezone));
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
?>
<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <div class="row justify-content-center">
    <div class="col-lg-4 col-md-4 col-sm-12">
      <div class="card mb-4">
        <div class="view overlay">
          <?php if(!empty($my_info['image'])){?>
            <img class="card-img-top" src="<?php echo base_url();?>assets/img/users/<?php echo $my_info['image'];?>" alt="Profile Photo">
          <?php } else { ?>
            <img class="card-img-top" src="<?php echo base_url();?>assets/img/users/stock.jpg" alt="Profile Photo">
          <?php } ?>
            <a href="#!">
              <div class="mask rgba-white-slight"></div>
            </a>
        </div><!-- View -->
        <div class="card-body d-flex flex-row">
          <div>
            <img src="<?php echo base_url();?>assets/img/<?php echo $my_rank['image'];?>" alt="Profile Photo">
          </div>
          <div class="text-left">
            <div class="d-flex align-items-center">
              <h4><strong><?php echo ucwords($my_info['first_name']);?> <?php echo ucwords($my_info['last_name']);?></strong></h4>
            </div>
            <div class="d-flex">
              <h6><strong><?php echo $count_posts['total']; ?></strong> Posts</h6>
              <a class="following" data-user-id="<?php echo $my_info['id'];?>"><h6 class="ml-4"><strong><?php echo $count_following['total']; ?></strong> Following</h6></a>
              <a class="followers" data-user-id="<?php echo $my_info['id'];?>"><h6 class="ml-4"><strong><?php echo $count_followers['total']; ?></strong> Followers</h6></a>
            </div>
            <h5 class="font-italic"><?php echo ucwords($my_info['bio']);?></h5>
            <?php if($my_info['id'] == $my_id){?> 
              <h5 class="blue-text mb-4"><strong><?php echo $my_info['email'];?></strong></h5>
              <div class="d-flex">
                <button type="button" class="btn btn-primary btn m-0 px-2 py-2" data-toggle="modal" data-target="#changepassword">Change Password</button>
                <button type="button" class="btn btn-info btn m-0 px-2 py-2" data-toggle="modal" data-target="#editprofile">Edit Profile</button>
              </div>
            <?php } ?>
            <?php if($my_info['id'] != $my_id && $count_followers['total'] == 0){?> 
              <button type="button" class="btn btn-sm btn-outline-primary waves-effect" id="follow_user" data-user-id="<?php echo $my_info['id'];?>">Follow</button>
            <?php } elseif($my_info['id'] != $my_id && $count_followers['total'] == 1) { ?>
              <button type="button" class="btn btn-sm btn-outline-danger waves-effect" id="unfollow_user" data-user-id="<?php echo $my_info['id'];?>">Unfollow</button>
            <?php } ?>
            <?php if ($my_info['id'] != $my_id) {?>
              <button class="btn btn-sm btn-primary m-0 px-3 py-2 z-depth-0 waves-effect" type="button" data-toggle="modal" data-target="#send_chat">Send a message</button>
            <?php } ?>
          </div>
        </div><!-- Card Body-->
      </div><!-- Card -->
      <?php if($my_info['id'] == $my_id){?> 
      <div class="card mb-4">
        <div class="card-header customcolorbg">
          <h5 class="text-white"><strong>Watch History</strong></h5>
        </div>
        <div class="card-body">
          <table class="table table-bordered display" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th scope="col">Video Name</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($histories as $history) {?>
              <tr>
                <td><a href="<?php base_url();?>modules/<?php echo $history['program_slug'];?>/<?php echo $history['course_slug'];?>/<?php echo $history['section_slug'];?>#<?php echo $history['content_ID'];?>" class="blue-text"><?php echo ucwords($history['content_name']);?></a></td>
                <td>
                  <?php if($history['status'] == 0){?>
                  <span class="badge badge-pill badge-info">On Going</span>
                  <?php } else { ?>
                  <span class="badge badge-pill badge-success">Finished</span>
                  <?php } ?>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div><!--Card Body-->
      </div><!--Card-->
      <?php } ?>
    </div><!--Column -->
    <div class="col-lg-6">
      <?php if ($my_info['id'] == $my_id) {?>
        <?php echo form_open_multipart('posts/create'); ?>
        <div class="card mb-4">
          <div class="media mt-2">
            <img class="rounded-circle ml-2 card-img-100 d-flex z-depth-1 mr-2 chat-mes-id" src="<?php echo base_url();?>assets/img/users/<?php echo $my_info['image'];?>" style="height: 50px; width: 50px" alt="Profile photo"/>
            <div class="media-body d-flex">
              <textarea type="textarea" class="textarea_post" name="posts" id="posts"></textarea>
            </div>
          </div>
          <div id="body_bottom_0" class="ml-4 image_textarea">
            <div class="preview_0"></div>
          </div>
          <div class="card-body py-0 mt-2">
            <div class="d-flex justify-content-end text-center border-top">
              <input type="hidden" name="image" id="image_0">
              <input type="file" style="display:none;" name="post_image[]" id="post_image_0" multiple accept="image/x-png,image/gif,image/jpeg">
              <button type="button" class="btn btn-link uploadTrigger" data-textarea-id="0"><i class="fas fa-photo-video mr-2 green-text"></i>Photo</button>
              <button class="btn btn-primary btn-sm" type="submit" id="create_posts">Posts</button>
            </div>
          </div>
        </div> <!-- Card -->
        <?php echo form_close(); ?>
      <?php } ?>
       <?php 
        $CI =& get_instance();
        $CI->load->model('posts_model');
        foreach ($posts as $post) {
          if($post['post_status'] == 1) {
            $images = $CI->posts_model->get_post_images($post['post_ID']);
        ?>
        <div class="card mb-4 posts">
          <div class="media mt-2">
            <img class="rounded-circle ml-2 card-img-100 d-flex z-depth-1 mr-2 chat-mes-id" src="<?php echo base_url();?>assets/img/users/<?php echo $post['image'];?>" style="height: 50px; width: 50px" alt="Profile photo">
            <div class="media-body">
               <h5><a class="text-dark profile_popover" href="<?php echo base_url().'user-profile/'.$post['user_ID']; ?>" data-user-id="<?php echo $post['user_ID'];?>"><?php echo ucwords($post['first_name']);?> <?php echo ucwords($post['last_name']);?></a>
                <?php if ($post['user_ID'] == $my_id) {?>
                <a class="float-right mr-2 post_popover" data-toggle="popover" alt="<?php echo $post['post_ID'];?>" data-post-id="<?php echo $post['post_ID'];?>"><i class="fas fa-ellipsis-v"></i></span></a>
                <?php } ?></h5>
              <span class="text-muted text-dark"><small><?php echo changetimefromUTC($post['timestamp'], $timezone);?></small></span>
            </div>
          </div>
          <div class="card-body py-0 mt-2">
            <?php echo ucfirst($post['posts']);?>
            <?php
              if (!empty($images)) {
              $all_images = array();
              $total = count($images);
              foreach ($images as $image) { 
                $all_images[] = base_url().'assets/img/posts/'.hash('md5', $post['user_ID']).'/'.$image['image'];
              }?>
              <?php if($total == 1){ ?>
                <div class="mt-2">
                  <span class="view_post" data-post-id="<?php echo $image['post_ID'];?>" data-user-id="<?php echo $post['user_ID'];?>"> 
                    <a class="imgs-grid-image" data-id="0"><img src="<?php echo base_url().'assets/img/posts/'.hash('md5', $post['user_ID']).'/'.$image['image'];?>" class="img-fluid img-thumbnail" style="width: 300px;"></a>
                  </span> 
                </div>
              <?php } else { ?>
                <span class="view_post" data-post-id="<?php echo $image['post_ID'];?>" data-user-id="<?php echo $post['user_ID'];?>"> 
                  <span id="post_images_<?php echo $post['post_ID'];?>"></span>
                 </span> 
                <script>
                  var images = <?php echo json_encode($all_images); ?>;
                  $(function() {
                    $('#post_images_<?php echo $post['post_ID'];?>').imagesGrid({
                        images: <?php echo json_encode($all_images); ?>,
                        align: true,
                        getViewAllText: function(imgsCount) { return 'View all' }
                    });
                  });
                </script>
              <?php } ?>
            <?php } ?>
            <div class="mt-4 mb-2">
              <a class="total_likes total_likes_<?php echo $post['post_ID'];?> view_likers" data-post-id="<?php echo $post['post_ID'];?>"></a>
              <span class="float-right text-center total_comments total_comments_<?php echo $post['post_ID'];?> mb-2" data-post-id="<?php echo $post['post_ID'];?>" data-user-id="<?php echo $post['user_ID'];?>"></span>
            </div>
            <div class="d-flex justify-content-between text-center border-top border-bottom w-100">
              <a class="p-3 ml-2 liked liked_<?php echo $post['post_ID'];?>" data-post-id="<?php echo $post['post_ID'];?>" data-user-id="<?php echo $post['user_ID'];?>" data-status="0"><i class="far fa-thumbs-up mr-2"></i> Like</a>
              <a class="p-3 ml-2 view_comments" data-post-id="<?php echo $post['post_ID'];?>" data-user-id="<?php echo $post['user_ID'];?>"><i class="far fa-comment-alt mr-2"></i> Comment</a>
              <p class="p-3 text-red text-muted" disabled><i class="fas fa-share mr-2"></i>Share</p>
            </div>
            <div id="comment_section_<?php echo $post['post_ID'];?>">
              <?php $q=1; foreach ($comments as $comment) { 
                if($post['post_ID'] == $comment['post_ID']) {
              ?>
              <div class="media m-2 comments_ID_<?php echo $comment['comment_ID']; ?>">
                <img class="rounded-circle card-img-100 d-flex mx-auto mb-3 ml-2 chat-mes-id" src="<?php echo base_url(); ?>assets/img/users/<?php echo $comment['image']; ?>" alt="Profile Photo">
                <div class="media-body text-left ml-2">
                  <div class="bg-light rounded p-2">
                  <h6 class="font-weight-bold m-0">
                    <a class="text-dark profile_popover" href="<?php echo base_url(); ?>user-profile/<?php echo $comment['user_ID']; ?>" data-user-id="<?php echo $post['user_ID'];?>"><?php echo ucwords($comment['first_name']); ?> <?php echo ucwords($comment['last_name']); ?></a>
                    <?php if($comment['user_ID'] == $my_info['id']){ ?>
                    <a class="float-right red-text m-1"><i class="fas fa-times delete_comment fa-xs" data-comment-id="<?php echo $comment['comment_ID']; ?>" data-post-id="<?php echo $comment['post_ID'];?>"></i></a>
                    <?php } ?>
                  </h6>
                  <?php echo $comment['comment']; ?>
                  <?php if(!empty($comment['comment_image'])) { ?>
                  <div class="mt-2 h-50">
                    <div class="d-flex">
                      <a rel="gallery_<?php echo $comment['comment_ID']; ?>" href="<?php echo base_url(); ?>assets/img/posts/<?php echo hash('md5', $comment['user_ID']); ?>/<?php echo $comment['comment_image']; ?>" class="swipebox"><img src="<?php echo base_url(); ?>assets/img/posts/<?php echo hash('md5', $comment['user_ID']); ?>/<?php echo $comment['comment_image']; ?>" class="img-fluid img-thumbnail" style="width: 200px;"></a>
                    </div>
                  </div>
                  <?php } ?>
                  </div>
                  <div class="mb-2">
                  <a class="ml-2 like_comment like_comment_<?php echo $comment['comment_ID']; ?>" data-comment-id="<?php echo $comment['comment_ID']; ?>" data-user-id="<?php echo $comment['user_ID']; ?>" data-post-id="<?php echo $comment['post_ID'];?>" data-status="0">Like</a>
                  <a class="ml-2 view_replies" data-comment-id="<?php echo $comment['comment_ID']; ?>" data-post-id="<?php echo $comment['post_ID'];?>" data-user-id="<?php echo $comment['user_ID']; ?>">Reply</a>
                  <span class="text-left ml-2" style="font-size: 12px;"><?php echo time_elapsed_string($comment['timestamp'], $timezone);?></span>
                  <?php 
                    $sql= $CI->posts_model->get_total_replies($comment['comment_ID']);
                    $sql2= $CI->posts_model->get_total_likes_comments($comment['comment_ID']);
                    if($sql2 > 0){
                      echo '<span class="float-right blue-text"><i class="far fa-thumbs-up"></i> '.$sql2.'</span></div>';
                    } else {
                      echo '</div>';        
                    }
                    if($sql > 0){
                      if($sql > 1){
                        echo '<a class="ml-4 view_replies" data-comment-id="'.$comment['comment_ID'].'" data-post-id="'.$comment['post_ID'].'" data-user-id="'.$comment['user_ID'].'"><i class="fas fa-reply mr-2"></i> '.$sql.' replies</a>';
                      } else {
                        echo '<a class="ml-4 view_replies" data-comment-id="'.$comment['comment_ID'].'" data-post-id="'.$comment['post_ID'].'" data-user-id="'.$comment['user_ID'].'"><i class="fas fa-reply mr-2"></i> '.$sql.' reply</a>';
                      }
                    } 
                   ?>
                  <div id="add_reply_<?php echo $comment['comment_ID']; ?>"></div>
                </div>
              </div>
              <?php if($q == 2){break;} $q++;} }?>
            </div>
          </div>
          <a class="text-center view_comments_<?php echo $post['post_ID'];?> view_comments mb-2" data-post-id="<?php echo $post['post_ID'];?>" data-user-id="<?php echo $post['user_ID'];?>"></a>
        </div><!--/.Card-->
        <?php } } ?>
      <div class="text-center">
        <a class="blue-text load_more" data-user-id="<?php echo $my_info['id']; ?>">View More</a>
      </div>
    </div><!--Column-->
  </div><!--Row-->
</div><!--Container-->
</main>
<!-- Create Chat -->
<div data-backdrop="static" class="modal fade" id="send_chat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="heading lead">Create Message</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="user_ID" value="<?php echo $my_info['id'];?>"></input>
        <textarea class="textarea" name="chat_message" placeholder="Write message to <?php echo ucwords($my_info['first_name']);?> <?php echo ucwords($my_info['last_name']);?>" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
      </div><!--Modal Body-->
      <div class="modal-footer justify-content-center">
        <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancel</a>
        <button class="btn btn-primary waves-effect float-right" type="submit" id="createamessage">Send</button>
      </div>
    </div><!--Content-->
  </div>
</div>
<!-- View Full Post -->
<div class="modal fade view_full_post_modal" id="view_full_post_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-fluid" role="document">
    <div class="modal-content">
      <div class="modal-body row m-0 p-0 black" <?php if(isMobile()){ echo 'style="height: 100%; overflow: auto;"'; }?> >
        <div class="col-lg-8 col-md-12 col-sm-12 text-center align-self-center">
          <div id="view_post_image"></div>
        </div>
        <div class="col-lg-4 col-md-12 col-sm-12 white p-0">
          <div id="post_content" <?php if(isMobile() == 0){ echo 'style="height: 700px; overflow: auto;"'; } ?> ></div>
          <div class="d-flex">
            <div id="body_bottom_1" class="ml-4 image_textarea">
              <img class="ml-4 mt-2" id="preview_1"/>
            </div>
            <textarea type="textarea" class="textarea_post" name="textarea_comments_1" id="textarea_comments_1"></textarea>
          </div>
          <input type="hidden" name="image" id="image_1">
          <input type="file" onchange="readURL(this, 1);" style="display:none;" name="post_image[]" id="post_image_1" multiple>
          <button type="submit" class="btn btn-primary btn-sm float-right submit_comment full_post_submit_comment" data-post-id="0" data-user-id="0" data-textarea-id="1" data-comment-id="0">comment</button>
          <button type="button" class="btn btn-link btn-sm uploadTrigger float-right" data-textarea-id="1"><i class="fas fa-photo-video mr-2 green-text"></i>Photo</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Likers -->
<div class="modal fade" id="view_likers" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-body" id="likers_post">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="edit_post" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <?php echo form_open_multipart('posts/edit'); ?>
      <div class="modal-body">
        <input type="hidden" name="post_ID"></input>
        <textarea type="textarea" class="textarea_post" name="edit_post_value" id="edit_post_value"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success btn-sm">Update</button>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>
<!-- Delete Posts -->
<div data-backdrop="static" class="modal fade" id="delete_post" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-sm modal-notify modal-danger" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">Delete Post</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this post?</p>
        <input type="hidden" class="form-control" name="post_ID">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-sm confirm_delete_post">Confirm</button>
      </div>
    </div>
  </div>
</div>
<!--Following -->
<div data-backdrop="static" class="modal fade" id="following" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="heading lead">Following</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <ul class="list-group list-group-flush" id="list_following">
        </ul>
      </div><!--Modal Body-->
      <div class="modal-footer justify-content-center">
        <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</a>
      </div>
    </div><!--Content-->
  </div>
</div>
<!--Followers -->
<div data-backdrop="static" class="modal fade" id="followers" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="heading lead">Followers</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <ul class="list-group list-group-flush" id="list_followers">
        </ul>
      </div><!--Modal Body-->
      <div class="modal-footer justify-content-center">
        <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</a>
      </div>
    </div><!--Content-->
  </div>
</div>
<?php if($my_info['id'] == $my_id){?> 
<!-- Change Password-->
<div data-backdrop="static" class="modal fade" id="changepassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="heading lead">Change Password</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php echo form_open('users/change_password'); ?>
        <div class="form-group">
          <label for="formGroupExampleInput">Current Password</label>
          <input type="password" class="form-control" name="current_password">
        </div>
        <div class="form-row mb-4">
          <div class="col">
            <label for="formGroupExampleInput">New Password</label>
            <input type="password" class="form-control" name="new_password">
          </div>
          <div class="col">
            <label for="formGroupExampleInput">Confirm New Password</label>
            <input type="password" class="form-control" name="cnew_Password">
          </div>
        </div>
      </div><!--Body-->
      <div class="modal-footer justify-content-center">
        <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancel</a>
        <button class="btn btn-success waves-effect float-right" type="submit">Save Changes</button>
      </div><!--Footer-->
      <?php echo form_close(); ?>
    </div><!--Content-->
  </div>
</div>
<!-- Change Password-->
<!-- Edit Profile -->
<div data-backdrop="static" class="modal fade" id="editprofile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="heading lead">Edit Profile</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php echo form_open_multipart('users/change_profile'); ?>
        <input type="hidden" id="image" name="image" value="<?php echo $my_info['image'];?>">
        <label for="image">Profile Photo</label>
        <div class="input-group">
          <div class="custom-file">
            <input type="file" class="custom-file-input" id="profile_photo" name="profile_photo" aria-describedby="inputGroupFileAddon01">
            <label class="custom-file-label text-left" for="logo"><?php echo $my_info['image'];?></label>
          </div>
        </div>
        <br>
        <div class="form-row mb-4">
          <div class="col">
            <label for="formGroupExampleInput">First Name</label>
            <input type="text" class="form-control" name="first_name" value="<?php echo ucwords($my_info['first_name']);?>">
          </div>
          <div class="col">
            <label for="formGroupExampleInput">Last Name</label>
            <input type="text" class="form-control" name="last_name" value="<?php echo ucwords($my_info['last_name']);?>">
          </div>
        </div>
        <div class="form-group">
          <label for="formGroupExampleInput">Bio</label>
          <input type="text" class="form-control" name="bio">
        </div>
      </div><!--Body-->
      <div class="modal-footer justify-content-center">
        <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancel</a>
        <button class="btn btn-success waves-effect float-right" type="submit">Save Changes</button>
      </div><!--Footer-->
      <?php echo form_close(); ?>
    </div><!--Content-->
  </div>
</div>
<!-- Edit Profile -->
<!-- Delete Posts -->
<div data-backdrop="static" class="modal fade" id="delete_post" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-sm modal-notify modal-danger" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">Delete Post</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this post?</p>
        <input type="hidden" class="form-control" name="post_ID">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-sm confirm_delete_post">Confirm</button>
      </div>
    </div>
  </div>
</div>
<!-- Delete Posts -->
<?php } ?>
<script type="text/javascript">
  function readURL(input, textarea) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $('#body_bottom_'+textarea).show();
        $('#preview_'+textarea).attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
      uploadImage(input.files[0], textarea);
    }
  }

  function uploadImage(image, textarea) {
    var data = new FormData();
    data.append("image", image);
    $.ajax({
      url: "<?php echo site_url('posts/upload_image')?>",
      cache: false,
      contentType: false,
      processData: false,
      data:data,
      type: "POST",
      success: function(url) {
        if(!url){
          $('#preview_'+textarea).removeAttr('src');
          toastr.error('Invalid image type');
        } else{
          $('#image_'+textarea).val(url);
        }
      },
      error: function(data) {
        console.log(data);
      }
    });
  }

$(function() {
  var imagesPreview = function(input, placeToInsertImagePreview) {
    if (input.files) {
      $('#body_bottom_0').show();
      var filesAmount = input.files.length;
      for (i = 0; i < filesAmount; i++) {
        var reader = new FileReader();
        reader.onload = function(event) {
          $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
        }
        reader.readAsDataURL(input.files[i]);
      }
    }
  };
  $('#post_image_0').on('change', function() {
    imagesPreview(this, 'div.preview_0');
  });
});
</script>
<script type="text/javascript">
$(document).ready(function(){
  $('.swipebox').swipebox();
  liked();

  $("#unfollow_user").one('click', function (event) {  
    event.preventDefault();
    var user_ID = $(this).data('user-id');
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>users/unfollow",
      dataType : "JSON",
      data:{user_ID:user_ID},
      success: function(data){
        location.reload();
      }
    });
    $(this).prop('disabled', true);
  });

  $("#follow_user").one('click', function (event) {  
    event.preventDefault();
    var user_ID = $(this).data('user-id');
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>users/follow",
      dataType : "JSON",
      data:{user_ID:user_ID},
      success: function(data){
        location.reload();
      }
    });
    $(this).prop('disabled', true);
  });

  //Create Message
  $('#createamessage').on('click',function(){
    var user_ID=$('[name="user_ID"]').val();
    var message=$('[name="chat_message"').val();
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>messages/create_message",
      dataType : "JSON",
      data : {user_ID:user_ID , chat_message:message},
      success: function(data){
        if(data.error){
            toastr.error(data.message);
        } else {
          toastr.success('Message Sent.');
          window.location.replace("<?php echo base_url().'messages'?>");
        }
      }
    });
    return false;
  });

  $(document).on('click', '.followers', function(){
    $('#followers').modal('show');
    var user_ID = $(this).data('user-id');
    $.ajax({
      url:"<?=base_url()?>users/get_followers",
      method:"POST",
      async : true,
      dataType : 'json',
      data:{user_ID:user_ID},
      success:function(data) {
        $('#list_followers').html(data);
      }
    })
  });

  $(document).on('click', '.following', function(){
    $('#following').modal('show');
    var user_ID = $(this).data('user-id');
    $.ajax({
      url:"<?=base_url()?>users/get_following",
      method:"POST",
      async : true,
      dataType : 'json',
      data:{user_ID:user_ID},
      success:function(data) {
        $('#list_following').html(data);
      }
    })
  });

  if(window.location.hash != ''){ 
    var hash = document.URL.substr(document.URL.indexOf('#')+1);
    $('html, body').animate({
      scrollTop: $('#posts_ID_'+hash).offset().top
    }, 'slow');
  }

  $("#accept_reward").one('click', function (event) {  
    event.preventDefault();
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>users/accept_reward",
      dataType : "JSON",
      success: function(data){
        toastr.success('Gain '+data.exp+' exp!');
        $('#daily_login').modal('hide');
      }
    });
    $(this).prop('disabled', true);
  });

  <?php if ($my_info['id'] == $my_id) {?>
  create_ckeditor('posts');
  create_ckeditor('edit_post_value');
  <?php } ?>
  create_ckeditor('textarea_comments_1');
  liked();
  $('.swipebox').swipebox();
  create_popover();

  $(document).on("click", ".imgs-grid-image", function() { 
    var post_ID = $(this).closest(".view_post").data('post-id');
    var user_ID = $(this).closest(".view_post").data('user-id');
    $('#view_full_post_modal').modal('show');
    $('.full_post_submit_comment').data('post-id', post_ID);
    $('.full_post_submit_comment').data('user-id', user_ID);
    var index = $(this).data('id');
    $.ajax({
      url:"<?=base_url()?>posts/get_full_post",
      method:"POST",
      async : true,
      dataType : 'json',
      data:{post_ID:post_ID},
      success:function(data) {
        $("#post_content").html(data);
        create_popover();
      }
    });
    $.ajax({
      url:"<?=base_url()?>posts/get_post_images",
      method:"POST",
      async : true,
      dataType : 'json',
      data:{post_ID:post_ID},
      success:function(data) {
        var html = '';
        html += '<div id="carouselExampleControls" class="carousel slide"  data-interval="false"><div class="carousel-inner">';
        for(i=0; i<data.length; i++){
          if(index == data[i].index){
            html +=  '<div class="carousel-item active"><img src="<?php echo base_url(); ?>assets/img/posts/'+data[i].user_ID+'/'+data[i].image+'" alt="image" class="img-fluid" <?php if(isMobile() == 0){ echo 'style="height: 750px; overflow: auto;"'; } ?>></div>';
          } else {
            html +=  '<div class="carousel-item"><img src="<?php echo base_url(); ?>assets/img/posts/'+data[i].user_ID+'/'+data[i].image+'" alt="image" class="img-fluid" <?php if(isMobile() == 0){ echo 'style="height: 750px; overflow: auto;"'; } ?>></div>';
          }
        }
        if(i != 1){
          html += '</div><a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="sr-only">Previous</span></a><a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="sr-only">Next</span></a></div>';
        } else {
          html += '</div></div>';
        }
        $("#view_post_image").html(html);
      }
    });
    $(".imgs-grid-modal").remove();
  });

  function create_ckeditor(element){
    CKEDITOR.replace(element, {
      plugins: 'mentions,emoji,basicstyles,undo,link,wysiwygarea,toolbar, autolink',
      height: 60,
      width: 500,
      width: '99%',
      toolbar: [{name: 'document', items: ['Undo', 'Redo']},{name: 'links', items: ['EmojiPanel', 'Link', 'Unlink']}],
      mentions: [{
          feed: dataFeed,
          itemTemplate: '<li data-id="{id}">' +
            '<img class="photo" src="{avatar}" style="width: 25px;"/>' +
            '<span class="fullname"> {fullname}</span>' +
            '</li>',
          outputTemplate: '<a href="<?php echo base_url(); ?>user-profile/{id}">@{fullname}</a><span>&nbsp;</span>',
          minChars: 0
        },
        {
          feed: tags,
          marker: '#',
          itemTemplate: '<li data-id="{id}"><strong>{fullname}</strong></li>',
          outputTemplate: '<a href="https://example.com/social?tag={fullname}">{fullname}</a>',
          minChars: 1
        }
      ]
    });
  }

  $("#accept_reward").one('click', function (event) {  
    event.preventDefault();
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>users/accept_reward",
      dataType : "JSON",
      success: function(data){
        toastr.success('Gain '+data.exp+' exp!');
        $('#daily_login').modal('hide');
      }
    });
    $(this).prop('disabled', true);
  });

  //Delete posts
  $(document).on("click", ".delete_post", function() { 
    var post_ID=$(this).data('post-id');
    $('#delete_post').modal('show');
    $('[name="post_ID"]').val(post_ID);
  });

  //Edit posts
  $(document).on("click", ".edit_post", function() { 
    var post_ID=$(this).data('post-id');
    $('[name="post_ID"]').val(post_ID);
    $('#edit_post').modal('show');
    $.ajax({
      url:"<?=base_url()?>posts/get_post",
      method:"POST",
      async : true,
      dataType : 'json',
      data:{post_ID:post_ID},
      success:function(data) {
        CKEDITOR.instances['edit_post_value'].setData(data.posts);
      }
    })
  });

  $(document).on('click', '.view_likers', function(){
    $('#view_likers').modal('show');
    var post_ID = $(this).data('post-id');
    $.ajax({
      url:"<?=base_url()?>posts/get_likers",
      method:"POST",
      async : true,
      dataType : 'json',
      data:{post_ID:post_ID},
      success:function(data) {
        var html = ''
        var i;
        for(i=0; i<data.length; i++){
          html += '<a class="mb-2" href="<?php echo base_url();?>user-profile/'+data[i].user_ID+'"><img class="mb-2 rounded-circle mr-2 card-img-100 chat-mes-id" src="<?php echo base_url();?>assets/img/users/'+data[i].image+'" style="height: 30px; width: 30px" alt="Profile photo">'+data[i].first_name+'</a><br>';
        }
        $('#likers_post').html(html);
      }
    })
  });

  //Like post
  $(document).on('click', '.liked', function(){
    var posts = $(this).data('post-id');
    var user_ID = $(this).data('user-id');
    var status = $(this).data('status');
    $.ajax({
      url:"<?=base_url()?>posts/liked",
      method:"POST",
      async : true,
      dataType : 'json',
      data:{posts:posts, user_ID:user_ID, status,status},
      success:function(data) {
        $('.liked_'+posts).removeClass('text-dark');
        if(!data.status){
          $('.liked_'+posts).removeClass('blue-text');
          $(".liked_"+posts).data("status", 0)
        } else {
          $('.liked_'+posts).addClass('blue-text');
          $(".liked_"+posts).data("status", 1);
        }      
      }
    })
  });

  //Like comment
  $(document).on('click', '.like_comment', function(){
    var comment_ID = $(this).data('comment-id');
    var user_ID = $(this).data('user-id');
    var post_ID = $(this).data('post-id');
    var status = $(this).data('status');
    $.ajax({
      url:"<?=base_url()?>posts/like_comment",
      method:"POST",
      async : true,
      dataType : 'json',
      data:{comment_ID:comment_ID, user_ID:user_ID, post_ID:post_ID, status:status},
      success:function(data) {
        if(!data.status){
          $('.like_comment_'+comment_ID).removeClass('blue-text');
          $('.like_comment_'+comment_ID).data("status", 0);
        } else {
          $('.like_comment_'+comment_ID).addClass('blue-text');
          $('.like_comment_'+comment_ID).data("status", 1);
        }      
      }
    })
  });

  function liked_comments() {
    $.ajax({
      type : "POST",
      url  : base_url +"posts/get_liked_comments",
      dataType : "JSON",
      success: function(data){
        for(i=0; i<data.length; i++){
          $('.like_comment_'+data[i].comment_ID).addClass('blue-text');
          $('.like_comment_'+data[i].comment_ID).data("status", 0);
        }
      }
    });
  }

  function liked() {
    liked_comments();
    $.ajax({
      type : "POST",
      url  : base_url +"posts/get_liked",
      dataType : "JSON",
      success: function(data){
        for(i=0; i<data.length; i++){
          $('.liked_'+data[i].post_ID).addClass('blue-text');
          $('.liked_'+data[i].post_ID).data("status", 0);
        }
      }
    });
    $('.total_likes').each(function(){
      var post_ID = $(this).data('post-id');
      $.ajax({
        type : "POST",
        url  : base_url +"posts/total_likes",
        dataType : "JSON",
        data:{post_ID:post_ID},
        success: function(data){
          if (data > 0){
            html = '<i class="far fa-thumbs-up text-primary"></i> '+data;
            $('.total_likes_'+post_ID).html(html);
          }
        }
      });
    });
    $('.total_comments').each(function(){
      var post_ID = $(this).data('post-id');
      $.ajax({
        type : "POST",
        url  : base_url +"posts/total_comments",
        dataType : "JSON",
        data:{post_ID:post_ID},
        success: function(data){
          if(data == 1){
            $('.view_comments_'+post_ID).hide();
            $('.total_comments_'+post_ID).text(data+' comment');
          } else if (data > 1){
            $('.view_comments_'+post_ID).text('View all '+data+' comments');
            $('.total_comments_'+post_ID).text(data+' comments');
          }
        }
      });
    });
  }

  var textarea = 2;
  $(document).on('click', '.view_comments', function(){
    var post_ID = $(this).data('post-id');
    var user_ID = $(this).data('user-id');
    get_comments(post_ID, user_ID);
    liked_comments();
    $(this).hide();
  });

  $(document).on('click', '.view_replies', function(){
    var comment_ID = $(this).data('comment-id');
    var post_ID = $(this).data('post-id');
    var user_ID = $(this).data('user-id');
    var post = $(this).data('post');
    get_replies(post_ID, comment_ID, user_ID, post);
    liked_comments();
  });

  $(document).on('click', '.uploadTrigger', function(){
    var textarea_ID = $(this).data('textarea-id');
    $("#post_image_"+textarea_ID).click();
  });

  $(document).on("click", ".submit_comment", function() { 
    var post_ID = $(this).data('post-id');
    var textarea_ID = $(this).data('textarea-id');
    var comment = CKEDITOR.instances['textarea_comments_'+textarea_ID].getData();
    var image = $('#image_'+textarea_ID).val();
    var user_ID = $(this).data('user-id');
    var comment_ID = $(this).data('comment-id');
    if(comment != '' || image != ''){
      $.ajax({
        type : "POST",
        url  :  "<?=base_url()?>posts/add_comment",
        dataType : "JSON",
        data : {post_ID:post_ID, comment:comment, comment_ID:comment_ID, user_ID:user_ID, image:image},
        success: function(data){
          if(!data){
            toastr.error('This posts has been deleted.');
          }
          CKEDITOR.instances['textarea_comments_'+textarea_ID].setData('');
          $('#textarea_comments_'+textarea_ID).val('');
          $('#image_'+textarea_ID).val('');
          $('#preview_'+textarea_ID).removeAttr('src');
          $('#body_bottom_'+textarea_ID).hide();
          toastr.success('Gained 20 Exp!');
          get_level();
          $('#body_bottom_'+textarea_ID).hide();
          if(comment_ID != 0){
            fetch_comments_reply(post_ID, comment_ID);
          } else {
            fetch_comments(post_ID, 0);
          }
        }
      });
    } else {
      toastr.error('Enter a comment or image');
    }
  });

  <?php 
    $all_users = array();
    foreach ($users as $user) {
      if(!empty($user["first_name"]) || !empty($user["first_name"])){
        if($my_info['id'] != $user["id"] && $user["status"] == 1) {
          $all_users[] = array(
            'id' =>  $user["id"],
            'fullname' =>  ucwords($user["first_name"]).' '.ucwords($user["last_name"]),
            'avatar' => 'assets/img/users/'.$user['image']
          );
        }
      }
    }
  ?>
  var users = <?php echo json_encode($all_users); ?>,
  tags = [];

  function createNewEditor(post_ID, textarea) {
    var element = document.createElement("textarea");
    $(element).addClass("textarea_"+textarea).attr('name', 'textarea_comments_'+textarea).appendTo('#textarea_comments_'+textarea);
    return create_ckeditor(element);
  }

  function get_comments(post_ID, user_ID) {
    var comments = '<div class="form-group m-2 mb-0 textarea_comments"><label for="quickReplyFormComment">Your comment</label><input type="file" style="display:none;" name="post_image" id="post_image_'+textarea+'" onchange="readURL(this, '+textarea+');"><input type="hidden" name="image_'+textarea+'" id="image_'+textarea+'"><button type="button" class="btn btn-link uploadTrigger m-0 ml-4 px-2 py-2" id="uploadTrigger_'+textarea+'" data-textarea-id="'+textarea+'"><i class="fas fa-photo-video mr-2 green-text"></i>Photo</button><div id="textarea_comments_'+textarea+'"></div><div id="body_bottom_'+textarea+'" class="image_textarea"><img class="ml-2 mt-2" id="preview_'+textarea+'"/></div><div class="text-center"><button class="btn btn-primary btn-sm submit_comment" type="submit" data-post-id="'+post_ID+'" data-user-id="'+user_ID+'" data-textarea-id="'+textarea+'" data-comment-id="0">Comment</button></div></div><div id="comments_posts_'+post_ID+'"></div>';
    fetch_comments(post_ID, 0);
    $('#comment_section_'+post_ID).html(comments);
    createNewEditor(post_ID, textarea);
    textarea++;
  }

  function get_replies(post_ID, comment_ID, user_ID, post) {
    var reply = '<div class="form-group mt-2"><label for="quickReplyFormComment">Your reply</label><input type="file" style="display:none;" name="post_image" id="post_image_'+textarea+'" onchange="readURL(this, '+textarea+');"><input type="hidden" name="image_'+textarea+'" id="image_'+textarea+'"><button type="button" class="btn btn-link uploadTrigger ml-4 m-0 px-2 py-2" id="uploadTrigger_'+textarea+'" data-textarea-id="'+textarea+'"><i class="fas fa-photo-video mr-2 green-text"></i>Photo</button><div id="textarea_comments_'+textarea+'"></div><div id="body_bottom_'+textarea+'" class="image_textarea"><img class="ml-2 mt-2" id="preview_'+textarea+'"/></div><div class="text-center"><button class="btn btn-primary btn-sm submit_comment" type="submit" data-post-id="'+post_ID+'" data-comment-id="'+comment_ID+'" data-user-id="'+user_ID+'" data-textarea-id="'+textarea+'">Add Reply</button></div></div><div class="post_reply_'+comment_ID+'"></div>';
    fetch_comments_reply(post_ID, comment_ID); 
    if(post == 0){
      $('#full_post_add_reply_'+comment_ID).html(reply);
    } else {
      $('#add_reply_'+comment_ID).html(reply);
    }
    
    createNewEditor(post_ID, textarea);
    textarea++;
    create_popover();
  }

  function fetch_comments(post_ID, post){
    $.ajax({
      method  : 'post',
      url   : "<?=base_url()?>posts/get_comments",
      dataType : 'json',
      async : true,
      data:{post_ID:post_ID},
      success : function(data){
        if(post == 0){
          $('#comments_posts_'+post_ID).html(data);
        } else {
          $('#full_post_comments'+post_ID).html(data);
        }
        
        $("img").addClass("img-fluid");
        create_popover();
      }
   });
  }

  function fetch_comments_reply(post_ID, comment_ID){
    $.ajax({
      method  : 'post',
      url   : "<?=base_url()?>posts/get_replies",
      dataType : 'json',
      async : true,
      data:{post_ID:post_ID, comment_ID:comment_ID},
      success : function(data){
        $('.post_reply_'+comment_ID).html(data);
        $("img").addClass("img-fluid");
      }
    });
  }

  $('.confirm_delete_post').on('click',function(){
    var post_ID = $('[name="post_ID"]').val();
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>posts/delete_post",
      dataType : "JSON",
      data : {post_ID:post_ID},
      success: function(data){
        toastr.error('Post deleted');
        location.reload();
      }
    });
    return false;
  });

  $(document).on("click", ".delete_comment", function() { 
    var comment_ID=$(this).data('comment-id');
    var post_ID=$(this).data('post-id');
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>posts/delete_comment",
      dataType : "JSON",
      data : {comment_ID:comment_ID},
      success: function(data){
        toastr.error('Comment deleted');
        $('.comments_ID_'+comment_ID).remove();
      }
    });
    return false;
  });

  var start = 5;

  $(document).on("click", ".load_more", function() { 
    var user_ID=$(this).data('user-id');
    $.ajax({
      url: "<?=base_url()?>posts/load_more",
      type: 'post',
      data: {start:start, user_ID:user_ID},
      beforeSend:function(){
        $(".load_more").text("Loading...");
      },
      success: function(response){
        $(".posts:last").after(response).show().fadeIn("slow");
        $(".load_more").text("View more");
        start = start + 5;
        if(!$.trim(response)) {
          $(".load_more").hide();
        }
        $("img").addClass("img-fluid");
        liked();
        create_popover();
      }
    });
  });

  $('#daily_login').modal('show');

  function dataFeed(opts, callback) {
    var matchProperty = 'fullname',
      data = users.filter(function(item) {
        return item[matchProperty].toLowerCase().indexOf(opts.query.toLowerCase()) > -1
      });
    data = data.sort(function(a, b) {
      return a[matchProperty].localeCompare(b[matchProperty], undefined, {
        sensitivity: 'accent'
      });
    });
    callback(data);
  }

  function create_popover(){
    $('.post_popover').popover({
      sanitize: false,
      placement : 'left',
      html : true,
      content: '<a class="mb-4 edit_post blue-text" data-post-id="0"><i class="fas fa-edit"></i> Edit Post</a><br><a class="delete_post red-text" data-post-id="0"><i class="fas fa-trash"></i> Delete Post</a>',
    });
    $('.profile_popover').popover({
      sanitize: false,
      html : true,
      trigger: 'hover',
      content: '<div id="user_profile"></div>',
    });
    $('.profile_popover').on('show.bs.popover', function () {
      $.ajax({
        type : "POST",
        url  : "<?=base_url()?>users/get_users",
        dataType : "JSON",
        data : {user_ID:$(this).data('user-id')},
        success: function(data){
          html = '<div class="d-flex flex-row mb-2"><img src="<?php base_url(); ?>assets/img/users/'+data.image+'" class="rounded-circle mr-2 chat-mes-id-2" alt="avatar" style="height: 50px;width: 50px;"><div><h6><strong>'+data.full_name+'</strong></h6><i>Level '+data.level+'</i></div></div><div class="d-flex"><h6><strong>'+data.count_posts+'</strong> Posts</h6><h6 class="ml-2"><strong>'+data.count_following+'</strong> Following</h6><h6 class="ml-2"><strong>'+data.count_followers+'</strong> Followers</h6></a></div>';
          $("#user_profile").html(html);
        }
      });
    });
  }

  $(document).on("click", ".post_popover", function() { 
    var post_ID=$(this).data('post-id');
    $(".edit_post").data("post-id", post_ID);
    $(".delete_post").data("post-id", post_ID);
  });
});
</script>