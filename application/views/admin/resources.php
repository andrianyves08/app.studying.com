<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <div class="card mb-4 wow fadeIn">
    <div class="card-body d-sm-flex justify-content-between">
      <h4 class="mb-2 mb-sm-0 pt-1">
        <span><a href="<?php echo base_url();?>admin">Home</a></span>
        <span>/</span>
        <span>Resources</span>
      </h4>
    </div>
  </div>
  <!-- Heading -->

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <table class="table table-bordered display table-responsive-md" cellspacing="0" width="100%">
            <thead>
              <th>Title</th>
              <th>Type</th>
              <th>Categories</th>
              <th>Date Uploaded</th>
              <th>Uploaded By</th>
              <th></th>
            </thead>
            <tbody>
              <?php foreach($resources as $resource){ ?> 
                <tr>
                  <td><?php echo $resource['title'];?></td>
                  <td>
                    <?php if($resource['type'] == '1'){?>
                      Blogs
                    <?php } else { ?>
                      Articles
                    <?php } ?>
                  </td>
                  <td>
                    <?php foreach($categories as $category){ ?> 
                      <?php if($resource['resource_ID'] == $category['resource_ID']){ ?> 
                        <?php echo ucwords($category['category_name']) ;?>,
                      <?php } ?>
                    <?php } ?>
                  </td>
                  <td><?php echo $resource['timestamp'];?></td>
                  <td><?php echo ucwords($resource['first_name']);?> <?php echo ucwords($resource['last_name']);?></td>
                  <td><a class="btn btn-sm btn-primary" href="<?php echo base_url('admin/resources/edit'); ?>/<?php echo $resource['resources_ID'];?>"> Edit</a></td>
                </tr>
              <?php }?>
            </tbody>
          </table>
          <a class="btn btn-primary" href="<?php echo base_url(); ?>admin/resources/create">Create Posts</a>
        </div><!--Card Body-->
      </div><!--Card-->
    </div><!--Column-->
  </div><!--Row-->
</div><!--Container-->
</main><!--Main laypassed out-->