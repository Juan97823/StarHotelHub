<?php include_once 'views/template/header-cliente.php'; ?>
<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
  <div class="col">
    <div class="card radius-10 border-start border-0 border-3 border-info">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div>
            <p class="mb-0 text-secondary">Total Reservations</p>
            <h4 class="my-1 text-info">1,245</h4>
            <p class="mb-0 font-13">+5.6% from last week</p>
          </div>
          <div class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto"><i class='bx bxs-bed'></i>
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
            <h4 class="my-1 text-danger">$45,789</h4>
            <p class="mb-0 font-13">+3.2% from last week</p>
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
            <p class="mb-0 text-secondary">Occupancy Rate</p>
            <h4 class="my-1 text-success">78.4%</h4>
            <p class="mb-0 font-13">+2.1% from last week</p>
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
            <h4 class="my-1 text-warning">5,134</h4>
            <p class="mb-0 font-13">+7.8% from last week</p>
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
            <h6 class="mb-0">Revenue Overview</h6>
          </div>
          <div class="dropdown ms-auto">
            <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="javascript:;">Action</a></li>
              <li><a class="dropdown-item" href="javascript:;">Another action</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="javascript:;">Something else here</a></li>
            </ul>
          </div>
        </div>
        <div class="d-flex align-items-center ms-auto font-13 gap-2 my-3">
          <span class="border px-1 rounded cursor-pointer"><i class="bx bxs-circle me-1" style="color: #14abef"></i>Revenue</span>
          <span class="border px-1 rounded cursor-pointer"><i class="bx bxs-circle me-1" style="color: #ffc107"></i>Occupancy</span>
        </div>
        <div class="chart-container-1">
          <canvas id="chart1"></canvas>
        </div>
      </div>
      <div class="row row-cols-1 row-cols-md-3 row-cols-xl-3 g-0 row-group text-center border-top">
        <div class="col">
          <div class="p-3">
            <h5 class="mb-0">12.45M</h5>
            <small class="mb-0">Total Visitors <span> <i class="bx bx-up-arrow-alt align-middle"></i> 3.5%</span></small>
          </div>
        </div>
        <div class="col">
          <div class="p-3">
            <h5 class="mb-0">15:20</h5>
            <small class="mb-0">Average Stay <span> <i class="bx bx-up-arrow-alt align-middle"></i> 4.8%</span></small>
          </div>
        </div>
        <div class="col">
          <div class="p-3">
            <h5 class="mb-0">1,500</h5>
            <small class="mb-0">Rooms Booked <span> <i class="bx bx-up-arrow-alt align-middle"></i> 2.1%</span></small>
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
            <h6 class="mb-0">Trending Rooms</h6>
          </div>
          <div class="dropdown ms-auto">
            <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="javascript:;">Action</a></li>
              <li><a class="dropdown-item" href="javascript:;">Another action</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="javascript:;">Something else here</a></li>
            </ul>
          </div>
        </div>
        <div class="chart-container-2 mt-4">
          <canvas id="chart2"></canvas>
        </div>
      </div>
      <ul class="list-group list-group-flush">
        <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Luxury Suite <span class="badge bg-success rounded-pill">45</span></li>
        <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Deluxe Room <span class="badge bg-danger rounded-pill">30</span></li>
        <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Standard Room <span class="badge bg-primary rounded-pill">90</span></li>
        <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Economy Room <span class="badge bg-warning text-dark rounded-pill">40</span></li>
      </ul>
    </div>
  </div>
</div>
<!--end row-->

<?php include_once 'views/template/footer-cliente.php'; ?>