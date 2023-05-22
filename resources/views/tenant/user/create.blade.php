@extends('tenant.index')

@section('content')
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12 order-1">
                <div class="breadscrumbs">
                    <h4 class="text-capitalize">{{ $tenant->name }} / Users / Create</h4>
                </div>

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mb-2" role="alert">
                        <strong>{{session('error')}}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h5>New User</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('tenant.users.store') }}" method="post">
                        
                            @csrf
                            
                            <div class="mb-3">
                                <label class="form-label" for="basic-icon-default-name">Name</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-name" class="input-group-text"><i class="bx bx-user"></i></span>
                                    <input type="text" name="name" class="form-control  @error('name') is-invalid @enderror" id="basic-icon-default-name" placeholder="Enter name" aria-label="Enter name" aria-describedby="basic-icon-default-name">
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
                                    <input type="email" name="email" id="basic-icon-default-email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter email" aria-label="Enter email" aria-describedby="basic-icon-default-email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="basic-icon-default-password">Password</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-password" class="input-group-text"><i class="bx bx-lock-alt"></i></span>
                                    <input type="password" name="password" class="form-control  @error('password') is-invalid @enderror" id="basic-icon-default-password" placeholder="Enter password" aria-label="Enter password" aria-describedby="basic-icon-default-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="basic-icon-default-password_confirmation">Confirm Password</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-password_confirmation" class="input-group-text"><i class="bx bx-lock-alt"></i></span>
                                    <input type="password" name="password_confirmation" class="form-control  @error('password_confirmation') is-invalid @enderror" id="basic-icon-default-password_confirmation" placeholder="Confirm password" aria-label="Enter password_confirmation" aria-describedby="basic-icon-default-password_confirmation">
                                </div>
                            </div>

                            <a href="{{ route('tenant.users.index') }}" class="btn btn-dark">Cancel</a>
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