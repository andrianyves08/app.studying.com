<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <div class="card mb-4 wow fadeIn">
    <div class="card-body d-sm-flex justify-content-between">
      <h4 class="mb-2 mb-sm-0 pt-1">
        <span><a href="<?php echo base_url();?>admin">Home</a></span>
        <span>/</span>
        <span>Modules</span>
      </h4>
      <h4 class="mb-2 mb-sm-0 pt-1">
      <a class="text-right" href="<?php echo base_url();?>admin/contents">Contents</a>
    </h4>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <table class="table table-bordered table-responsive-md" cellspacing="0" width="100%">
            <thead>
            <th>Title</th>
            <th>Status</th>
            <th>Created Date</th>
            <th>Created By</th>
            <th></th>
            </thead>
            <tbody id="sortablecourses">
            <?php foreach ($courses as $course) {?>
              <tr class="sortcourse" data-id="<?php echo $course['courID'];?>">
                <td style="cursor: all-scroll;"><?php echo ucwords($course['title']);?></td>
                <td class="text-center">
                <?php if($course['courstat'] == 0){?>
                <span class="badge badge-pill badge-danger">Inactive</span>
                <?php } else { ?>
                <span class="badge badge-pill badge-success">Active</span>
                <?php } ?>
                </td>
                <td><?php echo date("F d, Y h:i A", strtotime($course['last_updated']));?></td>
                <td><?php echo ucwords($course['first_name']);?> <?php echo ucwords($course['last_name']);?></td>
                <td>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <a class="btn btn-sm btn-success" href='<?php echo base_url(); ?>admin/modules/<?php echo $course['slug'];?>'>View</a>
                      <a class="btn btn-sm btn-primary" data-toggle='modal' data-target='#edit<?php echo $course['courID']; ?>' href='#edit?id=<?php echo $course['courID']; ?>'>Edit</a>
                    </div>
                  </div>
                </td>
              </tr>
              <div class="modal fade" id="edit<?php echo $course['courID']; ?>" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md" role="document">
                  <div class="modal-content">
                    <div class="modal-header text-center">
                      <h4 class="modal-title w-100 font-weight-bold"><?php echo ucwords($course['title']);?>
                      </h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;
                      </span>
                      </button>
                    </div>
                    <?php echo form_open_multipart('courses/update_course/'.$course['courID']); ?>
                    <div class="modal-body mx-3">
                      <div class="form-group">
                        <label for="formGroupExampleInput">* Title</label>
                        <input type="text" class="form-control" name="edittitle" value="<?php echo $course['title']; ?>">
                      </div>
                      <label for="editstatus">* Status</label><br>
                      <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input customSwitches swt<?php echo $course['courID']; ?>" id="<?php echo $course['courID']; ?>" <?php if($course['courstat'] == 1){ echo 'checked';}?> name="editstatus" value="<?php if($course['courstat'] == 1){ echo '1';} else { echo '0';}?>">
                        <label class="custom-control-label" for="<?php echo $course['courID']; ?>" id="testtex<?php echo $course['courID']; ?>"><?php if($course['courstat'] == 1){ echo 'Active';} else { echo 'Inactive';}?></label>
                      </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                      <button type="button" class="btn btn-outline-danger waves-effect" data-dismiss="modal">Cancel</button>
                      <button class="btn btn-outline-primary waves-effect">Update</button>
                    </div>
                    <?php echo form_close(); ?>
                  </div>
                </div>
              </div><!--Modal-->
            <?php } ?>
            </tbody>
          </table>
          <a type="button" class="btn btn-primary" data-toggle="modal" data-target="#createlesson">Create Module</a>
        </div><!--Card Body-->
      </div><!--Card-->
    </div><!--Column-->
  </div><!--Row-->
</div><!--Container-->
</main><!--Main laypassed out-->
<!-- Are you sure -->
<div class="modal fade" id="createlesson" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="heading lead">Create Module</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <?php echo form_open_multipart('courses/create_title'); ?>
        <div class="form-group">
          <label for="formGroupExampleInput">* Title</label>
          <input type="text" class="form-control" name="courseName" required>
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancel</a>
        <button class="btn btn-success waves-effect"><i class="fa fa-check-square-o"></i>Save</button>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
  $(".customSwitches").click(function() {
    var delete_lesson = $(this).attr('id');
    if($(".swt"+delete_lesson).is(":checked")){
      $('#testtex'+delete_lesson).text('Active');
      $(this).val(1);
    } else {
      $('#testtex'+delete_lesson).text('Inactive');
      $(this).val(0);
    }
  });
});
</script>
<script type="text/javascript">
$(document).ready(function() {
  $( "#sortablecourses" ).sortable({
    placeholder : "ui-state-highlight",
    update  : function(event, ui){
      var post_order_ids = new Array();
      $('#sortablecourses .sortcourse').each(function(){
        post_order_ids.push($(this).data("id"));
      });
      $.ajax({
        url:"<?php echo site_url('courses/sort_course_2')?>",
        method:"POST",
        data:{post_order_ids:post_order_ids},
        success:function(data){
           toastr.success('Module order has been updated successfully'); 
        }
      });
    }
  });
});
</script>