<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <div class="card mb-4 wow fadeIn">
    <div class="card-body d-sm-flex justify-content-between">
      <h4 class="mb-2 mb-sm-0 pt-1">
        <span><a href="<?php echo base_url();?>admin">Home</a></span>
        <span>/</span>
        <span>Ratings</span>
      </h4>
    </div>
  </div>
  <!-- Heading -->

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <table class="table table-bordered display table-responsive-md" cellspacing="0" width="100%">
            <thead>
            <th>Full Name</th>
            <th>Ratings</th>
            <th>Feedback</th>
            <th>Timestamp</th>
            </thead>
            <tbody>
            <?php foreach($ratings as $rating){ ?> 
            <tr>
              <td><?php echo ucwords($rating['first_name']);?> <?php echo ucwords($rating['last_name']);?></td>
              <td>
              <?php 
                  $output = '';
                  if($rating['rating'] == 0){
                    $output .='<i class="far fa-star amber-text"></i>';
                  } else {
                    $i = 0;
                    while($rating['rating'] > $i){
                      $output .='<i class="fas fa-star amber-text"></i>';
                      $i++;
                    }
                  }
                   echo $output;
                ?>
              </td>
              <td><?php echo ucfirst($rating['comments']);?></td>
              <td><?php echo date("F d, Y h:i A", strtotime($rating['timestamp']));?></td>
            </tr>
            <?php }?>
            </tbody>
          </table>
        </div><!--Card Body-->
      </div><!--Card-->
    </div><!--Columm-->
  </div><!--Row-->
</div><!--Container-->
</main><!--Main laypassed out-->