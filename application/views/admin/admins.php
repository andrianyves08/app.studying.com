<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <div class="card mb-4 wow fadeIn">
    <div class="card-body d-sm-flex justify-content-between">
      <h4 class="mb-2 mb-sm-0 pt-1">
        <span><a href="<?php echo base_url();?>admin">Home</a></span>
        <span>/</span>
        <span>Admins</span>
      </h4>
    </div>
  </div><!-- Heading -->

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <table class="table table-bordered display table-responsive-md" cellspacing="0" width="100%">
            <thead>
              <th>Full Name</th>
              <th>Email</th>
              <th>Status</th>
              <th>Last Login</th>
              <th></th>
            </thead>
            <tbody>
              <?php foreach ($admins as $admin) {?>
              <tr>
                <td><?php echo ucwords($admin['first_name']);?> <?php echo ucwords($admin['last_name']);?></td>
                <td><?php echo $admin['email'];?></td>
                <td>
                  <?php if($admin['status'] == 0){?>
                  <span class="badge badge-pill badge-danger">Deactivated</span>
                  <?php } else { ?>
                  <span class="badge badge-pill badge-success">Active</span>
                  <?php } ?>
                </td>
                <td><?php echo $admin['last_login'];?></td>
                <td>
                  <a class="btn btn-sm btn-primary" data-toggle='modal' data-target='#edit<?php echo $admin['id']; ?>' href='#edit?id=<?php echo $admin['id']; ?>'>Edit</a>
                </td>
              </tr>
              <div class="modal fade" id="edit<?php echo $admin['id']; ?>" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md" role="document">
                  <div class="modal-content">
                    <div class="modal-header text-center">
                      <h4 class="modal-title w-100 font-weight-bold"><?php echo ucwords($admin['first_name']);?>
                      </h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;
                      </span>
                      </button>
                    </div>
                    <?php echo form_open_multipart('admin/update_admin'); ?>
                    <div class="modal-body mx-3">
                      <div class="form-group">
                        <label for="formGroupExampleInput">* Email</label>
                         <input type="hidden" class="form-control" name="admin_ID" value="<?php echo $admin['id']; ?>">
                        <input type="email" class="form-control" name="email" value="<?php echo $admin['email']; ?>">
                      </div>
                      <div class="form-row mb-4">
                        <div class="col">
                           <label for="formGroupExampleInput">First Name</label>
                            <input type="text" class="form-control" name="first_name" value="<?php echo $admin['first_name']; ?>">
                        </div>
                        <div class="col">
                          <label for="formGroupExampleInput">Last Name</label>
                          <input type="text" class="form-control" name="last_name" value="<?php echo $admin['last_name']; ?>">
                        </div>
                      </div>
                      <div class="form-group mb-4">
                      <label for="formGroupExampleInput">* Position</label>
                        <select class="browser-default custom-select" name="position" id="position">
                          <?php if($admin['position'] == 1){ ?>
                            <option value="1" selected>Admin</option>
                            <option value="2">Super Admin</option>
                            <option value="3">Content and Blog Writer</option>
                          <?php } elseif($admin['position'] == 3) { ?>
                            <option value="1">Admin</option>
                            <option value="2">Super Admin</option>
                            <option value="3" selected>Content and Blog Writer</option>
                          <?php } else { ?>
                            <option value="1">Admin</option>
                            <option value="2" selected>Super Admin</option>
                            <option value="3">Content and Blog Writer</option>
                          <?php } ?>
                        </select>
                      </div>
                      <label for="editstatus">* Status</label><br>
                      <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input customSwitches swt<?php echo $admin['id']; ?>" id="<?php echo $admin['id']; ?>" <?php if($admin['status'] == 1){ echo 'checked';}?> name="status" value="<?php if($admin['status'] == 1){ echo '1';} else { echo '0';}?>">
                        <label class="custom-control-label" for="<?php echo $admin['id']; ?>" id="testtex<?php echo $admin['id']; ?>"><?php if($admin['status'] == 1){ echo 'Active';} else { echo 'Deactivated';}?></label>
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
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createnews">Create Admin</button>
        </div><!--Card Body-->
      </div><!--Card-->
    </div><!--Column-->
  </div><!--Row-->
</div><!--Container-->
</main><!--Main laypassed out-->
<!-- Are you sure -->
<div class="modal fade" id="createnews" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
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
        <?php echo form_open_multipart('admin/create_admin'); ?>
        <div class="form-group">
          <label for="formGroupExampleInput">* Email</label>
          <input type="email" class="form-control" name="email">
        </div>
        <div class="form-row mb-4">
          <div class="col">
             <label for="formGroupExampleInput">First Name</label>
              <input type="text" class="form-control" name="first_name">
          </div>
          <div class="col">
            <label for="formGroupExampleInput">Last Name</label>
            <input type="text" class="form-control" name="last_name">
          </div>
        </div>
        <div class="form-row mb-4">
          <div class="col">
            <label for="formGroupExampleInput">* Password</label>
            <input type="password" id="new_password" name="new_password" class="form-control">
          </div>
          <div class="col">
            <label for="formGroupExampleInput">* Confirm Password</label>
          <input type="password" id="cnew_Password" name="cnew_Password" class="form-control">
          </div>
        </div>
        <div class="form-group">
        <label for="formGroupExampleInput">* Position</label>
          <select class="browser-default custom-select" name="position" id="position">
            <option selected>Open this select menu</option>
            <option value="1">Admin</option>
            <option value="2">Super Admin</option>
            <option value="3">Content and Blog Writer</option>
          </select>
        </div> 
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancel</button>
        <button class="btn btn-primary waves-effect" type="submit">Create Admin</button>
        <?php echo form_close(); ?>
      </div>
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
      $('#testtex'+delete_lesson).text('Deactivate');
       $(this).val(0);
    }
  });
});
</script>