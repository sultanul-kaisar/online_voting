@extends('admin.layouts.app')
@section('title', $voter->name)

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $voter->name }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">{{ $voter->name }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <div class="content" >
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-md-12 col-xl-12">
                            <div class="card sale-card" style="min-height:550px!important;">
                                <div class="card-header">
                                    <h5 class="card-title">Update {{ $voter->name }}</h5>
                                    <div class="card-header-right col-md-12 ml-2">
                                        <a type="button" href="{{ route('voter.index') }}" class="btn btn-primary  float-right ml-2"><i class="fas fa-arrow-left"></i> Back</a>
                                        <a href="#" class="btn btn-primary float-md-right" onclick="event.preventDefault();document.getElementById('submit-form').submit();"><i class="fas fa-save "></i> Save</a>
                                    </div>
                                </div>

                                <div class="page-body">
                                    <div class="card-block">
                                        <form method="POST" id="submit-form" action="{{ route('voter.update', $voter->id)}}">
                                            @csrf
                                            @method('PUT')

                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-3 ml-5">Full Name ( <span class="text-danger">*</span> )</label>
                                                <div class="col-lg-8">
                                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Full Name" value="{{ old('name', $voter->name) }}">
                                                    @error('name')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-3 ml-5">Email</label>
                                                <div class="col-lg-8">
                                                    <input type="text" disabled class="form-control" value="{{ $voter->email }}">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-3 ml-5">Active Status ( <span class="text-danger">*</span> )</label>
                                                <div class="col-lg-8">
                                                    <select name="status" id="status-select" class="form-control status-select">
                                                        <option value="">Select Active Status</option>
                                                        <option value="active" {{ (old('status', $voter->status) == 'active') ? 'selected=selected' : ''}}>Enable</option>
                                                        <option value="inactive" {{ (old('status', $voter->status) == 'inactive') ? 'selected=selected' : ''}}>Disabled</option>
                                                    </select>
                                                    @error('status')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
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
        </div>
    </div>

@endsection
