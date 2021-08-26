@extends('admin.layouts.app')

@section('title', 'Account Settings')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Account Settings</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Account Settings</li>
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
                            <div class="card sale-card" style="min-height:250px!important;">
                                <div class="card-header">
                                    <h2 class="card-title">General Setting</h2>
                                    <div class="card-header-right col-md-12 ml-2">
                                        <a href="#" class="btn btn-primary float-md-right" onclick="event.preventDefault();document.getElementById('submit-general').submit();"><i class="fas fa-save "></i> Save</a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form method="POST" id="submit-general" action="{{ route('admin.my-account.general', auth()->user()->id)}}">
                                        @csrf
                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-2">Full Name</label>
                                            <div class="col-lg-10">
                                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Full Name" value="{{ old('name', auth()->user()->name) }}">
                                                @error('name')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-2">Email</label>
                                            <div class="col-lg-10">
                                                <input type="text" disabled class="form-control " value="{{ auth()->user()->email }}">
                                                @error('email')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                                <!-- Avatar -->
                            <div class="card sale-card" style="min-height:250px!important;">
                                <div class="card-header">
                                    <h2 class="card-title">Avatar Setting</h2>
                                    <div class="card-header-right col-md-12 ml-2">
                                        <a href="#" class="btn btn-primary float-md-right" onclick="event.preventDefault();document.getElementById('submit-avatar').submit();"><i class="fas fa-save "></i> Save</a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form method="POST" id="submit-avatar" action="{{ route('admin.my-account.avatar', auth()->user()->id)}}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Upload File</label>
                                            <div class="col-sm-10">
                                                <input type="file" name="avatar" class="form-control @error('avatar') is-invalid @enderror" placeholder="User avatar">
                                                @error('avatar')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Security -->

                            <div class="card sale-card" style="min-height:250px!important;">
                                <div class="card-header">
                                    <h2 class="card-title">Password Setting</h2>
                                    <div class="card-header-right col-md-12 ml-2">
                                        <a href="#" class="btn btn-primary float-md-right" onclick="event.preventDefault();document.getElementById('submit-security').submit();"><i class="fas fa-save "></i> Save</a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form method="POST" id="submit-security" action="{{ route('admin.my-account.security', auth()->user()->id)}}">
                                        @csrf
                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-2">Old Password ( <span class="text-danger">*</span> )</label>
                                            <div class="col-lg-10">
                                                <input type="password" name="old_password" class="form-control @error('old_password') is-invalid @enderror" placeholder="Old password">
                                                @error('old_password')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-2">New Password ( <span class="text-danger">*</span> )</label>
                                            <div class="col-lg-10">
                                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="New Password">
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
                                            <label class="col-form-label col-lg-2">Confirm New Password ( <span class="text-danger">*</span> )</label>
                                            <div class="col-lg-10">
                                                <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Confirm New Password">
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


@endsection
