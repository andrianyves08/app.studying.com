<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <section class="card wow fadeIn" style="background-image: url(<?php echo base_url();?>assets/img/<?php echo $pages['background_image'];?>);background-attachment: fixed; background-position: center; background-repeat: no-repeat; background-size: cover; height: 300px;">
    <div class="card-body text-white text-center py-5 px-5 my-5">
      <h1 class="mb-4">
        <strong><?php echo ucwords($pages['name']);?></strong>
      </h1>
    </div>
  </section>
  <hr class="my-5">
  <section class="wow fadeIn" style="visibility: visible; animation-name: fadeIn;">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="news-data">
            <?php echo $pages['content'];?>
        </div>
      </div><!--Column-->
    </div><!--Row-->
  </section>
</div><!--Container-->
</main>