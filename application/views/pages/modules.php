<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <div class="row mt-3 pt-3">
    <section class="center slider py-2">
      <?php foreach ($courses as $course) {?>
      <div>
        <div class="courses mb-2" data-id="<?php echo $course['course_ID']; ?>" data-slug="<?php echo $course['course_slug']; ?>" <?php if( strlen($course['course_title']) > 34){ echo 'data-toggle="tooltip"';}?> title="<?php echo ucwords($course['course_title']); ?>"><h2 class="mb-3 text-center text-dark text-truncate"><?php echo ucwords($course['course_title']); ?></h2></div>
        <div id="course_progress<?php echo $course['course_ID']; ?>">
        </div>
        <?php foreach ($sections as $section) {?>
          <?php if ($section['course_ID'] == $course['course_ID']) {?>
            <a href="<?php base_url(); ?><?php echo $slug;?>/<?php echo $section['course_slug'];?>/<?php echo $section['section_slug'];?>" class="click_card">
              <div class="card mb-2 hoverable_2 mr-3" <?php if(strlen($section['section_name']) > 44){ echo 'data-toggle="tooltip"';}?> data-placement="top" title="<?php echo ucwords($section['section_name']); ?>">
                <div class="card-header customcolorbg sections text-white m-0" data-id="<?php echo $section['section_ID']; ?>" data-slug="<?php echo $course['course_slug']; ?>" data-section-slug="<?php echo $section['section_slug']; ?>"><h5 class="text-truncate"><span id="section_<?php echo $section['section_ID']; ?>" class="float-left mr-2"></span><?php echo ucwords($section['section_name']) ?></h5></div>
              </div>
            </a>
          <?php } ?>
        <?php } ?>
      </div>
      <?php } ?>
    </section>
    </div>
  </div><!--Row-->
</div><!--Container-->
</main>
<script type="text/javascript">
$(document).ready(function(){
  last_watched();
  function last_watched(){
    $('.courses').each(function(){
      var slug = $(this).data('slug');
      var id = $(this).data('id');
      get_course_progress(slug, id);
    });
    $('.sections').each(function(){
      var slug = $(this).data('slug');
      var section_slug = $(this).data('section-slug');
      var id = $(this).data('id');
      get_module_progress(slug, section_slug, id);
    });
  }
  function get_course_progress(slug, id){
    $.ajax({
      type  : 'POST',
      url   : "<?=base_url()?>users/get_module_progress",
      dataType : 'json',
      data : {slug:slug},
      success : function(data){
        var html = '';
        html += '<div class="form-inline mb-2"><strong class="text-dark mr-2">Module Progress </strong><div class="progress" style="width: 100px; height: 20px;"><div class="progress-bar bg-success text-dark" role="progressbar" style="width: '+data.percentage_width+'%;" aria-valuemin="0" aria-valuemax="'+data.total+'">'+data.percentage+' % </div></div></div>';
        $('#course_progress'+id).html(html);
      }
    });
  }
  function get_module_progress(slug, section_slug, id){
    $.ajax({
      type  : 'POST',
      url   : "<?=base_url()?>users/get_section_progress",
      dataType : 'json',
      data : {slug:slug, section_slug:section_slug},
      success : function(data){
        if(data.percentage == 100){
          var html = '';
          html += '<i class="fas fa-star amber-text mr-1"></i>';
          $('#section_'+id).html(html);
        }
      }
    });
  }
});
</script>
<script type="text/javascript">
$(document).ready(function(){
  $('.center').slick({
    infinite: false,
    dots: true,
    slidesToShow: 3,
    slidesToScroll: 3,
    accessibility: true,
    adaptiveHeight: true,
    responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2,
        infinite: false,
        dots: true
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
  ]
  });
  if(window.location.hash != ''){ 
    var hash = document.URL.substr(document.URL.indexOf('#')+1);
    $('.center').slick('slickGoTo', hash - 2);
  }
  
});
</script>