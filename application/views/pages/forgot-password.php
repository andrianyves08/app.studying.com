<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Learn-Ecom Forgot Password</title>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
  <!-- Bootstrap core CSS -->
  <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
  <!-- Material Design Bootstrap -->
  <link href="<?php echo base_url(); ?>assets/css/mdb.min.css" rel="stylesheet">
  <!-- Your custom styles (optional) -->
  <link href="<?php echo base_url(); ?>assets/css/style.min.css" rel="stylesheet">
  <!-- Toastr -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/toastr/toastr.min.css">
  <!-- JQuery -->
  <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-3.4.1.min.js"></script>
  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/select2/css/select2.min.css">
  <link rel="icon" href="<?php echo base_url();?>assets/img/overlays/logo-1.png">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/plugins/fullpagescroll/fullpage.css" /> 
</head>
<style type="text/css">
* {
  margin: 0;
  padding: 0;
}
html, body {
  height: 100%;
  width: 100%;
  min-width: 100%;
}
body { 
  background: url("<?php echo base_url();?>assets/img/<?php if($title == 'Course'){ echo 'bg1.jpg'; } elseif ($title == 'Messages') { echo 'bg2.jpg'; } elseif ($title != 'Index') { echo 'bg4.jpg'; } else { echo 'NULL'; } ?>") no-repeat center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
  background-attachment: fixed;
  background-position: center;
  background-repeat: no-repeat;
  z-index: -200;
}
.video-overlay {
  position: fixed;
  height: 100%;
  width: 100%;
  background: #fff;
  z-index: -99;
  opacity: .85;
}
</style>
<body>
<div class="video-overlay"></div>
<div class="container">
  <section>
    <div class="row">
      <div class="col-md-5 mx-auto wow fadeIn pt-4 mt-4">
        <div class="card">
          <div class="card-body text-center">
            <?php echo form_open_multipart('email/send'); ?>
              <img alt="Logo" src="<?php echo base_url(); ?>assets/img/logo.png" class="img-fluid wow bounceInUp slow mb-4">
              <h2 class="mb-4">Reset Password</h2>
              <input type="email" id="email" name="email" placeholder="Enter your email." class="form-control mb-4">
              <div class="text-center">
                <button type="submit" name="login" class="btn btn-primary btn-rounded my-4 waves-effect">Send verification</button>
              </div>
            <?php echo form_close(); ?>
          </div><!--Card Body -->
        </div><!--Card -->
      </div><!--Column -->
    </div><!--Row -->
  </section>
  <?php echo validation_errors(); ?>
</div><!--Container -->