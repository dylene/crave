@extends('admin.index')

@section('content')
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12 order-1">
                <div class="breadscrumbs">
                    <h4 class="text-capitalize"> / Products / Create</h4>
                </div>

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mb-2" role="alert">
                        <strong>{{session('error')}}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h5>Update Product</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('tenant.products.update', $product->id) }}" enctype="multipart/form-data" method="post">
                        
                            @csrf
                            @method('put')

                            <div class="mb-3">
                                <label class="form-label" for="basic-icon-default-name">Name</label>
                                <div class="input-group input-group-merge">
                                    <input type="text" name="name" value="{{ $product->name }}" class="form-control  @error('name') is-invalid @enderror" id="basic-icon-default-name" placeholder="Enter name" aria-label="Enter name" aria-describedby="basic-icon-default-name">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="basic-icon-default-price">Price</label>
                                <div class="input-group input-group-merge">
                                    <input type="number" name="price" value="{{ $product->price }}" step="any" id="basic-icon-default-price" class="form-control @error('price') is-invalid @enderror" placeholder="Enter price" aria-label="Enter price" aria-describedby="basic-icon-default-price">
                                    @error('price')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="basic-icon-default-quantity">Quantity</label>
                                <div class="input-group input-group-merge">
                                    <input type="number" name="quantity" value="{{ $product->quantity }}" class="form-control  @error('quantity') is-invalid @enderror" id="basic-icon-default-quantity" placeholder="Enter quantity" aria-label="Enter quantity" aria-describedby="basic-icon-default-quantity">
                                    @error('quantity')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- <div class="mb-3">
                                <label class="form-label" for="basic-icon-default-file">file</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-file" class="input-group-text"><i class="bx bx-lock-alt"></i></span>
                                    <input type="file" name="file" class="form-control  @error('file') is-invalid @enderror" id="basic-icon-default-file" placeholder="Enter file" aria-label="Enter file" aria-describedby="basic-icon-default-file">
                                    @error('file')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-text">You can upload product image with the following extension: png, jpg, jpeg</div>
                            </div> --}}

                            <a href="{{ route('tenant.products.index') }}" class="btn btn-dark">Cancel</a>
                            <button type="submit" class="btn btn-danger">Update</button>
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