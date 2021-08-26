@extends('admin.layouts.app')
@section('title', "Permission")

@section('content')
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Permission</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">Permission</li>
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
                                    <h5 class="card-title">All Permission</h5>
                                    <div class="card-header-right col-md-12 ml-2">
                                        <a type="button" href="{{ route('permission.create') }}" class="btn btn-primary  float-right ml-2"><i class="fas fa-plus"></i> New Permission</a>
                                    </div>
                                </div>
                                <div class="row p-2">
                                    @if($pages->isEmpty())
                                        <div class="col-8 offset-2">
                                            <div class="text-center">
                                                <div class="alert alert-danger border-0 alert-dismissible">
                                                    <span class="font-weight-semibold">Oh snap!</span> No permission found. Please  <a href="{{ route('permission.create') }}" class="alert-link">try creating</a> new permission.
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @foreach($pages as $page)
                                        <div class="col-lg-4">
                                            <div class="card card-body custom-border-top" style="min-height:266px!important;">
                                                <div class="text-center">
                                                    <h4 class="mb-0 font-weight-bold">{{ ucwords($page->title) }}</h4>
                                                </div>
                                                <div class="card card-body bg-light mb-0">
                                                    @if($page->title == 'global')
                                                        <ul class="list list-unstyled mb-0">
                                                            <li><i class="fas fa-check-square"></i> {{ $page->title }}</li>
                                                        </ul>
                                                    @elseif($page->title == 'setting')
                                                        <ul class="list list-unstyled mb-0">
                                                            <li><i class="fas fa-check-square"></i> {{ $page->title }} view</li>
                                                            <li><i class="fas fa-check-square"></i> {{ $page->title }} edit</li>
                                                        </ul>
                                                    @else
                                                        <ul class="list list-unstyled mb-0">
                                                            <li><i class="fas fa-check-square"></i> {{ $page->title }} view</li>
                                                            <li><i class="fas fa-check-square"></i> {{ $page->title }} create</li>
                                                            <li><i class="fas fa-check-square"></i> {{ $page->title }} edit</li>
                                                            <li><i class="fas fa-check-square"></i> {{ $page->title }} delete</li>
                                                        </ul>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
