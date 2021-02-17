<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <section class="card" style="background-image: url(<?php echo base_url();?>assets/img/<?php echo $pages['background_image'];?>);background-attachment: fixed; background-position: center; background-repeat: no-repeat; background-size: cover; height: 300px;">
    <div class="card-body text-white text-center py-5 px-5 my-5">
      <h1 class="mb-4">
        <strong>Rank List</strong>
      </h1>
      <p>
        <strong></strong>
      </p>
    </div><!-- Card Body -->
  </section>
  <hr class="my-5">
  <section>
    <div class="row justify-content-center">
      <div class="col-md-4 mb-4">
        <?php foreach ($ranks as $rank) {?>
          <?php if ($rank['id'] == 1) {
            $level = '1 - 17';
          } elseif ($rank['id'] == 2){
            $level = '18 - 35';
          } elseif ($rank['id'] == 3){
            $level = '36 - 51';
          } elseif ($rank['id'] == 4) {
            $level = '52 - 67';
          } elseif ($rank['id'] == 5) {
            $level = '68 - 83';
          } elseif ($rank['id'] == 6) {
            $level = '84 - 99';
          } else {
            $level = '100';
          } ?>
          <div class="card text-center mb-4">
            <div class="view overlay">
              <img src="<?php echo base_url();?>assets/img/<?php echo $rank['image'];?>"  class="rounded mx-auto d-block">
            </div>
            <div class="card-body">
              <h4 class="card-title" style="font-family: Arnoldboecklin;"><strong><?php echo ucwords($rank['name']);?></strong></h4>
              <p class="card-text">Levels <?php echo $level;?></p>
            </div>
          </div>
        <?php }?>
      </div><!--Grid column-->
      <div class="col-md-4 mb-4">
        <div class="card mb-4">
          <div class="card-header customcolorbg">
            <h4 class="text-white"><strong>Rankings </strong></h4>
          </div>
          <div class="card-body">
            <?php $i=1; foreach ($rankings as $ranking) { ?>
              <img src="<?php echo base_url();?>assets/img/<?php echo $ranking['image'];?>" class="rounded-circle float-left" height="25px" width="25px" alt="avatar">
              <h6 class="card-title text-left"><strong>Level <?php echo ucwords($ranking['level']);?></strong> <a <?php if($ranking['id'] == $my_id){ echo 'href="'.base_url().'my-profile"'; } else { echo 'href="'.base_url().'user-profile/'.$ranking['id'].'"'; };?>><?php echo ucwords($ranking['first_name']);?> <?php echo ucwords($ranking['last_name']);?></a></h6>
            <?php $i++;} ?>
          </div>
        </div><!--Card-->
      </div><!--Column-->
    </div><!--Row-->
  </section>
</div><!--Contaienr-->
</main><!--Main layout-->