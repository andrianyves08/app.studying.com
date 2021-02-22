<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <div class="card mb-4 wow fadeIn">
    <!--Card content-->
    <div class="card-body d-sm-flex justify-content-between">
      <h4 class="mb-2 mb-sm-0 pt-1">
        <span><a href="<?php echo base_url();?>admin">Home</a></span>
        <span>/</span>
        <span><a href="<?php echo base_url(); ?>products">Products</a></span>
        <span>/</span>
        <span><?php echo ucwords($product['name']); ?></span>
      </h4>
    </div>
  </div>
    <!-- Heading -->
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <?php echo form_open_multipart('rated_products/update'); ?>
            <div class="form-group">
              <label for="formGroupExampleInput">* Name</label>
              <input type="text" class="form-control" name="name" id="name" value="<?php echo $product['name']; ?>">
              <input type="hidden" class="form-control" name="old_name" id="old_name" value="<?php echo $product['name']; ?>">
              <input type="hidden" class="form-control" name="product_ID" id="product_ID" value="<?php echo $product['id']; ?>">
            </div>
            <div class="form-group">
              <label for="formGroupExampleInput">* Description</label>
              <input type="text" class="form-control" name="description" id="description" value="<?php echo $product['description']; ?>">
            </div>
            <div class="form-group">
              <label for="formGroupExampleInput">* Rating</label>
              <input type="number" class="form-control" name="rating" min="0" max="10" value="<?php echo $product['rating']; ?>">
            </div>
            <label for="formGroupExampleInput">* Category</label>
            <div class="input-group mb-4">
              <select class="browser-default custom-select" id="select_category" name="category[]" required>
                <?php foreach($categories as $category){ 
                  if($category['type'] == 1){
                ?> 
                  <option value="<?php echo $category['id']; ?>" selected><?php echo $category['name']; ?></option>
                <?php } } ?>
              </select>
              <div class="input-group-append">
                <a class="btn btn-md btn-outline-primary m-0 px-3 py-2 z-depth-0 waves-effect" type="button" data-toggle="modal" data-target="#create_category">Create New Category</a>
              </div>
            </div>
            <label for="formGroupExampleInput">* Sub Category</label>
            <div class="form-group mb-4">
              <select class="browser-default custom-select select2" name="category[]" id="select_sub_category" multiple="multiple" data-placeholder="Select sub category" required style="width: 100%">
                <?php foreach($categories as $category){ 
                  if($category['type'] == 2){
                ?> 
                  <option value="<?php echo $category['id']; ?>" selected><?php echo $category['name']; ?></option>
                <?php } } ?>
              </select>
            </div>
            <label for="image">* Photos</label>
            <br>
            <?php  
            foreach($images as $image){ 
               if($image === end($images)) {
                  $last = $image['id']+1;
                  echo '<input type="hidden" id="last_image" value="'.$image['image'].'">';
                  echo '<input type="hidden" id="last_product_ID" value="'.$last.'">';
                }
            ?> 
              <div class="images">
                <div id="image_<?php echo $image['id'];?>">
                <img src="<?php echo base_url().'assets/img/rated-products/'.$product['slug'].'/'.$image['image']; ?>" class="img-thumbnail" style="width: 200px">
                <a class="red-text mr-1 delete_image" data-product-slug="<?php echo $product['slug'];?>" data-image-id="<?php echo $image['id'];?>" data-image-name="<?php echo $image['image'];?>"><i class="fas fa-times"></i></a>
                </div>
              </div>
            <?php } ?>
            <div id="body_bottom" class="image_textarea" style="display: none;">
              <img class="img-thumbnail" id="preview" style="width: 200px"/>
            </div>
            <br>
            <input type="file" onchange="readURL(this);" style="display:none;" name="post_image" id="post_image">
            <button type="button" class="btn btn-link uploadTrigger" id="uploadTrigger" data-textarea-id="0"><i class="fas fa-photo-video mr-2 green-text"></i>Add Photo</button>
            <button class="btn btn-primary waves-effect " type="submit">Save Changes</button>
          <?php echo form_close(); ?>
        </div><!--Card Body-->
      </div><!--Card-->
    </div><!--Column-->
  </div><!--Row-->
</div><!--Container-->
</main><!--Main laypassed out-->
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
        <div class="custom-control custom-radio">
          <input type="radio" class="custom-control-input category_type" id="main_category" name="type" value="1">
          <label class="custom-control-label" for="main_category">Main Category</label>
        </div>
        <div class="custom-control custom-radio">
          <input type="radio" class="custom-control-input category_type" id="sub_category" name="type" value="2">
          <label class="custom-control-label" for="sub_category">Sub Category</label>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button class="btn btn-primary waves-effect btn-sm float-right" type="submit" id="add_category">Create</button>
      </div>
    </div>
  </div>
</div>
<!-- Create Category-->
<script type="text/javascript">
 
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.readAsDataURL(input.files[0]);
      uploadImage(input.files[0]);
    }
  }

  function uploadImage(image) {
    var slug = '<?php echo $product['slug']; ?>';
    var last = $('#last_image').val();
    var last_product_ID = $('#last_product_ID').val();
    var product_ID = $('#product_ID').val();
    var data = new FormData();
    data.append("image", image);
    $.ajax({
      url: "<?php echo base_url('rated_products/upload_image')?>/"+slug+'/'+last+'/'+product_ID,
      cache: false,
      contentType: false,
      processData: false,
      data:data,
      type: "POST",
      success: function(url) {
        if(!url){
          $('#preview').removeAttr('src');
          toastr.error('Invalid image type');
        } else{
          toastr.success('Image added');
          $('#last_image').val(url);
          var html = '';
          html += '<div id="image_'+last_product_ID+'"><img src="<?php echo base_url(); ?>assets/img/rated-products/'+slug+'/'+url+'" class="img-thumbnail" style="width: 200px"><a class="red-text mr-1 delete_image" data-product-slug="<?php echo $product['slug'];?>" data-image-name="'+$.trim(url)+'" data-image-id="'+last_product_ID+'"><i class="fas fa-times"></i></a></div>';
          $(".images:last").after(html).show().fadeIn("slow");
        }
      },
      error: function(data) {
        console.log(data);
      }
    });
  }
</script>
<script>
$(document).ready(function(){
  $('#uploadTrigger').click(function(){
    $("#post_image").click();
  });

  get_category();
  function get_category(){
    $.ajax({
      type  : 'POST',
      url   : "<?=base_url()?>rated_products/get_category",
      async : true,
      dataType : 'json',
      success : function(data){
        var i;
        for(i=0; i<data.length; i++){
          if(data[i].type == 1 && $('#select_category option[value='+data[i].id+']').length == 0){
            $('#select_category').append('<option value="'+data[i].id+'">'+data[i].name+'</option>');
          } else if(data[i].type == 2 && $('#select_sub_category option[value='+data[i].id+']').length == 0) {
            $('#select_sub_category').append('<option value="'+data[i].id+'">'+data[i].name+'</option>');
          }
        }
      }
    });
  }

  //Add member
  $('#add_category').on('click',function(){
    var name = $('#new_category').val();
    var type = $(".category_type:checked").val();
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>rated_products/create_category",
      dataType : "JSON",
      data : {name:name, type:type},
      success: function(data){
        if(data.error){
          toastr.error(data.message);
        } else {
          toastr.success('Category created');
          $('#create_category').modal('hide');
        }
        $('#new_category').val('');
        get_category();
      }
    });
    return false;
  });

  //Like post
  $(document).on('click', '.delete_image', function(){
    var image_ID = $(this).data('image-id');
    var product_slug = $(this).data('product-slug');
    var image_name = $(this).data('image-name');
    $.ajax({
      url:"<?=base_url()?>rated_products/image_delete",
      method:"POST",
      async : true,
      dataType : 'json',
      data:{image_ID:image_ID, product_slug:product_slug, image_name:image_name},
      success:function(data) {
        toastr.success('Image Deleted');
        $('#image_'+image_ID).remove();
      }
    })
  });
});
</script>