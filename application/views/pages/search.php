<main class="pt-5 mx-lg-5">
<div class="container mt-5">
  <section>
    <div class="row flex-column-reverse flex-md-row">
      <div class="col-lg-8 col-md-8 mb-4 myList">
        <div class="card mb-4">
          <div class="card-header customcolorbg text-white text-center">Modules</div>
          <div class="card-body">
            <?php foreach ($courses as $course) { ?>
              <a href="<?php base_url(); ?>modules/<?php echo $course['program_slug'];?>/<?php echo $course['course_slug'];?>/<?php echo $course['section_slug'];?>"><?php echo $course['course_title']; ?>
              </a>
              <br>
            <?php } ?>
          </div>
        </div>
        <div class="card mb-4">
          <div class="card-header customcolorbg text-white text-center">Sections</div>
          <div class="card-body">
             <?php foreach ($sections as $section) { ?>
              <a href="<?php base_url(); ?>modules/<?php echo $section['program_slug'];?>/<?php echo $section['course_slug'];?>/<?php echo $section['section_slug'];?>"><?php echo $section['section_name']; ?>
              </a>
              <br>
            <?php } ?>
          </div>
        </div>
        <div class="card mb-4">
          <div class="card-header customcolorbg text-white text-center">Lessons</div>
          <div class="card-body">
            <?php foreach ($lessons as $lesson) { ?>
              <a href="<?php base_url(); ?>modules/<?php echo $lesson['program_slug'];?>/<?php echo $lesson['course_slug'];?>/<?php echo $lesson['section_slug'];?>#lesson-<?php echo $lesson['lesson_ID'];?>"><?php echo $lesson['lesson_name']; ?>
              </a>
              <br>
            <?php } ?>
          </div>
        </div>
        <div class="card mb-4">
          <div class="card-header customcolorbg text-white text-center">
            Contents
          </div>
          <div class="card-body">
            <?php foreach ($contents as $content) { ?>
              <div class="row">
                <div class="col-9 my-0 contents" data-id="<?php echo $content['content_ID'];?>">
                  <a href="<?php base_url(); ?>modules/<?php echo $content['program_slug'];?>/<?php echo $content['course_slug'];?>/<?php echo $content['section_slug'];?>#<?php echo $content['content_ID'];?>"><?php echo $content['content_name']; ?>
                  </a>
                </div>
                <div class="col-3 my-0 green-text watched_<?php echo $content['content_ID'];?>">
                </div>
              </div>
            <?php } ?>
          </div>
        </div><!--Card-->
        <div class="card-header customcolorbg text-white text-center mb-2">
            Questions and Answer
        </div>
        <div class="accordion md-accordion accordion-blocks" id="accordion" role="tablist" aria-multiselectable="true">
          <?php foreach ($faqs as $faq) { ?>
            <div class="card h-1 mb-2">
              <div class="card-header white mb-1" role="tab" id="heading1">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $faq['id'];?>" aria-expanded="true"
                aria-controls="collapse<?php echo $faq['id'];?>">
                  <h5 class="mb-0 font-thin h-1 text-dark">
                  <?php echo ucfirst($faq['question']); ?> <i class="fas fa-angle-down rotate-icon"></i>
                  </h5>
                </a>
              </div><!--Card Header-->
              <div id="collapse<?php echo $faq['id'];?>" class="collapse" role="tabpanel" aria-labelledby="heading1"
              data-parent="#accordion">
                <div class="card-body">
                  <?php echo $faq['answer']; ?>
                </div>
              </div><!--Accordion Panel-->
            </div><!--Card-->
          <?php } ?>
        </div>
        <?php foreach ($categories as $category) { ?>
          <div class="mb-4 h-1">
            <h4 class="indigo-text text-center mt-4 pt-4"><?php echo ucwords($category['name']); ?></h4>
            <div class="accordion md-accordion accordion-blocks" id="accordion" role="tablist"
            aria-multiselectable="true">
            <?php foreach ($all_faqs as $all_faq) { ?>
              <?php if ($category['id'] == $all_faq['category_ID']) { ?>
                <div class="card h-1 mb-2">
                  <div class="card-header white mb-1" role="tab" id="heading1">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $all_faq['id'];?>" aria-expanded="true"
                    aria-controls="collapse<?php echo $all_faq['id'];?>">
                      <h5 class="mb-0 font-thin h-1 text-dark">
                      <?php echo ucfirst($all_faq['question']); ?> <i class="fas fa-angle-down rotate-icon"></i>
                      </h5>
                    </a>
                  </div><!--Card Header-->
                  <div id="collapse<?php echo $all_faq['id'];?>" class="collapse" role="tabpanel" aria-labelledby="heading1"
                  data-parent="#accordion">
                    <div class="card-body">
                      <?php echo $all_faq['answer']; ?>
                    </div>
                  </div><!--Accordion Panel-->
                </div><!--Card-->
              <?php } ?>
            <?php } ?>
            </div><!--Accordion wrapper-->
          </div><!--H-1-->
        <?php } ?>
      </div><!--Column-->
      <div class="col-md-4 mb-4">
        <div class="card mb-4">
          <div class="card-header customcolorbg text-white">
            <i class="fas fa-eye amber-text" aria-hidden="true"></i> Last Video Watched
          </div>
          <div class="card-body">
            <a href="<?php base_url(); ?>modules/<?php echo $last_watched['program_slug'];?>/<?php echo $last_watched['slug'];?>/<?php echo $last_watched['section_slug'];?>#<?php echo $last_watched['content_ID'];?>"><?php echo ucwords($last_watched['name']);?> <?php echo $last_watched['content_name'];?>
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
      </div><!--Column-->
    </div><!--Row-->
  </section>
</div><!--Container-->
</main>
<script type="text/javascript">
$(document).ready(function(){
  last_watched();
  get_course_progress();
  function last_watched(){
    $('.contents').each(function(){
      var content = $(this).data('id');
       watched(content);
    });
  }
  function watched(content) {
    $.ajax({
      type : "POST",
      url  : "<?php echo site_url('users/watched_video');?>",
      dataType : "JSON",
      data : {content:content},
      success: function(data){
        if(data.success){
          var html = '';
          html += '<p class="green-text m-0" style="font-size: 16px;"><i class="fas fa-check-circle"></i> Watched</p>';
          $('.watched_'+content).html(html);
        }
      }
    });
  }
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