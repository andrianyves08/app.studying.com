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
            <div class="form-group">
              <label for="formGroupExampleInput">* URL</label>
              <input type="text" class="form-control" name="url" value="<?php echo $product['url']; ?>">
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