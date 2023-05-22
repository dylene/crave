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
                    <h5>Tenant Users</h5>
                    <a href="{{ route('tenant.users.create') }}" class="btn btn-danger">New User</a>
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
                                            <a class="btn btn-sm btn-primary" href="{{ route('tenant.users.show', ['user' => $user->id]) }}">View</a>
                                            <a class="btn btn-sm btn-info" href="{{ route('tenant.users.edit', ['user' => $user->id]) }}">Edit</a>
                                            <a class="btn btn-sm btn-danger" href="{{ route('tenant.users.destroy', ['user' => $user->id]) }}" onclick="event.preventDefault(); document.getElementById('delete-user-{{$user->id}}').submit();">Delete</a>
                                            <form action="{{ route('tenant.users.destroy', ['user' => $user->id]) }}" id="delete-user-{{ $user->id }}" method="post">
                                                
                                                @csrf
                                                @method('delete')
                                                
                                            </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" class="text-center">No data available!</td>
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