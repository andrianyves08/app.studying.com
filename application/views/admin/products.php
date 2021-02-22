<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <div class="card mb-4 wow fadeIn">
    <div class="card-body d-sm-flex justify-content-between">
      <h4 class="mb-2 mb-sm-0 pt-1">
        <span><a href="<?php echo base_url();?>admin">Home</a></span>
        <span>/</span>
        <span>Products</span>
      </h4>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <table class="table table-bordered table-responsive-md" cellspacing="0" width="100%">
            <thead>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Type</th>
            <th>Status</th>
            <th>Last Modified</th>
            <th></th>
            </thead>
            <tbody>
            <?php foreach ($products as $product) {?>
              <tr>
                <td><?php echo $product['product_ID'];?></td>
                <td><?php echo ucwords($product['product_name']);?></td>
                <td><?php echo ucfirst($product['description']);?></td>
                <td><?php echo $product['price'];?></td>
                <td><?php echo ucfirst($product['type_name']);?></td>
                <td><?php echo date("F d, Y h:i A", strtotime($product['date_modified']));?></td>
                <td>
                  <?php if($product['status'] == '1'){?>
                    <span class="badge badge-pill badge-success">Active</span>
                  <?php } else { ?>
                    <span class="badge badge-pill badge-warning">Inactive</span>
                  <?php } ?>
                </td>
                <td>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <a class="btn btn-sm btn-primary" href='<?php echo base_url(); ?>admin/products/<?php echo $product['product_ID'];?>'>Edit</a>
                      <a class="btn btn-sm btn-success edit_status" data-product-id="<?php echo $product['product_ID'];?>" data-status="<?php echo $product['status'];?>">Change Status</a>
                    </div>
                  </div>
                </td>
              </tr>
            <?php } ?>
            </tbody>
          </table>
          <a type="button" class="btn btn-primary" data-toggle="modal" data-target="#createlesson">Create Product</a>
        </div><!--Card Body-->
      </div><!--Card-->
    </div><!--Column-->
  </div><!--Row-->
</div><!--Container-->
</main><!--Main laypassed out-->
<!-- Create Product -->
<div class="modal fade" id="createlesson" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="heading lead">Create Products</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <?php echo form_open_multipart('products/create'); ?>
        <div class="form-group">
          <label for="formGroupExampleInput">* Name</label>
          <input type="text" class="form-control" name="name" required>
        </div>
        <div class="form-group">
          <label for="exampleFormControlTextarea2">Description</label>
          <textarea class="form-control rounded-0" name="description" id="description" rows="3"></textarea>
        </div>
        <div class="form-group">
          <label for="formGroupExampleInput">* Price</label>
          <input type="number" class="form-control" name="price" min="0" step="0.01"  max="1000000" required>
        </div>
        <label for="formGroupExampleInput">* Type</label>
        <select class="browser-default custom-select mb-4" id="type" name="type" required>
          <option disabled selected>Choose Type</option>
          <?php foreach ($types as $type) { ?>
            <option value="<?php echo $type['id']; ?>"><?php echo ucwords($type['name']); ?></option>
          <?php } ?>
        </select>
        <label for="formGroupExampleInput">* Category</label>
        <div class="input-group mb-4" style="width: 100%;">
          <select class="browser-default custom-select select2" name="category[]" id="category" multiple="multiple" data-placeholder="Select a Category" required style="width: 70%;">
          </select>
          <div class="input-group-append">
            <a class="btn btn-md btn-outline-primary m-0 px-3 py-2 waves-effect" type="button" data-toggle="modal" data-target="#create_category">Create New Category</a>
          </div>
        </div>
        <label for="image">* Main image</label>
        <div class="input-group mb-4">
          <div class="custom-file">
            <input type="file" class="custom-file-input" name="image" aria-describedby="inputGroupFileAddon01" required>
            <label class="custom-file-label text-left" for="image"></label>
          </div>
        </div>
        <label for="image">Other images</label>
        <div class="input-group mb-4">
          <div class="custom-file">
            <input type="file" class="custom-file-input" name="images[]" aria-describedby="inputGroupFileAddon01" multiple>
            <label class="custom-file-label text-left" for="images"></label>
          </div>
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
<!-- Create Product-->
<!-- Create Category-->
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
        <label for="formGroupExampleInput">* Type</label>
        <?php foreach ($types as $type) { ?>
          <div class="custom-control custom-radio">
            <input type="radio" class="custom-control-input category_type" id="category_type_<?php echo $type['id']; ?>" name="category_type" value="<?php echo $type['id']; ?>">
            <label class="custom-control-label" for="category_type_<?php echo $type['id']; ?>"><?php echo ucwords($type['name']); ?></label>
          </div>
        <?php } ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button class="btn btn-primary waves-effect btn-sm float-right" type="submit" id="add_category">Create</button>
      </div>
    </div>
  </div>
</div>
<!-- Create Category-->
<!-- Change Status -->
<div data-backdrop="static" class="modal fade" id="status_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-sm modal-notify modal-info" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">Edit Status</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="product_ID" name="product_ID">
        <label for="editstatus">* Status</label><br>
        <div class="custom-control custom-switch">
          <input type="checkbox" class="custom-control-input" id="status" value="0">
          <label class="custom-control-label" for="status" id="status_label">Inactive</label>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-target="#status" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-sm" id="confirm_status">Confirm</button>
      </div>
    </div>
  </div>
</div>
<!-- Change Status -->
<script>
$(document).ready(function(){
  //Change category based on type
  $('#type').change(function(){ 
    var type_ID=$(this).val();
    get_category(type_ID);
  });

  function get_category(type_ID){
   $.ajax({
      url : "<?=base_url()?>products/get_categories",
      method : "POST",
      data : {type_ID: type_ID},
      async : true,
      dataType : 'json',
      success: function(data){
        var html = '';
        var i;
        for(i=0; i<data.length; i++){
          html += '<option value='+data[i].id+'>'+data[i].name+'</option>';
        }
        $('#category').html(html);
      }
    });
    return false;
  }

  //Add member
  $('#add_category').on('click',function(){
    var name = $('#new_category').val();
    var type_ID = $(".category_type:checked").val();
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>products/create_category",
      dataType : "JSON",
      data : {name:name, type_ID:type_ID},
      success: function(data){
        if(data.error){
          toastr.error(data.message);
        } else {
          toastr.success('Category created');
          $('#create_category').modal('hide');
          get_category(type_ID);
          $('#new_category').val('');
        }
      }
    });
    return false;
  });

  $(document).on("click", ".edit_status", function() { 
    var status = $(this).data('status');
    var product_ID = $(this).data('product-id');
    $('#product_ID').val(product_ID);
    $('#status_modal').modal('show');
    if(status == 1){
      $('#status').prop('checked',true);
      $('#status_label').text('Active');
      $('#status').val(1);
    } 
  });

   //Like post
  $('#confirm_status').on('click',function(){
    var status = $('#status').val();
    var product_ID = $('#product_ID').val();
    $.ajax({
      url:"<?=base_url()?>products/change_status",
      method:"POST",
      async : true,
      dataType : 'json',
      data:{product_ID:product_ID, status:status},
      success:function(data) {
        toastr.success('Status Updated!');
        location.reload();
      }
    });
  });

  $("#status").click(function() {
    if($("#status").is(":checked")){
      $('#status_label').text('Active');
      $(this).val(1);
    } else {
      $('#status_label').text('Inactive');
      $(this).val(0);
    }
  });
});
</script>