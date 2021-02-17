<!-- Bootstrap tooltips -->
<script type="text/javascript" src="<?php echo base_url('/assets/admin/js/popper.min.js'); ?>"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="<?php echo base_url('/assets/admin/js/bootstrap.min.js'); ?>"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="<?php echo base_url('/assets/admin/js/mdb.min.js'); ?>"></script>
<!-- Initializations -->
<script type="text/javascript">
  new WOW().init();
</script>
<!-- DataTables JS -->
<script src="<?php echo base_url('/assets/admin/js/addons/datatables.min.js'); ?>" type="text/javascript"></script>
<!-- DataTables Select JS -->
<script src="<?php echo base_url('/assets/admin/js/addons/datatables-select.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('/assets/admin/plugins/rowreorder/js/dataTables.rowReorder.min.js'); ?>" type="text/javascript"></script>
<!-- Select2 -->
<script src="<?php echo base_url('/assets/plugins/select2/js/select2.full.min.js'); ?>"></script>
<script>
$(function () {
  $('.select2').select2()
})
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $('table.display').DataTable( {
    "order": [],
    // Your other options here...
} );
  });
</script>
<script type="text/javascript">
$(document).ready(function() {
  $.ajax({
    type : "POST",
     url  : "<?=base_url()?>posts/get_on_review_posts",
    dataType : "JSON",
    success: function(data){
      if(data > 0){
        var html = '<span class="badge badge-danger badge-pill">'+data+'</span>';
        $('#review_post').html(html);
      }
    }
  });
  $.ajax({
    type : "POST",
     url  : "<?=base_url()?>admin/new_messages",
    dataType : "JSON",
    success: function(data){
      if(data > 0){
        var html = '<span class="badge badge-danger badge-pill">'+data+'</span>';
        $('#new_messages').html(html);
      }
    }
  });
});
</script>
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

</script>
<script src="<?php echo base_url('/assets/plugins/summernote/summernote-bs4.min.js'); ?>"></script>
<!-- <script src="<?php echo base_url('/assets/plugins/summernote/summernote-classes.js'); ?>"></script> -->
<script src="<?php echo base_url('/assets/plugins/summernote/summernote-ext-addclass.js'); ?>"></script>
<script src="<?php echo base_url('/assets/plugins/summernote/summernote-file.js'); ?>"></script>
<script src="<?php echo base_url('/assets/plugins/chart.js/Chart.min.js'); ?>"></script>
<?php if($this->session->flashdata('multi')): ?>
  <?php echo $this->session->flashdata('multi'); ?>
<?php endif; ?>