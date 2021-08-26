@extends('admin.layouts.app')
@section('title', "Create Permission")

@section('content')
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Create Permission</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">Create Permission</li>
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
                                    <h5 class="card-title">Create Permission</h5>
                                    <div class="card-header-right col-md-12 ml-2">
                                        <a type="button" href="{{ route('permission.index') }}" class="btn btn-primary  float-right ml-2"><i class="fas fa-arrow-left"></i> Back</a>
                                        <a href="#" class="btn btn-primary float-md-right" onclick="event.preventDefault();document.getElementById('submit-form').submit();"><i class="fas fa-save "></i> Save</a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form method="POST" id="submit-form" action="{{ route('permission.store')}}">
                                        @csrf
                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-2">Title ( <span class="text-danger">*</span> )</label>
                                            <div class="col-lg-10">
                                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}">
                                                @error('title')
                                                <div class="text-danger mb-3">{{ $message }}</div>
                                                @enderror
                                                <span class="form-text text-justify text-muted" style="font-size:14px;">
                                                <span class="text-warning">**Hint: </span>
                                                only specify crud name.
                                                It will automatically generate all related permissions for the crud.
                                                e.g. If you want a crud for categories, just put "category" as CRUD name.
                                                It will generate follwing permissions for category: category view, category create, category edit, category delete
                                            </span>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
