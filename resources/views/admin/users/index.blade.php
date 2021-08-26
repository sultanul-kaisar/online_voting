@extends('admin.layouts.app')
@section('title', "Users")

@section('content')
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Users</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">Users</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-md-12 col-xl-12">
                            <div class="card sale-card" style="min-height:550px!important;">
                                <div class="card-header">
                                    <h5 class="card-title">All Users List</h5>
                                    @if(auth()->user()->can('master') || auth()->user()->can('global') || auth()->user()->can('user create'))
                                        <div class="card-header-right col-md-12 ml-2">
                                            <a type="button" href="{{ route('user.create') }}" class="btn btn-primary  float-right ml-2"><i class="fas fa-plus"></i> New User</a>
                                        </div>
                                    @endif
                                </div>

                                <div class="page-body">
                                    <div class="card-block">
                                        <div class="table-responsive dt-responsive">
                                            <table id="example1" class="table table-bordered table-striped">
                                                <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>Status</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Role</th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                @foreach($users as $user)
                                                    <tr>
                                                        <td>
                                                            @if(auth()->user()->hasrole('developer'))
                                                                @if(Auth::user()->id == '1')
                                                                    @if (Auth::user()->id === $user->id)
                                                                        <span class="badge badge-danger">
                                                                                Self modification restricted
                                                                            </span>
                                                                    @else
                                                                        <div class="list-icons">
                                                                            <div class="dropdown">
                                                                                <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                                                    <i class="fas fa-bars"></i>
                                                                                </a>

                                                                                <div class="dropdown-menu dropdown-menu-right">

                                                                                    <a href="{{ route('user.edit', $user->id) }}" class="dropdown-item"><i class="fas fa-pencil"></i> Edit</a>

                                                                                    <a href="{{ route('admin.dashboard') }}" class="dropdown-item" onclick="event.preventDefault();document.getElementById('delete-form{{$user->id}}').submit();"><i class="ti-trash"></i> Delete</a>
                                                                                    <form id="delete-form{{$user->id}}" action="{{ route('user.destroy', $user->id) }}" method="POST" style="display: none;">
                                                                                        @csrf
                                                                                        @method('DELETE')
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                @else
                                                                    @if (Auth::user()->id === $user->id)
                                                                        <span class="badge badge-danger">
                                                                                    Self modification restricted
                                                                            </span>
                                                                    @elseif(($user->id == '1') || ($user->id == '2'))
                                                                        <span class="badge badge-danger">
                                                                                Modification restricted
                                                                            </span>
                                                                    @else
                                                                        <div class="list-icons">
                                                                            <div class="dropdown">
                                                                                <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                                                    <i class="ti-menu-alt"></i>
                                                                                </a>

                                                                                <div class="dropdown-menu dropdown-menu-right">

                                                                                    <a href="{{ route('user.edit', $user->id) }}" class="dropdown-item"><i class="ti-pencil-alt"></i> Edit</a>

                                                                                    <a href="{{ route('admin.dashboard') }}" class="dropdown-item" onclick="event.preventDefault();document.getElementById('delete-form{{$user->id}}').submit();"><i class="ti-trash"></i> Delete</a>
                                                                                    <form id="delete-form{{$user->id}}" action="{{ route('user.destroy', $user->id) }}" method="POST" style="display: none;">
                                                                                        @csrf
                                                                                        @method('DELETE')
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                @endif
                                                            @else
                                                                @if (Auth::user()->id === $user->id)
                                                                    <span class="badge badge-danger">
                                                                        Self modification restricted
                                                                    </span>
                                                                @elseif(($user->hasrole('developer')) || ($user->hasrole('super admin')))
                                                                    <span class="badge badge-danger">
                                                                        Modification restricted
                                                                    </span>
                                                                @else
                                                                    @if(auth()->user()->can('master') || auth()->user()->can('global') || auth()->user()->can('user edit') || auth()->user()->can('user delete'))
                                                                        <div class="list-icons">
                                                                            <div class="dropdown">
                                                                                <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                                                    <i class="ti-menu-alt"></i>
                                                                                </a>

                                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                                    @if(auth()->user()->can('master') || auth()->user()->can('global') || auth()->user()->can('user edit'))
                                                                                        <a href="{{ route('user.edit', $user->id) }}" class="dropdown-item"><i class="ti-pencil-alt"></i> Edit</a>
                                                                                    @endif

                                                                                    @if(auth()->user()->can('master') || auth()->user()->can('global') || auth()->user()->can('user delete'))
                                                                                        <a href="{{ route('admin.dashboard') }}" class="dropdown-item" onclick="event.preventDefault();document.getElementById('delete-form{{$user->id}}').submit();"><i class="ti-trash"></i> Delete</a>
                                                                                        <form id="delete-form{{$user->id}}" action="{{ route('user.destroy', $user->id) }}" method="POST" style="display: none;">
                                                                                            @csrf
                                                                                            @method('DELETE')
                                                                                        </form>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                        <span class="badge badge-danger">
                                                                            Modification restricted
                                                                        </span>
                                                                    @endif
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($user->status == 'active')
                                                                <span  class="badge badge-success">Enabled</span>
                                                            @elseif($user->status == 'inactive')
                                                                <span class="badge badge-warning">disabled</span>
                                                            @elseif($user->status == 'block')
                                                                <span class="badge badge-danger">Blocked</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ ucfirst($user->name) }}</td>
                                                        <td>{{ $user->email }}</td>
                                                        <td>
                                                            @if($user->roles->isEmpty())
                                                                <span class="badge badge-danger mb-2" style="font-size: 12px;">
                                                                    No role
                                                                </span>
                                                            @else
                                                                @foreach($user->roles as $role)
                                                                    <span class="badge badge-success mb-2" style="font-size: 12px;">
                                                                        {{ ucfirst($role->name) }}
                                                                    </span>
                                                                @endforeach
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection
