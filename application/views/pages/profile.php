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
            <h4 class="mt-4"><strong><?php echo ucwords($my_info['first_name']);?> <?php echo ucwords($my_info['last_name']);?></strong></h4>
            <h5 class="font-italic"><?php echo ucwords($my_info['bio']);?></h5>
            <?php if($my_info['id'] == $my_id){?> 
            <h5 class="blue-text mb-4"><strong><?php echo $my_info['email'];?></strong></h5>
              <div class="d-flex">
                <button type="button" class="btn btn-primary btn-sm m-0 px-2 py-2" data-toggle="modal" data-target="#changepassword">Change Password</button>
                <button type="button" class="btn btn-info btn-sm m-0 px-2 py-2" data-toggle="modal" data-target="#editprofile">Edit Profile</button>
                <a class="btn btn-warning btn-sm m-0 px-2 py-2 fetch_notifcations">Notifications</a>
              </div>
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
          <table class="table table-bordered table-responsive display" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th scope="col">Modules</th>
                <th scope="col">Video Name</th>
                <th scope="col">Status</th>
                <th scope="col">Date Finished</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($histories as $history) {?>
              <tr>
                <td><?php echo ucwords($history['name']);?></td>
                <td><a href="<?php base_url();?>modules/<?php echo $history['program_slug'];?>/<?php echo $history['product_slug'];?>/<?php echo $history['course_slug'];?>/<?php echo $history['section_slug'];?>#<?php echo $history['content_ID'];?>" class="blue-text"><?php echo ucwords($history['content_name']);?></a></td>
                <td>
                  <?php if($history['status'] == 0){?>
                  <span class="badge badge-pill badge-info">On Going</span>
                  <?php } else { ?>
                  <span class="badge badge-pill badge-success">Finished</span>
                  <?php } ?>
                </td>
                <td><?php echo date("F d, Y h:i A", strtotime($history['timestamp']));?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div><!--Card Body-->
      </div><!--Card-->

      <div class="card-header customcolorbg mb-4">
        <h5 class="text-white"><strong>Denied Posts </strong></h5>
      </div>
      <?php foreach ($posts as $post) {
        if($post['post_status'] == 2){
       ?>
      <section class="mb-4" id="posts_ID_<?php echo $post['post_ID'];?>">
        <div class="row justify-content-center">
          <div class="col-lg-12">
            <div class="card">
              <div class="media mt-2">
                <img class="ml-2 card-img-100 d-flex z-depth-1 mr-3 chat-mes-id" src="<?php echo base_url();?>assets/img/users/<?php echo $post['image'];?>" style="height: 50px; width: 50px" alt="Profile photo">
                <div class="media-body">
                  <h5 class="font-weight-bold mt-0">
                    <a class="text-default" href="<?php base_url();?>user-profile/<?php echo $post['id'];?>"><?php echo ucwords($post['first_name']);?> <?php echo ucwords($post['last_name']);?></a>
                    <?php if ($post['user_ID'] == $my_id) {?>
                      <a class="float-right red-text mr-2"><i class="fas fa-times delete_post" data-post-id="<?php echo $post['post_ID'];?>"></i></a>
                    <?php } ?>
                  </h5>
                  <?php echo date("M d, Y h:i A", strtotime($post['timestamp']));?>
                </div>
              </div>
              <div class="card-body">
                <?php echo $post['posts'];?>
              </div>
               <div class="card-title text-left ml-2">
                4 likes 4 comments
              </div>
              <div class="card-header border-0 font-weight-bold text-center">
                <a class="ml-2 liked liked_<?php echo $post['post_ID'];?>" data-post-id="<?php echo $post['post_ID'];?>" data-user-id="<?php echo $post['user_ID'];?>">Like</a> <a class="ml-2 view_comments" data-post-id="<?php echo $post['post_ID'];?>" data-user-id="<?php echo $post['user_ID'];?>">Comments</a>
              </div>
              <div id="comment_section_<?php echo $post['post_ID'];?>">
              </div>
            </div><!--/.Card-->
          </div>
        </div>
      </section>
      <?php } } ?>
      <?php } ?>
    </div><!--Column -->
    <div class="col-lg-6">
      <?php if ($my_info['id'] == $my_id) {?>
        <?php echo form_open_multipart('posts/create'); ?>
          <section class="mb-5">
            <div class="card">
              <div class="media mt-2">
                <img class="rounded-circle ml-2 card-img-100 d-flex z-depth-1 mr-2 chat-mes-id" src="<?php echo base_url();?>assets/img/users/<?php echo $my_info['image'];?>" style="height: 50px; width: 50px" alt="Profile photo"/>
                <div class="media-body d-flex">
                  <textarea type="textarea" class="form-control mt-2 mr-2" name="posts" id="posts" rows="1" placeholder="What's on your mind, <?php echo ucwords($my_info['first_name']);?>?"></textarea>
                </div>
              </div>
              <div id="body_bottom_0" class="image_textarea">
                <img class="ml-2 mt-2" id="preview_0"/>
              </div>
              <div class="card-body py-0 mt-2">
                <div class="d-flex justify-content-end text-center border-top">
                  <input type="hidden" name="image" id="image_0">
                  <input type="file"  onchange="readURL(this, 0);" style="display:none;" name="post_image" id="post_image_0">
                  <button type="button" class="btn btn-link uploadTrigger" data-textarea-id="0"><i class="fas fa-photo-video mr-2 green-text"></i>Photo</button>
                  <button class="btn btn-primary btn-sm" type="submit" id="create_posts">Posts</button>
                </div>
              </div>
            </div> <!-- Card -->
          </section><!--Section-->
        <?php echo form_close(); ?>
      <?php } ?>
      <?php foreach ($posts as $post) {
        if($post['post_status'] == 1){
       ?>
        <section class="mb-4 posts">
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="media mt-2">
                  <img class="rounded-circle ml-2 card-img-100 d-flex z-depth-1 mr-2 chat-mes-id" src="<?php echo base_url();?>assets/img/users/<?php echo $post['image'];?>" style="height: 50px; width: 50px" alt="Profile photo">
                  <div class="media-body">
                     <h5><a class="text-dark" <?php if($post['user_ID'] == $my_id['id']){ echo 'href="'.base_url().'my-profile"'; } else { echo 'href="'.base_url().'user-profile/'.$post['user_ID'].'"'; };?>><?php echo ucwords($post['first_name']);?> <?php echo ucwords($post['last_name']);?></a>
                      <?php if ($post['user_ID'] == $my_id['id']) {?>
                        <a class="float-right red-text mr-1"><i class="fas fa-times delete_post" data-post-id="<?php echo $post['post_ID'];?>"></i></a>
                      <?php } ?></h5>
                    <span class="text-muted text-dark"><small><?php echo date("M j, Y h:i A", strtotime($post['timestamp']));?></small></span>
                  </div>
                </div>
                <div class="card-body py-0 mt-2"> 
                  <p class="post-text">
                    <?php echo ucfirst($post['posts']);?>
                  </p>
                  <?php if (!empty($post['post_image'])) {?>
                    <div class="bg-image hover-overlay ripple rounded-0 mt-4">
                      <img src="<?php echo base_url().'assets/img/posts/'.hash('md5', $post['user_ID']).'/'.$post['post_image'];?>" class="w-100"/>
                        <a href="#!">
                          <div class="mask" style="background-color: rgba(251, 251, 251, 0.2)" ></div>
                        </a>
                    </div>
                  <?php } ?>
                  <div class="d-flex justify-content-between mt-4">
                    <div>
                      <span class="total_likes total_likes_<?php echo $post['post_ID'];?>" data-post-id="<?php echo $post['post_ID'];?>"></span>
                    </div>
                    <div>
                      <a class="total_comments total_comments_<?php echo $post['post_ID'];?> view_comments" data-post-id="<?php echo $post['post_ID'];?>" data-user-id="<?php echo $post['user_ID'];?>"></a>
                    </div>
                  </div>
                  <div class="d-flex justify-content-between text-center border-top border-bottom">
                    <button type="button" class="ml-2 liked liked_<?php echo $post['post_ID'];?> btn btn-link" data-post-id="<?php echo $post['post_ID'];?>" data-user-id="<?php echo $post['user_ID'];?>"><i class="far fa-thumbs-up mr-2"></i> Like</button>
                    <button type="button" class="ml-2 view_comments btn btn-link" data-post-id="<?php echo $post['post_ID'];?>" data-user-id="<?php echo $post['user_ID'];?>"><i class="far fa-comment-alt mr-2"></i> Comment</button>
                    <button type="button" class="btn btn-link text-red" data-ripple-color="dark" disabled><i class="fas fa-share mr-2"></i>Share</button>
                  </div>
                  <div id="comment_section_<?php echo $post['post_ID'];?>">
                  </div>
                </div>
              </div><!--/.Card-->
            </div>
          </div>
        </section>
      <?php } } ?>
      <div class="text-center">
        <a class="blue-text load_more" data-user-id="<?php if(empty($posts[1]['user_ID'])){ echo $posts[1]['user_ID']; } else { echo $my_id; } ?>">View More</a>
      </div>
    </div><!--Column-->
  </div><!--Row-->
</div><!--Container-->
</main>

<?php if($my_info['id'] == $my_id){?> 
<!-- Notifications-->
<div data-backdrop="static" class="modal fade" id="my_notifications" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-warning modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="heading lead">My Notifications</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modal_notifications">
      </div><!--Body-->
      <div class="modal-footer justify-content-center">
        <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</a>
      </div><!--Footer-->
    </div><!--Content-->
  </div>
</div>
<!-- Notifications-->

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
      if(textarea != 0){
        uploadImage(input.files[0], textarea);
      }
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
        $('#image_'+textarea).val(url);
      },
      error: function(data) {
        console.log(data);
      }
    });
  }
</script>

<script type="text/javascript">
$(document).ready(function(){
  $("img").addClass("img-fluid");
  liked();

  $('.swipebox').swipebox();

  if(window.location.hash != ''){ 
    var hash = document.URL.substr(document.URL.indexOf('#')+1);
    $('html, body').animate({
      scrollTop: $('#posts_ID_'+hash).offset().top
    }, 'slow');
    
  }

function enlarge_image_a(image){ 
    $('.image_toggle_'+image).animate({height: "100%", width: "100%"}); 
  }

  function enlarge_image_b(image){ 
    $('.image_toggle_'+image).animate({height: "150px", width: "150px"}); 
  }

  $(document).on('click', '.image_comments', function(){
    var image = $(this).data('img-id');
    return (this.tog = !this.tog) ? enlarge_image_a(image) : enlarge_image_b(image);
  });

  //Like post
  $(document).on('click', '.liked', function(){
    var posts = $(this).data('post-id');
    var user_ID = $(this).data('user-id');
    $.ajax({
      url:"<?=base_url()?>posts/liked",
      method:"POST",
      async : true,
      dataType : 'json',
      data:{posts:posts, user_ID:user_ID},
      success:function(data) {
        if(!data.status){
          $('.liked_'+posts).removeClass('blue-text');
        } else {
          $('.liked_'+posts).addClass('blue-text');
        }      
      }
    })
  });

  //Like comment
  $(document).on('click', '.like_comment', function(){
    var comment_ID = $(this).data('comment-id');
    $.ajax({
      url:"<?=base_url()?>posts/like_comment",
      method:"POST",
      async : true,
      dataType : 'json',
      data:{comment_ID:comment_ID},
      success:function(data) {
        if(!data.status){
          $('.like_comment_'+comment_ID).removeClass('blue-text');
        } else {
          $('.like_comment_'+comment_ID).addClass('blue-text');
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
        }
      }
    });
  }

  function liked() {
    $.ajax({
      type : "POST",
      url  : base_url +"posts/get_liked",
      dataType : "JSON",
      success: function(data){
        for(i=0; i<data.length; i++){
          $('.liked_'+data[i].post_ID).addClass('blue-text');
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
            $('.total_comments_'+post_ID).text(data+' comment');
          } else if (data > 1){
            $('.total_comments_'+post_ID).text(data+' comments');
          }
        }
      });
    });
  }

  var textarea = 1;
  $(document).on('click', '.view_comments', function(){
    var post_ID = $(this).data('post-id');
    var user_ID = $(this).data('user-id');
    get_comments(post_ID, user_ID);
    liked_comments();
  });

  $(document).on('click', '.view_replies', function(){
    var comment_ID = $(this).data('comment-id');
    var post_ID = $(this).data('post-id');
    var user_ID = $(this).data('user-id');
    get_replies(post_ID, comment_ID, user_ID);
    liked_comments();
  });

  $(document).on('click', '.uploadTrigger', function(){
    var textarea_ID = $(this).data('textarea-id');
    $("#post_image_"+textarea_ID).click();
  });

  $(document).on("click", ".submit_comment", function() { 
    var post_ID = $(this).data('post-id');
    var textarea_ID = $(this).data('textarea-id');
    var comment = $('#textarea_comments_'+textarea_ID).val();
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
          $('#textarea_comments_'+textarea_ID).val('');
          $('#image_'+textarea_ID).val('');
          $('#preview_'+textarea_ID).removeAttr('src');
          $('#body_bottom_'+textarea_ID).hide();
          if(comment_ID){
            fetch_comments_reply(post_ID, comment_ID);
          } else {
            fetch_comments(post_ID);
          }
        }
      });
    } else {
     toastr.error('Enter a comment or image');
    }
  });

  function get_comments(post_ID, user_ID) {
    var comments = '<div class="form-group m-2 mb-0"><label for="quickReplyFormComment">Your comment</label><input type="file" style="display:none;" name="post_image" id="post_image_'+textarea+'" onchange="readURL(this, '+textarea+');"><input type="hidden" name="image_'+textarea+'" id="image_'+textarea+'"><button type="button" class="btn btn-link uploadTrigger m-0 ml-4 px-2 py-2" id="uploadTrigger_'+textarea+'" data-textarea-id="'+textarea+'"><i class="fas fa-photo-video mr-2 green-text"></i>Photo</button><textarea class="form-control textarea_'+textarea+'" id="textarea_comments_'+textarea+'" name="textarea_comment" rows="1"></textarea><div id="body_bottom_'+textarea+'" class="image_textarea"><img class="ml-2 mt-2" id="preview_'+textarea+'"/></div><div class="text-center"><button class="btn btn-primary btn-sm submit_comment" type="submit" data-post-id="'+post_ID+'" data-user-id="'+user_ID+'" data-textarea-id="'+textarea+'">Comment</button></div></div><div id="comments_posts_'+post_ID+'"></div>';
    fetch_comments(post_ID);
    $('#comment_section_'+post_ID).html(comments);
    textarea++;
  }

  function get_replies(post_ID, comment_ID, user_ID) {
    var reply = '<div class="form-group mt-2"><label for="quickReplyFormComment">Your reply</label><input type="file" style="display:none;" name="post_image" id="post_image_'+textarea+'" onchange="readURL(this, '+textarea+');"><input type="hidden" name="image_'+textarea+'" id="image_'+textarea+'"><button type="button" class="btn btn-link uploadTrigger ml-4 m-0 px-2 py-2" id="uploadTrigger_'+textarea+'" data-textarea-id="'+textarea+'"><i class="fas fa-photo-video mr-2 green-text"></i>Photo</button><textarea class="form-control textarea_'+textarea+'" id="textarea_comments_'+textarea+'" rows="1"></textarea><div id="body_bottom_'+textarea+'" class="image_textarea"><img class="ml-2 mt-2" id="preview_'+textarea+'"/></div><div class="text-center"><button class="btn btn-primary btn-sm submit_comment" type="submit" data-post-id="'+post_ID+'" data-comment-id="'+comment_ID+'" data-user-id="'+user_ID+'" data-textarea-id="'+textarea+'">Add Reply</button></div></div><div id="post_reply_'+comment_ID+'"></div>';
    fetch_comments_reply(post_ID, comment_ID); 
    $('#add_reply_'+comment_ID).html(reply);
    textarea++;
  }

  function fetch_comments(post_ID){
    $.ajax({
      method  : 'post',
      url   : "<?=base_url()?>posts/get_comments",
      dataType : 'json',
      async : true,
      data:{post_ID:post_ID},
      success : function(data){
        $('#comments_posts_'+post_ID).html(data);
        $("img").addClass("img-fluid");
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
        $('#post_reply_'+comment_ID).html(data);
        $("img").addClass("img-fluid");
      }
    });
  }

  //delete posts
  $(document).on("click", ".delete_post", function() { 
    var post_ID=$(this).data('post-id');
    $('#delete_post').modal('show');
    $('[name="post_ID"]').val(post_ID);
  });

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
    $.ajax({
        url: "<?=base_url()?>posts/load_more",
        type: 'post',
        data: {start:start},
        beforeSend:function(){
          $(".load_more").text("Loading...");
        },
        success: function(response){
          $(".posts:last").after(response).show().fadeIn("slow");
          $(".load_more").text("View more");
          start = start + 5;
          if(!response) {
            $(".load_more").hide();
          }
          $("img").addClass("img-fluid");
          liked();
        }
    });
  });

  var my_ID = '<?php echo $my_id?>';
  var status = 1;
  $(document).on("click", ".fetch_notifcations", function() { 
    $('#my_notifications').modal('show');
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>posts/get_notifications",
      dataType : "JSON",
      data:{status:status},
      success: function(data){
        var html= '';
        var i;
        for(i=0; i<data.length; i++){
          if(my_ID == data[i].owner){
            html += '<a class="dropdown-item" href="<?php echo base_url();?>my-profile#'+data[i].post_ID+'">'+data[i].type+'<h6 class="m-4">'+data[i].posts+'</h6></a>';
          } else {
            html += '<a class="dropdown-item" href="<?php echo base_url();?>user-profile/'+data[i].owner+'#'+data[i].post_ID+'">'+data[i].type+'<h6>'+data[i].posts+'</h6></a>';
          }
        }
        $('#modal_notifications').html(html);
      }
    });
  });

});
</script>