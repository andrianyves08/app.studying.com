<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <div class="card mb-4 wow fadeIn">
    <div class="card-body d-sm-flex justify-content-between">
      <h4 class="mb-2 mb-sm-0 pt-1">
        <span><a href="<?php echo base_url();?>admin">Home</a></span>
        <span>/</span>
        <span><a href="<?php echo base_url(); ?>admin/modules">Modules</a></span>
        <span>/</span>
        <span><?php echo ucwords($course['title']);?></span>
      </h4>
    </div>
  </div>
  <!-- Heading -->

  <div class="row">
    <div class="col-md-12 mb-4">
      <div class="accordion md-accordion accordion-blocks" id="accordionEx78" role="tablist" aria-multiselectable="true">
        <?php foreach ($sections as $section) {?>
        <div data-section-id="<?php echo $section["id"]; ?>" class="card sortsection">
          <div class="card-header" role="tab" id="mainsection<?php echo $section['id'];?>">
            <div class="float-right">
              <?php if($section['status'] == 1){ ?>
                <span class="badge badge-pill mr-2 badge-info">Active</span>
              <?php } else { ?>
                <span class="badge badge-pill mr-2 badge-warning">Hidden</span>
              <?php } ?>
              <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                <a type="button" class="btn btn-primary btn-sm edit_sect" id="<?php echo $section['id'];?>"><i class="fas fa-pencil-alt"></i></a>
                <button type="button" class="btn btn-danger btn-sm delete_sec"id="<?php echo $section['id'];?>"><i class="fas fa-trash-alt"></i></button>
              </div>
            </div>
            <a data-toggle="collapse" data-parent="#accordionEx78" href="#section<?php echo $section['id'];?>" aria-expanded="true"
              aria-controls="section<?php echo $section['id'];?>">
              <h3 class="mt-1 mb-0">
                <span style="cursor: all-scroll;"><?php echo $section['name'];?></span>
                <i class="fas fa-angle-down rotate-icon"></i>
              </h3>
            </a>
          </div><!-- Card Header -->
          <div id="section<?php echo $section['id'];?>" class="collapse" role="tabpanel" aria-labelledby="mainsection<?php echo $section['id'];?>"
            data-parent="#accordionEx78">
            <div class="card-body sortablelessons">
              <?php foreach ($lessons as $lesson) {?>
                <?php if ($section['id'] == $lesson['section_ID']) {?>
                  <div class="accordion md-accordion sortlessons" id="mainlesson<?php echo $lesson['id'];?>" role="tablist" aria-multiselectable="true" style="padding-left: 15px;" data-lesson-id="<?php echo $lesson["id"]; ?>">
                    <div class="float-right">
                      <?php if($lesson['status'] == 1){ ?>
                        <span class="badge badge-pill mr-2 badge-info">Active</span>
                      <?php } else { ?>
                        <span class="badge badge-pill mr-2 badge-warning">Hidden</span>
                      <?php } ?>
                      <a class="add_cont" id="<?php echo $lesson['id'];?>"><i class="fas fa-plus green-text"></i></a>
                      <a class="edit_les" id="<?php echo $lesson['id'];?>"><i class="fas fa-pencil-alt blue-text"></i></a>
                      <a class="delete_les" id="<?php echo $lesson['id'];?>"><i class="fas fa-trash-alt red-text"></i></a>
                    </div>
                    <a data-toggle="collapse" data-parent="#mainlesson<?php echo $lesson['id'];?>" href="#lesson<?php echo $lesson['id'];?>" aria-expanded="true"
                      aria-controls="lesson<?php echo $lesson['id'];?>">
                      <h4 class="mt-1 mb-0">
                        <span style="cursor: all-scroll;"><?php echo $lesson['name'];?></span>
                         <i class="fas fa-angle-down rotate-icon"></i>
                      </h4>
                    </a>
                    <div id="lesson<?php echo $lesson['id'];?>" class="collapse" role="tabpanel" aria-labelledby="mainsection<?php echo $section['id'];?>" data-parent="#mainlesson<?php echo $lesson['id'];?>">              
                      <div class="sortablecontent" style="padding-left: 25px;">
                        <?php foreach ($contents as $content) {?>
                          <?php if ($lesson['id'] == $content['lesson_ID']) {?>
                          <div class="row sortcontent" data-content-id="<?php echo $content["id"]; ?>">
                            <ul class="list-group align-middle" role="tablist" style="padding-left: 25px;">
                              <li style="cursor: all-scroll; padding: 0;margin: 0;" class="border-bottom sortcontentpart" ><h5><?php echo $content['name'];?></h5> </li>
                            </ul>
                            <div class="col-4 float-right">
                              <?php if($content['status'] == 1){ ?>
                                <span class="badge badge-pill mr-2 badge-info">Active</span>
                              <?php } else { ?>
                                <span class="badge badge-pill mr-2 badge-warning">Hidden</span>
                              <?php } ?>
                              <a class="edit_cont" id="<?php echo $content['id'];?>"><i class="fas fa-pencil-alt blue-text"></i></a>
                              <a class="delete_cont" id="<?php echo $content['id'];?>"><i class="fas fa-trash-alt red-text"></i></a>
                            </div>
                          </div>
                          <?php } ?>
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                <?php } ?>
              <?php } ?>
              <?php echo form_open_multipart('courses/create_lesson/'.$course['slug']); ?>
              <div class="row pt-3">
                <div class="col-md-6">
                  <div class="input-group mb-3">
                    <input type="hidden" class="form-control" name="secID" id="secID" value="<?php echo $section['id'];?>">
                    <input type="text" class="form-control" placeholder="Lesson Name" aria-label="Lesson Name" aria-describedby="button-addon2" name="lesson_name" id="lesson_name">
                    <div class="input-group-append">
                      <button class="btn btn-md btn-success m-0 px-3 py-2 z-depth-0 waves-effect" id="submit_lesson">Add</button>
                    </div>
                  </div>
                </div>
              </div>
              <?php echo form_close(); ?>
            </div>
          </div>
        </div><!-- Accordion card -->    
      <?php } ?>
      </div>
    </div><!--Grid column-->
  </div><!--Grid row-->

  <div class="row">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <?php echo form_open_multipart('courses/create_section/'.$course['slug']); ?>
          <div class="input-group">
            <input type="hidden" class="form-control" name="cor_id" value="<?php echo $course['id'];?>">
            <input type="text" class="form-control" placeholder="Section" aria-label="Section"
              aria-describedby="button-addon2" name="section_name" id="section_name">
            <div class="input-group-append">
              <button class="btn btn-md btn-success m-0 px-3 py-2 z-depth-0 waves-effect" id="submit_section">Add</button>
            </div>
          </div>
          <?php echo form_close(); ?>
        </div><!--Card-body-->
      </div><!--Card-->
    </div><!--Column-->
    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
          <a type="button" class="btn btn-primary m-0 px-3 py-2 z-depth-0 waves-effect" data-toggle="modal" data-target="#createlesson">Create Content Shortcut</a>
        </div><!--Card-body-->
      </div><!--Card-->
    </div><!--Column-->
  </div><!--Row-->
</div><!--Container-->
</main><!--Main laypassed out-->

<!-- Are you sure -->
<div data-backdrop="static" class="modal fade" id="createlesson" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-success modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="heading lead">Create Content</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php echo form_open_multipart('courses/create_content/'.$course['slug']); ?>
        <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <select class="browser-default custom-select" name="select_section" id="select_section" required>
                </select>
            </div>
            <div class="form-group">
              <select class="browser-default custom-select" id="select_lesson" name="select_lesson" required>
                <option selected disabled>Select Lesson</option>
              </select>
            </div> 
          </div><!--Col-->
        </div><!--Row-->
        <div class="row">
          <div class="col-md-12">
            <div id="dynamic_content">
            </div>
            <button class="btn btn-default waves-effect" id="addcontent" type="button">Add Another Content</button>
          </div><!--Col-->
        </div>
      </div>
      <!--Footer-->
      <div class="modal-footer justify-content-center">
        <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancel</a>
        <button class="btn btn-success waves-effect float-right" type="submit">Save Content</button>
      </div>
      <?php echo form_close(); ?>
    </div><!--/.Content-->
  </div>
</div>

<!-- Section Edit -->
<div data-backdrop="static" class="modal fade" id="sectionedit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-sm modal-notify modal-info" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">Edit Section Name</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="formGroupExampleInput">* Section Name</label>
          <input type="hidden" class="form-control" name="update_sec_id" id="update_sec_id">
          <input type="text" class="form-control mb-4" name="update_sec_name" id="update_sec_name" >
          <label for="section_status">* Status</label>
          <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input customSwitches" id="section_status" name="section_status">
            <label class="custom-control-label switch_label" for="section_status"></label>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-sm" id="update_section">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- Section Edit -->

<!-- Section Delete -->
<div data-backdrop="static" class="modal fade" id="sectiondelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-sm modal-notify modal-danger" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">Delete Section</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this section?
           lesson and content of this section will also be delete.</p>
        <input type="hidden" class="form-control" name="del_sec" id="del_sec" >
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-sm delete_section">Confirm</button>
      </div>
    </div>
  </div>
</div>
<!-- Section Delete -->

<!-- Lesson Edit -->
<div data-backdrop="static" class="modal fade" id="lessonedit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-sm modal-notify modal-info" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">Edit Lesson Name</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>      
      <div class="modal-body">
        <div class="form-group">
          <label for="formGroupExampleInput">* lesson Name</label>
          <input type="hidden" class="form-control" name="update_les_id" id="update_les_id">
          <input type="text" class="form-control" name="update_les_name" id="update_les_name">
        </div>
        <label for="lesson_status">* Status</label>
        <div class="custom-control custom-switch">
          <input type="checkbox" class="custom-control-input customSwitches" id="lesson_status" name="lesson_status">
          <label class="custom-control-label switch_label" for="lesson_status"></label>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-sm" id="update_lesson">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- Lesson Edit -->

<!-- Lesson Delete -->
<div data-backdrop="static" class="modal fade" id="lessondelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-sm modal-notify modal-danger" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">Delete Lesson</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this lesson along with its content?</p>
        <input type="hidden" class="form-control" name="del_les" id="del_les">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-sm delete_lesson">Confirm</button>
      </div>
    </div>
  </div>
</div>
<!-- Lesson Delete -->

<!-- Add Content -->
<div data-backdrop="static" class="modal fade" id="contentadd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-success modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="heading lead">Create Content</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <?php echo form_open_multipart('courses/create_content/'.$course['slug']); ?>
        <input type="hidden" class="form-control" name="select_lesson" id="select_lesson">
        <div id="dynamic_content_2">
        </div>
        <button class="btn btn-default waves-effect" id="addcontent_2" type="button">Add Another Content</button>
      </div>
      <div class="modal-footer justify-content-center">
        <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancel</a>
        <button class="btn btn-success waves-effect float-right" type="submit">Save Content</button>
      </div>
      <?php echo form_close(); ?>
    </div><
  </div>
</div>
<!-- Add Content -->

<!-- Content Edit -->
<div data-backdrop="static" class="modal fade" id="contentedit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg modal-notify modal-info" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">Edit Content</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>      
      <div class="modal-body">
      <?php echo form_open_multipart('courses/update_content'); ?>
        <div class="form-group">
          <label>* Content Title</label>
          <input type="hidden" class="form-control" name="update_con_id" id="update_con_id">
          <input type="hidden" class="form-control mb-4" name="course_slug" id="course_slug" value="<?php echo $course['slug']?>">
          <input type="text" class="form-control mb-4" name="update_con_name" id="update_con_name">
          <label for="content_status">* Status</label>
          <div class="custom-control custom-switch mb-4">
            <input type="checkbox" class="custom-control-input customSwitches" id="content_status" name="content_status">
            <label class="custom-control-label switch_label" for="content_status"></label>
          </div>
          <div class="form-group"><label for="contentitle">URL <h6 class="red-text">NOTE: Vimeo URL should start with https://vimeo... or //player...</h6></label><input type="text" class="form-control" name="update_con_url" id="update_con_url"></div>
          <input type="hidden" class="form-control" name="update_con_thumbnail_orig" id="update_con_thumbnail_orig">
          <label for="image">Thumbnail</label>
          <div class="input-group mb-4">
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="update_con_thumbnail" name="update_con_thumbnail" aria-describedby="inputGroupFileAddon01">
              <label class="custom-file-label text-left" for="update_con_thumbnail" id="update_con_thumbnail_label"></label>
            </div>
          </div>
          <label>Content</label>
          <textarea class="textarea summernote4" name="update_cont_part" id="update_cont_part" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" data-summernote-id="4"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-sm" type="submit">Save changes</button>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>
<!-- Content Edit -->

<!-- Content Delete -->
<div data-backdrop="static" class="modal fade" id="contentdelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-sm modal-notify modal-danger" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">Delete Content</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete content?</p>
        <input type="hidden" class="form-control" name="del_cont" id="del_cont">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-target="#contentdelete" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-sm delete_content" id="<?php echo $content['id'];?>">Confirm</button>
      </div>
    </div>
  </div>
</div>
<!-- Content Delete -->

<script type="text/javascript">
$(document).ready(function() {
  $(".customSwitches").click(function() {
    if($(".customSwitches").is(":checked")){
      $('.switch_label').text('Active');
      $(this).val(1);
    } else {
      $('.switch_label').text('Hidden');
      $(this).val(0);
    }
  });
});
</script>