@extends('admin.layouts.app')
@section('title', "Add Voter")

@section('content')
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add Voter</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">Add Voter</li>
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
                                    <h5 class="card-title">Add Voter</h5>
                                    <div class="card-header-right col-md-12 ml-2">
                                        <a type="button" href="{{ route('voter.index') }}" class="btn btn-primary  float-right ml-2"><i class="fas fa-arrow-left"></i> Back</a>
                                        <a href="#" class="btn btn-primary float-md-right" onclick="event.preventDefault();document.getElementById('submit-form').submit();"><i class="fas fa-save "></i> Save</a>
                                    </div>
                                </div>

                                <div class="page-body">
                                    <div class="card-block">
                                        <form method="POST" id="submit-form" action="{{ route('voter.store')}}" enctype="multipart/form-data">
                                            @csrf

                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-3 ml-5">Full Name ( <span class="text-danger">*</span> )</label>
                                                <div class="col-lg-8">
                                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Full Name" value="{{ old('name') }}">
                                                    @error('name')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-3 ml-5">Email ( <span class="text-danger">*</span> )</label>
                                                <div class="col-lg-8">
                                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email address" value="{{ old('email') }}">
                                                    @error('email')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-3 ml-5">Password ( <span class="text-danger">*</span> )</label>
                                                <div class="col-lg-8">
                                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                                                    @error('password')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                    <span class="form-text text-justify text-muted" style="font-size:14px;">
                                                        <span class="text-warning">**password hint: </span>
                                                        <span>
                                                            password must be 8 characters long &
                                                            at least contains one numeric value,
                                                            one uppercase letter,
                                                            one lowercase letter,
                                                            one special character,

                                                        </span>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-3 ml-5">Confirm Password ( <span class="text-danger">*</span> )</label>
                                                <div class="col-lg-8">
                                                    <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Confirm Password">
                                                    @error('password_confirmation')
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
