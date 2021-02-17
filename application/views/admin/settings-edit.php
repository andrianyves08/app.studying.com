<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <div class="card mb-4 wow fadeIn">
    <div class="card-body d-sm-flex justify-content-between">
      <h4 class="mb-2 mb-sm-0 pt-1">
        <span><a href="<?php echo base_url();?>admin">Home</a></span>
        <span>/</span>
        <span><a href="<?php echo base_url();?>admin/settings">Settings</a></span>
        <span>/</span>
        <span>Pages</span>
      </h4>
    </div>
  </div>
  <!-- Heading -->

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <?php echo form_open_multipart('settings/update_page/'.$pages['id']); ?>
          <h2><?php echo ucwords($pages['name']);?></h2>
          <input type="hidden"  id="image" name="image" value="<?php echo $pages['background_image'];?>">
          <label for="image">Hero Image</label>
          <div class="input-group mb-4">
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="background_image" name="background_image" aria-describedby="inputGroupFileAddon01">
              <label class="custom-file-label text-left" for="logo"><?php echo $pages['background_image'];?></label>
            </div>
          </div>
          <textarea class="textarea mb-4 pb-4" name="content" id="content" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $pages['content'];?></textarea>
          <button class="btn btn-outline-primary waves-effect " type="submit">Save Changes</button>
          <?php echo form_close(); ?>
        </div><!--Card Body-->
      </div><!--Card-->
    </div><!--Column-->
  </div><!--Row-->
</div><!--Container-->
</main><!--Main laypassed out-->
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
    ['font', ['bold', 'italic', 'underline', 'clear', 'fontsize']],
    ['fontname', ['fontname']],
    ['color', ['color']],
    ['para', ['ul', 'ol', 'paragraph']],
    ['height', ['height']],
    ['table', ['table']],
    ['insert', ['link', 'picture', 'hr']],
    ['view', ['fullscreen', 'codeview']],
    ['help', ['help']]
    
      // ['style', ['style']],
      // ['font', ['bold', 'underline', 'clear', 'fontsize']],
      // ['fontname', ['fontname']],
      // ['color', ['color']],
      // ['para', ['ul', 'ol', 'paragraph']],
      // ['table', ['table']],
      // ['insert', ['link', 'picture', 'video']],
      // ['view', ['fullscreen', 'codeview', 'help']],
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