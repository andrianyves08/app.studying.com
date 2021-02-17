<?php if($admin_status == 2){?>
<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <div class="card mb-4 wow fadeIn">
    <div class="card-body d-sm-flex justify-content-between">
      <h4 class="mb-2 mb-sm-0 pt-1">
        <span>Dashboard</span>
      </h4>
    </div>
  </div>
  <div class="row wow fadeIn">
    <div class="col-lg-3 col-md-3 mb-4">
      <div class="card">
        <div class="card-header">
          <strong><?php echo date('F')."'s";?> Sales</strong>
        </div>
        <div class="card-body">
          <h4>$<?php echo number_format($datas['this_month_sales'], 2, '.', ','); ?></h4>       
        </div>
      </div>
    </div><!--Column-->
    <div class="col-lg-3 col-md-3 mb-4">
      <div class="card">
        <div class="card-header">
          <strong>Total Students</strong>
        </div>
        <div class="card-body">
          <h4><?php echo $datas['total_students']; ?></h4>       
        </div>
      </div>
    </div><!--Column-->
    <div class="col-lg-3 col-md-3 mb-4">
      <div class="card">
        <div class="card-header">
          <strong>Total Current Online</strong>
        </div>
        <div class="card-body">
          <h4><?php echo $datas['current_online']; ?></h4>
        </div>
      </div>
    </div><!--Column-->
    <div class="col-lg-3 col-md-3 mb-4">
      <div class="card">
        <div class="card-header">
          <strong>Total Active Modules</strong>
        </div>
        <div class="card-body">
          <h4><?php echo $datas['total_modules']; ?></h4>
        </div>
      </div>
    </div><!--Column-->
  </div><!--Row-->
  <div class="row mb-4">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
            <strong>Monthly Sales</strong>
        </div>
        <div class="card-body">
          <div class="d-flex">
            <div class="d-flex flex-column">
              <h4>$<?php echo number_format($datas['this_year_sales'], 2, '.', ','); ?></h4> 
              <span class="mb-4">This year's total sales</span>
            </div>
          </div>
          <div class="position-relative mb-4"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
            <canvas id="sales-chart-3" height="200" width="288" class="chartjs-render-monitor" style="display: block; width: 288px; height: 200px;"></canvas>
          </div>
        </div><!--Card Body-->
      </div><!--Card -->
    </div><!--Column-->
  </div><!--Row-->
  <div class="row mb-4">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
            <strong>Total Sales</strong>
        </div>
        <div class="card-body">
          <div class="d-flex">
            <div class="d-flex flex-column">
              <h3 class="text-bold">$ <?php echo number_format($datas['total_sales'], 2, '.', ','); ?></h3>
              <span class="mb-4">Total sales</span>
            </div>
          </div>
          <div class="position-relative mb-4"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
            <canvas id="sales-chart-2" height="200" width="288" class="chartjs-render-monitor" style="display: block; width: 288px; height: 200px;"></canvas>
          </div>
        </div><!--Card Body-->
      </div><!--Card-->
    </div><!--Column-->
  </div><!--Row-->
  <div class="row mb-4">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <strong>Most Enrolled Program</strong>
        </div>
        <div class="card-body">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Program</th>
                <th scope="col">Total Enrolled</th>
                <th scope="col">Total Sales</th>
              </tr>
            </thead>
            <tbody>
              <?php $i = 1; foreach ($programs as $program ) { ?>
              <tr>
                <th scope="row"><?php echo $i; ?></th>
                <td><?php echo $program['program_name']; ?></td>
                <td><?php echo $program['total_enrolled']; ?></td>
                <td><?php echo number_format($program['program_sales'], 2, '.', ','); ?></td>
              </tr>
            <?php $i++; } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
</main>
<?php } else { ?>
<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <div class="card mb-4 wow fadeIn">
    <div class="card-body d-sm-flex justify-content-between">
      <h4 class="mb-2 mb-sm-0 pt-1">
        <a>Home Page</a>
        <span>/</span>
        <span>Dashboard</span>
      </h4>
    </div>
  </div>
  <!-- Heading -->
  <div class="row">
    <div class="col-lg-3 col-md-3 mb-4">
      <div class="card">
        <div class="card-header">
          <strong>Total Students</strong>
        </div>
        <div class="card-body">
          <h4><?php echo $datas['total_students']; ?></h4>       
        </div>
      </div>
    </div><!--Column-->
    <div class="col-lg-3 col-md-3 mb-4">
      <div class="card">
        <div class="card-header">
          <strong>Total Current Online</strong>
        </div>
        <div class="card-body">
          <h4><?php echo $datas['current_online']; ?></h4>
        </div>
      </div>
    </div><!--Column-->
    <div class="col-lg-3 col-md-3 mb-4">
      <div class="card">
        <div class="card-header">
          <strong>Total Active Modules</strong>
        </div>
        <div class="card-body">
          <h4><?php echo $datas['total_modules']; ?></h4>
        </div>
      </div>
    </div><!--Column-->
  </div><!--Row-->
</div>
</main>
<?php } ?>