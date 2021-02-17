<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <div class="card mb-4 wow fadeIn">
    <div class="card-body d-sm-flex justify-content-between">
      <h4 class="mb-2 mb-sm-0 pt-1">
        <span><a href="<?php echo base_url();?>admin">Home</a></span>
        <span>/</span>
        <span><a href="<?php echo base_url(); ?>resources">Resources</a></span>
        <span>/</span>
        <span>Create</span>
      </h4>
    </div>
  </div>
  <!-- Heading -->

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <?php echo form_open_multipart('resources/create_content'); ?>
          <div class="form-group">
            <label for="formGroupExampleInput">* Title</label>
            <input type="text" class="form-control" name="title" id="title" required>
          </div>
          <div class="form-group">
            <label for="formGroupExampleInput">* Short Description</label>
            <input type="text" class="form-control" name="description" id="description" required>
          </div>
          <div class="form-row mb-4">
            <div class="col">
              <label for="formGroupExampleInput">* Type</label>
              <select class="browser-default custom-select" id="type" name="type" required>
                <option value="1">Blog</option>
                <option value="2">Article</option>
              </select>
            </div>
            <div class="col">
              <label for="image">Banner</label>
              <div class="input-group">
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="banner" name="banner" aria-describedby="inputGroupFileAddon01">
                  <label class="custom-file-label text-left" for="banner"></label>
                </div>
              </div>
            </div>
          </div>
          <div class="input-group mb-4">
            <select class="browser-default custom-select select2" name="select_category[]" id="select_category" multiple="multiple" data-placeholder="Select a Category" required>
            </select>
            <div class="input-group-append">
              <a class="btn btn-md btn-outline-primary m-0 px-3 py-2 z-depth-0 waves-effect" type="button" data-toggle="modal" data-target="#create_category">Create New Category</a>
            </div>
          </div>
          <div class="input-group mb-4">
            <select class="browser-default custom-select select2" name="select_keyword[]" id="select_keyword" multiple="multiple" data-placeholder="Select a Keyword" required>
            </select>
            <div class="input-group-append">
              <a class="btn btn-md btn-outline-success m-0 px-3 py-2 z-depth-0 waves-effect" type="button" data-toggle="modal" data-target="#create_keyword">Create New Keyword</a>
            </div>
          </div>
          <label for="image">Upload Files</label>
          <h6 class="red-text">NOTE: You can select multiple files except folders</h6>
          <div class="input-group mb-4">
            <div class="custom-file">
              <input type="file" class="custom-file-input" name="resource_file[]" aria-describedby="inputGroupFileAddon01" multiple>
              <label class="custom-file-label text-left" for="resource_file"></label>
            </div>
          </div>
          <textarea class="textarea mb-4" name="content" id="content" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" required></textarea>
          <button class="btn btn-primary waves-effect " type="submit">Save Changes</button>
          <?php echo form_close(); ?>
        </div><!--Card Body-->
      </div><!--Card-->
    </div><!--Column-->
  </div><!--Row-->
</div><!--Container-->
</main>
<!-- Add Members -->
<div data-backdrop="static" class="modal fade" id="create_category" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-md modal-notify modal-success" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">Create New Category</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
        <label for="formGroupExampleInput">* Name</label>
        <input type="text" class="form-control" name="new_category" id="new_category">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button class="btn btn-primary waves-effect btn-sm float-right" type="submit" id="add_category">Create</button>
      </div>
    </div>
  </div>
</div>
<!-- Add Members -->

<!-- Add Members -->
<div data-backdrop="static" class="modal fade" id="create_keyword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-md modal-notify modal-success" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">Create New Keyword</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
        <label for="formGroupExampleInput">* Name</label>
        <input type="text" class="form-control" name="new_keyword" id="new_keyword">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button class="btn btn-primary waves-effect btn-sm float-right" type="submit" id="add_keyword">Create</button>
      </div>
    </div>
  </div>
</div>
<!-- Add Members -->
<script>
$(document).ready(function(){
  get_category();
  get_keyword();
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

  function get_category(){
    $.ajax({
      type  : 'POST',
      url   : "<?=base_url()?>resources/get_category",
      async : true,
      dataType : 'json',
      success : function(data){
        var html = '';
        var i;
        for(i=0; i<data.length; i++){
          html += '<option value='+data[i].id+'>'+data[i].name+'</option>';
        }
        $('#select_category').html(html);
      }
    });
  }

  function get_keyword(){
    $.ajax({
      type  : 'POST',
      url   : "<?=base_url()?>resources/get_keyword",
      async : true,
      dataType : 'json',
      success : function(data){
        var html = '';
        var i;
        for(i=0; i<data.length; i++){
          html += '<option value='+data[i].id+'>'+data[i].name+'</option>';
        }
        $('#select_keyword').html(html);
      }
    });
  }

  //Add member
  $('#add_category').on('click',function(){
    var category = $('#new_category').val();
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>resources/create_category",
      dataType : "JSON",
      data : {name:category},
      success: function(data){
        if(data.error){
          toastr.error(data.message);
        } else {
          toastr.success('Category created');
          $('#create_category').modal('hide');
        }
        get_category();
      }
    });
    return false;
  });

  $('#add_keyword').on('click',function(){
    var keyword = $('#new_keyword').val();
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>resources/create_keyword",
      dataType : "JSON",
      data : {name:keyword},
      success: function(data){
        if(data.error){
          toastr.error(data.message);
        } else {
          toastr.success('keyword created');
          $('#create_keyword').modal('hide');
        }
        get_keyword();
      }
    });
    return false;
  });
});
</script>