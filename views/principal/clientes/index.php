<?php include_once 'views/template/header-cliente.php'; ?>
<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
  <div class="col">
    <div class="card radius-10 border-start border-0 border-3 border-info">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div>
            <p class="mb-0 text-secondary">Total Orders</p>
            <h4 class="my-1 text-info">4805</h4>
            <p class="mb-0 font-13">+2.5% from last week</p>
          </div>
          <div class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto"><i class='bx bxs-cart'></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col">
    <div class="card radius-10 border-start border-0 border-3 border-danger">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div>
            <p class="mb-0 text-secondary">Total Revenue</p>
            <h4 class="my-1 text-danger">$84,245</h4>
            <p class="mb-0 font-13">+5.4% from last week</p>
          </div>
          <div class="widgets-icons-2 rounded-circle bg-gradient-bloody text-white ms-auto"><i class='bx bxs-wallet'></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col">
    <div class="card radius-10 border-start border-0 border-3 border-success">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div>
            <p class="mb-0 text-secondary">Bounce Rate</p>
            <h4 class="my-1 text-success">34.6%</h4>
            <p class="mb-0 font-13">-4.5% from last week</p>
          </div>
          <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto"><i class='bx bxs-bar-chart-alt-2'></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col">
    <div class="card radius-10 border-start border-0 border-3 border-warning">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div>
            <p class="mb-0 text-secondary">Total Customers</p>
            <h4 class="my-1 text-warning">8.4K</h4>
            <p class="mb-0 font-13">+8.4% from last week</p>
          </div>
          <div class="widgets-icons-2 rounded-circle bg-gradient-blooker text-white ms-auto"><i class='bx bxs-group'></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--end row-->

<div class="row">
  <div class="col-12 col-lg-8">
    <div class="card radius-10">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div>
            <h6 class="mb-0">Sales Overview</h6>
          </div>
          <div class="dropdown ms-auto">
            <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="javascript:;">Action</a>
              </li>
              <li><a class="dropdown-item" href="javascript:;">Another action</a>
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="javascript:;">Something else here</a>
              </li>
            </ul>
          </div>
        </div>
        <div class="d-flex align-items-center ms-auto font-13 gap-2 my-3">
          <span class="border px-1 rounded cursor-pointer"><i class="bx bxs-circle me-1" style="color: #14abef"></i>Sales</span>
          <span class="border px-1 rounded cursor-pointer"><i class="bx bxs-circle me-1" style="color: #ffc107"></i>Visits</span>
        </div>
        <div class="chart-container-1">
          <canvas id="chart1"></canvas>
        </div>
      </div>
      <div class="row row-cols-1 row-cols-md-3 row-cols-xl-3 g-0 row-group text-center border-top">
        <div class="col">
          <div class="p-3">
            <h5 class="mb-0">24.15M</h5>
            <small class="mb-0">Overall Visitor <span> <i class="bx bx-up-arrow-alt align-middle"></i> 2.43%</span></small>
          </div>
        </div>
        <div class="col">
          <div class="p-3">
            <h5 class="mb-0">12:38</h5>
            <small class="mb-0">Visitor Duration <span> <i class="bx bx-up-arrow-alt align-middle"></i> 12.65%</span></small>
          </div>
        </div>
        <div class="col">
          <div class="p-3">
            <h5 class="mb-0">639.82</h5>
            <small class="mb-0">Pages/Visit <span> <i class="bx bx-up-arrow-alt align-middle"></i> 5.62%</span></small>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-12 col-lg-4">
    <div class="card radius-10">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div>
            <h6 class="mb-0">Trending Products</h6>
          </div>
          <div class="dropdown ms-auto">
            <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="javascript:;">Action</a>
              </li>
              <li><a class="dropdown-item" href="javascript:;">Another action</a>
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="javascript:;">Something else here</a>
              </li>
            </ul>
          </div>
        </div>
        <div class="chart-container-2 mt-4">
          <canvas id="chart2"></canvas>
        </div>
      </div>
      <ul class="list-group list-group-flush">
        <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Jeans <span class="badge bg-success rounded-pill">25</span>
        </li>
        <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">T-Shirts <span class="badge bg-danger rounded-pill">10</span>
        </li>
        <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Shoes <span class="badge bg-primary rounded-pill">65</span>
        </li>
        <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Lingerie <span class="badge bg-warning text-dark rounded-pill">14</span>
        </li>
      </ul>
    </div>
  </div>
</div>


<div class="row row-cols-1 row-cols-lg-3">
  <div class="col d-flex">
    <div class="card radius-10 w-100">
      <div class="card-body">
        <p class="font-weight-bold mb-1 text-secondary">Weekly Revenue</p>
        <div class="d-flex align-items-center mb-4">
          <div>
            <h4 class="mb-0">$89,540</h4>
          </div>
          <div class="">
            <p class="mb-0 align-self-center font-weight-bold text-success ms-2">4.4% <i class="bx bxs-up-arrow-alt mr-2"></i>
            </p>
          </div>
        </div>
        <div class="chart-container-0">
          <canvas id="chart3"></canvas>
        </div>
      </div>
    </div>
  </div>
  <div class="col d-flex">
    <div class="card radius-10 w-100">
      <div class="card-header bg-transparent">
        <div class="d-flex align-items-center">
          <div>
            <h6 class="mb-0">Orders Summary</h6>
          </div>
          <div class="dropdown ms-auto">
            <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="javascript:;">Action</a>
              </li>
              <li><a class="dropdown-item" href="javascript:;">Another action</a>
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="javascript:;">Something else here</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="chart-container-1">
          <canvas id="chart4"></canvas>
        </div>
      </div>
      <ul class="list-group list-group-flush">
        <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Completed <span class="badge bg-gradient-quepal rounded-pill">25</span>
        </li>
        <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Pending <span class="badge bg-gradient-ibiza rounded-pill">10</span>
        </li>
        <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Process <span class="badge bg-gradient-deepblue rounded-pill">65</span>
        </li>
      </ul>
    </div>
  </div>
  <div class="col d-flex">
    <div class="card radius-10 w-100">
      <div class="card-header bg-transparent">
        <div class="d-flex align-items-center">
          <div>
            <h6 class="mb-0">Top Selling Categories</h6>
          </div>
          <div class="dropdown ms-auto">
            <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="javascript:;">Action</a>
              </li>
              <li><a class="dropdown-item" href="javascript:;">Another action</a>
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="javascript:;">Something else here</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="chart-container-0">
          <canvas id="chart5"></canvas>
        </div>
      </div>
      <div class="row row-group border-top g-0">
        <div class="col">
          <div class="p-3 text-center">
            <h4 class="mb-0 text-danger">$45,216</h4>
            <p class="mb-0">Clothing</p>
          </div>
        </div>
        <div class="col">
          <div class="p-3 text-center">
            <h4 class="mb-0 text-success">$68,154</h4>
            <p class="mb-0">Electronic</p>
          </div>
        </div>
      </div>
      <!--end row-->
    </div>
  </div>
</div>
<!--end row-->

<?php include_once 'views/template/footer-cliente.php'; ?>