<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <div class="card mb-4 wow fadeIn">
    <div class="card-body d-sm-flex justify-content-between">
      <h4 class="mb-2 mb-sm-0 pt-1">
        <span><a href="<?php echo base_url();?>admin">Home</a></span>
        <span>/</span>
        <span><a href="<?php echo base_url(); ?>admin/users">Users</a></span>
        <span>/</span>
        <span><?php echo ucwords($users['first_name']);?> <?php echo ucwords($users['last_name']);?></span>
      </h4>
    </div>
  </div>
  <!-- Heading -->
  <div class="row">
    <div class="col-md-4">
      <div class="card mb-4">
        <div class="view overlay">
          <?php if(!empty($users['image'])){?>
            <img class="card-img-top chat-mes-id-3" src="<?php echo base_url();?>assets/img/users/<?php echo $users['image'];?>" alt="Profile Photo">
          <?php } else { ?>
            <img class="card-img-top chat-mes-id-3" src="<?php echo base_url();?>assets/img/users/stock.png" alt="Profile Photo">
          <?php } ?>
          <a href="#!">
            <div class="mask rgba-white-slight"></div>
          </a>
        </div>
        <div class="card-body">
          <h4 class="card-title">
            <?php if(!empty($users['first_name']) && !empty($users['first_name'])){?>
              <strong><?php echo ucwords($users['first_name']);?> <?php echo ucwords($users['last_name']);?></strong>
            <?php } else { ?>
              <strong class="red-text">User doesn't add any name!</strong>
            <?php } ?>
          </h4>
          <h5 class="blue-text"><strong><?php echo $users['email'];?></strong></h5>
        </div>
        <div class="btn-group btn-group-sm mb-2" role="group" aria-label="Basic example">
          <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#changemodule">Add Purchases</button>
          <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#changestatus">Change Status</button>
          <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#change_password">Change Password</button>
          <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#changeprofile">Change Profile</button>
        </div>
      </div>
    </div><!--Column -->

    <div class="col-md-8">
      <div class="card mb-4">
        <div class="card-header customcolorbg">
           <h4 class="text-white"><strong>Purchases </strong></h4>
        </div>
        <div class="card-body">
          <table class="table table-responsive-md" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th scope="col">Module</th>
                <th scope="col">Created At</th>
                <th scope="col">Current Paid</th>
                <th scope="col">Status</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($modules as $module) {?>
              <tr>
                <td><?php echo ucwords($module['name']);?></td>
                <td><?php echo date("F d, Y h:i A", strtotime($module['created_at']));?></td>
                <td><?php echo $module['amount'];?> USD</td>
                <td>
                  <?php if($module['status'] == 2){?>
                    <span class="badge badge-pill badge-info">Refunded</span>
                  <?php } else { ?>
                    <span class="badge badge-pill badge-success">Paid</span>
                  <?php } ?>
                </td>
                <td>
                  <a class="update_status white-text btn btn-sm btn-primary" id="<?php echo $module['user_program_id'];?>"></i> Refund</a> 
                  <a class="white-text btn btn-sm btn-danger delete_purchase" data-purchase-id="<?php echo $module['user_program_id'];?>"></i> Delete Purchase</a> 
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div><!--Card Body-->
      </div> <!--Card-->
    </div><!--Column Delete-->
  </div><!--Row-->

  <div class="row">
    <div class="col-md-12">
      <div class="card mb-4">
        <div class="card-header customcolorbg">
           <h4 class="text-white"><strong>Videos Watched </strong></h4>
        </div>
        <div class="card-body">
          <table class="table table-bordered table-responsive-md display" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th scope="col">Module Name</th>
                <th scope="col">Content Name</th>
                <th scope="col">Status</th>
                <th scope="col">Date Finished</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($videos as $video) {?>
              <tr>
                <td><?php echo ucwords($video['name']);?></td>
                <td><?php echo ucwords($video['content_name']);?></td>
                <td>
                  <?php if($video['status'] == 0){?>
                    <span class="badge badge-pill badge-info">On Going</span>
                  <?php } else { ?>
                    <span class="badge badge-pill badge-success">Finished Watching</span>
                  <?php } ?>
                </td>
                <td><?php echo date("F d, Y h:i A", strtotime($video['timestamp']));?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div><!--Card Body-->
      </div> <!--Card-->
    </div><!--Column-->
  </div><!--Row--> 
</div><!--Container-->
</main><!--Main laypassed out-->

<!--Purchase Delete -->
<div data-backdrop="static" class="modal fade" id="delete_purchase_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-sm modal-notify modal-danger" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">Delete Purchase</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this purchase?</p>
        <input type="hidden" class="form-control" name="delete_ID" value="<?php echo $module['user_program_id'];?>">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-sm" id="delete_purchase">Confirm</button>
      </div>
    </div>
  </div>
</div>
<!--Purchase Delete-->

<!-- Add Purchase -->
<div data-backdrop="static" class="modal fade" id="changemodule" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="heading lead">Add Purchases</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <input type="hidden" class="form-control" name="user_ID" id="user_ID" value="<?php echo $users['id'];?>">
        <div class="form-group">
        <label for="formGroupExampleInput">* Programs</label>
          <select name="modules[]" id="modules" class="select2" multiple="multiple" data-placeholder="Select a State" style="width: 100%;" required>
            <?php foreach ($programs as $program) { ?>
              <option value="<?php echo $program['id'];?>"><?php echo ucwords($program['name']);?></option>
            <?php }?>
          </select>
        </div> 
      </div>
      <div class="modal-footer justify-content-center">
        <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancel</a>
        <button class="btn btn-success waves-effect float-right" type="submit" id="add_purchases">Save Changes</button>
      </div>
    </div>
  </div>
</div>
<!-- Add Purchase -->

<!-- Add Purchase -->
<div data-backdrop="static" class="modal fade" id="purchase_status" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="heading lead">Update Status</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <input type="hidden" class="form-control" name="purchase_ID" id="purchase_ID">
        <div class="form-group">
        <label for="formGroupExampleInput">* Status</label>
          <select class="browser-default custom-select" name="select_section" id="select_section">
            <option value="2">Refund</option>
          </select>
        </div> 
        <div class="form-group">
          <label for="formGroupExampleInput">* Amount to refund</label>
          <input type="number" name="amount" class="form-control" min="0">
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancel</a>
        <button class="btn btn-success waves-effect float-right" type="submit" id="update_status">Save Changes</button>
      </div>
    </div>
  </div>
</div>
<!-- Add Purchase -->

<div class="modal fade" id="changestatus" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">Change Status
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;
        </span>
        </button>
      </div>
      <?php echo form_open_multipart('users/change_status/'.$users['id']); ?>
      <div class="modal-body mx-3">
        <label for="editstatus">* Status</label><br>
        <div class="custom-control custom-switch">
          <input type="checkbox" class="custom-control-input customSwitches swt<?php echo $users['id']; ?>" id="<?php echo $users['id']; ?>" <?php if($users['status'] == '1'){ echo 'checked';}?> name="status">
          <label class="custom-control-label" for="<?php echo $users['id']; ?>" id="testtex<?php echo $users['id']; ?>"><?php if($users['status'] == '1'){ echo 'Active';} elseif ($users['status'] == '2') { echo 'Deactivated';} else { echo 'This user did not yet activate his account';}?></label>
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-outline-danger waves-effect" data-dismiss="modal">Cancel</button>
        <button class="btn btn-outline-primary waves-effect">Update</button>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>

<!--Change Password -->
<div data-backdrop="static" class="modal fade" id="change_password" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="heading lead">Change Password</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <?php echo form_open_multipart('admin/user_change_password'); ?>
        <div class="form-group">
          <label for="formGroupExampleInput">* New Password</label>
          <input type="password" name="new_password" class="form-control" required>
          <input type="hidden" name="user_ID" class="form-control" value="<?php echo $users['id'];?>">
        </div>
        <div class="form-group">
          <label for="formGroupExampleInput">* Confirm New Password</label>
          <input type="password" name="confirm_new_password" class="form-control" required>
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancel</a>
        <button class="btn btn-success waves-effect float-right" type="submit" id="add_purchases">Save Changes</button>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>
<!--Change Password -->

<!-- Change Profile -->
<div data-backdrop="static" class="modal fade" id="changeprofile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="heading lead">Change Password</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <?php echo form_open_multipart('admin/change_profile'); ?>
        <div class="form-row mb-4">
          <div class="col">
            <label for="formGroupExampleInput">First Name</label>
            <input type="text" class="form-control" name="first_name" value="<?php echo ucwords($users['first_name']);?>">
            <input type="hidden" class="form-control" name="image" value="<?php echo $users['image'];?>">
            <input type="hidden" name="user_ID" class="form-control" value="<?php echo $users['id'];?>">
          </div>
          <div class="col">
            <label for="formGroupExampleInput">Last Name</label>
            <input type="text" class="form-control" name="last_name" value="<?php echo ucwords($users['last_name']);?>">
          </div>
        </div>
        <div class="form-group">
          <label for="formGroupExampleInput">* Email</label>
          <input type="email" class="form-control" name="email" value="<?php echo ucwords($users['email']);?>">
        </div>
        <div class="form-group">
          <label for="formGroupExampleInput">* Bio</label>
          <input type="text" class="form-control" name="bio" value="<?php echo ucwords($users['bio']);?>">
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancel</a>
        <button class="btn btn-success waves-effect float-right" type="submit">Save Changes</button>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>
<!-- Change Profile -->