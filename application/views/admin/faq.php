<main class="pt-5 mx-lg-5">
  <div class="container-fluid mt-5">
    <div class="card mb-4 wow fadeIn">
      <div class="card-body d-sm-flex justify-content-between">
        <h4 class="mb-2 mb-sm-0 pt-1">
          <span><a href="<?php echo base_url();?>admin">Home</a></span>
          <span>/</span>
          <span>Users</span>
        </h4>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <table class="table table-bordered display table-responsive-md" cellspacing="0" width="100%">
              <thead>
              <th>Application</th>
              <th>Question</th>
              <th>Answer</th>
              <th>timestamp</th>
              <th></th>
              </thead>
              <tbody>
                <?php foreach($faqs as $faq){ ?> 
                  <tr>
                    <td>
                      <?php if ($faq['type'] == '1') { ?>
                        Portal
                      <?php } else { ?>
                        Studying
                      <?php } ?>
                    </td>
                    <td><?php echo ucfirst($faq['question']);?></td>
                    <td><?php echo $faq['answer'];?></td>
                    <td><?php echo date("F d, Y h:i A", strtotime($faq['timestamp']));?></td>
                    <td>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <a class="btn btn-sm btn-primary" href="<?php echo base_url('admin/frequently-asked-questions'); ?>/<?php echo $faq['id'];?>">Edit</a>
                          <a class="btn btn-sm btn-danger delete_faq" id="<?php echo $faq['id'];?>">Delete</a>
                        </div>
                      </div>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#create_question">Create Question</button>
          </div>
        </div>
      </div>
    </div>
  </div><!--Container-->
</main><!--Main laypassed out-->
<!-- Are you sure -->
<div class="modal fade" id="create_question" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
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
        <?php echo form_open_multipart('faq/create'); ?>
        <div class="form-group">
          <label for="formGroupExampleInput">* Application</label>
          <select class="browser-default custom-select" id="type" name="type" required>
            <option value="1">Portal</option>
            <option value="2">Studying</option>
          </select>
        </div>
        <div class="form-group">
          <label for="formGroupExampleInput">* Question</label>
          <input type="text" class="form-control" name="question" id="question" required>
        </div>
        <div class="input-group mb-4">
          <select class="browser-default custom-select" id="select_category" name="category" required>
          </select>
          <div class="input-group-append">
            <a class="btn btn-md btn-outline-primary m-0 px-3 py-2 z-depth-0 waves-effect" type="button" data-toggle="modal" data-target="#create_category">Create New Category</a>
          </div>
        </div>

        <label for="formGroupExampleInput">* Answer</label>
        <textarea class="textarea mb-4" name="answer" id="answer" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" required></textarea>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-outline-danger waves-effect" data-dismiss="modal">Cancel</button>
        <button class="btn btn-outline-primary waves-effect" type="submit">Create</button>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>
<!-- Are you sure -->
<!-- Section Delete -->
<div data-backdrop="static" class="modal fade" id="faqdelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-sm modal-notify modal-danger" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">Delete Question</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this Question?</p>
        <input type="hidden" class="form-control" name="faq_ID" id="faq_ID" >
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-sm delete">Confirm</button>
      </div>
    </div>
  </div>
</div>
<!-- Section Delete -->
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
<script>
$(document).ready(function(){
  get_category();
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

  $(document).on("click", ".delete_faq", function() { 
    var id=$(this).attr('id');
    $('#faqdelete').modal('show');
    $('[name="faq_ID"]').val(id);
  });

  $(".delete").click(function(){
    var faq_ID = $('#faq_ID').val();
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>faq/delete",
      dataType : "JSON",
      data : {id:faq_ID},
      success: function(data){
        toastr.error('Question Deleted');
        location.reload();
      }
    });
    return false;
  });

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
});
</script>