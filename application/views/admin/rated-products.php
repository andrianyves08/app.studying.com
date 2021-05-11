<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <div class="card mb-4 wow fadeIn">
    <div class="card-body d-sm-flex justify-content-between">
      <h4 class="mb-2 mb-sm-0 pt-1">
        <span><a href="<?php echo base_url();?>admin">Home</a></span>
        <span>/</span>
        <span>Rated Products</span>
      </h4>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <table class="table table-bordered table-responsive-md" cellspacing="0" width="100%">
            <thead>
            <th>Name</th>
            <th>Description</th>
            <th>Rating</th>
            <th></th>
            </thead>
            <tbody id="sortablecourses">
            <?php foreach ($products as $product) {?>
              <tr>
                <td><?php echo ucwords($product['name']);?></td>
                <td><?php echo ucfirst($product['description']);?></td>
                <td>
                <?php 
                  $output = '';
                  if($product['rating'] == 0){
                    $output .='<i class="far fa-star amber-text"></i>';
                  } else {
                    $i = 0;
                    while($product['rating'] > $i){
                      $output .='<i class="fas fa-star amber-text"></i>';
                      $i++;
                    }
                  }
                   echo $output;
                ?>
                </td>
                <td>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <a class="btn btn-sm btn-success view_image" data-product-id="<?php echo $product['id'];?>" data-product-slug="<?php echo $product['slug'];?>">View Image</a>
                      <a class="btn btn-sm btn-primary" href='<?php echo base_url(); ?>admin/rated-products/<?php echo $product['id'];?>'>Edit</a>
                      <a class="btn btn-sm btn-danger delete_product" data-product-id="<?php echo $product['id'];?>">Delete</a>
                    </div>
                  </div>
                </td>
              </tr>
            <?php } ?>
            </tbody>
          </table>
          <a type="button" class="btn btn-primary" data-toggle="modal" data-target="#createlesson">Create Rated Product</a>
        </div><!--Card Body-->
      </div><!--Card-->
    </div><!--Column-->
  </div><!--Row-->
</div><!--Container-->
</main><!--Main laypassed out-->
<!-- Create Product -->
<div class="modal fade" id="createlesson" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="heading lead">Create Procucts</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <?php echo form_open_multipart('rated_products/create'); ?>
        <div class="form-group">
          <label for="formGroupExampleInput">* Name</label>
          <input type="text" class="form-control" name="name" required>
        </div>
        <div class="form-group">
          <label for="formGroupExampleInput">* Description</label>
          <input type="text" class="form-control" name="description" required>
        </div>
        <div class="form-group">
          <label for="formGroupExampleInput">* Rating</label>
          <input type="number" class="form-control" name="rating" min="0" max="10" required>
        </div>
        <div class="form-group">
          <label for="formGroupExampleInput">* URL</label>
          <input type="text" class="form-control" name="url" required>
        </div>
        <label for="image">* Upload Photos</label>
        <div class="input-group mb-4">
          <div class="custom-file">
            <input type="file" class="custom-file-input" name="photos[]" aria-describedby="inputGroupFileAddon01" multiple required>
            <label class="custom-file-label text-left" for="photos"></label>
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
<!-- View Image -->
<div class="modal fade" id="product_images" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="heading lead">View Images</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
        <div class="d-grid mdb-lightbox" id="image_list">
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</a>
      </div>
    </div>
  </div>
</div>
<!-- View Image-->
<!-- Product Delete -->
<div data-backdrop="static" class="modal fade" id="product_delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-sm modal-notify modal-danger" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">Delete Product</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this product?</p>
        <input type="hidden" class="form-control" name="product_ID" id="product_ID">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-target="#product_delete" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-sm" id="confirm_delete_product">Confirm</button>
      </div>
    </div>
  </div>
</div>
<!-- Product Delete -->
<script>
$(document).ready(function(){
  $(document).on("click", ".delete_product", function() { 
    var id=$(this).data('product-id');
    $('#product_delete').modal('show');
    $('[name="product_ID"]').val(id);
  });

  $("#confirm_delete_product").on('click',function(){
    var product_ID = $('#product_ID').val();
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>rated_products/delete",
      dataType : "JSON",
      data : {id:product_ID},
      success: function(data){
        toastr.error('Product Deleted');
        location.reload();
      }
    });
    return false;
  });

  $(document).on("click", ".view_image", function() { 
    var product_ID = $(this).data('product-id');
    var slug = $(this).data('product-slug');
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>rated_products/get_images",
      dataType : "JSON",
      data : {id:product_ID},
      success: function(data){
        var html = '';
        var i;
        for(i=0; i<data.length; i++){
          html += '<img src="<?php echo base_url();?>assets/img/rated-products/'+slug+'/'+data[i].image+'" class="img-thumbnail" style="width: 200px">';
        }
        $('#product_images').modal('show');
        $('#image_list').html(html);
      }
    });
  });
});
</script>