<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <div class="card mb-4 wow fadeIn">
    <div class="card-body d-sm-flex justify-content-between">
      <h4 class="mb-2 mb-sm-0 pt-1">
        <span><a href="<?php echo base_url();?>admin">Home</a></span>
        <span>/</span>
        <span><a href="<?php echo base_url();?>admin/reviews">Reviews</a></span>
        <span>/</span>
        <span><?php echo ucwords($reviews['reviewers_name']);?></span>
      </h4>
    </div>
  </div>
  <!-- Heading -->

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <?php echo form_open_multipart('reviews/update'); ?>
          <div class="form-group">
            <label for="formGroupExampleInput">* Title</label>
            <input type="text" class="form-control" required value="<?php echo ucwords($reviews['title']);?>" name="title">
            <input type="hidden" class="form-control" value="<?php echo $reviews['id'];?>" name="review_ID">
          </div>
          <div class="form-group">
            <label for="formGroupExampleInput">* Full Name</label>
            <input type="text" class="form-control" required value="<?php echo ucwords($reviews['reviewers_name']);?>" name="name">
          </div>
          <div class="form-group">
            <label for="formGroupExampleInput">Testimonial</label>
            <input type="text" class="form-control"  value="<?php echo ucwords($reviews['testimonial']);?>" name="testimonial">
          </div>
          <div class="form-row mb-4">
            <div class="col">
              <label for="formGroupExampleInput">Niche</label>
              <input type="text" class="form-control" value="<?php echo ucwords($reviews['niche']);?>" name="niche">
            </div>
            <div class="col">
              <label for="formGroupExampleInput">* Location</label>
              <input type="text" class="form-control" required value="<?php echo ucwords($reviews['location']);?>" name="location">
            </div>
          </div>
          <div class="form-group">
            <label for="date">* Date</label>
            <input class="form-control" type="date" value="<?php echo date($reviews['date']);?>" id="date" name="date" required>
          </div>
          <div class="form-row mb-4">
            <div class="col">
              <label for="formGroupExampleInput">* Video URL</label>
              <input type="text" required value="<?php echo ucwords($reviews['url']);?>" name="url" class="form-control">
            </div>
            <div class="col">
              <label for="formGroupExampleInput">* Rating</label>
              <input type="number" required value="<?php echo ucwords($reviews['rating']);?>" name="rating" class="form-control" min="0" max="5">
            </div>
          </div>
          <label for="formGroupExampleInput">* Description</label>
          <textarea class="textarea mb-4" required name="description" id="description" placeholder="Place some text here" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo ucwords($reviews['description']);?></textarea>
          <button class="btn btn-outline-primary waves-effect " type="submit">Save Changes</button>
          <?php echo form_close(); ?>
        </div><!--Card Body-->
      </div><!--Card-->
    </div><!--Column-->
  </div><!--Row-->
</div><!--Container-->
</main><!--Main laypassed out-->