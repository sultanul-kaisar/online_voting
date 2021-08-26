@extends('admin.layouts.app')
@section('title', "Role")

@section('content')
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Role</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">Role</li>
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
                                    <h5 class="card-title">All Role</h5>
                                    <div class="card-header-right col-md-12 ml-2">
                                        <a type="button" href="{{ route('role.create') }}" class="btn btn-primary  float-right ml-2"><i class="fas fa-plus"></i> New Role</a>
                                    </div>
                                </div>
                                <div class="page-body">
                                    <div class="card-block">
                                        <div class="table-responsive dt-responsive">
                                            <table id="multi-colum-dt" class="table table-striped table-bordered nowrap">
                                                <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>Name</th>
                                                    <th>Permissions</th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                @foreach($roles as $role)
                                                    <tr>
                                                        <td>
                                                            @if(auth()->user()->hasrole('developer'))
                                                                <div class="list-icons">
                                                                    <div class="dropdown">
                                                                        <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                                            <i class="fas fa-bars"></i>
                                                                        </a>

                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                            <a href="{{ route('role.edit', $role->id) }}" class="dropdown-item"><i class="ti-pencil-alt"></i> Edit</a>
                                                                            <a href="{{ route('admin.dashboard') }}" class="dropdown-item" onclick="event.preventDefault();document.getElementById('delete-form{{$role->id}}').submit();"><i class="ti-trash"></i> Delete</a>
                                                                            <form id="delete-form{{$role->id}}" action="{{ route('role.destroy', $role->id) }}" method="POST" style="display: none;">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                @if($role->name == 'super admin')
                                                                    <span class="badge badge-danger">
                                                                        Modification restricted
                                                                    </span>
                                                                @elseif($role->name == 'uncategorized')
                                                                    <span class="badge badge-danger">
                                                                        Modification restricted
                                                                    </span>
                                                                @else
                                                                    @if(auth()->user()->can('master') || auth()->user()->can('global') || auth()->user()->can('role edit') || auth()->user()->can('role delete'))
                                                                        <div class="list-icons">
                                                                            <div class="dropdown">
                                                                                <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                                                    <i class="fas fa-bars"></i>
                                                                                </a>

                                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                                    @if(auth()->user()->can('master') || auth()->user()->can('global') || auth()->user()->can('role edit'))
                                                                                        <a href="{{ route('role.edit', $role->id) }}" class="dropdown-item"><i class="fas fa-pencil"></i> Edit</a>
                                                                                    @endif

                                                                                    @if(auth()->user()->can('master') || auth()->user()->can('global') || auth()->user()->can('role delete'))
                                                                                        <a href="{{ route('admin.dashboard') }}" class="dropdown-item" onclick="event.preventDefault();document.getElementById('delete-form{{$role->id}}').submit();"><i class="ti-trash"></i> Delete</a>
                                                                                        <form id="delete-form{{$role->id}}" action="{{ route('role.destroy', $role->id) }}" method="POST" style="display: none;">
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
                                                        <td>{{ ucfirst($role->name) }}</td>
                                                        <td>
                                                            @if($role->permissions->isEmpty())
                                                                <span class="badge badge-danger mb-2" style="font-size: 12px;">
                                                                    No permissions
                                                                </span>
                                                            @else
                                                                @foreach($role->permissions as $permission)
                                                                    <span class="badge badge-success mb-2" style="font-size: 12px;">
                                                                        {{ str_replace(['-', '_'], ' ', $permission->name) }}
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
