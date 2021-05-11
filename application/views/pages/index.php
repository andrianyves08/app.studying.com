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
<main class="pt-5">
<div class="container-fluid mt-5">
  <section class="text-center mb-4">
    <div class="row">
      <div class="col-md-12">
        <?php if(strtotime($my_info['created_at']) > strtotime('-3 days')){ ?>
          <h1>Welcome to </h1>
        <?php } ?>
        <picture>
          <img src="<?php echo base_url();?>assets/img/<?php echo $settings['logo_img'];?>" class="img-fluid mb-3" alt="" style="height: 70px;">
        </picture>
        <p class="h4 text-dark mb-4">Dedicated to creating the most innovating<br> educational experiences EVER.</p>
        <h4 class="text-dark">Use student70 to get 70% at shop.studying.com</h4>
        <?php echo form_open_multipart('search'); ?>
          <div class="mt-5 pt-5 form-inline md-form mr-auto justify-content-center ">
            <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search" name="search">
            <button class="btn btn-primary btn-rounded btn-sm my-0" type="submit">Search</button>
          </div>
        <?php echo form_close(); ?>
      </div><!--Grid column-->
    </div><!--Grid row-->
  </section><!--Section-->
  <?php if(strtotime($my_info['created_at']) > strtotime('-14 days')){ ?>
  <section class="pb-4 mb-4 mt-4 pt-4">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <h3 class="text-center"><i class="fas fa-book-reader amber-text" aria-hidden="true"></i> Let's Start Learning, <?php echo ucwords($my_info['first_name']); ?> <?php echo ucwords($my_info['last_name']); ?></h3>
        <p class="text-center ml-4 font-weight-light mb-3">Browse your course and discover what's inside.</p>
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
        </div>
      </div>
    </div><!--Row-->
  </section>
  <?php } ?>
  <section class="mb-4 mt-4 pt-4">
    <div class="row justify-content-center">
      <div class="col-lg-4 mb-4 text-left">
        <h3 class="mb-3"><i class="fas fa-fire amber-text"></i> <strong>Current daily login streak : <?php echo $daily_logins['days']; ?> </strong></h3>
        <h3 class="mb-3"><i class="fas fa-eye amber-text" aria-hidden="true"></i> <strong>Last Video Watched</strong></h3>
        <h6><strong><?php echo ucwords($last_watched['name']);?></strong></h6>
        <p><?php echo ucwords($last_watched['content_name']);?></p>
        <div class="d-flex mt-2">
          <a href="<?php base_url(); ?>modules/<?php echo $last_watched['program_slug'];?>/<?php echo $last_watched['slug'];?>/<?php echo $last_watched['section_slug'];?>#<?php echo $last_watched['content_ID'];?>" class="btn btn-primary btn-md waves-effect waves-light m-0 px-2 py-2"> Continue to last video
          <i class="far fa-image ml-1"></i>
        </a>
        <a href="<?php base_url(); ?>my-profile" class="btn btn-info btn-md waves-effect waves-light m-0 px-2 py-2"> View all history
          <i class="far fa-image ml-1"></i>
        </a>
        </div>
          <h3 class="mt-4 mb-3"><i class="fas fa-newspaper amber-text" aria-hidden="true"></i> <strong>Weekly Live Mastermind Calls: </strong></h3>
          <?php echo $pages['content']; ?>
          <div class="card mb-4 mt-4">
          <div class="card-header customcolorbg text-white h6">
            <i class="fas fa-crown amber-text" aria-hidden="true"></i> Rankings  
          </div>
          <div class="card-body">
            <?php foreach ($rankings as $ranking) { ?>
              <img src="<?php echo base_url();?>assets/img/<?php echo $ranking['image'];?>" class="rounded-circle float-left" height="25px" width="25px" alt="avatar">
              <h6 class="card-title text-left"><strong>Level <?php echo ucwords($ranking['level']);?></strong> <a href="<?php echo base_url().'user-profile/'.$ranking['id']; ?>"><?php echo ucwords($ranking['first_name']);?> <?php echo ucwords($ranking['last_name']);?></a></h6>
            <?php } ?>
            <a href="<?php base_url(); ?>rankings" class="btn btn-primary btn-md waves-effect waves-light">View All</a>
          </div>
        </div><!--/.Card-->
      </div><!--Grid column-->
      <div class="col-lg-6">
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
                <?php if ($post['user_ID'] == $my_info['id']) {?>
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
                $all_images[] = './assets/img/posts/'.hash('md5', $post['user_ID']).'/'.$image['image'];
              }?>
              <?php if($total == 1){ ?>
                <div class="mt-2">
                  <span class="view_post" data-post-id="<?php echo $image['post_ID'];?>" data-user-id="<?php echo $post['user_ID'];?>"> 
                    <a class="imgs-grid-image" data-id="0"><img src="<?php echo base_url().'./assets/img/posts/'.hash('md5', $post['user_ID']).'/'.$image['image'];?>" class="img-fluid img-thumbnail" style="width: 300px;"></a>
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
                <img class="rounded-circle card-img-100 d-flex mx-auto mb-3 ml-2 chat-mes-id" src="./assets/img/users/<?php echo $comment['image']; ?>" alt="Profile Photo">
                <div class="media-body text-left ml-2">
                  <div class="bg-light rounded p-2">
                  <h6 class="font-weight-bold m-0">
                    <a class="text-dark profile_popover" href="./user-profile/<?php echo $comment['user_ID']; ?>" data-user-id="<?php echo $post['user_ID'];?>"><?php echo ucwords($comment['first_name']); ?> <?php echo ucwords($comment['last_name']); ?></a>
                    <?php if($comment['user_ID'] == $my_info['id']){ ?>
                    <a class="float-right red-text m-1"><i class="fas fa-times delete_comment fa-xs" data-comment-id="<?php echo $comment['comment_ID']; ?>" data-post-id="<?php echo $comment['post_ID'];?>"></i></a>
                    <?php } ?>
                  </h6>
                  <?php echo $comment['comment']; ?>
                  <?php if(!empty($comment['comment_image'])) { ?>
                    <div class="mt-2 h-50">
                      <div class="d-flex">
                        <a rel="gallery_<?php echo $comment['comment_ID']; ?>" href="./assets/img/posts/<?php echo hash('md5', $comment['user_ID']); ?>/<?php echo $comment['comment_image']; ?>" class="swipebox"><img src="./assets/img/posts/<?php echo hash('md5', $comment['user_ID']); ?>/<?php echo $comment['comment_image']; ?>" class="img-fluid img-thumbnail" style="width: 200px;"></a>
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
          <a class="blue-text load_more">View More</a>
        </div>
      </div><!--column-->
    </div><!--Grid row-->
  </section><!--Section-->
</div><!--Container-->
</main><!--Main layout-->
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
          <button type="submit" class="btn btn-primary btn-sm float-right submit_comment full_post_submit_comment" data-post-id="0" data-user-id="0" data-textarea-id="1" data-comment-id="0" data-post="1">comment</button>
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
<?php if(date('j', strtotime($daily_logins['timestamp'])) < date('j')){ ?>
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
      <div class="modal-body">
        <p>Do the mindset for 30 consecutive days and get free 1 on 1 mastermind call!</p>
        <h6 class="red-text mb-4">NOTE: The Login treak will be reset if login not consecutive</h6>
        <h4 class="modal-title w-100">Your current login streak <i class="fas fa-fire amber-text"></i> : <?php echo $daily_logins['days']; ?></h4>
        <div class="row justify-content-center">
          <a id="accept_reward" data-days="<?php echo $daily_logins['days']; ?>">
            <div class="card hoverable">
              <div class="card-body">
                <div class="d-flex">
                <p>60 exp</p>
                <p class="ml-4">Accept</p>
                </div>
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
  $("#accept_reward").one('click', function (event) {  
    event.preventDefault();
    var days = $(this).data('days');
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>users/accept_reward",
      dataType : "JSON",
      data:{days:days},
      success: function(data){
        toastr.success('Gain 30 exp!');
        $('#daily_login').modal('hide');
      }
    });
    $(this).prop('disabled', true);
  });
});
</script>
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
        // uploadImage(input.files[i], 0);
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
  create_ckeditor('posts');
  create_ckeditor('edit_post_value');
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
            html +=  '<div class="carousel-item active"><img src="./assets/img/posts/'+data[i].user_ID+'/'+data[i].image+'" alt="image" class="img-fluid" <?php if(isMobile() == 0){ echo 'style="height: 750px; overflow: auto;"'; } ?>></div>';
          } else {
            html +=  '<div class="carousel-item"><img src="./assets/img/posts/'+data[i].user_ID+'/'+data[i].image+'" alt="image" class="img-fluid" <?php if(isMobile() == 0){ echo 'style="height: 750px; overflow: auto;"'; } ?>></div>';
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
      forcePasteAsPlainText : true, 
      plugins: 'mentions,emoji,basicstyles,undo,link,wysiwygarea,toolbar, pastetext',
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
          outputTemplate: '<a href="./user-profile/{id}">@{fullname}</a><span>&nbsp;</span>',
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
          html += '<a class="mb-2" href="./user-profile/'+data[i].user_ID+'"><img class="mb-2 rounded-circle mr-2 card-img-100 chat-mes-id" src="<?php echo base_url();?>assets/img/users/'+data[i].image+'" style="height: 30px; width: 30px" alt="Profile photo">'+data[i].first_name+'</a><br>';
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
    var post = $(this).data('post');
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
            fetch_comments(post_ID, post);
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
    var comments = '<div class="form-group m-2 mb-0 textarea_comments"><label for="quickReplyFormComment">Your comment</label><input type="file" style="display:none;" name="post_image" id="post_image_'+textarea+'" onchange="readURL(this, '+textarea+');"><input type="hidden" name="image_'+textarea+'" id="image_'+textarea+'"><button type="button" class="btn btn-link uploadTrigger m-0 ml-4 px-2 py-2" id="uploadTrigger_'+textarea+'" data-textarea-id="'+textarea+'"><i class="fas fa-photo-video mr-2 green-text"></i>Photo</button><div id="textarea_comments_'+textarea+'"></div><div id="body_bottom_'+textarea+'" class="image_textarea"><img class="ml-2 mt-2" id="preview_'+textarea+'"/></div><div class="text-center"><button class="btn btn-primary btn-sm submit_comment" type="submit" data-post-id="'+post_ID+'" data-user-id="'+user_ID+'" data-textarea-id="'+textarea+'" data-comment-id="0" data-post="0">Comment</button></div></div><div id="comments_posts_'+post_ID+'"></div>';
    fetch_comments(post_ID, 0);
    $('#comment_section_'+post_ID).html(comments);
    createNewEditor(post_ID, textarea);
    textarea++;
  }

  function get_replies(post_ID, comment_ID, user_ID, post) {
    var reply = '<div class="form-group mt-2"><label for="quickReplyFormComment">Your reply</label><input type="file" style="display:none;" name="post_image" id="post_image_'+textarea+'" onchange="readURL(this, '+textarea+');"><input type="hidden" name="image_'+textarea+'" id="image_'+textarea+'"><button type="button" class="btn btn-link uploadTrigger ml-4 m-0 px-2 py-2" id="uploadTrigger_'+textarea+'" data-textarea-id="'+textarea+'"><i class="fas fa-photo-video mr-2 green-text"></i>Photo</button><div id="textarea_comments_'+textarea+'"></div><div id="body_bottom_'+textarea+'" class="image_textarea"><img class="ml-2 mt-2" id="preview_'+textarea+'"/></div><div class="text-center"><button class="btn btn-primary btn-sm submit_comment" type="submit" data-post-id="'+post_ID+'" data-comment-id="'+comment_ID+'" data-user-id="'+user_ID+'" data-textarea-id="'+textarea+'" data-post="0">Add Reply</button></div></div><div class="post_reply_'+comment_ID+'"></div>';
    fetch_comments_reply(post_ID, comment_ID); 
    if(post == 1){
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
      data:{post_ID:post_ID, post:post},
      success : function(data){
        if(post == 1){
          $('.full_post_comments'+post_ID).html(data);
        } else {
          $('#comments_posts_'+post_ID).html(data);
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
          html = '<div class="d-flex flex-row mb-2"><img src="./assets/img/users/'+data.image+'" class="rounded-circle mr-2 chat-mes-id-2" alt="avatar" style="height: 50px;width: 50px;"><div><h6><strong>'+data.full_name+'</strong></h6><i>Level '+data.level+'</i></div></div><div class="d-flex"><h6><strong>'+data.count_posts+'</strong> Posts</h6><h6 class="ml-2"><strong>'+data.count_following+'</strong> Following</h6><h6 class="ml-2"><strong>'+data.count_followers+'</strong> Followers</h6></a></div>';
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