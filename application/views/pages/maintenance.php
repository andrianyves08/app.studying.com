<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Studying.com</title>
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
  overflow: hidden;
}
main {
  min-height: 100%;
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

p, h1, h2, h3, h4, h5, h6, label, td, dt, dd, li, span, tr{
  user-select: none; /* supported by Chrome and Opera */
  -webkit-user-select: none; /* Safari */
  -khtml-user-select: none; /* Konqueror HTML */
  -moz-user-select: none; /* Firefox */
  -ms-user-select: none; /* Internet Explorer/Edge */
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
<section>
  <div class="row">
    <div class="col-lg-5 mx-auto wow fadeIn pt-4 mt-4">
      <div class="jumbotron card card-image">
        <div class="text-dark text-center py-5 px-4">
           <img alt="Logo" src="<?php echo base_url(); ?>assets/img/logo.png" class="img-fluid wow bounceInUp slow mb-5">
          <div>
            <h2 class="card-title h1-responsive pt-3 mb-2 font-bold"><strong>Under Maintenance</strong></h2>
            <p class="mx-5 mb-5">Currently undergoing maintenance to serve you better. Come back later.
            </p>
            <a class="btn btn-outline-primary btn-md" href="https://www.studying.com"><i class="fas fa-globe left"></i> Studying.com</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>