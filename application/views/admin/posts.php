<main class="pt-5 mx-lg-5">
  <div class="container-fluid mt-5">
    <div class="card mb-4 wow fadeIn">
      <div class="card-body d-sm-flex justify-content-between">
        <h4 class="mb-2 mb-sm-0 pt-1">
          <span><a href="<?php echo base_url();?>admin">Home</a></span>
          <span>/</span>
          <span>Post Review</span>
        </h4>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <table class="table table-bordered display table-responsive-md" cellspacing="0" width="100%">
              <thead>
              <th>Posts</th>
              <th>Posted By</th>
              <th>Status</th>
              <th>Date Created</th>
              <th></th>
              </thead>user_ID
              <tbody>
                <?php foreach($posts as $post){ ?> 
                <tr>
                  <td><?php echo ucwords($post['posts']);?><br>
                      <?php if (!empty($post['post_image'])) {?>
                        <img src="<?php echo base_url().'assets/img/posts/'.hash('md5', $post['user_ID']).'/'.$post['post_image'];?>" style="width: 200px"/>
                      <?php } ?>
                  </td>
                  <td><?php echo ucwords($post['first_name']);?> <?php echo ucwords($post['last_name']);?></td>
                  <td>
                    <?php if ($post['post_status'] == '1') { ?>
                      <span class="badge badge-pill badge-success">Approved</span>
                    <?php } elseif ($post['post_status'] == '0') { ?>
                      <span class="badge badge-pill badge-default">On Review</span>
                    <?php } else { ?>
                      <span class="badge badge-pill badge-danger">Denied</span>
                    <?php } ?>
                  </td>
                  <td><?php echo date("F d, Y h:i A", strtotime($post['timestamp']));?></td>
                  <td>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <?php if ($post['post_status'] == '1') { ?>
                          <a class="btn btn-sm btn-danger deny_post" data-post-id="<?php echo $post['post_ID'];?>" data-user-id="<?php echo $post['user_ID'];?>">Deny Post</a>
                        <?php } elseif ($post['post_status'] == '0') { ?>
                          <a class="btn btn-sm btn-success approve_post" data-post-id="<?php echo $post['post_ID'];?>" data-user-id="<?php echo $post['user_ID'];?>">Approve Post</a>
                          <a class="btn btn-sm btn-danger deny_post" data-post-id="<?php echo $post['post_ID'];?>" data-user-id="<?php echo $post['user_ID'];?>">Deny Post</a>
                        <?php } else { ?>
                          <a class="btn btn-sm btn-success approve_post" data-post-id="<?php echo $post['post_ID'];?>" data-user-id="<?php echo $post['user_ID'];?>">Approve Post</a>
                         <?php } ?>
                      </div>
                    </div>
                  </td>
                </tr>
                <?php }?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div><!--Container-->
</main><!--Main laypassed out-->

<!-- Section Edit -->
<div data-backdrop="static" class="modal fade" id="approve_post" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-md modal-notify" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <p>Are you sure you want to approve this post?</p>
          <input type="hidden" class="form-control" name="approve_post_id">
          <input type="hidden" class="form-control" name="approve_user_id">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-md" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success btn-md" id="accept_post">Approve</button>
      </div>
    </div>
  </div>
</div>
<!-- Section Edit -->

<!-- Section Delete -->
<div data-backdrop="static" class="modal fade" id="deny_post" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-md modal-notify modal-danger" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to deny this post?</p>
        <input type="hidden" class="form-control" name="deny_post_id">
        <input type="hidden" class="form-control" name="deny_user_id">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-sm" id="not_accept_post">Confirm</button>
      </div>
    </div>
  </div>
</div>
<!-- Section Delete -->
<script type="text/javascript">
$(document).ready(function(){
  $("img").addClass("img-fluid");

  $('.textarea').summernote({
    height: "300px",
    callbacks: {
      onImageUpload: function(image) {
        uploadImage(image[0]);
      }
    },
    toolbar: [
      ['style', ['style']],
      ['font', ['bold', 'underline', 'clear', 'fontsize']],
      ['fontname', ['fontname']],
      ['color', ['color']],
      ['para', ['ul', 'ol', 'paragraph']],
      ['table', ['table']],
      ['insert', ['link', 'picture', 'video']],
      ['view', ['fullscreen', 'codeview', 'help']],
    ],
  });

  function uploadImage(image) {
    var data = new FormData();
    data.append("image", image);
    $.ajax({
      url: "<?php echo site_url('resources/upload_image')?>",
      cache: false,
      contentType: false,
      processData: false,
      data: data,
      type: "POST",
      success: function(url) {
        $('.textarea').summernote('insertImage', url);
      },
      error: function(data) {
        console.log(data);
      }
    });
  }

  //Get Section to approve
  $(document).on("click", ".approve_post", function() { 
    var post_ID=$(this).data('post-id');
    var user_ID=$(this).data('user-id');
    $('#approve_post').modal('show');
    $('[name="approve_post_id"]').val(post_ID);
    $('[name="approve_user_id"]').val(user_ID);
  });

  $("#accept_post").click(function(){
    var post_ID = $('[name="approve_post_id"]').val();
    var user_ID = $('[name="approve_user_id"]').val();
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>posts/approve_post",
      dataType : "JSON",
      data : {post_ID:post_ID, user_ID:user_ID},
      success: function(data){
        toastr.success('Post approved!');
        location.reload();
      }
    });
    return false;
  });

  //Get Section to delete
  $(document).on("click", ".deny_post", function() { 
    var post_ID=$(this).data('post-id');
    var user_ID=$(this).data('user-id');
    $('#deny_post').modal('show');
    $('[name="deny_post_id"]').val(post_ID);
    $('[name="deny_user_id"]').val(user_ID);
  });

  $("#not_accept_post").click(function(){
    var post_ID = $('[name="deny_post_id"]').val();
    var user_ID = $('[name="deny_user_id"]').val();
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>posts/not_accept_post",
      dataType : "JSON",
      data : {post_ID:post_ID, user_ID:user_ID},
      success: function(data){
        toastr.success('Post denied!');
        location.reload();
      }
    });
    return false;
  });
});
</script>