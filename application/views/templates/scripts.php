<!-- Rate portal -->
<div data-backdrop="static" class="modal fade" id="rate_us" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">Rate the new portal!</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php echo form_open_multipart('pages/send_rating'); ?>
        <p>Your feedback is a huge help for providing the most innovating educational experiences.</p>
        <p>Provide us Your solutions as well.</p>
        <span id="rateMe1" class="mb-4"></span>
        <input type="hidden" id="rating_page" name="rating_page" value="1">
        <input type="hidden" id="feedback_rating" name="feedback_rating">
        <div class="form-group">
          <textarea class="form-control rounded-0" name="feedback" id="feedback" rows="5" placeholder="Enter your feedback..."></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" id="ask_me_later">Logout</button>
        <button type="submit" class="btn btn-primary btn-sm">Send Feedback</button>
      <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap tooltips -->
<script type="text/javascript" src="<?php echo base_url();?>assets/js/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="<?php echo base_url();?>assets/js/mdb.min.js"></script>
<!-- Initializations -->
<script type="text/javascript">
  new WOW().init();
</script>
<!-- Select2 -->
<script src="<?php echo base_url();?>assets/plugins/select2/js/select2.full.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/toastr/toastr.min.js"></script>
<!-- DataTables JS -->
<script src="<?php echo base_url('/assets/admin/js/addons/datatables.min.js'); ?>" type="text/javascript"></script>
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
<script type="text/javascript">
$(document).ready(function() {
  paused();
  $('#stopmusic').click(function() {
    $("#audioDemo").toggleClass('active');
    if($("#audioDemo").hasClass('active')){
      $("#audioDemo").trigger('pause');
      $('#stopmusic').removeClass('fa-volume-up');
      $('#stopmusic').addClass('fa-volume-off'); 
      paused(0);
    } else {
      $("#audioDemo").trigger('play');
      $('#stopmusic').addClass('fa-volume-up');
      $('#stopmusic').removeClass('fa-volume-off');
      paused(1);
    }
  });
  function paused(number){
    $.ajax({
      type  : 'POST',
      url   : '<?php echo site_url('pages/music')?>',
      dataType : 'json',
      data : {id:number},
      success : function(data){
      }
    });
  }
});
</script>
<script>
$(function () {
  $('.select2').select2()
})
</script>
<script type="text/javascript">
function get_level(){
  $.ajax({
    type  : 'POST',
    url   : "<?=base_url()?>users/get_level",
    dataType : 'json',
    success : function(data){
      $('#my_level').html(data);
    }
  });
}
</script>
<script src="<?php echo base_url(); ?>assets/js/addons/rating.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  get_level();
  $('#rateMe1').mdbRate();
  $('#rateMe1').hover(function() {
    var count = $('#rateMe1 .amber-text').length;
    $('[name="feedback_rating"]').val(count);
  });
  $('#user_logout').on('click',function(){
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>pages/rating",
      dataType : "JSON",
      success: function(data){
        if(data.status == true){
          $('#rate_us').modal('show');
        } else if (data.status == false) {
          window.location.href = "<?php echo base_url(); ?>logout";
        }
      }
    });
    return false;
  });
  $('#ask_me_later').on('click',function(){
    window.location.href = "<?php echo base_url(); ?>logout";
  });
});
</script> 
<script type="text/javascript">
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>
<script type="text/javascript">
$(document).ready(function() {
  $('table.display').DataTable();
});
</script>
<script>
$("#menu-toggle").click(function(e) {
  e.preventDefault();
  $("#wrapper").toggleClass("toggled");
});
</script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/lazyframe.min.js"></script>
<script type="text/javascript">
lazyframe('.lazyframe', {
  apikey: 'AIzaSyB-iDku_44LtvJZ00FXc1G9UOjqDv3ttas'
});
</script>
<script src="<?php echo base_url();?>assets/plugins/slick/slick.min.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript">
const preloader = document.querySelector('.preloader');
const fadeEffect = setInterval(() => {
  // if we don't set opacity 1 in CSS, then   //it will be equaled to "", that's why we   // check it
  if (!preloader.style.opacity) {
    preloader.style.opacity = 1;
  }
  if (preloader.style.opacity > 0) {
    preloader.style.opacity -= 0.1;
  } else {
    clearInterval(fadeEffect);
  }
   preloader.classList.add("loaded");
}, 5);
</script>
<script type="text/javascript">
$(document).ready(function() {
  var my_ID = <?php echo $my_id;?>;
  $.ajax({
    type : "POST",
    url  : "<?=base_url()?>posts/get_notifications",
    dataType : "JSON",
    success: function(data){
      var html= '';
      var i;
      var count = 0;
      for(i=0; i<data.length; i++){
        if(data[i].type == 1){
          html += '<div data-url="./user-profile/'+data[i].notifier+'#'+data[i].post_ID+'" class="notifier dropdown-item"><img class="rounded-circle mr-2 card-img-100 chat-mes-id" src="<?php echo base_url();?>assets/img/users/'+data[i].image+'" style="height: 25px; width: 25px" alt="Profile photo">'+data[i].notification_option_id+'<br><div style="width: 300px;">'+data[i].posts+'</div><span style="font-size: 12px;">'+data[i].timestamp+'</span></div>';
        } else {
          html += '<div data-url="./messages" class="notifier dropdown-item"><img class="rounded-circle mr-2 card-img-100 chat-mes-id" src="<?php echo base_url();?>assets/img/users/'+data[i].image+'" style="height: 25px; width: 25px" alt="Profile photo">'+data[i].notification_option_id+'<br><div style="width: 300px;">'+data[i].posts+'</div><span style="font-size: 12px;">'+data[i].timestamp+'</span></div>';
        }
        
        if(data[i].status == 0){
          count++;
        }
      }
      $('#notifications').html(html);
      if(count != 0){
        var html2 = '<span class="badge badge-danger badge-pill">'+count+'</span>';
        $('#notification_bell').html(html2);
      }
    }
  });

  //Like post
  $('#seen_notification').on('click',function(){
    $.ajax({
      url:"<?=base_url()?>posts/seen",
      method:"POST",
      dataType : 'json',
      success:function(data) {     
      }
    })
  });

  $(document).on('click', '.notifier', function(){
    var href = $(this).data('url');
    window.location.href = href;
  });

  setInterval(function(){
    update_user_status();
  }, 60000);

  function update_user_status(){
    $.ajax({
      type  : 'post',
      url   : "<?=base_url()?>users/update_user_status",
      async : true,
      dataType : 'json',
      success : function(data){
      }
    });
  }
});
</script>
<!-- Developed By: Andrian Yves Macalino, andrianyvesmacalino@gmail.com -->
  </body>
</html>