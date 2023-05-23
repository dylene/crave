@extends('tenant.index')

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
      <div class="row">
          <div class="col-md-12 order-1">
              @if (session('success'))
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <strong>{{session('success')}}</strong>
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                @endif
            <!-- Tenant Users -->
            <div class="card my-1">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5>My Subscriptions</h5>
                    <a href="{{ route('tenant.subscription.upgrade.form', $tenant->id) }}" class="btn btn-danger">Upgrade Subscription</a>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Subscription</th>
                            <th>Subscription Price</th>
                            <th>Subscription Type</th>
                            <th>Duration in Days</th>
                            <th>Payment Gateway</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @if (!empty($tenant->subscription))
                                <tr>
                                    <td>{{ $tenant->subscription->name }}</td>
                                    <td>{{ $tenant->subscription->price }}</td>
                                    <td>{{ $tenant->subscription->type }}</td>
                                    <td>{{ $tenant->subscription->duration_in_days }}</td>
                                    <td class="text-capitalize">{{ $tenant->paymentGateway ? $tenant->paymentGateway->name :'free' }}</td>
                                    <td>{{ date('m-d-Y', strtotime($tenant->subscription->created_at)) }}</td>
                                    <td>
                                        {{-- <div class="d-flex align-items-center justify-content-center gap-1">
                                            <a class="btn btn-sm btn-primary" href="{{ route('tenant.subscriptions.show', ['tenant' => $tenant->id, 'tenant->subscription' => $tenant->subscription->id]) }}">View</a>
                                            <a class="btn btn-sm btn-info" href="{{ route('tenant.subscriptions.edit', ['tenant' => $tenant->id, 'tenant->subscription' => $tenant->subscription->id]) }}">Edit</a>
                                            <a class="btn btn-sm btn-danger" href="{{ route('tenant.subscriptions.destroy', ['tenant' => $tenant->id, 'tenant->subscription' => $tenant->subscription->id]) }}" onclick="event.preventDefault(); document.getElementById('delete-tenant-subscription-{{$tenant->subscription->id}}').submit();">Delete</a>
                                            <form action="{{ route('tenant.subscriptions.destroy', ['tenant' => $tenant->id, 'tenant->subscription' => $tenant->subscription->id]) }}" id="delete-tenant-subscription-{{ $tenant->subscription->id }}" method="post">

                                                @csrf
                                                @method('delete')

                                            </form>
                                        </div> --}}
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="5" class="text-center">No data available!</td>
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
