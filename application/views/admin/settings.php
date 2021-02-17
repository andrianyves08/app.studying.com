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
                <td><?php 
                  if($settings['system_status'] == 0){
                    echo '<span class="badge badge-pill badge-success">Active</span>';
                  } else {
                    echo '<span class="badge badge-pill badge-danger">Maintenance</span>';
                  }
                  ?>
                </td>
                <td><a class="text-primary" data-toggle="modal" data-target="#edit_status"><i class="fas fa-edit text-primary"></i> Edit</a></td>
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
                <td>Navbar Color</td>
                <td><?php echo $settings['nav_text_color'];?></td>
                <td><a class="text-primary" data-toggle="modal" data-target="#edit_nav_color"><i class="fas fa-edit text-primary"></i> Edit</a></td>
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

<!-- Nav -->
<div class="modal fade" id="edit_nav_color" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?php echo form_open_multipart('settings/nav_text_color'); ?>
      <div class="modal-body mx-3">
        <label for="image">Nav Icon Color</label>
        <div class="form-group">
          <select class="browser-default custom-select" name="nav_color" id="nav_color">
            <option value="amber-text">Yellow</option>
            <option value="red-text">Red</option>
            <option value="indigo-text">Indigo</option>
            <option value="cyan-text">Cyan</option>
            <option value="green-text">Green</option>
            <option value="pink-text">Pink<option>
            <option value="purple-text">Purple</option>
            <option value="black-text">Black</option>
            <option value="text-white">White</option>
            <option value="blue-text">Blue</option>
          </select>
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

<?php echo validation_errors(); ?>

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
<div class="modal fade" id="edit_status" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
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
        <?php echo form_open_multipart('admin/change_status'); ?>
        <div class="form-group">
          <label for="formGroupExampleInput">* Current Password</label>
          <input type="password" name="current_password" class="form-control" required>
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