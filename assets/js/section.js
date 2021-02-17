(function($, document, window){
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
  
  watched();
  function watched() {
    $.ajax({
      type : "POST",
      url  : base_url +"users/all_watched_video",
      dataType : "JSON",
      success: function(data){
         for(i=0; i<data.length; i++){
            var html = '';
            html += '<i class="fas fa-check-circle"></i> Watched!';
            $('.watched_'+data[i].content_ID).html(html);
          }
      }
    });
  }

  function createvideo(src, vimeo_ID, content){
    var options = {
      id: vimeo_ID,
      width: 640,
      height: 480
    };

    var player = new Vimeo.Player('content_url_'+vimeo_ID, options);
    function get_progress(handle_data) {
      $.ajax({
        type : "POST",
        url  : base_url +"users/get_progress",
        dataType : "JSON",
        data : {content:content, src:src},
        success: function(data){
          if(data.status){
            handle_data(data.progress);
          } else {
            handle_data(0);
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
          toastr.error('Some other error occurred');
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
      var progress = data.seconds;
      $.ajax({
        type : "POST",
        url  : base_url +"users/track_progress",
        dataType : "JSON",
        data : {progress:progress, src:src, content:content},
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
            toastr.success(' 50 Exp Gained!');
            var html = '';
            html += '<i class="fas fa-check-circle"></i> Watched!';
            $('.watched_'+content).html(html);
          } 
        }
      });
    }
  }

  $('.content_nav').on('click',function(){
    var src = $(this).data('src');
    var vimeo_ID = $(this).data('video-id');
    var content = $(this).data('id');
    createvideo(src, vimeo_ID, content);
  });

})(jQuery, document, window);