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
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5>Users Dashboard</h5>
                        <a href="{{ route('admin.tenants.create') }}" class="btn btn-danger"> Add Tenant </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Company</th>
                                    <th>Name</th>
                                    <th>email</th>
                                    <th>Domain</th>
                                    <th>Subscription</th>
                                    <th>Subscription Type</th>
                                    <th>Date Added</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @if (sizeof($tenants) > 0)
                                        @foreach ($tenants as $tenant)
                                            <tr>
                                                <td>{{ $loop->index+1 }}</td>
                                                <td>{{ $tenant->company }}</td>
                                                <td>{{ $tenant->name }}</td>
                                                <td>{{ $tenant->email }}</td>
                                                <td>{{ $tenant->domains[0]->domain }}</td>
                                                <td>{{ $tenant->subscription->name }}</td>
                                                <td class="text-center">{{ $tenant->subscription->name=='free'? 'Free' : 'Premium' }}</td>
                                                <td>{{ date('m-d-Y', strtotime($tenant->created_at)) }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center justify-content-center gap-1">
                                                    <a class="btn btn-sm btn-primary" href="{{ route('admin.tenants.show', $tenant->id) }}">View</a>
                                                    <a class="btn btn-sm btn-info" href="{{ route('admin.tenants.edit', $tenant->id) }}">Edit</a>
                                                    <a class="btn btn-sm btn-danger" href="{{ route('admin.tenants.destroy', $tenant->id) }}" onclick="event.preventDefault(); document.getElementById('delete-tenant-{{$tenant->id}}').submit();">Delete</a>
                                                    <form action="{{ route('admin.tenants.destroy', $tenant->id) }}" id="delete-tenant-{{ $tenant->id }}" method="post">
                                                        
                                                        @csrf
                                                        @method('delete')
                                                        
                                                    </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="9" class="text-center">No data available!</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
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