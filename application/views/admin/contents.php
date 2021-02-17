<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <div class="card mb-4 wow fadeIn">
    <div class="card-body d-sm-flex justify-content-between">
      <h4 class="mb-2 mb-sm-0 pt-1">
        <a href="<?php echo base_url();?>admin">Home</a>
        <span>/</span>
        <a href="<?php echo base_url();?>admin/modules"><span>Modules</span></a>
      </h4>
    </div>
  </div><!-- Heading -->

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <table class="table table-bordered display table-responsive table-sm" cellspacing="0" width="100%">
            <thead>
              <th>Content ID</th>
              <th>Module</th>
              <th>Section</th>
              <th>Lesson</th>
              <th>Content Title</th>
              <th>URL</th>
              <th>Thumbnail</th>
              <th></th>
            </thead>
            <tbody>
              <?php foreach($contents as $content){ ?> 
              <tr>
                <td><?php echo $content['content_ID'];?></td>
                <td><?php echo ucwords($content['course_name']);?></td>
                <td><?php echo ucwords($content['section_name']);?></td>
                <td><?php echo ucwords($content['lesson_name']);?></td>
                <td><?php echo ucwords($content['content_part_name']);?></td>
                <td><?php echo $content['content_part_url'];?></td>
                <td>
                  <?php if (!empty($content['content_part_thumbnail'])) {?> 
                    <img src="<?php echo base_url().'assets/img/contents/'.$content['content_part_thumbnail'];?>" alt="thumbnail" class="img-thumbnail" style="width: 200px">
                  <?php } else { ?>
                    None
                  <?php } ?>
                </td>
                <td><a class="btn btn-sm btn-primary edit_content" id="<?php echo $content['content_ID'];?>"> Edit</a></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div><!--Card Body-->
      </div><!--Card-->
    </div><!--Column-->
  </div><!--Row-->
</div><!--Container-->
</main><!--Main laypassed out-->
<!-- Are you sure -->
<div class="modal fade" id="content" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <?php echo form_open_multipart('courses/update_content_by_id'); ?>
        <div class="form-group">
          <label>* Content Title</label>
          <input type="hidden" class="form-control" name="update_con_id" id="update_con_id">
          <input type="text" class="form-control mb-4" name="update_con_name" id="update_con_name">
          <div class="form-group"><label for="contentitle">URL <h6 class="red-text">NOTE: Vimeo URL should start with https://vimeo... or //player...</h6></label><input type="text" class="form-control" name="update_con_url" id="update_con_url"></div>
          <input type="hidden" class="form-control" name="update_con_thumbnail_orig" id="update_con_thumbnail_orig">
          <label for="image">Thumbnail</label>
          <div class="input-group mb-4">
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="update_con_thumbnail" name="update_con_thumbnail" aria-describedby="inputGroupFileAddon01">
              <label class="custom-file-label text-left" for="update_con_thumbnail" id="update_con_thumbnail_label"></label>
            </div>
          </div>
           <label>Content</label>
          <textarea class="textarea" name="update_cont_part" id="update_cont_part" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" data-summernote-id="4"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-sm" type="submit">Save changes</button>
      </div>
      <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>
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
      ['style', ['style']],
      ['font', ['bold', 'underline', 'clear', 'fontsize']],
      ['fontname', ['fontname']],
      ['color', ['color']],
      ['para', ['ul', 'ol', 'paragraph']],
      ['table', ['table']],
      ['insert', ['link', 'picture']],
      ['view', ['fullscreen', 'codeview', 'help']],
    ],
  });

  function uploadImage(image) {
    var data = new FormData();
    data.append("image", image);
    $.ajax({
      url: "<?php echo site_url('courses/upload_image')?>",
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
<script type="text/javascript">
$(document).ready(function(){
  //Get content to update
  $(document).on('click','.edit_content',function(e) {
    var id=$(this).attr('id');
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>courses/get_content_by_id/"+id,
      dataType : "JSON",
      data : {id:id},
      success: function(data){
        $('#content').modal('show');
        $('[name="update_con_name"]').val(data.name);
        $('[name="update_con_url"]').val(data.url);
        $('[name="update_con_thumbnail_orig"]').val(data.thumbnail);
        $('[id="update_con_thumbnail_label"]').text(data.thumbnail);
        $('#update_cont_part').summernote('code', data.content);
        $('[name="update_con_id"]').val(data.id);
      }
    });
    return false;
  });   
});
</script>