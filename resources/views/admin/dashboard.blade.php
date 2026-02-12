@extends('admin.layout.app')

@section('title', 'Dashboard')

@section('content')

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="row">
        <!-- Customer Ratings -->
        <div class="col-md-12 col-xxl-12 mb-6">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Customer Ratings</h5>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="customerRatings" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="icon-base bx bx-dots-vertical-rounded icon-lg text-body-secondary"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="customerRatings">
                            <a class="dropdown-item" href="javascript:void(0);">Featured Ratings</a>
                            <a class="dropdown-item" href="javascript:void(0);">Based on Task</a>
                            <a class="dropdown-item" href="javascript:void(0);">See All</a>
                        </div>
                    </div>
                </div>
                <div class="card-body pb-0">
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <h2 class="mb-0">4.0</h2>
                        <div class="ratings">
                            <i class="icon-base bx bxs-star icon-lg text-warning"></i>
                            <i class="icon-base bx bxs-star icon-lg text-warning"></i>
                            <i class="icon-base bx bxs-star icon-lg text-warning"></i>
                            <i class="icon-base bx bxs-star icon-lg text-warning"></i>
                            <i class="icon-base bx bxs-star icon-lg text-lighter"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-label-primary me-2">+5.0</span>
                        <span>Points from last month</span>
                    </div>
                </div>
                <div id="customerRatingsChart"></div>
            </div>
        </div>
        <!--/ Customer Ratings -->
    </div>
</div>

@endsection
