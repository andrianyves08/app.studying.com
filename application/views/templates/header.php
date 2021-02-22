<!-- <?php error_reporting(0); ?> -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Studying.com <?php echo $title; ?></title>
  <link rel="icon" href="<?php echo base_url();?>assets/img/overlays/logo-1.png">
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
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/select2/css/select2.min.css">
  <!-- Lazyframe -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/lazyframe.css">
  <!-- Data Tables -->
  <link href="<?php echo base_url('/assets/admin/css/addons/datatables.min.css'); ?>" rel="stylesheet">
  <link href="<?php echo base_url('/assets/admin/css/addons/datatables-select.min.css'); ?>" rel="stylesheet">
  <!-- SlickJS -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/plugins/slick/slick.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/plugins/slick/slick-theme.css">
  <!-- Summernote -->
  <link rel="stylesheet" href="<?php echo base_url('/assets/plugins/summernote/summernote-bs4.css'); ?>">
  <link href="<?php echo base_url();?>assets/plugins/summernote/plugin/tam-emoji/css/emoji.css" rel="stylesheet">

  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-B5WLJ52MBS"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-B5WLJ52MBS', {
      'cookie_prefix': 'MyCookie',
      'cookie_domain': 'app.studying.com',
      'cookie_expires': 28 * 24 * 60 * 60,
      'user_id': '<?php echo $my_id;?>'  // 28 days, in seconds
    });
  </script>

  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/swipebox/src/css/swipebox.css">
  
<script src="<?php echo base_url();?>assets/plugins/swipebox/src/js/jquery.swipebox.js"></script>

</head>
<style type="text/css">
* {
  margin: 0;
  padding: 0;
}
html{
  font-size: 1em !important;
  font-family: Roboto !important;
}
html, body {
  height: 100%;
  width: 100%;
  min-width: 100%;
}
main {
  min-height: 100%;
}

<?php if($title != 'Home'){ ?>
body { 
  background: url("<?php echo base_url();?>assets/img/<?php echo $settings['background_image']; ?>") no-repeat center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
  background-attachment: fixed;
  background-position: center;
  background-repeat: no-repeat;
  z-index: -200;
}
<?php } ?> 
/* Style the video: 100% width and height to cover the entire window */
#myVideo {
  object-fit: cover;
  object-position: center;
  position: fixed;
  height: 100%;
  width: 100%;
  z-index: -100;
}

.navbar{
  background: #fff;
  <?php if($title == 'Home'){?>
    border: none !important;
    box-shadow: none !important;
  <?php } ?>
}
<?php if($title == 'Home'){?>
.navbar:not(.top-nav-collapse) {
  background: transparent;
}
<?php } ?>
.video-overlay {
  position: fixed;
  height: 100%;
  width: 100%;
  background: #fff;

  z-index: -99;
  opacity: .85;
}

#player{
  position:fixed;
  bottom:15px;
  right:15px;
  z-index: 10;
}

#volume {
  width: 50px;
}

.customsidenav {
  height: 100%;
  width: 0;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  overflow-x: hidden;
  transition: 0.5s;
  padding-top: 60px;
}

.customsidenav .closebtn {
  position: absolute;
  top: 0;
  right: 25px;
  font-size: 36px;
  margin-left: 50px;
}

#main {
  transition: margin-left .5s;
  padding: 16px;
}

@media screen and (max-height: 450px) {
  .customsidenav {padding-top: 15px;}
  .customsidenav a {font-size: 18px;}
}

img {
  image-rendering: auto;
}
.chat-mes-id {
  object-fit: cover;
  object-position: center;
  height: 50px;
  width: 50px;
}

.chat-mes-id-2 {
  object-fit: cover;
  object-position: center;
  height: 100%;
  width: 100%;
  image-rendering: pixelated;
}

.chat-mes-id-3 {
  object-fit: cover;
  object-position: center;
  height: 150px;
  width: 100%;
}

.customcolorbg{
  background-color: #459AD4;
}

::-webkit-scrollbar {
  width: 8px;
}

::-webkit-scrollbar-track {
  -webkit-box-shadow: inset 0 0 6px rgba(200,200,200,1);
  border-radius: 10px;
}

::-webkit-scrollbar-thumb {
  border-radius: 10px;
  background-color:#459AD4;
  -webkit-box-shadow: inset 0 0 6px rgba(90,90,90,0.7);
}

.customerheader{
  margin-top: 30px;
  position: absolute;
}

.active-purple input.form-control[type=text] {
  border-bottom: 1px solid #ce93d8;
  box-shadow: 0 1px 0 0 #ce93d8;
}

.slider {
  width: 90%;
  margin: 10px auto;
}

.slick-slide {
  margin: 0px 20px;
  <?php if($title == 'Modules'){ ?>
    height: 700px;
    overflow-y: auto;
  <?php } ?>
  outline: none;
}

.slick-slide img {
  width: 100%;
/*   height: 500px;
   overflow-y: auto;*/
}

.slick-prev:before,
.slick-next:before {
  color: black;
  background-color: transparent;
}


.slick-current {
  opacity: 1;
}

.flex-1 {
  flex: 1;
}

.custom_slider{
  float: left !important;
}

.border {
  border-width:3px !important;
  border-radius: 16px !important;
}

.preloader {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  width: 100%;
  background: #fff;
  position: fixed;
  top: 0;
  left: 0;
  z-index: 9999;
  opacity: 1;
  transform: opacity 1s linear;
}

.preloader.loaded{
  opacity: 0;
  pointer-events: none;
}

.hoverable_2:hover .sections{
  text-decoration: underline;
  background-color: #4E54C6;
}

.sections{
  border-radius: 15px !important;
}

<?php if($title == 'Modules'){?>
.card{
   border-radius: 15px !important;
}
<?php } ?>


.dropdown-toggle_2:after {
 display: none;
}

#dropdown_category {         
  max-height: 500px;
  overflow-y: auto;
}

/*.courses{
  min-height: 100px;
}*/
.click_card{
  outline: none;
}

.rounded{
   border-radius: 15px !important;
}

/*.rounded-top{
  border-radius: 15px 15px 0px 0px !important;
}*/

.lazyframe{

 z-index: -10 !important;
}

.content_progress {
 margin-top: -4px;

 z-index: 999999;
}


.duration{
  margin-top: -30px !important;
  z-index: 999999;
  background-color: #000;
  border-radius: 5px !important;
  padding: 2px !important;
}

p {
  padding: 0 !important;
  margin: 0 !important;
}

.media-body h5 {
    font-weight: 500;
    margin-bottom: 0;
}

textarea#posts {
    background: #eeeeee;
    border-radius: 100px !important;
}

.image_textarea{
  display: none;
}

.image_textarea img{
  margin: 10px;
  height: 95px;
  width: 95px;
}

.image_comments{
  height: 150px;
  width: 150px;
  cursor: pointer;
}

.checkboxButton[type="checkbox"] {
  display: none;
}
.checkboxButton[type="checkbox"]:not(:disabled) ~ .checkbox_label {
  cursor: pointer;
}
.checkboxButton[type="checkbox"]:disabled ~ .checkbox_label {
  color: #00C851
  border-color: #00C851
  box-shadow: none;
}

.checkbox_label {
  display: block;
  background: white;
  position: relative;
}

.checkboxButton[type="checkbox"]:checked + .checkbox_label{
  border: 2px solid #1dc973;
}
</style>
<body>
<div class="preloader">
  <picture>
    <a>
      <img src="<?php echo base_url();?>assets/img/logo-1.png" class="img-fluid wow slideOutUp" alt="" style="height: 300px;">
    </a>
  </picture>
</div>
<?php if($title != 'Login'){ ?>
<script type="text/javascript">
$(document).ready(function() {
  $.getJSON('<?php echo base_url(); ?>user-status', function(data) {
    if (!data.isLoggedIn) {
      window.location.href = "<?php echo base_url(); ?>login";
    } else if (data.status == 0 && !data.a) {
      window.location.href = "<?php echo base_url(); ?>maintenance";
    } else {
      var html = '';
      html += '<strong>'+data.fn+' '+data.ln+'</strong>';
      $('.my_info').html(html);
    }
  });
});
</script>
<?php } ?>
<script type = "text/javascript">
  var base_url = '<?php echo base_url() ?>';
</script>
<div class="video-overlay"></div>
<?php if($title == 'Home'){ ?>
  <video class="video-intro" autoplay muted loop id="myVideo">
    <source src="<?php echo base_url();?>assets/img/videos/<?php echo $settings['home_video'];?>" type="video/mp4">
  </video> 
<?php } ?>
<?php if($title == 'Home'){ ?>
  <audio autoplay loop <?php if($music_status['music_status'] == '0'){ echo 'muted';}?> id="audioDemo"><source src="<?php echo base_url();?>assets/img/<?php echo $settings['music'];?>" type="audio/mp3"><a href="https://icons8.com/music/author/vadim-derepa">Vadim Derepa</a></audio>
  <div class="col-md-4 d-flex justify-content-end" id="player">
    <a><i class="fas <?php if($music_status['music_status'] == '0'){ echo 'fa-volume-off';} else { echo 'fa-volume-up';}?> fa-lg" id="stopmusic"></i></a>
  </div>
<?php } ?>