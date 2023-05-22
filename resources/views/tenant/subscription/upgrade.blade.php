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
                    <h5>Upgrade Subscriptions</h5>
                    <a href="{{ route('tenant.subscription') }}" class="btn btn-danger">Back</a>
                </div>
                <div class="card-body">

                    <form action="{{ route('tenant.subscription.upgrade', $tenant->id) }}" method="post">
                        
                        @csrf

                        <input type="hidden" name="subscription_type"  value="free" id="subscription_type">

                        <div class="register-devider w-50">
                            <div class="mb-3">
                                <label class="form-label" for="basic-icon-default-subscription">Select subscription</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class='bx bxs-purchase-tag' ></i></span>
                                    <select name="subscription_id" id="subscription_id" class="form-select @error('subscription_id') is-invalid @enderror">
                                        <option data-subscription="{&quot;id&quot;:2,&quot;name&quot;:&quot;3 Months&quot;,&quot;price&quot;:&quot;300.00&quot;,&quot;type&quot;:&quot;premium&quot;,&quot;duration_in_days&quot;:90,&quot;max_products&quot;:30,&quot;created_at&quot;:&quot;2023-05-22T04:21:24.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-05-22T04:21:24.000000Z&quot;}" value="2">3 Months</option>
                                        <option data-subscription="{&quot;id&quot;:3,&quot;name&quot;:&quot;6 Months&quot;,&quot;price&quot;:&quot;600.00&quot;,&quot;type&quot;:&quot;premium&quot;,&quot;duration_in_days&quot;:180,&quot;max_products&quot;:50,&quot;created_at&quot;:&quot;2023-05-22T04:21:24.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-05-22T04:21:24.000000Z&quot;}" value="3">6 Months</option>
                                        <option data-subscription="{&quot;id&quot;:4,&quot;name&quot;:&quot;9 Months&quot;,&quot;price&quot;:&quot;900.00&quot;,&quot;type&quot;:&quot;premium&quot;,&quot;duration_in_days&quot;:270,&quot;max_products&quot;:70,&quot;created_at&quot;:&quot;2023-05-22T04:21:24.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-05-22T04:21:24.000000Z&quot;}" value="4">9 Months</option>
                                        <option data-subscription="{&quot;id&quot;:5,&quot;name&quot;:&quot;Annual&quot;,&quot;price&quot;:&quot;1100.00&quot;,&quot;type&quot;:&quot;premium&quot;,&quot;duration_in_days&quot;:360,&quot;max_products&quot;:100,&quot;created_at&quot;:&quot;2023-05-22T04:21:24.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-05-22T04:21:24.000000Z&quot;}" value="5">Annual</option>
                                    </select>
                                    @error('subscription_id')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 d-none" id="payment-gateway-container">
                                <label class="form-label" for="basic-icon-default-subscription">Payment gateway</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class='bx bx-mail-send'></i></span>
                                    <select name="payment_gateway_id" id="payment-gateway-toggler" class="form-select text-capitalize @error('payment_gateway_id') is-invalid @enderror">
                                        <option value="">Select payment</option>
                                        <option data-gateways="[{&quot;id&quot;:1,&quot;name&quot;:&quot;gcash&quot;,&quot;created_at&quot;:&quot;2023-05-22T04:21:24.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-05-22T04:21:24.000000Z&quot;},{&quot;id&quot;:2,&quot;name&quot;:&quot;paymaya&quot;,&quot;created_at&quot;:&quot;2023-05-22T04:21:24.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-05-22T04:21:24.000000Z&quot;}]" value="1">gcash</option>
                                        <option data-gateways="[{&quot;id&quot;:1,&quot;name&quot;:&quot;gcash&quot;,&quot;created_at&quot;:&quot;2023-05-22T04:21:24.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-05-22T04:21:24.000000Z&quot;},{&quot;id&quot;:2,&quot;name&quot;:&quot;paymaya&quot;,&quot;created_at&quot;:&quot;2023-05-22T04:21:24.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-05-22T04:21:24.000000Z&quot;}]" value="2">paymaya</option>
                                    </select>
                                    @error('payment_gateway_id')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="mb-3 d-none" id="payment-number-container">
                                <label class="form-label" for="basic-icon-default-mobile">Mobile Number</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class='bx bxs-phone'></i></span>
                                    <input type="number" name="mobile" id="mobile" class="form-control bg-white @error('mobile') is-invalid @enderror" placeholder="Enter mobile number" aria-label="" aria-describedby="basic-icon-default-mobile">
                                </div>
                                @error('mobile')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
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