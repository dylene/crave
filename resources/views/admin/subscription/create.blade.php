@extends('admin.index')

@section('content')
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12 order-1">
                <div class="card">
                    <div class="card-header">
                        <h5>New Subscription</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.subscriptions.store') }}" method="post">
                        
                            @csrf
    
                            <div class="mb-3">
                                <label class="form-label" for="basic-icon-default-name">Subscription Name</label>
                                <div class="input-group input-group-merge">
                                    <input type="text" name="name" class="form-control  @error('name') is-invalid @enderror" id="basic-icon-default-name" placeholder="Enter name" aria-label="Enter name" aria-describedby="basic-icon-default-name">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-text"> Example: 3 months </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-icon-default-price">Price</label>
                                <div class="input-group input-group-merge">
                                    <input type="number" step="any" name="price" id="basic-icon-default-price" class="form-control @error('price') is-invalid @enderror" placeholder="Enter price" aria-label="Enter price" aria-describedby="basic-icon-default-price">
                                    @error('price')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-icon-default-duration_in_days">Duration In Days</label>
                                <div class="input-group input-group-merge">
                                    <input type="number" name="duration_in_days" id="basic-icon-default-duration_in_days" class="form-control @error('duration_in_days') is-invalid @enderror" placeholder="Enter duration in days name" aria-label="Enter duration_in_days name" aria-describedby="basic-icon-default-duration_in_days-name">
                                    @error('duration_in_days')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-icon-default-max_products">Max products</label>
                                <div class="input-group input-group-merge">
                                    <input type="number" step="any" name="max_products" id="basic-icon-default-max_products" class="form-control @error('max_products') is-invalid @enderror" placeholder="Enter allowable number of products" aria-label="Enter max_products" aria-describedby="basic-icon-default-max_products">
                                    @error('max_products')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-text"> Please specify how many products the tenant can upload. </div>
                            </div>

                            <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-dark">Cancel</a>
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