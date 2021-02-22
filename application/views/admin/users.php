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
  <!-- Heading -->
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <table class="table table-bordered display table-responsive-md" cellspacing="0" width="100%">
            <thead>
            <th>User ID</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Status</th>
            <th>Last Login</th>
            <th></th>
            </thead>
            <tbody>
            <?php foreach($clients as $client){ ?> 
              <tr>
                <td><?php echo $client['id'];?></td>
                <td><?php echo ucwords($client['first_name']);?> <?php echo ucwords($client['last_name']);?></td>
                <td><?php echo $client['email'];?></td>
                <td>
                  <?php if($client['status'] == '0'){?>
                    <span class="badge badge-pill badge-warning">Not Yet Activated</span>
                  <?php } elseif($client['status'] == '1') { ?>
                    <span class="badge badge-pill badge-success">Active</span>
                  <?php } else { ?>
                    <span class="badge badge-pill badge-danger">Deactivated</span>
                  <?php } ?>
                </td>
                <td><?php echo $client['last_login'];?></td>
                <td><a class="btn btn-sm btn-success" href="<?php echo base_url('admin/users'); ?>/<?php echo $client['id'];?>"> View</a></td>
              </tr>
            <?php }?>
            </tbody>
          </table>
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createnews">Create User</button>
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
        <?php echo form_open_multipart('users/create'); ?>
        <div class="form-group">
          <label for="formGroupExampleInput">* Email</label>
          <input type="email" class="form-control" name="email" required>
        </div>
        <div class="form-group">
        <label for="formGroupExampleInput">* Programs</label>
          <select name="modules[]" id="modules" class="select2" multiple="multiple" data-placeholder="Select a State" style="width: 100%;" required>
            <?php foreach ($programs as $program) { ?>
             <option value="<?php echo $program['id'];?>"><?php echo ucwords($program['name']);?></option>
            <?php }?>
          </select>
        </div> 
        <h6 class="red-text">NOTE: default password for new user is studying</h6>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-outline-danger waves-effect" data-dismiss="modal">Cancel</button>
        <button class="btn btn-outline-primary waves-effect" type="submit">Create User</button>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>