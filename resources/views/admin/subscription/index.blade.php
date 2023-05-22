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
                        <h5>Subscription</h5>
                        <a href="{{ route('admin.subscriptions.create') }}" class="btn btn-danger"> Add Subscription </a>
                    </div>
                    <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Type</th>
                            <th>Duration in days</th>
                            <th>Maximum Products</th>
                            <th>Date Added</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @if (sizeof($subscriptions) > 0)
                                @foreach ($subscriptions as $subscription)
                                    <tr>
                                        <td>{{ $loop->index+1 }}</td>
                                        <td class="text-capitalize">{{ $subscription->name }}</td>
                                        <td>{{ $subscription->price }}</td>
                                        <td class="text-capitalize">{{ $subscription->type }}</td>
                                        <td class="text-center">{{ $subscription->duration_in_days }}</td>
                                        <td class="text-center">{{ $subscription->max_products }}</td>
                                        <td>{{ date('m-d-Y', strtotime($subscription->created_at)) }}</td>
                                        <td>
                                            <div class="d-flex align-items-center justify-content-center gap-1">
                                            <a class="btn btn-sm btn-primary" href="{{ route('admin.subscriptions.show', $subscription->id) }}">View</a>
                                            <a class="btn btn-sm btn-info" href="{{ route('admin.subscriptions.edit', $subscription->id) }}">Edit</a>
                                            <a class="btn btn-sm btn-danger" href="{{ route('admin.subscriptions.destroy', $subscription->id) }}" onclick="event.preventDefault(); document.getElementById('delete-subscriptions-{{$subscription->id}}').submit();">Delete</a>
                                            <form action="{{ route('admin.subscriptions.destroy', $subscription->id) }}" id="delete-subscriptions-{{ $subscription->id }}" method="post">
                                                
                                                @csrf
                                                @method('delete')
                                                
                                            </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="text-center">No data available!</td>
                                </tr>
                            @endif
                        </tbody>
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