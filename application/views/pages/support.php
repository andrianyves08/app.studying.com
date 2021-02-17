<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <section class="card wow fadeIn" style="background-image: url(<?php echo base_url();?>assets/img/bg4.jpg);background-attachment: fixed; background-position: center; background-repeat: no-repeat; background-size: cover; height: 300px;">
    <div class="card-body text-white text-center py-5 px-5 my-5">
      <h1 class="mb-4">
        <strong>Report Bug / Support</strong>
      </h1>
      <p>
        <strong>We would love to assist you.</strong>
      </p>
      <p>
        <strong>Reporting us the bug that you encounter will help us improve the portal.</strong>
      </p>
    </div>
  </section>
  <hr class="my-5">
  <section class="wow fadeIn" style="visibility: visible; animation-name: fadeIn;">
    <div class="row justify-content-center">
      <div class="col-lg-8">
      <?php echo form_open_multipart('email/support'); ?>
        <div class="news-data">
          <div class="form-group">
            <textarea class="form-control rounded-0" name="message" id="message" rows="10" placeholder="Enter your message..."></textarea>
          </div>
          <button class="btn btn-primary waves-effect " type="submit">Send</button>
        </div><!--News-->
       <?php echo form_close(); ?>
      </div><!--Column-->
    </div><!--Row-->
  </section>
</div>
</main>