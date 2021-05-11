<main class="pt-5 mx-lg-5">
  <div class="container-fluid mt-5">
    <section>
      <div class="row justify-content-center mr-2 mb-4">
        <div class="col-lg-4 mb-4">
          <div class="input-group mb-3">
            <input type="text" class="form-control form-control-sm" placeholder="Search Message" aria-describedby="button-addon4" id="search_user">
            <div class="input-group-append" id="button-addon4">
              <button class="btn btn-sm btn-primary m-0 px-3 py-2 z-depth-0 waves-effect" type="button" data-toggle="modal" data-target="#send_chat">Create a message</button>
              <button class="btn btn-sm btn-secondary m-0 px-3 py-2 z-depth-0 waves-effect" type="button"  data-toggle="modal" data-target="#create_group">Create a group</button>
            </div>
          </div>
          <div class="card wide overflow-auto" id="my_friends" style="height: 750px;">
          </div><!-- Card -->
        </div> <!--Column-->
        <div class="col-lg-8">
          <div class="card chat-room small-chat wide" id="messages" style="height: 800px;">
          </div><!--Card-->
        </div><!--Column-->
      </div><!--Row-->
    </section>
  </div><!--Contaier-->
</main>
<!-- Create Chat -->
<div data-backdrop="static" class="modal fade" id="send_chat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="heading lead">Create Message</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="formGroupExampleInput">* Select Name</label>
          <select name="email" id="email" class="select2" style="width: 100%;">
            <?php foreach ($all_users as $users) { ?>
              <option value='<?php echo $users['id']; ?>'><?php echo ucwords($users['first_name']); ?> <?php echo ucwords($users['last_name']); ?></option>
            <?php } ?>
          </select>
        </div>
        <textarea class="textarea" name="chat_message" id="create_message" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
      </div><!--Modal Body-->
      <div class="modal-footer justify-content-center">
        <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancel</a>
        <button class="btn btn-primary waves-effect float-right" type="submit" id="createamessage">Send Message</button>
      </div>
    </div><!--Content-->
  </div>
</div>
<!-- Create Group -->
<div data-backdrop="static" class="modal fade" id="create_group" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="heading lead">Create Group</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>
      <?php echo form_open_multipart('messages/create_group'); ?>
      <div class="modal-body">
        <div class="form-group">
          <label for="formGroupExampleInput">* Enter Group Name</label>
          <input type="text" class="form-control" name="group_name" id="group_name">
        </div>
        <div class="form-group">
          <label for="formGroupExampleInput">* Members</label>
          <select name="members[]" id="members" class="select2" multiple="multiple" data-placeholder="Select members" style="width: 100%;">
          </select>
        </div>
      </div><!--Modal Body-->
      <div class="modal-footer justify-content-center">
        <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancel</a>
        <button class="btn btn-primary waves-effect float-right" type="submit">Create Group</button>
      </div>
      <?php echo form_close(); ?>
    </div><!--Content-->
  </div>
</div>
<!-- View Members -->
<div data-backdrop="static" class="modal fade" id="view_members" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-md modal-notify modal-info" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">Members</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <ul class="list-group list-group-flush" id="list_members">
        </ul>
      </div><!--Modal Body-->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div><!--Content-->
  </div>
</div>
<!-- Add Members -->
<div data-backdrop="static" class="modal fade" id="add_members" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-md modal-notify modal-success" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">Members</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
        <label for="formGroupExampleInput">* Enter Email</label>
        <input type="hidden" class="form-control" name="group" id="group">
          <input type="email" class="form-control" name="new_member" id="new_member">
        </div>
      </div><!--Modal Body-->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button class="btn btn-primary waves-effect btn-sm float-right" type="submit" id="add_member">Add Member</button>
      </div>
    </div><!--Content-->
  </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
  $("#search_user").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#my_friends .start_chat").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });

  var limit = 10;
  fetch_user();
  friends();
  get_user_status();
 
  setInterval(function(){
    update_chat_history_data();
    update_group_chat_history_data();
    get_user_status();
  }, 5000);
  setTimeout(start, 1000);

  function get_user_status(){
    $.ajax({
      type  : 'post',
      url   : "<?=base_url()?>messages/get_users_status",
      async : true,
      dataType : 'json',
      success : function(data){
        var html = '';
        var i;
        for(i=0; i<data.length; i++){
          var date = new Date(data[i].status);
          var now = new Date();
          var FIVE_MIN=1*60*1000;

          // if one minute ago
          if((now - new Date(date)) > FIVE_MIN) {
            $('.last_login_'+data[i].user_ID).html(data[i].last_login);
          } else {
            $('.last_login_'+data[i].user_ID).html('<i class="fas fa-circle text-success"></i>');
          }

          if(data[i].count != 0){
            $('.new_messages_'+data[i].user_ID).show();
            $('.new_messages_'+data[i].user_ID).html(data[i].count);
          } else {
            $('.new_messages_'+data[i].user_ID).hide();
          }

        }
      }
    });
  }

  function start(){
    var group_ID = 1;
    var full_name = '#general';
    limit = 10;
    make_group_chat_dialog_box(1, full_name);
    $('#message_header1').addClass("bg-light");
  };

  function friends(){
    $.ajax({
      type  : 'post',
      url   : "<?=base_url()?>messages/get_friends",
      async : true,
      dataType : 'json',
      success : function(data){
        var html = '';
        var i;
        for(i=0; i<data.length; i++){
          html += '<option value='+data[i].user_ID+'>'+data[i].first_name+' '+data[i].last_name+'</option>';
        }
        $('#members').html(html);
      }
    });
  }

  function fetch_user(){
    $.ajax({
      type  : 'post',
      url   : "<?=base_url()?>messages/get_users",
      dataType : 'json',
      success : function(data){
        $('#my_friends').html(data);
      }
    });
  }

  $(document).on('click', '.replay', function(){
    var chat_ID = $(this).data('message-id');
    var messages = $(".chat_texts_"+chat_ID).text();
    $(".replying").text(messages);
    $(".send").data("chat-id", chat_ID);
    $(".send").attr("data-chat-id", chat_ID);
    $(".clear_replay").show();
  });

  $(document).on('click', '.group_replay', function(){
    var chat_ID = $(this).data('message-id');
    var messages = $(".chat_texts_"+chat_ID).text();
    $(".replying").text(messages);
    $(".group_send").data("chat-id", chat_ID);
    $(".group_send").attr("data-chat-id", chat_ID);
    $(".clear_replay").show();
  });

  $(document).on('click', '.clear_replay', function(){
    $(".replying").text('');
    $(".clear_replay").hide();
  });

  //Create Message
  $('#createamessage').on('click',function(){
    var email=$('#email').val();
    var mes=$('#create_message').val();
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>messages/create_message",
      dataType : "JSON",
      data : {user_ID:email , chat_message:mes},
      success: function(data){
        if(data.error){
            toastr.error(data.message);
        } else {
          toastr.success('Message Sent.');
          $('[name="email"]').val("");
          $('#create_message').val("");
          $('#send_chat').modal('hide');
          fetch_user();
        }
      }
    });
    return false;
  });

  $(document).on('click', '.start_chat', function(){
    var header = $(this).attr('id');
    var usID = $(this).data('id');
    var first_name = $(this).data('name');
    var last_name = $(this).data('last');
    limit = 10;
    make_chat_dialog_box(usID, first_name, last_name);
    $('#message_header'+header).addClass("bg-light");
    $('.message_header').not("#message_header"+header).removeClass("bg-light"); 
  });

  $(document).on('click', '.viewmore', function(){
    var to_user_id = $(this).data('user-id');
    limit = limit + 10;
    $.ajax({
      method  : 'post',
      url   : "<?=base_url()?>messages/get_messages",
      dataType : 'json',
      async : true,
      data:{user_ID:to_user_id, limit:limit},
      beforeSend:function(){
        $(".viewmore").text("Loading...");
      },
      success: function(data){
        $('#chat-messages_'+to_user_id).html(data);
        $(".viewmore").text("View More");
        if(!$.trim(data)) {
          $(".viewmore").hide();
        }
      }
    });
  });

  $(document).on('click', '.send', function(){
    var to_user_id = $(this).data('sender-id');
    var chat_ID = $(this).data('chat-id');
    var message = CKEDITOR.instances['message'].getData();
    if(message != ''){
      $.ajax({
        url:"<?=base_url()?>messages/send_message",
        method:"POST",
        async : true,
        dataType : 'json',
        data:{user_ID:to_user_id, chat_message:message, chat_ID:chat_ID},
        success:function(data) {
          toastr.success(' 10 Exp Gained!');
          fetch_user_chat_history(to_user_id);
          fetch_user();
          CKEDITOR.instances['message'].setData('');
          $(".replying").text('');
          $(".clear_replay").hide();
          $(".send").data("chat-id", 0);
        }
      })
    } else {
     toastr.error('Enter a message');
    }
  });
   
  function make_chat_dialog_box(to_user_id, first_name, last_name) {
    var message_content = '<div class="card-header white d-flex justify-content-between p-2 fixed"><div class="heading d-flex justify-content-start"><div class="data"><p class="name mb-0"><strong>'+first_name+' '+last_name+'</strong></p></div></div><div class="icons grey-text"><a class="feature"></a></div></div><div class="my-custom-scrollbar overflow-auto p-3"><a><p class="text-center blue-text font-italic viewmore" data-user-id="'+to_user_id+'">View More</p></a><div class="chat-messages" id="chat-messages_'+to_user_id+'" data-touserid="'+to_user_id+'">';
    fetch_user_chat_history(to_user_id);
    message_content += '</div></div><div class="card-footer white text-muted pt-1 pb-2 px-3" style="margin-top: auto;"><div class="d-flex justify-content-center"><div class="replying"></div><a class="clear_replay font-weight-bold red-text ml-5" style="display: none;">X</a></div><div id="message"></div><button class="btn btn-primary btn-sm send float-right" data-sender-id="'+to_user_id+'" data-chat-id="0">Send</button></div>';
    $('#messages').html(message_content);
    createNewEditor();
  }

  function fetch_user_chat_history(to_user_id){
    $.ajax({
      method  : 'post',
      url   : "<?=base_url()?>messages/get_messages",
      dataType : 'json',
      async : true,
      data:{user_ID:to_user_id, limit:limit},
      success : function(data){
        $('#chat-messages_'+to_user_id).html(data);
      }
    });
  }

  $(document).on('click', '.group_view_more', function(){
    var group_ID = $(this).data('group-id');
    limit = limit + 10;
    $.ajax({
      method  : 'post',
      url   : "<?=base_url()?>messages/get_group_messages",
      dataType : 'json',
      data:{group_ID:group_ID, limit:limit},
      beforeSend:function(){
        $(".group_view_more").text("Loading...");
      },
      success : function(data){
        $('#chat_group_messages_'+group_ID).html(data);
        $(".group_view_more").text("View More");
        if(!$.trim(data)) {
          $(".group_view_more").hide();
        }
      }
    });
  });

  function update_chat_history_data(){
    $('.chat-messages').each(function(){
      var to_user_id = $(this).data('touserid');
      fetch_user_chat_history(to_user_id);
    });
  }

  $(document).on('click', '.delete_chat', function(){
    var del = $(this).attr('id');
    if(confirm("Are you sure you want to remove this chat?")){
      $.ajax({
        type : "POST",
        url  : "<?=base_url()?>messages/delete_message",
        dataType : "JSON",
        async : true,
        data : {chat:del},
        success: function(data){
          toastr.success('Message Deleted');
          update_chat_history_data();
        }
    });
    }
  });

  $(document).on('click', '.group_send', function(){
    var group_ID = $(this).data('group-id');
    var message = CKEDITOR.instances['group_message'].getData();
    var chat_ID = $(this).data('chat-id');
    if(message != ''){
      $.ajax({
        url:"<?=base_url()?>messages/send_group_message",
        method:"POST",
        async : true,
        dataType : 'json',
        data:{group_ID:group_ID, chat_message:message, chat_ID:chat_ID},
        success:function(data) {
          toastr.success(' 10 Exp Gained!');
          CKEDITOR.instances['group_message'].setData('');
          fetch_group_chat_history(group_ID);
          $(".replying").text('');
          $(".clear_replay").hide();
          $(".group_send").data("chat-id", 0);
        }
      })
    } else {
      toastr.error('Enter a message');
    }
  });

  function make_group_chat_dialog_box(group_ID, group_name) {
    var group_message_content = '<div class="card-header white d-flex justify-content-between p-2 fixed"><div class="heading d-flex justify-content-start"><div class="data"><p class="name mb-0"><strong>'+group_name+'</strong></p></div></div><div class="icons grey-text"><a class="add_new_member" id="'+group_ID+'"><i class="fas fa-user-plus mr-2"></i></a><a class="show_list" id="'+group_ID+'"><i class="fas fa-users mr-2"></i></a></div></div><div class="my-custom-scrollbar overflow-auto p-3"><a><p class="text-center blue-text font-italic group_view_more" data-group-id="'+group_ID+'">View More</p></a><div class="chat_group_messages" id="chat_group_messages_'+group_ID+'" data-group-id="'+group_ID+'">';
    fetch_group_chat_history(group_ID);
    group_message_content += '</div></div><div class="card-footer text-muted white pt-1 pb-2 px-3" style="margin-top: auto;"><div class="d-flex justify-content-center"><div class="replying"></div><a class="clear_replay font-weight-bold red-text ml-5" style="display: none;">X</a></div><div id="group_message"></div><button class="btn btn-primary btn-sm group_send float-right" data-group-id="'+group_ID+'" data-chat-id="0">Send</button></div>';
    $('#messages').html(group_message_content);
    createGroupNewEditor();
  }

  $(document).on('click', '.start_group_chat', function(){
    var header = $(this).attr('id');
    var group_ID = $(this).data('id');
    var full_name = $(this).data('name');
    limit = 10;
    make_group_chat_dialog_box(group_ID, full_name);
    $('#message_header'+header).addClass("bg-light");
    $('.message_header').not("#message_header"+header).removeClass("bg-light");
  });

  function fetch_group_chat_history(group_ID){
    $.ajax({
      method  : 'post',
      url   : "<?=base_url()?>messages/get_group_messages",
      dataType : 'json',
      data:{group_ID:group_ID, limit:limit},
      success : function(data){
        $('#chat_group_messages_'+group_ID).html(data);
      }
   });
  }

  function update_group_chat_history_data(){
    $('.chat_group_messages').each(function(){
      var group_ID = $(this).data('group-id');
      fetch_group_chat_history(group_ID);
    });
  }

  $(document).on('click', '.delete_group_chat', function(){
    var del = $(this).attr('id');
    if(confirm("Are you sure you want to remove this chat?")){
      $.ajax({
        type : "POST",
        url  : "<?=base_url()?>messages/delete_group_message",
        dataType : "JSON",
        async : true,
        data : {chat:del},
        success: function(data){
          toastr.success('Message Deleted');
          update_group_chat_history_data();
        }
    });
    }
  });

  //View members
  $(document).on('click', '.show_list', function(e) {
    var group_id=$(this).attr('id');
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>messages/get_group_members",
      dataType : "JSON",
      data : {id:group_id},
      success: function(data){
        $('#view_members').modal('show');
        $('#list_members').html(data);
      }
    });
    return false;
  });

  //Add Members 
  $(document).on("click", ".add_new_member", function() { 
    var id=$(this).attr('id');
    $('#add_members').modal('show');
    $('[name="group"]').val(id);
  });

  //Add member
  $('#add_member').on('click',function(){
    var email = $('#new_member').val();
    var group = $('[name="group"]').val();
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>messages/add_member",
      dataType : "JSON",
      data : {id:email, group_id: group},
      success: function(data){
        toastr.success('Member Added');
        $('#add_members').modal('hide');
      }
    });
    return false;
  });

  <?php 
    $all = array();
    foreach ($all_users as $user) {
      if(!empty($user["first_name"]) || !empty($user["first_name"])){
        if($my_id != $user["id"]) {
          $all[] = array(
            'id' =>  $user["id"],
            'fullname' =>  ucwords($user["first_name"]).' '.ucwords($user["last_name"]),
            'avatar' => 'assets/img/users/'.$user['image']
          );
        }
      }
    }
  ?>
  var users = <?php echo json_encode($all); ?>,
  tags = [];

  function createNewEditor() {
    var element = document.createElement("textarea");
    $(element).attr('name', 'message').appendTo('#message');
    return CKEDITOR.replace(element, {
      plugins: 'emoji,basicstyles,undo,wysiwygarea,toolbar,pastetext',
      height: 60,
      width: '99%',
      toolbar: [{
          name: 'document',
          items: ['Undo', 'Redo']
        },
        {
          name: 'links',
          items: ['EmojiPanel']
        }
      ],
      mentions: [{
          feed: dataFeed,
          itemTemplate: '<li data-id="{id}">' +
            '<img class="photo" src="{avatar}" style="width: 25px;"/>' +
            '<span class="fullname"> {fullname}</span>' +
            '</li>',
          outputTemplate: '<a href="./user-profile/{id}">@{fullname}</a><span>&nbsp;</span>',
          minChars: 0
        }
      ]
    });
  }

  function createGroupNewEditor() {
    var element = document.createElement("textarea");
    $(element).attr('name', 'group_message').appendTo('#group_message');
    return CKEDITOR.replace(element, {
      plugins: 'mentions,emoji,basicstyles,undo,link,wysiwygarea,toolbar,pastetext',
      contentsCss: [
        'http://cdn.ckeditor.com/4.16.0/full-all/contents.css',
        'https://ckeditor.com/docs/ckeditor4/4.16.0/examples/assets/mentions/contents.css'
      ],
      height: 60,
      width: '99%',
      toolbar: [{
          name: 'document',
          items: ['Undo', 'Redo']
        },
        {
          name: 'links',
          items: ['EmojiPanel', 'Link', 'Unlink']
        }
      ],
      mentions: [{
          feed: dataFeed,
          itemTemplate: '<li data-id="{id}">' +
            '<img class="photo" src="{avatar}" style="width: 25px;"/>' +
            '<span class="fullname"> {fullname}</span>' +
            '</li>',
          outputTemplate: '<a href="./user-profile/{id}">@{fullname}</a><span>&nbsp;</span>',
          minChars: 0
        }
      ]
    });
  }

  function dataFeed(opts, callback) {
    var matchProperty = 'fullname',
      data = users.filter(function(item) {
        return item[matchProperty].toLowerCase().indexOf(opts.query.toLowerCase()) > -1
      });
    data = data.sort(function(a, b) {
      return a[matchProperty].localeCompare(b[matchProperty], undefined, {
        sensitivity: 'accent'
      });
    });
    callback(data);
  }
});
</script>