<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <section class="card wow fadeIn mb-4" style="background-image: url(<?php echo base_url();?>assets/img/bg4.jpg);background-attachment: fixed; background-position: center; background-repeat: no-repeat; background-size: cover; height: 300px;">
    <div class="card-body text-white text-center py-5 px-5 my-5">
      <h1 class="mb-4">
        <strong>Tools</strong>
      </h1>
    </div>
  </section>
  <section>
    <div class="row justify-content-center mb-4">
      <div class="col-md-3">
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
      <div class="col-md-3">
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
      <div class="col-md-3">
        <h2 class="mb-4">
          <strong>BEP ROAS Calculator </strong>
        </h2>
        <div class="news-data">
          <div class="form-group">
            <label for="aliexpress_cost">Selling Price</label>
            <input type="number" class="form-control bep_roas_calculator" id="bep_roas_selling_price">
          </div>
          <div class="form-group">
            <label for="aliexpress_cost">Shipping Price</label>
            <input type="number" class="form-control bep_roas_calculator" id="bep_roas_shipping_roas">
          </div>
          <div class="form-group">
            <label for="shipping_cost">BEP</label>
            <input type="number" class="form-control bep_roas_calculator" id="bep_roas_bep">
          </div>
          <div class="form-group">
            <label for="bep">BEP ROAS</label>
            <input type="number" class="form-control bep_roas_calculator" id="bep_roas" disabled>
          </div>
        </div>
      </div><!--Column-->
      <div class="col-md-3">
        <h2 class="mb-4">
          <strong>Total Profit Calculator </strong>
        </h2>
        <div class="news-data">
          <div class="form-group">
            <label for="aliexpress_cost">Total Revenue</label>
            <input type="number" class="form-control profit_calculator" id="total_revenue">
          </div>
          <div class="form-group">
            <label for="aliexpress_cost">Total Expenses</label>
            <input type="number" class="form-control profit_calculator" id="total_expenses">
          </div>
          <div class="form-group">
            <label for="bep">Your Profit</label>
            <input type="number" class="form-control profit_calculator" id="profit" disabled>
          </div>
        </div>
      </div><!--Column-->
    </div><!--Grid row-->
    <div class="row justify-content-center">
      <div class="col-lg-12">
        <h2 class="mb-4 text-center">
          <strong>Facebook Kill Scale Calculator</strong>
        </h2>
        <div class="card mb-4">
        <div class="card-body">
          <table class="table table-bordered display" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>Reporting starts</th>
                <th>Reporting ends</th>
                <th>Ad set name</th>
                <th>Results</th>
                <th>Results indicator</th>
                <th>Cost per results</th>
                <th>Ad set budget</th>
                <th>Ad set budget type</th>
                <th>Amount spent (AUD)</th>
                <th>Landing page views</th>
                <th>Cost per landing page views</th>
                <th>CPM (cost per 1000 impressions) (AUD)</th>
                <th>Frequency</th>
              </tr>
            </thead>
            <tbody id="fb_results">
            </tbody>
          </table>
          <form id="import_csv" enctype="multipart/form-data">
          <label for="fb_bep">Facebook ad set csv</label>
          <div class="input-group mb-4">
            <div class="input-group-prepend">
              <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
            </div>
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="facebook_csv" aria-describedby="inputGroupFileAddon01" name="facebook_csv">
              <label class="custom-file-label" for="facebook_csv">Choose file</label>
            </div>
          </div>
          <div class="form-group">
            <label for="fb_bep">Your BEP</label>
            <input type="number" class="form-control" id="fb_bep" name="fb_bep" required>
          </div>
          <button class="btn btn-primary btn-sm float-right" type="submit" id="submit_add">Submit</button>
          </form>
        </div><!--Card Body-->
      </div><!--Card-->
    </div>
      </div><!--Grid column-->
    </div><!--Grid row-->
     <div class="row justify-content-center">
      <div class="col-lg-12">
        <h2 class="mb-4 text-center">
          <strong>Rated Products Library</strong>
        </h2>
        <nav class="navbar navbar-expand-lg navbar-dark mt-3 mb-4">
          <span class="navbar-brand text-dark">Search</span>
          <button class="navbar-toggler text-dark" type="button" data-toggle="collapse" data-target="#basicExampleNav"
            aria-controls="basicExampleNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars text-dark"></i>
          </button>
          <div class="collapse navbar-collapse" id="basicExampleNav">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item">
                <?php echo form_open('tools'); ?>
                <div class="input-group ml-2 mt-1">
                  <input class="form-control form-control-sm" type="text" placeholder="Search" aria-label="Search" name="tools">
                  <div class="input-group-prepend">
                    <button class="btn btn-light btn-sm m-0 px-3 py-2 z-depth-0" type="submit"><i class="fas fa-search"></i></button>
                  </div>
                </div>
                <?php echo form_close(); ?>
              </li>
            </ul>
          </div>
        </nav>
        <div class="row">
          <?php foreach ($products as $product) { ?>
          <div class="col-lg-3 col-md-3 col-sm-6 products"> 
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
                <button type="button" class="btn btn-outline-indigo btn-rounded btn-sm px-1 waves-effect view_more" data-product-id="<?php echo $product['id']; ?>" data-product-description="<?php echo $product['description']; ?>" data-product-slug="<?php echo $product['slug']; ?>" data-product-name="<?php echo $product['name']; ?>" data-product-url="<?php echo $product['url']; ?>">View Details</button>

              </div>
            </div><!-- Card -->
          </div>
          <?php } ?>
        </div>
          <div class="text-center">
            <a class="blue-text load_more">View More</a>
          </div>
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
            <a class="ml-xl-0 ml-4 mb-4" id="product_url" href="" target="_blank">Go to URL</a>
            <div class="font-weight-normal mt-4">
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
    var product_url = $(this).data('product-url');
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>rated_products/get_images",
      dataType : "JSON",
      data : {id:product_ID},
      success: function(data){
        var html = '';
        var i;
        for(i=0; i<data.length; i++){
          if(i == 0){
            html += '<a rel="gallery-1" href="<?php echo base_url(); ?>assets/img/rated-products/'+product_slug+'/'+data[i].image+'" class="swipebox"><img src="<?php echo base_url(); ?>assets/img/rated-products/'+product_slug+'/'+data[i].image+'" class="img-fluid img-thumbnail"></a><div class="d-flex">';
          } else {
            html += '<a rel="gallery-1" href="<?php echo base_url(); ?>assets/img/rated-products/'+product_slug+'/'+data[i].image+'" class="swipebox"><img src="<?php echo base_url(); ?>assets/img/rated-products/'+product_slug+'/'+data[i].image+'" class="img-fluid img-thumbnail" style="width: 200px;"></a>';
          }
          if((i + 1) == (data.length)){
            html += '</div>';
          }
        }
        $('#product_images').html(html);
        $('#product_name').text(product_name);
        $('#product_description').text(product_description);
        $('#product_url').attr("href", product_url);
      }
    });
  });

  var start = 10;
  <?php 
  if(empty($product_name)){
    $product_name = NULL;
  }
  ?>
  var product_name = '<?php echo $product_name; ?>';
  $(document).on("click", ".load_more", function() { 
    $.ajax({
      url: "<?=base_url()?>rated_products/load_more",
      type: 'post',
      data: {start:start, product_name:product_name},
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
    if(aliexpress_cost <= 10){
      var min_price = (aliexpress_cost+average_shipping - shipping_cost) + 14;
      var max_price = min_price + 5;
    } else if(aliexpress_cost >= 11 && aliexpress_cost <= 15){
      var min_price = (aliexpress_cost+average_shipping - shipping_cost) + 16;
      var max_price = min_price + 5;
    } else if(aliexpress_cost >= 16 && aliexpress_cost <= 20){
      var min_price = (aliexpress_cost+average_shipping - shipping_cost) + 19;
      var max_price = min_price + 10;
    } else if(aliexpress_cost >= 21 && aliexpress_cost <= 30){
      var min_price = (aliexpress_cost+average_shipping - shipping_cost) + 24;
      var max_price = min_price + 10;
    } else if(aliexpress_cost > 30){
      var min_price = (aliexpress_cost+average_shipping - shipping_cost) + (aliexpress_cost);
      var max_price = min_price;
    }
    $('#min_price').val(parseFloat(min_price));
    $('#max_price').val(parseFloat(max_price));
  }); 

  $(document).on('blur', ".bep_calculator", function(){
    var cost = Number($('#bep_aliexpress_cost').val());  
    var selling_price = Number($('#bep_selling_price').val());  
    var price = (selling_price-cost);
    $('#bep').val(parseFloat(price));
  }); 

  $(document).on('blur', ".bep_roas_calculator", function(){
    var selling = Number($('#bep_roas_selling_price').val());
    var shipping = Number($('#bep_roas_shipping_roas').val());
    var bep = Number($('#bep_roas_bep').val());  
    var price = ((selling+shipping)) / bep;
    $('#bep_roas').val(parseFloat(price));
  }); 

  $(document).on('blur', ".profit_calculator", function(){
    var total_revenue = Number($('#total_revenue').val());
    var total_expenses = Number($('#total_expenses').val());
    var profit = total_revenue - total_expenses;
    $('#profit').val(parseFloat(profit));
  }); 

    $(document).on('click', "#submit_add", function(){
    event.preventDefault();
    var myform = document.getElementById("import_csv");
    var fd = new FormData(myform);
    var fb_bep =  Number($('#fb_bep').val());  
    $.ajax({
      url:"<?php echo base_url(); ?>tools/import",
      method:"POST",
      data: fd,
      contentType:false,
      cache:false,
      processData:false,
      enctype: 'multipart/form-data',
      dataType : 'json',
      success:function(url){
        var html = ''
        var i;
        for(i=0; i<url.length; i++){
          if(fb_bep < url[i]['Cost per results']){
            var results = '<span class="badge badge-pill badge-danger">Kill</span>';
          } else {
            var results = '<span class="badge badge-pill badge-success">Keep</span>';
          }
          html += '<tr>';
          html += '<td>'+url[i]['Reporting starts']+'</td>';
          html += '<td>'+url[i]['Reporting ends']+'</td>';
          html += '<td>'+url[i]['Ad set name']+'</td>';
          html += '<td>'+results+'</td>'
          html += '<td>'+url[i]['Results indicator']+'</td>';
          html += '<td>'+url[i]['Cost per results']+'</td>';
          html += '<td>'+url[i]['Ad set budget']+'</td>';
          html += '<td>'+url[i]['Ad set budget type']+'</td>';
          html += '<td>'+url[i]['Amount spent (AUD)']+'</td>';
          html += '<td>'+url[i]['Landing page views']+'</td>';
          html += '<td>'+url[i]['Cost per landing page views']+'</td>';
          html += '<td>'+url[i]['CPM (cost per 1,000 impressions) (AUD)']+'</td>';
          html += '<td>'+url[i]['Frequency']+'</td>';
          html += '</tr>';
        }
        $('#fb_results').html(html);
      }
    })
  });
});
</script>