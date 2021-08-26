@extends('admin.layouts.app')
@section('title', "Vote Purposes")

@section('content')
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Vote Purpose Category</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">Vote Purposes</li>
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
                                    <h5 class="card-title">All Vote Purpose Categories</h5>
                                    @if(auth()->user()->can('master') || auth()->user()->can('global') || auth()->user()->can('vote category create'))
                                        <div class="card-header-right col-md-12 ml-2">
                                            <a type="button" href="{{ route('vote-category.create') }}" class="btn btn-primary  float-right ml-2"><i class="fas fa-plus"></i> New Vote Purpose Category</a>
                                        </div>
                                    @endif
                                </div>

                                <div class="page-body">
                                    <div class="card-block">
                                        <div class="table-responsive dt-responsive">
                                            <table id="example1" class="table table-bordered table-striped">
                                                <thead>
                                                <tr>@if(auth()->user()->can('master') || auth()->user()->can('global') || auth()->user()->can('vote category view') || auth()->user()->can('vote category edit') || auth()->user()->can('vote category delete'))
                                                    <th>Action</th>
                                                    @endif
                                                    <th>Title</th>
                                                    <th>Slug</th>
                                                    <th>Parent Title</th>
                                                    <th>Status</th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                @foreach($voteCategories as $voteCategory)
                                                    <tr>
                                                        @if(auth()->user()->can('master') || auth()->user()->can('global') || auth()->user()->can('vote category edit') || auth()->user()->can('vote category delete'))
                                                            <td class="">
                                                                <div class="list-icons">
                                                                    <div class="dropdown">
                                                                        <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                                            <i class="fas fa-bars"></i>
                                                                        </a>
                                                                        <div class="dropdown-menu dropdown-menu-right custom-dropdown-menu-right">
                                                                            @if(auth()->user()->can('master') || auth()->user()->can('global') || auth()->user()->can('vote category edit'))
                                                                                <a href="{{ route('vote-category.edit', $voteCategory->id) }}" class="dropdown-item"><i class="fas fa-pencil-alt"></i> View / Edit</a>
                                                                            @endif
                                                                            @if(auth()->user()->can('master') || auth()->user()->can('global') || auth()->user()->can('vote category delete'))
                                                                                <a href="{{ route('admin.dashboard') }}" class="dropdown-item" onclick="event.preventDefault();document.getElementById('delete-form{{$voteCategory->id}}').submit();"><i class="fas fa-trash"></i> Delete</a>
                                                                                <form id="delete-form{{$voteCategory->id}}" action="{{ route('vote-category.destroy', $voteCategory->id) }}" method="POST" style="display: none;">
                                                                                    @csrf
                                                                                    @method('DELETE')
                                                                                </form>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        @endif
                                                        <td>{{  $voteCategory->title }}</td>
                                                        <td>{{  $voteCategory->slug }}</td>
                                                        <td>
                                                            @if(!is_null($voteCategory->parent))
                                                                {{ $voteCategory->parent->title }}
                                                            @else
                                                                --
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($voteCategory->status == "active")
                                                                <span class="badge badge-success">Enabled</span>
                                                            @endif

                                                            @if($voteCategory->status == "inactive")
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
