<script type="text/javascript">
$(document).ready(function(){
  //Get purchase ID to refund
  $(document).on("click", ".update_status", function() { 
    var id=$(this).attr('id');
    $('#purchase_status').modal('show');
    $('[name="purchase_ID"]').val(id);
  });

   //update status
  $('#update_status').on('click',function(){
    var purchase_ID = $('[name="purchase_ID"]').val();
    var amount = $('[name="amount"]').val();
    $.ajax({
      type : "POST",
       url  : "<?=base_url()?>users/refund_purchase",
      dataType : "JSON",
      data : {id:purchase_ID, amount:amount},
      success: function(data){
        toastr.success('Purchase Refunded!');
        location.reload();
      }
    });
    return false;
  });

  $(document).on("click", ".delete_purchase", function() { 
    var id=$(this).data('purchase-id');
    $('#delete_purchase_modal').modal('show');
    $('[name="delete_ID"]').val(id);
  });

  //update status
  $('#delete_purchase').on('click',function(){
    var purchase_ID = $('[name="delete_ID"]').val();
    $.ajax({
      type : "POST",
       url  : "<?=base_url()?>users/delete_purchase",
      dataType : "JSON",
      data : {id:purchase_ID},
      success: function(data){
        toastr.success('Purchase Deleted!');
        location.reload();
      }
    });
    return false;
  });

  //Add purchaser
  $('#add_purchases').on('click',function(){
    var user_ID = $('#user_ID').val();
    var modules = $('#modules').val();
    $.ajax({
      type : "POST",
       url  : "<?=base_url()?>users/add_purchases",
      dataType : "JSON",
      data : {id:user_ID, modules:modules},
      success: function(data){
        $('#changemodule').modal('hide');
        location.reload();
        toastr.success('Purchase Added');
          
      }
    });
    return false;
  });
});
</script>
<script type="text/javascript">
$(document).ready(function() {
  $(".customSwitches").click(function() {
    var delete_lesson = $(this).attr('id');
    if($(".swt"+delete_lesson).is(":checked")){
      $('#testtex'+delete_lesson).text('Active');
      $(this).val(1);
    } else {
      $('#testtex'+delete_lesson).text('Deactivate');
       $(this).val(0);
    }
  });
});
</script>
  </body>
</html>