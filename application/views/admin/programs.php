<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <div class="card mb-4 wow fadeIn">
    <div class="card-body d-sm-flex justify-content-between">
      <h4 class="mb-2 mb-sm-0 pt-1">
        <span><a href="<?php echo base_url();?>admin">Home</a></span>
        <span>/</span>
        <span>Programs</span>
      </h4>
    </div>
  </div>
  <!-- Heading -->
  <div class="row">
    <div class="col-md-12 mb-4">
      <div class="accordion md-accordion accordion-blocks" id="accordionEx78" role="tablist"
        aria-multiselectable="true">
        <?php foreach ($programs as $program) {?>
          <div class="card">
            <div class="card-header" role="tab" id="mainsection<?php echo $program['id'];?>">
              <div class="float-right">
                <a class="green-text"><i class="fas fa-dollar-sign"></i><?php echo $program['price'];?></a>
                <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                  <a type="button" class="btn btn-primary btn-sm edit_program" id="<?php echo $program['id'];?>"><i class="fas fa-pencil-alt"></i></a>
                </div>
              </div>
              <a data-toggle="collapse" data-parent="#accordionEx78" href="#section<?php echo $program['id'];?>" aria-expanded="true"
                aria-controls="section<?php echo $program['id'];?>">
                <h5 class="mt-1 mb-0">
                  <span><?php echo ucwords($program['name']);?></span>
                  <i class="fas fa-angle-down rotate-icon"></i>
                </h5>
              </a>
            </div><!--Card Header-->
            <div id="section<?php echo $program['id'];?>" class="collapse" role="tabpanel" aria-labelledby="mainsection<?php echo $program['id'];?>"
              data-parent="#accordionEx78">
              <div class="card-body sortablelessons">
                <div class="sortablecontent" style="padding-left: 25px;">
                  <?php foreach ($modules as $module) {?>
                    <?php if ($program['id'] == $module['program_ID']) {?>
                      <div class="row">
                        <ul class="list-group align-middle" role="tablist" style="padding-left: 25px;">
                          <li style="padding: 0;margin: 0;" class="border-bottom" ><h6><?php echo ucwords($module['title']);?></h6> </li>
                        </ul>
                        <div class="col-3 float-right">
                          <a class="delete_module" id="<?php echo $module['programs_modules_id'];?>"><i class="fas fa-trash-alt red-text"></i></a>
                        </div>
                      </div>
                    <?php } ?>
                  <?php } ?>
                </div>
                <div class="row pt-3">
                  <div class="col-md-8">
                    <div class="input-group mb-3">
                      <div class="input-group-append">
                        <button class="btn btn-md btn-success m-0 px-3 py-2 z-depth-0 waves-effect add_modle" id="<?php echo $program['id'];?>">Add</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div><!-- Card Body-->
            </div><!-- 2nd Accordion-->
          </div><!--Accordion card-->
        <?php } ?>
      </div><!-- Accordion-->
    </div><!--Column-->
  </div><!--Row-->

  <div class="row">
    <div class="col-md-6">
      <div class="card mb-4">
        <div class="card-body">
           <?php echo form_open_multipart('programs/create_program/'); ?>
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Program" aria-label="Section"
              aria-describedby="button-addon2" name="name" id="name">
            <div class="input-group-append">
              <button class="btn btn-md btn-success m-0 px-3 py-2 z-depth-0 waves-effect" id="submit_section">Create New Program</button>
            </div>
          </div>
        <?php echo form_close(); ?>
        </div><!--Card-body-->
        </div><!--Card-->
      </div>
    </div>
  </div>
</div><!--Container-->
</main><!--Main laypassed out-->
<!-- Program Edit -->
<div data-backdrop="static" class="modal fade" id="program_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-sm modal-notify modal-info" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">Edit Program</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div> 
      <div class="modal-body">
        <div class="form-group">
          <label for="formGroupExampleInput">* Program Name</label>
          <input type="hidden" class="form-control" name="program_ID" id="program_ID">
          <input type="text" class="form-control" name="program_name" id="program_name" >
        </div>
        <div class="form-group">
          <label for="formGroupExampleInput">* Program Price</label>
          <input type="text" class="form-control" name="program_price" id="program_price" >
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-sm" id="update_program">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- Program Edit -->

<!-- Add Modules -->
<div data-backdrop="static" class="modal fade" id="moduleadd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-success modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="heading lead">Add Modules</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>
      <?php echo form_open_multipart('programs/add_modules'); ?>
      <div class="modal-body">
        <input type="hidden" class="form-control" name="prog_ID" id="prog_ID">
        <select name="modules[]" id="modules" class="select2" multiple="multiple" data-placeholder="Select a Module" style="width: 100%;"></select>
      </div>
      <div class="modal-footer justify-content-center">
        <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancel</a>
        <button class="btn btn-success waves-effect float-right" type="submit">Add</button>
      </div>
      <?php echo form_close(); ?>
    </div><!--/.Content-->
  </div>
</div>
<!-- Add Modules -->

<!-- Module Delete -->
<div data-backdrop="static" class="modal fade" id="module_delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-sm modal-notify modal-danger" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">Delete Module</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this module?</p>
        <input type="hidden" class="form-control" name="module_ID" id="module_ID">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-target="#module_delete" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-sm" id="confirm_delete_module">Confirm</button>
      </div>
    </div>
  </div>
</div>
<!-- Module Delete -->
<script type="text/javascript">
$(document).ready(function(){
  //Get program to update
  $(document).on('click','.add_modle',function(e) {
    var id=$(this).attr('id');
    $('#moduleadd').modal('show');
    $('[name="prog_ID"]').val(id);
    $.ajax({
      type  : 'POST',
      url   : "<?=base_url()?>programs/get_modules",
      async : true,
      dataType : 'json',
      data : {id:id},
      success : function(data){
        var html = '';
        var i;
        for(i=0; i<data.length; i++){
          html += '<option value='+data[i].course_ID+'>'+data[i].title+'</option>';
        }
        $('#modules').html(html);
      }
    });
  });

  //Get program to update
  $(document).on('click','.edit_program',function(e) {
    var id=$(this).attr('id');
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>programs/get_program",
      dataType : "JSON",
      data : {id:id},
      success: function(data){
        $('#program_edit').modal('show');
        $('[name="program_name"]').val(data.name);
        $('[name="program_price"]').val(data.price);
        $('[name="program_ID"]').val(data.id);
      }
    });
    return false;
  });

  //Update program
  $('#update_program').on('click',function(){
    var name=$('#program_name').val();
    var id=$('#program_ID').val();
    var price=$('#program_price').val();
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>programs/update_program",
      dataType : "JSON",
      data : {program_ID:id, program_name:name, program_price:price},
      success: function(data){
        if(data.error){
          toastr.error(data.message);
        } else {
          toastr.success('Section name updated.');
          $('[name="program_name"]').val("");
          $('[name="program_ID"]').val("");
          $('[name="program_price"]').val("");
          $('#program_edit').modal('hide');
          location.reload();
        }
      }
    });
    return false;
  });

  //Get Module to delete
  $(document).on("click", ".delete_module", function() { 
    var id=$(this).attr('id');
    $('#module_delete').modal('show');
    $('[name="module_ID"]').val(id);
  });

  $("#confirm_delete_module").click(function(){
    var module_ID = $('#module_ID').val();
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>programs/delete_module/",
      dataType : "JSON",
      data : {id:module_ID},
      success: function(data){
        toastr.error('Modle Deleted');
        location.reload();
      }
    });
    return false;
  });
});
</script>