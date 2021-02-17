<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Login Page - Log in to your account | Studying.com Portal</title>
  <meta name="description" content="Studying.com Portal" />
  <meta name="keywords" content="Studying.com Portal, dropshipping portal, learn dropshippning, easy dropshipping, portal studying.com, studying.com login page" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
  <!-- Bootstrap core CSS -->
  <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">
  <!-- Material Design Bootstrap -->
  <link href="<?php echo base_url();?>assets/css/mdb.min.css" rel="stylesheet">
  <!-- Your custom styles (optional) -->
  <link href="<?php echo base_url();?>assets/css/style.min.css" rel="stylesheet">
  <link rel="icon" href="<?php echo base_url();?>assets/img/overlays/logo-1.png">
  <!-- Toastr -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/toastr/toastr.min.css">  <!-- Toastr -->
<style type="text/css">
html,
body,
header,
.view {
  height: 100%;
}
.video-overlay {
  position: fixed;
  height: 100%;
  width: 100%;
  background: #ffffff;
  z-index: -99;
  opacity: .75;
}
#myVideo {
  object-fit: cover;
  object-position: center;
  position: fixed;
  height: 100%;
  width: 100%;
  z-index: -100;

}
p, h1, h2, h3, h4, h5, h6, label, td, dt, dd, li, span, tr{
  user-select: none; /* supported by Chrome and Opera */
  -webkit-user-select: none; /* Safari */
  -khtml-user-select: none; /* Konqueror HTML */
  -moz-user-select: none; /* Firefox */
  -ms-user-select: none; /* Internet Explorer/Edge */
}
</style>
</head>
<body>
<div class="video-overlay"></div>
<video class="video-intro" autoplay muted loop id="myVideo">
  <source src="<?php echo base_url();?>assets/img/videos/<?php echo $settings['login_video'];?>" type="video/mp4">
</video>  
<div class="view full-page-intro">
  <div class="mask d-flex justify-content-center align-items-center">
    <div class="container">
      <div class="row">
        <div class="col-md-6 mb-4 white-text text-center text-md-left wow fadeInLeft">
          <img src="<?php echo base_url();?>assets/img/<?php echo $settings['logo_img'];?>" class="img-fluid mb-4" alt="Responsive image">
          <p class="h4 mb-4 d-none d-md-block indigo-text">
            <strong>Dedicated to creating the most innovating educational experiences... ever.</strong>
          </p>
        </div> <!--Grid column-->
        <div class="col-md-6 col-xl-5 mb-4 wow fadeInRight">
          <div class="card">
            <div class="card-body">
              <?php echo form_open('login'); ?>
              <div class="dark-grey-text text-center mb-4">
                <p>v1.7.47 <!-- <a class="blue-text" data-toggle="modal" data-target="#basicExampleModal">changelog</a> --></p><h3 class="font-weight-bold pb-2 text-center dark-grey-text"></p><h3><strong>Login</strong></h3>
              </div>
              <label for="email"> <i class="fas fa-user prefix grey-text"></i> Your Email</label>
              <input type="email" id="email" class="form-control mb-4" name="email" required>
              <label for="form2"><i class="fas fa-envelope prefix grey-text"></i> Password</label>
              <input type="password" id="password" name="password" class="form-control mb-4" requied>
              <div class="text-center my-4">
                <button class="btn btn-primary">Login</button>
                 <a href="<?php echo base_url();?>forgot-password" class="ml-5">Forgot password?</a>
              </div>
              </form>
              <p class="text-center">Not a member? Visit <a href="https://www.studying.com">Studying.com</a></p>
            </div><!--Card Body-->
          </div><!--Card-->
        </div><!--Column-->
      </div><!--Row-->
    </div><!-- Container -->
  </div><!-- Mask & flexbox options-->
</div><!-- Full Page Intro -->
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-3.4.1.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="<?php echo base_url();?>assets/js/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="<?php echo base_url();?>assets/js/mdb.min.js"></script>
<!-- Initializations -->
<script type="text/javascript">
// Animations initialization
new WOW().init();
</script>
<script src="<?php echo base_url(); ?>assets/plugins/toastr/toastr.min.js"></script>
<script type="text/javascript">
$(function() {  
  <?php if($this->session->flashdata('success')): ?>
    <?php echo "toastr.success('".$this->session->flashdata('success')." ')"; ?>
  <?php endif; ?>
  <?php if($this->session->flashdata('error')): ?>
    <?php echo "toastr.error('".$this->session->flashdata('error')." ')"; ?>
  <?php endif; ?>  
});
</script>
<?php if($this->session->flashdata('multi')): ?>
  <?php echo $this->session->flashdata('multi'); ?>
<?php endif; ?>
</body>
</html>