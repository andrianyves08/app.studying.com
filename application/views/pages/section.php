<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <h3 class="mb-4 pt-4 ml-2 mr-2 text-center" id="main_header">
    <span class="dropdown">
      <a class="dropdown-toggle text-wrap blue-text" data-toggle="dropdown" id="course_drop" aria-haspopup="true" aria-expanded="false">
        <strong><?php echo ucwords($courses['title']);?></strong>
      </a>
      <div class="dropdown-menu" id="course_dropdown" aria-labelledby="course_drop">
      </div>
    </span>
    <span>/</span>
    <span class="dropdown">
      <a class="dropdown-toggle text-wrap blue-text" data-toggle="dropdown" id="section_drop" aria-haspopup="true" aria-expanded="false">
        <strong><?php echo ucwords($sections['name']);?></strong>
      </a>
      <div class="dropdown-menu" id="section_dropdown" aria-labelledby="section_drop">
      </div>
    </span>
  </h3>
  <div class="row justify-content-center">
    <div class="col-md-8 mb-4">
      <?php $count=1; foreach ($lessons as $lesson) {
        if ($lesson['status'] == 1) {
        ?>
        <?php $i = 1; foreach ($contents as $content) {?>
          <?php if ($lesson['id'] == $content['lesson_ID'] && $content['status'] == 1) {?>
            <?php
              if(substr($content['url'], 2, 6) == 'player' || substr($content['url'], 8, 5) == 'vimeo'){
                $player = 'vimeo';
                $video_ID = substr($content['url'], 25);
              } else {
                $player = 'youtube';
                $video_ID = substr($content['url'], 24);
              } 
            ?>
            <div class="text-center mb-4 content-pane content_id<?php echo $content['id'];?> current_row_<?php echo $count;?> text-center" style="display:none;" data-id="<?php echo $content['id'];?>" data-src="<?php echo $content['url'];?>" data-video-id="<?php echo $video_ID;?>" data-video="<?php echo $player;?>">
              <p class="h5 mb-2"><?php echo ucfirst($lesson['name']);?></p>
                <?php if (!empty($content['url'])) {?>
                  <?php if ($player == 'vimeo') {?>
                    <div class="embed-responsive embed-responsive-16by9">
                      <div class="embed-responsive-item" id="content_url_<?php echo $content['id']; ?>"></div>
                    </div>
                  <?php } else { ?>
                    <div class="embed-responsive embed-responsive-16by9">
                      <iframe class="embed-responsive-item" src="<?php echo $content['url']; ?>"></iframe>
                    </div>
                  <?php } ?>
                <?php } ?> 
              <p class="mb-4 font-italic" style="font-size: 16px;"><?php echo $i.') '.ucfirst($content['name']);?></p>
              <div class="input-group justify-content-center mb-4">
                <div class="input-group-prepend">
                  <a class="btn btn-sm btn-indigo m-0 prev_content" data-current-row="<?php echo $count;?>" data-id="<?php echo $content['id'];?>" data-src="<?php echo $content['url'];?>" data-video-id="<?php echo $video_ID;?>" data-video="<?php echo $player;?>"><i class="fas fa-angle-double-left"></i> Prev</a>
                  <a class="btn btn-sm btn-indigo m-0 next_content" data-current-row="<?php echo $count;?>" data-id="<?php echo $content['id'];?>" data-src="<?php echo $content['url'];?>" data-video-id="<?php echo $video_ID;?>" data-video="<?php echo $player;?>">Next <i class="fas fa-angle-double-right"></i></a>
                </div>
              </div><!--Input Group-->
              <?php echo $content['content'];?>
              <?php if (!empty($content['url'])) {?>
                <?php $found_key = array_search($content['id'], array_column($my_ratings, 'content_ID')); if(!$found_key){ ?>
                <div class="mt-4" id="add_rating_<?php echo $content['id'];?>">
                  <h5>Rate this video</h5>
                  <span id="rateMe_<?php echo $content['id'];?>" class="mb-4"></span>
                  <input type="hidden" id="feedback_rating_<?php echo $content['id'];?>">
                  <div class="form-group">
                    <textarea class="form-control rounded-0" id="feedback_<?php echo $content['id'];?>" id="feedback" rows="2" placeholder="Write your review"></textarea>
                  </div>
                  <script type="text/javascript">
                  $(document).ready(function() {
                    $('#rateMe_<?php echo $content['id'];?>').mdbRate();
                    $('#rateMe_<?php echo $content['id'];?>').hover(function() {
                      var count = $('#rateMe_<?php echo $content['id'];?> .amber-text').length;
                      $('#feedback_rating_<?php echo $content['id'];?>').val(count);
                    });
                  });
                  </script>
                  <button type="button" class="btn btn-success btn-md submit_rating" data-content-id="<?php echo $content['id'];?>">Submit Review</button>
                </div>
              <?php } } ?>
            </div><!--Card-->
          <?php $i++; $count++;} ?>
        <?php } ?>
      <?php } } ?>
      <div class="myList">
        <?php $count=1; foreach ($lessons as $lesson) {
          if ($lesson['status'] == 1) {
        ?>
        <h4 class="indigo-text h-1">
          <strong><?php echo ucfirst($lesson['name']);?></strong>
        </h4>
        <div id="section<?php echo $lesson['id'];?>">
          <div id="lesson<?php echo $lesson['id'];?>" class="myList-3">
            <div class="row mb-1">
              <section class="center slider">
                <?php $c=1; foreach ($contents as $content) {?>
                  <?php if ($lesson['id'] == $content['lesson_ID'] && $content['status'] == 1) {?>
                    <?php
                      if(substr($content['url'], 2, 6) == 'player' || substr($content['url'], 8, 5) == 'vimeo'){
                        $player = 'vimeo';
                        $video_ID = substr($content['url'], 25);
                      } else {
                        $player = 'youtube';
                        $video_ID = substr($content['url'], 24);
                      } 
                    ?>
                  <div class="h-3">
                    <div>
                      <?php if (!empty($content['url'])) { ?>
                      <a class="content_nav blue-text card-title click_card" data-id="<?php echo $content['id'];?>" data-current-row="<?php echo $count;?>" data-src="<?php echo $content['url'];?>" data-video="<?php echo $player;?>" data-video-id="<?php echo $video_ID;?>" src="<?php echo $content['url'];?>">
                        <div class="text-center text_content text_content_<?php echo $count;?> text_content_id_<?php echo $content['id'];?>">
                          <div class="view">
                            <div class="embed-responsive embed-responsive-16by9" style="cursor: pointer;">
                              <img class="lazyframe embed-responsive-item rounded" data-src="<?php echo $content['url']; ?>" data-vendor="vimeo">
                              </img> 
                            </div>
                          </div>
                            <div class="content_progress progress md-progress ml-2 mr-2 progress_<?php echo $content['id'];?>" style="height: 4px;">
                            </div>
                            <p class="duration float-right mr-2 text-white p-0 duration_<?php echo $content['id'];?>" style="font-size: 12px;"></p>
                          <div class="flex-1">
                            <h6 class="m-2 text-left"><span class="green-text watched_<?php echo $content['id'];?> mr-1">
                            </span><strong><?php echo $c.') '.ucfirst($content['name']);?></strong></h6>     
                          </div>
                          <span id="content_rating_<?php echo $content['id'];?>">
                          </span>
                        </div>
                      </a>
                      <?php } else { ?>
                      <a style="cursor: pointer;" class="content_nav blue-text card-title click_card" data-id="<?php echo $content['id'];?>" data-current-row="<?php echo $count;?>" data-src="<?php echo $content['url'];?>" data-video="<?php echo $player;?>" data-video-id="<?php echo $video_ID;?>">
                        <div class="rounded card text-center text_content text_content_<?php echo $count;?> text_content_id_<?php echo $content['id'];?>">
                          <div class="card-body py-5 px-5 my-5">
                            <h6 class=""><?php echo $c.') '.ucfirst($content['name']);?></h6>
                          </div>
                        </div>
                      </a>
                      <?php } ?>
                    </div><!--slider-->
                  </div><!--h-3-->
                  <?php $c++; $count++;} ?>
                <?php } ?>
              </section>
            </div><!--Row-->
          </div><!--Lesson ID-->
        </div><!-- Section ID-->
      <?php } } ?>
      </div><!--My List-->
    </div><!--Column-->
  </div><!--Row-->
</div><!--Container-->
</main><!--Main layout-->
<script src="<?php echo base_url();?>assets/plugins/player/player.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  var course_slug = '<?php echo $courses['slug']; ?>';
  $.getJSON('<?php echo base_url(); ?>check-purchase/'+course_slug, function(data) {
    if (!data.is_my_purchase) {
      toastr.error('This content is not available in your purchase');
      setTimeout(function() {
         window.location.href = base_url;
      }, 1000);
    }
  });
});
</script>
<script type="text/javascript">
$(document).ready(function() {
  var slug = '<?php echo $slug; ?>';
  var course_slug = '<?php echo $courses['slug']; ?>';
  var section_slug = '<?php echo $sections['slug']; ?>';
  mypurchase(slug, course_slug, section_slug);
  watched();

  $(document).on('click', '.submit_rating', function(){
    var content_ID = $(this).data('content-id');
    var rating = $('#feedback_rating_'+content_ID).val();
    var feedback = $('#feedback_'+content_ID).val();
    if(rating != ''){
      $.ajax({
        url:"<?=base_url()?>courses/submit_rating",
        method:"POST",
        async : true,
        dataType : 'json',
        data:{content_ID:content_ID, rating:rating, feedback:feedback},
        success:function(data) {
          toastr.success('Review submitted');
          $('#add_rating_'+content_ID).remove();
        }
      })
    } else {
     toastr.error('Add rating');
    }
  });

  if(window.location.hash != ''){ 
    var hash = document.URL.substr(document.URL.indexOf('#')+1);
    $('.content_id'+hash).show(); 
    $('.text_content_id_'+hash).addClass('border border-primary rounded-lg'); 
    if($('.content_id'+hash).data('src')){
      var src = $('.content_id'+hash).data('src');
      var vimeo_ID = $('.content_id'+hash).data('video-id');
      var content = $('.content_id'+hash).data('id');
      createvideo(src, vimeo_ID, content);
    } 
    if(hash.substring(0,6) == 'lesson'){
      var lesson = hash.substring(7);
      $('html, body').animate({
        scrollTop: $('#lesson'+lesson).offset().top
      }, 'slow');
    }
  }

  function createvideo(src, vimeo_ID, content, next_row){
    var options = {
      url: src,
      width: 640,
      height: 480,
      autoplay: true,
    };
    var player = new Vimeo.Player('content_url_'+content, options);
    let playing = true;

    function get_progress(handle_data) {
      $.ajax({
        type : "POST",
        url  : base_url +"users/get_progress",
        dataType : "JSON",
        data : {content:content, src:src},
        success: function(data){
          if(data.status == true){
            handle_data(data.progress);
            if(section_slug != '005-live-mastermind-group-coaching'){
              if(data.finished == 0){
                simulationTime(data.progress);
              }
            }
          } else {
            handle_data(0);
            if(section_slug != '005-live-mastermind-group-coaching'){
              simulationTime(0);
            }
          }
        }
      });
    }

    player.ready().then(function() {
    }).catch(function(error) {
      switch (error.name) {
        case 'TypeError':
          toastr.error('The id was not a number.');
          break;
        case 'PasswordError':
          toastr.error('The video is password-protected');
          break;
        case 'PrivacyError':
          toastr.error('The video is password-protected');
          break;
        default:
          toastr.error('Some error occurred. Please refresh page or contact Support.');
          break;
      }
    });

    player.on('ready', function(){
      player.unmute();
    });

    get_progress(function(output){
      player.setCurrentTime(Math.round(output));
      player.on('ended', function(output){
         player.setCurrentTime(0);
      });
    });

    player.on('play', function(){
      player.off('play');
      player.on('timeupdate', onPlayProgress);
      player.on('ended', finished);
      player.play();
    });

    function onPlayProgress(data) {
      var duration = data.duration;
      var progress = data.seconds;
      $.ajax({
        type : "POST",
        url  : base_url +"users/track_progress",
        dataType : "JSON",
        data : {duration:duration, progress:progress, src:src, content:content},
        success: function(data){
        }
      });
    }

    function finished() {
      $.ajax({
        type : "POST",
        url  : base_url +"users/finished_watched",
        dataType : "JSON",
        data : {src:src, content:content},
        success: function(data){
          if(data.error){
            toastr.info('Next video will play in 2 seconds.');
            setTimeout(function() {
              toastr.info('Next video will play in 1 second.');
            }, 2000);
            toastr.success(' 50 Exp Gained!');
            var html = '';
            html += '<i class="fas fa-check-circle"></i>';
            $('.watched_'+content).html(html);
            setTimeout(function() {
              get_video(next_row);
              goto(next_row);
            }, 2000);
          } 
        }
      });
    }

    // Disallow skipping/forwarding
    function simulationTime(simulationTime) {
      player.on('seeked', function(e) {
        if (e.seconds > simulationTime) {
            player.setCurrentTime(simulationTime).then(function(seconds) {
             }).catch(function(error) {
              switch (error.name) {
                case 'RangeError':
                  break;
                default:
                  break;
              }
            });
        } else {
          simulationTime = data.seconds;
        }
      });
      window.setInterval(function() {
        if (playing) {
          simulationTime++;
        }
      }, 1000);
    }

    // Pause video when browser leave
    document.addEventListener("visibilitychange", function() {
      if (document.hidden){
        player.pause();
      }
    });
  }

  function mypurchase(slug, course_slug, section_slug){
    var nxt = '<?php echo $sections['row']; ?>';
    $.ajax({
      type  : 'post',
      url   : "<?=base_url()?>users/my_purchases_by_section",
      async : true,
      dataType : 'json',
      data : {course_slug:course_slug, slug:slug},
      success : function(data){
        var html = '';
        var i;
        for(i=0; i<data.length; i++){
          if(section_slug == data[i].section_slug){
            html += '<a class="dropdown-item waves-effect waves-light blue-text" href="<?php echo base_url(); ?>modules/'+data[i].slug+'/'+data[i].course_slug+'/'+data[i].section_slug+'">'+data[i].section_name+'</a>';
          } else {
            html += '<a class="dropdown-item waves-effect waves-light" href="<?php echo base_url(); ?>modules/'+data[i].slug+'/'+data[i].course_slug+'/'+data[i].section_slug+'">'+data[i].section_name+'</a>';
          }
        }
        $('#section_dropdown').html(html);
      }
    });
    $.ajax({
      type  : 'post',
      url   : "<?=base_url()?>users/my_purchases",
      async : true,
      dataType : 'json',
      data : {slug:slug},
      success : function(data){
        var html = '';
        var i;
        for(i=0; i<data.length; i++){
          if(course_slug == data[i].course_slug){
            html += '<a class="dropdown-item waves-effect waves-light blue-text" href="<?php echo base_url(); ?>modules/'+data[i].slug+'/'+data[i].course_slug+'/'+data[i].section_slug+'">'+data[i].title+'</a>';
          } else {
            html += '<a class="dropdown-item waves-effect waves-light" href="<?php echo base_url(); ?>modules/'+data[i].slug+'/'+data[i].course_slug+'/'+data[i].section_slug+'">'+data[i].title+'</a>';
          }
        }
        $('#course_dropdown').html(html);
      }
    });
  }

  $("#listSearch").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $('.collapse').addClass("show");
    $(".myList .h-1").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
    $(".myList-2 .h-2").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
    $(".myList-3 .h-3").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });

  function watched() {
    $.ajax({
      type : "POST",
      url  : base_url +"users/all_watched_video",
      dataType : "JSON",
      success: function(data){
        for(i=0; i<data.length; i++){
          var html = '';
          html += '<i class="fas fa-check-circle"></i>';
          $('.watched_'+data[i].content_ID).html(html);
        }
      }
    });
    $.ajax({
      type : "POST",
      url  : base_url +"users/get_current_progress",
      dataType : "JSON",
      success: function(data){
        for(i=0; i<data.length; i++){
          var html = '';
          if(data[i].status == 1){
            var percentage = 100;
          } else {
            var percentage = Math.round(((data[i].progress / data[i].duration) * 100)); 
          }
          html += '<div class="progress-bar bg-success" role="progressbar" style="width: '+percentage+'%; height: 20px" aria-valuenow="'+data[i].progress+'" aria-valuemin="0" aria-valuemax="'+data[i].duration+'"></div>';
          $('.progress_'+data[i].content_ID).html(html);
          
        }
      }
    });
    $.ajax({
      type : "POST",
      url  : base_url +"users/all_videos",
      dataType : "JSON",
      success: function(data){
        for(i=0; i<data.length; i++){
          $('.duration_'+data[i].content_ID).text(secondsTimeSpanToHMS(Math.round(data[i].duration)));
        }
      }
    });
    $.ajax({
      type  : 'post',
      url   : "<?=base_url()?>courses/get_content_ratings",
      dataType : 'json',
      data : {section_slug:section_slug},
      success : function(data){
        var i;
        for(i=0; i<data.length; i++){
          if(data[i].average - Math.floor(data[i].average)){
            var r = 1;
          } else {
            var r = 0;
          }
          
          var html = '';
          while(data[i].average > r){
            html +='<i class="fas fa-star amber-text"></i>';
            r++;
          }

          if(data[i].average - Math.floor(data[i].average)){
            html += '<i class="fas fa-star-half amber-text"></i>';
          }
      
          $('#content_rating_'+data[i].content_ID).html(html);
        }
      }
    });
  }

  function secondsTimeSpanToHMS(s) {
    var h = Math.floor(s/3600); //Get whole hours
    s -= h*3600;
    var m = Math.floor(s/60); //Get remaining minutes
    s -= m*60;
    return h+":"+(m < 10 ? '0'+m : m)+":"+(s < 10 ? '0'+s : s); //zero padding on minutes and seconds
  }

  $('.content_nav').on('click', function() {
    var current_row = $(this).data('current-row'); 
    var video = $(this).data('video'); 
    var src = $(this).data('src');
    if(src && video == 'vimeo'){
      var next_row = current_row+1;
      var vimeo_ID = $(this).data('video-id');
      var content = $(this).data('id');
      createvideo(src, vimeo_ID, content, next_row);
    }
    goto(current_row);
  }); 

  $('.next_content').on('click', function() {
    var current_row = $(this).data('current-row'); 
    var next_row = current_row+1;
    goto(next_row);
  }); 

  $('.prev_content').on('click', function() {
    var current_row = $(this).data('current-row'); 
    var prev_row = current_row-1;
    goto(prev_row);
  }); 

  function goto(current){
    $('.text_content_'+current).addClass('border border-primary rounded-lg');
    $('.text_content').not(".text_content_"+current).removeClass('border border-primary rounded-lg'); 
    $('.current_row_'+current).show(); 
    $('.content-pane').not(".current_row_"+current).hide(); 
    if(!$('.current_row_'+current).length){
      next_module();
    }
    $('html, body').animate({
      scrollTop: $('#main_header').offset().top
    }, 1000);
    var video = $('.current_row_'+current).data('video'); 
    if(video == 'vimeo'){
     get_video(current);
    }
  }

  function get_video(video_row){
    var src = $('.current_row_'+video_row).data('src');
    var vimeo_ID = $('.current_row_'+video_row).data('video-id');
    var content = $('.current_row_'+video_row).data('id');
    createvideo(src, vimeo_ID, content, video_row);
  }

  function next_module(){
    $.ajax({
      type : "POST",
      url  : base_url +"users/next",
      dataType : "JSON",
      data : {course_slug:course_slug, section_slug:section_slug},
      success: function(data){
        window.location.replace("<?php echo base_url(); ?>modules/"+slug+"/"+data.course_slug+"/"+data.section_slug+"");
      }
    });
  }
});
</script>
<script type="text/javascript">
$(document).ready(function(){
  $('.center').slick({
    infinite: false,
    slidesToShow: 3,
    slidesToScroll: 3,
    responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2,
        infinite: false,
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    }
  ]
  });
});
</script>