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
            <table class="table table-bordered display table-responsive" cellspacing="0" width="100%">
              <thead>
              <th colspan="5">App</th>
              <th colspan="30">Message</th>
              <th colspan="15">Sent By</th>
              <th colspan="15">Email</th>
              <th colspan="5">Timestamp</th>
              </thead>
              <tbody>
                <?php foreach($messages as $message){ ?> 
                  <tr>
                    <td colspan="5">
                      <?php 
                        if($message['from_ID'] == 0){
                          echo 'Studying';
                        } else {
                          echo 'Portal';
                        }
                      ?>
                    </td>
                    <td colspan="30"><?php echo ucfirst($message['message']);?></td>
                    <td colspan="15">
                      <?php 
                        if($message['from_ID'] == 0){
                          echo ucwords($message['other_user_name']);
                        } else {
                          echo ucwords($message['first_name']).' '.ucwords($message['last_name']);
                        }
                      ?>
                    </td>
                    <td colspan="15">
                      <?php 
                        if($message['from_ID'] == 0){
                          echo $message['other_email'];
                        } else {
                          echo $message['email'];
                        }
                      ?>
                    </td>
                    <td colspan="5"><?php echo date("F d, Y h:i A", strtotime($message['timestamp'])); ?></td>
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
});
</script>