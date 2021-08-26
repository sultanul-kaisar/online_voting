@extends('admin.layouts.app')
@section('title', "Voters")

@section('content')
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Voters</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">Voters</li>
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
                                    <h5 class="card-title">All Voters List</h5>
                                    <div class="card-header-right col-md-12 ml-2">
                                        <a type="button" href="{{ route('voter.create') }}" class="btn btn-primary  float-right ml-2"><i class="fas fa-plus"></i> New Voter</a>
                                    </div>
                                </div>

                                <div class="page-body">
                                    <div class="card-block">
                                        <div class="table-responsive dt-responsive">
                                            <table id="example1" class="table table-bordered table-striped">
                                                <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Status</th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                @foreach($voters as $voter)
                                                    <tr>
                                                        <td>
                                                            <div class="list-icons">
                                                                <div class="dropdown">
                                                                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                                        <i class="fas fa-bars"></i>
                                                                    </a>

                                                                    <div class="dropdown-menu dropdown-menu-right">

                                                                        <a href="{{ route('voter.edit', $voter->id) }}" class="dropdown-item"><i class="fas fa-pencil-alt"></i> Edit</a>

                                                                        <a href="{{ route('admin.dashboard') }}" class="dropdown-item" onclick="event.preventDefault();document.getElementById('delete-form{{$voter->id}}').submit();"><i class="fas fa-trash"></i> Delete</a>
                                                                        <form id="delete-form{{$voter->id}}" action="{{ route('voter.destroy', $voter->id) }}" method="POST" style="display: none;">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>{{  $voter->name }}</td>
                                                        <td>{{  $voter->email }}</td>
                                                        <td>
                                                            @if($voter->status == "active")
                                                                <span class="badge badge-success">Enabled</span>
                                                            @endif

                                                            @if($voter->status == "inactive")
                                                                <span class="badge badge-danger">Disabled</span>
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
