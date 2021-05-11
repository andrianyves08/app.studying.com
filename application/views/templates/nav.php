<header>
  <nav class="navbar fixed-top navbar-expand-lg navbar-dark scrolling-navbar wow fadeIn">
    <picture>
      <a class="navbar-brand waves-effect" href="<?php echo base_url(); ?>">
        <source media="(min-width: 456px)" srcset="<?php echo base_url();?>assets/img/logo-1.png">
        <source media="(min-width: 256px)" srcset="<?php echo base_url();?>assets/img/logo-1.png">
        <img src="<?php echo base_url();?>assets/img/logo-1.png" class="img-fluid" alt="" style="height: 40px;">
      </a>
    </picture>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <i class="fas fa-bars blue-text"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item" id="my_level">
        </li> 
        <?php if($title != 'Home'){ ?>
          <?php echo form_open('search'); ?>
          <div class="input-group ml-2 mt-1">
            <input class="form-control form-control-sm" type="text" placeholder="Search" aria-label="Search" name="search">
            <div class="input-group-prepend">
              <button class="btn btn-light btn-sm m-0 px-3 py-2 z-depth-0" type="submit"><i class="fas fa-search"></i></button>
            </div>
          </div>
          <?php echo form_close(); ?>
        <?php } ?>
      </ul>
      <ul class="navbar-nav nav-flex-icons">
        <li class="nav-item avatar dropdown mr-0">
          <a class="nav-link dropdown-toggle dropdown-toggle_2 blue-text" id="seen_notification" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-bell" id="notification_bell"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-lg-right dropdown-secondary notifications" id="notifications" aria-labelledby="seen_notification">
          </div>
        </li>
        <li class="nav-item dropdown">
           <a class="nav-link dropdown-toggle blue-text" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <strong>
              My Modules</strong>
          </a>
          <div class="dropdown-menu dropdown-menu-right dropdown-default" aria-labelledby="navbarDropdownMenuLink" id="my_purchases">
            <?php foreach ($my_purchases as $my_purchase) { ?>
              <a class="dropdown-item" href="<?php echo base_url();?>modules/<?php echo $my_purchase['slug'];?>"><?php echo $my_purchase['name'];?></a>
            <?php } ?>
          </div>
        </li>
        <li class="nav-item">
          <a href="<?php echo base_url(); ?>messages" class="nav-link waves-effect blue-text">
           <strong>
           Messages</strong>
            <?php if($unseen_chat > 0){ echo '<span class="badge badge-danger badge-pill">'.$unseen_chat.'</span>'; } ?>
          </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle waves-effect waves-light blue-text my_info" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          </a>
          <div class="dropdown-menu dropdown-menu-right dropdown-default" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item waves-effect waves-light" href="<?php echo base_url(); ?>my-profile">My Profile</a>
            <a class="dropdown-item waves-effect waves-light" href="<?php echo base_url(); ?>modules/updates">Browse Monthly Updates</a>
            <a class="dropdown-item waves-effect waves-light" href="<?php echo base_url(); ?>support">Report Bug / Support</a>
            <a href="<?php echo base_url(); ?>logout" class="dropdown-item waves-effect waves-light" id="user_logout"> Log Out
            <i class="fas fa-sign-out-alt"></i> 
            </a>
          </div>
        </li>
      </ul>
    </div>
  </nav>
</header>