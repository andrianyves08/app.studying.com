<main class="pt-5 mx-lg-5">
  <div class="container-fluid mt-5">
    <div class="card mb-4 wow fadeIn">
      <div class="card-body d-sm-flex justify-content-between">
        <h4 class="mb-2 mb-sm-0 pt-1">
          <span><a href="<?php echo base_url();?>admin">Home</a></span>
          <span>/</span>
          <span>Reviews</span>
        </h4>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <table class="table table-bordered display table-responsive-md" cellspacing="0" width="100%">
              <thead>
              <th>Full Name</th>
              <th>Description</th>
              <th>Rating</th>
              <th>Date Created</th>
              <th></th>
              </thead>
              <tbody>
                <?php foreach($reviews as $reviews){ ?> 
                <tr>
                  <td><?php echo ucwords($reviews['reviewers_name']);?></td>
                  <td><?php echo $reviews['description'];?></td>
                  <td><?php echo $reviews['rating'];?></td>
                  <td><?php echo date("F d, Y h:i A", strtotime($reviews['timestamp']));?></td>
                  <td>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <a class="btn btn-sm btn-primary" href='<?php echo base_url('admin/reviews'); ?>/<?php echo $reviews['id'];?>'>Edit</a>
                        <a class="btn btn-sm btn-danger delete_review" id="<?php echo $reviews['id'];?>">Delete</a>
                      </div>
                    </div>
                  </td>
                </tr>
                <?php }?>
              </tbody>
            </table>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#create_review">Create Reviews</button>
          </div>
        </div>
      </div>
    </div>
  </div><!--Container-->
</main><!--Main laypassed out-->

<!-- Are you sure -->
<div class="modal fade" id="create_review" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-lg modal-info" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="heading lead">Create Review</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <?php echo form_open_multipart('reviews/create'); ?>
        <div class="form-group">
          <label for="formGroupExampleInput">* Title</label>
          <input type="text" class="form-control" name="title" required>
        </div>
        <div class="form-group">
          <label for="formGroupExampleInput">* Full Name</label>
          <input type="text" class="form-control" name="name" required>
        </div>
         <div class="form-group">
          <label for="formGroupExampleInput">Testimonial</label>
          <input type="text" class="form-control" name="testimonial">
        </div>
        <div class="form-row mb-4">
          <div class="col">
             <label for="formGroupExampleInput">Niche</label>
              <input type="text" class="form-control" name="niche">
          </div>
          <div class="col">
            <label for="formGroupExampleInput">* Location</label>
            <input type="text" class="form-control" name="location" required>
          </div>
        </div>
        <div class="form-group">
          <label for="date">* Date</label>
            <input class="form-control" type="date" value="<?php echo date("Y-m-d");?>" id="date" name="date" required>
        </div>
        <div class="form-row mb-4">
          <div class="col">
            <label for="formGroupExampleInput">* Video URL</label>
            <input type="text" required name="url" class="form-control">
          </div>
          <div class="col">
            <label for="formGroupExampleInput">* Rating</label>
          <input type="number" required name="rating" class="form-control" min="0" max="5">
          </div>
        </div>
          <label for="formGroupExampleInput">* Description</label>
         <textarea class="textarea mb-4" name="description" id="description" placeholder="Place some text here" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-outline-danger waves-effect" data-dismiss="modal">Cancel</button>
        <button class="btn btn-outline-primary waves-effect" type="submit">Create Rating</button>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>
<!-- Section Delete -->
<div data-backdrop="static" class="modal fade" id="sectiondelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-sm modal-notify modal-danger" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">Delete Review</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this Review?</p>
        <input type="hidden" class="form-control" name="del_review" id="del_review" >
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-sm delete">Confirm</button>
      </div>
    </div>
  </div>
</div>
<!-- Section Delete -->
<script type="text/javascript">
$(document).ready(function(){
  $(".delete").click(function(){
    var review_id = $('#del_review').val();
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>reviews/delete_review",
      dataType : "JSON",
      data : {id:review_id},
      success: function(data){
        toastr.error('Review Deleted');
        location.reload();
      }
    });
    return false;
  });

  //Get Section to delete
  $(document).on("click", ".delete_review", function() { 
    var id=$(this).attr('id');
    $('#sectiondelete').modal('show');
    $('[name="del_review"]').val(id);
  });
});
</script>
<script>
$(document).ready(function(){
  $('.textarea').summernote({
    height: "300px",
    callbacks: {
      onImageUpload: function(image) {
      uploadImage(image[0]);
      }
    },
    toolbar: [
      ['insert', ['link', 'picture']],
    ],
  });

  function uploadImage(image) {
    var data = new FormData();
    data.append("image", image);
    $.ajax({
      url: "<?php echo site_url('reviews/upload_image')?>",
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
});
</script>