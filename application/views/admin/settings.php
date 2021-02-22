<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <div class="card mb-4 wow fadeIn">
    <div class="card-body d-sm-flex justify-content-between">
      <h4 class="mb-2 mb-sm-0 pt-1">
        <span><a href="<?php echo base_url();?>admin">Home</a></span>
        <span>/</span>
        <span>Settings</span>
      </h4>
    </div>
  </div>
  <!-- Heading -->

  <div class="row">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <h4>Options</h4>
          <table class="table table-responsive-md" cellspacing="0" width="100%">
            <tbody>
              <tr>
                <td>System Status</td>
                <td>
                  <?php 
                  if($settings['system_status'] == 0){
                    echo '<span class="badge badge-pill badge-danger">Under Maintenance</span>';
                  } else {
                    echo '<span class="badge badge-pill badge-success">Active</span>';
                  }
                  ?>
                </td>
                <td><a class="text-primary" data-toggle="modal" data-target="#edit_system_status"><i class="fas fa-edit text-primary"></i> Edit</a></td>
              </tr>
              <tr>
                <td>Logo</td>
                <td><?php echo $settings['logo_img'];?></td>
                <td><a class="text-primary" data-toggle="modal" data-target="#edit_logo"><i class="fas fa-edit text-primary"></i> Edit</a></td>
              </tr>
              <tr>
                <td>Login Video</td>
                <td><?php echo $settings['login_video'];?></td>
                <td><a class="text-primary" data-toggle="modal" data-target="#edit_login_video"><i class="fas fa-edit text-primary"></i> Edit</a></td>
              </tr>
              <tr>
                <td>Home Video</td>
                <td><?php echo $settings['home_video'];?></td>
                <td><a class="text-primary" data-toggle="modal" data-target="#edit_home_video"><i class="fas fa-edit text-primary"></i> Edit</a></td>
              </tr>
              <tr>
                <td>Music</td>
                <td><?php echo $settings['music'];?></td>
                <td><a class="text-primary" data-toggle="modal" data-target="#edit_music"><i class="fas fa-edit text-primary"></i> Edit</a></td>
              </tr>
              <tr>
                <td>Review Post Status</td>
                <td>
                  <?php 
                  if($settings['review_post_status'] == 0){
                    echo '<span class="badge badge-pill badge-danger">Off</span>';
                  } else {
                    echo '<span class="badge badge-pill badge-success">On</span>';
                  }
                  ?>
                </td>
                <td><a class="text-primary" data-toggle="modal" data-target="#edit_review_post_status"><i class="fas fa-edit text-primary"></i> Edit</a></td>
              </tr>
            </tbody>
          </table>
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#changepassword">Change Password</button>
        </div><!--Card Body-->
      </div><!--Card-->
    </div><!--Colmun-->

    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <h4>Pages</h4>
          <table class="table table-responsive-md" cellspacing="0" width="100%">
            <tbody>
            <?php foreach ($pages as $page) {?>
              <tr>
                <td><?php echo ucwords($page['name']);?></td>
                <td><a class="text-primary" href="<?php echo base_url('admin/settings'); ?>/<?php echo $page['id'];?>"><i class="fas fa-edit text-primary"></i> Edit</a></td>
              </tr>
            <?php } ?>
            </tbody>
          </table>
        </div><!--Card Body-->
      </div><!--Card-->
    </div><!--Column-->
  </div><!--Row-->
</div><!--Container-->
</main>
<!-- Logo -->
<div class="modal fade" id="edit_logo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?php echo form_open_multipart('settings/logo'); ?>
      <div class="modal-body mx-3">
        <label for="image">Logo</label>
        <div class="input-group">
          <div class="custom-file">
            <input type="file" class="custom-file-input" id="logo" name="logo" aria-describedby="inputGroupFileAddon01">
            <label class="custom-file-label text-left" for="logo"><?php echo $settings['logo_img'];?></label>
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-outline-danger waves-effect" data-dismiss="modal">Cancel</button>
        <button class="btn btn-outline-primary waves-effect" type="submit">Update</button>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>

<!-- Login Video -->
<div class="modal fade" id="edit_login_video" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?php echo form_open_multipart('settings/login_video'); ?>
      <div class="modal-body mx-3">
        <label for="image">Background video on Login Page</label>
        <div class="input-group">
          <div class="custom-file">
            <input type="file" class="custom-file-input" id="login_video" name="login_video" aria-describedby="inputGroupFileAddon01">
            <label class="custom-file-label text-left" for="login_video"><?php echo $settings['login_video'];?></label>
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-outline-danger waves-effect" data-dismiss="modal">Cancel</button>
        <button class="btn btn-outline-primary waves-effect" type="submit">Update</button>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>

<!-- Home Video -->
<div class="modal fade" id="edit_home_video" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?php echo form_open_multipart('settings/home_video'); ?>
      <div class="modal-body mx-3">
        <label for="image">Background video on Home Page</label>
        <div class="input-group">
          <div class="custom-file">
            <input type="file" class="custom-file-input" id="home_video" name="home_video" aria-describedby="inputGroupFileAddon01">
            <label class="custom-file-label text-left" for="home_video"><?php echo $settings['home_video'];?></label>
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-outline-danger waves-effect" data-dismiss="modal">Cancel</button>
        <button class="btn btn-outline-primary waves-effect" type="submit">Update</button>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>

<!-- Music -->
<div class="modal fade" id="edit_music" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?php echo form_open_multipart('settings/music'); ?>
      <div class="modal-body mx-3">
        <label for="image">Background Music</label>
        <div class="input-group">
          <div class="custom-file">
            <input type="file" class="custom-file-input" id="music" name="music" aria-describedby="inputGroupFileAddon01">
            <label class="custom-file-label text-left" for="music"><?php echo $settings['music'];?></label>
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-outline-danger waves-effect" data-dismiss="modal">Cancel</button>
        <button class="btn btn-outline-primary waves-effect" type="submit">Update</button>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>

<!-- Change Password -->
<div class="modal fade" id="changepassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">Change Password</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <?php echo form_open_multipart('admin/change_password'); ?>
        <div class="form-group">
          <label for="formGroupExampleInput">* Current Password</label>
          <input type="password" name="current_password" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="formGroupExampleInput">* New Password</label>
          <input type="password" name="new_password" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="formGroupExampleInput">* Confirm New Password</label>
          <input type="password" name="confirm_new_password" class="form-control" required>
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-outline-danger waves-effect" data-dismiss="modal">Cancel</button>
        <button class="btn btn-outline-primary waves-effect" type="submit">Save Changes</button>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>

<!-- Change Password -->
<div class="modal fade" id="edit_system_status" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">Change System Status</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <?php echo form_open_multipart('admin/change_system_status'); ?>
        <div class="form-group">
          <label for="editstatus">* Status</label><br>
          <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" name="system_status" id="system_status" <?php if($settings['system_status'] == 1){ echo 'checked'; } ?> value="<?php if($settings['system_status'] == 1){ echo '1';} else { echo '0';}?>">
            <label class="custom-control-label" for="system_status" id="system_status_label"><?php if($settings['system_status'] == 0){ echo 'Under Maintenance'; } else { echo 'Active'; } ?>
            </label>
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-outline-danger waves-effect" data-dismiss="modal">Cancel</button>
        <button class="btn btn-outline-primary waves-effect" type="submit">Save Changes</button>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>

<!-- Change Password -->
<div class="modal fade" id="edit_review_post_status" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">Change Review Post Status</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <?php echo form_open_multipart('admin/change_review_post_status'); ?>
        <div class="form-group">
          <label for="editstatus">* Status</label><br>
          <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" name="review_status" id="review_status" <?php if($settings['review_post_status'] == 1){ echo 'checked'; } ?> value="<?php if($settings['review_post_status'] == 1){ echo '1';} else { echo '0';}?>">
            <label class="custom-control-label" for="review_status" id="review_status_label"><?php if($settings['review_post_status'] == 0){ echo 'Off'; } else { echo 'On'; } ?>
            </label>
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-outline-danger waves-effect" data-dismiss="modal">Cancel</button>
        <button class="btn btn-outline-primary waves-effect" type="submit">Save Changes</button>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>
<script>
$(document).ready(function(){
  $("#review_status").click(function() {
    if($("#review_status").is(":checked")){
      $('#review_status_label').text('On');
      $(this).val(1);
    } else {
      $('#review_status_label').text('Off');
      $(this).val(0);
    }
  });

  $("#system_status").click(function() {
    if($("#system_status").is(":checked")){
      $('#system_status_label').text('On');
      $(this).val(1);
    } else {
      $('#system_status_label').text('Off');
      $(this).val(0);
    }
  });
});
</script>