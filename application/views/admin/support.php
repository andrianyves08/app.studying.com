<main class="pt-5 mx-lg-5">
  <div class="container-fluid mt-5">
    <div class="card mb-4 wow fadeIn">
      <div class="card-body d-sm-flex justify-content-between">
        <h4 class="mb-2 mb-sm-0 pt-1">
          <span><a href="<?php echo base_url();?>admin">Home</a></span>
          <span>/</span>
          <span>Support</span>
        </h4>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <table class="table table-bordered display table-responsive-md" cellspacing="0" width="100%">
              <thead>
              <th>Message</th>
              <th>Sent By</th>
              <th>Timestamp</th>
              <th></th>
              </thead>
              <tbody>
                <?php foreach($messages as $message){ ?> 
                  <tr>
                    <td><?php echo ucfirst($message['message']);?></td>
                    <td><?php echo ucwords($message['first_name']);?> <?php echo ucwords($message['last_name']);?></td>
                    <td><?php echo date("F d, Y h:i A", strtotime($message['timestamp']));?></td>
                    <td>
                      <?php if($message['reward_status'] == 0){ ?>
                        <a class="btn btn-sm btn-success give_reward" data-user-id="<?php echo $message['user_ID'];?>" data-message-id="<?php echo $message['message_ID'];?>">Give Reward</a>
                      <?php } ?>
                    </td>
                  </tr>
                <?php }?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div><!--Container-->
</main><!--Main laypassed out-->
<script type="text/javascript">
$(document).ready(function(){
  $.ajax({
    type : "POST",
     url  : "<?=base_url()?>admin/seen",
    dataType : "JSON",
    success: function(data){
    }
  });

  $(document).on("click", ".give_reward", function() { 
    var user_ID=$(this).data('user-id');
    var message_ID=$(this).data('message-id');
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>admin/give_reward",
      dataType : "JSON",
      data : {user_ID:user_ID, message_ID:message_ID},
      success: function(data){
        toastr.success('20 exp given!');
        location.reload();
      }
    });
  });
});
</script>