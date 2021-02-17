<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <section class="card" style="background-image: url(<?php echo base_url();?>assets/img/<?php echo $pages['background_image'];?>);background-attachment: fixed; background-position: center; background-repeat: no-repeat; background-size: cover; height: 300px;">
    <div class="card-body text-white text-center py-5 px-5 my-5">
      <h1 class="mb-4"><strong><?php echo ucwords($pages['name']);?></strong></h1>
      <p><strong>Every Dropshipping Questions</strong></p>
    </div>
  </section>
  <hr class="my-5">
  <section style="visibility: visible; animation-name: fadeIn;">
    <div class="row justify-content-center">
      <div class="col-md-7">
        <input class="form-control mb-4" id="listSearch" type="text" placeholder="Search" aria-label="Search">
        <div class="myList">
        <?php foreach ($categories as $category) { ?>
          <div class="mb-4 h-1">
            <h4 class="indigo-text text-center mt-4 pt-4"><?php echo ucwords($category['name']); ?></h4>
            <div class="accordion md-accordion accordion-blocks" id="accordion" role="tablist"
            aria-multiselectable="true">
            <?php foreach ($faqs as $faq) { ?>
              <?php if ($category['id'] == $faq['category_ID']) { ?>
                <div class="card h-1 mb-2">
                  <div class="card-header white mb-1" role="tab" id="heading1">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $faq['id'];?>" aria-expanded="true"
                    aria-controls="collapse<?php echo $faq['id'];?>">
                      <h5 class="mb-0 font-thin h-1 text-dark">
                      <?php echo ucfirst($faq['question']); ?> <i class="fas fa-angle-down rotate-icon"></i>
                      </h5>
                    </a>
                  </div><!--Card Header-->
                  <div id="collapse<?php echo $faq['id'];?>" class="collapse" role="tabpanel" aria-labelledby="heading1"
                  data-parent="#accordion">
                    <div class="card-body">
                      <?php echo $faq['answer']; ?>
                    </div>
                  </div><!--Accordion Panel-->
                </div><!--Card-->
              <?php } ?>
            <?php } ?>
            </div><!--Accordion wrapper-->
          </div><!--H-1-->
        <?php } ?>
        </div><!--My List-->
      </div><!--Grid column-->
    </div><!--Grid row-->
  </section><!--Section: Jumbotron-->
</div><!--Container-->
</main><!--Main layout-->
<script type="text/javascript">
$(document).ready(function(){
  $("#listSearch").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".myList .h-1").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
 }); 
</script>