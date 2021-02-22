<main class="pt-5">
<div class="container mt-5">
  <section class="text-center mb-4">
    <div class="row">
      <div class="col-md-12">
        <?php if(strtotime($created_at['created_at']) > strtotime('-3 days')){ ?>
          <h1>Welcome to </h1>
        <?php } ?>
        <picture>
          <img src="<?php echo base_url();?>assets/img/<?php echo $settings['logo_img'];?>" class="img-fluid mb-3" alt="" style="height: 70px;">
        </picture>
        <p class="h4 text-dark">Dedicated to creating the most innovating<br> educational experiences EVER.</p>
        <?php echo form_open_multipart('search'); ?>
          <div class="mt-5 pt-5 form-inline md-form mr-auto justify-content-center ">
            <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search" name="search">
            <button class="btn btn-primary btn-rounded btn-sm my-0" type="submit">Search</button>
          </div>
        <?php echo form_close(); ?>
      </div><!--Grid column-->
    </div><!--Grid row-->
  </section><!--Section-->
  <?php if(strtotime($created_at['created_at']) > strtotime('-14 days')){ ?>
  <section class="pb-4 mb-4 mt-4 pt-4">
    <h3 class=""><i class="fas fa-book-reader amber-text" aria-hidden="true"></i> Let's Start Learning, <?php echo ucwords($created_at['first_name']); ?> <?php echo ucwords($created_at['last_name']); ?></h3>
    <p class="ml-4 font-weight-light mb-3">Browse your course and discover what's inside.</p>
    <div class="row">
      <?php foreach ($user_programs as $user_program) { ?>
      <div class="col-md-6">
        <a href="<?php base_url(); ?>modules/<?php echo $user_program['slug'];?>" class="card hoverable">
          <div class="card-body">
            <div class="media">
              <p><i class="fas fa-search fa-2x text-primary mr-4"></i></p>
              <div class="media-body">
                <h5 class="dark-grey-text"><?php echo ucwords($user_program['name']);?></h5>
              </div>
            </div>
          </div>
        </a>
      </div><!--Column-->
      <?php } ?>
    </div><!--Row-->
  </section>
  <?php } ?>
  <?php if(!empty($last_watched['content_row'])){ ?>
  <section class="mb-4 mt-4 pt-4">
    <div class="row">
      <div class="col-md-7 mb-4">
        <div class="view">
          <div class="embed-responsive embed-responsive-16by9">
            <img class="lazyframe embed-responsive-item img-fluid" data-src="<?php echo $last_watched['content_url']; ?>" data-vendor="vimeo">
            </img> 
          </div>
        </div>
      </div><!--Grid column-->
      <div class="col-md-5 mb-4 text-right">
        <h3 class="mb-3"><i class="fas fa-eye amber-text" aria-hidden="true"></i> <strong>Last Video Watched</strong></h3>
        <h6><strong><?php echo ucwords($last_watched['name']);?></strong></h6>
        <p><?php echo ucwords($last_watched['content_name']);?></p>
        <a href="<?php base_url(); ?>modules/<?php echo $last_watched['program_slug'];?>/<?php echo $last_watched['slug'];?>/<?php echo $last_watched['section_slug'];?>#<?php echo $last_watched['content_ID'];?>" class="btn btn-primary btn-md waves-effect waves-light"> Continue to last video
          <i class="far fa-image ml-1"></i>
        </a>
        <a href="<?php base_url(); ?>my-profile" class="btn btn-info btn-md waves-effect waves-light"> View all history
          <i class="far fa-image ml-1"></i>
        </a>
        <hr>
        <h3 class="mb-4"><i class="fas fa-award amber-text" aria-hidden="true"></i> <strong>My Progress</strong></h3>
        <div id="course_progress">
        </div>
      </div><!--Grid column-->
    </div><!--Grid row-->
  </section><!--Section-->
  <?php } ?>
  <section class="text-center mt-4 pt-4">
    <div class="row flex-column-reverse flex-md-row">
      <div class="col-lg-8 col-md-12">
        <h3 class="mb-3"><i class="fas fa-newspaper amber-text" aria-hidden="true"></i> <strong>Weekly Live Mastermind Calls: </strong></h3>
          <?php echo $pages['content']; ?>
      </div><!--Grid column-->
      <div class="col-lg-4 col-md-12">
        <div class="card mb-4">
          <div class="card-header customcolorbg text-white h6">
            <i class="fas fa-crown amber-text" aria-hidden="true"></i> Rankings  
          </div>
          <div class="card-body">
            <?php foreach ($rankings as $ranking) { ?>
              <img src="<?php echo base_url();?>assets/img/<?php echo $ranking['image'];?>" class="rounded-circle float-left" height="25px" width="25px" alt="avatar">
              <h6 class="card-title text-left"><strong>Level <?php echo ucwords($ranking['level']);?></strong> <a <?php if($ranking['id'] == $created_at['id']){ echo 'href="'.base_url().'my-profile"'; } else { echo 'href="'.base_url().'user-profile/'.$ranking['id'].'"'; };?>><?php echo ucwords($ranking['first_name']);?> <?php echo ucwords($ranking['last_name']);?></a></h6>
            <?php } ?>
            <a href="<?php base_url(); ?>rankings" class="btn btn-primary btn-md waves-effect waves-light">View All</a>
          </div>
        </div><!--/.Card-->
      </div><!--column-->
    </div><!--row-->
  </section><!--Section-->
  <?php echo form_open_multipart('posts/create'); ?>
  <section class="mt-4 pt-4 mb-5">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="card">
          <div class="media mt-2">
            <img class="rounded-circle ml-2 card-img-100 d-flex z-depth-1 mr-2 chat-mes-id" src="<?php echo base_url();?>assets/img/users/<?php echo $created_at['image'];?>" style="height: 50px; width: 50px" alt="Profile photo"/>
            <div class="media-body d-flex">
              <textarea type="textarea" class="form-control mt-2 mr-2" name="posts" id="posts" rows="1" placeholder="What's on your mind, <?php echo ucwords($created_at['first_name']);?>?"></textarea>
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
      </div><!--column-->
    </div><!--row-->
  </section><!--Section-->
  <?php echo form_close(); ?>
  <!--Section: Newsfeed-->
  <?php foreach ($posts as $post) {
    if($post['post_status'] == 1){
  ?>
  <section class="mb-4 posts">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="card">
          <div class="media mt-2">
            <img class="rounded-circle ml-2 card-img-100 d-flex z-depth-1 mr-2 chat-mes-id" src="<?php echo base_url();?>assets/img/users/<?php echo $post['image'];?>" style="height: 50px; width: 50px" alt="Profile photo">
            <div class="media-body">
               <h5><a class="text-dark" <?php if($post['user_ID'] == $created_at['id']){ echo 'href="'.base_url().'my-profile"'; } else { echo 'href="'.base_url().'user-profile/'.$post['user_ID'].'"'; };?>><?php echo ucwords($post['first_name']);?> <?php echo ucwords($post['last_name']);?></a>
                <?php if ($post['user_ID'] == $created_at['id']) {?>
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
              <div class="mt-4">
                <img src="<?php echo base_url().'assets/img/posts/'.hash('md5', $post['user_ID']).'/'.$post['post_image'];?>" class="w-100"/>
              </div>
            <?php } ?>
            <div class="d-flex justify-content-between mt-4 mb-2">
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
              <button type="button" class="btn btn-link text-red" disabled><i class="fas fa-share mr-2"></i>Share</button>
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
    <a class="blue-text load_more">View More</a>
  </div>
</div><!--Container-->
</main><!--Main layout-->
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
<script type="text/javascript">
$(document).ready(function(){
  $.ajax({
    type  : 'POST',
    url   : "<?=base_url()?>users/get_course_progress",
    dataType : 'json',
    success : function(data){
      var html = '';
      html += '<div class="form-inline"><div class="progress" style="width: 100%; height: 20px;"><div class="progress-bar bg-success" role="progressbar" style="width: '+data.percentage_width+'%;" aria-valuemin="0" aria-valuemax="'+data.total+'">'+data.percentage+' % </div></div></div>';
      $('#course_progress').html(html);
    }
  });
});
</script>
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
</script>
<script type="text/javascript">
$(document).ready(function(){
  $("img").addClass("img-fluid");
  liked();
  $('.swipebox').swipebox();

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
          if(!$.trim(response)) {
            $(".load_more").hide();
          }
          $("img").addClass("img-fluid");
          liked();
        }
    });
  });

  $('#daily_login').modal('show');
});
</script>

<?php if(strtotime($daily_logins['date_started']) > strtotime('-30 days') && date('j', strtotime($daily_logins['timestamp'])) < date('j')){ ?>
<div class="modal fade" id="daily_login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">Daily Login Mindset Reward</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?php echo form_open_multipart('users/accept_reward'); ?>
      <div class="modal-body">
        <p>Do the mindset for 30 consecutive days and get free 1 on 1 mastermind call!</p>
        <h6 class="red-text mb-4">NOTE: This rewards will last for 30 days</h6>
        <div class="row justify-content-center">
          <?php $i=1; $exp = 15; while($i < 31) {?>
          <div class="col-lg-2 col-md-3 col-sm-4 m-1 p-0 radio_card">
            <?php if($i == $daily_logins['days']){ ?>
              <input type="checkbox" id="checkbox_<?php echo $i;?>" name="reward" class="checkboxButton" value="1">
              <label for="checkbox_<?php echo $i;?>" class="checkbox_label">
            <?php } ?>
            <div class="card hoverable radio_card <?php if($i > $daily_logins['days']){ echo 'grey lighten-2 text-muted'; } ?> ">
              <div class="card-body">
                <h6 class="card-title">Day <?php echo $i;?> <?php if($i < $daily_logins['days']) { echo '<i class="fas fa-check green-text float-right"></i>'; }?></h6>
                <p><?php echo $exp;?> exp</p>
              </div>
            </div>
            </label>
          </div>
          <?php $i++; $exp = $exp + 15; } ?>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success btn-sm">Accept Reward</button>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>
<?php } ?>