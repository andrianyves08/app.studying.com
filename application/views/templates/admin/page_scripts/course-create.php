<script>
$(document).ready(function(){
  var r=0;
  $('#addcontent_2').click(function(){
    r++;
    $('#dynamic_content_2').append('<div id="row_2'+r+'"><br><div class="form-group"><label for="contentitle">* Title</label><input type="text" class="form-control" name="contentitle[]" id="contentitle_'+r+'"></div><div class="form-group"><label for="contentitle">URL <h6 class="red-text">NOTE: Vimeo URL should start with https://vimeo... or //player...</h6></label><input type="text" class="form-control" name="content_url[]" id="content_url_'+r+'"></div><label>Content</label><textarea class="multipletextarea_2 multiple_2_'+r+'" name="content[]" id="content_'+r+'" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" data-multiple-2-summernote="'+r+'"></textarea><a type="button" name="remove" id="'+r+'" class="btn_remove btn btn-sm btn-danger float-right">DELETE</a></div>');
    $(document).ready(function(){
      $('.multipletextarea_2').each(function(){
        var summernoteID = $(this).data('multiple-2-summernote');
        $(this).summernote({
          disableDragAndDrop: true,
          dialogsInBody: true,
          height: "200px",
          callbacks: {
            onImageUpload: function(image) {
              uploadImage2(image[0], summernoteID);
            }
          },
          addclass: {
            debug: false,
            classTags: [{title:"Button","value":"btn btn-success"},{title:"Button","value":"btn btn-primary"}]
          },
          toolbar: [
            ['style', ['style', 'addclass']],
            ['font', ['bold', 'underline', 'clear', 'fontsize']],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture']],
            ['view', ['fullscreen', 'codeview', 'help']],
          ],
        });
      });
    });

    function uploadImage2(image, summernoteID) {
      var data = new FormData();
      data.append("image", image);
      $.ajax({
        url: "<?=base_url()?>courses/upload_image",
        cache: false,
        contentType: false,
        processData: false,
        data: data,
        type: "POST",
        success: function(url) {
          $('.multiple_2_'+summernoteID).summernote('insertImage', url);
        },
        error: function(data) {
          console.log(data);
        }
      });
    }
  });
  $(document).on('click', '.btn_remove', function(){
    var button_id = $(this).attr("id"); 
    $('#row_2'+button_id+'').remove();
    r--;
  });
});
</script>
<script>
$(document).ready(function(){
  var i=0;
  $('#addcontent').click(function(){
    i++;
    $('#dynamic_content').append('<div id="row'+i+'"><br><div class="form-group"><label for="contentitle">* Content Title</label><input type="text" class="form-control" name="contentitle[]" id="contentitle_'+i+'"></div><div class="form-group"><label for="contentitle">URL <h6 class="red-text">NOTE: Vimeo URL should start with https://vimeo... or //player...</h6></label><input type="text" class="form-control" name="content_url[]" id="content_url_'+i+'"></div><label>Content</label><textarea class="multipletextarea multiple_'+i+'" name="content[]" id="content_'+i+'" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" data-multiple-summernote="'+i+'"></textarea><a type="button" name="remove" id="'+i+'" class="btn_remove btn btn-sm btn-danger float-right">DELETE</a></div>');
      $('.multipletextarea').each(function(){
        var summernoteID = $(this).data('multiple-summernote');
        $(this).summernote({
          disableDragAndDrop: true,
          dialogsInBody: true,
          height: "200px",
          callbacks: {
            onImageUpload: function(image) {
              uploadImage2(image[0], summernoteID);
            }
          },
          addclass: {
            debug: false,
            classTags: [{title:"Button","value":"btn btn-success"},{title:"Button","value":"btn btn-primary"}]
          },
          toolbar: [
            ['style', ['style', 'addclass']],
            ['font', ['bold', 'underline', 'clear', 'fontsize']],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture']],
            ['view', ['fullscreen', 'codeview', 'help']],
          ],
        });
      });

    function uploadImage2(image, summernoteID) {
      var data = new FormData();
      data.append("image", image);
      $.ajax({
        url: "<?=base_url()?>courses/upload_image",
        cache: false,
        contentType: false,
        processData: false,
        data: data,
        type: "POST",
        success: function(url) {
          $('.multiple_'+summernoteID).summernote('insertImage', url);
        },
        error: function(data) {
          console.log(data);
        }
      });
    }
  });

  $(document).on('click', '.btn_remove', function(){
    var button_id = $(this).attr("id"); 
    $('#row'+button_id+'').remove();
    i--;
  });

  $(document).ready(function(){
    $('.textarea').each(function(){
      var summernoteID = $(this).data('summernote-id');
      $(this).summernote({
        disableDragAndDrop: true,
        dialogsInBody: true,
        height: "300px",
        callbacks: {
          onImageUpload: function(image) {
           uploadImage(image[0], summernoteID);
          }
        },
        addclass: {
        debug: false,
        classTags: [{title:"Button","value":"btn btn-success"},{title:"Button","value":"btn btn-primary"}]
      },
      toolbar: [
        ['style', ['style', 'addclass']],
        ['font', ['bold', 'underline', 'clear', 'fontsize']],
        ['fontname', ['fontname']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['link', 'picture']],
        ['view', ['fullscreen', 'codeview', 'help']],
      ],
      });
    });
  });
  function uploadImage(image, summernoteID) {
    var data = new FormData();
    data.append("image", image);
    $.ajax({
      url: "<?=base_url()?>courses/upload_image",
      cache: false,
      contentType: false,
      processData: false,
      data: data,
      type: "POST",
      success: function(url) {
        $('.summernote'+summernoteID).summernote('insertImage', url);
      },
      error: function(data) {
        console.log(data);
      }
    });
  }
});
</script>
<script type="text/javascript">
$(document).ready(function() {
  $( "#accordionEx78" ).sortable({
  placeholder : "ui-state-highlight",
    update  : function(event, ui){
      var sec_order_id = new Array();
      $('#accordionEx78 .sortsection').each(function(){
        sec_order_id.push($(this).data("section-id"));
      });
      $.ajax({
        url:"<?=base_url()?>courses/sort_section",
        method:"POST",
        data:{sec_order_id:sec_order_id},
        success:function(data){
        }
      });
    }
  });
});
</script>
<script type="text/javascript">
$(document).ready(function() {
  $( ".sortablelessons" ).sortable({
    placeholder : "ui-state-highlight",
    update  : function(event, ui){
      var les_order_id = new Array();
      $('.sortablelessons .sortlessons').each(function(){
        les_order_id.push($(this).data("lesson-id"));
      });
      $.ajax({
        url:"<?=base_url()?>courses/sort_lesson",
        method:"POST",
        data:{les_order_id:les_order_id},
        success:function(data){
          if(data){
            $(".alert-danger").hide();
            $(".alert-success ").show();
          } else {
            $(".alert-success").hide();
            $(".alert-danger").show();
          }
        }
      });
    }
  });
});
</script>
<script type="text/javascript">
$(document).ready(function() {
  $( ".sortablecontent" ).sortable({
    placeholder : "ui-state-highlight",
    update  : function(event, ui){
      var con_order_id = new Array();
      $('.sortablecontent .sortcontent').each(function(){
        con_order_id.push($(this).data("content-id"));
      });
      $.ajax({
        url:"<?=base_url()?>courses/sort_content",
        method:"POST",
        data:{con_order_id:con_order_id},
        success:function(data) {
        }
      });
    }
  });
});
</script>
<script type="text/javascript">
$(document).ready(function() {
  $( ".sortablecontentpart" ).sortable({
  placeholder : "ui-state-highlight",
  update  : function(event, ui){
    var con_part_order_id = new Array();
    $('.sortablecontentpart .sortcontentpart').each(function(){
      con_part_order_id.push($(this).data("content-part-id"));
    });
    $.ajax({
      url:"<?php echo site_url('courses/sort_content_part');?>",
      method:"POST",
      data:{con_part_order_id:con_part_order_id},
      success:function(data) {
      }
    });
  }
  });
});
</script>

<script type="text/javascript">
$(document).ready(function(){
  var course_slug = '<?php echo $course['slug'];?>';
  show_section_select();

  //on change lesson base on section chosen
  $('#select_section').change(function(){ 
    var section_id=$(this).val();
    $.ajax({
      url : "<?=base_url()?>courses/get_lesson",
      method : "POST",
      data : {section_id: section_id},
      async : true,
      dataType : 'json',
      success: function(data){
        var html = '';
        var i;
        html += '<option disabled selected>Choose Lesson</option>';
        for(i=0; i<data.length; i++){
          html += '<option value='+data[i].id+'>'+data[i].name+'</option>';
        }
        $('#select_lesson').html(html);
      }
    });
    return false;
  }); 

  $(".delete_section").click(function(){
    var delete_section = $('#del_sec').val();
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>courses/delete_section",
      dataType : "JSON",
      data : {id:delete_section, course_slug:course_slug},
      success: function(data){
        toastr.error('Section Deleted');
        show_section_select();
        location.reload();
      }
    });
    return false;
  });

  $(".delete_content").click(function(){
    var delete_content = $('#del_cont').val();
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>courses/delete_content",
      dataType : "JSON",
      data : {id:delete_content, course_slug:course_slug},
      success: function(data){
        toastr.error('Lesson Deleted');
        show_section_select();
        location.reload();
      }
    });
    return false;
  });

  function show_section_select(){
    var slug = '<?php echo $course['slug'];?>';
    $.ajax({
      type  : 'POST',
      url   : "<?=base_url()?>courses/get_section",
      dataType : 'json',
      data : {slug:slug},
      success : function(data){
        var html = '';
        var i;
        html += '<option disabled selected>Choose Section</option>';
        for(i=0; i<data.length; i++){
          html += '<option value='+data[i].id+'>'+data[i].name+'</option>';
        }
        $('#select_section').html(html);
        $('#delete_section').html(html);
        $('#add_lesson_section').html(html);
      }
    });
  }

  //Get Section to update
  $(document).on('click','.edit_sect',function(e) {
    var id=$(this).attr('id');
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>courses/get_section_2",
      dataType : "JSON",
      data : {id:id},
      success: function(data){
        $('#sectionedit').modal('show');
        $('[name="update_sec_name"]').val(data.name);
        $('[name="update_sec_id"]').val(data.id);
        $('[name="section_status"]').val(data.status);
        $('.switch_label').text('Hidden');
        if(data.status == 1){
          $('#section_status').attr("checked", "checked");
          $('.switch_label').text('Active');
        }
      }
    });
    return false;
  });

  //Update Section
  $('#update_section').on('click',function(){
    var name=$('#update_sec_name').val();
    var id=$('#update_sec_id').val();
    var status=$('#section_status').val();
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>courses/update_section",
      dataType : "JSON",
      data : {update_sec_id:id , update_sec_name:name, course_slug:course_slug, status:status},
      success: function(data){
      if(data.error){
          toastr.error(data.message);
        } else {
          toastr.success('Section name updated.');
          $('[name="update_sec_name"]').val("");
          $('[name="update_sec_id"]').val("");
          $('[name="section_status"]').val("");
          $('#sectionedit').modal('hide');
          location.reload();
        }
      }
    });
    return false;
  });

  //Get Section to delete
  $(document).on("click", ".delete_sec", function() { 
    var id=$(this).attr('id');
    $('#sectiondelete').modal('show');
    $('[name="del_sec"]').val(id);
  });

  //Get Lesson to update
  $(document).on('click','.edit_les',function(e) {
    var id=$(this).attr('id');
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>courses/get_lesson_by_id/"+id,
      dataType : "JSON",
      data : {les_id:id},
      success: function(data){
        $('#lessonedit').modal('show');
        $('[name="update_les_name"]').val(data.name);
        $('[name="update_les_id"]').val(data.id);
        $('[name="lesson_status"]').val(data.status);
        $('.switch_label').text('Hidden');
        if(data.status == 1){
          $('#lesson_status').attr("checked", "checked");
          $('.switch_label').text('Active');
        }
      }
    });
    return false;
  });

  //update lesson
  $('#update_lesson').on('click',function(){
    var name=$('#update_les_name').val();
    var id=$('#update_les_id').val();
    var status=$('#lesson_status').val();
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>courses/update_lesson",
      dataType : "JSON",
      data : {update_les_id:id , update_les_name:name, course_slug:course_slug, status:status},
      success: function(data){
        if(data.error){
          toastr.error(data.message);
        } else {
          toastr.success('Lesson name updated.');
          $('[name="update_les_name"]').val("");
          $('[name="update_les_id"]').val("");
          $('[name="lesson_status"]').val("");
          $('#lessonedit').modal('hide');
          location.reload();
        }
      }
    });
    return false;
  });

  //Get Lesson to delete
  $(document).on("click", ".delete_les", function() { 
    var id=$(this).attr('id');
    $('#lessondelete').modal('show');
    $('[name="del_les"]').val(id);
   });

  //delete lesson
  $('.delete_lesson').on('click',function(){
    var delete_lesson = $('#del_les').val();
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>courses/delete_lesson",
      dataType : "JSON",
      data : {id:delete_lesson, course_slug:course_slug},
      success: function(data){
        toastr.error('Lesson Deleted');
        show_section_select();
        location.reload();
      }
    });
    return false;
  });

  //Get lesson for adding content
  $(document).on('click','.add_cont',function(e) {
    var id=$(this).attr('id');
    $('#contentadd').modal('show');
    $('[name="select_lesson"]').val(id);
  });

  //Get content to update
  $(document).on('click','.edit_cont',function(e) {
    var id=$(this).attr('id');
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>courses/get_content_by_id/"+id,
      dataType : "JSON",
      data : {id:id},
      success: function(data){
        $('#contentedit').modal('show');
        $('[name="update_con_name"]').val(data.name);
        $('[name="update_con_url"]').val(data.url);
        $('[name="update_con_thumbnail_orig"]').val(data.thumbnail);
        $('[id="update_con_thumbnail_label"]').text(data.thumbnail);
        $('#update_cont_part').summernote('code', data.content);
        $('[name="update_con_id"]').val(data.id);
        $('[name="content_status"]').val(data.status);
        $('.switch_label').text('Hidden');
        if(data.status == 1){
          $('#content_status').attr("checked", "checked");
          $('.switch_label').text('Active');
        }
      }
    });
    return false;
  });

    //Get Content to delete
  $(document).on("click", ".delete_cont", function() { 
    var id=$(this).attr('id');
    $('#contentdelete').modal('show');
    $('[name="del_cont"]').val(id);
  });
});
</script>
  </body>
</html>