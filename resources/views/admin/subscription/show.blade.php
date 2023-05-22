@extends('admin.index')

@section('content')
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12 order-1">
                <div class="breadscrumbs d-flex align-items-center justify-content-between">
                    <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-danger">Back</a>
                </div>                    
                <!-- Tenant Information -->
                <div class="card my-1">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5>Tenant Information</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name:</th>
                                    <td>{{ $subscription->name }}</td>
                                </tr>
                                <tr>
                                    <th>Price:</th>
                                    <td>{{ $subscription->price }}</td>
                                </tr>
                                <tr>
                                    <th>Duration in Days:</th>
                                    <td>{{ $subscription->duration_in_days }}</td>
                                </tr>
                                <tr>
                                    <th>Max Products:</th>
                                    <td>{{ $subscription->max_products }}</td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- / Content -->
    <div class="content-backdrop fade"></div>
</div>
@endsection