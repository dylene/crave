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
                    
                <!-- Tenant Information -->
                <div class="card my-1">
                    <div class="card-header d-flex n-items-center justify-content-between">
                        <h5>Tenant Information</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Company Name:</th>
                                    <td>{{ $tenant->company }}</td>
                                </tr>
                                {{-- <tr>
                                    <th>Name:</th>
                                    <td>{{ $tenant->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>{{ $tenant->email }}</td>
                                </tr> --}}
                                <tr>
                                    <th>Domain:</th>
                                    <td>{{ $tenant->domains[0]->domain }}</td>
                                </tr>
                                <tr>
                                    <th>Subscription:</th>
                                    <td>{{ $tenant->subscription->name }}</td>
                                </tr>
                                <tr>
                                    <th>Subscription Type:</th>
                                    <td class="text-capitalize">{{ $tenant->subscription->type }}</td>
                                </tr>
                                <tr>
                                    <th>Subscription Duration:</th>
                                    <td>{{ $tenant->subscription->duration_in_days }} days</td>
                                </tr>
                                <tr>
                                    <th>
                                        Maximum Products:
                                        <div class="form-text">The maximum products to be sold based on the subscription.</div>
                                    </th>
                                    <td>{{ $tenant->subscription->max_products }}</td>
                                </tr>
                                <tr>
                                    <th>Total Payable:</th>
                                    <td>{{ $tenant->subscription->price }}</td>
                                </tr>
                                <tr>
                                    <th>Payment Status:</th>
                                    <td>{{ $tenant->payment_status==0? 'Not Paid' : 'Paid' }}</td>
                                </tr>
                                <tr>
                                    <th>Payment Gateway:</th>
                                    <td class="text-capitalize">{{ $tenant->paymentGateway? $tenant->paymentGateway->name : 'Paid' }}</td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                <!-- Tenant Users -->
                <div class="card my-1">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5>Tenant Users</h5>
                        <a href="{{ route('admin.users.create', $tenant->id) }}" class="btn btn-danger">New User</a>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Contact</th>
                                <th>Date Added</th>
                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @if (sizeof($users) > 0)
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $loop->index+1 }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->role }}</td>
                                            <td>{{ $user->mobile? $user->mobile : 'none' }}</td>
                                            <td>{{ date('m-d-Y', strtotime($user->created_at)) }}</td>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-center gap-1">
                                                <a class="btn btn-sm btn-primary" href="{{ route('admin.users.show', ['tenant' => $tenant->id, 'user' => $user->id]) }}">View</a>
                                                <a class="btn btn-sm btn-info" href="{{ route('admin.users.edit', ['tenant' => $tenant->id, 'user' => $user->id]) }}">Edit</a>
                                                <a class="btn btn-sm btn-danger" href="{{ route('admin.users.destroy', ['tenant' => $tenant->id, 'user' => $user->id]) }}" onclick="event.preventDefault(); document.getElementById('delete-user-{{$user->id}}').submit();">Delete</a>
                                                <form action="{{ route('admin.users.destroy', ['tenant' => $tenant->id, 'user' => $user->id]) }}" id="delete-user-{{ $user->id }}" method="post">
                                                    
                                                    @csrf
                                                    @method('delete')
                                                    
                                                </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center">No data available!</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                </div>

                @if (sizeof($products)==$tenant->subscription->max_products)
                    <div class="alert alert-danger alert-dismissible fade show mb-2" role="alert">
                        <strong>Opps! You can only upload {{ $tenant->subscription->max_products}} products based on your subscription. Consider upgrading your subscription.</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                <!-- Tenant Products -->
                <div class="card my-1">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5>Tenant Products</h5>
                        <a href="{{ route('admin.products.create', $tenant->id) }}" class="btn btn-danger">New Product</a>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Date Added</th>
                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @if (sizeof($products) > 0)
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>{{ $loop->index+1 }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->price }}</td>
                                            <td>{{ $product->quantity }}</td>
                                            <td>{{ date('m-d-Y', strtotime($product->created_at)) }}</td>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-center gap-1">
                                                <a class="btn btn-sm btn-primary" href="{{ route('admin.products.show', ['tenant' => $tenant->id, 'product' => $product->id]) }}">View</a>
                                                <a class="btn btn-sm btn-info" href="{{ route('admin.products.edit', ['tenant' => $tenant->id, 'product' => $product->id]) }}">Edit</a>
                                                <a class="btn btn-sm btn-danger" href="{{ route('admin.products.destroy', ['tenant' => $tenant->id, 'product' => $product->id]) }}" onclick="event.preventDefault(); document.getElementById('delete-product-{{$product->id}}').submit();">Delete</a>
                                                <form action="{{ route('admin.products.destroy', ['tenant' => $tenant->id, 'product' => $product->id]) }}" id="delete-product-{{ $product->id }}" method="post">
                                                    
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