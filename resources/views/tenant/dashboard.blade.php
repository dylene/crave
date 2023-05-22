@extends('tenant.index')

@section('content')
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
      <div class="row">
        <div class="col-md-12 order-1">
          <div class="row">
            <div class="col-sm-6 mb-4">
              <div class="card">
                <div class="card-body">
                  <div class="card-title d-flex align-items-start justify-content-between">
                      <i class='bx bxs-bar-chart-alt-2 text-danger text-danger p-2 rounded'></i>
                  </div>
                  <span class="fw-semibold d-block mb-1">Total Users</span>
                  <h3 class="card-title mb-2">{{ sizeof($users) }}</h3>
                </div>
              </div>
            </div>
            <div class="col-sm-6 mb-4">
              <div class="card">
                <div class="card-body">
                  <div class="card-title d-flex align-items-start justify-content-between">
                      <i class='bx bxs-bar-chart-alt-2 text-danger text-danger p-2 rounded'></i>
                  </div>
                  <span class="fw-semibold d-block mb-1">Total Products</span>
                  <h3 class="card-title mb-2">{{ sizeof($products) }}</h3>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <!-- / Content -->

    <div class="content-backdrop fade"></div>
  </div>
@endsection