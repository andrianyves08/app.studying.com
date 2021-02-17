<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <div class="card mb-4 wow fadeIn">
    <div class="card-body d-sm-flex justify-content-between">
      <h4 class="mb-2 mb-sm-0 pt-1">
        <a href="<?php echo base_url(); ?>">Home</a>
        <span>/</span>
        <a href="<?php echo base_url(); ?>resources"><span>FAQs</span></a>
      </h4>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <?php echo form_open_multipart('faq/update'); ?>
            <div class="form-group">
              <label for="formGroupExampleInput">Type</label>
              <select class="browser-default custom-select" id="type" name="type" required>
                <?php if($faqs['type'] == '1') { ?>
                  <option value="1" selected>Portal</option>
                  <option value="2">Studying</option>
                <?php } else { ?>
                  <option value="1">Portal</option>
                  <option value="2" selected>Studying</option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group mb-4">
              <label for="formGroupExampleInput">* Question</label>
              <input type="text" class="form-control" name="question" id="question" value="<?php echo ucwords($faqs['question']); ?>" required>
              <input type="hidden" class="form-control" name="faq_ID" id="faq_ID" value="<?php echo $faqs['id']; ?>">
            </div>
            <div class="input-group mb-4">
              <select class="browser-default custom-select" id="category_ID" name="category" required>
                <?php foreach($all_categories as $all_category){ ?> 
                <option value="<?php echo ucwords($all_category['id']); ?>" <?php if($faqs['category_ID'] == $all_category['id']){ echo 'selected'; } ?>><?php echo ucwords($all_category['name']); ?></option>
                <?php } ?>
              </select>
              <div class="input-group-append">
                <a class="btn btn-md btn-outline-mdb-color m-0 px-3 py-2 z-depth-0 waves-effect" type="button" data-toggle="modal" data-target="#create_category">Create New Category</a>
              </div>
            </div>
            <textarea class="textarea mb-4" name="answer" id="answer" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" required><?php echo $faqs['answer']; ?></textarea>
            <button class="btn btn-primary waves-effect mt-4" type="submit">Save Changes</button>
          <?php echo form_close(); ?>
        </div><!--Card Body-->
      </div><!--Card-->
    </div><!--Column-->
  </div><!--Row-->
</div><!--Container-->
</main>
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
});
</script>