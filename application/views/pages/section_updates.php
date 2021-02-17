<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <section>
    <div class="row mt-5 justify-content-center">
      <div class="col-md-3 mb-4 text-center">
      <?php foreach ($all as $contents) {?>
        <?php if (!empty($contents['content_URL'])) { ?>
          <div class="card mb-4">
            <div class="view">
              <div class="embed-responsive embed-responsive-16by9">
                <img class="lazyframe embed-responsive-item" data-src="<?php echo $contents['content_URL']; ?>" data-vendor="vimeo">
                </img> 
              </div>
            </div>
            <div class="card-body d-flex flex-column">
              <h6 class="card-title"><strong><?php echo ucwords($contents['course_name']);?></strong></h6>
              <a class="h6 mt-2 ml-2 mr-2" href="<?php base_url(); ?><?php echo $contents['course_slug'];?>/<?php echo $contents['section_slug'];?>#<?php echo $contents['content_ID'];?>"><?php echo ucwords($contents['content_part_name']);?>
              </a>
              <span class="mb-2">Uploaded: <?php echo date("F d, Y", strtotime($contents['content_part_last_updated']));?></span>
            </div>
          </div>
        <?php } else { ?>
          <div class="card mb-4">
            <div class="card-body d-flex flex-column">
              <h6 class="card-title"><strong><?php echo ucwords($contents['course_name']);?></strong></h6>
              <a class="h6 mt-2 ml-2 mr-2" href="<?php base_url(); ?><?php echo $contents['course_slug'];?>/<?php echo $contents['section_slug'];?>#<?php echo $contents['content_ID'];?>"><?php echo ucwords($contents['content_part_name']);?>
              </a>
              <span class="mb-2">Uploaded: <?php echo date("F d, Y", strtotime($contents['content_part_last_updated']));?></span>
            </div>
          </div>
        <?php } ?>
      <?php } ?>
      </div><!--Grid column-->
      <div class="col-md-4 mb-4">
        <div class="card mb-4">
          <div class="card-header customcolorbg text-white">
            <i class="fas fa-eye amber-text" aria-hidden="true"></i> Last Video Watched
          </div>
          <div class="card-body">
            <a href="<?php base_url(); ?><?php echo $last_watched['slug'];?>/<?php echo $last_watched['section_slug'];?>#<?php echo $last_watched['content_ID'];?>"><?php echo ucwords($last_watched['name']);?> <?php echo $last_watched['content_name'];?>
              <i class="far fa-image"></i>
            </a>
          </div>
        </div><!--Card-->
        <div class="card mb-4">
          <div class="card-header customcolorbg text-white">
            <i class="fas fa-graduation-cap amber-text" aria-hidden="true"></i> My Progress  
          </div>
          <div class="card-body" id="course_progress">
          </div>
        </div><!--Card-->
      </div><!--Grid column-->
    </div><!--Grid row-->
  </section>
</div><!--Container-->
</main>
<script type="text/javascript">
$(document).ready(function(){
  get_course_progress();
  function get_course_progress(){
    $.ajax({
      type  : 'POST',
      url   : "<?=base_url()?>users/get_course_progress",
      dataType : 'json',
      success : function(data){
        var html = '';
        html += '<div class="form-inline"><div class="progress" style="width: 100%; height: 20px;"><div class="progress-bar bg-success" role="progressbar" style="width: '+data.percentage_width+'%;" aria-valuemin="0" aria-valuemax="'+data.total+'">'+data.percentage+' % </div></div></div>';

        $('#course_progress').html(html);
      }
    });
  }
});
</script>