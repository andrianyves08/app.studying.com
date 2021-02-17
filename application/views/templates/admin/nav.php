<?php 
  // 1 = admin
  // 2 = superadmin
  // 3 = blogger
if($admin_status == '1'){?>
<header>
  <nav class="navbar fixed-top navbar-expand-lg navbar-light white scrolling-navbar">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link waves-effect active">
              <?php echo ucfirst($first_name);?> <?php echo ucfirst($last_name);?>
            </a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle waves-effect waves-light" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <strong><?php echo ucfirst($title);?>
            </strong>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-default" aria-labelledby="navbarDropdownMenuLink">
              <a href="<?php echo base_url();?>admin" class="dropdown-item waves-effect waves-light <?php if($title == 'Home'){ echo 'active';}?> waves-effect">Dashboard<i class="fas fa-chart-pie ml-3"></i></a>
              <a href="<?php echo base_url();?>admin/support" class="dropdown-item waves-effect waves-light <?php if($title == 'Support'){ echo 'active';}?>">Messages<i class="fas fa-comment ml-3"></i></a>
              <a href="<?php echo base_url();?>admin/products" class="dropdown-item waves-effect waves-light <?php if($title == 'Products'){ echo 'active';}?>">Products<i class="fas fa-search-dollar ml-3"></i></a>
              <a href="<?php echo base_url();?>admin/users" class="dropdown-item waves-effect waves-light <?php if($title == 'Users'){ echo 'active';}?>">Users<i class="fas fa-user ml-3"></i></a>
              <a href="<?php echo base_url();?>admin/modules" class="dropdown-item waves-effect waves-light <?php if($title == 'Course'){ echo 'active';}?>">Modules<i class="fas fa-graduation-cap ml-3"></i></a>
              <a href="<?php echo base_url();?>admin/posts" class="dropdown-item waves-effect waves-light <?php if($title == 'Posts'){ echo 'active';}?>">Posts<i class="fas fa-newspaper ml-3"></i></a>
              <a href="<?php echo base_url();?>admin/resources" class="dropdown-item waves-effect waves-light <?php if($title == 'Resources'){ echo 'active';}?>">Resources<i class="fas fa-blog ml-3"></i></a>
              <a href="<?php echo base_url();?>admin/reviews" class="dropdown-item waves-effect waves-light <?php if($title == 'Reviews'){ echo 'active';}?>">Reviews<i class="fas fa-user-edit ml-3"></i></a>
              <a href="<?php echo base_url();?>admin/frequently-asked-questions" class="dropdown-item waves-effect waves-light <?php if($title == 'FAQ'){ echo 'active';}?>">FAQs<i class="fas fa-question ml-3"></i></a>
              <a href="<?php echo base_url();?>admin/settings" class="dropdown-item waves-effect waves-light <?php if($title == 'Settings'){ echo 'active';}?>">Settings<i class="fas fa-cog ml-3"></i></a>
            </div>
          </li>
        </ul>
        <!-- Right -->
        <ul class="navbar-nav nav-flex-icons">
          <li class="nav-item">
            <a class="nav-link waves-effect" href="<?php echo base_url();?>admin/logout">
              <i class="fas fa-sign-out-alt mr-2"></i>Sign Out
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- Sidebar -->
  <div class="sidebar-fixed position-fixed">
    <a class="logo-wrapper waves-effect">
      <img src="<?php echo base_url();?>assets/img/<?php echo $settings['logo_img'];?>" class="img-fluid" alt="">
    </a>
    <div class="list-group list-group-flush">
      <a href="<?php echo base_url();?>admin" class="list-group-item list-group-item-action <?php if($title == 'Home'){ echo 'active';}?> waves-effect"><i class="fas fa-chart-pie mr-2"></i>Dashboard</a>
      <a href="<?php echo base_url();?>admin/support" class="list-group-item list-group-item-action waves-effect <?php if($title == 'Support'){ echo 'active';}?>"><i class="fas fa-comment mr-2"></i>Messages <span id="new_messages"></span></a>
      <a href="<?php echo base_url();?>admin/products" class="list-group-item list-group-item-action waves-effect <?php if($title == 'Products'){ echo 'active';}?>"><i class="fas fa-search-dollar mr-2"></i>Products</span></a>
      <a href="<?php echo base_url();?>admin/users" class="list-group-item list-group-item-action waves-effect <?php if($title == 'Users'){ echo 'active';}?>"><i class="fas fa-user mr-2"></i>Users</a>
      <a href="<?php echo base_url();?>admin/modules" class="list-group-item list-group-item-action waves-effect <?php if($title == 'Course'){ echo 'active';}?>"><i class="fas fa-graduation-cap mr-2"></i>Modules</a>
      <a href="<?php echo base_url();?>admin/posts" class="list-group-item list-group-item-action waves-effect <?php if($title == 'Posts'){ echo 'active';}?>"><i class="fas fa-newspaper mr-2"></i>Posts</a>
      <a href="<?php echo base_url();?>admin/resources" class="list-group-item list-group-item-action waves-effect <?php if($title == 'Resources'){ echo 'active';}?>"><i class="fas fa-blog mr-2"></i>Resources</a>
      <a href="<?php echo base_url();?>admin/reviews" class="list-group-item list-group-item-action waves-effect <?php if($title == 'Reviews'){ echo 'active';}?>"><i class="fas fa-user-edit mr-2"></i>Reviews</a>
      <a href="<?php echo base_url();?>admin/frequently-asked-questions" class="list-group-item list-group-item-action waves-effect <?php if($title == 'FAQ'){ echo 'active';}?>"><i class="fas fa-question mr-2"></i>FAQs</a>
      <a href="<?php echo base_url();?>admin/settings" class="list-group-item list-group-item-action waves-effect <?php if($title == 'Settings'){ echo 'active';}?>"><i class="fas fa-cog mr-2"></i>Settings</a>
    </div>
  </div>
  <!-- Sidebar -->
</header><!--Main Navigation-->
<?php } elseif($admin_status == '3') {?>
<header>
  <nav class="navbar fixed-top navbar-expand-lg navbar-light white scrolling-navbar">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link waves-effect active">
              <?php echo ucfirst($first_name);?> <?php echo ucfirst($last_name);?>
            </a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle waves-effect waves-light" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <strong><?php echo ucfirst($title);?>
            </strong>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-default" aria-labelledby="navbarDropdownMenuLink">
              <a href="<?php echo base_url();?>admin/resources" class="dropdown-item waves-effect waves-light <?php if($title == 'Resources'){ echo 'active';}?>">Resources<i class="fas fa-blog ml-3"></i></a>
              <a href="<?php echo base_url();?>admin/reviews" class="dropdown-item waves-effect waves-light <?php if($title == 'Reviews'){ echo 'active';}?>">Reviews<i class="fas fa-user-edit ml-3"></i></a>
              <a href="<?php echo base_url();?>admin/frequently-asked-questions" class="dropdown-item waves-effect waves-light <?php if($title == 'FAQ'){ echo 'active';}?>">FAQs<i class="fas fa-question ml-3"></i></a>
              <a href="<?php echo base_url();?>admin/settings" class="dropdown-item waves-effect waves-light <?php if($title == 'Settings'){ echo 'active';}?>">Settings<i class="fas fa-cog ml-3"></i></a>
            </div>
          </li>
        </ul>
        <!-- Right -->
        <ul class="navbar-nav nav-flex-icons">
          <li class="nav-item">
            <a class="nav-link waves-effect" href="<?php echo base_url();?>admin/logout">
              <i class="fas fa-sign-out-alt mr-2"></i>Sign Out
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- Sidebar -->
  <div class="sidebar-fixed position-fixed">
    <a class="logo-wrapper waves-effect">
      <img src="<?php echo base_url();?>assets/img/<?php echo $settings['logo_img'];?>" class="img-fluid" alt="">
    </a>
    <div class="list-group list-group-flush">
      <a href="<?php echo base_url();?>admin/resources" class="list-group-item list-group-item-action waves-effect <?php if($title == 'Resources'){ echo 'active';}?>"><i class="fas fa-blog mr-2"></i>Resources</a>
      <a href="<?php echo base_url();?>admin/reviews" class="list-group-item list-group-item-action waves-effect <?php if($title == 'Reviews'){ echo 'active';}?>"><i class="fas fa-user-edit mr-2"></i>Reviews</a>
      <a href="<?php echo base_url();?>admin/frequently-asked-questions" class="list-group-item list-group-item-action waves-effect <?php if($title == 'FAQ'){ echo 'active';}?>"><i class="fas fa-question mr-2"></i>FAQs</a>
      <a href="<?php echo base_url();?>admin/settings" class="list-group-item list-group-item-action waves-effect <?php if($title == 'Settings'){ echo 'active';}?>"><i class="fas fa-cog mr-2"></i>Settings</a>
    </div>
  </div>
  <!-- Sidebar -->
</header>
<?php } else { ?>
<header>
  <nav class="navbar fixed-top navbar-expand-lg navbar-light white scrolling-navbar">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link waves-effect active">
              <?php echo ucfirst($first_name);?> <?php echo ucfirst($last_name);?>
            </a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle waves-effect waves-light" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <strong><?php echo ucfirst($title);?>
              </strong>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-default" aria-labelledby="navbarDropdownMenuLink">
              <a href="<?php echo base_url();?>admin" class="dropdown-item waves-effect waves-light <?php if($title == 'Home'){ echo 'active';}?> waves-effect">Dashboard<i class="fas fa-chart-pie ml-3"></i></a>
              <a href="<?php echo base_url();?>admin/support" class="dropdown-item waves-effect waves-light <?php if($title == 'Support'){ echo 'active';}?>">Messages<i class="fas fa-comment ml-3"></i></a>
              <a href="<?php echo base_url();?>admin/products" class="dropdown-item waves-effect waves-light <?php if($title == 'Products'){ echo 'active';}?>">Products<i class="fas fa-search-dollar ml-3"></i></a>
              <a href="<?php echo base_url();?>admin/users" class="dropdown-item waves-effect waves-light <?php if($title == 'Users'){ echo 'active';}?>">Users<i class="fas fa-user ml-3"></i></a>
              <a href="<?php echo base_url();?>admin/ratings" class="dropdown-item waves-effect waves-light <?php if($title == 'Ratings'){ echo 'active';}?>">Ratings<i class="fas fa-star ml-3 amber-text"></i></a>
              <a href="<?php echo base_url();?>admin/programs" class="dropdown-item waves-effect waves-light <?php if($title == 'Programs'){ echo 'active';}?>">Programs<i class="fas fa-hourglass ml-3"></i></a>
              <a href="<?php echo base_url();?>admin/modules" class="dropdown-item waves-effect waves-light <?php if($title == 'Course'){ echo 'active';}?>">Modules<i class="fas fa-graduation-cap ml-3"></i></a>
              <a href="<?php echo base_url();?>admin/posts" class="dropdown-item waves-effect waves-light <?php if($title == 'Posts'){ echo 'active';}?>">Posts<i class="fas fa-newspaper ml-3"></i></a>
              <a href="<?php echo base_url();?>admin/resources" class="dropdown-item waves-effect waves-light <?php if($title == 'Resources'){ echo 'active';}?>">Resources<i class="fas fa-blog ml-3"></i></a>
              <a href="<?php echo base_url();?>admin/reviews" class="dropdown-item waves-effect waves-light <?php if($title == 'Reviews'){ echo 'active';}?>">Reviews<i class="fas fa-user-edit ml-3"></i></a>
              <a href="<?php echo base_url();?>admin/frequently-asked-questions" class="dropdown-item waves-effect waves-light <?php if($title == 'FAQ'){ echo 'active';}?>">FAQs<i class="fas fa-question ml-3"></i></a>
              <a href="<?php echo base_url();?>admin/admins" class="dropdown-item waves-effect waves-light <?php if($title == 'Admins'){ echo 'active';}?>">Admins<i class="fas fa-user-cog ml-3"></i></a>
              <a href="<?php echo base_url();?>admin/settings" class="dropdown-item waves-effect waves-light <?php if($title == 'Settings'){ echo 'active';}?>">Settings<i class="fas fa-cog ml-3"></i></a>
            </div>
          </li>
        </ul>
        <ul class="navbar-nav nav-flex-icons">
          <li class="nav-item">
            <a class="nav-link waves-effect" href="<?php echo base_url();?>admin/logout">
              <i class="fas fa-sign-out-alt mr-2"></i>Sign Out
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- Sidebar -->
  <div class="sidebar-fixed position-fixed">
    <a class="logo-wrapper waves-effect">
      <img src="<?php echo base_url();?>assets/img/<?php echo $settings['logo_img'];?>" class="img-fluid" alt="">
    </a>
    <div class="list-group list-group-flush">
      <a href="<?php echo base_url();?>admin" class="list-group-item list-group-item-action <?php if($title == 'Home'){ echo 'active';}?> waves-effect"><i class="fas fa-chart-pie mr-2"></i>Dashboard</a>
      <a href="<?php echo base_url();?>admin/support" class="list-group-item list-group-item-action waves-effect <?php if($title == 'Support'){ echo 'active';}?>"><i class="fas fa-comment mr-2"></i>Messages <span id="new_messages"></span></a>
      <a href="<?php echo base_url();?>admin/products" class="list-group-item list-group-item-action waves-effect <?php if($title == 'Products'){ echo 'active';}?>"><i class="fas fa-search-dollar mr-2"></i>Products</span></a>
      <a href="<?php echo base_url();?>admin/users" class="list-group-item list-group-item-action waves-effect <?php if($title == 'Users'){ echo 'active';}?>"><i class="fas fa-user mr-3"></i>Users</a>
      <a href="<?php echo base_url();?>admin/ratings" class="list-group-item list-group-item-action waves-effect <?php if($title == 'Ratings'){ echo 'active';}?>"><i class="fas fa-star mr-2 amber-text"></i>Ratings</a>
      <a href="<?php echo base_url();?>admin/programs" class="list-group-item list-group-item-action waves-effect <?php if($title == 'Programs'){ echo 'active';}?>"><i class="fas fa-hourglass mr-3"></i>Programs</a>
      <a href="<?php echo base_url();?>admin/modules" class="list-group-item list-group-item-action waves-effect <?php if($title == 'Course'){ echo 'active';}?>"><i class="fas fa-graduation-cap mr-2"></i>Modules</a>
      <a href="<?php echo base_url();?>admin/posts" class="list-group-item list-group-item-action waves-effect <?php if($title == 'Posts'){ echo 'active';}?>"><i class="fas fa-newspaper mr-2"></i>Posts <span id="review_post"></span></a>
      <a href="<?php echo base_url();?>admin/resources" class="list-group-item list-group-item-action waves-effect <?php if($title == 'Resources'){ echo 'active';}?>"><i class="fas fa-blog mr-2"></i> Resources</a>
      <a href="<?php echo base_url();?>admin/reviews" class="list-group-item list-group-item-action waves-effect <?php if($title == 'Reviews'){ echo 'active';}?>"><i class="fas fa-user-edit mr-2"></i>Reviews</a>
      <a href="<?php echo base_url();?>admin/frequently-asked-questions" class="list-group-item list-group-item-action waves-effect <?php if($title == 'FAQ'){ echo 'active';}?>"><i class="fas fa-question mr-3"></i>FAQs</a> 
      <a href="<?php echo base_url();?>admin/admins" class="list-group-item list-group-item-action waves-effect <?php if($title == 'Admins'){ echo 'active';}?>"><i class="fas fa-user-cog mr-2"></i>Admins</a>
      <a href="<?php echo base_url();?>admin/settings" class="list-group-item list-group-item-action waves-effect <?php if($title == 'Settings'){ echo 'active';}?>"><i class="fas fa-cog mr-2"></i>Settings</a>
    </div>
  </div>
</header>
<?php } ?>