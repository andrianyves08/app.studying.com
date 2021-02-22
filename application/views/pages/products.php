<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <section class="card wow fadeIn mb-4" style="background-image: url(<?php echo base_url();?>assets/img/bg4.jpg);background-attachment: fixed; background-position: center; background-repeat: no-repeat; background-size: cover; height: 300px;">
    <div class="card-body text-white text-center py-5 px-5 my-5">
      <h1 class="mb-4">
        <strong>Rated Products</strong>
      </h1>
    </div>
  </section>
  <section>
    <div class="row justify-content-center">
      <div class="col-md-4">
        <h2 class="mb-4">
          <strong>Pricing Calculator </strong>
        </h2>
        <div class="news-data">
          <div class="form-group">
            <label for="aliexpress_cost">Aliexpress Cost</label>
            <input type="number" class="form-control pricing_calculator" id="aliexpress_cost">
          </div>
          <div class="form-group">
            <label for="average_shipping">Average Aliexpress Shipping</label>
            <input type="number" class="form-control pricing_calculator" id="average_shipping">
          </div>
          <div class="form-group">
            <label for="shipping_cost">Your Shipping Cost</label>
            <input type="number" class="form-control pricing_calculator" id="shipping_cost">
          </div>
          <div class="form-group">
            <label for="price">Minimum Price</label>
            <input type="number" class="form-control" id="min_price" disabled>
          </div>
          <div class="form-group">
            <label for="price">Maximum Price</label>
            <input type="number" class="form-control" id="max_price" disabled>
          </div>
        </div>
      </div><!--Column-->
      <div class="col-md-4">
        <h2 class="mb-4">
          <strong>BEP Calculator </strong>
        </h2>
        <div class="news-data">
          <div class="form-group">
            <label for="aliexpress_cost">Aliexpress Cost</label>
            <input type="number" class="form-control bep_calculator" id="bep_aliexpress_cost">
          </div>
          <div class="form-group">
            <label for="shipping_cost">Your Selling Price</label>
            <input type="number" class="form-control bep_calculator" id="bep_selling_price">
          </div>
          <div class="form-group">
            <label for="bep">BEP</label>
            <input type="number" class="form-control bep_calculator" id="bep" disabled>
          </div>
        </div>
      </div><!--Column-->
    </div><!--Grid row-->
     <div class="row justify-content-center">
      <div class="col-md-8">
        <h2 class="mb-4 text-center">
          <strong>Facebook Kill Scale</strong>
        </h2>
        <div class="news-data">
          <div class="form-group">
            <label for="aliexpress_cost">Aliexpress Cost</label>
            <input type="number" class="form-control bep_calculator" id="bep_aliexpress_cost">
          </div>
          <div class="form-group">
            <label for="shipping_cost">Your Selling Price</label>
            <input type="number" class="form-control bep_calculator" id="bep_selling_price">
          </div>
          <div class="form-group">
            <label for="bep">BEP</label>
            <input type="number" class="form-control bep_calculator" id="bep" disabled>
          </div>
        </div>
      </div><!--Column-->
    </div><!--Grid row-->
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <nav class="navbar navbar-expand-lg navbar-dark mt-3 mb-4">
          <span class="navbar-brand text-dark">Categories:</span>
          <button class="navbar-toggler text-dark" type="button" data-toggle="collapse" data-target="#basicExampleNav"
            aria-controls="basicExampleNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars text-dark"></i>
          </button>
          <div class="collapse navbar-collapse" id="basicExampleNav">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item">
                <a class="nav-link waves-effect text-dark" href="<?php base_url();?><?php if(!empty($category_slug)){ echo 'all'; }else{ echo 'rated-products'; } ?>">
                 <strong>All</strong>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle waves-effect waves-light text-dark" id="category" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <?php 
                    if(empty($category_slug)){
                      echo 'Category';
                    } else {
                      echo $category_name['name'];
                    }
                  ?>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-default" aria-labelledby="category" id="dropdown_category">
                  <?php foreach($categories as $category){ ?>
                  <a class="dropdown-item waves-effect waves-light" href="<?php echo base_url().'rated-products/'.$category['slug']; ?>"><?php echo $category['name']; ?></a>
                <?php } ?>
                </div>
              </li>
            </ul>
<!--             <form class="form-inline">
              <div class="md-form my-0">
                <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
              </div>
            </form> -->
          </div>
        </nav>
        <div class="row">
          <?php if(!empty($category_slug)){?>
          <?php foreach ($product_categories as $product_categories) { ?>
          <?php foreach ($products as $product) { ?>
            <?php if ($product['id'] == $product_categories['product_ID']) { ?>
          <div class="col-lg-3 col-md-4 col-sm-6 products"> 
            <div class="card text-center mb-4">
              <div class="view overlay">
                <?php foreach ($images as $image) {
                  if($image['product_ID'] == $product['id']){ ?>
                <img class="card-img-top chat-mes-id-3" src="<?php echo base_url(); ?>assets/img/products/<?php echo $product['slug'].'/'.$image['image']; ?>"
                  alt="Card image cap">
                <a href="#!">
                  <div class="mask rgba-white-slight"></div>
                </a>
                <?php break;}} ?>
              </div>
              <div class="card-body">
                <p class="mb-1"><a href="" class="font-weight-bold black-text"><?php echo $product['name']; ?></a></p>
                <div class="amber-text fa-xs mb-1">
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
                </div> 
                <button type="button" class="btn btn-outline-indigo btn-rounded btn-sm px-1 waves-effect view_more" data-product-id="<?php echo $product['id']; ?>" data-product-description="<?php echo $product['description']; ?>" data-product-slug="<?php echo $product['slug']; ?>" data-product-name="<?php echo $product['name']; ?>">View Details</button>

              </div>
            </div><!-- Card -->
          </div>
          <?php } } } ?>
           <?php } else { ?>
          <?php foreach ($products as $product) { ?>
          <div class="col-lg-3 col-md-4 col-sm-6 products"> 
            <div class="card text-center mb-4">
              <div class="view overlay">
                <?php foreach ($images as $image) {
                  if($image['product_ID'] == $product['id']){ ?>
                <img class="card-img-top chat-mes-id-3" src="<?php echo base_url(); ?>assets/img/rated-products/<?php echo $product['slug'].'/'.$image['image']; ?>"
                  alt="Card image cap">
                <a href="#!">
                  <div class="mask rgba-white-slight"></div>
                </a>
                <?php break;}} ?>
              </div>
              <div class="card-body">
                <p class="mb-1"><a href="" class="font-weight-bold black-text"><?php echo $product['name']; ?></a></p>
                <div class="amber-text fa-xs mb-1">
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
                </div> 
                <button type="button" class="btn btn-outline-indigo btn-rounded btn-sm px-1 waves-effect view_more" data-product-id="<?php echo $product['id']; ?>" data-product-description="<?php echo $product['description']; ?>" data-product-slug="<?php echo $product['slug']; ?>" data-product-name="<?php echo $product['name']; ?>">View Details</button>

              </div>
            </div><!-- Card -->
          </div>
          <?php } } ?>
        </div>
        <?php if(empty($category_slug)){ ?>
          <div class="text-center">
            <a class="blue-text load_more">View More</a>
          </div>
        <?php } ?>
      </div><!--Grid column-->
    </div><!--Grid row-->
  </section><!--Section: Content-->
</div><!--Container-->
</main>

<!-- View Image -->
<div class="modal fade" id="view_more" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="heading lead">Product Details</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-7 mb-2" id="product_images">
            
          </div>
          <div class="col-lg-5 text-center text-md-left">
            <h2 class="h2-responsive text-center text-md-left product-name font-weight-bold dark-grey-text mb-1 ml-xl-0 ml-4" id="product_name"></h2>
            <div class="mb-2" id="product_categories"></div>
            <div class="font-weight-normal">
              <p class="ml-xl-0 ml-4" id="product_description"></p>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</a>
      </div>
    </div>
  </div>
</div>
<!-- View Image-->

<script type="text/javascript">
  $('.swipebox').swipebox();
</script>
<script>
$(document).ready(function(){
  $(document).on("click", ".view_more", function() { 
    $('#view_more').modal('show');
    var product_ID = $(this).data('product-id');
    var product_slug = $(this).data('product-slug');
    var product_description = $(this).data('product-description');
    var product_name = $(this).data('product-name');
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>rate_products/get_images",
      dataType : "JSON",
      data : {id:product_ID},
      success: function(data){
        var html = '';
        var i;
        for(i=0; i<data.length; i++){
          if(i == 0){
            html += '<a rel="gallery-1" href="<?php echo base_url(); ?>assets/img/rate-products/'+product_slug+'/'+data[i].image+'" class="swipebox"><img src="<?php echo base_url(); ?>/assets/img/rate-products/'+product_slug+'/'+data[i].image+'" class="img-fluid img-thumbnail"></a><div class="d-flex">';
          } else {
            html += '<a rel="gallery-1" href="<?php echo base_url(); ?>assets/img/rate-products/'+product_slug+'/'+data[i].image+'" class="swipebox"><img src="<?php echo base_url(); ?>/assets/img/rate-products/'+product_slug+'/'+data[i].image+'" class="img-fluid img-thumbnail" style="width: 200px;"></a>';
          }
          if((i + 1) == (data.length)){
            html += '</div>';
          }
        }
        $('#product_images').html(html);
        $('#product_name').text(product_name);
        $('#product_description').text(product_description);
      }
    });
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>rate_products/get_product_categories",
      dataType : "JSON",
      data : {id:product_ID},
      success: function(data){
        var html = '';
        var i;
        for(i=0; i<data.length; i++){
          html += '<a href="<?php echo base_url().'rated-products';?>/'+data[i].slug+'" <span class="badge badge-default badge-pill ml-2"><i class="fas fa-tag text-white" aria-hidden="true"></i> '+data[i].name+'</span></a>';
        }
        $('#product_categories').html(html);
      }
    });
  });

  var start = 10;
  <?php 
  if(empty($category_slug)){
    $category_slug = NULL;
  }
  ?>
  var category_slug = '<?php echo $category_slug; ?>';
  $(document).on("click", ".load_more", function() { 
    $.ajax({
        url: "<?=base_url()?>rate_products/load_more",
        type: 'post',
        data: {start:start, category_slug:category_slug},
        beforeSend:function(){
          $(".load_more").text("Loading...");
        },
        success: function(response){
          $(".products:last").after(response).show().fadeIn("slow");
          $(".load_more").text("View more");
          start = start + 10;
          if(!$.trim(response)) {
            $(".load_more").hide();
          }
        }
    });
  });
});
</script>
<script type="text/javascript">
$(document).ready(function(){
  $(document).on('blur', ".pricing_calculator", function(){
      var aliexpress_cost = Number($('#aliexpress_cost').val());  
      var average_shipping = Number($('#average_shipping').val());  
      var shipping_cost = Number($('#shipping_cost').val());
      // if(aliexpress_cost <= 10){
        var min_price = (aliexpress_cost+average_shipping - shipping_cost) + 15;
        var max_price = min_price + 5;
      // } else if(aliexpress_cost >= 10 && aliexpress_cost <= 15){
      //   var min_price = (aliexpress_cost+average_shipping) - (shipping_cost + 17);
      // } else if(aliexpress_cost >= 15 && aliexpress_cost <= 20){
      //  } else if(aliexpress_cost >= 20 && aliexpress_cost <= 30){
      //   var min_price = (aliexpress_cost+average_shipping) - (shipping_cost + 35);
      // } else if(aliexpress_cost >= 30){
      //   var min_price = (aliexpress_cost+average_shipping) - (shipping_cost + (aliexpress_cost*2));
      // }
      $('#min_price').val(parseFloat(min_price));
      $('#max_price').val(parseFloat(max_price));
  }); 

  $(document).on('blur', ".bep_calculator", function(){
      var cost = Number($('#bep_aliexpress_cost').val());  
      var selling_price = Number($('#bep_selling_price').val());  
      var price = (cost-selling_price);
      $('#bep').val(parseFloat(price));
  }); 
});
</script>