@extends('admin.index')

@section('content')
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12 order-1">
               
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mb-2" role="alert">
                        <strong>{{session('error')}}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h5>Update Tenant</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.tenants.update', $tenant->id) }}" method="post">
                        
                            @csrf
                            @method('put')

                            <input type="hidden" name="subscription_type" value="{{ $tenant->subscription->name }}" id="subscription_type">

                            <div class="d-flex gap-1">
        
                                <div class="register-devider w-50">
                                    <div class="mb-3">
                                        <label class="form-label" for="basic-icon-default-company">Company Name</label>
                                        <div class="input-group input-group-merge">
                                            <span id="basic-icon-default-company" class="input-group-text"><i class="bx bx-home"></i></span>
                                            <input type="text" name="company" value="{{ $tenant->company }}" class="form-control  @error('company') is-invalid @enderror" id="basic-icon-default-company" placeholder="Enter company name" aria-label="Enter company" aria-describedby="basic-icon-default-company">
                                            @error('company')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- <div class="mb-3">
                                        <label class="form-label" for="basic-icon-default-name">Name</label>
                                        <div class="input-group input-group-merge">
                                            <span id="basic-icon-default-name" class="input-group-text"><i class="bx bx-user"></i></span>
                                            <input type="text" name="name" value="{{ $tenant->name }}" class="form-control  @error('name') is-invalid @enderror" id="basic-icon-default-name" placeholder="Enter name" aria-label="Enter name" aria-describedby="basic-icon-default-name">
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="basic-icon-default-email">Email</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                            <input type="email" name="email" value="{{ $tenant->email }}" id="basic-icon-default-email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter email" aria-label="Enter email" aria-describedby="basic-icon-default-email">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div> --}}
                                    <div class="mb-3">
                                        <label class="form-label" for="basic-icon-default-subscription">Select subscription</label>
                                        <div class="input-group input-group-merge">
                                            
                                            <span class="input-group-text"><i class='bx bxs-purchase-tag'></i></span>

                                            <select name="subscription_id" id="subscription_id" class="form-select">
                                                @foreach ($subscriptions as $subscription)
                                                    <option 
                                                    
                                                    @if ($tenant->subscription->id == $subscription->id)
                                                        selected
                                                    @endif
                                                    
                                                    value="{{ $subscription->id }}" data-subscription="{{ $subscription }}">{{ $subscription->name }}</option>
                                                @endforeach
                                            </select>
                                            
                                            @error('subscription_id')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 @if($tenant->subscription->name == 'free') d-none @endif" id="payment-gateway-container">
                                        <label class="form-label" for="basic-icon-default-subscription">Payment gateway</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class='bx bx-mail-send'></i></span>
                                            
                                            <select name="payment_gateway_id" id="payment-gateway-toggler" class="form-select text-capitalize">
                                                <option value="">Select payment</option>
                                                @foreach ($gateways as $gateway)
                                                    <option 
                                                    
                                                    @if ($tenant->paymentGateway && $tenant->paymentGateway->id == $gateway->id)
                                                        selected
                                                    @endif
                                                    
                                                    value="{{ $gateway->id }}" data-gateways="{{ $gateways }}">{{ $gateway->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('payment_gateway_id')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
        
                                <div class="register-devider w-50">
                                   
                                    
                                    <div class="mb-3 @if($tenant->subscription->name == 'free') d-none @endif" id="payment-number-container">
                                        <label class="form-label" for="basic-icon-default-mobile">Mobile Number</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class='bx bxs-phone'></i></span>
                                            <input type="number" name="mobile" value="{{ $tenant->paymentGateway? $tenant->mobile : '' }}" id="mobile" class="form-control bg-white @error('mobile') is-invalid @enderror" placeholder="Enter mobile number" aria-label="" aria-describedby="basic-icon-default-mobile">
                                        </div>
                                        @error('mobile')
                                            <span class="invalid-feedback" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="basic-icon-default-max_products">Total Payments</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class='bx bx-dollar'></i></span>
                                            <input type="max_products" name="max_products" value="{{sizeof($subscriptions)>0? $subscriptions[0]->price : 0}}" id="subscription-price" class="form-control bg-white @error('max_products') is-invalid @enderror" placeholder="Auto loaded" aria-label="" aria-describedby="basic-icon-default-max_products" readonly>
                                        </div>
                                    </div>
                                        <div class="mb-3">
                                        <label class="form-label" for="basic-icon-default-max_products">Max Products</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class='bx bxl-product-hunt'></i></span>
                                            <input type="max_products" name="max_products" value="{{sizeof($subscriptions)>0? $subscriptions[0]->max_products : 0}}" id="subscription-max_products" class="form-control bg-white @error('max_products') is-invalid @enderror" placeholder="Auto loaded" aria-label="" aria-describedby="basic-icon-default-max_products" readonly>
                                        </div>
                                    </div>
                                    {{-- <div class="mb-3">
                                        <label class="form-label" for="basic-icon-default-password">Password</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class='bx bxs-lock-alt'></i></span>
                                            <input type="password" name="password" id="basic-icon-default-password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter password" aria-label="" aria-describedby="basic-icon-default-password">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="password_confirmation">Confirm Password</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class='bx bxs-lock-alt'></i></span>
                                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm password" aria-label="" aria-describedby="password_confirmation">
                                        </div>
                                    </div> --}}
                                </div>
                                
                            </div>

                            <a href="{{ route('admin.tenants.index') }}" class="btn btn-dark">Cancel</a>
                            <button type="submit" class="btn btn-danger">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->
    <div class="content-backdrop fade"></div>
</div>
@endsection