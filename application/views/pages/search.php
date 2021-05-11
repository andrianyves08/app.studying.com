<main class="pt-5 mx-lg-5">
<div class="container mt-5">
  <section>
    <div class="row flex-column-reverse flex-md-row">
      <div class="col-lg-12 myList mt-4">
        <h4>about <?php echo $total_results; ?> results</h4>
        <ul class="nav nav-pills mb-3 w-100" id="pills-tab" role="tablist">
          <li class="nav-item">
            <a class="nav-link" id="pills-modules-tab" data-toggle="pill" href="#pills-modules" role="tab"
              aria-controls="pills-modules" aria-selected="false">Modules</a>
          </li>
           <li class="nav-item">
            <a class="nav-link" id="pills-sections-tab" data-toggle="pill" href="#pills-sections" role="tab"
              aria-controls="pills-sections" aria-selected="false">Sections</a>
          </li>
           <li class="nav-item">
            <a class="nav-link" id="pills-lessons-tab" data-toggle="pill" href="#pills-lessons" role="tab"
              aria-controls="pills-lessons" aria-selected="false">Lessons</a>
          </li>
           <li class="nav-item">
            <a class="nav-link" id="pills-contents-tab" data-toggle="pill" href="#pills-contents" role="tab"
              aria-controls="pills-contents" aria-selected="false">Contents</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="pills-qanda-tab" data-toggle="pill" href="#pills-qanda" role="tab"
              aria-controls="pills-qanda" aria-selected="false">Questions and Answers</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="pills-blogs-tab" data-toggle="pill" href="#pills-blogs" role="tab"
              aria-controls="pills-blogs" aria-selected="false">Blogs</a>
          </li>
        </ul>
        <div class="tab-content pt-2 pl-1" id="pills-tabContent">
          <div class="tab-pane fade show active" id="pills-modules" role="tabpanel" aria-labelledby="pills-modules-tab">
            <?php foreach ($courses as $course) { ?>
              <a class="ml-4" href="<?php base_url(); ?>modules/<?php echo $course['program_slug'];?>/<?php echo $course['course_slug'];?>/<?php echo $course['section_slug'];?>"><?php echo $course['course_title']; ?>
              </a>
              <br>
            <?php } ?>
          </div>
          <div class="tab-pane fade" id="pills-sections" role="tabpanel" aria-labelledby="pills-sections-tab">
            <?php foreach ($sections as $section) { ?>
              <a class="ml-4" href="<?php base_url(); ?>modules/<?php echo $section['program_slug'];?>/<?php echo $section['course_slug'];?>/<?php echo $section['section_slug'];?>"><?php echo $section['section_name']; ?>
              </a>
              <br>
            <?php } ?>
          </div>
          <div class="tab-pane fade" id="pills-lessons" role="tabpanel" aria-labelledby="pills-lessons-tab">
            <?php foreach ($lessons as $lesson) { ?>
              <a class="ml-4" href="<?php base_url(); ?>modules/<?php echo $lesson['program_slug'];?>/<?php echo $lesson['course_slug'];?>/<?php echo $lesson['section_slug'];?>#lesson-<?php echo $lesson['lesson_ID'];?>"><?php echo $lesson['lesson_name']; ?>
              </a>
              <br>
            <?php } ?>
          </div>
          <div class="tab-pane fade" id="pills-contents" role="tabpanel" aria-labelledby="pills-contents-tab">
            <?php foreach ($contents as $content) { ?>
              <div class="row ml-4">
                <div class="col-9 my-0 contents" data-id="<?php echo $content['content_ID'];?>">
                  <a href="<?php base_url(); ?>modules/<?php echo $content['program_slug'];?>/<?php echo $content['course_slug'];?>/<?php echo $content['section_slug'];?>#<?php echo $content['content_ID'];?>"><?php echo $content['content_name']; ?>
                  </a>
                </div>
                <div class="col-3 my-0 green-text watched_<?php echo $content['content_ID'];?>">
                </div>
              </div>
            <?php } ?>
          </div>
          <div class="tab-pane fade" id="pills-qanda" role="tabpanel" aria-labelledby="pills-qanda-tab">
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
          </div>
          <div class="tab-pane fade" id="pills-blogs" role="tabpanel" aria-labelledby="pills-blogs-tab">
            <?php foreach ($blogs as $blog) { ?>
              <div class="row justify-content-center post_3">
                <div class="col-lg-4 mb-4 view overlay zoom">
                  <img src="https://app.studying.com/assets/img/blogs/<?php echo $blog['banner']; ?>" class="img-fluid z-depth-1-half img-id-2" alt="">
                </div>
                <div class="col-lg-8 mb-4">
                  <h6 class="indigo-text"><?php echo ucwords($blog['type_name']); ?></h6>
                  <h2 class="customfont_header"><?php echo ucwords($blog['title']); ?></h2>
                  <p><?php echo substr(ucfirst(strip_tags($blog['content'])), 0, 300); ?>...</p>
                  <a href="https://www.studying.com/<?php echo $blog['slug'];?>" target="_blank">Read More <i class="fas fa-angle-double-right ml-1"></i></a>
                  <p class="mt-auto"><?php echo date("F d, Y", strtotime($blog['timestamp']));?></p>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div><!--Column-->
    </div><!--Row-->
  </section>
</div><!--Container-->
</main>
<script type="text/javascript">
$(document).ready(function(){
  watched();
  function watched(content) {
    $.ajax({
      type : "POST",
      url  : base_url +"users/all_watched_video",
      dataType : "JSON",
      success: function(data){
        for(i=0; i<data.length; i++){
          var html = '';
          html += '<p class="green-text m-0" style="font-size: 16px;"><i class="fas fa-check-circle"></i> Watched</p>';
          $('.watched_'+data[i].content_ID).html(html);
        }
      }
    });
  }
});
</script>