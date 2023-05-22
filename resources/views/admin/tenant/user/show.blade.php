@extends('admin.index')

@section('content')
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12 order-1">
                @if (session('success'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>{{session('success')}}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="breadscrumbs d-flex align-items-center justify-content-between">
                    <h4 class="text-capitalize mb-0">{{ $tenant->name }} / {{ $user->name }} / Information</h4>
                    <a href="{{ route('admin.tenants.show', $tenant->id) }}" class="btn btn-danger">Back</a>
                </div>
                <!-- Tenant Information -->
                <div class="card my-1">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5>User Tenant Information</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>{{ $user->email }}</td>
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