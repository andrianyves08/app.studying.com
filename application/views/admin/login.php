<div class="container">
<section class="p-3 my-md-3 text-center">
  <div class="row">
    <div class="col-md-5 mx-auto wow fadeInUp">
      <div class="card">
        <div class="card-body">
        <?php echo form_open('admin/login'); ?> 
          <img alt="Logo" src="<?php echo base_url(); ?>assets/img/logo.png" class="img-fluid wow rotateIn slow mb-4">
          <p>v1.7.47 <a class="blue-text" data-toggle="modal" data-target="#basicExampleModal">changelog</a></p><h3 class="font-weight-bold pb-2 text-center dark-grey-text"><strong>Administrator</strong></h3>
          <input type="text" id="email" name="email" placeholder="Email" class="form-control mb-4">
          <input type="password" id="password" name="password" class="form-control mb-4" placeholder="Password">
          <div class="text-center">
            <button type="submit" name="login" class="btn btn-primary btn-rounded my-4 waves-effect">Login</button>
          </div>
          <?php echo form_close(); ?>
        </div><!--Card Body-->
      </div><!--Card-->
    </div><!--Column-->
  </div><!--Row-->
</section>
<?php echo validation_errors(); ?>
</div><!--Container-->
<!-- Modal -->
<div class="modal fade" id="basicExampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Updates</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body ml-4">
        <ul>
          <li>Fixed outside click in modules</li>
          <li>Fixed logout button</li>
          <li>Fixed responsive home page images</li>
          <li>Added logs</li>
          <li>Added ratings/feedback section</li>
          <li>Fixed user's navigation list of purchases</li>
          <li>Fixed autoplay music</li>
          <li>Fixed disappearing page after watching a video</li>
          <li>Fixed changing/updating background image/videos</li>
          <li>Readded create users in admin account</li>
          <li>Readded user's products in admin account</li>
          <li>Added last video watched</li>
          <li>Fixed search button</li>
          <li>Fixed doubling navigation</li>
          <li>Stays logged-in even when browser is closed</li>
          <li>Added User Tracker, and more styling options for creating content</li>
          <li>Added create reviews</li>
          <li>Added create blogs and articles</li>
          <li>Added terms and conditions</li>
          <li>Added privacy policy</li>
          <li>Updated default password to studying</li>
        </ul>
      </dv>
    </div>
  </div>
</div>